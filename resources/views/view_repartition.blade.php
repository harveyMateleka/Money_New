@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">REPARTITION</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-12">
                            <h4 class="card-header">
                            <div>
                        
                          <label>REPARTITION D'ARGENT PAR AGENCE</label>
                          </h4>
                            <div class="red box">
                           </div>
                        <div class="green box">
                      
                    </div>  
                      <div class="card-body">
                            <form action="#" method="POST" id="form_agence">
                            {{csrf_field()}}
                                <div class="form-row">
                                      <div class="form-group col-md-4">
                                      <label class="form-label">Agence</label>
                                        <select class="form-control js-states" name="id_agence" id="id_agence" data-validation="required">
                                        <option value='-1' >Selectionez l'agence</option>
                                        @foreach($resultat as $data)
                                        <option value="{!! $data->numagence !!}">{!! $data->nomagence !!}</option>
                                        @endforeach
                                        </select>
                                      </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Montant CDF</label>
                                        <input type="text" class="currency" autocomplete="off" data-validation="required" name="Montcdf"  id="Montcdf">
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="form-label">Montant USD</label>
                                        <input type="text" class="currency" autocomplete="off" data-validation="required" name="Montusd"  id="Montusd">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                
                                 </div>
                                
                                <button type="button" class="btn btn-success" name="btnsave_repartition" id="btnsave_repartition">REPARTIR</button>
                                <button type="button" class="btn btn-danger">annule</button>
                                <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="code_agence1">
                            </form>
                        </div> 
                </div>   

                        
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                            <h6 class="card-header">Liste de agence</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_agence1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>NOM AGENCE</th>
                                        <th>TEL SERVICE</th>
                                        <th>MONTANTCDF</th>
                                        <th>MONTANTUSD</th>
                                        <th>ACTION</th>
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
            affiche_agence1();
            $("#id_agence").select2();
        $('#btnsave_repartition').click(function() {
        var nomagence=$("#id_agence").val();
        var Montcdf=$("#Montcdf").val();
        var Montusd=$("#Montusd").val();
        if(Montcdf!='' && Montusd!=''){ 
                       swal.fire({
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
                                    url   : "{{route('route_update_repartition')}}",
                                    type  : 'POST',
                                    async : false,
                                    data  : {Montcdf:$("#Montcdf").val(),
                                            Montusd:$("#Montusd").val(),
                                            numagence:$("#id_agence").val(),
                                    },
                                    success:function(data)
                                    {
                                        if(data.success=='1'){
                                            Swal.fire('opération effectuée', '', 'success')
                                            affiche_agence1();
                                            $("#id_agence").val('-1');
                                            $("#Montcdf").val('');
                                            $("#Montusd").val('');
                                        }
                                        else{
                                            Swal.fire('error', '', 'error')
                                        }
                                    
                                    }
                                });
                            }
                                else if (result.isDenied){
                                    Swal.fire('Changes are not saved', '', 'info')  
                                }
                    });

   }

    });

  
   $('body').delegate('.modifier_agence1','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('get_agence')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        $("#id_agence").val(data.numagence);
                        $("#id_agence").change();
                        $("#Montcdf").val(data.Montcdf);
                        $("#Montusd").val(data.Montusd);
                        $("#code_agence1").val(data.numagence);
                      }
                  });
         });
    
        })();

        function affiche_agence1()
         {
         var otableau=$('#tab_agence1').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"{{route('get_list_agence')}}",
             "columns":[
                 {"data":'numagence'},
                 {"data":'nomagence'},
                 {"data":'telservice'},
                 {"data":'Montcdf'},
                 {"data":'Montusd'},
                 {"data":'numagence',"autoWidth":true,"render":function (data) {
                         return'<button data-id='+data+' class="btn btn-info btn-circle modifier_agence1" ><i class="fa fa-check"></i></button>';
                     }}
             ],
             "pageLength": 10,
             "bDestroy":true
         });
         
         }
 
         </script> 
@endsection
