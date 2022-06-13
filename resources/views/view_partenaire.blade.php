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
                                        
                                        <div class="form-group col-md-4">
                                            <label class="form-label">INTITULE DU COMPTE</label>
                                            <input type="text" class="form-control" style="border: 1px solid silver" name="type"  id="type" data-validation="required">
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

@section('script')
 $('#btnsave_partenaire').click(function() { 
        var type = $("#type").val();
        var id_partenaire = $("#code_partenaire").val();
        if(type!=''){ 
            if ($("#code_partenaire").val()=='') {
               swal({
        title: 'la colombe Money',
        text: "voulez vous ajouter un partenaire?",
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
                      url   : "{{route('route_create_partenaire')}}",
                      type  : 'POST',
                      async : false,
                      data  : {type:type
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                         swal({title: 'la colombe Money!',
                         text: 'nouveaux partenaire ajouter!',
                         type: 'success'
                         })
                              window.location.href=("{{route('index_partenaire')}}");
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
            html: 'Pas ajouter'
        })
    });
            }
            else{
        swal({
        title: 'Voulez vous modifier?',
        text: "il ya pas moyen de modifie!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,MODIFIER!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                $.ajax({
                      url   : "{{route('route_update_partenaire')}}",
                      type  : 'POST',
                      async : false,
                      data  : {type:$("#type").val(),
                              id_partenaire:$("#code_partenaire").val(),
                               
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                            swal({title: 'la colombe Money!',
                text: 'modification  partenaire!',
                type: 'success'
                })
                           window.location.href=("{{route('index_partenaire')}}");
                        }
                        else{
                            alert('operation non effectuée');
                        }
                       
                      }
                  });
                   })

   }
 }).then(function () {
        swal({
            type: 'info',
            title: 'la colombe Money',
            html: 'les information ne sont pas mofifier'
        })
    });S
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
                           window.location.href=("{{route('index_partenaire')}}");
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
@endsection