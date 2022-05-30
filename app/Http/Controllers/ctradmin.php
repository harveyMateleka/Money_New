<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_personnel;
use App\Models\user;
use App\Models\tbl_menu;
use App\Models\tbl_depot;
use App\Models\tbl_fonction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
use DateTime;
use  Carbon\carbon;
use Illuminate\Support\Facades\View;
class ctradmin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          if (Auth::check()) {
            $count_actif=0;
           $count_conge=0;
            $count_licencie=0;
            $personnel=tbl_personnel::all();

            foreach ($personnel as  $ligne_personnel) {
                switch ($ligne_personnel->etat) {
                    case 1:
                         $count_actif++;
                        break;
                    case 2:
                         $count_conge++;
                       break;
                    default:
                    $count_licencie++;
                       break;
                }
           }
           $date= new DateTime();

           $result5=DB::table('tbl_depots')->where('created_at','=', $date->format('Y-m-d'))->where('id_devise','=','1')->get();
           $result6=DB::table('tbl_depots')->where('created_at','=', $date->format('Y-m-d'))->where('id_devise','=','2')->get();
           //SORTIE
           $result7=DB::table('tbl_depots')->where('created_at','=', $date->format('Y-m-d'))->where('id_devise','=','1')->where('etatservi','=','1')->get();
           $result8=DB::table('tbl_depots')->where('created_at','=', $date->format('Y-m-d'))->where('id_devise','=','2')->where('etatservi','=','1')->get();
          //CREDIT CLIENT
           $result_credit=DB::table('tbl_depots')->where('created_at','=', $date->format('Y-m-d'))->where('etatservi','=','0')->where('id_devise','=','1')->get();
           $result_credit1=DB::table('tbl_depots')->where('created_at','=', $date->format('Y-m-d'))->where('etatservi','=','0')->where('id_devise','=','2')->get();
           //MOUVEMENT 
           $this->index_entete();


          $data =tbl_depot::select('id','created_at','montenvoi')->where('id_devise','=','2')
          ->get()->groupBy(function($data){
           return Carbon::parse($data->created_at)->format('M-Y');
          });
          $montant=[];
          $months=[];
          $monthCount=[];
          foreach ($data as $month => $values) {
             $months[]=$month;
             $monthCount[]=count($values);
          }
  
         // DOLLARS AMERICAIN
  
          $data1 =tbl_depot::select('id','created_at','montenvoi')->where('id_devise','=','1')
          ->get()->groupBy(function($data1){
           return Carbon::parse($data1->created_at)->format('M-Y');
          });
          $montant1=[];
          $months1=[];
          $monthCount1=[];
          foreach ($data1 as $month1 => $values1) {
             $months1[]=$month1;
             $montant1=[];
             $monthCount1[]=count($values1);
          }  

       // $data =tbl_depot::select('id','created_at')
       // ->get()->groupBy(function($data){
       //  return Carbon::parse($data->created_at)->format('M');
       // });

      

        $arrayName =['nbr_actif'=>$count_actif,
        'nbr_conge'=>$count_conge,
        'nbr_licencie'=>$count_licencie,
        'TotalcreditUsd'=>$result_credit->count(),
        'TotalcreditCdf'=>$result_credit1->count(),
        'TotalEntreUsd'=>$result5->count(),
        'TotalEntreCdf'=>$result6->count(),
        'TotalsortieUsd'=>$result7->count(),
        'TotalSortieCdf'=>$result8->count(),
        'data'=> $data,
        'months'=>$months,
        'monthCount'=>$monthCount,
        'data1'=> $data1,
        'months1'=>$months1,
        'monthCount1'=>$monthCount1
    ];
           return view('dashboard', $arrayName);
            
        }
        else{
            //return redirect()->route('index_login');
        }


     
}
 public function index_entete()
 {
   $personnel=tbl_personnel::whereMatricule(Auth::user()->matricule)->first();

   if($personnel){
         $donnees = DB::table('tbl_droitacces','tbl_droit')->join('tbl_sous_menus','tbl_droit.id_sous','=','tbl_sous_menus.id_sous')
          ->join('tbl_menus','tbl_sous_menus.id_menu','=','tbl_menus.id_menu')
             ->where('tbl_droit.id_fonction', '=', $personnel->id_fonction)
             ->orderBy('tbl_sous_menus.id_menu','ASC')
             ->orderBy('tbl_sous_menus.id_sous','ASC')
             ->select('item_sous', 'lien','item_menu','icon','tbl_sous_menus.id_menu')
             ->get();
             return View::share('donnees',$donnees); 
   }
                 
 }

    public function __construct(){
       $this->middleware('auth'); 
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
        //
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
}
