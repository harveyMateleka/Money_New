@extends('layouts.header')
@section('content')

<div class="container-fluid flex-grow-1 container-p-y">
   <div class="card col-md-8">
      <h4 class="card-header">Rapport panel</h4>
      <div class="card-body">
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">RAPPORT %</button>
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1" data-whatever="@fat">RAPPORT ENTREE ET SORTIE</button>
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2" data-whatever="@getbootstrap">RAPPORT CREDIT</button>
        <!--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="# exampleModal4" data-whatever="@getbootstrap">RAPPORT CLOTURE GENERAL</button> -->
        
         <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-12">
                           <h4 class="card-header">RAPPORT DES POURCENTAGES JOUR ,MENSUEL,ANNUEL</h4>
                           <div class="card-body">
                              <form action="#" method="POST">
                                 {{csrf_field()}}
                                 <div id="affichage" style='color:red; font-size:15px;'>
                                 </div>
                                 <div class="form-row">
                                    <div class="form-group col-md-6">
                                       <label class="form-label">Date Debut</label>
                                       <input type="date" class="form-control" name="name_datedebut" id='name_datedebut'>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <label class="form-label">Date Fin</label>
                                       <input type="date" class="form-control" name="name_datefin" id='name_datefin'>
                                    </div>
                                 </div>
                                 <button type="button" class="btn btn-success" name="btndisplay" id='btndisplay1'>Afficher</button>
                                 <button type="reset" class="btn btn-danger">annule</button>
                              </form>
                           </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                           <h6 class="card-header">Liste des Transaction</h6>
                           <div class="card-body">
                              <table class="table card-table" id='tab_pourcentage'>
                                 <thead class="thead-lisght">
                                    <tr>
                                       <th>ID</th>
                                       <th>POURCENTAGE USD</th>
                                       <th>POURCENTAGE CDF</th>
                                       <th>DATE</th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    
                  </div>
               </div>
            </div>
         </div>
         
         
         <!--   ===================================modal 1 ================================-->
         <div class="modal fade bd-example-modal-lg" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-12">
                           <h4 class="card-header">RAPPORT A RESTITUER JOUR ,MENSUEL,ANNUEL</h4>
                           <div class="card-body">
                              <form action="#" method="POST">
                                 {{csrf_field()}}
                                 <div id="affichage2" style='color:red; font-size:15px;'>
                                 </div>
                                 <div class="form-row">
                                    <div class="form-group col-md-6">
                                       <label class="form-label">Date Debut</label>
                                       <input type="date" class="form-control" name="name_datedebut" id='name_datedebut4'>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <label class="form-label">Date Fin</label>
                                       <input type="date" class="form-control" name="name_datefin" id='name_datefin4'>
                                    </div>
                                 </div>
                                 <button type="button" class="btn btn-success" name="btndisplay" id='btndisplay2'>Afficher</button>
                                 <button type="reset" class="btn btn-danger">annule</button>
                              </form>
                           </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                           <h6 class="card-header">Liste des Transaction</h6>
                           <div class="card-body">
                              <table class="table card-table" id='tab_restitution'>
                                 <thead class="thead-lisght">
                                    <tr>
                                       <th>Code</th>
                                       <th>Benefi</th>
                                       <th>Phone</th>
                                       <th>Montant</th>
                                       <th>Devise</th>
                                       <th>Etat</th>
                                       <th>Date</th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     
                  </div>
               </div>
            </div>
         </div>
         <!--   ===================================modal 2================================-->
         <div class="modal fade bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-12">
                           <h4 class="card-header">RAPPORT DES CREDITS JOUR ,MENSUEL,ANNUEL</h4>
                           <div class="card-body">
                              <form action="#" method="POST">
                                 {{csrf_field()}}
                                 <div id="affichage1" style='color:red; font-size:15px;'>
                                 </div>
                                 <div class="form-row">
                                    <div class="form-group col-md-6">
                                       <label class="form-label">Date Debut</label>
                                       <input type="date" class="form-control" name="name_datedebut" id='name_datedebut3'>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <label class="form-label">Date Fin</label>
                                       <input type="date" class="form-control" name="name_datefin" id='name_datefin3'>
                                    </div>
                                 </div>
                                 <button type="button" class="btn btn-success" name="btndisplay" id='btndisplay3'>Afficher</button>
                                 <button type="reset" class="btn btn-danger">annule</button>
                              </form>
                           </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                           <h6 class="card-header">Liste des Transaction</h6>
                           <div class="card-body">
                              <table class="table card-table" id='tab_credit'>
                                 <thead class="thead-lisght">
                                    <tr>
                                       
                                       <th>Code</th>
                                       <th>Benefi</th>
                                       <th>Phone</th>
                                       <th>Montant</th>
                                       <th>Devise</th>
                                       <th>Date</th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
