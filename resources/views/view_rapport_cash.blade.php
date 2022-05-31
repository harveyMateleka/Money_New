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
            <div class="col-md-4">
                  <label class="form-label"> Agence de Provenance</label>
                  <select class="custom-select flex-grow-1" id='name_agence' name="name_agence" required>
                     <option value='-1'>Choisir une agence</option>
                     @foreach($don as $ligne_agence)
                     <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                     @endforeach
                  </select>
                  @foreach($don as $ligne_agence)
                  <input type="hidden"  class="form-control"  name="{{'agence'.$ligne_agence->numagence}}"  id="{{'agence'.$ligne_agence->numagence}}" value="{{$ligne_agence->nomagence}}">
                   <input type="hidden"  class="form-control"  name="{{'ag_init'.$ligne_agence->numagence}}"  id="{{'ag_init'.$ligne_agence->numagence}}" value="{{$ligne_agence->initial}}">
                  @endforeach
               </div></br>
                

                
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
@section('javascript')
<script type="text/javascript">
    (function() {
    $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });

$('#btndisplay').click(function(){
    if($('#name_datefin').val() >= $('#name_datedebut').val()  && $('#name_agence').val()) {
        afficher_rapport($('#name_datedebut').val(),$('#name_datefin').val(),$('#name_agence').val());
    }
    else {
       $('#affichage').html('la date debut ne peux pas etre superieure à la date de la fin'); 
    }
});

//$('#name_agence').change(function() {
                     //if ($('#name_agence').val() != '-1') {
                      //  afficher_rapport($('#name_agence').val());
                    // } else {
                    // }
    //});


function afficher_rapport(date_debut,date_fin,codeagence1){
var tableau=[date_debut,date_fin,codeagence1];

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
})();
</script>  
@endsection