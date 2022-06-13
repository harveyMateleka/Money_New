@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Rapport</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
    </div>
    <div class="card col-md-8">
        <h4 class="card-header">Rapport Cash express</h4>
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
                <button type="button" class="btn btn-success" name="btndisplay" id='btndisplay'>Afficher</button>
                <button type="reset" class="btn btn-danger">annule</button>
            </form>
        </div>
    </div>
    <hr class="border-light container-m--x my-4">
    <div class="card col-md-12">
        <h6 class="card-header">Liste des Transaction</h6>
        <div class="card-body">
        <table class="table card-table" id='tab_transfert'>
            <thead class="thead-lisght">
                <tr>
                    <th>Date</th>
                    <th>Agence</th>
                    <th>Partenaire</th>
                    <th>Montant</th>  
                    <th>Devise</th>
                    <th>Operation</th>
                    
                </tr>
            </thead>
    
        </table>
        </div>
    </div>
</div>        
@endsection
@section('script')
$('#btndisplay').click(function(){
    if($('#name_datefin').val() >= $('#name_datedebut').val()){
        afficher_rapport($('#name_datedebut').val(),$('#name_datefin').val());
    }
    else {
       $('#affichage').html('la date debut ne peux pas etre superieure à la date de la fin'); 
    }
});
function afficher_rapport(date_debut,date_fin){
var tableau=[date_debut,date_fin];
    var otableau=$('#tab_transfert').DataTable({
            "bProcessing":true,
            "sAjaxSource":"/admin/liste_rapport/"+tableau,
            "columns":[
                {"data":'date_T'},
                {"data":'nomagence'},
                {"data":'type'},
                {"data":'montant'},
                {"data":'id_devise',"autoWidth":true,"render":function (data) {
                    if(data==1){
                        return 'Usd';
                    }
                    else{
                        return 'Cdf';
                    }
                   }},
                {"data":'operation',"autoWidth":true,"render":function (data) {
                    if(data==1){
                        return 'Depot';
                    }
                    else{
                        return 'Retrait';
                    }
                   }}
            ],
            "pageLength": 7, 
            "bDestroy":true
        });
}

@endsection