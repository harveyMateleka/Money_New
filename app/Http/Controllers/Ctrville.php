<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_vile;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ctradmin;
class Ctrville extends Controller
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
            return view("view_ville");
        }
        else{
            return redirect()->route('index_login');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        if ($request->ajax()) {
            
            
            $table=tbl_vile::whereVille($request->name_ville)->first();
            if (!$table) {
                $record= new tbl_vile;
                $record->ville=strtoupper($request->name_ville);
                $record->initial=strtoupper($request->initial);
                $record->save();
                return response()->json(['success'=>'1']);
            }
            else{
                    $message='vos informations sont incorrectes.';
                    return view('view_ville',compact('message'));
            }
        }  
    }
    public function get_list()
    {
        $resultat=tbl_vile::orderBy('id_ville','DESC')
                                      ->get(); 
           return response()->json(['data'=>$resultat]);
    }

    public function get_id(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_vile::whereId_ville($request->code)->first();
            return response()->json($resultat); 
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
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $this->validate($request,['ville'=>'required']);
            $resultat=tbl_vile::whereId_ville($request->code_ville)->update(['ville'=>$request->ville,'initial'=>$request->initial]);
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
            $resultat=tbl_vile::whereId_ville($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }
}
