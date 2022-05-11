<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ctradmin;

use Illuminate\Http\Request;
use App\Models\tbl_fonction;
use Illuminate\Support\Facades\Auth;
class Ctrfonction extends Controller
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
             return view("view_fonction");
        }
        else{
            //return route('index_login'); 
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
            $table=tbl_fonction::whereFonction($request->name_fonction)->first();
            if (!$table) {
                $record= new tbl_fonction;
                $record->fonction=$request->name_fonction;
                $record->save();
                return response()->json(['success'=>'1']);
            }
            else{
                return response()->json(['success'=>'0']);
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

    public function get_id_f(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_fonction::whereId_fonction($request->code)->first();
            return response()->json($resultat); 
        }
    }

    public function get_list_f()
    {
        $resultat=tbl_fonction::orderBy('id_fonction','DESC')
                                      ->get(); 
           return response()->json(['data'=>$resultat]);
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
            $this->validate($request,['fonction'=>'required']);
            $resultat=tbl_fonction::whereId_fonction($request->code_fonction)->update(['fonction'=>$request->fonction]);
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
            $resultat=tbl_fonction::whereId_fonction($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }
}
