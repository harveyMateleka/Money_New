@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Rapport</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
    </div>
    <div class="card col-md-12">
        <h4 class="card-header">Rapport Cash express</h4>
        <div class="card-body">
            <form action="#" method="POST">
            {{csrf_field()}}
                <div id="affichage" style='color:red; font-size:15px;'>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Agence</label>
                        <select class="form-control" name="agence" id="agence">
                        <option value="-1">Choisir Agence</option>
                            @foreach($agence as $agences)
                            <option value="{{$agences->numagence}}">{{$agences->nomagence}}</option>
                            @endforeach
                        </select>  
                    </div>
                   
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
@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
            $("#agence").select2();

  //affiche_transfert_partenaire();

  $('#agence').change(function() {
         if ($('#agence').val() != '-1') {
            affiche_transferts($("#agence").val());
         } else {
            return '';
         }
      });

      $('#btndisplay').click(function(){
            if($('#name_datefin').val() >= $('#name_datedebut').val() && $('#agence').val() != '-1'){
                $('#affichage').html('');
                let tab=[$('#agence').val(),$('#name_datedebut').val(),$('#name_datefin').val()];
                affiche_transfertes(tab);
            }
            else {
            $('#affichage').html('la date debut ne peux pas etre superieure à la date de la fin'); 
            }
});
});
function affiche_transferts(agence)
         {
         var otableau=$('#tab_transfert').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"/admin/liste_transfert_banque/"+ agence,
             "columns":[
                 {"data":'date_T'},
                 {"data":'nomagence'},
                 {"data":'type'},
                 {"data":'montant',"autoWidth": true,"render": function(data) {
                        let values = formateIndianCurrency(data);
                        return values.substring(0, values.length - 1);
                    }},
                 {"data":'intitule'},
                 {"data":'operation',"autoWidth":true,"render":function(data){
                    if (data =='2') {
                        return "DEPOT";
                    }
                    else {
                        return "RETRAIT";
                    }
                    }},
                 
             ],
             order:[[0,"DESC"]],
             "pageLength": 10,
             "bDestroy":true
         });
         
         }

         function affiche_transfertes(agence,debut,fin)
         {
        let array=[agence,debut,fin];
         var otableau=$('#tab_transfert').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"/admin/liste_rapports/"+ array,
             "columns":[
                 {"data":'date_T'},
                 {"data":'nomagence'},
                 {"data":'type'},
                 {"data":'montant',"autoWidth": true,"render": function(data) {
                        let values = formateIndianCurrency(data);
                        return values.substring(0, values.length - 1);
                    }},
                 {"data":'intitule'},
                 {"data":'operation',"autoWidth":true,"render":function(data){
                    if (data =='2') {
                        return "DEPOT";
                    }
                    else {
                        return "RETRAIT";
                    }
                    }},
                 
             ],
             order:[[0,"DESC"]],
             "pageLength": 10,
             "bDestroy":true
         });
         
         }
</script>  
@endsection