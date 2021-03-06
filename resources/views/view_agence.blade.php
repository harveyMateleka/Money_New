@extends('layouts.header')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="container-fluid flex-grow-1 container-p-y">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Créer une gance</a></li>
    <li><a data-toggle="tab" href="#menu1">Ajouter une ville</a></li>
    <li><a data-toggle="tab" href="#menu2">Droit d'acees</a></li>
  </ul>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
    <h3 class="font-weight-bold py-3 mb-0"></h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
   </div>
   <div class="card col-md-12">
      <h4 class="card-header">AGENCES</h4>
      <div class="card-body">
         <form action="#" method="POST" id="form_agence">
            <div class="form-row">
               {{csrf_field()}}
               <div class="form-group col-md-4">
                  <label class="form-label">NOM AGENCE</label>
                  <input type="text" style="text-transform:uppercase;" class="form-control" required="" name="nomagence" placeholder="" id="nomagence">
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-4">
                  <label class="form-label">ADDRESS</label>
                  <input type="text" style="text-transform:uppercase;" class="form-control"  data-validation="required" name="adresse" placeholder="" id="adresse">
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-4">
                  <label class="form-label">NUMERO SERVICE</label>
                  <input type="text" class="form-control" data-validation="required" name="telservice" placeholder="" id="telservice">
                  <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-4">
                  <select class="form-control "  name="id_ville" data-validation="required" id="id_ville">
                     <option value='-1'>SELECTION VILLE</option>
                     @foreach($resultat as $data)
                     <option value="{{$data->id_ville}}" style="text-transform:uppercase;">{{$data->ville}}</option>
                     @endforeach
                  </select>
               </div>
                <div class="form-group col-md-4">
                  <select class="form-control "  name="indiceag" data-validation="required" id="indiceag">
                     <option value='-1'>INDICE AGENCE</option>
                     <option value='0'>AGENCE</option>
                     <option value='1'>COFFRE</option>
                     <option value='2'>COFFRE DE CREANCE</option>
                     <option value='3'>COFFRE ONG</option>
                     <option value='4'>COFFRE DE DEPENSE</option>
<<<<<<< HEAD
                     <option value='5'>Creance ONG</option>
                    
