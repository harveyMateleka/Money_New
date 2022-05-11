<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\tbl_devise;
use App\Http\Controllers\ctradmin;
use Illuminate\Support\Facades\Auth;

class Ctrtaux extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            $this->entete();
            return view("view_taux");
        }
        else{
            return redirect()->route('index_login');
          }
       
    }
    public function entete(){
        $affichage= new ctradmin;
        return $affichage->index_entete();
    }

    public function store(Request $request)
    { 
        if ($request->ajax()) {
            $table=tbl_devise::whereIntitule($request->intitule)->first();
            if (!$table) {
                $record= new tbl_devise;
                $record->intitule=$request->intitule;
                $record->taux = $request->taux;
                $record->save();
                return response()->json(['success'=>'1']);
            }
            else{
                return response()->json(['success'=>'0']);
            }
        }  
    }

    public function update_taux(Request $request)
    {
        if ($request->ajax()) {
             $this->validate($request,['intitule'=>'required']);
            $resultat=tbl_devise::whereId($request->id_code)->update(['intitule'=>$request->intitule,
            'taux'=>$request->taux]);
            return response()->json(['success'=>'1']);   
        } 
    }

   public function get_list()
    {
        $resultat=tbl_devise::orderBy('id','DESC')
                                      ->get(); 
           return response()->json(['data'=>$resultat]);
    }


   public function get_id(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_devise::whereId($request->code)->first();
            return response()->json($resultat); 
        }
    }



    public function destroy( Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_devise::whereId($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }

}
