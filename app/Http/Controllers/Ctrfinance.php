<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ctradmin;
use App\Http\Controllers\CtrTransfert;
use App\Http\Controllers\Ctrpersonnel;
use Illuminate\Support\Facades\Auth;
use App\Models\tbl_banque;
use App\Models\tbl_agence;
use App\Models\tbl_typedepense;
use App\Models\tbl_depense;
use App\Models\tbl_vile;
use App\Models\tbl_devise;
use App\Models\tbl_autorisation;
use App\Models\tbl_mvtbanque;
use DB;
use DateTime;

class Ctrfinance extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $date;
    public function index_banque()
    {
        if (Auth::check()) {
            $this->entete();
            return view('view_banque');
        }
        
    }
    public function __construct(){
        $this->date= new DateTime();
        
    }

    public function index_transfert()
    {
        if (Auth::check()) {
            $this->entete();
            $resultat=tbl_banque::all();
            return view('view_transfert',compact('resultat'));
        }
        
    }
    public function index_repartition()
    {
        if (Auth::check()) {
            $this->entete();
           $resultat=tbl_agence::all();
        return view("view_repartition",compact('resultat'));
        }  
    }

    public function index_mvtbanque()
    {
        if (Auth::check()) {
           $this->entete();
           $resul_ag=tbl_agence::all();
           $resul_bank=tbl_banque::all();
        return view("view_mvtbanque",compact('resul_ag','resul_bank'));
        // $data=DB::table('tbl_mvtbanques')->where('tbl_mvtbanques.etatmvt','=',0)
        // ->orderBy('id','DESC')
        // ->select('id','id_type','Montmvt','etatmvt','detail_prov','detail_des','devise','created_at')
        // ->get();
        // dd($data);
        }  
    }

    public function index_depense()
    {
        if (Auth::check()) {
            $this->entete();
             $typedep= tbl_typedepense::all();
              $auto= tbl_autorisation::all();
             $don=DB::table('tbl_affectations')->join('tbl_agences','tbl_affectations.numagence','=','tbl_agences.numagence')
            ->where('tbl_affectations.matricule','=',Auth::user()->matricule)
            ->where('tbl_affectations.statut','=','1')
            ->orderBy('id','DESC')
            ->select('tbl_affectations.numagence','tbl_agences.nomagence')->get();
            return view('view_depense',compact('don','typedep','auto'));

        }
        
    }

     public function index_confirmationdep()
    {
        if (Auth::check()) {
            $this->entete();
            $agence=$this->get_agence();
            return view('view_confirmationdepense',compact('agence'));
        }
        
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

    public function entete(){
        $affichage= new ctradmin;
        return $affichage->index_entete();
    }
    public function historique($matricule,$operation){
        $resultat=new Ctrpersonnel;
        return $resultat->historisation($matricule,$operation);
    }

    public function get_list_banque()
    {

        $resultat=tbl_banque::orderBy('id','DESC')
                                      ->get(); 
           return response()->json(['data'=>$resultat]);
    }
     public function get_agence(){
        $affichage= new CtrTransfert;
        return $affichage->recu_agence();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_banque(Request $request)
    {
        if ($request->ajax()) {
            $table=tbl_banque::whereNumero_compte($request->numero_compte)->first();
            if (!$table) {
                $record= new tbl_banque;
                $record->numero_compte=$request->numero_compte;
                $record->intitulecompte=$request->intitulecompte;
                $record->Montant=$request->Montant;
                $record->devise=$request->devise;
                $record->save();
                $operation='Insertion de compte bancaire'.$request->numero_compte.' au montant de '.$request->Montant;
                $this->historique(Auth::user()->matricule,$operation);
                return response()->json(['success'=>'1']);
            }  
            else{
                return response()->json(['success'=>'0']);
            }
        } 
    }

   public function store_mvtbanque(Request $request)
    {
        if ($request->ajax()) {
            $name_agence='';
            $montantdollars=0.0;
            $montantcdf=0.0;
            $operation='';
                if ($request->indice==1 || $request->indice==2) {
                    $montant=0.0;
                    $requette=tbl_agence::whereNumagence($request->prov)->first();
                    if ($requette) {
                        $montantdollars=$requette->Montusd;
                        $montantcdf=$requette->Montcdf;
                        $name_agence=$requette->nomagence;
                            if ($request->devise==1) {
                                if ($request->montant >$montantdollars) {
                                    return response()->json(['success'=>'le montant est insuffisant']);
                                    
                                    }
                                    $montantdollars-=$request->montant;
                                $operation="Sortie banque du montant ".$request->montant." Usd dans l'agence".$name_agence;
                            }
                            else{

                                if ($request->montant > $montantcdf) {
                                    return response()->json(['success'=>'le montant est insuffisant']);
                                    
                                }
                                $montantcdf-=$request->montant;
                                $operation="Sortie banque du montant ".$request->montant." Cdf dans l'agence".$name_agence;
                            }

                            if ($request->indice==1) {
                                $req=tbl_mvtbanque::create(['Montmvt'=>$request->montant,'id_type'=>$request->indice,'matricule'=>Auth::user()->matricule,'id_banque'=>0,'numagence'=>$request->prov,
                                'observation'=>$request->motif,'etatmvt'=>0,'prov_banq'=>0,'prov_ag'=>$request->desti,'devise'=>$request->devise,'created_at'=>$this->date->format('Y-m-d'),
                                'detail_prov'=>$request->det_prov,'detail_des'=>$request->det_desti]);
                                $requet=tbl_agence::whereNumagence($request->prov)->update(['Montcdf'=>$montantcdf,'Montusd'=>$montantdollars]);
                                $this->historique(Auth::user()->matricule,$operation);
                                return response()->json(['success'=>'1']);
                            }
                            else{
                                $req=tbl_mvtbanque::create(['Montmvt'=>$request->montant,'id_type'=>$request->indice,'matricule'=>Auth::user()->matricule,'id_banque'=>0,'numagence'=>$request->prov,
                                'observation'=>$request->motif,'etatmvt'=>0,'prov_banq'=>$request->desti,'prov_ag'=>0,'devise'=>$request->devise,'created_at'=>$this->date->format('Y-m-d'),
                                'detail_prov'=>$request->det_prov,'detail_des'=>$request->det_desti]);
                                $requet=tbl_agence::whereNumagence($request->prov)->update(['Montcdf'=>$montantcdf,'Montusd'=>$montantdollars]);
                                $this->historique(Auth::user()->matricule,$operation);
                                return response()->json(['success'=>'1']);
                            }
                            
                            
                      }

                }
                else{
                    $resu=tbl_banque::where('id','=',$request->prov)->first();
                    if ($resu->Montant!=0.0) {
                        if ($resu->Montant > $request->montant) {
                            if($resu->devise==$request->devise){
                                $resu->decrement('Montant',$request->montant); 
                                $req=tbl_mvtbanque::create(['Montmvt'=>$request->montant,'id_type'=>$request->indice,'matricule'=>Auth::user()->matricule,'id_banque'=>$request->prov,'numagence'=>0,
                                'observation'=>$request->motif,'etatmvt'=>0,'prov_banq'=>$request->desti,'prov_ag'=>$request->desti,'devise'=>$request->devise,'created_at'=>$this->date->format('Y-m-d'),
                                'detail_prov'=>$request->det_prov,'detail_des'=>$request->det_desti]);
                                $operation="Sortie Banque dans le compte ".$resu->intitulecompte. " du montant ".$request->montant;
                                $this->historique(Auth::user()->matricule,$operation);
                                return response()->json(['success'=>'1']);
                         
                            }
                            else{
                                return response()->json(['success'=>'incorrect dans le type de compte']);
                                exit();
                            }
                        }
                        else{
                            return response()->json(['success'=>'le montant est insuffisant']); 
                            exit();
                        }
                       }
                }
            
                
        } 
    }

    public function get_list_mvt()
    {

        $data=DB::table('tbl_mvtbanques')->orderBy('id','DESC')
                                         ->select('id','id_type','Montmvt','etatmvt','detail_prov','detail_des','devise','created_at')
                                         ->get();
                                         return response()->json(['data'=>$data]);

    }

    public function update_mvt(Request $request)
    {
        if ($request->ajax()) {
            $montantdolars=0.0; 
            $montantcdf=0.0;
            $name_agence='';
            $operation='';
            $data=tbl_mvtbanque::whereId($request->id_mvt)->first();
            if ($data) {
                $data->etatmvt=1;
                $data->updated_at=$this->date->format('Y-m-d');
                $data->save();
                           if($data->id_type==1 || $data->id_type==3){
                               $select=tbl_agence::whereNumagence($data->prov_ag)->first();
                                if ($select) {
                                    $montantdolars=$select->Montusd;
                                    $montantcdf=$select->Montcdf;
                                    $name_agence=$select->nomagence;  
                                    if ($data->devise==2) {
                                        $montantcdf+= $data->Montmvt;
                                        $operation='Entrée banque du montant de '.$data->Montmvt."Cdf dans l'agence ".$name_agence;    
                                      }
                                      else{
                                        $montantdolars += $data->Montmvt; 
                                        $operation='Entrée banque du montant de '.$data->Montmvt."Usd dans l'agence ".$name_agence; 
                                      }  
                                }
                                $update=tbl_agence::whereNumagence($data->prov_ag)->update(['Montcdf'=>$montantcdf,'Montusd'=>$montantdolars]);
                                $this->historique(Auth::user()->matricule,$operation); 
                                return response()->json(['success'=>'1']); 
                                  
                           }
                           else{
                            $select=tbl_banque::where('id','=',$data->prov_banq)->first();
                            if ($select) {
                                $select->Montant +=$data->Montmvt;
                                $select->save();
                                $operation='Entrée banque du montant de '.$data->Montmvt." dans le numero de compte ".$select->numero_compte;
                                $this->historique(Auth::user()->matricule,$operation); 
                                return response()->json(['success'=>'1']);  
                            }
                           }

              }
            }
    }

    public function update_banque(Request $request)
    {
        if ($request->ajax()) {
           
            $resultat=tbl_banque::whereId($request->id)->update(['numero_compte'=>$request->numero_compte,'intitulecompte'=>$request->intitulecompte,'Montant'=>$request->Montant,'devise'=>$request->devise]);
            return response()->json(['success'=>'1']);   
        } 
    }

    public function transfert(Request $request)
    {
        if ($request->ajax()) {
            $operation='';
            $compte_dest='';
            if(Auth::attempt(['email' =>$request->username,'password' =>$request->password])){
                $indice=0;
                $resultat=tbl_banque::where('id','=',$request->prov)->first();
                                if ($resultat->Montant!=0.0) {
                                    if ($resultat->Montant > $request->montant) {
                                        if($resultat->devise==$request->devise){
                                            $student_marks = tbl_banque::where('id','=',$request->desti)->first();
                                            if ($student_marks) {
                                                if($student_marks->devise==$resultat->devise){
                                                    $student_marks->Montant += $request->montant;
                                                    $compte_dest=$student_marks->numero_compte; 
                                                    $student_marks->save();
                                                }
                                                else {
                                                    return response()->json(['success'=>'le deux compte doivent avoir la meme devise']);
                                                }    
                                            }
                                                $resultat->decrement('Montant',$request->montant); 
                                                $operation="Transfert du compte ".$resultat->numero_compte." au montant ".$request->montant;
                                                $operation.=" vers le compte ".$compte_dest;         
                                                $this->historique(Auth::user()->matricule,$operation); 
                                           
                                             }
                                            else{
                                                return response()->json(['success'=>'le deux compte doivent avoir la meme devise']);   
                                            }
                                    }
                                    else{
                                        return response()->json(['success'=>'le montant est insuffisant']); 
                                        
                                    }
                        }
                        else{
                            return response()->json(['success'=>'ce compte est à 0']);
                        }
            }
            else{
                return response()->json(['success'=>"ce compte n'existe pas"]);
            }          
        } 
    }

    
    public function update_repartition(Request $request)
    { 
       if ($request->ajax()) {
            $resultat=tbl_agence::whereNumagence($request->numagence)->update(['Montcdf'=>$request->Montcdf,'Montusd'=>$request->Montusd]);
            return response()->json(['success'=>'1']);   
        } 
    }

    public function get_id_banque(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_banque::whereId($request->code)->first();
            return response()->json($resultat); 
        }
    }
   public function store_depense(Request $request )
    {
      if ($request->ajax()) {
            $Montantusd=0.0;
            $Montantcdf=0.0;
            $requette2=tbl_agence::whereNumagence($request->numagence)->first();
            if ($requette2) {
                $Montantusd=$requette2->Montusd;
                $Montantcdf=$requette2->Montcdf;
            }
                if ($request->devise=='1') {
                    if ($Montantusd >=$request->montant) {
                        $resultat=tbl_depense::create([
                            'motif'=>$request->motif,
                            'devise'=>$request->devise,
                            'etat'=>'1',
                            'montant'=>$request->montant,
                            'id_typdep'=>$request->id_typdep,
                            'id_auto'=>$request->id_auto,
                            'matricule'=>Auth::user()->matricule,
                            'numagence'=>$request->numagence,
                            'created_at'=>$this->date->format('Y-m-d'),
                        ]);
                        $Montantusd-= $request->montant;
                        $requet=tbl_agence::whereNumagence($request->numagence)->update(['Montusd'=>$Montantusd]);
                        return response()->json(['success'=>'1']);
                    }
                    else {
                        return response()->json(['success'=>'votre espece dollars est insuffisant pour effectuer cette depense']);
                    }
                }
                else {
                    if ($Montantcdf >=$request->montant) {
                        $resultat=tbl_depense::create([
                            'motif'=>$request->motif,
                            'devise'=>$request->devise,
                            'etat'=>'1',
                            'montant'=>$request->montant,
                            'id_typdep'=>$request->id_typdep,
                            'id_auto'=>$request->id_auto,
                            'matricule'=>Auth::user()->matricule,
                            'numagence'=>$request->numagence,
                            'created_at'=>$this->date->format('Y-m-d'),
                        ]);
                        $Montantcdf-= $request->montant;
                        $requet=tbl_agence::whereNumagence($request->numagence)->update(['Montcdf'=>$Montantcdf]);
                        return response()->json(['success'=>'1']);
                    }
                    else {
                        return response()->json(['success'=>'votre espece franc est insuffisant pour effectuer cette depense']);
                    }
                }
            
        }

         }




    public function get_id_depense(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_depense::whereId_dep($request->code)->update(['etat'=>$request->etat]);
            return response()->json(['success'=>'etat modifié']); 
        }
    }

   public function get_id_depense1(Request $request)
    {
        if ($request->ajax()) {
             $resultat=tbl_depense::whereId_dep($request->code)->first();
            return response()->json($resultat); 
           
        }
    }

      public function   get_list_depense($code)
    {

        $resultat=DB::table('tbl_depenses')->join('tbl_agences','tbl_depenses.numagence','=','tbl_agences.numagence')
        ->where('tbl_depenses.numagence','=',$code)
        ->select('id_dep','motif','devise','etat','montant','id_typdep','id_auto','matricule','nomagence','created_at')
        ->orderBy('created_at','DESC')->get(); 
           return response()->json(['data'=>$resultat]);
    }


     public function update_depense(Request $request)
    { 
       if ($request->ajax()) {
            $resultat=tbl_depense::whereId_dep($request->id_dep)->update(['motif'=>$request->motif,'id_typdep'=>$request->id_typdep,'id_auto'=>$request->id_auto]);
            return response()->json(['success'=>'1']);   
        } 
     
    }
    public function get_confirmation($dbut,$dfin){

        $resultat=DB::table('tbl_depenses')->join('tbl_agences','tbl_depenses.numagence','=','tbl_agences.numagence')
                                           ->join('tbl_typedepenses','tbl_depenses.id_typdep','=','tbl_typedepenses.id_typdep')
        ->whereBetween('tbl_depenses.created_at', [$dbut,$dfin])
        ->select('id_dep','motif','devise','etat','montant','type_dep','id_auto','matricule','nomagence','created_at')
        ->orderBy('tbl_depenses.numagence','ASC')->get(); 
        return response()->json(['data'=>$resultat]);
    }

    public function update_depense_mod(Request $request){
        if ($request->ajax()) {
            $Montantusd=0.0;
            $Montantcdf=0.0;
            $requette2=tbl_agence::whereNumagence($request->agence)->first();
            if ($requette2) {
                $Montantusd=$requette2->Montusd;
                $Montantcdf=$requette2->Montcdf;
            }

            if ($request->devise==$request->code_devise) {
                if ($request->montant > $request->code_montant) {
                    $difference=$request->montant-$request->code_montant;
                    $resultat=tbl_depense::whereId_dep($request->id_dep)->update(['montant'=>$request->montant]);
                    if ($request->devise=='1') {
                        $Montantusd-=$difference;
                        $requette=tbl_agence::whereNumagence($request->agence)->update(['Montusd'=>$Montantusd]);
                        return response()->json(['success'=>'1']);

                    }
                    else {
                        $Montantcdf-=$difference;
                        $requette=tbl_agence::whereNumagence($request->agence)->update(['Montcdf'=>$Montantcdf]);
                        return response()->json(['success'=>'1']);

                    }   
                } elseif($request->montant < $request->code_montant) {
                    $difference=$request->code_montant-$request->montant;
                    $resultat=tbl_depense::whereId_dep($request->id_dep)->update(['montant'=>$request->montant]);
                    if ($request->devise=='1') {
                        $Montantusd+=$difference;
                        $requette=tbl_agence::whereNumagence($request->agence)->update(['Montusd'=>$Montantusd]);
                        return response()->json(['success'=>'1']);

                    }
                    else {
                        $Montantcdf+=$difference;
                        $requette=tbl_agence::whereNumagence($request->agence)->update(['Montcdf'=>$Montantcdf]);
                        return response()->json(['success'=>'1']);

                    }
                }
                
            }
            else {
                if ($request->montant==$request->code_montant) {
                    $resultat=tbl_depense::whereId_dep($request->id_dep)->update(['devise'=>$request->devise]);
                    if ($request->devise=='1') {
                        $Montantusd-=$request->montant;
                        $Montantcdf+=$request->montant;
                    } else {
                        $Montantusd+=$request->montant;
                        $Montantcdf-=$request->montant;
                    }
                    $requette=tbl_agence::whereNumagence($request->agence)->update(['Montcdf'=>$Montantcdf,'Montusd'=>$Montantusd]);
                    return response()->json(['success'=>'1']);

                   
                } elseif($request->montant > $request->code_montant) {
                    $resultat=tbl_depense::whereId_dep($request->id_dep)->update(['devise'=>$request->devise,'montant'=>$request->montant]);

                    if ($request->devise=='1') {
                        $Montantusd-=$request->montant;
                        $Montantcdf+=$request->code_montant;
                    } else {
                        $Montantusd+=$request->code_montant;
                        $Montantcdf-=$request->montant;
                    }
                    $requette=tbl_agence::whereNumagence($request->agence)->update(['Montcdf'=>$Montantcdf,'Montusd'=>$Montantusd]);
                    return response()->json(['success'=>'1']);
                   
                }
                else {
                    $difference=$request->code_montant-$request->montant;
                    $resultat=tbl_depense::whereId_dep($request->id_dep)->update(['devise'=>$request->devise,'montant'=>$request->montant]);
                    if ($request->devise=='1') {
                        $Montantusd-=$request->montant;
                        $Montantcdf+=$request->code_montant;
                    } else {
                        $Montantusd+=$request->code_montant;
                        $Montantcdf-=$request->montant;
                    }
                    $requette=tbl_agence::whereNumagence($request->agence)->update(['Montcdf'=>$Montantcdf,'Montusd'=>$Montantusd]);
                    return response()->json(['success'=>'1']);
                }
                
            }
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy_banque(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_banque::whereId($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }

    public function destroy_depense(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_depense::whereId_dep($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }
   
}
