<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Ctrville;
use App\Http\Controllers\Ctrparemetre;
use App\Http\Controllers\Ctrtaux;
use App\Http\Controllers\Ctrpersonnel;
use App\Http\Controllers\Ctrfinance;
use App\Http\Controllers\ctradmin;
use App\Http\Controllers\CtrTransfert;
use App\Http\Controllers\Ctruser;
use App\Http\Controllers\CtrRetrait;
use App\Http\Controllers\Ctraffectation;
use App\Http\Controllers\Ctragence;
use App\Http\Controllers\CtrBanque;
use App\Http\Controllers\Ctrcredit_client;
use App\Http\Controllers\Ctrdepense;
use App\Http\Controllers\CtrOngs;
use App\Http\Controllers\Ctrpartenaire;
use App\Http\Controllers\Ctrcloture;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('view_login');
})->name('index');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/service', function () {
    return view('service');
})->name('service');

Route::get('/apropos', function () {
    return view('apropos');
})->name('apropos');


Route::get('/admin/essaie', [PdfController::class, 'index'])->name('index_essaie');
Route::get('pdf/generate/{id},{a},{v},{t},{e},{te},{b},{tb},{m},{mc},{dev},{raison}', [CtrTransfert::class, 'generatePDF'])->name('route_create3');
Route::get('admin/print/{id}', [CtrTransfert::class, 'print']);
Route::post('admin/generate', [CtrTransfert::class, 'generatecode'])->name('route_generate');
//_____________________________________ville______________________________________
Route::get('admin/ville', [Ctrparemetre::class, 'index_ville'])->name('route_index_ville');
Route::post('admin/create_ville', [Ctrville::class, 'store'])->name('route_create_ville');
Route::post('admin/update_ville', [Ctrville::class, 'update_ville'])->name('route_update_ville');
Route::get('admin/liste_ville', [Ctrville::class, 'get_list'])->name('get_list_ville');
Route::post('admin/get_ville', [Ctrville::class, 'get_id'])->name('get_ville');
Route::post('admin/delete_ville', [Ctrville::class, 'destroy'])->name('delete_ville');
//____________________________________fin____________________________________________
Route::get('admin/fonction', [Ctrparemetre::class, 'index1'])->name('route_index_fonct');
Route::post('admin/save_fonction', [Ctrparemetre::class, 'create_fonction'])->name('create_fonction');
Route::post('admin/update_fonction', [Ctrparemetre::class, 'update_fonct'])->name('update_fonction');
Route::post('admin/delete_fonction', [Ctrparemetre::class, 'destroy'])->name('delete_fonction');
Route::get('admin/get_list_f', [Ctrparemetre::class, 'get_list_f'])->name('get_list_f');
Route::post('admin/get_id_f', [Ctrparemetre::class, 'get_id_f'])->name('get_id_f');
//________________________________________fin fonction________________________________________
//_________________________________________debut typedep______________________________________
Route::get('admin/get_list_typedep', [Ctrparemetre::class, 'get_list_typedep'])->name('get_list_typedep');
Route::get('admin/type_depense', [Ctrparemetre::class, 'index2'])->name('index_typedep');
Route::post('admin/save_typedep', [Ctrparemetre::class, 'create_typedep'])->name('create_typedep');
Route::post('admin/update_typedep', [Ctrparemetre::class, 'update_typedep'])->name('update_typedep');
Route::post('admin/get_id_typedep', [Ctrparemetre::class, 'get_id_typedep'])->name('get_id_typedep');
Route::post('admin/delete_typedep', [Ctrparemetre::class, 'destroy_typedep'])->name('delete_typedep');
//___________________________________________fin typedep_________________________________________________
//____________________________________________debut menu____________________________________________________
Route::get('admin/menu', [Ctrparemetre::class, 'index3'])->name('index_menu');
Route::get('admin/get_list_menu', [Ctrparemetre::class, 'get_list_menu'])->name('get_list_menu');
Route::post('admin/save_menu', [Ctrparemetre::class, 'create_menu'])->name('create_menu');
Route::post('admin/update_menu', [Ctrparemetre::class, 'update_menu'])->name('update_menu');
Route::post('admin/get_id_menu', [Ctrparemetre::class, 'get_id_menu'])->name('get_id_menu');
Route::post('admin/delete_menu', [Ctrparemetre::class, 'destroy_menu'])->name('delete_menu');
//_____________________________________________fin menu_______________________________________________________
//____________________________________________debut sous_menu_________________________________________________
Route::get('admin/sous_menu', [Ctrparemetre::class, 'index4'])->name('index_smenu');
Route::get('admin/get_list_smenu', [Ctrparemetre::class, 'get_list_smenu'])->name('get_list_smenu');
Route::post('admin/save_smenu', [Ctrparemetre::class, 'create_smenu'])->name('create_smenu');
Route::post('admin/update_smenu', [Ctrparemetre::class, 'update_smenu'])->name('update_smenu');
Route::post('admin/get_id_smenu', [Ctrparemetre::class, 'get_id_smenu'])->name('get_id_smenu');
Route::post('admin/delete_smenu', [Ctrparemetre::class, 'destroy_smenu'])->name('delete_smenu');
//____________________________________________fin sous menu___________________________________________________
//___________________________debut permission_________________________________________________________________
Route::get('admin/permission', [Ctrparemetre::class, 'index5'])->name('index_droit_access');
Route::post('admin/save_droit', [Ctrparemetre::class, 'create_droit'])->name('create_droit');
Route::post('admin/delete_droit', [Ctrparemetre::class, 'destroy_droit'])->name('delete_droit');
Route::get('admin/get_list_droit', [Ctrparemetre::class, 'get_list_droit'])->name('get_list_droit');
//____________________________fin_____________________________________________________________________________
//_____________________________________debut users____________________________________________________________
Route::get('admin/users', [Ctruser::class, 'index'])->name('index_users');
Route::get('admin/get_list_users', [Ctruser::class, 'get_list_users'])->name('get_list_users');
Route::post('admin/save_users', [Ctruser::class, 'save_users'])->name('save_users');
Route::post('admin/update_users', [Ctruser::class, 'update'])->name('update_users');
Route::post('admin/destroy_users', [Ctruser::class, 'destroy'])->name('destroy_users');
Route::post('admin/profil', [Ctruser::class, 'update_profil'])->name('update');
Route::post('admin/get_id_user', [Ctruser::class, 'get_id_user'])->name('get_id_user');

