@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Cash Partenaire</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
    </div>
    <div class="card col-md-12">
        <h4 class="card-header">Cash Partenaire</h4>
        <div class="card-body">
            <form action="#" method="POST">
            {{csrf_field()}}
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
                    <div class="form-group col-md-6">
                        <label class="form-label">Partenaire</label>
                        <select class="form-control" name="partenaire" id="partenaire">
                        <option value="-1">Choisir Partenaire </option>
                        @foreach($banque as $banques)
                            <option value="{{$banques->id_partenaire}}">{{$banques->type}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Devise</label>
                        <select class="form-control" name="devise" id="devise">
                        <option value="-1">Choisir Devise</option>
                        @foreach($devise as $devises)
                            <option value="{{$devises->id}}">{{$devises->intitule}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Operation</label>
                        <select class="form-control" name="operation" id="operation">
                            <option value="2">Depot</option>
                            <option value="1">Retrait</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Montant</label>
                        <input type="number" autocomplete="off" class="currency" name="montant" id="montant">
                    </div>
                </div>
                <button type="button" class="btn btn-success" name="btnsave_trans" id="btnsave_trans">Enregistrer</button>
                <button type="reset" class="btn btn-danger">annule</button>
            </form>
        </div>
    </div>
    <hr class="border-light container-m--x my-4">
    <div class="card col-md-12">
        <h6 class="card-header">Transaction</h6>
        <div class="card-body">
        <table class="table card-table" id='transfert'>
            <thead class="thead-lisght">
                <tr>
                    <th>Date</th>
                    <th>Agence</th>
                    <th>Agent</th>
                    <th>Partenaire</th>
                    <th>Montant</th>  
                    <th>Devise</th>
                    <th>Operation</th>
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
$(document).ready(function() {
    $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
            $("#agence,#operation,#devise,#partenaire").select2();


                     $('#agence').change(function() {
                     if ($('#agence').val() != '-1') {
                        affiche_transfert_partenaire($('#agence').val());
                     } else {
                     }
                     });



  $('#btnsave_trans').click(function() { 
        if($("#montant").val()!='' && $("#agence").val()!='-1' && $("#operation").val()!='-1' && $("#devise").val()!='-1' && $("#partenaire").val()!='-1'){ 
                Swal.fire({  
                        title: 'Colombe Money',
                        html: "Voulez vous effectuer cette operation", 
                        width: 600,
                        padding: '3em',  
                        showDenyButton: true,   
                        confirmButtonText: `Enregistrer`,  
                        denyButtonText: `Annuler`,
                    }).then((result) => { 
                        if (result.isConfirmed) { 
                            $.ajax({
                                url   : "{{route('transfert_banque_insert')}}",
                                type  : 'POST',
                                async : false,
                                data  : {
                                    agence:$("#agence").val(),
                                    montant:$("#montant").val(),
                                    operation:$("#operation").val(),
                                    devise:$("#devise").val(),
                                    partenaire:$("#partenaire").val()

                                },
                                success:function(data)
                                {
                                    if(data.success=='1'){
                                        Swal.fire('opération effectuée', '', 'success')
                                        affiche_transfert_partenaire();
                                        $("#agence").val("-1");
                                        $("#montant").val("");
                                        $("#operation").val("-1");
                                        $("#devise").val("-1");
                                        $("#partenaire").val("-1");
                                    }
                                    else{
                                        Swal.fire('error', '', 'error')
                                    } 
                                },
                                error:function(data){

                                    Swal.fire('error', '', 'error')                            
                                    }
                            });
                        } else if (result.isDenied) {    
                                          Swal.fire('Changes are not saved', '', 'info')  
                                       }
                    });
            
        }
    });
});
function affiche_transfert_partenaire(codeagence)
         {
         var otableau=$('#transfert').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"/admin/liste_transfert_banque/"+codeagence,
             "columns":[
                 {"data":'date_T'},
                 {"data":'nomagence'},
                 {"data":'matricule'},
                {"data":'type'},
                {"data":'montant'},
                 {"data":'intitule'},
                 {"data":'operation',"autoWidth":true,"render":function (data){
                       if (data!='1') {
                             return 'depot';
                         }else{
                             return 'retrait';
                         }
                 }},
                
             ],
             "pageLength": 10,
             "bDestroy":true
         });
         
         }
</script>  
@endsection