@extends('layouts.header')
@section('content')
<div class="modal fade" id="modal_personnel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">LISTE DES AGENTS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <table class="table card-table" id='tab_person'>
               <thead class="thead-light">
                  <tr>
                     <th>Matricule</th>
                     <th>Nom</th>
                     <th>PostNom</th>
                     <th>Prenom</th>
                     <th>ACTION</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0"></h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
   </div>
   <div class="card col-md-12">
      <h3 class="card-header">Affecter un Agent</h3>
      <div class="card-body">
         <form action="#" method="POST" id="form_affectation">
            {{csrf_field()}}
            <div class="row">
               <div class="col-md-3">
                  <div class="form-row">
                     <label class="form-label">MATRICULE</label>
                     <input type="text" class="form-control" style="text-transform:uppercase; border: 1px solid silver; padding-left: 8px !important" name="name_matr" placeholder="Afficher le matricule" id="name_matr">
                     <div class="clearfix"></div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-row">
                     <label class="form-label">NOM</label>
                     <input type="text" class="form-control" style="text-transform:uppercase; border: 1px solid silver; padding-left: 8px !important" name="name_matr" placeholder="Afficher le matricule" id="nom">
                     <div class="clearfix"></div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-row">
                     <label class="form-label">PRENOM</label>
                     <input type="text" class="form-control" style="text-transform:uppercase; border: 1px solid silver; padding-left: 8px !important" name="name_matr" placeholder="Afficher le matricule" id="postnom">
                     <div class="clearfix"></div>
                  </div>
               </div>

               <div class="col-md-3">
                  <div class="form-row">
                     <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_personnel" name="btnsave_smenu" id="btnsave_smenu">TROUVE UN PERSONNEL</button>
                  </div>
               </div>
            </div>
            </br>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-row">
                     <select class="custom-select flex-grow-1 form-control" id='name_agence' name="name_agence">
                        <option value='-1'>SELECTION AGENCE</option>
                        @foreach($result_agence as $agence)
                        <option value='{!! $agence->numagence !!}'>{!! $agence->nomagence !!}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            </br>
            </br>
            <div class="row">
               <div class="form-row">
                  <button type="button" class="btn btn-success" name="btnsave_users" id="btnsave_affectation">Enregistrer</button>
                  <button type="button" class="btn btn-danger" style="margin-left: 10px !important" id="btnreset_affectation">Annuler</button>
                  <input type="hidden" class="form-control" id="name_occupation">
               </div>
            </div>
         </form>
      </div>


   </div>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-12">
      <h6 class="card-header">liste des agent affecter</h6>
      <div class="card-body">
         <table class="table card-table" id="tab_affectation">
            <thead class="thead-light">
               <tr>
                  <th>Id</th>
                  <th>Nom Agence</th>
                  <th>Matricule</th>
                  <th>Nom</th>
                  <th>Postnom</th>
                  <th>Prenom</th>
                  <th>Date Affect.</th>
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
$('body').delegate('.afficher_matri', 'click', function () {
var ids = $(this).data('id');
$.ajax({
url: "{{route('get_affecter')}}",
type: 'POST',
async: false,
data: {
code: ids
},
success: function (data) {
$("#name_matr").val(ids);
$("#nom").val(data.nom);
$("#postnom").val(data.postnom);
$("#prenom").val(data.prenom);
}
});

});

$("#name_agence").select2();

$('#btnsave_affectation').click(function () {
if ($("#name_agence").val() != '-1' && $("#name_matr").val() != '') {
swal({
title: 'La Colombe Money',
text: " Voulez vous affecter un agent!",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Oui Affecter!',
cancelButtonText: 'No, ANNULE!',
confirmButtonClass: 'btn btn-success',
cancelButtonClass: 'btn btn-danger',
buttonsStyling: false,
allowOutsideClick: false,
showLoaderOnConfirm: true,
preConfirm: function () {
return new Promise(function (resolve, reject) {
$.ajax({
url: "{{route('create_affectation')}}",
type: 'POST',
async: false,
data: {
name_matr: $("#name_matr").val(),
name_agence: $("#name_agence").val()
},
success: function (data) {
if (data.success == '1') {
swal({title: 'La Colombe Money!',
text: 'Un agent affecter avec success!',
type: 'success'
})
affiche_affectation();
$("#name_matr").val("");
$("#name_agence").val("-1");
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
html: 'Agent not affecter '
})
});
}

});


$('body').delegate('.supprimer_aff', 'click', function () {

var ids = $(this).data('id');
swal({
title: 'La Colombe Money',
text: " Voulez vous supprimer un agent affecter!",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Oui Supprimer!',
cancelButtonText: 'No, ANNULE!',
confirmButtonClass: 'btn btn-success',
cancelButtonClass: 'btn btn-danger',
buttonsStyling: false,
allowOutsideClick: false,
showLoaderOnConfirm: true,
preConfirm: function () {
return new Promise(function (resolve, reject) {
$.ajax({
url: "{{route('destroy_affecter')}}",
type: 'POST',
async: false,
data: {
code: ids
},
success: function (data) {
if (data.success == '1') {
swal({title: 'La Colombe Money!',
text: 'Un agent supprimer avec success!',
type: 'success'
})
window.location.href = ("{{route('index_affectation')}}");
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
title: 'La Colombe Money',
html: 'Agent not supprimer '
})
});
});
@endsection