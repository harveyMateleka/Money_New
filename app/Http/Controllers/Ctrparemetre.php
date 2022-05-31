<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_fonction;
use App\Models\tbl_typedepense;
use App\Models\tbl_menu;
use App\Models\tbl_sous_menu;
use App\Models\tbl_droitacces;
use App\Models\tbl_agence;
use App\Models\tbl_vile;
use App\Models\tbl_ong;
use DB;
use App\Http\Controllers\ctradmin;
use Illuminate\Support\Facades\Auth;

class Ctrparemetre extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1()
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

public function index_ville()
    {
         if (Auth::check()) {
            $this->entete();
        return view("view_ville"); 
        }
        else{
            return redirect()->route('index_login');
        }   
    }

//__________________________________________agence__________________________________________________________
    public function index_agence()
    {
        if (Auth::check()) {
            $this->entete();
            $resultat=tbl_vile::orderBy('ville','ASC')->get();
            return view("view_agence",compact('resultat'));
        }
        else{
            return redirect()->route('index_login');
        }        
    }
    public function store_agence(Request $request)
    { 
        //if ($request->ajax()) {
            $table=tbl_agence::whereNomagence($request->nomagence)->first();
            if (!$table) {
                $record= new tbl_agence;
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
       // }  
    }
    public function get_list_agence()
    {
        $resultat=tbl_agence::orderBy('numagence','DESC')
                                      ->get(); 
           return response()->json(['data'=>$resultat]);
    }
    public function update_agence(Request $request)
    { 
       if ($request->ajax()) {
            
            $resultat=tbl_agence::whereNumagence($request->numagence)->update(['nomagence'=>$request->nomagence,'adresse'=>$request->adresse,'telservice'=>$request->telservice,'indiceag'=>$request->indiceag,'initial'=>$request->initial]);
            return response()->json(['success'=>'1']);   
        } 
    }
    public function get_id_agence(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_agence::whereNumagence($request->code)->first();
            return response()->json($resultat); 
        }
    }
    public function destroy_agence( Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_agence::whereNumagence($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }

    //________________________________________________fin agance________________________________________________________
    public function index2()
    {
        if (Auth::check()) {
            $this->entete();
        return view("view_typedepense");
        }
        else{
            return redirect()->route('index_login');
        }
        
    }
    public function index3()
    {
       if (Auth::check()) {
        $this->entete();
        return view("view_menu");
       }
       else{
        return redirect()->route('index_login'); 
       }
    }
    public function index4()
    {
      if (Auth::check()) {
        $this->entete();
        $resultat=tbl_menu::all();
        return view("view_sous_menu",compact('resultat'));
      } 
      else{
        return redirect()->route('index_login');
      }
       
       
        //dd($resultat);
    }
    public function index5()
    {
        if (Auth::check()) {
            $this->entete();
            $resultat=tbl_fonction::all();
            $resul_smenu=DB::table('tbl_sous_menus')->select('id_sous','item_sous')
                                                     ->orderBy('id_sous','DESC')
                                                     ->get();
                                                    
            return view("view_permission",compact('resultat','resul_smenu'));
        }
        else{
            return redirect()->route('index_login'); 
        }
        
          
    }
    public function index_ong()
    {
        if (Auth::check()) {
            $this->entete();
            return view('view_ong');
        }
        else{
            return redirect()->route('index_login');
          }
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
    public function create_fonction(Request $request)
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

    public function create_typedep(Request $request)
    { 
        if ($request->ajax()) {
            $table=tbl_typedepense::whereType_dep($request->name_typedep)->first();
            if (!$table) {
                $record= new tbl_typedepense;
                $record->type_dep=$request->name_typedep;
                $record->save();
                return response()->json(['success'=>'1']);
            }
            else{
                return response()->json(['success'=>'0']);
            }
        }  
    }
    public function create_menu(Request $request)
    { 
        if ($request->ajax()) {
            $table=tbl_menu::whereItem_menu($request->name_menu)->first();
            if (!$table) {
                $record= new tbl_menu;
                $record->item_menu=$request->name_menu;
                $record->icon=$request->name_icon;
                $record->save();
                return response()->json(['success'=>'1']);
            }
            else{
                return response()->json(['success'=>'0']);
            }
        }  
    }

    public function create_smenu(Request $request)
    { 
        if ($request->ajax()) {
            $table=tbl_sous_menu::whereItem_sous($request->name_smenu)->first();
            if (!$table) {
                $record= new tbl_sous_menu;
                $record->item_sous=$request->name_smenu;
                $record->id_menu=$request->name_menu;
                $record->lien=$request->name_lien;
                $record->save();
                return response()->json(['success'=>'1']);
            }
            else{
                return response()->json(['success'=>'0']);
            }
        }  
    }

    public function create_droit(Request $request)
    { 
        if ($request->ajax()) {
            $table=tbl_droitacces::where(['id_fonction'=>$request->name_fonction,'id_sous'=>$request->name_smenu])->first();
            if (!$table) {
                $record= new tbl_droitacces;
                $record->id_fonction=$request->name_fonction;
                $record->id_sous=$request->name_smenu;
                $record->save();
                return response()->json(['success'=>'1']);
            }
            else{
                return response()->json(['success'=>'0']);
            }
        }  
    }

    public function update_fonct(Request $request){
        if ($request->ajax()) {
            $this->validate($request,['fonction'=>'required']);
            $resultat=tbl_fonction::whereId_fonction($request->code_fonction)->update(['fonction'=>$request->fonction]);
            return response()->json(['success'=>'1']);   
        }
    }

    public function update_typedep(Request $request){
        if ($request->ajax()) {
            $this->validate($request,['typedep'=>'required']);
            $resultat=tbl_typedepense::whereId_typdep($request->code_typedep)->update(['type_dep'=>$request->typedep]);
            return response()->json(['success'=>'1']);   
        }
    }

    public function update_menu(Request $request){
        if ($request->ajax()) {
            $this->validate($request,['menu'=>'required','name_icon'=>'required']);
            $resultat=tbl_menu::whereId_menu($request->code_menu)->update(['item_menu'=>$request->menu,'icon'=>$request->name_icon]);
            return response()->json(['success'=>'1']);   
        }
    }

    public function update_smenu(Request $request){
        if ($request->ajax()) {
            $resultat=tbl_sous_menu::whereId_sous($request->code_smenu)->update(['item_sous'=>$request->name_smenu,'lien'=>$request->name_lien,'id_menu'=>$request->menu]);
            return response()->json(['success'=>'1']);   
        }
    }

    public function get_list_f()
    {
        $resultat=tbl_fonction::orderBy('id_fonction','DESC')
                                      ->get(); 
           return response()->json(['data'=>$resultat]);
    }

    public function get_list_smenu()
    {
        $resultat=DB::table('tbl_sous_menus')->join('tbl_menus','tbl_sous_menus.id_menu','=','tbl_menus.id_menu')
                                             ->orderBy('id_sous','DESC')
                                             ->get(array('id_sous','item_sous','lien','tbl_menus.item_menu')); 
           return response()->json(['data'=>$resultat]);
    }

    public function get_list_droit()
    {
        $resultat=DB::table('tbl_droitacces')->join('tbl_sous_menus','tbl_droitacces.id_sous','=','tbl_sous_menus.id_sous')
                                             ->join('tbl_fonctions','tbl_droitacces.id_fonction','=','tbl_fonctions.id_fonction')
                                             ->orderBy('id_droit','DESC')
                                             ->get(array('id_droit','tbl_sous_menus.item_sous','tbl_fonctions.fonction')); 
           return response()->json(['data'=>$resultat]);
    }


    public function get_list_menu()
    {
        $resultat=tbl_menu::orderBy('id_menu','DESC')
                                      ->get(); 
           return response()->json(['data'=>$resultat]);
    }

    public function get_list_typedep(){
        
        $resultat=tbl_typedepense::orderBy('id_typdep','DESC')
                                ->get(); 
        return response()->json(['data'=>$resultat]);
    }

    public function get_id_menu(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_menu::whereId_menu($request->code)->first();
            return response()->json($resultat); 
        }
    }

    public function get_id_smenu(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_sous_menu::whereId_sous($request->code)->first();
            return response()->json($resultat); 
        }
    }

    public function get_id_f(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_fonction::whereId_fonction($request->code)->first();
            return response()->json($resultat); 
        }
    }

    public function get_id_typedep(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_typedepense::whereId_typdep($request->code)->first();
            return response()->json($resultat); 
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
        if ($request->ajax()) {
           
            $table=tbl_ong::whereName_ong($request->ong)->first();
            if (!$table) {
                $record=tbl_ong::create(['name_ong'=>$request->ong,'name_Perso'=>$request->Perso,
                'adresse_siege'=>$request->siege,'tel_contact'=>$request->tel]);
                return response()->json(['success'=>'1']);
                
            }  
            else{
                return response()->json(['success'=>'0']);
            }
        } 
    }
    public function update_ong(Request $request)
    {
        if ($request->ajax()) {
             
            $resultat=tbl_ong::whereId($request->id)->update(['name_ong'=>$request->name_ong,'name_Perso'=>$request->name_Perso,
            'adresse_siege'=>$request->adresse_siege,'tel_contact'=>$request->tel_contact]);
            return response()->json(['success'=>'1']);   
        } 
    }
    public function get_list_ong()
    {
        $resultat=tbl_ong::orderBy('id','DESC')
                                      ->get(); 
           return response()->json(['data'=>$resultat]);
    }
    public function get_id_ong(Request $request)
    {
        if ($request->ajax()) {
            $resultat=tbl_ong::whereId($request->code)->first();
            return response()->json($resultat); 
        }
    }
    public function destroy_ong(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_ong::whereId($id->code)->delete();
            return response()->json(['success'=>'1']); 
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
    public function destroy(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_fonction::whereId_fonction($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }

    public function destroy_typedep(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_typedepense::whereId_typdep($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }
    public function destroy_menu(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_menu::whereId_menu($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }
    public function destroy_smenu(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_sous_menu::whereId_sous($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }

    public function destroy_droit(Request $id)
    {
        if ($id->ajax()) {
            $resultat=tbl_droitacces::whereId_droit($id->code)->delete();
            return response()->json(['success'=>'1']); 
        }
    }
}
