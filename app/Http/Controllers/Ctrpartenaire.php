<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_personnel;
use App\Models\user;
use App\Models\tbl_menu;
use App\Models\tbl_partenaire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
use Illuminate\Support\Facades\View;


class Ctrpartenaire extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 public function index_partenaire()
{
    if (Auth::check()) {
            $this->entete();
        //     $m = Auth::user()->matricule;
        //     $agence = DB::select("SELECT * FROM tbl_affectations, tbl_agences WHERE tbl_affectations.matricule = '$m' AND tbl_affectations.numagence = tbl_agences.numagence ");
        //     $banque = DB::select("SELECT * FROM tbl_partenaires");
        //     $devise = DB::select("SELECT * FROM tbl_devises");
        //     $affichage = DB::select("SELECT * FROM tbl_agences, tbl_transfert_banques WHERE  tbl_agences.numagence = tbl_transfert_banques.numagence ");
        //    return view('view_partenaire', compact('affichage','agence', 'banque', 'devise'));
        }        
}

 public function index_entete()
 {
    $donnees = DB::table('tbl_droitacces','tbl_droit')->join('tbl_sous_menus','tbl_droit.id_sous','=','tbl_sous_menus.id_sous')
          ->join('tbl_menus','tbl_sous_menus.id_menu','=','tbl_menus.id_menu')
             ->where('tbl_droit.id_fonction', '=', Session::get('fonction'))
             ->orderBy('tbl_sous_menus.id_menu','DESC')
             ->select('item_sous', 'lien','item_menu','icon','tbl_sous_menus.id_menu')
             ->get();
             return View::share('donnees',$donnees);                
 }

    public function __construct(){
       $this->middleware('auth'); 
    }

     public function entete(){
        $affichage= new ctradmin;
        return $affichage->index_entete();
    }
public function index_partenaire_trans(){
        if (Auth::check()) {
            $this->entete();
            $m = Auth::user()->matricule;
            $agence = DB::select("SELECT * FROM tbl_affectations, tbl_agences WHERE tbl_affectations.matricule = '$m' AND tbl_affectations.numagence = tbl_agences.numagence ");
            $banque = DB::select("SELECT * FROM tbl_partenaires");
            $devise = DB::select("SELECT * FROM tbl_devises");
            $affichage = DB::select("SELECT * FROM tbl_agences, tbl_transfert_banques WHERE  tbl_agences.numagence = tbl_transfert_banques.numagence ");
           return view('view_partenaire_transfert', compact('affichage','agence', 'banque', 'devise'));
        }
    }
    public function transfert_banque_insert(Request $request){
     
      if ($request->ajax()) {
               if($request->devise == 2){
                if ($request->operation  == '1') {
                    $ajout = tbl_transfert_banque::create([
                        'numagence' => $request->agence,
                        'banque' => $request->partenaire,
                        'devise' => $request->devise,
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
                }elseif ($request->operation  == '2') {
                    $ajout = tbl_transfert_banque::create([
                        'numagence' => $request->agence,
                        'banque' => $request->partenaire,
                        'devise' => $request->devise,
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
                }
            }elseif ($request->devise == 1) {
                if ($request->operation  == '1') {
                    $ajout = tbl_transfert_banque::create([
                        'numagence' => $request->agence,
                        'banque' => $request->partenaire,
                        'devise' => $request->devise,
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
                }elseif ($request->operation  == '2') {
                    $ajout = tbl_transfert_banque::create([
                        'numagence' => $request->agence,
                        'banque' => $request->partenaire,
                        'devise' => $request->devise,
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
                }
            }
            return response()->json(['success'=>'1']);     
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



    public function destroy( Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_partenaire::whereId_partenaire($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
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