//_____________________________________fin____________________________________________________________________
//________________________________debut_affectation___________________________________________________________
Route::get('admin/affectation', [Ctrpersonnel::class, 'index_affectation'])->name('index_affectation');
//
Route::get('admin/afectation', [Ctrpersonnel::class, 'get_afectation'])->name('get_afectation');
Route::get('admin/get_affectation', [Ctrpersonnel::class, 'get_affectation'])->name('get_affectation');
Route::post('admin/create_affectation', [Ctrpersonnel::class, 'create_affectation'])->name('create_affectation');
Route::get('admin/login', [Ctrpersonnel::class, 'index_login'])->name('index_login');
Route::post('admin/login_prossess', [Ctrpersonnel::class, 'login'])->name('create_login'); 
Route::post('admin/update_login', [Ctrpersonnel::class, 'update_login'])->name('update_login');

Route::post('admin/delete_historique', [Ctrpersonnel::class, 'delete_historique'])->name('delete_historique');
Route::get('admin/historique', [Ctrpersonnel::class, 'index_historique'])->name('index_historique');

Route::post('admin/get_id_user', [Ctrpersonnel::class, 'get_id_user'])->name('get_id_user');
//_________________________________fin affectation___________________________________________________________
Route::get('admin/dashboard', [ctradmin::class, 'index'])->name('route_index'); 

//_____________________________________________debut ong______________________________________________________
Route::get('admin/index_ong', [CtrOngs::class, 'index'])->name('index_create_ong');
Route::post('admin/create_ong', [CtrOngs::class, 'store'])->name('create_ong');
Route::post('admin/update_ong', [CtrOngs::class, 'update'])->name('update_ong');
Route::get('admin/list_ong', [CtrOngs::class, 'get_list_ong'])->name('get_list_ongc');
Route::post('admin/get_ong', [CtrOngs::class, 'get_id_ong'])->name('get_ong');
Route::post('admin/delete_ong', [CtrOngs::class, 'destroy'])->name('delete_ong');
Route::get('admin/repartion_ong', [CtrOngs::class, 'repartition_ong'])->name('repart_index');
Route::get('admin/Transfert_ong', [CtrOngs::class, 'Transfert_ong'])->name('index_ongs');
Route::post('admin/save_detail', [CtrOngs::class, 'save_detail'])->name('save_detail');
Route::post('admin/save_ong', [CtrOngs::class, 'save_transfert_ong'])->name('save_ong');
Route::get('admin/charger_ong', [CtrOngs::class, 'charger_transfert'])->name('charger_ong');
Route::get('admin/paiement_ong', [CtrOngs::class, 'index_paie_ong'])->name('index_paie_ong');
Route::post('admin/check_ong', [CtrOngs::class, 'check_ong'])->name('route_paie');
Route::post('admin/sortie_ong', [CtrOngs::class, 'sortie_ong'])->name('sortie_ong');
Route::get('admin/liste_ong', [CtrOngs::class, 'index_liste'])->name('index_liste');
Route::post('admin/cherche_ong', [CtrOngs::class, 'chercher'])->name('chercher');
Route::post('admin/delete_det', [CtrOngs::class, 'delete_det'])->name('delete_det');
Route::get('admin/get_all_paie/{agence}', [CtrOngs::class, 'get_all_paie']);
Route::get('admin/get_all', [CtrOngs::class, 'get_all_detail'])->name('get_all_detail');
Route::get('admin/getMontant/{date_debut},{date_fin}', [CtrOngs::class, 'getMont']);
Route::post('admin/gettotalentre/', [CtrOngs::class, 'gettotalentre'])->name('gettotalentre');



