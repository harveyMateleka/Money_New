<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_agence;
use App\Http\Controllers\ctradmin;
use Illuminate\Support\Facades\Auth;
use App\Models\tbl_vile;

class Ctragence extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function entete(){
        $affichage = new Ctradmin;
        return $affichage->index_entete();
    }
    
    
     public function index()
    {
        if (Auth::check()) {
            $this->entete();
            $resultat=tbl_vile::orderBy('ville','ASC')->get();
            return view("view_agence",compact('resultat'));
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

    public function index_repartition()
    {
        if (Auth::check()) {
            $this->entete();
           $resultat=tbl_agence::all();
           return view("view_repartition",compact('resultat'));
        } 
        else{
            return redirect()->route('login');
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table=tbl_agence::whereNomagence(strtoupper($request->nomagence))->first();
        if (!$table) {
            $record = new tbl_agence;
            $record->nomagence=strtoupper($request->nomagence);
            $record->adresse=strtoupper($request->adresse);
            $record->telservice=strtoupper($request->telservice);
            $record->id_ville=strtoupper($request->id_ville);
            $record->indiceag=strtoupper($request->indiceag);
            $record->initial=strtoupper($request->initial);
            $record->save();
            return response()->json(['success'=>'1']);
        }  
        else{
            return response()->json(['success'=>'0']);
        }
    }

    public function get_list_agence()
    {
        $resultat=tbl_agence::orderBy('numagence','DESC')
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

    public function update_repartition(Request $request)
    { 
       if ($request->ajax()) {
            $resultat=tbl_agence::whereNumagence($request->numagence)->update(['Montcdf'=>$request->Montcdf,'Montusd'=>$request->Montusd]);
            return response()->json(['success'=>'1']);   
        } 
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

    public function get_id_agence(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_agence::whereNumagence($request->code)->first();
            return response()->json($resultat); 
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
            $resultat=tbl_agence::whereNumagence($request->numagence)->update(['nomagence'=>$request->nomagence,'adresse'=>$request->adresse,'telservice'=>$request->telservice,'indiceag'=>$request->indiceag,'initial'=>$request->initial]);
            return response()->json(['success'=>'1']);   
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
            $resultat=tbl_agence::whereNumagence($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }
}