=======
>>>>>>> rabBranch
                  </select>
               </div>
               <div class="form-group col-md-4">
                  <label class="form-label">INITIAL</label>
                  <input type="text" style="text-transform:uppercase;" class="form-control" required="" name="initial" placeholder="" id="initial">
               </div>
               <div class="clearfix" id="mes_naex" style="color:red"></div>
            </div>
            <button type="button" class="btn btn-success" name="btnsave_agence" id="btnsave_agence">Enregistre</button>
            <button type="reset" class="btn btn-danger">annule</button>
            <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="code_agence">
         </form>
      </div>
   </div>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-12">
      <h6 class="card-header">Liste des agences</h6>
      <div class="card-body">
         <table class="table card-table" id="tab_agence">
            <thead class="thead-light">
               <tr>
                  <th>ID</th>
                  <th>NOM DU agence</th>
                  <th>ADDRESS</th>
                  <th>TEL SERVICE</th>
                  <th>INDICE </th>
                  <th>INITIAL</th>
                  <th>ACTION</th>
               </tr>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
   </div>
    </div>
    <div id="menu1" class="tab-pane fade">
    <div class="container-fluid flex-grow-1 container-p-y">
        <h3 class="font-weight-bold py-3 mb-0">Ville</h3>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        </div>
        <div class="card col-md-12">
            <h4 class="card-header">Ajout Ville</h4>
            <div class="card-body">
                <form action="#" method="POST" id="form_ville">
                {{csrf_field()}}
                @if(empty($message))
                @else
                <p style="font-size :10px; color:red"> {{$message}}</p>
                    @endif
                    <div class="form-row">
        
                        <div class="form-group col-md-6">
                            <label class="form-label">NOM DE LA VILLE/SECTEUR</label>
                            
                            <input type="text" style="text-transform:uppercase;" class="form-control" name="name_ville" placeholder="Saisir le nom de la ville" id="name_ville">
                            
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label class="form-label">INITIAL</label>
                            <input type="text" style="text-transform:uppercase;" class="form-control" name="initial" placeholder="Saisir l'initial de la ville" id="initial">
                            <div class="clearfix"></div>
                        </div>
                        
                    </div>
                    <button type="button" class="btn btn-success" name="btnsave_ville" id="btnsave_ville">Enregistre</button>
                    <button type="button" class="btn btn-danger">annule</button>
                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_ville">
                </form>
            </div>
        </div>
        <hr class="border-light container-m--x my-4">
        <div class="card col-md-12">
            <h6 class="card-header">Liste de ville</h6>
            <div class="card-body">
            <table class="table card-table" id="tab_ville">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>NOM DU VILLE</th>
                        <th>INITIAL</th>
                        <th>ACTION</th>  
                    </tr>
                </thead>
                <tbody>  
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </div>
    <div id="menu2" class="tab-pane fade">
    <div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0"> Permission</h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
   </div>
   <div class="card col-md-8">
      <h4 class="card-header">Droit d'access</h4>
      <div class="card-body">
         <form action="#" method="POST" id="form_sous">
            {{csrf_field()}}
            <div class="form-row">
               <div class="input-group col-md-6">
                  <select class="custom-select flex-grow-1" id='name_fonction'>
                     <option value='-1'>Selectionnez la fonction</option>
                     @foreach($resultat_f as $ligne_fonction)
                     <option value='{!! $ligne_fonction->id_fonction !!}'>{!! $ligne_fonction->fonction !!}</option>
                     @endforeach
                  </select>
               </div>
            </div>
         </form>
      </div>
      <hr class="border-light container-m--x my-4">
      <table class="table card-table" id="tab_permi">
         <thead class="thead-light">
            <tr>
               <th>Id</th>
               <th>Nom de l'option</th>
               <th>Donnez Droit</th>
            </tr>
         </thead>
         <tbody>
            @foreach($resul_smenu as $ligne_menu)
            <tr>
               <td>
                  {!! $ligne_menu->id_sous !!}
               </td>
               <td>
                  {!! $ligne_menu->item_sous !!}
               </td>
               <td>

                  <input type="checkbox" data-id='{{ $ligne_menu->id_sous }}'  class=" checking"/><br>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
      </br>
      <div class="form-row">
        <ddiv class="form-group col-md-8" style="padding-left: 30%">
      <button type="submit" class="btn btn-success" id="btnactualise" >SAUVERGARDE LE SOUS MENU</button>
      </div> 
      </div>         
    </br></br>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-12">
      <h6 class="card-header">Tableau du droit d'access</h6>
      <div class="card-body">
         <table class="table card-table" id="tab_droit">
            <thead class="thead-light">
               <tr>
                  <th>Id</th>
                  <th>Fonction</th>
                  <th>Option de Menu</th>
                  <th>Retirer</th>
               </tr>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
   </div>
</div>
    </div>
  </div>
</div>
<script type="text/javascript">
   $(document).ready(function() {
    $('#tab_agence').DataTable({
    "lengthMenu": [[10, 25, 50, -1], [5, 25, 50, "All"]],
     
      dom: 'Bfrtip',
        buttons: [
            'print', 'copy', 'excel', 'pdf'
            
        ]
  });
} );

</script>


