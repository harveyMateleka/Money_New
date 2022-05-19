<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_cloture;
use Illuminate\Support\Facades\Auth;
use DB;
use DateTime;
use App\Http\Controllers\ctradmin;
use App\Http\Controllers\CtrTransfert;

class Ctrcloture extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    private $transfert;
    private $admin;
    private $date;

    public function index()
    {
        if (Auth::check()) { 
            $this->admin->index_entete();
            $don=$this->transfert->recu_agence();
            return view('view_cloture',compact('don'));
        }
        else{
            return redirect()->route('login');
          }
    }
    public function __construct(){

        $this->transfert=new CtrTransfert; 
        $this->admin=new ctradmin; 
        $this->date= new DateTime();
    }

    public function index_cloture1()
    { 
           if (Auth::check()) { 
                 $this->admin->index_entete();
                   $totalespesecdf=0.0;
                   $totalespeseusd=0.0;
                   $totalcoffrecdf=0.0;
                   $totalcoffreusd=0.0;
                   $totalpourcentageusd=0.0;
                   $totalpourcentagecdf=0.0;
                   $totalbankusd=0.0;
                   $totalbankcdf=0.0;
                   $totalcreditusd=0.0;
                   $totalcreditcdf=0.0;
                   $totalmvtusd=0.0;
                   $totalmvtcdf=0.0;
                   $capitalusd=0.0;
                   $capitalcdf=0.0;
                   $depensecdf=0.0;
                   $depenseusd=0.0;
                   $diffcdf=0.0;
                   $diffusd=0.0;
   
                   $date = date('Y-m-d');
           
                   //_______toutes les especes des agences et des coffres
               $total=DB::table('tbl_agences')
                  ->select(DB::raw('SUM(Montusd) as mont1'),DB::raw('SUM(Montcdf) as mont'),'indiceag')
                   ->whereIn('indiceag',['0','1'])
                   ->groupBy('indiceag')
                   ->get();
                  foreach ($total as $ligne_total) {
                      if ($ligne_total->indiceag=='0') {
                       $totalespesecdf=$ligne_total->mont;
                       $totalespeseusd=$ligne_total->mont1;
                      } else {
                       $totalcoffrecdf=$ligne_total->mont;
                       $totalcoffreusd=$ligne_total->mont1;
                      }
                  }
                  //___________fin_______________
                  // pour le banque_________________z
                  $banques=DB::table('tbl_banques')->select(DB::raw('SUM(montant) as montant'),'devise')
                  ->groupBy('devise')
                  ->get();
                   
                     foreach ($banques as $request) {
                               if ($request->devise=='1') {
                                   $totalbankusd=$request->montant;
                               }else{
                                   $totalbankcdf =$request->montant;
                               }
       
                           }
               //______________fin banque____________________
   
                //______________________debut mouvement banque___________
                $mvt=DB::table('tbl_mvtbanques')->select(DB::raw('SUM(Montmvt) as montbanques'),'devise')
                ->where('etatmvt','=','0')
                ->groupBy('devise')
                ->get();
                foreach ($mvt as $request) {
                   if ($request->devise=='1') {
                       $totalmvtusd=$request->montbanques;
                   }else{
                       $totalmvtcdf =$request->montbanques;
                   }
               } 
               
               //_________________________fin mvt__________
   $pourcentage=DB::table('tbl_depots')->select(DB::raw('SUM(montpour) as pourusd'),'id_devise')
              ->where('created_at','=',$date)
              ->groupBy('id_devise')
              ->get();
              foreach ($pourcentage as $pour) {
                           if ($pour->id_devise==1) {
                               $totalpourcentageusd=$pour->pourusd;
                           }else{
                               $totalpourcentagecdf =$pour->pourusd;
                           }
                       }
     $credit=DB::table('tbl_depots')->select(DB::raw('SUM(montenvoi) as montenvoi'),'id_devise')
              ->where('etatservi','=','0')
              ->groupBy('id_devise')
              ->get();
     foreach ($credit as $ligne_credit) {
                           if ($ligne_credit->id_devise==1) {
                               $totalcreditusd=$ligne_credit->montenvoi;
                           }else{
                               $totalcreditcdf =$ligne_credit->montenvoi;
                           }
                       }
               $depense=DB::table('tbl_depenses')->select(DB::raw('SUM(montant) as montantdepend'),'devise')
                   ->where('created_at','=',$this->date->format('Y-m-d'))
                   ->where('etat','=','1')
                   ->groupBy('devise')
                   ->get();
     foreach ($depense as $ligne_dep) {
                           if ($ligne_dep->devise=='1') {
                               $depenseusd=$ligne_dep->montantdepend;
                           }else{
                               $depensecdf =$ligne_dep->montantdepend;
                           }
                       } 
   
                       $diffusd=$totalpourcentageusd-$depenseusd;
                       $diffcdf=$totalpourcentagecdf-$depensecdf;
                       if ($diffusd > 0 && $diffcdf >0 ) {
                           $capitalusd=($totalbankusd+$totalespeseusd+$totalmvtusd+$totalcoffreusd+$depenseusd + $diffusd)-($totalcreditusd+$totalpourcentageusd);
                           $capitalcdf=($totalbankcdf+$totalespesecdf+$totalmvtcdf+$totalcoffrecdf+$depensecdf + $diffcdf)-($totalcreditcdf+$totalpourcentagecdf);
                       }
                       elseif($diffusd > 0 && $diffcdf <= 0) {
                           $capitalusd=($totalbankusd+$totalespeseusd+$totalmvtusd+$totalcoffreusd+$depenseusd + $diffusd)-($totalcreditusd+$totalpourcentageusd);
                           $capitalcdf=($totalbankcdf+$totalespesecdf+$totalmvtcdf+$totalcoffrecdf+$depensecdf)-($totalcreditcdf+$totalpourcentagecdf);
                       }
                       elseif($diffusd <= 0 && $diffcdf > 0) {
                           $capitalusd=($totalbankusd+$totalespeseusd+$totalmvtusd+$totalcoffreusd+$depenseusd )-($totalcreditusd+$totalpourcentageusd);
                           $capitalcdf=($totalbankcdf+$totalespesecdf+$totalmvtcdf+$totalcoffrecdf+$depensecdf + $diffcdf)-($totalcreditcdf+$totalpourcentagecdf);
                       }
                       else {
                           $capitalusd=($totalbankusd+$totalespeseusd+$totalmvtusd+$totalcoffreusd+$depenseusd )-($totalcreditusd+$totalpourcentageusd);
                           $capitalcdf=($totalbankcdf+$totalespesecdf+$totalmvtcdf+$totalcoffrecdf+$depensecdf)-($totalcreditcdf+$totalpourcentagecdf);
                      
                       }
                                       
                   $data=['total_bankusd'=> $totalbankusd,
                          'total_bankcdf'=> $totalbankcdf,
                          'totalespesecdf'=>$totalespesecdf,
                          'totalespeseusd'=>$totalespeseusd,
                          'totalpourcentageusd'=>$totalpourcentageusd,
                          'totalpourcentagecdf'=>$totalpourcentagecdf,
                          'totalcreditcdf'=>$totalcreditcdf,
                          'totalcreditusd'=>$totalcreditusd,
                          'totalmvtcdf' =>$totalmvtcdf,
                          'totalmvtusd' =>$totalmvtusd,
                          'capitalcdf'=>$capitalcdf,
                          'capitalusd'=>$capitalusd,
                          'diffcdf'=>$diffcdf,
                          'diffusd'=>$diffusd,
                          'depenseusd'=>$depenseusd,
                          'depensecdf'=>$depensecdf,
                          'coffre_usd'=>$totalcoffreusd,
                          'coffre_cdf'=>$totalcoffrecdf,
                       ];
                       //dd($depense);    
                
                       return view('view_general',$data);  
   
   
   
             } 
             else {
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {

            $table=tbl_cloture::whereNumagence($request->numagence)->whereCreated_at($request->name_date)->first();
            if (!$table) {
                $record= new tbl_cloture;
                $record->departcdf=$request->departcdf;
                $record->departusd=$request->departusd;
                $record->nvdepartcdf=$request->nvdepartcdf;
                $record->nvdepartusd=$request->nvdepartusd;
                $record->totalentrecdf=$request->totalentrecdf;
                $record->totalentreusd=$request->totalentreusd;
                $record->pourcentagecdf=$request->pourcentagecdf;
                $record->pourcentageusd=$request->pourcentageusd;
                $record->created_at=$request->name_date;
                $record->numagence=$requette->numagence;
                $record->save();
                return response()->json(['success'=>'1']);
            }  
            else{
               
                $table->departcdf=$request->departcdf;
                 $table->departusd=$request->departusd;
                 $table->nvdepartcdf=$request->nvdepartcdf;
                 $table->nvdepartusd=$request->nvdepartusd;
                 $table->totalentrecdf=$request->totalentrecdf;
                 $table->totalentreusd=$request->totalentreusd;
                 $table->pourcentagecdf=$request->pourcentagecdf;
                 $table->pourcentageusd=$request->pourcentageusd;
                 $table->created_at=$request->name_date;
                 $table->numagence=$requette->numagence;
                 $table->save();
                return response()->json(['success'=>'2']);
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
    public function destroy($id)
    {
        //
    }

   
    public function check_clotures(Request $request)
    {
        $departNcdf=0.0;
        $departNusd=0.0;
        $totalentreUsd=0.0;
        $totalentreCdf=0.0;
        $pourcUsd=0.0;
        $PourcCdf=0.0;
        $totalsortieUsd=0.0;
        $totalsortieCdf=0.0;
        $totalongusd=0.0;
        $totalongcdf=0.0;
        $totalsongusd=0.0;
        $totalsongcdf=0.0;
        $totalsortieusd=0.0;
        $totalsortiecdf=0.0;
        $totaleusd=0.0;
        $totalecdf=0.0;
        $totalsusd=0.0;
        $totalscdf=0.0;
        $bankEusd=0.0;
        $bankEcdf=0.0;
        $bankSusd=0.0;
        $bankScdf=0.0;
        $ancfranc=0.0;
        $ancdollars=0.0;
        $valeur=0;

            if ($request->name_date < $this->date->format('Y-m-d')) {
                $resultat=tbl_cloture::whereNumagence($request->numagence)
                                      ->where('created_at','=',$request->name_date)->first();
                if ($resultat) {
                    $valeur=1;
                    $departNusd=$resultat->nvdepartusd;
                    $departNcdf=$resultat->nvdepartcdf;
                    $ancfranc=$resultat->departcdf;
                    $ancdollars=$resultat->departusd;
                    $pourcUsd=$resultat->pourcentageusd;
                    $PourcCdf=$resultat->pourcentagecdf;
                }
            }

            $requettebank=DB::table('tbl_mvtbanques')->where('numagence','=',$request->numagence)
            ->where('created_at','=',$request->name_date)
            ->select(DB::raw('SUM(Montmvt) as Montantmvt'),'devise')
            ->groupBy('devise')
            ->get();
                foreach ($requettebank as $ligne_bank) {
                if ($ligne_bank->devise==1) {
                $bankSusd=$ligne_bank->Montantmvt;
                }
                else{
                $bankScdf=$ligne_bank->Montantmvt;
                }
                }

                $requettebank1=DB::table('tbl_mvtbanques')->where('tbl_mvtbanques.prov_ag','=',$request->numagence)
                ->where('updated_at','=',$request->name_date)
                ->select(DB::raw('SUM(Montmvt) as Montantmvt'),'devise')
                ->groupBy('devise')
                ->get();
                foreach ($requettebank1 as $ligne_bank1) {
                if ($ligne_bank1->devise==1) {
                    $bankEusd=$ligne_bank1->Montantmvt;
                }
                else{
                    $bankEcdf=$ligne_bank1->Montantmvt;
                }
                }
             
        

    $entree=DB::table('tbl_depots')->where('numagence','=', $request->numagence)
                                   ->where('created_at','=',$request->name_date)
                                   ->select(DB::raw('SUM(montenvoi) as montant'),DB::raw('SUM(montpour) as montpour'),'id_devise')
                                   ->groupBy('id_devise')
                                   ->get();
        foreach ($entree as $ligne_entree) {
            if ($ligne_entree->id_devise==1) {
                $totalentreUsd=$ligne_entree->montant;
                $pourcUsd=$ligne_entree->montpour;
            }
            else{
                $totalentreCdf=$ligne_entree->montant;
                $PourcCdf=$ligne_entree->montpour;
            }
        }
        $sortie=DB::table('tbl_retraits')->join('tbl_depots','tbl_retraits.id_depot','=','tbl_depots.numdepot')
                                         ->where('tbl_retraits.numagence','=',$request->numagence)
                                         ->where('tbl_retraits.date_servis','=',$request->name_date)
                                         ->select(DB::raw('SUM(montenvoi) as montant'),'tbl_depots.id_devise')
                                         ->groupBy('tbl_depots.id_devise')
                                         ->get();
                foreach ($sortie as $ligne_sortie) {
                if ($ligne_sortie->id_devise==1) {
                    $totalsortieUsd+=$ligne_sortie->montant; 
                }
                else{
                    $totalsortieCdf+=$ligne_sortie->montant;
                }
                }
          $requette=DB::table('tbl_transfert_banques')->
          where('numagence','=',$request->numagence)
                                                      ->where('date_T','=',$request->name_date)
                                                      ->select(DB::raw('SUM(montant) as mont'),'operation','id_devise')
                                                      ->groupBy('operation','id_devise')
                                                      ->get();
           
          foreach ($requette as $ligne_requette) {
             if ($ligne_requette->operation=='1' && $ligne_requette->id_devise==1) {
                $totaleusd=$ligne_requette->mont;
             }
             elseif ($ligne_requette->operation=='1' && $ligne_requette->id_devise==2) {
                $totalecdf=$ligne_requette->mont;
             }
             elseif ($ligne_requette->operation=='2' && $ligne_requette->id_devise==1) {
                $totalsusd=$ligne_requette->mont;
             }
             else{
                $totalscdf=$ligne_requette->mont;
             }
          }

          $requetdepense=DB::table('tbl_depenses')->where('numagence','=',$request->numagence)
          ->where('created_at','=',$request->name_date)
          ->select(DB::raw('SUM(montant) as montantdep'),'devise')
          ->groupBy('devise')
          ->get();


          $requet=DB::table('tbl_transfert_ongs')->where('prov','=',$request->numagence)
                ->where('type','=','1')
                ->where('created_at','=',$request->name_date)
                ->select(DB::raw('SUM(mont_trans) as monttrans'),DB::raw('SUM(mont_com) as montpour'),DB::raw('SUM(mont_dep) as deplac'),'devise')
                ->groupBy('devise')
                ->get();

                $requetong=DB::table('tbl_paiements','paiement')->join('tbl_detail_ts','paiement.code_detail','=','tbl_detail_ts.id')
                ->join('tbl_agences','tbl_detail_ts.numagence','=','tbl_agences.numagence')
                ->join('tbl_transfert_ongs','tbl_detail_ts.id_transf','=','tbl_transfert_ongs.id')
                ->select(DB::raw('SUM(Montpay) as mont'),'tbl_detail_ts.numagence','paiement.created_at','devise')
                ->where('paiement.created_at','=',$request->name_date)
                ->where('tbl_detail_ts.numagence','=',$request->numagence)
                ->groupBy('paiement.code_detail','tbl_detail_ts.numagence','devise','paiement.created_at')
                ->get();

                foreach ($requet as $ligne_requet) {
                    if ($ligne_requet->devise=='1') {
                        $totalongusd=$ligne_requet->montpour + $ligne_requet->monttrans + $ligne_requet->deplac;
                    }else{
                        $totalongcdf =$ligne_requet->montpour + $ligne_requet->monttrans + $ligne_requet->deplac;
                    }
                }
                
      
//___________________________________cloture depense_______________________________
                foreach ($requetdepense as $depense) {
                    if ($depense->devise=='1') {
                        $totalsortieusd=$depense->montantdep;
                    }else{
                        $totalsortiecdf=$depense->montantdep;
                    }
                }

                foreach ($requetong as $ligne_requetong) {
                    if ($ligne_requetong->devise=='1') {
                        $totalsongusd=$ligne_requetong->mont;
                    }else{
                        $totalsongcdf =$ligne_requetong->mont;
                    }
                }

                if ($valeur == 0) {
                    $nouvdepart=DB::table('tbl_agences')->where('numagence','=', $request->numagence)
                                    ->select(DB::raw('SUM(Montcdf) as montcdf'),DB::raw('SUM(Montusd) as montantusd'))
                                    ->first();
                                    if ($nouvdepart) {
                                        $departNcdf=$nouvdepart->montcdf;
                                        $departNusd=$nouvdepart->montantusd;
                                        $ancfranc=($departNcdf+$totalsortieCdf+$totalscdf + $totalsongcdf + $totalsortiecdf+$bankScdf)-($totalentreCdf+$PourcCdf+$totalecdf+$totalongcdf+$bankEcdf);
                                        $ancdollars=($departNusd+$totalsongusd+$totalsortieUsd+$totalsusd + $totalsortieusd+$bankSusd)-($totalentreUsd+$pourcUsd+$totaleusd+$totalongusd+$bankEusd);
                                
                                    }
                }
              
               
        $data=['nouvdepartusd'=> $departNusd,
               'nouvdepartcdf'=> $departNcdf,
               'totalentreusd'=> $totalentreUsd,
               'totalentrecdf'=> $totalentreCdf,
               'pourusd'=> $pourcUsd,
               'pourcdf'=>  $PourcCdf,
               'totalsortiusd'=> $totalsortieUsd,
               'totalsorticdf'=> $totalsortieCdf,
               'ancdepartUsd'=> $ancdollars,
               'ancdepartCdf'=> $ancfranc,
               'totaleusd'=> $totaleusd,
               'totalecdf'=> $totalecdf,
               'totalsusd'=> $totalsusd,
               'totalscdf'=> $totalscdf,
               'totalEOngusd'=> $totalongusd,
               'totalEOngcdf'=> $totalongcdf,
               'totalSONGusd'=> $totalsongusd,
               'totalSONGcdf'=> $totalsongcdf,
               'totaldepusd'=> $totalsortieusd,
               'totaldepcdf'=> $totalsortiecdf,

               'sortiebankusd'=> $bankSusd,
               'sortiebankcdf'=> $bankScdf,
               'entrebankusd'=> $bankEusd,
               'entrebankcdf'=> $bankEcdf,
              ];                           
    
             return response()->json(['data'=>$data]);

}
}
