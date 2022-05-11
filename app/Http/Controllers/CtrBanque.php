<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_banque;
use App\Http\Controllers\ctradmin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Ctrpersonnel;

class CtrBanque extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $this->entete();
            return view('view_banque');
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

    public function get_list_banque()
    {

        $resultat=tbl_banque::orderBy('id','DESC')
                                      ->get(); 
           return response()->json(['data'=>$resultat]);
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
    public function historique($matricule,$operation){
        $resultat=new Ctrpersonnel;
        return $resultat->historisation($matricule,$operation);
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
    public function update(Request $request)
    {
        if ($request->ajax()) {
           
            $resultat=tbl_banque::whereId($request->id)->update(['numero_compte'=>$request->numero_compte,'intitulecompte'=>$request->intitulecompte,'Montant'=>$request->Montant,'devise'=>$request->devise]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_banque::whereId($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }
}
