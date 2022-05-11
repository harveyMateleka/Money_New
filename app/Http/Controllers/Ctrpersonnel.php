<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_personnel;
use App\Models\tbl_agence;
use App\Models\tbl_fonction;
use App\Models\User;
use App\Models\tbl_historique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\ctradmin;
use DB;
use DateTime;
use Session;

class Ctrpersonnel extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $date;

    public function index()
    {
        if (Auth::check()) {
            $this->entete();
            $resultat=tbl_fonction::all();
            $resul=$this->generateRandomString();
            return view("view_personnel",compact('resultat','resul'));
        }
        else{
            return redirect()->route('login');
          }
    }

    public function __construct(){
        $this->date= new DateTime();
    }
    public function entete(){
        $affichage= new ctradmin;
        return $affichage->index_entete();
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
    public function historisation($matr,$operation){
        if ($matr!='' && $operation!='') {
         $insert=tbl_historique::create(['matricule'=>$matr,
                                         'operation'=>$operation,
                                         'created_at'=>$this->date->format('Y-m-d H:i:s')]);
            return 1;                             
        }   
    }
   
    
 public function get_affecter(Request $request)
     {
         if ($request->ajax()) {
             $resultat=tbl_personnel::whereMatricule($request->code)->first();
             return response()->json($resultat); 
         }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  
  
    public function get_affectation(Request $request)
    {
        $resultat=DB::table('tbl_personnels')->where('etat','=',1)
                                            ->select('matricule','nom','postnom','prenom')
                                             ->get();
        return response()->json(['data'=>$resultat]);
    }
    
    public function update_Users(Request $request)
    {
        
    }

  

    //______________________________________________personnel_____________________________________________________
    public function store(Request $request)
    {      
        if ($request->ajax()) {
            $table=tbl_personnel::whereMatricule($request->matricule)->first();
            if (!$table) {
                $record= new tbl_personnel;
                $record->matricule=$request->matricule;
                $record->nom=$request->nom;
                $record->postnom=$request->postnom;
                $record->prenom=$request->prenom;
                $record->tel=$request->tel;
                $record->adresse=$request->adresse;
                $record->etat=$request->etat;
                $record->occupation=$request->occupation;
                $record->id_fonction=$request->id_fonction;
                $record->save();
                return response()->json(['success'=>'1','data'=>$resul=$this->generateRandomString()]);
            }  
            else{
                return response()->json(['success'=>'0']);
            }
        }  
    }
    public function get_list_personnel()
    {

         $resultat = DB::table('tbl_personnels')
         ->join('tbl_fonctions', 'tbl_fonctions.id_fonction', '='
         ,'tbl_personnels.id_fonction')
          ->orderBy('matricule','DESC')
          ->select('tbl_personnels.*', 'tbl_fonctions.fonction')->get();
           return response()->json(['data'=>$resultat]);
    }

   

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $this->validate($request,['nom'=>'required']);
            $resultat=tbl_personnel::whereMatricule($request->matricule)->update(['nom'=>$request->nom,'postnom'=>$request->postnom,'prenom'=>$request->prenom,'adresse'=>$request->adresse,'tel'=>$request->tel,'id_fonction'=>$request->id_fonction,'etat'=>$request->etat,'occupation'=>$request->occupation]);
            return response()->json(['success'=>'1']);   
        } 
    }
    public function get_id_personnel(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_personnel::whereMatricule($request->code)->first();
            return response()->json($resultat); 
        }
    }

    public function destroy_personnel( Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_personnel::whereMatricule($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }

function generateRandomString($length = 4) {
    $characters ='A'.mt_rand(1000000000, 9999999999); 
    $charactersLength = strlen($characters);
    $randomString = 'MTR-';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
  
  function generateRandom($length = 4) {
    $characters ='A'.mt_rand(1000000000, 9999999999); 
    $charactersLength = strlen($characters);
    $randomString = 'Mtp-';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

    //______________________________________________fin_____________________________________________________________

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
   

    

    public function profil()
    {
        if (Auth::check()) {
        $this->entete();
        $utilisateur = DB::select("SELECT * FROM users WHERE email = '".Auth::user()->id."' ");
        return view('view_profil');
        } 
        else{
            return redirect()->route('index_login');
        }  
        
    }

    public function deconnexion(){
        // if (Auth::check()) {
        //     $deconnexion = user::whereEmail(Auth::user()->email)->update(['etatcon' => 0]);
        //     $this->historisation(Auth::user()->matricule,'Deconnected');
        //     Auth::logout();
        //     return redirect()->route('index_login');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
  
    
    //  public function email_oublie(Request $request){
    //     if ($request->ajax()) {
    //         $result=user::whereEmail($request->email_oublie)->first();
    //         if ($result) {
    //             $new_passe=$this->generateRandom();
    //             $result->etat='0';
    //             $result->password=Hash::make($new_passe);
    //             $result->save();
    //             return response()->json(['success'=>'1','new_passe'=>$new_passe]);
    //         }else {
    //             return response()->json(['success'=>'2']);
    //         }
    //     }
    // }
    
    public function affichagecode(){
        if (Auth::check()) {
        $this->entete();
            $codes = DB::select("SELECT * FROM tbl_depots, tbl_agences, tbl_devises, tbl_personnels WHERE tbl_depots.etatservi = '1' AND tbl_depots.numagence =  tbl_agences.numagence AND tbl_depots.matricule = tbl_personnels.matricule AND tbl_depots.id_devise = tbl_devises.id ORDER BY created_at DESC");
            return view('view_affichagecode', compact("codes"));
        } 
        else{
            return redirect()->route('index_login');
        } 
    }
}
