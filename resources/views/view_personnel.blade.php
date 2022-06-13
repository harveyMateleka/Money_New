@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
  <h3 class="font-weight-bold py-3 mb-0">Ajout Personnel</h3>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
  </div>
  <div class="card col-md-12">
    <h4 class="card-header">Mise à Jour personnel</h4>
    <div class="card-body">
      <form action="#" method="POST" id="form_personnel">
        {{csrf_field()}}
        <div class="form-row">
          <div class="form-group col-md-4">
            <label class="form-label">NOM</label>
            <input type="text" class="form-control @error('nom') is-invalid @enderror"" name=" nom" placeholder="Nom" id="nom" style="border: 1px solid silver; padding-left: 8px !important">
            <div class="clearfix"></div>
            @error('nom')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label class="form-label">POSTNOM</label>
            <input type="text" class="form-control" name="postnom" placeholder="Postnom" id="postnom" data-validation="required" style="border: 1px solid silver; padding-left: 8px !important">
            <div class="clearfix"></div>
          </div>
          <div class="form-group col-md-4">
            <label class="form-label">PRENOM</label>
            <input type="text" class="form-control" name="prenom" placeholder="Prénom" id="prenom"
             data-validation="required" style="border: 1px solid silver; padding-left: 8px !important">
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-row">
          {{csrf_field()}}
          <div class="form-group col-md-4">
            <label class="form-label">TELEPHONE</label>
            <input type="text" onKeyPress="return numbersonly(this, event)" style="border: 1px solid silver; padding-left: 8px !important" size="10" placeholder="Téléphone" maxlength="10" class="form-control" name="tel" placeholder="" id="tel" data-validation="required">
            <div class="clearfix"></div>
          </div>
          {{csrf_field()}}
          <div class="form-group col-md-4">
            <label class="form-label">MATRICULE</label>
            <input type="text" class="form-control" name="matricule" placeholder="" id="matricule" data-validation="required" value="{{$resul}}" style="border: 1px solid silver; padding-left: 8px !important">
            <div class="clearfix"></div>
          </div>
          {{csrf_field()}}
          <div class="form-group col-md-4">
            <select class="form-control" name="id_fonction" id="id_fonction" data-validation="required"
             style="border: 1px solid silver; margin-top: 20px !important">
              <option disabled selected>SELECT FONCTION</option>
              @foreach($resultat as $data)
              <option value="{{$data->id_fonction}}">{{$data->fonction}}</option>
              @endforeach
            </select>
          </div>
          {{csrf_field()}}
          <div class="form-group col-md-4">
            <label class="form-label">ADDRESS</label>
            <input type="text" class="form-control" name="adresse" placeholder="Adresse"
             id="adresse" data-validation="required" value="" style="border: 1px solid silver; padding-left: 8px !important">
            <div class="clearfix"></div>
          </div>
          <div class="form-group col-md-4">
              <label class="form-label">OCCUPATION</label>
            <select class="form-control js-states" name="occupation" data-validation="" id="occupation" data-validation="required" style="border: 1px solid silver">
              <option disabled selected>SELECT OCCUPATION</option>
              <option value="1">DIRECTION</option>
              <option value="0">AGENCE</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <div class="form-check form-check-inline">
                
              <input class="form-check-input" type="radio" name="etat" checked id="etat_actif" value="1">
              <label class="form-check-label" for="inlineRadio1" checked>Actif</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="etat" id="etat_conge" value="2">
              <label class="form-check-label" for="inlineRadio2">En conge</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="etat" id="etat_licencie" value="3">
              <label class="form-check-label" for="inlineRadio3">Licencie</label>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-success" name="btnsave_personnel" id="btnsave_personnel">Enregistre</button>
        <button type="reset" class="btn btn-danger">annule</button>
        <input type="hidden" class="form-control" placeholder="Saisir le nom de la personnel" id="code_personnel">
      </form>
    </div>
  </div>
  <hr class="border-light container-m--x ">
  <div class="card col-md-12">
    <h6 class="card-header">Liste de personnel</h6>
    <div class="card-body">
      <table class="table card-table" id="tab_personnel">
        <thead class="thead-light">
          <tr>
            <th>ID</th>
            <th>NOM</th>
            <th>PRENOM</th>
            <th>ADDRESS</th>
            <th>TELEPHONE</th>
            <th>OCCUPATION</th>
            <th>FONCTION</th>
            <th>ETAT</th>
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
@section ('script')
$('#btnsave_personnel').click(function () {
var etat_perso = [];
if (document.getElementById('etat_actif').checked) {
etat_perso = 1;
} else if (document.getElementById('etat_conge').checked) {
etat_perso = 2;
} else {
etat_perso = 3;
}
var matricule = $("#matricule").val();
var nom = $("#nom").val();
var postnom = $("#postnom").val();
var prenom = $("#prenom").val();
var adresse = $("#adresse").val();
var tel = $("#tel").val();
//var etat=$("#etat").val();
var occupation = $("#occupation").val();
var id_fonction = $("#id_fonction").val();
if (nom != '' && postnom != '' && prenom != '' && adresse != '' && tel != '' && occupation != '' && id_fonction != '') {
if ($("#code_personnel").val() == '') {
swal({
title: 'la colombe Money',
text: "voulez vous l'enregistre!",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes,AJOUTER!',
cancelButtonText: 'No, ANNULE!',
confirmButtonClass: 'btn btn-success',
cancelButtonClass: 'btn btn-danger',
buttonsStyling: false,
allowOutsideClick: false,
showLoaderOnConfirm: true,
preConfirm: function () {
return new Promise(function (resolve, reject) {

$.ajax({
url: "{{route('route_create_personnel')}}",
type: 'POST',
async: false,
data: {
matricule: matricule,
nom: nom,
postnom: postnom,
prenom: prenom,
adresse: adresse,
tel: tel,
etat: etat_perso,
occupation: occupation,
id_fonction: id_fonction
},
success: function (data) {
if (data.success == '1') {
swal({title: 'la colombe Money!',
text: 'enregistrement un nouveau agent!',
type: 'success'
})
window.location.href = ("{{route('index_personnel')}}");
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
title: 'la colombe Money',
html: 'LE PERSONNEL NE PAS AJOUTER DANS LE SYSTEM'
})
});

} else {

swal({
title: 'Voulez vous modifier LES INFORMATION DU PERSONNEL SELECTIONER?',
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
url: "{{route('route_update_personnel')}}",
type: 'POST',
async: false,
data: {
nom: $("#nom").val(),
postnom: $("#postnom").val(),
prenom: $("#prenom").val(),
adresse: $("#adresse").val(),
tel: $("#tel").val(),
occupation: $("#occupation").val(),
id_fonction: $("#id_fonction").val(),
etat: etat_perso,
matricule: $("#code_personnel").val(),
},
success: function (data) {
if (data.success == '1') {
swal({title: 'la colombe Money!',
text: 'modification un nouveau agent!',
type: 'success'
})
window.location.href = ("{{route('index_personnel')}}");
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
html: 'les information ne sont pas mofifier'
})
});
}
}
});
$('body').delegate('.modifier_personnel', 'click', function () {
var ids = $(this).data('id');
$.ajax({
url: "{{route('get_personnel')}}",
type: 'POST',
async: false,
data: {
code: ids
},
success: function (data) {
$("#nom").val(data.nom);
$("#postnom").val(data.postnom);
$("#prenom").val(data.prenom);
$("#tel").val(data.tel);
$("#adresse").val(data.adresse);
if (data.etat == 1) {
$("#etat_actif").prop('checked', true);
} else if (data.etat == 2) {
$("#etat_conge").prop('checked', true);
} else {
$("#etat_licencie").prop('checked', true);
}
$("#occupation").val(data.occupation);
$("#id_fonction").val(data.id_fonction);
$("#code_personnel").val(data.matricule);
}
});
});
$('body').delegate('.supprimer_personnel', 'click', function () {
var ids = $(this).data('id');
swal({
title: 'Voulez vous supprimer le personnel?',
text: "il ya pas moyen de le modifier!",
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
url: "{{route('delete_personnel')}}",
type: 'POST',
async: false,
data: {
code: ids
},
success: function (data) {
if (data.success == '1') {
swal({ title: 'la colombe Money!',
text: 'suppression du personnel avec success!',
type: 'success'
})
window.location.href = ("{{route('index_personnel')}}");
} else {
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
html: "les information du personelle n'est sont pas supprimer"
})
});
});
@endsection