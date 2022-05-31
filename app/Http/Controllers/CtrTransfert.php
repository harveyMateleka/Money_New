<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ctradmin;
use App\Http\Controllers\Ctrpersonnel;
use Illuminate\Support\Facades\Auth;
use Nexmo\Laravel\Facade\Nexmo;
use App\Models\tbl_affectation;
use App\Models\tbl_vile;
use App\Models\tbl_partenaire;
use App\Models\tbl_devise;
use App\Models\tbl_client;
use App\Models\tbl_depot;
use App\Models\tbl_agence;
use App\Models\tbl_personnel;
use App\Models\tbl_pourcentage;
use App\Models\tbl_banque;
use App\Models\tbl_transfert_banque;
use App\Models\tbl_mvtbanques;
use App\Models\tbl_cloture;
use DateTime;
use PDF;
use App;
use DB;
use Illuminate\Support\Carbon;


class CtrTransfert extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $date;
    private $agence;
    private $agence1;
    private $transfert;
    private $ong;
    private $banque;
    private $code_ville;
    private $numagence;
    private $devise;
    private $data;

    public function __construct(){
        $this->date= new DateTime();
        $this->agence=tbl_agence::all();
        $this->banque=tbl_banque::all();
        $this->agence=tbl_agence::where('indiceag','<>',1)->get();
      
    }
   public function print($id)
    {
        $result=DB::table('tbl_depots')->join('tbl_agences','tbl_depots.numagence','=','tbl_agences.numagence')
                                       ->join('tbl_viles','tbl_depots.id_ville','=','tbl_viles.id_ville')
                                       ->join('tbl_clients','tbl_depots.id_client','=','tbl_clients.id_client')
                                        ->join('tbl_devises','tbl_depots.id_devise','=','tbl_devises.id')  
                                        ->where('tbl_depots.id','=',$id) 
                                        ->select('tbl_depots.id','numdepot','nomben','montenvoi','montpour','created_at','ville','intitule','nomclient','nomagence','tel','telclient','raison')
                                        ->first();
        if ($result) {
             $data = [
                 'entete' => "Bon d'envoie",
                   'date' => $result->created_at,
                   'agence'  => $result->nomagence,
                   'ville'  => $result->ville,
                   'trans'  => $result->numdepot,
                   'expiditeur'  => $result->nomclient,
                   'telexp'  => $result->tel,
                   'beneficiere'  => $result->nomben,
                   'tel1'  => $result->telclient,
                   'montant'  => $result->montenvoi,
                   'montantcom'  => $result->montpour,
                   'devise'  => $result->intitule,
                   'indice'  => '1', 
                   'raison' => $result->raison       
                     ];
            
                    $pdf = PDF::loadView('generate_pdf',$data);
                    return $pdf->download('codingdriver.pdf');
        }
    }
   public function generatecode(Request $request){
          
          if ($request->ajax()) {
              $resultat=$request->initial_ag;
              $resultat.=$this->recupe_code();
              $resultat.='-'.$request->initial_vil;
              return response()->json(['success'=>$resultat]);
          }
      } 

      function recupe_code($length = 9) {
        $characters ='A'.mt_rand(1000000000, 9999999999); 
        $charactersLength = strlen($characters);
        $randomString = '-';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
      }


