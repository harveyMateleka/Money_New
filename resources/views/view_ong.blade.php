@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">O.N.G</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-8">
                            <h4 class="card-header">ENREGISTREMENT D'UN O.N.G</h4>
                            <div class="card-body">
                                <form action="#" method="POST">
                                {{csrf_field()}}
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label class="form-label">NOM O.N.G</label>
                                            <input type="text" class="form-control" data-validation="required" name="nomong" style="text-transform:uppercase;" placeholder="" id="name_ong">
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label class="form-label">NOM PERSONNEL</label>
                                            <input type="text"  style="text-transform:uppercase;" class="form-control" data-validation="required" name="nompersonnel" placeholder="" id="name_Perso">
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label class="form-label">ADRESSE SIEGE</label>
                                            <input type="text" class="form-control" style="text-transform:uppercase;" data-validation="required" name="adresse" placeholder="" id="adresse_siege">
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label class="form-label">TELEPHONE</label>
                                            <input type="number" class="form-control" data-validation="required" name="telservice" placeholder="" id="tel_contact">
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success" name="btnsave_ong" id="btnsave_ong">Enregistre</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de l'ong" id="ong">
                                </form>

                                
                                
                            </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                            <h6 class="card-header">LITE DES ONG</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_ong1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>NOM ONG</th>
                                        <th>NOM PERSONNEL</th>
                                        <th>TEL CONTACT</th>
                                        <th>ADRESSE SIEGE</th>
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

    $('#btnsave_ong').click(function() {
        var name_ong=$("#name_ong").val();
        var name_Perso=$("#name_Perso").val();
        var adresse_siege=$("#adresse_siege").val();
        var tel_contact=$("#tel_contact").val();
        var id=$("#id").val();
        if($("#name_ong").val()!='' && $("#name_Perso").val()!='' && $("#tel_contact").val()!=''&& $("#adresse_siege").val()!=''){ 
            if ($("#ong").val()=='') {   
        swal({
        title: 'La Colombe Money',
        text: "voulez vous ajouter Ong?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui,Ajouter!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {

                $.ajax({
                      url   : "{{route('create_ong')}}",
                      type  : 'POST',
                      async : false,
                      data  : { ong:name_ong,
                                Perso:name_Perso,
                                 siege:adresse_siege,
                                 tel:tel_contact
                      },
                      success:function(data)
                      {
                        //alert(data.success); 
                        
                        if(data.success=='1'){
                        swal({title: 'La Colombe Moeny!',
                        text: 'un nouveau ong ajouté avec success!',
                        type: 'success'
                        })
                            //window.location.href=("{{route('index_create_ong')}}");
                            affiche_ong1();
                            $("#name_ong").val('');
                            $("#name_Perso").val('');
                            $("#adresse_siege").val('');
                            $("#tel_contact").val('');
                        }
                        else{
                              swal({title: 'La Colombe Money !',
                                text: 'Operation non effectué!',
                                type: 'danger'
                                })
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
            title: 'La Colombe Money',
            html: 'Pas ajouter ong'
        })
    });

            }
            else{

              swal({
        title: 'La Colombe Money',
        text: "Voulez vous modifier?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui,modifier!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {

                $.ajax({
                    
                      url   : "{{route('update_ong')}}",
                      type  : 'POST',
                      async : false,
                      data  : {name_ong: $("#name_ong").val(),
                               name_Perso: $("#name_Perso").val(),
                               adresse_siege: $("#adresse_siege").val(),
                               tel_contact: $("#tel_contact").val(),
                               id: $("#ong").val(),
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                        swal({title: 'La Colombe Money!',
                text: 'modification une ong avec success!',
                type: 'success'
                })
                            affiche_ong1();
                            $("#name_ong").val('');
                            $("#name_Perso").val('');
                            $("#adresse_siege").val('');
                            $("#tel_contact").val('');
                        }
                        else{
                            swal({title: 'La Colombe Money!',
                            text: 'Operation non effectuée!',
                            type: 'info'
                            })
                        }
                       
                      }
                  });
                   })

   }
 }).then(function () {
        swal({
            type: 'info',
            title: 'La Colombe Money',
            html: 'les information ne sont pas mofifier'
        })
    });
            }
            
          
        }
    });

    $('body').delegate('.modifier_ong1','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('get_ong')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        $("#ong").val(data.id);
                        $("#name_ong").val(data.name_ong);
                        $("#name_Perso").val(data.name_Perso);
                        $("#adresse_siege").val(data.adresse_siege);
                        $("#tel_contact").val(data.tel_contact);
                        
                        
                      }
                  });
         });
    

 $('body').delegate('.supprimer_ong1','click',function(){
        var ids=$(this).data('id');

            $.ajax({
            url   : "{{route('delete_ong')}}",
            type  : 'POST',
            async : false,
            data  : {code: ids
            },
            success:function(data)
            {
              if(data.success=='1'){
                affiche_ong1();
              }
              else{
                  alert('erreur dans la suppression');
              }
            }
        });
    });
@endsection
