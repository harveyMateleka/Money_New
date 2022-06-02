<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ctradmin;
use DB;
use DateTime;
use App\Models\tbl_personnel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Ctruser extends Controller
{
    private $admin;
    private $personnel;

    public function index()
    {
        if (Auth::check()) {
            $this->admin->index_entete();
            $result_users = $this->personnel->generateRandom();
            return view('view_users', compact('result_users'));
        } else {
            return redirect()->route('login');
        }
    }

    public function __construct()
    {
        $this->admin = new ctradmin;
        $this->personnel = new ctrpersonnel;
    }


    public function save_users(Request $request)
    {
        
        if ($request->ajax()) {
            
            $resultat = user::whereMatricule($request->name_matr)->first();
            if (!$resultat) {
                $ii = 0;
                $name = 'ABT-' . ++$ii;
                $resultat = user::create([
                    'name' => $name,
                    'email' => $request->name_email,
                    'password' => Hash::make($request->name_passe),
                    'etatcon' => '0',
                    'etat' => '0',
                    'matricule' => $request->name_matr,
                    'remember_token' => $request->name_passe
                ]);
                return response()->json([
                    'message' => "L'utilisateur a été enregistré avec succès",
                    'status'  => 200
                ]);
            } else {
                return response()->json([
                    'status' => 'Erreur !!! L\enregistrement de l\'utilisateur a échoué']);
            }
        }
    }



    public function get_id_user(Request $request){
        $id = $request->id;

        $result = User::find($id);
        return response()->json($result);
    }


    public function update_profil(Request $request)
    {

        if (Auth::check()) {
            $news = new users;
            if ($request->hasFile('profil')) {
                if (Auth::user()->image) {
                    if (file_exists(public_path() . '/img/image_user/' . Auth::user()->image)) {
                        unlink(public_path() . '/img/image_user/' . Auth::user()->image);
                        $image = $request->file('profil');
                        $name = $image->getClientOriginalName();
                        $image->move(public_path() . '/img/image_user/', $name);
                        $resultat = user::whereEmail(Auth::user()->email)->update(['password' => Hash::make($request->password), 'image' => $name, 'name' => $request->name, 'email' => $request->email]);
                        return redirect()->route('profil');
                    } else {
                        $image = $request->file('profil');
                        $name = $image->getClientOriginalName();
                        $image->move(public_path() . '/img/image_user/', $name);
                        $resultat = user::whereEmail(Auth::user()->email)->update(['password' => Hash::make($request->password), 'image' => $name, 'name' => $request->name, 'email' => $request->email, 'etatcon' => 0]);
                        //Auth::logout();
                        return redirect()->route('index_login');
                    }
                } else {
                    $image = $request->file('profil');
                    $name = $image->getClientOriginalName();
                    $image->move(public_path() . '/img/image_user/', $name);
                    $resultat = user::whereEmail(Auth::user()->email)->update(['password' => Hash::make($request->password), 'image' => $name, 'name' => $request->name, 'email' => $request->email, 'etatcon' => 0]);
                    //Auth::logout();
                    return redirect()->route('login');
                }
            } else {
                $resultat = user::whereEmail(Auth::user()->email)->update(['password' => Hash::make($request->password), 'name' => $request->name, 'email' => $request->email, 'etatcon' => 0]);
                //Auth::logout();
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }


    public function update(Request $request)
    {
        $resultat = User::whereId($request->code_users)
            ->update([
                'email' => $request->name_email,
                'password' => Hash::make($request->name_passe),
                'etatcon' => '0',
                'etat' => '0',
                'matricule' => $request->name_matr
            ]);
        return response()->json(['success' => '1']);
    }

    public function get_list_users(Request $request)
    {
        $resultat = DB::table('users')->join('tbl_personnels', 'users.matricule', '=', 'tbl_personnels.matricule')
            ->orderBy('id', 'DESC')
            ->get(array('id', 'email', 'etatcon', 'tbl_personnels.nom'));
        return response()->json(['data' => $resultat]);
    }

    public function destroy(Request $id)
    {
        if ($id->ajax()) {
            $resultat = User::findOrFail($id->code)->first();
            $resultat->delete();
            return response()->json(['success' => '1']);
        }
    }
}
