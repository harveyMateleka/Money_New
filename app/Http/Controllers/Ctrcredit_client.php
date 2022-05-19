<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ctradmin;
use App\Models\tbl_depot;
use App\Models\tbl_agence;
use App\Models\tbl_vile;
use App\Models\tbl_devise;
use Illuminate\Support\Facades\Auth;
use DB;
class Ctrcredit_client extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $admin;
    public function index()
    {
        //
    }

    public function __construct(){

        //$this->transfert=new CtrTransfert; 
        $this->admin=new ctradmin; 
    }

    public function index_credit()
    {
        if (Auth::check()) {  
            $this->admin->index_entete();
             $tab_ville=tbl_vile::orderBy('ville','asc')->get();
            $tab_devise=tbl_devise::orderBy('id','DESC')->get();
            $agence=tbl_agence::orderBy('nomagence','asc')->get();
            $resultat=DB::table('tbl_depots','tbl_depot')->join('tbl_agences','tbl_depot.numagence','=','tbl_agences.numagence')
                                                         ->join('tbl_clients','tbl_depot.id_client','=','tbl_clients.id_client')
                                                         ->join('tbl_viles','tbl_depot.id_ville','=','tbl_viles.id_ville')
                                                         ->join('tbl_devises','tbl_depot.id_devise','=','tbl_devises.id')
                                        ->where('tbl_depot.etatservi','=','0')
                                        ->orderBy('tbl_depot.id','DESC')
                                        ->select('tbl_depot.id','numdepot','nomben','montenvoi','montpour','created_at','nomagence','nomclient','ville','intitule','id_devise')
                                        ->get();
    
          
            
            return view('view_credit',compact('resultat','tab_ville','tab_devise','agence'));
        }
        else{
            return redirect()->route('index_login');
        }
    }

    public function index_restitution()
    {
        if (Auth::check()) {  
            $this->admin->index_entete();
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

                 public function get_id_credit(Request $request)
                 {
                     if ($request->ajax()) {
                          $resultat=DB::table('tbl_depots','depot')->join('tbl_clients','depot.id_client','=','tbl_clients.id_client')
                          ->join('tbl_agences','depot.numagence','=','tbl_agences.numagence')->where('depot.numdepot','=',$request->code)->first();
                         return response()->json($resultat); 
                        
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
