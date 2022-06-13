@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0"></h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
   </div>
   <div class="card col-md-6">
      <h4 class="card-header">COMPTE BANCAIRE</h4>
      <div class="card-body">
         <form action="#" method="POST" id="form_personnel">
            {{csrf_field()}}
            <div class="form-row">
               <div class="form-group col-md-6">
                  <label class="form-label">Numero Compte</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important"  type="text" class="form-control" name="numero_compte" placeholder="Numero Compte" id="numero_compte" data-validation="required">
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-6">
                  <label class="form-label">Intitule du Compte</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text"  class="form-control" name="intitulecompte" placeholder="Intitule du Compte" style="text-transform:uppercase;" id="intitulecompte" data-validation="required">
                  <div class="clearfix"></div>
               </div>
               </div>
            <div class="form-row">
              <div class=" col-md-6">
                  <select  style="border: 1px solid silver !important; padding-left: 8px !important"  class="form-control js-states" name="devise" data-validation="" id="devise" data-validation="required">
                     <option disabled selected>Select Devise</option>
                     <option value="2">CDF</option>
                     <option value="1">USD</option>
                  </select>
               </div>
                 <div class="form-group col-md-6">
                  <label class="form-label">Montant </label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="Montant" placeholder="Montant" id="Montant" data-validation="required">
                  <div class="clearfix"></div>
               </div>
            </div>
            <button type="button" class="btn btn-success" name="btnsave_banque" id="btnsave_banque">ENREGISTRE COMPTE</button>
            <button type="reset" class="btn btn-danger">annule</button>
            <input type="hidden" class="form-control" placeholder="Saisir le nom de la personnel" id="code_banque">
         </form>
      </div>
   </div>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-12">
      <h6 class="card-header">Liste des Compte bancaire</h6>
      <div class="card-body">
          <div style="overflow-x:auto;">
         <table class="table card-table" id="tab_banque">
            <thead class="thead-dark">
               <tr>
                  <th>ID BANK</th>
                  <th>NUMERO COMPTE</th>
                  <th>INTITULE</th>
                  <th>DEVISE</th>
                  <th>MONTANT</th>
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
@endsection
@section ('script')
$('#btnsave_banque').click(function () {
   var id = $("#code_banque").val();
   var numero_compte = $("#numero_compte").val();
   var intitulecompte = $("#intitulecompte").val();
   var Montant = $("#Montant").val();
   var devise = $("#devise").val();
   if (numero_compte != '' && numero_compte != '' && intitulecompte != '' && Montant != '' && devise != '') {
      if ($("#code_banque").val() == '') {
       swal({
        title: 'La Colombe Money',
        text: "voulez vous ajouter un compter bancaire?",
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
            url: "{{route('route_create_banque')}}",
            type: 'POST',
            async: false,
            data: {
               numero_compte: numero_compte,
               intitulecompte: intitulecompte,
               Montant: Montant,
               devise: devise
            },
            success: function (data) {
               if (data.success == '1') {
               swal({title: 'La Colombe Money!',
                text: 'Nouvel compter bancaire ajouter avec success !',
                type: 'success'
                })
                affiche_banque();
                $("#code_banque").val("");
                $("#numero_compte").val("");
                $("#intitulecompte").val("");
                $("#Montant").val("");
                $("#devise").val("-1");
                  //window.location.href = ("{{route('index_banque')}}");
               } else {
                  swal({title: 'la colombe Money!',
                text: 'ce numero compte existe dejà !',
                type: 'success'
                });
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
            title: 'la colombe Money',
            html: 'Le compte n\'est pas ajouté '
        })
    });

      } else {
       swal({
        title: 'La Colombe Money',
        text: "Voulez vous modifier les information de la banque?!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OUI,Modifier!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
         $.ajax({
            url: "{{route('route_update_banque')}}",
            type: 'POST',
            async: false,
            data: {
               id : $("#code_banque").val(),
               numero_compte : $("#numero_compte").val(),
               intitulecompte : $("#intitulecompte").val(),
               Montant : $("#Montant").val(),
               devise : $("#devise").val()
               
              
            },
            success: function (data) {
               if (data.success == '1') {
                  swal({title: 'la colombe Money!',
                text: 'modification compte bancaire!',
                type: 'success'
                })
                affiche_banque();
                $("#code_banque").val();
                $("#numero_compte").val();
                $("#intitulecompte").val();
                $("#Montant").val();
                $("#devise").val();
                  //window.location.href = ("{{route('index_banque')}}");
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
            html: 'les information ne sont pas mofifié'
        })
    });
      }
   }
});


$('body').delegate('.modifier_banque', 'click', function () {
   var ids = $(this).data('id');
   $.ajax({
      url: "{{route('get_banque')}}",
      type: 'POST',
      async: false,
      data: {
         code: ids
      },
      success: function (data) {
         $("#numero_compte").val(data.numero_compte);
         $("#intitulecompte").val(data.intitulecompte);
         $("#Montant").val(data.Montant);
         $("#devise").val(data.devise);
         $("#code_banque").val(data.id);
         
      }
   });
});
$('body').delegate('.supprimer_banque', 'click', function () {
   var ids = $(this).data('id');
      swal({
        title: 'La Colombe Money',
        text: "Voulez supprimer le donnes dans la base de donnees ,le donnes ne seront plus trouvables apres suppression!",
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
      url: "{{route('delete_banque')}}",
      type: 'POST',
      async: false,
      data: {
         code: ids
      },
      success: function (data) {
         if (data.success == '1') {
         swal({title: 'la colombe Money!',
                text: 'compte bancaire suprimer avec success!',
                type: 'success'
                })
            window.location.href = ("{{route('index_banque')}}");
         } else {
            alert('erreur dans la suppression');
         }
      }

   });
    })
   }
 }).then(function () {
        swal({
            type: 'info',
            title: 'la colombe Money',
            html: 'Le compte bancaire n\'est pas suppriméz'
        })
    });
});
@endsection