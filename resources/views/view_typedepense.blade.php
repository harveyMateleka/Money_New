@extends('layouts.header')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Page Type depense</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            
                        </div>

                        <div class="card col-md-8">
                            <h4 class="card-header">Ajout type Depense</h4>
                            <div class="card-body">
                                <form action="#" method="POST" id="form_ville">
                                {{csrf_field()}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Type Depense</label>
                                            <input type="text" class="form-control" name="name_typedep" placeholder="Saisir le type Depense" id="name_typedep">
                                            <div class="clearfix"></div>
                                        </div>
                                       
                                    </div>
                                    <button type="button" class="btn btn-success" name="btnsave_typedep" id="btnsave_typedep">Enregistre</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_typedep">
                                </form>
                            </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-8">
                            <h6 class="card-header">Liste de Type Depense</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_typedep">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Type Depense</th>
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
                affiche_typedep();
    $('#btnsave_typedep').click(function() { 
        var name_typedep=$("#name_typedep").val();
        if(name_typedep!=''){ 
            if ($("#code_typedep").val()=='') {
                
                $.ajax({
                      url   : "{{route('create_typedep')}}",
                      type  : 'POST',
                      async : false,
                      data  : {name_typedep:name_typedep
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                            affiche_typedep();
                            $("#name_typedep").val("");
                        }
                        else{
                            alert('existe deja');
                        } 
                      },
                      error:function(data){

                        alert(data.success);                              
                        }
                  });
            }
            else{
                $.ajax({
                      url   : "{{route('update_typedep')}}",
                      type  : 'POST',
                      async : false,
                      data  : {typedep: $("#name_typedep").val(),
                               code_typedep:$("#code_typedep").val(),
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                            affiche_typedep();
                            $("#name_typedep").val("");
                            $("#code_typedep").val("");
                        }
                        else{
                            alert('operation non effectuée');
                        }
                       
                      }
                  });
            }
            
          
        }
    });
    
    $('body').delegate('.modifier_typedep','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('get_id_typedep')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        $("#name_typedep").val(data.type_dep);
                        $("#code_typedep").val(data.id_typdep);
                      }
                  });
         });

         $('body').delegate('.supprimer_typedep','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('delete_typedep')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                            affiche_typedep();
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
    })();

    function affiche_typedep()
         {
           var otableau=$('#tab_typedep').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_typedep')}}",
                 "columns":[
                     {"data":'id_typdep'},
                     {"data":'type_dep'},
                     {"data":'id_typdep',"autoWidth":true,"render":function (data) {
         
                             return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_typedep" ><i class="fa fa-times"></i></button>'+ ' ' +
                                 '<button data-id='+data+' class="btn btn-info btn-circle modifier_typedep" ><i class="fa fa-check"></i></button>';
                         }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
   
         </script>
@endsection