//_____________________________________________fin ong__________________________________________________________

//___________________agence______________________________________________________

Route::get('/agence', [Ctrparemetre::class, 'index_agence'])->name('index_agence'); 
Route::post('/save_agence', [Ctrparemetre::class, 'store_agence'])->name('route_create_agence'); 
Route::post('/get_agence', [Ctrparemetre::class, 'get_id_agence'])->name('get_agence'); 
Route::post('/update_agence', [Ctrparemetre::class, 'update_agence'])->name('route_update_agence');
Route::post('/delete_agence', [Ctrparemetre::class, 'destroy_agence'])->name('delete_agence');
Route::get('/list_agence', [Ctrparemetre::class, 'get_list_agence'])->name('get_list_agence');
//_________________fin__________________________________________________________

//_________________________________________________________personnel__________________________________

Route::get('admin/personnel', [Ctrpersonnel::class, 'indexpersonnel'])->name('index_personnel');
Route::post('admin/create_personnel', [Ctrpersonnel::class, 'store_personnel'])->name('route_create_personnel');
Route::post('admin/update_personnel', [Ctrpersonnel::class, 'update_personnel'])->name('route_update_personnel');
Route::get('admin/liste_personnel', [Ctrpersonnel::class, 'get_list_personnel'])->name('get_list_personnel');
Route::post('admin/get_personnel', [Ctrpersonnel::class, 'get_id_personnel'])->name('get_personnel');
Route::post('admin/delete_personnel', [Ctrpersonnel::class, 'destroy_personnel'])->name('delete_personnel');
//______________________________________________________fin personnel_____________________________________________
//____________________________________________devise taux__________________________________________________________
Route::get('admin/taux', [Ctrtaux::class, 'index'])->name('index_taux');
Route::post('admin/create_taux', [Ctrtaux::class, 'store'])->name('route_create_taux');
Route::post('admin/update_taux', [Ctrtaux::class, 'update_taux'])->name('route_update_taux');
Route::get('admin/liste_taux', [Ctrtaux::class, 'get_list'])->name('get_list_taux');
Route::post('admin/get_taux', [Ctrtaux::class, 'get_id'])->name('get_taux');
Route::post('admin/delete_taux', [Ctrtaux::class, 'destroy'])->name('delete_taux');

//________________________________________________________________________________________________________________
//________________________________debut retrait___________________________
Route::get('admin/sortie', [CtrRetrait::class, 'index'])->name('index_sortie');
Route::post('admin/check_route', [CtrRetrait::class, 'check_sortie'])->name('route_check');
Route::post('admin/save_sortie', [CtrRetrait::class, 'store'])->name('save_sortie');
Route::get('admin/liste_sortie={id}', [CtrRetrait::class, 'show_sortie'])->name('show_sortie');
Route::get('admin/code_servi', [CtrRetrait::class, 'get_code'])->name('get_code');
Route::post('admin/save_sortie', [CtrRetrait::class, 'store'])->name('save_sortie');
Route::get('admin/af_code', [CtrRetrait::class, 'index_codeservi'])->name('affichagecode');
Route::get('admin/aff_code/{debut},{fin}', [CtrRetrait::class, 'get_plage'])->name('get_plage');

//______________________________________fin retrait__________________________________________________________


Route::get('admin/entree', [CtrTransfert::class, 'index_entree'])->name('index_entree');
Route::post('admin/checktel', [CtrTransfert::class, 'checktel'])->name('route_tel');

Route::get('admin/liste_agence={id}', [CtrTransfert::class, 'show_listentree'])->name('list_entree');

