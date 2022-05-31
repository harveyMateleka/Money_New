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
use App\Models\tbl_retrait;
use App\Models\tbl_agence;
use App\Models\tbl_personnel;
use App\Models\tbl_pourcentage;
use App\Models\tbl_banque;
use App\Models\tbl_ong;
use App\Models\tbl_transfert_ong;
use App\Models\tbl_detail_t;
use App\Models\tbl_paiement;
use App\Models\tbl_transfert_banque;
use App\Models\tbl_mvtbanques;
use App\Models\tbl_cloture;
use DateTime;
use DB;
use PDF;
use App;
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

    public function __construct(){
        $this->date= new DateTime();
        $this->agence=tbl_agence::all();
        $this->banque=tbl_banque::all();
        $this->agence=tbl_agence::where('indiceag','<>',1)->get();
        $this->ong=tbl_ong::orderBy('name_ong','ASC')->get();
        $resultat=tbl_transfert_ong::orderBy('id','DESC')->skip(0)->take(1)->first();
        if ($resultat) {
            $this->transfert=$resultat->id + 1;
        }
        else
        {
            $this->transfert=1; 
        } 
        
      
    }
    public function index_restitution()
    {
        if (Auth::check()) {  
            $this->entete();
            $resultat=DB::table('tbl_depots','tbl_depot')->join('tbl_agences','tbl_depot.numagence','=','tbl_agences.numagence')
                                                         ->join('tbl_clients','tbl_depot.id_client','=','tbl_clients.id_client')
                                                         ->join('tbl_viles','tbl_depot.id_ville','=','tbl_viles.id_ville')
                                                         ->join('tbl_devises','tbl_depot.id_devise','=','tbl_devises.id')
                                        ->where('tbl_depot.retrait_credit','=','1')
                                        ->orderBy('tbl_depot.id','DESC')
                                        ->select('tbl_depot.id','numdepot','nomben','montenvoi','montpour','created_at','nomagence','nomclient','ville','intitule')
                                        ->get();
                                        
            return view('view_restitution',compact('resultat'));
        }
    }

    public function repartition_ong(){
        if (Auth::check()) {  
            $this->entete();

$resultat=DB::table('tbl_transfert_ongs','tbl_transfert')->join('tbl_ongs','tbl_transfert.id_ong','=','tbl_ongs.id')
            ->where('tbl_transfert.created_at','=',$this->date->format('Y-m-d'))
            ->select('mont_trans','tbl_transfert.id','devise','type','taux','name_ong','tbl_transfert.created_at')
            ->orderBy('tbl_transfert.id','DESC')
            ->get();

            $data=[
                'tbl_agence'=>$this->agence,
                'code_trasanct'=>$this->generateRandomString(),
                'data_base'=>$resultat
            ];
            return view('view_repartitionOng',$data);

        }
        else {
            return redirect()->route('index_login');
        }
    }

    public function index_cloture1()
 { 
        if (Auth::check()) { 
                $this->entete();
                $totalespesecdf=0.0;
                $totalespeseusd=0.0;
                $totalcoffrecdf=0.0;
                $totalcoffreusd=0.0;
                $totalpourcentageusd=0.0;
                $totalpourcentagecdf=0.0;
                $totalbankusd=0.0;
                $totalbankcdf=0.0;
                $totalcreditusd=0.0;
                $totalcreditcdf=0.0;
                $totalmvtusd=0.0;
                $totalmvtcdf=0.0;
                $capitalusd=0.0;
                $capitalcdf=0.0;
                $depensecdf=0.0;
                $depenseusd=0.0;
                $diffcdf=0.0;
                $diffusd=0.0;

                $date = date('Y-m-d');
        
                //_______toutes les especes des agences et des coffres
            $total=DB::table('tbl_agences')
               ->select(DB::raw('SUM(Montusd) as mont1'),DB::raw('SUM(Montcdf) as mont'),'indiceag')
                ->whereIn('indiceag',['0','1'])
                ->groupBy('indiceag')
                ->get();
               foreach ($total as $ligne_total) {
                   if ($ligne_total->indiceag=='0') {
                    $totalespesecdf=$ligne_total->mont;
                    $totalespeseusd=$ligne_total->mont1;
                   } else {
                    $totalcoffrecdf=$ligne_total->mont;
                    $totalcoffreusd=$ligne_total->mont1;
                   }
               }
               //___________fin_______________
               // pour le banque_________________z
               $banques=DB::table('tbl_banques')->select(DB::raw('SUM(montant) as montant'),'devise')
               ->groupBy('devise')
               ->get();
                
                  foreach ($banques as $request) {
                            if ($request->devise=='1') {
                                $totalbankusd=$request->montant;
                            }else{
                                $totalbankcdf =$request->montant;
                            }
    
                        }
            //______________fin banque____________________

             //______________________debut mouvement banque___________
             $mvt=DB::table('tbl_mvtbanques')->select(DB::raw('SUM(Montmvt) as montbanques'),'devise')
             ->where('etatmvt','=','0')
             ->groupBy('devise')
             ->get();
             foreach ($mvt as $request) {
                if ($request->devise=='1') {
                    $totalmvtusd=$request->montbanques;
                }else{
                    $totalmvtcdf =$request->montbanques;
                }
            } 
            
            //_________________________fin mvt__________
$pourcentage=DB::table('tbl_depots')->select(DB::raw('SUM(montpour) as pourusd'),'id_devise')
           ->where('created_at','=',$date)
           ->groupBy('id_devise')
           ->get();
           foreach ($pourcentage as $pour) {
                        if ($pour->id_devise==1) {
                            $totalpourcentageusd=$pour->pourusd;
                        }else{
                            $totalpourcentagecdf =$pour->pourusd;
                        }
                    }
  $credit=DB::table('tbl_depots')->select(DB::raw('SUM(montenvoi) as montenvoi'),'id_devise')
           ->where('etatservi','=','0')
           ->groupBy('id_devise')
           ->get();
  foreach ($credit as $ligne_credit) {
                        if ($ligne_credit->id_devise==1) {
                            $totalcreditusd=$ligne_credit->montenvoi;
                        }else{
                            $totalcreditcdf =$ligne_credit->montenvoi;
                        }
                    }
            $depense=DB::table('tbl_depenses')->select(DB::raw('SUM(montant) as montantdepend'),'devise')
                ->where('created_at','=',$this->date->format('Y-m-d'))
                ->where('etat','=','1')
                ->groupBy('devise')
                ->get();
  foreach ($depense as $ligne_dep) {
                        if ($ligne_dep->devise=='1') {
                            $depenseusd=$ligne_dep->montantdepend;
                        }else{
                            $depensecdf =$ligne_dep->montantdepend;
                        }
                    } 

                    $diffusd=$totalpourcentageusd-$depenseusd;
                    $diffcdf=$totalpourcentagecdf-$depensecdf;
                    if ($diffusd > 0 && $diffcdf >0 ) {
                        $capitalusd=($totalbankusd+$totalespeseusd+$totalmvtusd+$totalcoffreusd+$depenseusd + $diffusd)-($totalcreditusd+$totalpourcentageusd);
                        $capitalcdf=($totalbankcdf+$totalespesecdf+$totalmvtcdf+$totalcoffrecdf+$depensecdf + $diffcdf)-($totalcreditcdf+$totalpourcentagecdf);
                    }
                    elseif($diffusd > 0 && $diffcdf <= 0) {
                        $capitalusd=($totalbankusd+$totalespeseusd+$totalmvtusd+$totalcoffreusd+$depenseusd + $diffusd)-($totalcreditusd+$totalpourcentageusd);
                        $capitalcdf=($totalbankcdf+$totalespesecdf+$totalmvtcdf+$totalcoffrecdf+$depensecdf)-($totalcreditcdf+$totalpourcentagecdf);
                    }
                    elseif($diffusd <= 0 && $diffcdf > 0) {
                        $capitalusd=($totalbankusd+$totalespeseusd+$totalmvtusd+$totalcoffreusd+$depenseusd )-($totalcreditusd+$totalpourcentageusd);
                        $capitalcdf=($totalbankcdf+$totalespesecdf+$totalmvtcdf+$totalcoffrecdf+$depensecdf + $diffcdf)-($totalcreditcdf+$totalpourcentagecdf);
                    }
                    else {
                        $capitalusd=($totalbankusd+$totalespeseusd+$totalmvtusd+$totalcoffreusd+$depenseusd )-($totalcreditusd+$totalpourcentageusd);
                        $capitalcdf=($totalbankcdf+$totalespesecdf+$totalmvtcdf+$totalcoffrecdf+$depensecdf)-($totalcreditcdf+$totalpourcentagecdf);
                   
                    }
                                    
                $data=['total_bankusd'=> $totalbankusd,
                       'total_bankcdf'=> $totalbankcdf,
                       'totalespesecdf'=>$totalespesecdf,
                       'totalespeseusd'=>$totalespeseusd,
                       'totalpourcentageusd'=>$totalpourcentageusd,
                       'totalpourcentagecdf'=>$totalpourcentagecdf,
                       'totalcreditcdf'=>$totalcreditcdf,
                       'totalcreditusd'=>$totalcreditusd,
                       'totalmvtcdf' =>$totalmvtcdf,
                       'totalmvtusd' =>$totalmvtusd,
                       'capitalcdf'=>$capitalcdf,
                       'capitalusd'=>$capitalusd,
                       'diffcdf'=>$diffcdf,
                       'diffusd'=>$diffusd,
                       'depenseusd'=>$depenseusd,
                       'depensecdf'=>$depensecdf,
                       'coffre_usd'=>$totalcoffreusd,
                       'coffre_cdf'=>$totalcoffrecdf,
                    ];
                    //dd($depense);    
             
                    return view('view_general',$data);  



          } 
          else {
            return redirect()->route('index_login');
        }
  }


   public function print($id)
    {
        $result=DB::table('tbl_depots')->join('tbl_agences','tbl_depots.numagence','=','tbl_agences.numagence')
                                       ->join('tbl_viles','tbl_depots.id_ville','=','tbl_viles.id_ville')
                                       ->join('tbl_clients','tbl_depots.id_client','=','tbl_clients.id_client')
                                        ->join('tbl_devises','tbl_depots.id_devise','=','tbl_devises.id')  
                                        ->where('tbl_depots.id','=',$id) 
                                        ->select('tbl_depots.id','numdepot','nomben','montenvoi','montpour','created_at','ville','intitule','nomclient','nomagence','tel','telclient')
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
                     ];
            
                    $pdf = PDF::loadView('generate_pdf',$data);
                    return $pdf->download('codingdriver.pdf');
        }
    }
   public function generatecode(Request $request){
          
          if ($request->ajax()) {
              $resultat=$request->initial_ag;
              $resultat.=$this->recupe_code();
              $resultat.=$request->initial_vil;
              return response()->json(['success'=>$resultat]);
          }
      } 

      function recupe_code($length = 4) {
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
            $transact=$this->generateRandomString4();
            $numero_ag=0;
            foreach ($don as $value_donnee) {
                $numero_ag=$value_donnee->numagence;
            }
            
            return view('view_entree',compact('don','tab_ville','tab_devise'));
        }
        else{
            return redirect()->route('index_login');
          }
    }

  public function index_sortie()
    {
        if (Auth::check()) {  
            $this->entete();
            $sortie_agence=$this->recu_agence();
            return view('view_sortie',compact('sortie_agence'));
        }
        else{
            return redirect()->route('index_login');
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

    public function index_ong()
    {
        if (Auth::check()) {  
            $this->entete();
             $data=[
                 'tbl_agence'=>$this->agence,
                 'tbl_banque'=>$this->banque,
                 'code_trasanct'=>$this->generateRandomString(),
                 'ong'=>$this->ong,
                 'transfert'=>$this->transfert
             ];
             return view('view_save_ong',$data);
          
        }
        else{
            return redirect()->route('index_login');
        }
    }

    public function index_paie_ong()
    {
        if (Auth::check()) {  
            $this->entete();
             $agence=$this->recu_agence();
             return view('view_sortie_ong',compact('agence'));
          
        }
        else{
            return redirect()->route('index_login');
        }
        
    }

    public function index_liste()
    {
        if (Auth::check()) {  
            $this->entete();
            $requette=DB::table('tbl_paiements','paiement')->join('tbl_detail_ts','paiement.code_detail','=','tbl_detail_ts.id')
                                                           ->join('tbl_agences','tbl_detail_ts.numagence','=','tbl_agences.numagence')
                                                           ->join('tbl_transfert_ongs','tbl_detail_ts.id_transf','=','tbl_transfert_ongs.id')
                                                           ->where('paiement.created_at','=',$this->date->format('Y-m-d'))
                                                           ->select(DB::raw('SUM(Montpay) as mont'),'nomagence','paiement.created_at','devise')
                                                           ->groupBy('paiement.code_detail','nomagence','devise','paiement.created_at')
                                                           ->get();
                                                           //dd($requette);

             return view('view_liste_paie',compact('requette'));
          
        }
        else{
            return redirect()->route('index_login');
        }
    }

   public function index_credit()
{
    if (Auth::check()) {  
        $this->entete();
         $tab_ville=tbl_vile::orderBy('ville','asc')->get();
        $tab_devise=tbl_devise::orderBy('id','DESC')->get();
        $agence=tbl_agence::orderBy('nomagence','asc')->get();
        $resultat=DB::table('tbl_depots','tbl_depot')->join('tbl_agences','tbl_depot.numagence','=','tbl_agences.numagence')
                                                     ->join('tbl_clients','tbl_depot.id_client','=','tbl_clients.id_client')
                                                     ->join('tbl_viles','tbl_depot.id_ville','=','tbl_viles.id_ville')
                                                     ->join('tbl_devises','tbl_depot.id_devise','=','tbl_devises.id')
                                    ->where('tbl_depot.etatservi','=','0')
                                    ->orderBy('tbl_depot.id','DESC')
                                    ->select('tbl_depot.id','numdepot','montenvoi','montpour','created_at','nomagence','nomclient','ville','intitule','id_devise')
                                    ->get();

      
        
        return view('view_credit',compact('resultat','tab_ville','tab_devise','agence'));
    }
    else{
        return redirect()->route('index_login');
    }
}

    public function index_cloture_agence()
{

        if (Auth::check()) {
            $this->entete();
            
             $don=DB::table('tbl_affectations')->join('tbl_agences','tbl_affectations.numagence','=','tbl_agences.numagence')
            ->where('tbl_affectations.matricule','=',Auth::user()->matricule)
             ->where('tbl_affectations.statut','=','1')
             ->orderBy('id','DESC')
             ->select('tbl_affectations.numagence','tbl_agences.nomagence')
             ->get(); 
            return view('view_cloture',compact('don'));
        }
        else{
            return redirect()->route('index_login');
          }
       }

    public function chercher(Request $request)
    {
        $resultat=DB::table('tbl_transfert_ongs','tbl_transfert')->join('tbl_ongs','tbl_transfert.id_ong','=','tbl_ongs.id')
            ->where('tbl_transfert.id','=',$request->code_tra)
            ->select('mont_trans','tbl_transfert.id','devise','type','taux','name_ong','tbl_transfert.created_at')
            ->orderBy('tbl_transfert.id','DESC')
            ->first();

            return response()->json($resultat);   
    }

public function store_cloture_agence(Request $request)
    {
        if ($request->ajax()) {

            $requette=DB::table('tbl_affectations','tbl_affect')->join('tbl_agences','tbl_affect.numagence','=','tbl_agences.numagence')
            ->where('tbl_affect.matricule','=',Auth::user()->matricule)
            ->where('statut','=','1')
            ->select('tbl_affect.numagence','tbl_agences.nomagence','Montusd','Montcdf')->first();
            if ($requette) {

                $table=tbl_cloture::whereNumagence($requette->numagence)->whereCreated_at($this->date->format('Y-m-d'))->first();
                if (!$table) {
                    $record= new tbl_cloture;
                    $record->departcdf=$request->departcdf;
                    $record->departusd=$request->departusd;
                    $record->nvdepartcdf=$request->nvdepartcdf;
                    $record->nvdepartusd=$request->nvdepartusd;
                    $record->totalentrecdf=$request->totalentrecdf;
                    $record->totalentreusd=$request->totalentreusd;
                    $record->pourcentagecdf=$request->pourcentagecdf;
                    $record->pourcentageusd=$request->pourcentageusd;
                    $record->created_at=$this->date->format('Y-m-d');
                    $record->numagence=$requette->numagence;
                    $record->save();
                    return response()->json(['success'=>'1']);
                }  
                else{
                   
                    $table->departcdf=$request->departcdf;
                     $table->departusd=$request->departusd;
                     $table->nvdepartcdf=$request->nvdepartcdf;
                     $table->nvdepartusd=$request->nvdepartusd;
                     $table->totalentrecdf=$request->totalentrecdf;
                     $table->totalentreusd=$request->totalentreusd;
                     $table->pourcentagecdf=$request->pourcentagecdf;
                     $table->pourcentageusd=$request->pourcentageusd;
                     $table->created_at=$this->date->format('Y-m-d');
                     $table->numagence=$requette->numagence;
                     $table->save();
                    return response()->json(['success'=>'2']);
                }
            }
            
           
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
            $requette2=tbl_agence::whereNumagence($request->agence)->first();
            if ($requette2) {
                $Montantusd=$requette2->Montusd;
                $Montantcdf=$requette2->Montcdf;
                $name_agence=$requette2->nomagence;
            }
            while ($a <= 2) {
                $requette=tbl_client::whereTel($request->expeditel)->first();
                if ($requette) {
                       $insert=tbl_depot::create(['numdepot'=>$request->transact,
                                                  'telclient'=>$request->tel_ben,
                                                  'nomben'=>$request->benefic,
                                                  'montenvoi'=>$request->montenv,
                                                  'montpour'=>$request->montcom,
                                                  'etatservi'=>'0',
                                                  'id_ville'=>$request->ville,
                                                  'id_devise'=>$request->devise,
                                                  'numagence'=>$request->agence,
                                                  'created_at'=>$this->date->format('Y-m-d'),
                                                  'matricule'=>Auth::user()->matricule,
                                                  'id_client'=>$requette->id_client,
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
                    $requette1=tbl_client::create(['nomclient'=>$request->expediteur,'tel'=>$request->expeditel]);
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

    public function show_sortie($id)
    {
        $requette=DB::table('tbl_agences')->where('numagence','=',$id)->select('numagence','id_ville')->first();
        if ($requette) {
            $req=DB::table('tbl_depots')->join('tbl_agences','tbl_depots.numagence','=','tbl_agences.numagence')
                                        ->join('tbl_viles','tbl_depots.id_ville','=','tbl_viles.id_ville')
                                        ->join('tbl_devises','tbl_depots.id_devise','=','tbl_devises.id')  
                                        ->where('tbl_depots.id_ville','=',$requette->id_ville) 
                                        ->where('tbl_depots.etatservi','=','0') 
                                        ->select('tbl_depots.id','tbl_depots.id_devise','montenvoi','created_at','ville','intitule','nomagence')
                                        ->get();
            return response()->json(['data'=>$req]);      
            }

    }

        public function save_sortie(Request $request)
    {
        if ($request->ajax()) {
            $montdollars=0.0;
            $value=0;
            $montcdf=0.0;
            $name_agence='';
            $operation='';
            $requette=DB::table('tbl_agences')->where('numagence','=',$request->agence)
             ->select('numagence','nomagence','Montusd','Montcdf')->first();
                if ($requette) {
                   $this->numagence=$request->agence;
                   $montdollars=$requette->Montusd;
                   $montcdf=$requette->Montcdf;
                   $name_agence=$requette->nomagence;
                  }
                   
            if ($request->devise==1 && $montdollars >= $request->montant) { 
                $montdollars-=$request->montant;
                $value=1;
                $operation="Sortie du code ".$request->code." du montant de ".$request->montant." Usd dans l'agence ".$name_agence; 
            }elseif ($request->devise==2 && $montcdf >= $request->montant) {
                $montcdf-=$request->montant;
                $value=1;
                $operation="Sortie du code ".$request->code." du montant de ".$request->montant." Cdf dans l'agence ".$name_agence; 
               
            }
            if ($value==1) {
                $update=tbl_agence::whereNumagence($request->agence)->update(['Montusd'=> $montdollars,'Montcdf'=>$montcdf]);
                $insert= new tbl_retrait;
                $insert->matricule=Auth::user()->matricule;
                $insert->numagence=$request->agence;
                $insert->id_depot=$request->code;
                $insert->date_servis=$this->date->format('Y-m-d');
                $insert->save();
                $requet=tbl_depot::whereNumdepot($request->code)->update(['etatservi'=>'1']);
                $this->historique(Auth::user()->matricule,$operation);
                return response()->json(['success'=>'1']);
            }
            else {
                return response()->json(['success'=>'3']);
            }
           
          
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

   public function generatePDF($id,$a,$v,$t,$e,$te,$b,$tb,$m,$mc,$dev,$r)
    {
        if ($id=='1') {
             $data = [
                 'entete' => "Bon d'envoie",
                   'date' => $this->date->format('Y-m-d'),
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
                   'raison'  => $r,           
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
                              'date' => $this->date->format('Y-m-d'),
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
                              'raison'  => $r,           
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

    public function save_detail(Request $request)
    {
            if ($request->ajax()) {

                $requette=DB::table('tbl_detail_ts')->where('id_transf','=',$request->code)
                   ->select(DB::raw('SUM(montp) as montant'))
                    ->first();
                    if ($requette) {
                        if ($requette->montant < $request->total_Mont) {
                             $requet=tbl_detail_t::where('id_transf','=',$request->code)->where('numagence','=',$request->desti)
                             ->first();
                                if (!$requet) {
                                    $insert=tbl_detail_t::create([
                                    'id_transf'=>$request->code,
                                    'montp'=>$request->montant,
                                    'numagence'=>$request->desti,
                                    'code_tr'=>$request->code_tra,
                                    'created_at'=>$this->date->format('Y-m-d')
                                   ]);
                                     return response()->json(['success'=>$this->generateRandomString()]);
                                } else {
                                    return response()->json(['success'=>'2']);
                                }
                                

                        }
                        else{
                            return response()->json(['success'=>'2']);
                        }

                    } else {
                          $requet=tbl_detail_t::where('id_transf','=',$request->code)->where('numagence','=',$request->desti)
                             ->first();
                                if (!$requet) {
                                    $insert=tbl_detail_t::create([
                                    'id_transf'=>$request->code,
                                    'montp'=>$request->montant,
                                    'numagence'=>$request->desti,
                                    'code_tr'=>$request->code_tra,
                                    'created_at'=>$this->date->format('Y-m-d')
                                   ]);
                                     return response()->json(['success'=>$this->generateRandomString()]);
                                } else {
                                    return response()->json(['success'=>'2']);
                                }
                    }
                    
               
                
                
                }
    }

    public function save_ong(Request $request)
    {
            if ($request->ajax()) {
                $montdollars=0.0;
                $montcdf=0.0;
                $operation='';
                $name='';
                    $insert=tbl_transfert_ong::create(['id_ong'=>$request->ong,'mont_trans'=>$request->montant,'mont_com'=>$request->pour,'mont_dep'=>$request->frais,
                    'devise'=>$request->devise,'type'=>$request->etat,'prov'=>$request->prov,'taux'=>$request->taux,
                   'created_at'=>$this->date->format('Y-m-d')]);

                    if ($request->etat==1) {
                        $result=tbl_agence::whereNumagence($request->prov)->first();
                        if ($result) {
                            $montdollars=$result->Montusd;
                            $montcdf=$result->Montcdf; 
                            $name=$result->nomagence;  
                        }
                                if ($request->devise==1) {
                                    $montant=$request->montant + $request->pour + $request->frais;
                                    $montdollars+= $montant;
                                    $operation="Entrée pour le compte de l'ong du montant ".$montant." Usd dans l'agence ".$name;
                                        
                                }
                                    else{
                                        $montant=$request->montant + $request->pour + $request->frais; 
                                        $montcdf+=$montant; 
                                        $operation="Entrée pour le compte de l'ong du montant ".$montant." Usd dans l'agence ".$name;
                                    }
                                    $sult=tbl_agence::whereNumagence($request->prov)->update(['Montusd'=>$montdollars,'Montcdf'=>$montcdf]);
                                    $this->historique(Auth::user()->matricule,$operation);
                                   
                                    return response()->json(['success'=>'1']);
                       }
                    else{
                        $student_marks = tbl_banque::where('id','=',$request->prov)->first();
                        $montantt=$request->montant + $request->pour + $request->frais;
                        if ($student_marks) {
                                if ($student_marks->devise==$request->devise) {
                                    $student_marks->Montant +=$montantt;
                                    $operation= "Entrée pour le compte de l'ong du montant ".$montantt." dans le compte ".$student_marks->intitulecompte;
                                    $student_marks->save();
                                    $this->historique(Auth::user()->matricule,$operation);
                                    return response()->json(['success'=>'1']);
                                  }
                                  else{
                                    return response()->json(['success'=>'2']); 
                                  }
                           
                            
                        }
                       }
            }
    }
    public function charger_ong(){
        $resultat=DB::table('tbl_transfert_ongs','tbl_transfert')->join('tbl_ongs','tbl_transfert.id_ong','=','tbl_ongs.id')
                                                                 ->select('mont_trans','tbl_transfert.id','mont_com','mont_dep','devise','type','taux','montpayé','name_ong','tbl_transfert.created_at')
                                                                 ->orderBy('tbl_transfert.id','DESC')
                                                                 ->get();
 
   return response()->json(['data'=>$resultat]); 
        
    }

public function check_sortie(Request $request)
    {
        $reponse='';

        $requette=DB::table('tbl_agences')
                        ->where('numagence','=',$request->agence)
                        ->select('tbl_agences.nomagence','tbl_agences.id_ville','Montcdf','Montusd')->first();

            if ($requette) {
                $req=DB::table('tbl_depots')->join('tbl_agences','tbl_depots.numagence','=','tbl_agences.numagence')
                                        ->join('tbl_viles','tbl_depots.id_ville','=','tbl_viles.id_ville')
                                        ->join('tbl_clients','tbl_depots.id_client','=','tbl_clients.id_client')
                                        ->join('tbl_devises','tbl_depots.id_devise','=','tbl_devises.id')  
                                        ->where('tbl_depots.id_ville','=',$requette->id_ville) 
                                        ->where('tbl_depots.etatservi','=','0')
                                        ->where('tbl_depots.numdepot','=',$request->code)  
                                        ->select('tbl_depots.id','numdepot','nomben','montenvoi','montpour','created_at','ville','intitule','nomclient','nomagence','tbl_depots.id_devise')
                                        ->first();
                                        if ($req) {
                                            $reponse='1';
                                            $this->MontCdf=$requette->Montcdf;
                                            $this->MontUsd=$requette->Montusd;
                                            $this->agence=$requette->nomagence;
                                            $this->devise=$req->id_devise;
                                            return response()->json(['data'=>$req,'success'=>$reponse]);
                                        }
                                        else{
                                           $reque1=DB::table('tbl_depots')->where('tbl_depots.numdepot','=',$request->code)->first();
                                           if ($reque1) {
                                                        if ($reque1->etatservi=='0') {
                                                            $reponse="ce code doit etre servi dans une autre ville";
                                                            return response()->json(['success'=>$reponse]);
                                                        }
                                                        else{
                                                            $reponse="ce code a été deja servi";
                                                            return response()->json(['success'=>$reponse]);
                                                        }
                                            }
                                            else{
                                                $reponse="ce code n'existe pas dans le systeme";
                                                return response()->json(['success'=>$reponse]);  
                                            }  
                                        }
                 }
                  
    }


    public function check_ong(Request $request)
    {

        if ($request->ajax()) {

            $requette=DB::table('tbl_detail_ts')->join('tbl_transfert_ongs','tbl_detail_ts.id_transf','=','tbl_transfert_ongs.id')
                                                ->join('tbl_ongs','tbl_transfert_ongs.id_ong','=','tbl_ongs.id')
                                                ->where('code_tr','=',$request->code)
                                                ->where('numagence','=',$request->agence)
                                                ->select('montp','mont_trans','devise','tbl_detail_ts.id as id_detail','name_ong')
                                                ->first();
            if ($requette) {
                $total=0.0;
                $result = DB::table('tbl_paiements')
                             ->where('code_detail','=',$requette->id_detail)
                             ->select(DB::raw('SUM(Montpay) as mont'))
                             ->first();
                             if ($result) {
                                $total= $result->mont;
                              }
                              else{
                                $total=0.0; 
                              }
                              return response()->json(['data'=>$requette,'total'=>$total,'success'=>'1']);  
              }
              else{
                return response()->json(['success'=>"il se peut que ce code n'existe pas ou qui ne doit pas etre payé dans cet agence"]);
              }
           
         }
                  
    }
    
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


    public function update_credit(Request $request)
    {
    
      if ($request->ajax()) {
            $montantdolars=0.0;
            $montantcdf=0.0;
              $data=tbl_depot::where('id','=',$request->code)->first();
              if($data){
                  $data->etatservi=1;
                  $data->retrait_credit=1;
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

    public function sortie_ong(Request $request)
    {
        if ($request->ajax()) {
            $montdollars=0.0;
            $montcdf=0.0; 
            $name_agence='';
            $operation=''; 
            $requette1=tbl_detail_t::where('id','=',$request->code_detail)->first();
            if ($requette1) {
                $requette2=tbl_transfert_ong::where('id','=',$requette1->id_transf)->first();
                    if ($requette2) {
                        $result=tbl_agence::whereNumagence($requette1->numagence)->first();
                        if ($result) {
                            $montdollars=$result->Montusd;
                            $montcdf=$result->Montcdf; 
                            $name_agence=$result->nomagence;  
                        }

                        if ($requette2->devise=='1') {
                                if ($montdollars < $request->montant) {
                                    return response()->json(['success'=>"l'agence n'a pas assez de montant pour faire la sortie"]);
                                    exit();
                                }
                                else {
                                  $montdollars-=$request->montant;
                                  $operation="paiement de l'ong du montant de ".$request->montant." Usd dans l'agence de ".$name_agence;
                                }   
                         } 
                        else{
                                if ($montcdf < $request->montant) {
                                    return response()->json(['success'=>"l'agence n'a pas assez de montant pour faire la sortie"]);
                                    exit();
                                }
                                else {
                                $montcdf-=$request->montant;
                                $operation="paiement de l'ong du montant de ".$request->montant." Cdf dans l'agence de ".$name_agence;   
                               
                                }
                        } 
                        $requette2->montpayé+=$request->montant;
                        $requette2->save();
                        $requette=tbl_paiement::create(['code_detail'=>$request->code_detail,'Montpay'=>$request->montant,'created_at'=>$this->date->format('Y-m-d')]);
                        $result1=tbl_agence::whereNumagence($requette1->numagence)->update(['Montcdf'=>$montcdf,'Montusd'=>$montdollars]);
                        $this->historique(Auth::user()->matricule,$operation);
                        return response()->json(['success'=>'1']);     
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
    public function transfert_banque(){
        if (Auth::check()) {
            $this->entete();
        
             $part=tbl_partenaire::orderBy('id_partenaire','DESC')->get();
             $resultat=DB::table('tbl_affectations')->join('tbl_agences','tbl_affectations.numagence','=','tbl_agences.numagence')
            ->where('tbl_affectations.matricule','=',Auth::user()->matricule)
             ->where('tbl_affectations.statut','=','1')
             ->orderBy('id','DESC')
             ->select('tbl_affectations.numagence','tbl_agences.nomagence')
             ->get();
             $devise=tbl_devise::orderBy('id','DESC')->get();
             
             return view('view_transfert_banque',compact('resultat','devise','part'));

        }
    }

public function get_liste_transfert()
{
    $resultat=DB::table('tbl_affectations')
                  ->join('tbl_agences','tbl_affectations.numagence','=','tbl_agences.numagence')
                  ->join('tbl_transfert_banques','tbl_affectations.numagence','=','tbl_transfert_banques.numagence')
                  ->join('tbl_partenaires','tbl_partenaires.id_partenaire','=','tbl_transfert_banques.id_partenaire')
                  ->join('tbl_devises','tbl_devises.id','=','tbl_transfert_banques.id_devise')
                  ->where('tbl_affectations.matricule','=',Auth::user()->matricule)
                  ->where('tbl_affectations.statut','=','1')
                  ->orderBy('id_tranfert','DESC')
                  ->select('tbl_affectations.numagence','nomagence','tbl_transfert_banques.date_T','montant','tbl_transfert_banques.id_devise','intitule','operation','tbl_transfert_banques.matricule','tbl_transfert_banques.id_partenaire' ,'type')
                  ->get();
              return response()->json(['data'=>$resultat]);

}

    public function transfert_insert(Request $request){
            if($request->devise == 2){
                if ($request->operation  == '1') {
                    $ajout = tbl_transfert_banque::create([
                        'numagence' => $request->agence,
                        'id_partenaire' => $request->partenaire,
                        'id_devise' => $request->devise,
                        'montant' => $request->montant,
                        'date_T' => date('Y-m-d'),
                        'matricule' => Auth::user()->matricule,
                        'operation' => $request->operation
                    ]); 
                    $agence = tbl_agence::whereNumagence($request->agence)->first();
                      if ($agence){
                          $montantCDF = $agence->Montcdf;
                      }
                      $totoCDF = $montantCDF + $request->montant;
                      $mod_agence = tbl_agence::whereNumagence($request->agence)->update(['Montcdf' => $totoCDF]);
                }elseif ($request->operation  == '2') {
                    $ajout = tbl_transfert_banque::create([
                        'numagence' => $request->agence,
                        'id_partenaire' => $request->partenaire,
                        'id_devise' => $request->devise,
                        'montant' => $request->montant,
                        'date_T' => date('Y-m-d'),
                        'matricule' => Auth::user()->matricule,
                        'operation' => $request->operation
                    ]); 
                    $agence = tbl_agence::whereNumagence($request->agence)->first();
                      if ($agence){
                          $montantCDF = $agence->Montcdf;
                      }
                      $totoCDF = $montantCDF - $request->montant;
                      $mod_agence = tbl_agence::whereNumagence($request->agence)->update(['Montcdf' => $totoCDF]);
                }
            }elseif ($request->devise == 1) {
                if ($request->operation  == '1') {
                    $ajout = tbl_transfert_banque::create([
                        'numagence' => $request->agence,
                        'id_partenaire' => $request->partenaire,
                        'id_devise' => $request->devise,
                        'montant' => $request->montant,
                        'date_T' => date('Y-m-d'),
                        'matricule' => Auth::user()->matricule,
                        'operation' => $request->operation
                    ]); 
                    $agence = tbl_agence::whereNumagence($request->agence)->first();
                      if ($agence){
                          $montantCDF = $agence->Montusd;
                      }
                      $totoCDF = $montantCDF + $request->montant;
                      $mod_agence = tbl_agence::whereNumagence($request->agence)->update(['Montusd' => $totoCDF]);
                }elseif ($request->operation  == '2') {
                    $ajout = tbl_transfert_banque::create([
                        'numagence' => $request->agence,
                        'id_partenaire' => $request->partenaire,
                        'id_devise' => $request->devise,
                        'montant' => $request->montant,
                        'date_T' => date('Y-m-d'),
                        'matricule' => Auth::user()->matricule,
                        'operation' => $request->operation
                    ]); 
                    $agence = tbl_agence::whereNumagence($request->agence)->first();
                      if ($agence){
                          $montantCDF = $agence->Montusd;
                      }
                      $totoCDF = $montantCDF - $request->montant;
                      $mod_agence = tbl_agence::whereNumagence($request->agence)->update(['Montusd' => $totoCDF]);
                }
            }
            return redirect()->route('transfert_banque');    
       
    }
//____________________________code_raphael______________________________________
public function index_partenaire()
{
      if (Auth::check()) {
            $this->entete();
            return view("view_partenaire");
        }
               
}

public function store_partenaire(Request $request)
{      
if ($request->ajax()) {
    $table=tbl_partenaire::whereId_partenaire($request->id_partenaire)->first();
    if (!$table) {
        $record= new tbl_partenaire;
        $record->type=$request->type;
        $record->save();
        return response()->json(['success'=>'1']);
    }  
    else{
        return response()->json(['success'=>'0']);
    }
}  
}

public function update_partenaire(Request $request)
{
if ($request->ajax()) {
    $this->validate($request,['type'=>'required']);
    $resultat=tbl_partenaire::whereId_partenaire($request->id_partenaire)->update(['type'=>$request->type]);
    return response()->json(['success'=>'1']);   
} 
}
public function get_list()
{
$resultat=tbl_partenaire::orderBy('id_partenaire','DESC')->get(); 
   return response()->json(['data'=>$resultat]);
}


public function get_id(Request $request)
{
if ($request->ajax()) {
    $resultat=tbl_partenaire::whereId_partenaire($request->code)->first();
    return response()->json($resultat); 
}
}



public function destroy_partenaire(Request $id)
{
if ($id->ajax()) {
    $resultat=tbl_partenaire::whereId_partenaire($id->code)->delete();
    return response()->json(['success'=>'1']); 
}
}

///////++++++++++++++++++++++++++++++++DEBUT RAPPORT+++++++++++++++++++++++++++++++++++++++++++++
    public function get_rapport($d,$f)
    {
        $resultat=DB::table('tbl_transfert_banques','tbl_transfert')->join('tbl_agences','tbl_transfert.numagence','=','tbl_agences.numagence')
        ->join('tbl_partenaires','tbl_transfert.id_partenaire','=','tbl_partenaires.id_partenaire')
        ->whereBetween('date_T', [$d,$f])
        ->select(DB::raw('SUM(montant) as montant'),'type','nomagence','id_devise','date_T','operation')
        ->groupBy('date_T','nomagence','type','operation','id_devise')
        ->get();
        return response()->json(['data'=>$resultat]); 
    }

    
    public function index_rapport()
    {
        if (Auth::check()) {  
            $this->entete();
             return view('view_rapport_cash');
        }
        else{
            return redirect()->route('index_login');
        }
    }

        public function index_general()
    {
        if (Auth::check()) {  
            $this->entete();
             return view('view_rapport_general');
        }
        else{
            return redirect()->route('index_login');
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
    
              
   public function get_id_credit(Request $request)
{
    if ($request->ajax()) {
    // $resultat=tbl_depot::whereId($request->code)->first();
        $resultat= DB::table('tbl_depots','tbl_depot')
        ->join('tbl_clients','tbl_depot.id_client','=','tbl_clients.id_client')
        ->whereId($request->code)
        ->select('tbl_depot.id','numdepot','montenvoi','nomben','montpour','created_at','numagence','nomclient','id_ville','id_devise','tel','telclient')
        ->first();


        return response()->json($resultat); 
       
    }
}


     public function index_rapport_s()
    {
        if (Auth::check()) {  
            $this->entete();
            $resultat=DB::table('tbl_transfert_banques','tbl_transfert')->join('tbl_partenaires','tbl_transfert.id_partenaire','=','tbl_partenaires.id_partenaire')
            ->where('date_T','=', $this->date->format('Y-m-d'))
            ->orderBy('type','asc')
            ->select(DB::raw('SUM(montant) as montant'),'type','id_devise','operation')
            ->groupBy('type','operation','id_devise')
            ->get();
            ///dd($resultat);
             return view('view_cash_s',compact('resultat'));
        }
        else{
            return redirect()->route('index_login');
        }
    }
    
    
    

public function up_credit_client(Request $request)
{
    if ($request->ajax()) {
        $montdollars=0.0;
        $montcdf=0.0;
        $agence=tbl_agence::whereNumagence($request->agence)->first();
        if ($agence) {
            $montdollars=$agence->Montusd;
            $montcdf=$agence->Montcdf;
        }
            if ($request->id_devise==$request->code_devise) {
                if ($request->montenvoi==$request->montenvoi_code) {
                    $resultat=tbl_depot::whereId($request->id_code)->first();
                    if ($resultat) {
                        $resultat->id_ville=$request->ville;
                        $resultat->nomben=$request->ben;
                        $resultat->telclient=$request->telben;
                        $resultat->save();
                    }
                    return response()->json(['success'=>'operation reussie']); 
                } elseif ($request->montenvoi > $request->montenvoi_code) {
                    $taux=0;
                    $pourc=0.0;
                    $devise=tbl_devise::whereId($request->id_devise)->first();
                    if ($devise) {
                        $taux=$devise->taux;
                    }
                    $pourc=$request->montenvoi * $taux/ 100;
                    $montantanc=$request->montenvoi_code + $request->pourc;
                    $montantnouv=$request->montenvoi+$pourc-$montantanc;
                    if ($request->id_devise==1) {
                        $montdollars+=$montantnouv;
                     }
                     else{
                        $montcdf+=$montantnouv;
                     }
                     $resultat=tbl_depot::whereId($request->id_code)->first();
                     if ($resultat) {
                         $resultat->id_ville=$request->ville;
                         $resultat->nomben=$request->ben;
                         $resultat->telclient=$request->telben;
                         $resultat->montenvoi=$request->montenvoi;
                         $resultat->montpour=$pourc;
                         $resultat->save();
                     }
                     $update=tbl_agence::whereNumagence($request->agence)->update(['Montcdf'=>$montcdf,'Montusd'=>$montdollars]);
                     return response()->json(['success'=>'operation reussie']);
                }
                else{
                    $taux=0;
                    $pourc=0.0;
                    $devise=tbl_devise::whereId($request->id_devise)->first();
                    if ($devise) {
                        $taux=$devise->taux;
                    }
                    $pourc=$request->montenvoi * $taux/ 100;
                    $montantanc=$request->montenvoi_code + $request->pourc;
                    $mont=$request->montenvoi + $pourc;
                    $montantnouv=$montantanc-$mont;
                    if ($request->id_devise==1) {
                        $montdollars-=$montantnouv;
                     }
                     else{
                        $montcdf-=$montantnouv;
                     }
                     $resultat=tbl_depot::whereId($request->id_code)->first();
                     if ($resultat) {
                         $resultat->id_ville=$request->ville;
                         $resultat->nomben=$request->ben;
                         $resultat->telclient=$request->telben;
                         $resultat->montenvoi=$request->montenvoi;
                         $resultat->montpour=$pourc;
                         $resultat->save();
                     }
                     $update=tbl_agence::whereNumagence($request->agence)->update(['Montcdf'=>$montcdf,'Montusd'=>$montdollars]);
                     return response()->json(['success'=>'operation reussie']);
                } 
                
            } else {
                if ($request->montenvoi==$request->montenvoi_code) {
                    if ($request->id_devise==1) {
                        $montdollars+=$request->montenvoi+$request->pourc;
                        $montcdf-=$request->montenvoi+$request->pourc;
                    }
                    else {
                        $montdollars-=$request->montenvoi+$request->pourc;
                        $montcdf+=$request->montenvoi+$request->pourc;
                    }
                    $resultat=tbl_depot::whereId($request->id_code)->first();
                    if ($resultat) {
                        $resultat->id_ville=$request->ville;
                        $resultat->nomben=$request->ben;
                        $resultat->telclient=$request->telben;
                        $resultat->id_devise=$request->id_devise;
                        $resultat->save();
                    }
                    $update=tbl_agence::whereNumagence($request->agence)->update(['Montcdf'=>$montcdf,'Montusd'=>$montdollars]);
                    return response()->json(['success'=>'operation reussie']); 
                } elseif ($request->montenvoi > $request->montenvoi_code) {
                    $taux=0;
                    $pourc=0.0;
                    $devise=tbl_devise::whereId($request->id_devise)->first();
                    if ($devise) {
                        $taux=$devise->taux;
                    }
                    $pourc=$request->montenvoi * $taux/ 100;
                    $montantanc=$request->montenvoi_code + $request->pourc;
                    $montantnouv=$request->montenvoi+$pourc;
                    if ($request->id_devise==1) {
                        $montcdf-=$montantanc;
                        $montdollars+=$montantnouv;
                     }
                     else{
                        $montcdf+=$montantnouv;
                        $montdollars-=$montantanc;
                     }
                     $resultat=tbl_depot::whereId($request->id_code)->first();
                     if ($resultat) {
                         $resultat->id_ville=$request->ville;
                         $resultat->nomben=$request->ben;
                         $resultat->telclient=$request->telben;
                         $resultat->montenvoi=$request->montenvoi;
                         $resultat->id_devise=$request->id_devise;
                         $resultat->montpour=$pourc;
                         $resultat->save();
                     }
                     $update=tbl_agence::whereNumagence($request->agence)->update(['Montcdf'=>$montcdf,'Montusd'=>$montdollars]);
                     return response()->json(['success'=>'operation reussie']);
                }
                else{
                    $taux=0;
                    $pourc=0.0;
                    $devise=tbl_devise::whereId($request->id_devise)->first();
                    if ($devise) {
                        $taux=$devise->taux;
                    }
                    $pourc=$request->montenvoi * $taux/ 100;
                    $montantanc=$request->montenvoi_code + $request->pourc;
                    $montantnouv=$request->montenvoi+$pourc;
                    if ($request->id_devise==1) {
                        $montdollars+=$montantnouv;
                        $montcdf-=$montantanc;
                     }
                     else{
                        $montcdf+=$montantnouv;
                        $montdollars-=$montantanc;
                     }
                     $resultat=tbl_depot::whereId($request->id_code)->first();
                     if ($resultat) {
                         $resultat->id_ville=$request->ville;
                         $resultat->nomben=$request->ben;
                         $resultat->telclient=$request->telben;
                         $resultat->montenvoi=$request->montenvoi;
                         $resultat->id_devise=$request->id_devise;
                         $resultat->montpour=$pourc;
                         $resultat->save();
                     }
                     $update=tbl_agence::whereNumagence($request->agence)->update(['Montcdf'=>$montcdf,'Montusd'=>$montdollars]);
                     return response()->json(['success'=>'operation reussie']);
                }
            }
       
    }
}

     public function get_rapportG($d,$f)
    {
        $resultat=DB::table('tbl_clotures',)->join('tbl_agences','tbl_clotures.numagence','=','tbl_agences.numagence')
        ->whereBetween('created_at', [$d,$f])
        ->select('totalentreusd','departcdf','nomagence','pourcentageusd','pourcentagecdf','created_at','totalentrecdf','nvdepartusd','nvdepartcdf','departusd','departcdf')
        ->get();
        return response()->json(['data'=>$resultat]); 
    }
    
    
    public function partenaire_trans(){
        if (Auth::check()) {
            $this->entete();
            $date = date('Y-m-d');
           $banques = DB::table('tbl_transfert_banques', 'tbl_transfert_banque')->join('tbl_partenaires', 'tbl_partenaires.id_partenaire', '=', 'tbl_transfert_banque.id_partenaire')
            ->select(DB::raw('SUM(montant) as montants'),'tbl_transfert_banque.id_partenaire', 'id_devise', 'operation', 'date_T', 'type')
            ->where('date_T', '=', $date)
           ->groupBy('tbl_transfert_banque.id_partenaire','operation', 'id_devise', 'date_T', 'type' )
           ->get();


           $retraitusd = DB::table('tbl_transfert_banques')->where('operation', 2)->where('id_devise', 1)->where('date_T', date('Y-m-d'))->where('id_partenaire', 1)->sum('montant');
           $depotusd = DB::table('tbl_transfert_banques')->where('operation', 1)->where('id_devise', 1)->where('date_T', date('Y-m-d'))->where('id_partenaire', 1)->sum('montant');

           $retraitcdf = DB::table('tbl_transfert_banques')->where('operation', 2)->where('id_devise', 2)->where('date_T', date('Y-m-d'))->where('id_partenaire', 1)->sum('montant');
           $depotcdf = DB::table('tbl_transfert_banques')->where('operation', 1)->where('id_devise', 2)->where('date_T', date('Y-m-d'))->where('id_partenaire', 1)->sum('montant');
           $totusdEquity = $depotusd - $retraitusd;
           $totcdfEquity = $retraitcdf - $depotcdf;
           //Acess banque
           $retraitusdA = DB::table('tbl_transfert_banques')->where('operation', 2)->where('id_devise', 1)->where('date_T', date('Y-m-d'))->where('id_partenaire', 7)->sum('montant');
           $depotusdA = DB::table('tbl_transfert_banques')->where('operation', 1)->where('id_devise', 1)->where('date_T', date('Y-m-d'))->where('id_partenaire', 7)->sum('montant');

           $retraitcdfA = DB::table('tbl_transfert_banques')->where('operation', 2)->where('id_devise', 2)->where('date_T', date('Y-m-d'))->where('id_partenaire', 7)->sum('montant');
           $depotcdfA = DB::table('tbl_transfert_banques')->where('operation', 1)->where('id_devise', 2)->where('date_T', date('Y-m-d'))->where('id_partenaire', 7)->sum('montant');
           $totusdAcess = $depotusdA - $retraitusdA;
           $totcdfAcess = $retraitcdfA - $depotcdfA;
           return view('view_cloture_partenaire', compact('banques', 'totusdEquity', 'totcdfEquity', 'totusdAcess', 'totcdfAcess'));
        }
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

public function check_clotures(Request $request){
     
            

          $departNcdf=0.0;
            $departNusd=0.0;
            $totalentreUsd=0.0;
            $totalentreCdf=0.0;
            $pourcUsd=0.0;
            $PourcCdf=0.0;
            $totalsortieUsd=0.0;
            $totalsortieCdf=0.0;
            $totalongusd=0.0;
            $totalongcdf=0.0;
            $totalsongusd=0.0;
            $totalsongcdf=0.0;
            $totalsortieusd=0.0;
            $totalsortiecdf=0.0;
            $totaleusd=0.0;
            $totalecdf=0.0;
            $totalsusd=0.0;
            $totalscdf=0.0;
            $bankEusd=0.0;
            $bankEcdf=0.0;
            $bankSusd=0.0;
            $bankScdf=0.0;

           

                $requettebank=DB::table('tbl_mvtbanques')->where('numagence','=',$request->numagence)
                ->where('created_at','=',$this->date->format('Y-m-d'))
                ->select(DB::raw('SUM(Montmvt) as Montantmvt'),'devise')
                ->groupBy('devise')
                ->get();
                    foreach ($requettebank as $ligne_bank) {
                    if ($ligne_bank->devise==1) {
                    $bankSusd=$ligne_bank->Montantmvt;
                    }
                    else{
                    $bankScdf=$ligne_bank->Montantmvt;
                    }
                    }

                    $requettebank1=DB::table('tbl_mvtbanques')->where('tbl_mvtbanques.prov_ag','=',$this->agence1)
                    ->where('updated_at','=',$this->date->format('Y-m-d'))
                    ->select(DB::raw('SUM(Montmvt) as Montantmvt'),'devise')
                    ->groupBy('devise')
                    ->get();
                    foreach ($requettebank1 as $ligne_bank1) {
                    if ($ligne_bank1->devise==1) {
                        $bankEusd=$ligne_bank1->Montantmvt;
                    }
                    else{
                        $bankEcdf=$ligne_bank1->Montantmvt;
                    }
                    }
            $nouvdepart=DB::table('tbl_agences')->where('numagence','=', $request->numagence)
                                        ->select(DB::raw('SUM(Montcdf) as montcdf'),DB::raw('SUM(Montusd) as montantusd'))
                                        ->first();
                                        if ($nouvdepart) {
                                            $departNcdf=$nouvdepart->montcdf;
                                            $departNusd=$nouvdepart->montantusd;
                                        }

        $entree=DB::table('tbl_depots')->where('numagence','=', $request->numagence)
                                       ->where('created_at','=',$this->date->format('Y-m-d'))
                                       ->select(DB::raw('SUM(montenvoi) as montant'),DB::raw('SUM(montpour) as montpour'),'id_devise')
                                       ->groupBy('id_devise')
                                       ->get();
            foreach ($entree as $ligne_entree) {
                if ($ligne_entree->id_devise==1) {
                    $totalentreUsd=$ligne_entree->montant;
                    $pourcUsd=$ligne_entree->montpour;
                }
                else{
                    $totalentreCdf=$ligne_entree->montant;
                    $PourcCdf=$ligne_entree->montpour;
                }
            }
            $sortie=DB::table('tbl_retraits')->join('tbl_depots','tbl_retraits.id_depot','=','tbl_depots.numdepot')
                                             ->where('tbl_retraits.numagence','=',$request->numagence)
                                             ->where('tbl_retraits.date_servis','=',$this->date->format('Y-m-d'))
                                             ->select(DB::raw('SUM(montenvoi) as montant'),'tbl_depots.id_devise')
                                             ->groupBy('tbl_depots.id_devise')
                                             ->get();
                    foreach ($sortie as $ligne_sortie) {
                    if ($ligne_sortie->id_devise==1) {
                        $totalsortieUsd+=$ligne_sortie->montant; 
                    }
                    else{
                        $totalsortieCdf+=$ligne_sortie->montant;
                    }
                    }
              $requette=DB::table('tbl_transfert_banques')->
              where('numagence','=',$request->numagence)
                                                          ->where('date_T','=',$this->date->format('Y-m-d'))
                                                          ->select(DB::raw('SUM(montant) as mont'),'operation','id_devise')
                                                          ->groupBy('operation','id_devise')
                                                          ->get();
               
              foreach ($requette as $ligne_requette) {
                 if ($ligne_requette->operation=='1' && $ligne_requette->id_devise==1) {
                    $totaleusd=$ligne_requette->mont;
                 }
                 elseif ($ligne_requette->operation=='1' && $ligne_requette->id_devise==2) {
                    $totalecdf=$ligne_requette->mont;
                 }
                 elseif ($ligne_requette->operation=='2' && $ligne_requette->id_devise==1) {
                    $totalsusd=$ligne_requette->mont;
                 }
                 else{
                    $totalscdf=$ligne_requette->mont;
                 }
              }

              $requetdepense=DB::table('tbl_depenses')->where('numagence','=',$request->numagence)
              ->where('created_at','=',$this->date->format('Y-m-d'))
              ->select(DB::raw('SUM(montant) as montantdep'),'devise')
              ->groupBy('devise')
              ->get();


              $requet=DB::table('tbl_transfert_ongs')->where('prov','=',$request->numagence)
                    ->where('type','=','1')
                    ->where('created_at','=',$this->date->format('Y-m-d'))
                    ->select(DB::raw('SUM(mont_trans) as monttrans'),DB::raw('SUM(mont_com) as montpour'),DB::raw('SUM(mont_dep) as deplac'),'devise')
                    ->groupBy('devise')
                    ->get();

                    $requetong=DB::table('tbl_paiements','paiement')->join('tbl_detail_ts','paiement.code_detail','=','tbl_detail_ts.id')
                    ->join('tbl_agences','tbl_detail_ts.numagence','=','tbl_agences.numagence')
                    ->join('tbl_transfert_ongs','tbl_detail_ts.id_transf','=','tbl_transfert_ongs.id')
                    ->select(DB::raw('SUM(Montpay) as mont'),'tbl_detail_ts.numagence','paiement.created_at','devise')
                    ->where('paiement.created_at','=',$this->date->format('Y-m-d'))
                    ->where('tbl_detail_ts.numagence','=',$request->numagence)
                    ->groupBy('paiement.code_detail','tbl_detail_ts.numagence','devise','paiement.created_at')
                    ->get();

                    foreach ($requet as $ligne_requet) {
                        if ($ligne_requet->devise=='1') {
                            $totalongusd=$ligne_requet->montpour + $ligne_requet->monttrans + $ligne_requet->deplac;
                        }else{
                            $totalongcdf =$ligne_requet->montpour + $ligne_requet->monttrans + $ligne_requet->deplac;
                        }
                    }
                    
          
//___________________________________cloture depense_______________________________
                    foreach ($requetdepense as $depense) {
                        if ($depense->devise=='1') {
                            $totalsortieusd=$depense->montantdep;
                        }else{
                            $totalsortiecdf=$depense->montantdep;
                        }
                    }

                    foreach ($requetong as $ligne_requetong) {
                        if ($ligne_requetong->devise=='1') {
                            $totalsongusd=$ligne_requetong->mont;
                        }else{
                            $totalsongcdf =$ligne_requetong->mont;
                        }
                    }
                  
                    $ancfranc=($departNcdf+$totalsortieCdf+$totalscdf + $totalsongcdf + $totalsortiecdf+$bankScdf)-($totalentreCdf+$PourcCdf+$totalecdf+$totalongcdf+$bankEcdf);
                    $ancdollars=($departNusd+$totalsongusd+$totalsortieUsd+$totalsusd + $totalsortieusd+$bankSusd)-($totalentreUsd+$pourcUsd+$totaleusd+$totalongusd+$bankEusd);
            
            $data=['nouvdepartusd'=> $departNusd,
                   'nouvdepartcdf'=> $departNcdf,
                   'totalentreusd'=> $totalentreUsd,
                   'totalentrecdf'=> $totalentreCdf,
                   'pourusd'=> $pourcUsd,
                   'pourcdf'=>  $PourcCdf,
                   'totalsortiusd'=> $totalsortieUsd,
                   'totalsorticdf'=> $totalsortieCdf,
                   'ancdepartUsd'=> $ancdollars,
                   'ancdepartCdf'=> $ancfranc,
                   'totaleusd'=> $totaleusd,
                   'totalecdf'=> $totalecdf,
                   'totalsusd'=> $totalsusd,
                   'totalscdf'=> $totalscdf,
                   'totalEOngusd'=> $totalongusd,
                   'totalEOngcdf'=> $totalongcdf,
                   'totalSONGusd'=> $totalsongusd,
                   'totalSONGcdf'=> $totalsongcdf,
                   'totaldepusd'=> $totalsortieusd,
                   'totaldepcdf'=> $totalsortiecdf,

                   'sortiebankusd'=> $bankSusd,
                   'sortiebankcdf'=> $bankScdf,
                   'entrebankusd'=> $bankEusd,
                   'entrebankcdf'=> $bankEcdf,
                  ];                           
        
                 return response()->json(['data'=>$data]);
    
    }
    
}
