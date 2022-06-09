@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Ajout taux</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-6">
                            <h4 class="card-header">Mise à Jour tauxs</h4>
                            <div class="card-body">
                                <form action="#" method="POST" id="form_taux">
                                {{csrf_field()}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label">INTITULE DEVISE</label>
                                            <input type="text" style="text-transform:uppercase;" class="form-control" name="intitule" placeholder="Saisi intitule" id="intitule">
                                            <div id="mes_ex" style="color:red; font-size:10px;" class="clearfix"></div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Taux</label>
                                            <input type="number" class="form-control" name="taux" placeholder="Saisir Taux" id="taux">
                                        </div>
                                        <div id="ms" style="color:red">ss</div>

                                    </div>
                                    <button type="button" class="btn btn-success" name="btnsave_taux" id="btnsave_taux">Enregistre</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_taux">
                                </form>
                            </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-6      ">
                            <h6 class="card-header">Liste de taux</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_taux">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>intitule</th>
                                        <th>Taux</th>
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
$(document).ready(function() {
    $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
 $('#btnsave_taux').click(function() {
        var id_code=$("#num").val(); 
        var intitule=$("#intitule").val();
        var taux=$("#taux").val();

        if(intitule!='' && taux!=''){ 
            if ($("#code_taux").val()=='') {
                swal({
        title: 'Voulez vous ajouter le taux?',
        text: " est vous sure!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,Ajouter!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                $.ajax({
                      url   : "{{route('route_create_taux')}}",
                      type  : 'POST',
                      async : false,

                      data  : {  id:id_code,
                                 intitule:intitule,
                                 taux:taux
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                         swal({title: 'la colombe Money!',
                text: 'Un nauveau taux ajouter avec succes!',
                type: 'success'
                })
                            window.location.href=("{{route('index_taux')}}");
                        }
                        else{
                            alert('existe deja');
                        } 
                      },
                      error:function(data){

                        alert(data.success);                              
                        }
                  });
                       })
    }
      }).then(function () {
        swal({
            type: 'info',
            title: 'la colombe Money',
            html: 'taux n\'est pas ajouté'
        })
    });
            }
            else{
                swal({
        title: 'Voulez vous modifier le taux?',
        text: " est vous sure!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,Modifier!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                $.ajax({
                      url   : "{{route('route_update_taux')}}",
                      type  : 'POST',
                      async : false,
                      data  : {intitule: $("#intitule").val(),
                               taux: $("#taux").val(),
                               id_code:$("#code_taux").val(),
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                         swal({title: 'la colombe Money!',
                text: 'modification taux avec success!',
                type: 'success'
                })
                            window.location.href=("{{route('index_taux')}}");
                        }
                        else{
                            alert('erreur de transaction');
                        }
                       
                      }
                  });
                        })
    }
      }).then(function () {
        swal({
            type: 'info',
            title: 'la colombe Money',
            html: 'taux ne pas modifier'
        })
    });
            }
            
          
        }else{
        $("#ms").html("Vveuillez remplire tout les champs !");
    }
    });
  
    $('body').delegate('.modifier_taux','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('get_taux')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        $("#intitule").val(data.intitule);
                        $("#taux").val(data.taux);
                        $("#code_taux").val(data.id);
                      }
                  });
         });
    

 $('body').delegate('.supprimer_taux','click',function(){
        var ids=$(this).data('id');
         swal({
        title: 'Voulez vous supprimer le taux ?',
        text: "il ya pas moyen de le  modifier!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,Supprimer!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function() {
          return new Promise(function(resolve, reject) {
            $.ajax({
            url   : "{{route('delete_taux')}}",
            type  : 'POST',
            async : false,
            data  : {code: ids
            },
            success:function(data)
            {
              if(data.success=='1'){
              swal({ title: 'la colombe Money!',
            text: 'suppression du taux avec success!',
            type: 'success'
          })
                  window.location.href=("{{route('index_taux')}}");
              }
              else{
                  alert('erreur dans la suppression');
              }
            }
        });
        })

        }
      }).then(function() {
        swal({
          type: 'info',
          title: 'la colombe Money',
          html: "les information du taux n'est sont pas supprimer"
        })
      });
    });
});
</script> 
@endsection

