<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ctradmin;
use App\Models\tbl_affectation;
use App\Models\tbl_agence;
use App\Models\tbl_fonction;
use App\Models\tbl_historique;
use App\Models\tbl_personnel;
use App\Models\User;
use DateTime;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class Ctrpersonnel extends Controller
{

    private $date;

    public function index()
    {
        if (Auth::check()) {
            $this->entete();
            $result_users = $this->generateRandom();
            return view('view_users', compact('result_users'));
        } else {
            return redirect()->route('index_login');
        }
    }

    public function getUsers()
    {
        if (Auth::check()) {
            $resultat = DB::table('users')->join('tbl_personnels', 'users.matricule', '=', 'tbl_personnels.matricule')
                ->orderBy('id', 'DESC')
                ->get(array('id', 'email', 'etatcon', 'tbl_personnels.nom'));

            $agents = tbl_personnel::get();
            $datas = User::orderBy('name', 'asc')->get();

            return view('view_users', compact('datas', 'agents'));

            /* $agents = tbl_personnel::get();

        dd($datas);*/
        }
    }

    // CREATION NOUVEL UTILISATEUR

    public function storeUser(Request $request)
    {
        $file = $request->file('avatar');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/img', $fileName);

        print_r($file);

        $etat = 0;

        $empData = [
            'name' => $request->nom,
            'email' => $request->email,
            'password' => $request->pwd,
            'etat' => $etat,
        ];

        User::create($empData);
        return response()->json([
            "status" => 200,
        ]);
    }

 public function get_id_user(Request $request)
    {
        $id = $request->id;

        $result = User::find($id);
        return response()->json($result);
    }

    public function index_historique()
    {
        if (Auth::check()) {
            $this->entete();
            $resultat = DB::table('tbl_historiques')
                ->join('tbl_personnels', 'tbl_historiques.matricule', '=', 'tbl_personnels.matricule')
                ->orderBy('created_at', 'DESC')
                ->select('tbl_historiques.*', 'nom', 'postnom')->get();
            return view('view_historique', compact('resultat'));
        } else {
            return redirect()->route('index_login');
        }
    }

    public function delete_historique()
    {
        DB::table('tbl_historiques')->take(100)->delete();
        return response()->json(['success' => '1']);
    }

    public function indexpersonnel()
    {
        if (Auth::check()) {
            $this->entete();
            $resultat = tbl_fonction::all();
            $resul = $this->generateRandomString();
            return view("view_personnel", compact('resultat', 'resul'));
        } else {
            return redirect()->route('index_login');
        }
    }

    public function index_login()
    {
        if (!Auth::check()) {
            return view('view_login');
        }
    }

    public function index_affectation()
    {
        if (Auth::check()) {
            $this->entete();
            $result_agence = tbl_agence::orderBy('nomagence', 'ASC')->get();
            return view('vieuw_affectation', compact('result_agence'));
        } else {
            return redirect()->route('index_login');
        }
    }

    public function __construct()
    {
        //$this->middleware('auth');
        $this->date = new DateTime();
    }
    public function entete()
    {
        $affichage = new ctradmin;
        return $affichage->index_entete();
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $personnel = tbl_personnel::whereMatricule(Auth::user()->matricule)->first();
            $this->historisation(Auth::user()->matricule, 'Connected');
            if ($personnel) {
                Session::put('fonction', $personnel->id_fonction);
            }
            Session::put('password', $request->password);
            if (Auth::user()->etat == '0') {
                $motdepasse = $request->password;
                return view('view_update', compact('motdepasse'));
            } else {
                $update = user::whereId(Auth::id())->update(['etatcon' => '1']);
                return redirect()->route('route_index');
            }
        } else {
            $message = 'vos informations sont incorrectes.';
            return view('view_login', compact('message'));
        }
    }
    public function update_login(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required', 'confirm' => 'required',
        ]);
        if ($request->new_password == $request->confirm) {
            $update = user::whereId(Auth::user()->id)->update(['password' => Hash::make($request->new_password), 'etat' => '1', 'etatcon' => '1']);
            Session::put('password', $request->new_password);
            return redirect()->route('route_index');
        } else {
            return back()->with([
                'message' => 'verifier bien votre mot de passe',
            ]);
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
    public function historisation($matr, $operation)
    {
        if ($matr != '' && $operation != '') {
            $insert = tbl_historique::create([
                'matricule' => $matr,
                'operation' => $operation,
                'created_at' => $this->date->format('Y-m-d H:i:s'),
            ]);
            return 1;
        }
    }
    public function create_affectation(Request $request)
    {
        if ($request->ajax()) {
            $resultat = tbl_personnel::where('matricule', '=', $request->name_matr)->first();
            if ($resultat->occupation == '1') {
                $teste = DB::table('tbl_affectations')->where('matricule', '=', $request->name_matr)
                    ->where('numagence', '=', $request->name_agence)
                    ->first();
                if (!$teste) {
                    $record = tbl_affectation::create([
                        'matricule' => $request->name_matr,
                        'numagence' => $request->name_agence,
                        'statut' => '1',
                        'created_at' => $this->date->format('Y-m-d H:i:s'),
                    ]);
                    return response()->json(['success' => '1']);
                } else {
                    return response()->json(['success' => '0']);
                }
            } else {
                $teste = DB::table('tbl_affectations')->where('matricule', '=', $request->name_matr)
                    ->where('numagence', '=', $request->name_agence)
                    ->first();
                if (!$teste) {
                    $update = tbl_affectation::whereMatricule($resultat->matricule)->update(['statut' => '0']);
                    $record = tbl_affectation::create([
                        'matricule' => $request->name_matr,
                        'numagence' => $request->name_agence,
                        'statut' => '1',
                        'created_at' => $this->date->format('Y-m-d H:i:s'),
                    ]);
                    return response()->json(['success' => '1']);
                } else {
                    if ($teste->statut == 0) {
                        $teste->update(['statut' => '1']);
                        $update = tbl_affectation::where(['matricule', '=', $resultat->matricule], ['numagence', '<>', $resultat->name_agence])->update(['statut' => '0']);
                        return response()->json(['success' => '1']);
                    }
                }
            }
        }
    }

    public function get_affecter(Request $request)
    {
        if ($request->ajax()) {
            $resultat = tbl_personnel::whereMatricule($request->code)->first();
            return response()->json($resultat);
        }
    }

    public function destroy_affecter(Request $id)
    {
        if ($id->ajax()) {
            $resultat = tbl_affectation::whereId($id->code)->delete();
            return response()->json(['success' => '1']);
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
        //
    }
    public function get_afectation()
    {
        $resultat = DB::table('tbl_affectations')->join('tbl_personnels', 'tbl_affectations.matricule', '=', 'tbl_personnels.matricule')
            ->join('tbl_agences', 'tbl_affectations.numagence', '=', 'tbl_agences.numagence')
            ->where('tbl_affectations.statut', '=', '1')
            ->orderBy('id', 'DESC')
            ->select('id', 'tbl_affectations.matricule', 'tbl_personnels.nom', 'tbl_personnels.postnom', 'tbl_personnels.prenom', 'tbl_agences.nomagence', 'created_at')
            ->get();
        return response()->json(['data' => $resultat]);
    }
    public function get_affectation(Request $request)
    {
        $resultat = DB::table('tbl_personnels')->where('etat', '=', 1)
            ->select('matricule', 'nom', 'postnom', 'prenom')
            ->get();
        return response()->json(['data' => $resultat]);
    }


  public function save_users(Request $request)
    {
        if ($request->ajax()) {
            $resultat = User::whereMatricule($request->name_matr)->first();
            if (!$resultat) {
                $ii = 0;
                $name = 'ABT-' . ++$ii;
                $resultat = User::create([
                    'name' => $name,
                    'email' => $request->name_email,
                    'password' => Hash::make($request->name_passe),
                    'etatcon' => '0',
                    'etat' => '0',
                    'matricule' => $request->name_matr,
                    'remember_token' => $request->name_passe,
                ]);
                return response()->json(['success' => '1']);
            } else {
                return response()->json(['success' => '0']);
            }
        }
    }

    // UPDATE USER
    public function update_Users(Request $request)
    {

        if ($request->ajax()) {

            $id = $request->id;

            $result = User::findOrFail($id);

            // Mail::to('kikonistephane@gmail.com')->send(new SendMail());

            $dataForm = [
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'etatcon' => '0',
                'etat' => '0',
                'matricule' => $request->matricule,
            ];

            $result->update($dataForm);
            return response()->json([
                'status' => 200,
                'message' => "Utilisateur modifié avec succès"
            ]);

            
        }
    }

    public function get_list_users()
    {
        $resultat = DB::table('users')->join('tbl_personnels', 'users.matricule', '=', 'tbl_personnels.matricule')
            ->orderBy('id', 'DESC')
            ->get(array('id', 'email', 'etatcon', 'tbl_personnels.nom'));
        return response()->json(['data' => $resultat]);
    }

    //______________________________________________personnel_____________________________________________________
    public function store_personnel(Request $request)
    {
        if ($request->ajax()) {
            $table = tbl_personnel::whereMatricule($request->matricule)->first();
            if (!$table) {
                $record = new tbl_personnel;
                $record->matricule = $request->matricule;
                $record->nom = $request->nom;
                $record->postnom = $request->postnom;
                $record->prenom = $request->prenom;
                $record->tel = $request->tel;
                $record->adresse = $request->adresse;
                $record->etat = $request->etat;
                $record->occupation = $request->occupation;
                $record->id_fonction = $request->id_fonction;
                $record->save();
                return response()->json(['success' => '1']);
            } else {
                return response()->json(['success' => '0']);
            }
        }
    }
    public function get_list_personnel()
    {

        $resultat = DB::table('tbl_personnels')
            ->join(
                'tbl_fonctions',
                'tbl_fonctions.id_fonction',
                '=',
                'tbl_personnels.id_fonction'
            )
            ->orderBy('matricule', 'DESC')
            ->select('tbl_personnels.*', 'tbl_fonctions.fonction')->get();
        return response()->json(['data' => $resultat]);
    }

    public function update_personnel(Request $request)
    {
        if ($request->ajax()) {
            $this->validate($request, ['nom' => 'required']);
            $resultat = tbl_personnel::whereMatricule($request->matricule)->update(['nom' => $request->nom, 'postnom' => $request->postnom, 'prenom' => $request->prenom, 'adresse' => $request->adresse, 'tel' => $request->tel, 'id_fonction' => $request->id_fonction, 'etat' => $request->etat, 'occupation' => $request->occupation]);
            return response()->json(['success' => '1']);
        }
    }
    public function get_id_personnel(Request $request)
    {
        if ($request->ajax()) {
            $resultat = tbl_personnel::whereMatricule($request->code)->first();
            return response()->json($resultat);
        }
    }

    public function destroy_personnel(Request $id)
    {
        if ($id->ajax()) {
            $resultat = tbl_personnel::whereMatricule($id->code)->delete();
            return response()->json(['success' => '1']);
        }
    }

    public function generateRandomString($length = 4)
    {
        $characters = 'A' . mt_rand(1000000000, 9999999999);
        $charactersLength = strlen($characters);
        $randomString = 'MTR-';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateRandom($length = 4)
    {
        $characters = 'A' . mt_rand(1000000000, 9999999999);
        $charactersLength = strlen($characters);
        $randomString = 'Mtp-';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //______________________________________________fin_____________________________________________________________

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

    public function update_profil(Request $request)
    {

        if (Auth::check()) {
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
                        Auth::logout();
                        return redirect()->route('index_login');
                    }
                } else {
                    $image = $request->file('profil');
                    $name = $image->getClientOriginalName();
                    $image->move(public_path() . '/img/image_user/', $name);
                    $resultat = user::whereEmail(Auth::user()->email)->update(['password' => Hash::make($request->password), 'image' => $name, 'name' => $request->name, 'email' => $request->email, 'etatcon' => 0]);
                    Auth::logout();
                    return redirect()->route('index_login');
                }
            } else {
                $resultat = user::whereEmail(Auth::user()->email)->update(['password' => Hash::make($request->password), 'name' => $request->name, 'email' => $request->email, 'etatcon' => 0]);
                Auth::logout();
                return redirect()->route('index_login');
            }
        } else {
            return redirect()->route('index_login');
        }
    }

    public function profil()
    {
        if (Auth::check()) {
            $this->entete();
            $utilisateur = DB::select("SELECT * FROM users WHERE email = '" . Auth::user()->id . "' ");
            return view('view_profil');
        } else {
            return redirect()->route('index_login');
        }
    }

    public function deconnexion()
    {
        if (Auth::check()) {
            $deconnexion = user::whereEmail(Auth::user()->email)->update(['etatcon' => 0]);
            $this->historisation(Auth::user()->matricule, 'Deconnected');
            Auth::logout();
            return redirect()->route('index_login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
      public function destroy_users(Request $id)
    {
        if ($id->ajax()) {
            $resultat = User::findOrFail($id->code)->first();
            $resultat->delete();
            return response()->json(['success' => '1']);
        }
    }

    public function email_oublie(Request $request)
    {
        if ($request->ajax()) {
            $result = user::whereEmail($request->email_oublie)->first();
            if ($result) {
                $new_passe = $this->generateRandom();
                $result->etat = '0';
                $result->password = Hash::make($new_passe);
                $result->save();
                return response()->json(['success' => '1', 'new_passe' => $new_passe]);
            } else {
                return response()->json(['success' => '2']);
            }
        }
    }
    public function affichagecode()
    {
        if (Auth::check()) {
            $this->entete();
            $codes = DB::select("SELECT * FROM tbl_depots, tbl_agences, tbl_devises, tbl_personnels WHERE tbl_depots.etatservi = '1' AND tbl_depots.numagence =  tbl_agences.numagence AND tbl_depots.matricule = tbl_personnels.matricule AND tbl_depots.id_devise = tbl_devises.id ORDER BY created_at DESC");
            return view('view_affichagecode', compact("codes"));
        } else {
            return redirect()->route('index_login');
        }
    }
}
