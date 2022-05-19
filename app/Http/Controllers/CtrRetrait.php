<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ctradmin;
use App\Http\Controllers\CtrTransfert;
use App\Http\Controllers\Ctrpersonnel;
use App\Models\tbl_agence;
use App\Models\tbl_retrait;
use App\Models\tbl_depot;
use Illuminate\Support\Facades\Auth;
use DB;
use DateTime;

class CtrRetrait extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $transfert;
    private $admin;
    private $date;
    public function index()
    {
        if (Auth::check()) {  
            $this->admin->index_entete();
            $sortie_agence=$this->transfert->recu_agence();
            return view('view_sortie',compact('sortie_agence'));
        }
        else{
            return redirect()->route('index_login');
        }
    }
    public function __construct(){

        $this->transfert=new CtrTransfert; 
        $this->admin=new ctradmin; 
        $this->date= new DateTime();
    }

    public function index_codeservi(){
        if (Auth::check()) {
            $this->admin->index_entete();
            return view('view_affichagecode');
        }
        else{
            return redirect()->route('login');
        }  
    }

    public function get_code(){
        $resultat=DB::table('tbl_retraits','retrait')->join('tbl_depots','retrait.id_depot','=','tbl_depots.numdepot')
                                                ->join('tbl_agences','retrait.numagence','=','tbl_agences.numagence')
                                                 ->join('tbl_personnels','retrait.matricule','=','tbl_personnels.matricule')
                                                 ->join('tbl_devises','tbl_depots.id_devise','=','tbl_devises.id')
                                                 ->where('tbl_depots.etatservi','=','1')
                                                 ->select('retrait.id','nomagence',DB::raw("CONCAT(tbl_personnels.nom,' ',tbl_personnels.prenom) AS name"),'numdepot','montenvoi','intitule','date_servis')
                                                 ->get();
                                                 return response()->json(['data'=>$resultat]);
    }

    public function get_plage($debut,$fin){
        $resultat=DB::table('tbl_retraits','retrait')->join('tbl_depots','retrait.id_depot','=','tbl_depots.numdepot')
                                                ->join('tbl_agences','retrait.numagence','=','tbl_agences.numagence')
                                                ->join('tbl_personnels','retrait.matricule','=','tbl_personnels.matricule')
                                                ->join('tbl_devises','tbl_depots.id_devise','=','tbl_devises.id')
                                                 ->where('tbl_depots.etatservi','=','1')
                                                 ->whereBetween('date_servis', [$debut,$fin])
                                                 ->select('retrait.id','nomagence',DB::raw("CONCAT(tbl_personnels.nom,' ',tbl_personnels.prenom) AS name"),'numdepot','montenvoi','intitule','date_servis')->get();
  //dd($resultat);
        return response()->json(['data'=>$resultat]);
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
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $montdollars=0.0;
            $value=0;
            $montcdf=0.0;
            $name_agence='';
            $operation='';
            $requette2=$this->transfert->get_montAg($request->agence);
            $montdollars=$requette2['montantD'];
            $montcdf=$requette2['montantC'];
            $name_agence=$requette2['nameagence'];
                   
            if ($request->devise == 1 && $montdollars >= $request->montant) { 
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
                $this->transfert->historique(Auth::user()->matricule,$operation);
                return response()->json(['success'=>'1']);
            }
            else {
                return response()->json(['success'=>'3']);
            }
           
          
        }
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
    public function destroy($id)
    {
        //
    }
}