<!--================================================modal 3 ======================-->
           <div class="modal fade bd-example-modal-lg" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
      
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

             <div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Rapport Cloture</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
    </div>
    <div class="card col-md-8">
        <h4 class="card-header">Rapport du cloture Generale</h4>
        <div class="card-body">
            <form action="#" method="POST">
            {{csrf_field()}}
                <div id="affichage" style='color:red; font-size:15px;'>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Date Debut</label>
                        <input type="date" class="form-control" name="name_datedebut5" id='name_datedebut5'>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Date Fin</label>
                        <input type="date" class="form-control" name="name_datefin5" id='name_datefin5'>
                    </div>
                </div>
                <button type="button" class="btn btn-success" name="btndisplay" id='btndisplay'>Afficher</button>
                <button type="reset" class="btn btn-danger">annule</button>
            </form>
        </div>
    </div>
    <hr class="border-light container-m--x my-4">
    <div class="card col-md-12">
        <h6 class="card-header">Detail de la cloture</h6>
        <div class="card-body">
        <table class="table card-table" id='tab_clotureG'>
            <thead class="thead-lisght">
                <tr>
                    <th>Date</th>
                    <th>Agence</th>
                    <th>Nv.Depart-Usd</th>
                    <th>Nv.Depart Cdf</th>
                    <th>Ac.Depart Usd</th>
                    <th>Ac.Depart Cdf</th>
                    <th>Tot entrée Usd</th>
                    <th>Tot entrée Cdf</th>
                    <th>Total % Usd</th>
                    <th>Total % Cdf</th>     
                </tr>
            </thead>
    
        </table>
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script type="text/javascript">
    (function() {
    $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
$('#btndisplay1').click(function(){
    if($('#name_datefin').val() >= $('#name_datedebut').val()){
        afficher_general($('#name_datedebut').val(),$('#name_datefin').val());
    }
    else {
       $('#affichage').html('la date debut ne peux pas etre superieure à la date de la fin'); 
    }
});

$('#btndisplay3').click(function(){
    if($('#name_datefin3').val() >= $('#name_datedebut3').val()){
        afficher_credit($('#name_datedebut3').val(),$('#name_datefin3').val());
    }
    else {
       $('#affichage1').html('la date debut ne peux pas etre superieure à la date de la fin'); 
    }
});


$('#btndisplay2').click(function(){
    if($('#name_datefin4').val() >= $('#name_datedebut4').val()){
        afficher_restitution($('#name_datedebut4').val(),$('#name_datefin4').val());
    }
    else {
       $('#affichage2').html('la date debut ne peux pas etre superieure à la date de la fin'); 
    }
});

$('#btndisplay').click(function(){
    if($('#name_datefin5').val() >= $('#name_datedebut5').val()){
        afficher_rapportG($('#name_datedebut5').val(),$('#name_datefin5').val());
    }
    else {
       $('#affichage5').html('la date debut ne peux pas etre superieure à la date de la fin'); 
    }
});
})();


//=========================================pourcentage===============================

function afficher_general(date_debut,date_fin){
var tableau=[date_debut,date_fin];

    var otableau=$('#tab_pourcentage').DataTable({
      dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
            "bProcessing":true,
            "sAjaxSource":"/admin/liste_rapport_general/"+tableau,
            "columns":[
                {"data":'id'},
                {"data":'pourceusd'},
                {"data":'pourcecdf'},
                {"data":'created_at'},
               
            ],
            "pageLength": 7, 
            "bDestroy":true
        });
    }
//==========================================================restitution==========================

function afficher_restitution(date_debut,date_fin){
var tableau=[date_debut,date_fin];
    var otableau=$('#tab_restitution').DataTable({
      dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
            "bProcessing":true,
            "sAjaxSource":"/admin/liste_rapport_restitution/"+tableau,
            "columns":[
                {"data":'numdepot'},
                {"data":'nomben'},
                {"data":'telclient'},
                {"data":'montenvoi'},
                {"data":'id_devise'},
                {"data":'etatservi'},
                {"data":'created_at'},
               
            ],
            "pageLength": 7, 
            "bDestroy":true
        });
     }

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++CLOTURE GENERALE+++++µ
function afficher_rapportG(date_debut5,date_fin5){
var tableau=[date_debut5,date_fin5];
    var otableau=$('#tab_clotureG').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
            "bProcessing":true,
            "sAjaxSource":"/admin/liste_rapportG/"+tableau,
            "columns":[
                {"data":'created_at'},
                {"data":'nomagence'},
                {"data":'nvdepartusd'},
                {"data":'nvdepartcdf'},
                {"data":'departusd'},
                {"data":'departcdf'},
                {"data":'totalentreusd'},
                {"data":'totalentrecdf'},
                {"data":'pourcentageusd'},
                {"data":'pourcentagecdf'} 
            ],
            "pageLength": 7, 
            "bDestroy":true
        });
}


function afficher_credit(date_debut3,date_fin3){
var tableau=[date_debut3,date_fin3];
    var otableau=$('#tab_credit').DataTable({
      dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
            "bProcessing":true,
            "sAjaxSource":"/admin/liste_rapport_credit/"+tableau,
            "columns":[
                {"data":'numdepot'},
                {"data":'nomben'},
                {"data":'telclient'},
                {"data":'montenvoi'},
                {"data":'id_devise',"autoWidth":true,"render":function (data){
                        if (data!=1 ) {
                             return 'cdf';
                         }else{
                             return 'Usd'
                         }
         
                 }},
                {"data":'created_at'},
               
            ],
            "pageLength": 7, 
            "bDestroy":true
        });
     }
     </script>  
@endsection