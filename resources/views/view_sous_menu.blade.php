@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Page de Sous Menu</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">  
                        </div>

                        <div class="card col-md-8">
                            <h4 class="card-header">Ajout de Sous Menu</h4>
                            <div class="card-body">
                                <form action="#" method="POST" id="form_sous">
                                {{csrf_field()}}
                                <div class="form-row">
                                        <div class="input-group col-md-6">
                                            <select class="custom-select flex-grow-1" id='name_menu'>
                                                <option value='-1'>SELECTIONER LE MENU</option>
                                                @foreach($resultat as $ligne_menu)
                                                <option value='{!! $ligne_menu->id_menu !!}'>{!! $ligne_menu->item_menu !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                                </br>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label">NOM DU SOUS MENU</label>
                                            <input type="text" style="text-transform:uppercase;" class="form-control" name="name_menu" placeholder="" id="name_smenu">
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="form-label">LIEN DU ROUTE</label>
                                            <input type="text" style="text-transform:uppercase;" class="form-control" name="name_lien" placeholder="" id="name_lien">
                                            <div class="clearfix"></div>
                                        </div>
                                       
                                    </div>

                                    <button type="button" class="btn btn-success" name="btnsave_smenu" id="btnsave_smenu">Enregistre</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_smenu">
                                </form>
                            </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-8">
                            <h6 class="card-header">Liste de Sous Menu</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_smenu">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom de Menu</th>
                                        <th>Nom de Sous Menu</th>
                                        <th>Lien du route</th>
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

@section ('javascript')
<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
            affiche_smenu();
            $('#btnsave_smenu').click(function() { 
        var name_menu=$("#name_menu").val();
        var name_smenu=$("#name_smenu").val();
        var name_lien=$("#name_lien").val();
        if(name_menu!='-1' &&  name_smenu!='' && name_lien!=''){ 
            if ($("#code_smenu").val()=='') {
                
                $.ajax({
                      url   : "{{route('create_smenu')}}",
                      type  : 'POST',
                      async : false,
                      data  : {name_menu:name_menu,
                               name_smenu:name_smenu,
                               name_lien:name_lien
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                            affiche_smenu();
                            $("#name_smenu").val("");
                            $("#name_menu").val("-1");
                            $("#name_lien").val("");
                        }
                        else{
                            $('#affichage_message').html('ce sous menu existe deja');
                            $('#modal_message').modal('show');
                        } 
                      },
                      error:function(data){

                        alert(data.success);                              
                        }
                  });
            }
            else{
                $.ajax({
                      url   : "{{route('update_smenu')}}",
                      type  : 'POST',
                      async : false,
                      data  : {menu: $("#name_menu").val(),
                               name_smenu:name_smenu,
                               name_lien:name_lien,
                               code_smenu:$("#code_smenu").val()
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                            affiche_smenu();
                            $("#name_smenu").val("");
                            $("#name_menu").val("-1");
                            $("#name_lien").val("");
                            $("#code_smenu").val("");
                        }
                        else{
                            alert('operation non effectuée');
                        }
                       
                      }
                  });
            }
            
          
        }
    });
    $('body').delegate('.modifier_smenu','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('get_id_smenu')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        $("#code_smenu").val(data.id_sous);
                        $("#name_lien").val(data.lien);
                        $("#name_smenu").val(data.item_sous);
                        $("#name_menu").val(data.id_menu);
                      }
                  });
         });

         $('body').delegate('.supprimer_smenu','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('delete_smenu')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                            affiche_smenu();
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
              
 });
 function affiche_smenu()
         {
           var otableau=$('#tab_smenu').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_smenu')}}",
                 "columns":[
                     {"data":'id_sous'},
                     {"data":'item_menu'},
                     {"data":'item_sous'},
                     {"data":'lien'},
                     {"data":'id_sous',"autoWidth":true,"render":function (data) {
         
                             return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_smenu" ><i class="fa fa-times"></i></button>'+ ' ' +
                                 '<button data-id='+data+' class="btn btn-info btn-circle modifier_smenu" ><i class="fa fa-check"></i></button>';
                         }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
</script> 
@endsection

