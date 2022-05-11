<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_agence;
use App\Models\tbl_typedepense;
use App\Models\tbl_depense;
use App\Models\tbl_autorisation;
use App\Models\tbl_mvtbanque;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ctradmin;
use App\Http\Controllers\CtrTransfert;
use App\Models\tbl_devise;
use DB;
use DateTime;

class Ctrdepense extends Controller
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
             $typedep= tbl_typedepense::all();
             $auto= tbl_autorisation::all();
             $don=$this->get_agence();
            return view('view_depense',compact('don','typedep','auto'));

        }
        else{
            return redirect()->route('login');
        }
    }

    public function index_confirmationdep()
    {
        if (Auth::check()) {
            $this->entete();
            $agence=$this->get_agence();
            return view('view_confirmationdepense',compact('agence'));
        }

        else{
            return redirect()->route('login');
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

    public function get_agence(){
        $affichage= new CtrTransfert;
        return $affichage->recu_agence();
    }
    public function __construct(){
        $this->date= new DateTime();
        
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
            $Montantusd=0.0;
            $Montantcdf=0.0;
            $requette2=tbl_agence::whereNumagence($request->numagence)->first();
            if ($requette2) {
                $Montantusd=$requette2->Montusd;
                $Montantcdf=$requette2->Montcdf;
            }
                if ($request->devise=='1') {
                    if ($Montantusd >=$request->montant) {
                        $array=array($request->motif,$request->devise,$request->montant,$request->id_typdep,$request->id_auto,$request->numagence);
                        $this->save_data($array);
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
                        $array=array($request->motif,$request->devise,$request->montant,$request->id_typdep,$request->id_auto,$request->numagence);
                        $this->save_data($array);
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
    private function save_data(array $request){

        $resultat=tbl_depense::create([
            'motif'=>$request[0],
            'devise'=>$request[1],
            'etat'=>'1',
            'montant'=>$request[2],
            'id_typdep'=>$request[3],
            'id_auto'=>$request[4],
            'matricule'=>Auth::user()->matricule,
            'numagence'=>$request[5],
            'created_at'=>$this->date->format('Y-m-d'),
        ]);
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

    public function entete(){
        $affichage= new ctradmin;
        return $affichage->index_entete();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_depense::whereId_dep($request->id_dep)->update(['motif'=>$request->motif,'id_typdep'=>$request->id_typdep,'id_auto'=>$request->id_auto]);
            return response()->json(['success'=>'1']);   
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

    public function get_confirmation($dbut,$dfin){

        $resultat=DB::table('tbl_depenses')->join('tbl_agences','tbl_depenses.numagence','=','tbl_agences.numagence')
                                           ->join('tbl_typedepenses','tbl_depenses.id_typdep','=','tbl_typedepenses.id_typdep')
        ->whereBetween('tbl_depenses.created_at', [$dbut,$dfin])
        ->select('id_dep','motif','devise','etat','montant','type_dep','id_auto','matricule','nomagence','created_at')
        ->orderBy('tbl_depenses.numagence','ASC')->get(); 
        return response()->json(['data'=>$resultat]);
    }

    public function etat_depense(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_depense::whereId_dep($request->code)->update(['etat'=>$request->etat]);
            return response()->json(['success'=>'etat modifié']); 
        }
    }

    public function get_depense(Request $request)
    {
        if ($request->ajax()) {
             $resultat=tbl_depense::whereId_dep($request->code)->first();
            return response()->json($resultat); 
           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_depense::whereId_dep($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }
}