Route::post('admin/create_entree', [CtrTransfert::class, 'store_entree'])->name('route_entree');





Route::post('admin/check_route', [CtrTransfert::class, 'check_sortie'])->name('route_check');

Route::post('admin/save_sortie', [CtrTransfert::class, 'save_sortie'])->name('save_sortie');



Route::get('admin/credit_client', [CtrTransfert::class, 'index_credit'])->name('index_credit');
Route::post('admin/get_id_credit', [CtrTransfert::class, 'get_id_credit'])->name('get_id_credit');
Route::post('admin/up_credit_client', [CtrTransfert::class, 'up_credit_client'])->name('up_credit_client');

//Route::get('admin/create_ong', [CtrTransfert::class, 'index_ong'])->name('index_ong');
Route::post('admin/update_credit', [CtrTransfert::class, 'update_credit'])->name('update_credit');
Route::post('admin/update_credit_liste', [CtrTransfert::class, 'update_credit_liste'])->name('update_credit_liste');


Route::get('admin/credit_restitution', [CtrTransfert::class, 'index_restitution'])->name('index_restitution');
Route::post('admin/update_restitution', [CtrTransfert::class, 'update_restitution'])->name('update_restitution');
Route::get('admin/pourcentage', [CtrTransfert::class, 'index_pourcentage'])->name('index_pourcentage');
Route::post('admin/update_pourcentage', [CtrTransfert::class, 'update_pourcentage'])->name('update_pourcentage');
Route::get('admin/cloture', [Ctrcloture::class, 'index'])->name('index_cloture');
Route::post('admin/create_cloture', [Ctrcloture::class, 'store'])->name('store_cloture_agence');
Route::post('admin/check', [Ctrcloture::class, 'check_clotures'])->name('check_clotures');
Route::get('admin/cloturegeneral', [Ctrcloture::class, 'index_cloture1'])->name('index_cloture1');

Route::get('admin/rapport_cash', [CtrTransfert::class, 'index_rapport_s'])->name('index_statistique');

//_______________________________________fin_____________________________

Route::get('admin/banque', [Ctrfinance::class, 'index_banque'])->name('index_banque');
Route::post('admin/create_banque', [Ctrfinance::class, 'store_banque'])->name('route_create_banque');
Route::post('admin/update_banque', [Ctrfinance::class, 'update_banque'])->name('route_update_banque');
Route::get('admin/liste_banque', [Ctrfinance::class, 'get_list_banque'])->name('get_list_banque');
Route::post('admin/get_banque', [Ctrfinance::class, 'get_id_banque'])->name('get_banque');
Route::post('admin/delete_banque', [Ctrfinance::class, 'destroy_banque'])->name('delete_banque');
Route::post('admin/update_rep', [Ctrfinance::class, 'update_repartition'])->name('route_update_repartition');
Route::get('admin/repartition', [Ctrfinance::class, 'index_repartition'])->name('index_repartition');
Route::get('admin/profil', [Ctrpersonnel::class, 'profil'])->name('profil');
Route::post('admin/profil', [Ctrpersonnel::class, 'update_profil'])->name('update');
//__________________________________________deconnexion________________________
Route::get('admin/deconnexion', [Ctrpersonnel::class, 'deconnexion'])->name('deconnexion_user');
//__________________________________________depense_____________________________________________

