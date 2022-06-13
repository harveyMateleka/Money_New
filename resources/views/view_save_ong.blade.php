@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
<<<<<<< HEAD
   <h3 class="font-weight-bold py-3 mb-0">DEPOT ONG </h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">   
   </div>
   <div class="row">
   <div class="card col-md-8">
      <div class="card -header">    
      </div>
      <div class="card-body">
         <form action="#" method="POST" id="form_affectation">
            {{csrf_field()}}
            <div id="message" style='color:red; font-size:15px;'>
            </div>
            <div class="form-row">
            <div class="col-md-6">
              <label class="form-label"> ONG</label> 
              <div class="form-group">
                  <select class="custom-select flex-grow-1" id='name_ong' name="name_ong">
                     <option value='-1'>Choisir l'ong</option>
                     @foreach($ong as $ligne_ong)
                     <option value='{!! $ligne_ong->id !!}'>{!! $ligne_ong->name_ong !!}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-md-6" >
            <label class="form-label">EXPEDITEUR</label> 
               <div class="form-group ">     
                     <input type="text" width="100%" class="form-control"  name="name_transact"  style="text-transform:uppercase;" placeholder="EXPEDITEUR" id="name_exp" value="" >
                     <div class="clearfix"></div>
               </div>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-12">
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" checked type="radio" name="etat" id="etat_ag" value="1">
                     <label class="form-check-label"  for="inlineRadio1">Agence</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input"  type="radio" name="etat" id="etat_bank" value="2">
                     <label class="form-check-label" for="inlineRadio2">Banque</label>
                  </div>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-12" id='prov_bank'>
                  <select class="custom-select flex-grow-1" id='name_bank'>
                     <option value='-1'>Selectionnez Bank</option>
                     @foreach($tbl_banque as $ligne_banque)
                     <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group col-md-12" id='prov_ag'>
                  <select class="custom-select flex-grow-1" id='name_prov'>
                     <option value='-1'>Agence de Provenance</option>
                     @foreach($tbl_agence as $ligne_agence)
                     <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="form-row">
                        <div class="col-md-6" >
                        <label class="form-label">Devise</label>
                                <div class="form-group">
                                    <select class="form-control js-states" name="devise" data-validation="" id="devise" data-validation="required">
                                        <option value='-1'>Selectionnez la devise</option>
                                        <option value="2">CDF</option>
                                        <option value="1">USD</option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-6" >
                        <label class="form-label">Taux de Pourcentage</label>
                        <div class="form-group col-md-6">
                            <input type="text" class="currency" name="Montant" placeholder="" id="taux" value="3">
                            <div class="clearfix"></div>
                        </div>
                        </div>
            </div>
            <div class="form-row">
               <div class="col-md-4" >
                  <label class="form-label">MONTANT </label>
                        <div class="form-group">
                        <input type="text" class="currency" name="Montant" placeholder="" id="Montant" data-validation="required">
                        <div class="clearfix"></div>
                    </div>
               </div>
               <div class="col-md-4" >
                      <label class="form-label">COMMISSION</label>
                        <div class="form-group">
                            <input type="text" class="currency" name="Montant" placeholder="" id="montant_pourc" readonly>
                            <div class="clearfix"></div>
                        </div>
               </div>
               <div class="col-md-4" >
                      <label class="form-label">Frais DEPLACEMENT</label>
                        <div class="form-group">
                  <input type="text" class="currency" id='frais' name="frais" placeholder="" id="mont_dep">
                  <div class="clearfix"></div>
                        </div>
               </div>
              
            </div>
            
            <hr class="border-light container-m--x my-4">
            <button type="button" class="btn btn-success" name="btnsave_users" id="btnsave_ong">Save</button>
            <button type="reset" class="btn btn-danger" id="btnreset_affectation">annule</button>
            <input type="hidden" class="form-control"  id="name_id" value=''>
         </form>
      </div>
   </div>&nbsp;&nbsp;
   <div class="card col-md-3">
      <div class="card -header">    
      </div>
      <div class="card-body">
         <div class="row">
             <div class="col-md-12">
             <label class="form-label">TOTAL ENTREE EN USD PAR AGENCE</label>
             <label id='mont_usd_ag' class="form-label" style="text-align:center;color:red;font-size:20px">{!! $resultat["montantusd_ag"] !!}</label>  
             </div>
           
         </div>
         <hr class="border-light container-m--x my-4">
         <div class="row">
             <div class="col-md-12">
             <label class="form-label">TOTAL ENTREE EN CDF PAR AGENCE</label>
             <label id='mont_cdf_ag' class="form-label" style="text-align:center;color:red;font-size:20px">{!! $resultat["montantcdf_ag"] !!}</label>  
             </div>
           
         </div>
         <hr class="border-light container-m--x my-4">
         <div class="row">
             <div class="col-md-12">
             <label class="form-label">TOTAL ENTREE EN USD PAR BANQUE</label>
             <label id='mont_usd_bq' class="form-label" style="text-align:center;color:red;font-size:20px">{!!$resultat["montantusd_bq"] !!}</label>  
             </div>
           
         </div>
         <hr class="border-light container-m--x my-4">
         <div class="row">
             <div class="col-md-12">
             <label class="form-label">TOTAL ENTREE EN CDF PAR BANQUE</label>
             <label id='mont_cdf_bq' class="form-label" style="text-align:center;color:red;font-size:20px">{!!$resultat["montantcdf_bq"] !!}</label>  
             </div>
           
         </div>
      </div>
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
=======
    <h3 class="font-weight-bold py-3 mb-0">TRANFERT ONG </h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
    </div>
    <div class="card col-md-12">
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
                        <select class="custom-select flex-grow-1" id='name_ong' name="name_ong">
                            <option value='-1'>SELECTIONER ONG</option>
                            @foreach($ong as $ligne_ong)
                            <option value='{!! $ligne_ong->id !!}'>{!! $ligne_ong->name_ong !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label"></label>
                        <input type="text" class="form-control" name="name_transact" style="text-transform:uppercase;" placeholder="EXPEDITEUR" id="name_exp" value="">
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="etat" id="etat_ag" value="1">
                            <label class="form-check-label" for="inlineRadio1">Agence</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="etat" id="etat_bank" value="2">
                            <label class="form-check-label" for="inlineRadio2">Banque</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6" id='prov_bank'>
                        <select class="custom-select flex-grow-1" id='name_bank'>
                            <option value='-1'>Selectionnez Bank</option>
                            @foreach($tbl_banque as $ligne_banque)
                            <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6" id='prov_ag'>
                        <select class="custom-select flex-grow-1" id='name_prov'>
                            <option value='-1'>Agence de Provenance</option>
                            @foreach($tbl_agence as $ligne_agence)
                            <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <select class="form-control js-states" name="devise" data-validation="" id="devise" data-validation="required">
                            <option value='-1'>Selectionnez la devise</option>
                            <option value="2">CDF</option>
                            <option value="1">USD</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">MONTANT </label>
                        <input type="text" class="form-control" name="Montant" placeholder="" id="Montant" data-validation="required">
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Taux </label>
                        <input type="text" class="form-control" name="Montant" placeholder="" id="taux" value="3">
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Montant Pourc. </label>
                        <input type="text" class="form-control" name="Montant" placeholder="" id="montant_pourc" readonly>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Frais Deplacement.</label>
                        <input type="text" class="form-control" id='frais' name="frais" placeholder="" id="mont_dep">
                        <div class="clearfix"></div>
                    </div>
                </div>
                <hr class="border-light container-m--x my-4">

                <hr class="border-light container-m--x my-4">
                <button type="button" class="btn btn-success" name="btnsave_users" id="btnsave_ong">Save</button>
                <button type="reset" class="btn btn-danger" id="btnreset_affectation">annule</button>
                <input type="hidden" class="form-control" id="name_id" value=''>
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
>>>>>>> stephBranch
</div>
@endsection


@section ('javascript')
<script type="text/javascript">
<<<<<<< HEAD
$(document).ready(function() {
    affiche_ong();
    $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
            $("#name_bank,#name_prov,#name_ong,#devise").select2();
    document.getElementById("prov_bank").style.display = "none";
$('#etat_bank').change(function () {
    if (document.getElementById("etat_bank").checked) {
        document.getElementById("prov_ag").style.display = "none";
        document.getElementById("prov_bank").style.display = "block";
    }
});
$('#etat_ag').change(function () {
    if (document.getElementById("etat_ag").checked) {
        document.getElementById("prov_ag").style.display = "block";
        document.getElementById("prov_bank").style.display = "none";
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
=======
    $(document).ready(function() {
        affiche_ong();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
>>>>>>> stephBranch
            }
        });
        document.getElementById("name_prov").style.display = "none";
        $('#etat_bank').change(function() {
            if (document.getElementById("etat_bank").checked) {
                document.getElementById("name_prov").style.display = "none";
                document.getElementById("name_bank").style.display = "block";
            }
        });
        $('#etat_ag').change(function() {
            if (document.getElementById("etat_ag").checked) {
                document.getElementById("name_prov").style.display = "block";
                document.getElementById("name_bank").style.display = "none";
            }
        });
        $('#Montant').on('input', function() {
            if (!isNaN($('#Montant').val())) {
                $('#montant_pourc').val(calcul_com());
            } else {
                $('#Montant').val('');
            }
        });
        $('#Montpaye').on('input', function() {
            if (!isNaN($('#Montpaye').val())) {} else {
                $('#Montpaye').val('');
            }
        });
        $('#taux').on('input', function() {
            if (!isNaN($('#taux').val())) {
                $('#montant_pourc').val(calcul_com());
            } else {
                $('#taux').val(3);
            }
        });
        $('#frais').on('input', function() {
            if (!isNaN($('#frais').val())) {} else {
                $('#frais').val('');
            }
        });

        $('#Montpaye').on('input', function() {
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

<<<<<<< HEAD
        
            if (provenance != 0 && indice != 0) {
                swal.fire({
                  title: 'Colombe Money',
                  html: "Voulez vous enregistrer cette transaction",
                  width: 600,
                  padding: '3em',
                  showDenyButton: true,
                  confirmButtonText: `Enregistrer`,
                  denyButtonText: `Annuler`,
                }).then((result) => {
                    if (result.isConfirmed) {
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
                            $('#name_ong').val("-1");
                            $('#taux').val(3);
                            $('#montant_pourc').val("");
                            Swal.fire('operation reussie', '', 'success')
                            $('#mont_usd_ag').html(data.resultat.montantusd_ag);
                            $('#mont_cdf_ag').html(data.resultat.montantcdf_ag);
                            $('#mont_usd_bq').html(data.resultat.montantusd_bq);
                            $('#mont_cdf_bq').html(data.resultat.montantcdf_bq);
                        } else {
                            Swal.fire(data.success, '', 'info')    }
                    },
                    error: function (data) {
                        alert(data.success);
                    }
                });
                    }
                    else if (result.isDenied) {
                     Swal.fire('Changes are not saved', '', 'info')
                  }
                });
               
=======
        $('#btnsave_ong').click(function() {
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
                        $('#message').html('selectionnez la banque');
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
                        success: function(data) {
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
                                $('#message').html('verifiez bien le montant que vous voulez affecté dans le numero banque si elle est de la meme devise');
                            }
                        },
                        error: function(data) {
                            alert(data.success);
                        }
                    });
                }

            } else {
                $('#message').html('verifiez bien les zones de saisie');
>>>>>>> stephBranch
            }
        });


    });

    function affiche_ong() {
        var otableau = $('#tab_save_ong').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print', 'copy', 'excel', 'pdf'
            ],
            "bProcessing": true,
            "sAjaxSource": "{{route('charger_ong')}}",
            "columns": [{
                    "data": 'id'
                },
                {
                    "data": 'created_at'
                },
                {
                    "data": 'name_ong'
                },
                {
                    "data": 'devise',
                    "autoWidth": true,
                    "render": function(data) {
                        if (data == 2) {
                            return 'CDF';
                        } else {
                            return 'USD';
                        }
                    }
<<<<<<< HEAD
                      }},
            {"data":'mont_trans',"autoWidth":true,"render":function (data){
                let values = formateIndianCurrency(data);
                return values.substring(0,values.length - 1);
            }},
            {"data":'taux'},
            {"data":'mont_com',"autoWidth":true,"render":function (data){
                let values = formateIndianCurrency(data);
                return values.substring(0,values.length - 1);
            }},
            {"data":'mont_dep'},
            
                {"data":'montpayé',"autoWidth":true,"render":function (data){
                   if (data==null) {
                        return 0;
                    }else{
                        let values = formateIndianCurrency(data);
                        return values.substring(0,values.length - 1);
                    }
                      }},
              
            {"data":'id',"autoWidth":true,"render":function (data) {
                return '<button data-id='+data+' class="btn btn-info btn-circle modifier_desa" ><i class="fa fa-check"></i></button>';
                }}
        ],
        order:[[0,"DESC"]],
        "bDestroy":true
    }); 
=======
                },
                {
                    "data": 'mont_trans'
                },
                {
                    "data": 'taux'
                },
                {
                    "data": 'mont_com'
                },
                {
                    "data": 'mont_dep'
                },

                {
                    "data": 'montpayé',
                    "autoWidth": true,
                    "render": function(data) {
                        if (data == null) {
                            return 0;
                        } else {
                            return data;
                        }
                    }
                },
                // {"data":'type',"autoWidth":true,"render":function (data){
                //   if (data==1) {
                //        return 'Agence';
                //    }else{
                //        return 'Banque';
                //    }
                //      }},
                {
                    "data": 'id',
                    "autoWidth": true,
                    "render": function(data) {
                        return '<button data-id=' + data + ' class="btn btn-info btn-circle modifier_desa" ><i class="fa fa-check"></i></button>';
                    }
                }
            ],
            "bDestroy": true
        });
>>>>>>> stephBranch
    }
</script>
@endsection