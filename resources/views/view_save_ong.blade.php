@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0">TRANFERT ONG </h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">   
   </div>
   <div class="card col-md-8">
      <div class="card -header">    
      </div>
      <div class="card-body">
         <form action="#" method="POST" id="form_affectation">
            {{csrf_field()}}
            <div id="message" style='color:red; font-size:15px;'>
            </div>
            <div class="form-row">
               <div class="form-group col-md-6">
                  <label class="form-label"></label> 
                  <select style="border: 1px solid silver !important; padding-left: 8px !important" class="custom-select flex-grow-1" id='name_ong' name="name_ong">
                     <option value='-1'>SELECTIONER ONG</option>
                     @foreach($ong as $ligne_ong)
                     <option value='{!! $ligne_ong->id !!}'>{!! $ligne_ong->name_ong !!}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group col-md-6">
                  <label class="form-label"></label>         
                     <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control"  name="name_transact"  style="text-transform:uppercase;" placeholder="EXPEDITEUR" id="name_exp" value="" >
                     <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-12">
                  <div class="form-check form-check-inline">
                     <input  style="border: 1px solid silver !important; padding-left: 8px !important" class="form-check-input" type="radio" name="etat" id="etat_ag" value="1">
                     <label class="form-check-label"  for="inlineRadio1">Agence</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input  style="border: 1px solid silver !important; padding-left: 8px !important" class="form-check-input" checked type="radio" name="etat" id="etat_bank" value="2">
                     <label class="form-check-label" for="inlineRadio2">Banque</label>
                  </div>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-6" id='prov_bank'>
                  <select style="border: 1px solid silver !important; padding-left: 8px !important" class="custom-select flex-grow-1" id='name_bank'>
                     <option value='-1'>Selectionnez Bank</option>
                     @foreach($tbl_banque as $ligne_banque)
                     <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group col-md-6" id='prov_ag'>
                  <select  style="border: 1px solid silver !important; padding-left: 8px !important" class="custom-select flex-grow-1" id='name_prov'>
                     <option value='-1'>Agence de Provenance</option>
                     @foreach($tbl_agence as $ligne_agence)
                     <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-6">
                  <select  style="border: 1px solid silver !important; padding-left: 8px !important" class="form-control js-states" name="devise" data-validation="" id="devise" data-validation="required">
                     <option value='-1'>Selectionnez la devise</option>
                     <option value="2">CDF</option>
                     <option value="1">USD</option>
                  </select>
               </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label class="form-label">MONTANT </label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="Montant" placeholder="" id="Montant" data-validation="required">
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-6">
                  <label class="form-label">Taux </label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="Montant" placeholder="" id="taux" value="3">
                  <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label class="form-label">Montant Pourc. </label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="Montant" placeholder="" id="montant_pourc" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-6">
                  <label class="form-label">Frais Deplacement.</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important"  type="text" class="form-control" id='frais' name="frais" placeholder="" id="mont_dep">
                  <div class="clearfix"></div>
               </div>
            </div>
            <hr class="border-light container-m--x my-4">
            <button type="button" class="btn btn-success" name="btnsave_users" id="btnsave_ong">Save</button>
            <button type="reset" class="btn btn-danger" id="btnreset_affectation">annule</button>
            <input type="hidden" class="form-control"  id="name_id" value=''>
         </form>
      </div>
   </div>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-12">
      <h6 class="card-header">Liste de transfert des ong</h6>
      <div class="card-body">
         <table class="table card-table" id="tab_save_ong">
            <thead class="thead-light">
               <tr>
                  <th>Id</th>
                  <th>Date</th>
                  <th>Nom ong</th>
                  <th>Devise</th>
                  <th>Montant Trans</th>
                  <th>Taux</th>
                  <th>Pourc.</th>
                  <th>Frais Dep.</th>
                  <th>Montant Payé</th>
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
document.getElementById("name_prov").style.display = "none";
$('#etat_bank').change(function () {
    if (document.getElementById("etat_bank").checked) {
        document.getElementById("name_prov").style.display = "none";
        document.getElementById("name_bank").style.display = "block";
    }
});
$('#etat_ag').change(function () {
    if (document.getElementById("etat_ag").checked) {
        document.getElementById("name_prov").style.display = "block";
        document.getElementById("name_bank").style.display = "none";
    }
});
$('#Montant').on('input', function () {
    if (!isNaN($('#Montant').val())) {
        $('#montant_pourc').val(calcul_com());
    } else {
        $('#Montant').val('');
    }
});
$('#Montpaye').on('input', function () {
    if (!isNaN($('#Montpaye').val())) {} else {
        $('#Montpaye').val('');
    }
});
$('#taux').on('input', function () {
    if (!isNaN($('#taux').val())) {
        $('#montant_pourc').val(calcul_com());
    } else {
        $('#taux').val(3);
    }
});
$('#frais').on('input', function () {
    if (!isNaN($('#frais').val())) {} else {
        $('#frais').val('');
    }
});

$('#Montpaye').on('input', function () {
  if (!isNaN($('#Montpaye').val())) {
    if (parseFloat($('#Montpaye').val()) > parseFloat($('#Montant').val())) {
      $('#Montpaye').val('');
    }
  } else {
    $('#Montpaye').val('');
  }
});

function calcul_com() {
    if ($('#Montant').val() != '' && $('#taux').val() != '') {
        var mont = $('#Montant').val();
        var taux = $('#taux').val();
        var montant = mont * taux / 100;
        var montantt = parseFloat(montant).toFixed(2);
        return montantt;
    } else {
        return '';
    }
}

$('#btnsave_ong').click(function () {
    var provenance = 0;
    var indice = 0;
    if ($('#devise').val() != '-1' && $('#Montant').val() != '' && $('#name_ong').val() != '-1' && $('#name_exp').val() != '' && $('#taux').val() != '' && $('#montant_pourc').val() != '' && $('#frais').val() != '') {
        if (document.getElementById("etat_ag").checked) {
            if ($('#name_prov').val() != '-1') {
                provenance = $('#name_prov').val();
                indice = 1;
            } else {
                $('#message').html('selectionnez agence');
            }
        } else {
            if ($('#name_bank').val() != '-1') {
                provenance = $('#name_bank').val();
                indice = 2;
            } else {
                $('#message').html('Veuillez selectionner une banque');
            }
        }

        
            if (provenance != 0 && indice != 0) {
                $.ajax({
                    url: "{{route('save_ong')}}",
                    type: 'POST',
                    async: false,
                    data: {
                        code: $('#name_id').val(),
                        montant: parseFloat($('#Montant').val()),
                        expedi: $('#name_exp').val(),
                        etat: indice,
                        devise: $('#devise').val(),
                        frais: $('#frais').val(),
                        ong: $('#name_ong').val(),
                        taux: $('#taux').val(),
                        pour: $('#montant_pourc').val(),
                        prov: provenance
                    },
                    success: function (data) {
                        if (data.success == '1') {
                            affiche_ong();
                            $('#Montant').val("");
                            $('#name_exp').val("");
                            $('#devise').val("-1");
                            $('#frais').val("");
                            $('#name_ong').val("");
                            $('#taux').val(3);
                            $('#montant_pourc').val("");
                        } else {
                            $('#message').html('Veuillez bien verifiez le montant que vous voulez affecté dans le numero banque si elle est de la meme devise');
                        }
                    },
                    error: function (data) {
                        alert(data.success);
                    }
                });
            }
       
    } else {
        $('#message').html('Veuillez bien verifiez les zones de saisie');
    }
});
@endsection