Route::get('admin/depense', [Ctrfinance::class, 'index_depense'])->name('index_depense');
Route::post('admin/create_depense', [Ctrfinance::class, 'store_depense'])->name('route_create_depense');
Route::post('admin/update_depense', [Ctrfinance::class, 'update_depense'])->name('route_update_depense');
Route::post('admin/update_depense_mod', [Ctrfinance::class, 'update_depense_mod'])->name('update_depense_mod');
Route::get('admin/liste_depense={code}', [Ctrfinance::class, 'get_list_depense']);
Route::get('admin/liste_confir/{dbut},{dfin}', [Ctrfinance::class, 'get_confirmation']);
Route::post('admin/get_depense', [Ctrfinance::class, 'get_id_depense'])->name('get_depense');
Route::post('admin/delete_depense', [Ctrfinance::class, 'destroy_depense'])->name('delete_depense');
Route::post('admin/update_depense', [Ctrfinance::class, 'update_depense'])->name('route_update_depense');
Route::get('admin/confirdepense', [Ctrfinance::class, 'index_confirmationdep'])->name('index_confirdep');
Route::post('admin/update_depense1', [Ctrfinance::class, 'update_depense1'])->name('route_update_depense1');
Route::post('admin/get_depense1', [Ctrfinance::class, 'get_id_depense1'])->name('get_depense1');
Route::get('admin/transfert', [Ctrfinance::class, 'index_transfert'])->name('index_transfert');
Route::get('admin/mvt_banque', [Ctrfinance::class, 'index_mvtbanque'])->name('index_mvtbank');
Route::post('admin/stransfert', [Ctrfinance::class, 'transfert'])->name('transfert');
Route::post('admin/smvt', [Ctrfinance::class, 'store_mvtbanque'])->name('create_mvt');
Route::get('admin/get_mvt', [Ctrfinance::class, 'get_list_mvt'])->name('get_mvt');
Route::post('admin/update_mvt', [Ctrfinance::class, 'update_mvt'])->name('update_mvt');
//______________________________________________________ong__________________________________________________
// Route::post('admin/save_detail', [CtrTransfert::class, 'save_detail'])->name('save_detail');
// Route::post('admin/save_ong', [CtrTransfert::class, 'save_ong'])->name('save_ong');
// //Route::get('admin/charger_ong', [CtrTransfert::class, 'charger_ong'])->name('charger_ong');
// Route::get('admin/paiement_ong', [CtrTransfert::class, 'index_paie_ong'])->name('index_paie_ong');
// Route::post('admin/check_ong', [CtrTransfert::class, 'check_ong'])->name('route_paie');
// Route::post('admin/sortie_ong', [CtrTransfert::class, 'sortie_ong'])->name('sortie_ong');
// Route::get('admin/liste_ong', [CtrTransfert::class, 'index_liste'])->name('index_liste');

Route::post('admin/cherche_ong', [CtrTransfert::class, 'chercher'])->name('chercher');

//_____________________________________________fin ong_______________________________________________________

//__________________________________________raphael_____________________________________________
Route::get('admin/partenaire', [CtrTransfert::class, 'index_partenaire'])->name('index_partenaire');
Route::post('admin/create_partenaire', [CtrTransfert::class, 'store_partenaire'])->name('route_create_partenaire');
Route::post('admin/update_partenaire', [CtrTransfert::class, 'update_partenaire'])->name('route_update_partenaire');
Route::get('admin/liste_partenaire', [CtrTransfert::class, 'get_list'])->name('get_list_partenaire');
Route::post('admin/get_partenaire', [CtrTransfert::class, 'get_id'])->name('get_partenaire');
Route::post('admin/delete_partenaire', [CtrTransfert::class, 'destroy_partenaire'])->name('delete_partenaire');
// root de rabby__________________________________________________________________________________________
Route::get('admin/transfert_banque', [CtrTransfert::class, 'transfert_banque'])->name('transfert_banque');
Route::post('admin/transfert_banque', [CtrTransfert::class, 'transfert_insert'])->name('transfert_banque_insert');
Route::get('admin/liste_transfert_banque', [CtrTransfert::class, 'get_liste_transfert'])->name('get_list_transfert');
//Route::post('admin/get_partenaire', [CtrTransfert::class, 'get_id'])->name('get_partenaire');


//root rapport -----------------------------------------------------------------------------------------
Route::get('admin/rapport_banque', [CtrTransfert::class, 'index_rapport'])->name('index_rapport');
Route::get('admin/liste_rapport/{d},{f}', [CtrTransfert::class, 'get_rapport']);
Route::get('admin/liste_rapportG/{d},{f}', [CtrTransfert::class, 'get_rapportG']);
Route::get('admin/rapport_general', [CtrTransfert::class, 'index_general'])->name('index_general');

Route::get('admin/liste_rapport_general/{d},{f}', [CtrTransfert::class, 'get_rapport_general']);
Route::get('admin/liste_rapport_credit/{d},{f}', [CtrTransfert::class, 'get_rapport_credit1']);
Route::get('admin/liste_rapport_restitution/{d},{f}', [CtrTransfert::class, 'get_rapport_restitution']);


Route::get("admin/barcharts", [CtrTransfert::class,'get_all_entree']);
//---------------------------------cloture de transaction -----------------------
Route::get('admin/partenaire_trans', [CtrTransfert::class, 'partenaire_trans'])->name('partenaire');

Route::post('admin/password_oublie', [Ctrpersonnel::class, 'email_oublie'])->name('email_oublie');
Route::get('admin/index_retrait', [CtrTransfert::class, 'index_retrait'])->name('index_retrait');
Route::post('admin/update_retrait_code', [CtrTransfert::class, 'update_retrait'])->name('update_retrait');




