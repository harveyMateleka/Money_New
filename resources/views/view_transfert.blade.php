@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Transfert Banque</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
    </div>
    <div class="card col-md-12">
        <h4 class="card-header">D'un compte à un compte</h4>
        <div class="card-body">
            <form action="#" method="POST" id="form_personnel">
                {{csrf_field()}}
                <div id="message" style='color:red; font-size:15px;'>
                </div>
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <select class="custom-select flex-grow-1" id='name_prov'>
                            <option value='-1'>COMPTE DE PROVENANCE</option>
                            @foreach($resultat as $ligne_banque)
                            <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">

                        <select class="custom-select flex-grow-1" id='name_desti'>
                            <option value='-1'>VERS QUEL COMPTE</option>
                            @foreach($resultat as $ligne_banque)
                            <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <select class="form-control js-states" style="border: 1px solid silver !important" name="devise" data-validation="" id="devise" data-validation="required">
                            <option value='-1'>SELECT DEVISE</option>
                            <option value="2">CDF</option>
                            <option value="1">USD</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">MONTANT </label>
                        <input type="number" class="currency" name="Montant" id="Montant" data-validation="required">
                        <div class="clearfix" id='monttrans'></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">CONFIRMER EMAIL/PHONE</label>
                        <input type="email" class="form-control" name="Montant" style="border: 1px solid silver !important ; padding-left: 8px !important" placeholder="saisir votre email" id="name_email" data-validation="required">
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">CONFIRMER MOT DE PASSE</label>
                        <input type="password" style="border: 1px solid silver !important; padding-left: 8px !important" class="form-control" name="" placeholder="Confirmation" id="pass" data-validation="required">
                        <div class="clearfix"></div>
                    </div>

                </div>

                <button type="button" class="btn btn-success" name="btnsave_banque" id="btnsave_transfert">ENREGISTRE</button>
                <button type="reset" class="btn btn-danger">annule</button>
                <input type="hidden" class="form-control" placeholder="Saisir le nom de la personnel" id="code_banque">
            </form>
        </div>
    </div>
    <hr class="border-light container-m--x my-4">

</div>
@endsection

@section ('script')
$('#name_prov').select2();
$('#name_desti').select2();

$("#Montant").on('input',function(){
if($("#Montant").val()!=''){
let formatmont=formateIndianCurrency($("#Montant").val());
let new_amount=formatmont.substring(0,formatmont.length - 1);
$("#monttrans").html(new_amount);
}
else if($("#Montant").val()==0) {
$("#monttrans").html(0);
}
else {
$("#monttrans").html("");
}

});

$('#btnsave_transfert').click(function() {
if($("#name_prov").val()!='-1' && $("#name_desti").val()!='-1' && $("#devise").val()!='' && $("#Montant").val()!='' && $("#pass").val()!='' && $("#name_email").val()!=''){
if($("#name_prov").val()== $("#name_desti").val()){
$("#message").html('vous ne devez pas transferer dans un meme compte');
}
else{
swal({
title: 'la colombe Money',
text: "voulez vous transfert vers un autre compte?",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes,transferer!',
cancelButtonText: 'No, ANNULE!',
confirmButtonClass: 'btn btn-success',
cancelButtonClass: 'btn btn-danger',
buttonsStyling: false,
allowOutsideClick: false,
showLoaderOnConfirm: true,
preConfirm: function () {
return new Promise(function (resolve, reject) {
$.ajax({
url : "{{route('transfert')}}",
type : 'POST',
async : false,
data : {prov:$("#name_prov").val(),
desti:$("#name_desti").val(),
devise:$("#devise").val(),
montant:$("#Montant").val(),
username:$("#name_email").val(),
password:$("#pass").val()
},
success:function(data)
{
if(data.success=='1'){
swal({title: 'la colombe Money!',
text: 'transfert effectuer!',
type: 'success'
});
$("#name_prov").val('-1');
$("#name_desti").val('-1');
$("#devise").val('-1');
$("#Montant").val('');
$("#name_email").val('');
$("#pass").val('');
window.location.href=("{{route('index_transfert')}}");

}
else{
swal({title: 'la colombe Money!',
text: data.success,
type: 'success'
});
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
html: 'transfert non effectuer'
})
});
}

}

});

@endsection