@endsection
<<<<<<< HEAD
@section('javascript')
<script type="text/javascript">
   (function() {
      $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
      $("#ville").select2();
      $("#indiceag").select2();

      $('#btnsave_agence').click(function () {
=======
@section('script')
$("#id_ville").select2();
$("#indiceag").select2();
$('#btnsave_agence').click(function () {
>>>>>>> rabBranch
   var nomagence = $("#nomagence").val();
   var adresse = $("#adresse").val();
   var telservice = $("#telservice").val();
   var id_ville = $("#id_ville").val();
   var indiceag = $("#indiceag").val();
   var initial = $("#initial").val();
   if ($("#nomagence").val() != '' && $("#adresse").val() != '' && $("#id_ville").val() != '-1' && $("#telservice").val() != '' && $("#indiceag").val() != '' && $("#initial").val() != '') {
      if ($("#code_agence").val() == '') {

<<<<<<< HEAD
               swal.fire({
                  title: 'Colombe Money',
                  html: "Voulez vous enregistrer cette agence",
                  width: 600,
                  padding: '3em',
                  showDenyButton: true,
                  confirmButtonText: `Enregistrer`,
                  denyButtonText: `Annuler`,
               }).then((result) => {
                  if (result.isConfirmed) {
                     $.ajax({
                     url: "{{route('route_create_agence')}}",
                     type: 'POST',
                     async: false,
                     data: {
                        nomagence: nomagence,
                        adresse: adresse,
                        telservice: telservice,
                        id_ville: $("#ville").val(),
                        indiceag: indiceag,
                        initial: initial
                     },
                     success: function (data) {
                        if (data.success == '1') {
                           Swal.fire('operation reussie', '', 'success')
                           $("#nomagence").val('');
                           $("#adresse").val('');
                           $("#ville").val("-1");
                           $("#telservice").val("");
                           $("#initial").val("");
                           affiche_agence();
                        } else {
                           alert('existe deja');
                        }
                     },
                     error: function (data) {
                        alert(data.success);
                     }
                  });

         } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
         }
      });
  
      } else {

         swal.fire({
                  title: 'Colombe Money',
                  html: "Voulez vous modifier une agence?",
                  width: 600,
                  padding: '3em',
                  showDenyButton: true,
                  confirmButtonText: `Modifier`,
                  denyButtonText: `Annuler`,
               }).then((result) => {
                  if (result.isConfirmed) {
                     $.ajax({
                     url: "{{route('route_update_agence')}}",
                     type: 'POST',
                     async: false,
                     data: {
                        nomagence: $("#nomagence").val(),
                        adresse: $("#adresse").val(),
                        telservice: $("#telservice").val(),
                        id_ville: $("#ville").val(),
                        numagence: $("#code_agence").val(),
                        indiceag:$("#indiceag").val(),
                        initial:$("#initial").val(),
                     },
                     success: function (data) {
                        if (data.success == '1') {
                           Swal.fire('operation reussie', '', 'success')
                           $("#nomagence").val('');
                           $("#adresse").val('');
                           $("#ville").val("-1");
                           $("#telservice").val("");
                           $("#initial").val("");
                           $("#code_agence").val('');
                           affiche_agence();
                        } else {
                           alert('existe deja');
                        }
                     },
                     error: function (data) {
                        alert(data.success);
                     }
                  });

         } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
         }
      });
=======
      swal({
        title: 'Voulez vous ajouter une agence?',
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
            url: "{{route('route_create_agence')}}",
            type: 'POST',
            async: false,
            data: {
               nomagence: nomagence,
               adresse: adresse,
               telservice: telservice,
               telservice: telservice,
               id_ville: $("#id_ville").val(),
               indiceag: indiceag,
               initial: initial
            },
            success: function (data) {
               if (data.success == '1') {
                swal({title: 'la colombe Money!',
                text: 'Un nauveau agence ajouter!',
                type: 'success'
                })
                  window.location.href = ("{{route('index_agence')}}");
               } else {
                  alert('existe deja');
               }
            },
            error: function (data) {
               alert(data.success);
            }
         });
     
       })
    }
      }).then(function () {
        swal({
            type: 'info',
            title: 'La Colombe Money',
            html: 'Agence n\'est pas ajoutée'
        })
    });
      } else {
      swal({
        title: 'Voulez vous modifier une agence?',
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
            url: "{{route('route_update_agence')}}",
            type: 'POST',
            async: false,
            data: {
               nomagence: $("#nomagence").val(),
               adresse: $("#adresse").val(),
               telservice: $("#telservice").val(),
               id_ville: $("#id_ville").val(),
               numagence: $("#code_agence").val(),
               indiceag:$("#indiceag").val(),
               initial:$("#initial").val(),
            },
            success: function (data) {
               if (data.success == '1') {
                swal({title: 'la colombe Money!',
                text: 'modification agence avec success!',
                type: 'success'
                })
                  window.location.href = ("{{route('index_agence')}}");
               } else {
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
            html: 'Agence n\'est pas modifiée'
        })
    });
>>>>>>> rabBranch
      }
   }else{
    $("#mes_naex").html("tout les champs doivent etre obligatoirement remplire !");
   }
});
$('body').delegate('.modifier_agence', 'click', function () {
   var ids = $(this).data('id');
   $.ajax({
      url: "{{route('get_agence')}}",
      type: 'POST',
      async: false,
      data: {
         code: ids
      },
      success: function (data) {
         $("#nomagence").val(data.nomagence);
         $("#adresse").val(data.adresse);
         $("#telservice").val(data.telservice);
         $("#id_ville").val(data.id_ville);
         $("#indiceag").val(data.indiceag);
         $("#initial").val(data.initial);
         $("#code_agence").val(data.numagence);
      }
   });
});
$('body').delegate('.supprimer_agence', 'click', function () {
   var ids = $(this).data('id');
   $.ajax({
      url: "{{route('delete_agence')}}",
      type: 'POST',
      async: false,
      data: {
         code: ids
      },
      success: function (data) {
         if (data.success == '1') {
            window.location.href = ("{{route('index_agence')}}");
         } else {
            alert('erreur dans la suppression');
         }
      }
   });
});



