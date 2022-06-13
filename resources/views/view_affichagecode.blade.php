@extends('layouts.header')
@section('content')
<div class="modal fade bd-example-modal-lg" id="modal_servis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid flex-grow-1 container-p-y">
            <div class="text-muted small mt-0 mb-4 d-block breadcrumb"></div>
            <div class="card col-md-12">
              <h4 class="card-header">Detail du Code Servis</h4>
              <div class="card-body">
                <form action="#" method="POST">
                  {{csrf_field()}}
                  <div class="form-row"> 
                  <div class="form-group col-md-6">
                      <label class="form-label">Expéditeur</label>
                      <input type="text" class="form-control" name="" id='expediteur'>
                    </div>
                    <div class="form-group col-md-6">
                      <label class="form-label">Tél expediteur</label>
                      <input type="text" class="form-control" name="" id='telexp'>
                    </div>
                    </div>
                    <div class="form-row"> 
                    <div class="form-group col-md-6">
                      <label class="form-label">Nom Beneficiaire</label>
                      <input type="text" class="form-control" name="" id='beneficiere'>
                    </div>
                    <div class="form-group col-md-6">
                      <label class="form-label">Tél Beneficiaire</label>
                      <input type="text" class="form-control" name="" id='telben'>
                    </div>
                  </div>
                  <div class="form-row">
                  <div class="form-group col-md-6">
                      <label class="form-label">Date d'envoi</label>
                      <input type="text" class="form-control" name="" id='date'>
                    </div>
                    <div class="form-group col-md-6">
                      <label class="form-label">Agence de Provenance</label>
                      <input type="text" class="form-control" name="" id='agence'>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <hr class="border-light container-m--x my-4">
<div class="container-fluid flex-grow-1 container-p-y">
        
        <hr class="border-light container-m--x my-4">
        <div class="card col-md-12">
            <h6 class="card-header">Liste des codes servvis</h6>
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
            </form> </br><hr>
            <table class="table card-table" id='code_servis'>
                <thead class="thead-light">
                    <tr>
                        <th>Id</th>
                        <th>Agence</th>
                        <th>Agent</th>
                        <th>Code</th>
                        <th>Montant</th>
                        <th>Devise</th>
                        <th>Date</th>
                        <th>Action</th>      
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
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
        formater();
            $('#btndisplay').click(function() {
                if($('#name_datefin').val() >= $('#name_datedebut').val()){
            affiche_date($('#name_datedebut').val(),$('#name_datefin').val());
                }
                else {
                $('#affichage').html('la date debut ne peux pas etre superieure à la date de la fin'); 
            }
        });

        $('body').delegate('.edit','click',function(){
        var ids=$(this).data('id');
        $.ajax({
            url: "{{route('get_id_credit')}}",
            type: 'POST',
            async: false,
            data: {
            code: ids,
            },
            success: function (data) {

                $("#beneficiere").val(data.nomben);
                $("#agence").val(data.nomagence);
                $("#expediteur").val(data.nomclient);
                $("#telben").val(data.telclient);
                $("#telexp").val(data.tel);
                $("#date").val(data.created_at);
                $('#modal_servis').modal('show');  
            
            }
  });

 });

    })();

    function formater(){
        var otableau=$('#code_servis').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_code')}}",
                 "columns":[
                     {"data":'id'},
                     {"data":'nomagence'},
                     {"data":'name'},
                     {"data":'numdepot'},
                     {"data":'montenvoi',"autoWidth":true,"render":function (data){
                        let mont=formateIndianCurrency(data);
                        let new_value=mont.substring(0,mont.length - 1);
                        return new_value;
                     }},
                     {"data":'intitule'},
                     {"data":'date_servis'},
                     
                     {"data":'numdepot',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-warning btn-circle edit" >Edit</button>';
                          }}
                    
                 ],
                 "pageLength": 10, 
                 "bDestroy":true,
                 responsive:true,
             });  
    }

    function affiche_date(date_debut,date_fin){
        var tableau=[date_debut,date_fin];
        var otableau=$('#code_servis').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"/admin/aff_code/"+tableau,
                 "columns":[
                     {"data":'id'},
                     {"data":'nomagence'},
                     {"data":'name'},
                     {"data":'numdepot'},
                     {"data":'montenvoi',"autoWidth":true,"render":function (data){
                        let mont=formateIndianCurrency(data);
                        let new_value=mont.substring(0,mont.length - 1);
                        return new_value;
                     }},
                     {"data":'intitule'},
                     {"data":'date_servis'},
                     
                     {"data":'numdepot',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-warning btn-circle print" >Edit</button>';
                          }}
                    
                 ],
                 "pageLength": 10, 
                 "bDestroy":true,
                 responsive:true,
             });  
    }
</script>
@endsection