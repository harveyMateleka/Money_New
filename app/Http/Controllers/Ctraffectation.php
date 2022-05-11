<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_agence;
use Illuminate\Support\Facades\Auth;
use App\Models\tbl_affectation;
use App\Models\tbl_personnel;
use DB;
use DateTime;

class Ctraffectation extends Controller
{
    private $admin;
    private $personnel;
    private $data;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $this->admin->index_entete();
           $result_agence=tbl_agence::orderBy('nomagence','ASC')->get();
            return view('vieuw_affectation',compact('result_agence'));
            } 
            else{
                return redirect()->route('login');
              } 
    }

    public function __construct(){
        $this->admin = new ctradmin;
        $this->personnel= new ctrpersonnel;
        $this->date= new DateTime();
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
            $teste=DB:: table('tbl_affectations')->where('matricule','=',$request->name_matr)
                                                   ->where('numagence','=',$request->name_agence)
                                                   ->first();
            $resultat=tbl_personnel::where('matricule','=',$request->name_matr)->first();
            $array=array($request->name_matr,$request->name_agence);
            if ($resultat->occupation=='1') {
               
                    if (!$teste) {
                        $this->save_data($array);
                        return response()->json(['success'=>'1']); 
                    }
                    else{
                        return response()->json(['success'=>'0']);
                        
                        }
          }
          else{
                    if (!$teste) {
                        $update=tbl_affectation::whereMatricule($resultat->matricule)->update(['statut'=>'0']);
                        $this->save_data($array);
                        return response()->json(['success'=>'1']);  
                        
                        }
                        else{
                                if ($teste->statut==0) {
                                    $teste->update(['statut'=>'1']);
                                    $update=tbl_affectation::where(['matricule','=',$resultat->matricule],['numagence','<>',$resultat->name_agence])->update(['statut'=>'0']);
                                    return response()->json(['success'=>'1']);  
                                }
                                
                                
                        }
            }
         
        }
    }

    private function save_data(array $tableau){

        $record=tbl_affectation::create(['matricule'=>$tableau[0],
                                        'numagence'=>$tableau[1],
                                        'statut'=>'1',
                                        'created_at'=>$this->date->format('Y-m-d H:i:s')]);
    }

    public function get_afectation()
    {
        $resultat=DB::table('tbl_affectations')->join('tbl_personnels','tbl_affectations.matricule','=','tbl_personnels.matricule')
                                               ->join('tbl_agences','tbl_affectations.numagence','=','tbl_agences.numagence')
                                               ->where('tbl_affectations.statut','=','1')
                                               ->orderBy('id','DESC')
                                               ->select('id','tbl_affectations.matricule','tbl_personnels.nom','tbl_personnels.postnom','tbl_personnels.prenom','tbl_agences.nomagence','created_at')
                                               ->get();
        return response()->json(['data'=>$resultat]);
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
    public function destroy(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_affectation::whereId($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }
}
