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
    

    public function index_mvtbanque()
    {
        if (Auth::check()) {
           $this->entete();
           $resul_ag=tbl_agence::all();
           $resul_bank=tbl_banque::all();
        return view("view_mvtbanque",compact('resul_ag','resul_bank'));
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

        $data=DB::table('tbl_mvtbanques')->where('tbl_mvtbanques.etatmvt','=',0)
                                         ->orderBy('id','DESC')
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
    

   
   
}