//________________________________________fonction de ville_______________________________________
$('#btnsave_ville').click(function() { 
             var name_ville=$("#name_ville").val();
             var initial=$("#initial").val();
             if(name_ville!=''){ 
                 if ($("#code_ville").val()=='') {
                    swal({
                    title: 'La Colombe money',
                    text: "voulez vous ajouter une ville?",
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
                           url   : "{{route('route_create_ville')}}",
                           type  : 'POST',
                           async : false,
                           data  : {
                                     name_ville:name_ville,
                                     initial:initial
                                 },
                            
                          
                           success:function(data)
                           {
                             if(data.success=='1'){
               
                                 window.location.href=("{{route('route_index_ville')}}");
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
            title: 'La Colombe Money',
            html: 'la ville n\'est pas ajoutée ! '
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
        confirmButtonText: 'Oui,Modifier!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                     $.ajax({
                           url   : "{{route('route_update_ville')}}",
                           type  : 'POST',
                           async : false,
                           data  : {ville: $("#name_ville").val(),
                                    initial: $("#initial").val(),
                                    code_ville:$("#code_ville").val(),
                           },
                           success:function(data)
                           {
                             if(data.success=='1'){
                                 swal({title: 'La Colombe Money',
                text: 'modification ville avec success!',
                type: 'success'
                })
                                 window.location.href=("{{route('route_index_ville')}}");
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
            title: 'La Colombe Money',
            html: 'les information ne sont pas mofifiées'
        })
    });
                 }
                 
               
             }
         });
         
         $('body').delegate('.modifier_ville','click',function(){
                       var ids=$(this).data('id');
                       $.ajax({
                           url   : "{{route('get_ville')}}",
                           type  : 'POST',
                           async : false,
                           data  : {code: ids
                           },
                           success:function(data)
                           {
                             $("#name_ville").val(data.ville);
                             $("#code_ville").val(data.id_ville);
                             $("#initial").val(data.initial);
                           }
                       });
              });
              $('body').delegate('.supprimer_ville','click',function(){
                       var ids=$(this).data('id');
                        swal({
        title: 'La Colombe Money',
        text: "Voulez supprimer le donnes dans la base de donnees?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui,SUPRIMER!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                       $.ajax({
                           url   : "{{route('delete_ville')}}",
                           type  : 'POST',
                           async : false,
                           data  : {code: ids
                           },
                           success:function(data)
                           {
                             if(data.success=='1'){
                                  swal({title: 'La Colombe Money!',
                text: 'ville suprimer avec success!',
                type: 'success'
                })
                                 window.location.href=("{{route('route_index_ville')}}");
                             }
                             else{
                                 alert('erreur dans la suppression');
                             }
                           }
                       });
            })
   }
 }).then(function () {
        swal({
            type: 'info',
            title: 'La Colombe Money',
            html: 'La ville n\'est pas supprimée !'
        })
    });


//___________________________________________Droit acces_________________________________________________

$('#tab_permi').DataTable({
  "lengthMenu": [
    [10, 25, 50, -1],
    [5, 25, 50, "All"]
  ],
  "pageLength": 7,
  "bDestroy": true
});
$('body').delegate('.checking', 'click', function () {
  var ids = $(this).data('id');
  var name_fonction = $("#name_fonction").val()
  if (name_fonction != '-1') {
    $.ajax({
      url: "{{route('create_droit')}}",
      type: 'POST',
      async: false,
      data: {
        name_fonction: name_fonction,
        name_smenu: ids
      },
      success: function (data) {
        if (data.success == '1') {
          affiche_droit();
        }
      },
      error: function (data) {
        alert(data.success);
      }
    });
  } else {
    $('#affichage_message').html('Veuillez selectionner la fonction');
    $('#modal_message').modal('show');
    $(".checking").prop('checked', false);
  }
});
$('body').delegate('.supprimer_droit', 'click', function (e) {
  var idss = $(e.target).attr("data-id");
  //alert(idss);
  $.ajax({
    url: "{{route('delete_droit')}}",
    type: 'POST',
    async: false,
    data: {
      code: idss
    },
    success: function (data) {
      if (data.success == '1') {
        affiche_droit();
      }
    },
    error: function (data) {
      alert(data.success);
    }
  });
});
$('#btnactualise').click(function () {
  window.location.href = ("{{route('index_droit_access')}}");
});
@endsection