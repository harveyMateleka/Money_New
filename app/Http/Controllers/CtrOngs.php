<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_ong;
use App\Models\tbl_transfert_ong;
use App\Http\Controllers\ctradmin;
use App\Models\tbl_agence;
use App\Models\tbl_banque;
use App\Models\tbl_detail_t;
use App\Models\tbl_paiement;
use App\Http\Controllers\Ctrpersonnel;
use App\Http\Controllers\CtrTransfert;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DB;

class CtrOngs extends Controller
{
    private $agence;
    private $ong;
    private $banque;
    private $date;
    private $transfert;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $this->entete();
            return view('view_ong');
        } else {
            return redirect()->route('login');
        }
    }

    public function __construct()
    {
        $this->date = new DateTime();
        $this->banque = tbl_banque::all();
        $this->agence = tbl_agence::where('indiceag', '<>', 1)->get();
        $this->ong = tbl_ong::orderBy('name_ong', 'ASC')->get();
        $resultat = tbl_transfert_ong::orderBy('id', 'DESC')->skip(0)->take(1)->first();
        if ($resultat) {
            $this->transfert = $resultat->id + 1;
        } else {
            $this->transfert = 1;
        }
    }

    public function Transfert_ong()
    {
        if (Auth::check()) {
            $this->entete();
            $somme = [];
            $somme = $this->get_total($this->date->format('Y-m-d'));
            $data = [
                'tbl_agence' => $this->agence,
                'tbl_banque' => $this->banque,
                'ong' => $this->ong,
                'transfert' => $this->transfert,
                'resultat' => $somme
            ];
            return view('view_save_ong', $data);
        } else {
            return redirect()->route('login');
        }
    }

    public function repartition_ong()
    {
        if (Auth::check()) {
            $this->entete();
            $resultat = DB::table('tbl_transfert_ongs', 'tbl_transfert')->join('tbl_ongs', 'tbl_transfert.id_ong', '=', 'tbl_ongs.id')
                ->where('tbl_transfert.created_at', '=', $this->date->format('Y-m-d'))
                ->select('mont_trans', 'tbl_transfert.id', 'devise', 'type', 'taux', 'name_ong', 'tbl_transfert.created_at')
                ->orderBy('tbl_transfert.id', 'DESC')
                ->get();
            $data = [
                'tbl_agence' => $this->agence,
                'code_trasanct' => $this->generateRandomString(),
                'data_base' => $resultat
            ];
            return view('view_repartitionOng', $data);
        } else {
            return redirect()->route('login');
        }
    }

    public function chercher(Request $request)
    {
        $resultat = DB::table('tbl_transfert_ongs', 'tbl_transfert')->join('tbl_ongs', 'tbl_transfert.id_ong', '=', 'tbl_ongs.id')
            ->where('tbl_transfert.id', '=', $request->code_tra)
            ->select('mont_trans', 'tbl_transfert.id', 'devise', 'type', 'taux', 'name_ong', 'tbl_transfert.created_at')
            ->orderBy('tbl_transfert.id', 'DESC')
            ->first();

        return response()->json($resultat);
    }

    function generateRandomString($length = 4)
    {
        $characters = 'A' . mt_rand(1000000000, 9999999999);
        $charactersLength = strlen($characters);
        $randomString = 'ABT-';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function recu_agence()
    {
        $affichage = new CtrTransfert;
        return $affichage->recu_agence();
    }


    public function save_detail(Request $request)
    {
        if ($request->ajax()) {

            $requette = DB::table('tbl_detail_ts')->where('id_transf', '=', $request->code)
                ->select(DB::raw('SUM(montp) as montant'))
                ->first();
            if ($requette) {
                if ($requette->montant < $request->total_Mont) {
                    $requet = tbl_detail_t::where('id_transf', '=', $request->code)->where('numagence', '=', $request->desti)
                        ->first();
                    if (!$requet) {
                        $insert = tbl_detail_t::create([
                            'id_transf' => $request->code,
                            'montp' => $request->montant,
                            'numagence' => $request->desti,
                            'code_tr' => $request->code_tra,
                            'created_at' => $this->date->format('Y-m-d')
                        ]);
                        return response()->json(['success' => $this->generateRandomString()]);
                    } else {
                        return response()->json(['success' => '2']);
                    }
                } else {
                    return response()->json(['success' => '2']);
                }
            } else {
                $requet = tbl_detail_t::where('id_transf', '=', $request->code)->where('numagence', '=', $request->desti)
                    ->first();
                if (!$requet) {
                    $insert = tbl_detail_t::create([
                        'id_transf' => $request->code,
                        'montp' => $request->montant,
                        'numagence' => $request->desti,
                        'code_tr' => $request->code_tra,
                        'created_at' => $this->date->format('Y-m-d')
                    ]);
                    return response()->json(['success' => $this->generateRandomString()]);
                } else {
                    return response()->json(['success' => '2']);
                }
            }
        }
    }

    public function save_transfert_ong(Request $request)
    {
        if ($request->ajax()) {
            $montdollars = 0.0;
            $montcdf = 0.0;
            $operation = '';
            $name = '';
            $insert = tbl_transfert_ong::create([
                'id_ong' => $request->ong, 'mont_trans' => $request->montant, 'mont_com' => $request->pour, 'mont_dep' => $request->frais,
                'devise' => $request->devise, 'type' => $request->etat, 'prov' => $request->prov, 'taux' => $request->taux,
                'created_at' => $this->date->format('Y-m-d')
            ]);

            if ($request->etat == 1) {
                $result = tbl_agence::whereNumagence($request->prov)->first();
                if ($result) {
                    $montdollars = $result->Montusd;
                    $montcdf = $result->Montcdf;
                    $name = $result->nomagence;
                }
                if ($request->devise == 1) {
                    $montant = $request->montant + $request->pour + $request->frais;
                    $montdollars += $montant;
                    $operation = "Entrée pour le compte de l'ong du montant " . $montant . " Usd dans l'agence " . $name;
                } else {
                    $montant = $request->montant + $request->pour + $request->frais;
                    $montcdf += $montant;
                    $operation = "Entrée pour le compte de l'ong du montant " . $montant . " Usd dans l'agence " . $name;
                }
                $sult = tbl_agence::whereNumagence($request->prov)->update(['Montusd' => $montdollars, 'Montcdf' => $montcdf]);
                $this->historique(Auth::user()->matricule, $operation);
                $somme = $this->get_total($this->date->format('Y-m-d'));

                return response()->json(['success' => '1', 'resultat' => $somme]);
            } else {
                $student_marks = tbl_banque::where('id', '=', $request->prov)->first();
                $montantt = $request->montant + $request->pour + $request->frais;
                if ($student_marks) {
                    if ($student_marks->devise == $request->devise) {
                        $student_marks->Montant += $montantt;
                        $operation = "Entrée pour le compte de l'ong du montant " . $montantt . " dans le compte " . $student_marks->intitulecompte;
                        $student_marks->save();
                        $this->historique(Auth::user()->matricule, $operation);
                        $somme = $this->get_total($this->date->format('Y-m-d'));
                        return response()->json(['success' => '1', 'resultat' => $somme]);
                    } else {
                        return response()->json(['success' => 'la devise de la transaction est differente de celle de numero de compte']);
                    }
                }
            }
        }
    }
    public function charger_transfert()
    {
        $resultat = DB::table('tbl_transfert_ongs', 'tbl_transfert')->join('tbl_ongs', 'tbl_transfert.id_ong', '=', 'tbl_ongs.id')
            ->select('mont_trans', 'tbl_transfert.id', 'mont_com', 'mont_dep', 'devise', 'type', 'taux', 'montpayé', 'name_ong', 'tbl_transfert.created_at')
            ->orderBy('id', 'DESC')
            ->orderBy('tbl_transfert.created_at', 'DESC')
            ->get();

        return response()->json(['data' => $resultat]);
    }

    public function getMont($date_debut, $date_fin)
    {
        $resultat = tbl_paiement::join('tbl_detail_ts', 'tbl_paiements.code_detail', '=', 'tbl_detail_ts.id')
            ->join('tbl_transfert_ongs', 'tbl_detail_ts.id_transf', '=', 'tbl_transfert_ongs.id')
            ->join('tbl_ongs', 'tbl_transfert_ongs.id_ong', '=', 'tbl_ongs.id')
            ->join('tbl_agences', 'tbl_detail_ts.numagence', '=', 'tbl_agences.numagence')
            ->whereBetween('tbl_paiements.created_at', [$date_debut, $date_fin])
            ->select(DB::raw('SUM(Montpay) as total'), 'name_ong', 'devise', 'nomagence', 'tbl_paiements.created_at')
            ->groupBy('tbl_paiements.created_at', 'name_ong', 'nomagence', 'devise')
            ->get();
        return response()->json(['data' => $resultat]);
    }

    private function get_total($date)
    {
        $montantusd_ag = 0.0;
        $montantcdf_ag = 0.0;
        $montantusd_bq = 0.0;
        $montantcdf_bq = 0.0;
        $resultat = tbl_transfert_ong::select(DB::raw('SUM(mont_trans) as total'), 'type', 'devise',)->whereCreated_at($date)->groupBy('type', 'devise')->get();
        foreach ($resultat as $ligne_resultat) {
            if ($ligne_resultat->type == '1') {
                ($ligne_resultat->devise == '1') ? $montantusd_ag = $ligne_resultat->total : $montantcdf_ag = $ligne_resultat->total;
            } else {
                ($ligne_resultat->devise == '1') ? $montantusd_bq = $ligne_resultat->total : $montantcdf_bq = $ligne_resultat->total;
            }
        }
        $data = [
            "montantusd_ag" => $montantusd_ag,
            "montantcdf_ag" => $montantcdf_ag,
            "montantusd_bq" => $montantusd_bq,
            "montantcdf_bq" => $montantcdf_bq,

        ];
        return  $data;
    }

    public function historique($matricule, $operation)
    {
        $resultat = new Ctrpersonnel;
        return $resultat->historisation($matricule, $operation);
    }

    public function index_paie_ong()
    {
        if (Auth::check()) {
            $this->entete();
            $agence = $this->recu_agence();
            return view('view_sortie_ong', compact('agence'));
        } else {
            return redirect()->route('login');
        }
        //dd($this->get_all_paie(16));

    }

    public function check_ong(Request $request)
    {

        if ($request->ajax()) {

            $requette = DB::table('tbl_detail_ts')->join('tbl_transfert_ongs', 'tbl_detail_ts.id_transf', '=', 'tbl_transfert_ongs.id')
                ->join('tbl_ongs', 'tbl_transfert_ongs.id_ong', '=', 'tbl_ongs.id')
                ->where('code_tr', '=', $request->code)
                ->where('numagence', '=', $request->agence)
                ->select('montp', 'mont_trans', 'devise', 'tbl_detail_ts.id as id_detail', 'name_ong')
                ->first();
            if ($requette) {
                $total = 0.0;
                $result = DB::table('tbl_paiements')
                    ->where('code_detail', '=', $requette->id_detail)
                    ->select(DB::raw('SUM(Montpay) as mont'))
                    ->first();
                if ($result) {
                    $total = $result->mont;
                } else {
                    $total = 0.0;
                }
                return response()->json(['data' => $requette, 'total' => $total, 'success' => '1']);
            } else {
                return response()->json(['success' => "il se peut que ce code n'existe pas ou qui ne doit pas etre payé dans cet agence"]);
            }
        }
    }

    public function sortie_ong(Request $request)
    {
        if ($request->ajax()) {
            $montdollars = 0.0;
            $montcdf = 0.0;
            $name_agence = '';
            $operation = '';
            $requette1 = tbl_detail_t::where('id', '=', $request->code_detail)->first();
            if ($requette1) {
                $requette2 = tbl_transfert_ong::where('id', '=', $requette1->id_transf)->first();
                if ($requette2) {
                    $result = tbl_agence::whereNumagence($requette1->numagence)->first();
                    if ($result) {
                        $montdollars = $result->Montusd;
                        $montcdf = $result->Montcdf;
                        $name_agence = $result->nomagence;
                    }

                    if ($requette2->devise == '1') {
                        if ($montdollars < $request->montant) {
                            return response()->json(['success' => "l'agence n'a pas assez de montant pour faire la sortie"]);
                            exit();
                        } else {
                            $montdollars -= $request->montant;
                            $operation = "paiement de l'ong du montant de " . $request->montant . " Usd dans l'agence de " . $name_agence;
                        }
                    } else {
                        if ($montcdf < $request->montant) {
                            return response()->json(['success' => "l'agence n'a pas assez de montant pour faire la sortie"]);
                            exit();
                        } else {
                            $montcdf -= $request->montant;
                            $operation = "paiement de l'ong du montant de " . $request->montant . " Cdf dans l'agence de " . $name_agence;
                        }
                    }
                    $requette2->montpayé += $request->montant;
                    $requette2->save();
                    $requette = tbl_paiement::create(['code_detail' => $request->code_detail, 'Montpay' => $request->montant, 'created_at' => $this->date->format('Y-m-d')]);
                    $result1 = tbl_agence::whereNumagence($requette1->numagence)->update(['Montcdf' => $montcdf, 'Montusd' => $montdollars]);
                    $this->historique(Auth::user()->matricule, $operation);
                    return response()->json(['success' => '1']);
                }
            }
        }
    }

    public function index_liste()
    {
        if (Auth::check()) {
            $this->entete();
            $requette = DB::table('tbl_paiements', 'paiement')->join('tbl_detail_ts', 'paiement.code_detail', '=', 'tbl_detail_ts.id')
                ->join('tbl_agences', 'tbl_detail_ts.numagence', '=', 'tbl_agences.numagence')
                ->join('tbl_transfert_ongs', 'tbl_detail_ts.id_transf', '=', 'tbl_transfert_ongs.id')
                ->where('paiement.created_at', '=', $this->date->format('Y-m-d'))
                ->select(DB::raw('SUM(Montpay) as mont'), 'nomagence', 'paiement.created_at', 'devise')
                ->groupBy('paiement.code_detail', 'nomagence', 'devise', 'paiement.created_at')
                ->get();
            //dd($requette);
            $resultat=tbl_agence::whereIn('indiceag',array(3,5 ))->get();

            return view('view_liste_paie', compact('requette','resultat'));
        } else {
            return redirect()->route('index_login');
        }
    }


    public function entete()
    {
        $affichage = new ctradmin;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {

            $table = tbl_ong::whereName_ong($request->ong)->first();
            if (!$table) {
                $record = tbl_ong::create([
                    'name_ong' => $request->ong, 'name_Perso' => $request->Perso,
                    'adresse_siege' => $request->siege, 'tel_contact' => $request->tel, 'postnom' => $request->past_name,
                    'prename' => $request->pre_name, 'email' => $request->email, 'tel_contact2' => $request->tele, 'id_user' => Auth::id()
                ]);
                return response()->json(['success' => '1']);
            } else {
                return response()->json(['success' => '0']);
            }
        }
    }

    public function get_id_ong(Request $request)
    {
        if ($request->ajax()) {
            $resultat = tbl_ong::whereId($request->code)->first();
            return response()->json($resultat);
        }
    }
    public function get_list_ong()
    {
        $resultat = tbl_ong::orderBy('id', 'DESC')
            ->get();
        return response()->json(['data' => $resultat]);
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

            $resultat = tbl_ong::whereId($request->id)->update([
                'name_ong' => $request->name_ong, 'name_Perso' => $request->name_Perso,
                'adresse_siege' => $request->adresse_siege, 'tel_contact' => $request->tel_contact,
                'postnom' => $request->past_name, 'prename' => $request->pre_name, 'email' => $request->email, 'tel_contact2' => $request->tele
            ]);
            return response()->json(['success' => '1']);
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
            $resultat = tbl_ong::whereId($id->code)->delete();
            return response()->json(['success' => '1']);
        }
    }

    public function get_all_detail()
    {
        $data = tbl_detail_t::join('tbl_transfert_ongs', 'tbl_detail_ts.id_transf', '=', 'tbl_transfert_ongs.id')
            ->join('tbl_ongs', 'tbl_transfert_ongs.id_ong', '=', 'tbl_ongs.id')
            ->join('tbl_agences', 'tbl_detail_ts.numagence', '=', 'tbl_agences.numagence')
            ->select('tbl_detail_ts.id', 'code_tr', 'tbl_detail_ts.created_at', 'montp', 'nomagence', 'name_ong', 'devise')
            ->orderBy('tbl_detail_ts.id', 'DESC')
            ->get();
        return response()->json(['data' => $data]);
    }

    public function get_all_paie($agence)
    {
        $data = tbl_paiement::join('tbl_detail_ts', 'tbl_paiements.code_detail', '=', 'tbl_detail_ts.id')
            ->join('tbl_transfert_ongs', 'tbl_detail_ts.id_transf', '=', 'tbl_transfert_ongs.id')
            ->join('tbl_ongs', 'tbl_transfert_ongs.id_ong', '=', 'tbl_ongs.id')
            ->join('tbl_agences', 'tbl_detail_ts.numagence', '=', 'tbl_agences.numagence')
            ->where('tbl_detail_ts.numagence', '=', $agence)
            ->select('tbl_paiements.id', 'code_tr', 'tbl_paiements.created_at', 'Montpay', 'nomagence', 'name_ong', 'devise')
            ->orderBy('tbl_paiements.id', 'DESC')
            ->get();
        return response()->json(['data' => $data]);
    }
    public function delete_det(Request $id)
    {
        if ($id->ajax()) {
            $resultat = tbl_detail_t::whereId($id->code)->delete();
            return response()->json(['success' => '1']);
        }
    }
    public function gettotalentre(Request $request)
    {
        if ($request->ajax()) {
            $resultat = tbl_transfert_ong::whereBetween('created_at', [$request->date_debut, $request->date_fin])
                ->select(DB::raw('SUM(mont_trans) as montant'), DB::raw('SUM(mont_com) as montantcom'), DB::raw('SUM(mont_dep) as montantdep'), 'devise')
                ->groupBy('devise')->get();
            return response()->json(['donnee' => $resultat, 'success' => '200']);
        }
    }
}
