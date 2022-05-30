@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">AJOUTER PARTENAIRE</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-12">
                            <h4 class="card-header">CASH EXPRESS ET ACCESS </h4>
                            <div class="card-body">
                                <form action="#" method="POST" id="form_personnel">
                                {{csrf_field()}}
                                    <div class="form-row">
                                        
                                        <div class="form-group col-md-8">
                                            <label class="form-label">NOM DE LA BANQUE</label>
                                            <input type="text" class="form-control" name="type"  id="type" data-validation="required">
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
  
                                    <button type="button" class="btn btn-success" name="btnsave_partenaire" id="btnsave_partenaire">ADD PARTENAIRE</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la personnel" id="code_partenaire">
                                </form>
                            </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                            <h6 class="card-header">PARTENAIRES</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_partenaire">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID PARTENAIRE</th>
                                        <th>NOM DU PARTENAIRE</th>
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
 $('#btnsave_partenaire').click(function() { 
        var type = $("#type").val();
        if(type!=''){ 
            if ($("#code_partenaire").val()=='') {
                Swal.fire({  
                        title: 'Colombe Money',
                        html: "Ajout de partenaire", 
                        width: 600,
                        padding: '3em',  
                        showDenyButton: true,   
                        confirmButtonText: `Enregistrer`,  
                        denyButtonText: `Annuler`,
                    }).then((result) => { 
                        if (result.isConfirmed) { 
                            $.ajax({
                                url   : "{{route('route_create_partenaire')}}",
                                type  : 'POST',
                                async : false,
                                data  : {type:type
                                },
                                success:function(data)
                                {
                                    if(data.success=='1'){
                                        Swal.fire('opération effectuée', '', 'success')
                                        affiche_partenaire();
                                        $("#type").val("");
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
    else{

        Swal.fire({  
                        title: 'Colombe Money',
                        html: "Modifier partenaire", 
                        width: 600,
                        padding: '3em',  
                        showDenyButton: true,   
                        confirmButtonText: `Modifier`,  
                        denyButtonText: `Annuler`,
                    }).then((result) => { 
                        if (result.isConfirmed) { 
                            $.ajax({
                                url   : "{{route('route_update_partenaire')}}",
                                type  : 'POST',
                                async : false,
                                data  : {type: $("#type").val(),
                                        id_partenaire: $("#code_partenaire").val()
                                },
                                success:function(data)
                                {
                                    if(data.success=='1'){
                                        Swal.fire('opération effectuée', '', 'success')
                                        affiche_partenaire();
                                        $("#type").val("");
                                        $("#code_partenaire").val("");
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
            
        }
    });


    $('body').delegate('.modifier_partenaire','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('get_partenaire')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        $("#type").val(data.type);
                        $("#code_partenaire").val(data.id_partenaire);
                      }
                  });
         });


         $('body').delegate('.supprimer_partenaire','click',function(){

                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('delete_partenaire')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                            affiche_partenaire();
                        }
                        else{
                            alert('erreur dans la suppression');
                        }
                      },
                      error:function(data){

                      alert(data.success);                              
                      }
                  });
         });
         affiche_partenaire();
        })();
         
        function affiche_partenaire()
         {
           var otableau=$('#tab_partenaire').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_partenaire')}}",
                 "columns":[
                     {"data":'id_partenaire'},
                     {"data":'type'},
                     {"data":'id_partenaire',"autoWidth":true,"render":function (data) {
                          return '<button data-id='+data+' class="btn btn-info btn-circle modifier_partenaire" ><i class="fa fa-check"></i></button>';
                     }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
        </script>  
@endsection