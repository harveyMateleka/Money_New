<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_personnel;
use App\Models\user;
use App\Models\tbl_menu;
use App\Models\tbl_partenaire;
use App\Models\tbl_transfert_banque;
use App\Models\tbl_devise;
use App\Models\tbl_agence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ctrTransfert;
use App\Http\Controllers\ctradmin;
use Session;
use DB;
use DateTime;
use Illuminate\Support\Facades\View;


class Ctrpartenaire extends Controller
{
    private $transfert;
    private $date;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 public function index()
{
    if (Auth::check()) {
            $this->entete();
            return view('view_partenaire');
        }
        else{
            return redirect()->route('login');
        }        
}


    public function __construct(){
        $this->transfert = new ctrTransfert;
        $this->date= new DateTime();
    }

     public function entete(){
        $affichage= new ctradmin;
        return $affichage->index_entete();
    }
public function index_partenaire_trans(){
        if (Auth::check()) {
            $this->entete();
            $data=[
                "agence"=>$this->transfert->recu_agence(),
                "banque"=>tbl_partenaire::all(),
                "devise"=>tbl_devise::all(),
            ];
           return view('view_transfert_banque',$data);
        }
        else{
            return redirect()->route('login');
        } 
        
    
    }
    public function transfert_insert(Request $request){
     
      if ($request->ajax()) {
          $tableau=[
            $request->agence,
            $request->partenaire,
            $request->devise,
            $request->montant,
            $request->operation
          ];
                if ($this->save_transfert($tableau)) {
                    return response()->json(['success'=>'1']);
                }   
         }

       }

       public function index_rapport(){
        if (Auth::check()) {
            $this->entete();
            $data=[
                "agence"=>tbl_agence::whereIndiceag(0)->orderBy("nomagence","ASC")->get(),
            ];
            
           return view('view_rapport_cash',$data);
        }
        else{
            return redirect()->route('login');
        } 
       }
            
    private function save_transfert($params=[]){
       
            $valeur=new tbl_transfert_banque;
            $valeur->numagence=$params[0];
            $valeur->id_partenaire=$params[1];
            $valeur->id_devise=$params[2];
            $valeur->montant=$params[3];
            $valeur->date_T=$this->date->format('Y-m-d');
            $valeur->matricule=Auth::user()->matricule;
            $valeur->operation=$params[4];
            $valeur->save();
            $array=array($params[0],$params[2],$params[4],$params[3]);
            $this->modify($array);
            return True;
    }

    private function modify(array $paramas){
        $requette=$this->transfert->get_montAg($paramas[0]);
        $montantd=$requette["montantD"];
        $montantc=$requette["montantC"];
        if ($paramas[1] == 2 ) {
            ($paramas[2] == '1') ? $montantc -= $paramas[3] : $montantc += $paramas[3] ;
        }
        else{
            ($paramas[2] == '1') ? $montantd -= $paramas[3] : $montantd += $paramas[3];
        }
        tbl_agence::whereNumagence($paramas[0])->update(['Montusd' =>$montantd,'Montcdf'=>$montantc]);
    }



    public function store(Request $request)
        {      
        if ($request->ajax()) {
            $table=tbl_partenaire::whereType($request->type)->first();
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

     public function update(Request $request)
    {
        if ($request->ajax()) {
            $this->validate($request,['type'=>'required']);
            $resultat=tbl_partenaire::whereId_partenaire($request->id_partenaire)->update(['type'=>$request->type]);
            return response()->json(['success'=>'1']);   
        } 
    }
       public function get_all_part()
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

    public function get_rapport_s(Request $request){

        $resultat=tbl_transfert_banque::join("tbl_partenaires","tbl_transfert_banques.id_partenaire","=","tbl_partenaires.id_partenaire")
                                        ->join("tbl_agences","tbl_transfert_banques.numagence","=","tbl_agences.numagence")
                                        ->join("tbl_devises","tbl_transfert_banques.id_devise","=","tbl_devises.id")
                                        ->where("tbl_transfert_banques.numagence","=",$request->agence)
                                        ->whereBetween("tbl_transfert_banques.date_T",[$request->debut,$request->fin])
                                        ->select("id_tranfert","date_T","nomagence","type","montant","intitule","operation")
                                        ->get();
                return response()->json(['data'=>$resultat]); 

    }



    public function destroy(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_partenaire::whereId_partenaire($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }

    public function get_liste_transfert($agence)
    {
        $resultat=tbl_transfert_banque::join("tbl_partenaires","tbl_transfert_banques.id_partenaire","=","tbl_partenaires.id_partenaire")
                                        ->join("tbl_agences","tbl_transfert_banques.numagence","=","tbl_agences.numagence")
                                        ->join("tbl_devises","tbl_transfert_banques.id_devise","=","tbl_devises.id")
                                        ->where("tbl_transfert_banques.numagence","=",$agence)
                                        ->select("id_tranfert","date_T","nomagence","type","montant","intitule","operation")
                                        ->get();
        return response()->json(['data'=>$resultat]); 

    }



 public function index_cloturecapital()
    {
        if (Auth::check()) {  
            $this->entete();
            $date= date('Y-m-d');
        
            return view('view_cloturecapital');
        }
    }


     }