public function index_entree()
    {
        if (Auth::check()) {
            $this->entete();
            $tab_ville=tbl_vile::orderBy('ville','asc')->get();
            $don=$this->recu_agence();
            $tab_devise=tbl_devise::orderBy('id','DESC')->get();
            return view('view_entree',compact('don','tab_ville','tab_devise'));
        }
        else{
            return redirect()->route('login');
          }
    }

    public function index_pourcentage()
    {
        if (Auth::check()) {  
            $this->entete();
            $date= date('Y-m-d');
           $resultat=DB::table('tbl_clotures','tbl_cloture')
                                       ->join('tbl_agences','tbl_cloture.numagence','=','tbl_agences.numagence')
                                       ->where('tbl_cloture.datecloture',$date)
                                       ->orderBy('tbl_cloture.id_cloture','DESC')
                                       ->select('tbl_cloture.id_cloture','nomagence','pourcentagecdf','pourcentageusd','depensecdf','depenseusd','datecloture')->get();
            return view('view_pourcentage',compact('resultat'));
        }
    }




    public function entete(){
        $affichage= new ctradmin;
        return $affichage->index_entete();
    }
    public function historique($matricule,$operation){
        $resultat=new Ctrpersonnel;
        return $resultat->historisation($matricule,$operation);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


  public function update_pourcentage(Request $request)
    {
    
      if ($request->ajax()) {
            $montantdolars=0.0;
            $montantcdf=0.0;
            $numagence=0;
            $resultat=tbl_pourcentage::where('created_at','=',$this->date->format('Y-m-d'))->first();
           // dd($resultat);
            if (!$resultat) {
                $create=tbl_pourcentage::create([
                    'pourceusd'=>$request->totalusd,
                    'pourcecdf'=>$request->totalcdf,
                    'created_at'=>$this->date->format('Y-m-d')]);
                $requette=DB::table('tbl_affectations','tbl_affect')->join('tbl_agences','tbl_affect.numagence','=','tbl_agences.numagence')
                    ->where('tbl_affect.matricule','=',Auth::user()->matricule)
                    ->where('statut','=','1')
                    ->select('tbl_affect.numagence','tbl_agences.nomagence','Montusd','Montcdf')->first();
                        if ($requette) {
                            $montantdolars=$requette->Montusd;
                            $montantcdf=$requette->Montcdf;
                            $numagence=$requette->numagence;
                        }

                        if($request->totalcdf <= 0 && $request->totalusd <= 0 ){
                            return response()->json(['success'=>'2']);
                         }
                         elseif ($request->totalcdf > 0 && $request->totalusd > 0) {
                            $montantdolars-=$request->totalusd;
                            $montantcdf-=$request->totalcdf;
                         }
                         elseif ($request->totalcdf < 0 && $request->totalusd > 0) {
                            $montantdolars-=$request->totalusd;
                         }
                         elseif ($request->totalcdf > 0 && $request->totalusd < 0) {
                            $montantcdf-=$request->totalcdf;
                         }
                         else {
                            $montantdolars+=0;
                            $montantcdf+=0;
                         }
                         $update=tbl_agence::whereNumagence($numagence)->update(['Montcdf'=>$montantcdf,'Montusd'=>$montantdolars]);
                         return response()->json(['success'=>'1']);       

            } else {
                return response()->json(['success'=>'3']);  
            }
        }
   }
          
    public function store_entree(Request $request)
    {
        if ($request->ajax()) {
            $a=1;
            $response=0;
            $name_agence='';
            $operation='';
            $Montantusd=0.0;
            $Montantcdf=0.0;
            $requette2=$this->get_montAg($request->agence);
            $Montantusd=$requette2['montantD'];
            $Montantcdf=$requette2['montantC'];
            $name_agence=$requette2['nameagence'];
          
            while ($a <= 2) {
                $requette=tbl_client::whereTel($request->expeditel)->first();
                if ($requette) {
                       $insert=tbl_depot::create(['numdepot'=>$request->transact,
                                                  'telclient'=>$request->tel_ben,
                                                  'nomben'=>strtoupper($request->benefic),
                                                  'montenvoi'=>$request->montenv,
                                                  'montpour'=>$request->montcom,
                                                  'etatservi'=>'0',
                                                  'id_ville'=>$request->ville,
                                                  'id_devise'=>$request->devise,
                                                  'numagence'=>$request->agence,
                                                  'created_at'=>$this->date->format('Y-m-d'),
                                                  'matricule'=>Auth::user()->matricule,
                                                  'id_client'=>$requette->id_client,
                                                  'raison'=> $request->raison
                                                 ]);
                                        
                                        if($request->devise==1){
                                           $Montantusd+= $request->montenv + $request->montcom;
                                           $operation="Entrée du ".$request->transact." au montant de ".$request->montenv." Usd dans l'agence ".$name_agence;
                                        }
                                        else{
                                           $Montantcdf+= $request->montenv + $request->montcom; 
                                           $operation="Entrée du ".$request->transact." au montant de ".$request->montenv." Cdf dans l'agence ".$name_agence;
                                        }
                                        $requet=tbl_agence::whereNumagence($request->agence)->update(['Montusd'=>$Montantusd,'Montcdf'=>$Montantcdf]);
                                        $this->historique(Auth::user()->matricule,$operation);
                                        $response=1;   
                                    break;   
                }
                else{
                    $requette1=tbl_client::create(['nomclient'=>strtoupper($request->expediteur),'tel'=>$request->expeditel]);
                       $a++;
                       
                              //Nexmo::message()->send([
                              //'to' =>$request->expeditel,
                              //'from'=> '+243972887050',
                              //'text'=>$request->transact 
                               //]); 
                       
                             //echo "Message sent";
                       
                       
                    }
            }
            
                        if ($response==1) {
                            $transact=$this->generateRandomString();
                            return response()->json(['success'=>'1','data'=>$transact]);
                        }
                        else{
                            return response()->json(['success'=>'0']); 
                        }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_listentree($id)
    {
        $requette=tbl_agence::where('numagence','=',$id)->first();
        if ($requette) {
            $req=DB::table('tbl_depots')->join('tbl_agences','tbl_depots.numagence','=','tbl_agences.numagence')
                                        ->join('tbl_clients','tbl_depots.id_client','=','tbl_clients.id_client')
                                        ->join('tbl_viles','tbl_depots.id_ville','=','tbl_viles.id_ville')
                                        ->join('tbl_devises','tbl_depots.id_devise','=','tbl_devises.id')  
                                        ->where('tbl_depots.numagence','=',$id) 
                                        ->select('tbl_depots.id','numdepot','nomben','montenvoi','montpour','created_at','ville','intitule','nomclient','nomagence')
                                        ->get();
            return response()->json(['data'=>$req]);      
            }

    }

  

     
  function generateRandomString4($length = 4) {
        $characters ='A'.mt_rand(1000000000, 9999999999); 
        $charactersLength = strlen($characters);
        $randomString = 'KITA';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString.='LU';
        return $randomString;
      }

      public function get_montAg($request){

        $requette=tbl_agence::whereNumagence($request)->first();
        if ($requette){
            $data=[
                'montantD'=>$requette->Montusd,
                'montantC'=>$requette->Montcdf,
                'nameagence'=>$requette->nomagence,
            ];
           return $data;
          }
          else {
              return false;
          }
      }

    public function generatePDF($id,$a,$v,$t,$e,$te,$b,$tb,$m,$mc,$dev,$raison)
    {
        if ($id=='1') {
             $data = [
                 'entete' => "Bon d'envoie",
                   'date' => $this->date->format('d-m-Y'),
                   'agence'  => $a,
                   'ville'  => $v,
                   'trans'  => $t,
                   'expiditeur'  => $e,
                   'telexp'  => $te,
                   'beneficiere'  => $b,
                   'tel1'  => $tb,
                   'montant'  => $m,
                   'montantcom'  => $mc,
                   'devise'  => $dev,
                   'indice'  => $id,
                   'raison' => $raison        
                     ];
            
                    $pdf = PDF::loadView('generate_pdf',$data);
                    return $pdf->download('codingdriver.pdf');
        }
        else{
            $requette=DB::table('tbl_affectations','tbl_affect')->join('tbl_agences','tbl_affect.numagence','=','tbl_agences.numagence')
                                                                ->join('tbl_viles','tbl_viles.id_ville','=','tbl_agences.id_ville')
                                                                ->where('matricule','=',Auth::user()->matricule)
                                                                ->where('statut','=','1')
                                                                ->select('ville','nomagence')
                                                                ->first();
                    if ($requette) {
                        $data = [
                             'entete' => "Bon de Sortie",
                              'date' => $this->date->format('d-m-Y'),
                              'agence'  => $a,
                              'ville'  => $v,
                              'villedes'  => $requette->ville,
                              'agencedest'  => $requette->nomagence,
                              'trans'  => $t,
                              'expiditeur'  => $e,
                              'beneficiere'  => $b,
                              'montant'  => $m,
                              'montantcom'  => $mc,
                              'devise'  => $dev,
                              'indice'  => $id,
                              'raison' => $raison          
                                ];
                                $pdf = PDF::loadView('generate_pdf',$data);
                                return $pdf->download('codingdriver.pdf');
                    }

           

        }
    }

    // public function genera_ong($id,$o,$m,$dev,$mm,$f,$e,$na)
    // {
    //     $resultat=tbl_ong::whereId($o)->select('name_ong','adresse_siege','tel_contact')->first();
    //   $retVal = ($id=='1') ? DB::table('tbl_detail_ts')->join('tbl_agences','tbl_detail_ts.numagence','=','tbl_agences.numagence')
    //                         ->select('montp','nomagence')
    //                         ->where('tbl_detail_ts.id_transf','=',$na)
    //                         ->get() : '' ;
    //     $data = [
    //         'entete' => "Bon de Transfert",
    //          'date' => $this->date->format('Y-m-d'),
    //          'ong'  => $resultat,
    //          'detail'  => $retVal,
    //          'montant'  => $m,
    //          'expiditeur'  => $e,
    //          'pourcmont'  => $mm,
    //          'frais'  => $f,
    //          'devise'  => $dev,
    //          'indice'  => $id,         
    //            ];
      
    //           $pdf = PDF::loadView('generate_ong',$data);
    //           return $pdf->download('bon_transfert.pdf');
    // }

    

    




    
    
      public function index_retrait()
    {
        if (Auth::check()) {  
            $this->entete();
            $resultat=DB::table('tbl_depots','tbl_depot')->join('tbl_agences','tbl_depot.numagence','=','tbl_agences.numagence')
                                                         ->join('tbl_clients','tbl_depot.id_client','=','tbl_clients.id_client')
                                                         ->join('tbl_viles','tbl_depot.id_ville','=','tbl_viles.id_ville')
                                                         ->join('tbl_devises','tbl_depot.id_devise','=','tbl_devises.id')
                                        ->where('tbl_depot.etatservi','=','0')
                                        ->orderBy('tbl_depot.id','DESC')
                                        ->select('tbl_depot.id','numdepot','nomben','montenvoi','montpour','created_at','nomagence','nomclient','ville','intitule')
                                        ->get();
                                        
            return view('view_retraitcode',compact('resultat'));
        }
    }

  public function update_retrait(Request $request)
    {
    
      if ($request->ajax()) {
            $montantdolars=0.0;
            $montantcdf=0.0;
              $data=tbl_depot::where('id','=',$request->code)->first();
              if($data){
                  $data->etatservi=1;
                  $data->updated_at;
                  $data->save();

            $requette=DB::table('tbl_affectations','tbl_affect')->join('tbl_agences','tbl_affect.numagence','=','tbl_agences.numagence')
            ->where('tbl_affect.matricule','=',Auth::user()->matricule)
            ->where('statut','=','1')
            ->select('tbl_affect.numagence','tbl_agences.nomagence','Montusd','Montcdf')->first();

                                if ($requette) {

                                   $montantdolars=$requette->Montusd - $data->montenvoi;
                                    $montantcdf=$requette->Montcdf - $data->montenvoi;  
                              
                                if ($data->id_devise == 1) {
                                    $update=tbl_agence::whereNumagence($data->numagence)->update(['Montusd'=>$montantdolars]); 
                                    return response()->json(['success'=>'1']);    
                                  }
                                else{
                                    $update=tbl_agence::whereNumagence($data->numagence)->update(['Montcdf'=>$montantcdf]); 

                                    return response()->json(['success'=>'1']);    
                                    }   
      
                                 }

                            }

                         
       
                      }

                 }
    public function update_restitution(Request $request)
    {
    
      if ($request->ajax()) {
            $montantdolars=0.0;
            $montantcdf=0.0;
              $data=tbl_depot::where('id','=',$request->code)->first();
              if($data){
                  $data->etatservi=0;
                  $data->retrait_credit=0;
                  $data->updated_at;
                  $data->save();

            $requette=DB::table('tbl_affectations','tbl_affect')->join('tbl_agences','tbl_affect.numagence','=','tbl_agences.numagence')
            ->where('tbl_affect.matricule','=',Auth::user()->matricule)
            ->where('statut','=','1')
            ->select('tbl_affect.numagence','tbl_agences.nomagence','Montusd','Montcdf')->first();

                                if ($requette) {

                                   $montantdolars=$requette->Montusd +  $data->montenvoi;
                                    $montantcdf=$requette->Montcdf +  $data->montenvoi;  
                              
                                if ($data->id_devise == 1) {
                                    $update=tbl_agence::whereNumagence($data->numagence)->update(['Montusd'=>$montantdolars]); 
                                    return response()->json(['success'=>'1']);    
                                  }
                                else{
                                    $update=tbl_agence::whereNumagence($data->numagence)->update(['Montcdf'=>$montantcdf]); 

                                    return response()->json(['success'=>'1']);    
                                    }   
      
                            }

                        }
       
                      }

                 }


   

   

    function generateRandomString($length = 4) {
        $characters ='A'.mt_rand(1000000000, 9999999999); 
        $charactersLength = strlen($characters);
        $randomString = 'ABT-';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //________________________________________________code de rabby_____________________________________________________
   

//public function get_liste_transfert()
 //{
   /// $resultat=DB::table('tbl_affectations')
                  ////->join('tbl_agences','tbl_affectations.numagence','=','tbl_agences.numagence')
                  //->join('tbl_transfert_banques','tbl_affectations.numagence','=','tbl_transfert_banques.numagence')
                  //->join('tbl_partenaires','tbl_partenaires.id_partenaire','=','tbl_transfert_banques.id_partenaire')
                  //->join('tbl_devises','tbl_devises.id','=','tbl_transfert_banques.id_devise')
                  //->where('tbl_affectations.matricule','=',Auth::user()->matricule)
                  //->where('tbl_affectations.statut','=','1')
                  //->orderBy('id_tranfert','DESC')
                  //->select('tbl_affectations.numagence','nomagence','tbl_transfert_banques.date_T','montant','tbl_transfert_banques.id_devise','intitule','operation','tbl_transfert_banques.matricule','tbl_transfert_banques.id_partenaire' ,'type')
                  //->get();
              //return response()->json(['data'=>$resultat]);

//}

    
//____________________________code_raphael______________________________________

///////++++++++++++++++++++++++++++++++DEBUT RAPPORT+++++++++++++++++++++++++++++++++++++++++++++
   // public function get_rapport($d,$f)
   // {
       //     $resultat=DB::table('tbl_transfert_banques','tbl_transfert')
       //     ->join('tbl_agences','tbl_transfert.numagence','=','tbl_agences.numagence')
         //   ->join('tbl_partenaires','tbl_transfert.id_partenaire','=','tbl_partenaires.id_partenaire')
          //  ->whereBetween('date_T', [$d,$f]) 
          //  ->select(DB::raw('SUM(montant) as montant'),'type','nomagence','id_devise','date_T','operation')
           // ->groupBy('date_T','nomagence','type','operation','id_devise')
           // ->get();
           // return response()->json(['data'=>$resultat]);
  //  }



    

    
    public function index_rapport()
    {
        if (Auth::check()) {  
            $this->entete();
             $don=$this->recu_agence();
             return view('view_rapport_cash',compact('don'));
        }
        else{
            return redirect()->route('login');
        }
    }




        public function index_general()
    {
        if (Auth::check()) {  
            $this->entete();
             return view('view_rapport_general');
        }
        else{
            return redirect()->route('login');
        }
    }

        public function get_rapport_general($d,$f)
    {
        $resultat=DB::table('tbl_pourcentages')
        ->whereBetween('created_at', [$d,$f])
        ->select('id','pourceusd','pourcecdf','created_at')
        ->get();
        return response()->json(['data'=>$resultat]); 
    }

    public function get_rapport_credit1($d,$f)
    {
        $resultat=DB::table('tbl_depots','tbl_depot')
        ->join('tbl_agences','tbl_depot.numagence','=','tbl_agences.numagence')
        ->join('tbl_devises','tbl_depot.id_devise','=','tbl_devises.id')
        ->where('etatservi','=', '0')
        ->whereBetween('created_at', [$d,$f])
        ->select('numdepot','nomben','telclient','montenvoi','id_devise','created_at')
        ->get();
        return response()->json(['data'=>$resultat]); 
    }


     public function get_rapport_restitution($d,$f)
    {
        $resultat=DB::table('tbl_depots','tbl_depot')
        ->join('tbl_agences','tbl_depot.numagence','=','tbl_agences.numagence')
        ->join('tbl_devises','tbl_depot.id_devise','=','tbl_devises.id')
        ->whereBetween('created_at', [$d,$f])
        ->select('numdepot','nomben','telclient','montenvoi','id_devise','created_at','etatservi')
        ->get();
        return response()->json(['data'=>$resultat]); 
    }
    
              



   //  public function index_rapport_s()
    //{
        //if (Auth::check()) {  
         //   $this->entete();
            //$resultat=DB::table('tbl_transfert_banques','tbl_transfert')->join('tbl_partenaires','tbl_transfert.id_partenaire','=','tbl_partenaires.id_partenaire')
            //->where('date_T','=', $this->date->format('Y-m-d'))
            //->orderBy('type','asc')
            //->select(DB::raw('SUM(montant) as montant'),'type','id_devise','operation')
           // ->groupBy('type','operation','id_devise')
           // ->get();
            ///dd($resultat);
           //  return view('view_cash_s',compact('resultat'));
       // }
       // else{
            //return redirect()->route('login');
       // }
    //}
    
    



     public function get_rapportG($d,$f)
    {
        $resultat=DB::table('tbl_clotures',)->join('tbl_agences','tbl_clotures.numagence','=','tbl_agences.numagence')
        ->whereBetween('created_at', [$d,$f])
        ->select('totalentreusd','departcdf','nomagence','pourcentageusd','pourcentagecdf','created_at','totalentrecdf','nvdepartusd','nvdepartcdf','departusd','departcdf')
        ->get();
        return response()->json(['data'=>$resultat]); 
    }
    
    
    

  public function recu_agence(){
                $donnees=DB::table('tbl_affectations')->join('tbl_agences','tbl_affectations.numagence','=','tbl_agences.numagence')
                ->where('tbl_affectations.matricule','=',Auth::user()->matricule)
                ->where('tbl_affectations.statut','=','1')
                ->orderBy('tbl_agences.nomagence','asc')
                ->select('tbl_affectations.numagence','tbl_agences.nomagence','tbl_agences.initial')
                ->get(); 
                return  $donnees;
      }             


    
}
