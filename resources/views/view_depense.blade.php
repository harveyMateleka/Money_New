@extends('layouts.header')
@section('content')

<style>
  .swal2-icon.swal2-warning {
    font-size: 1rem;
    margin-top: 15px;
  }

  #errSelect,
  #errDepense,
  #errDevise,
  #errMontant,
  #errAuto,
  #errMotif {
    font-size: 13px;
    margin-left: 15px
  }
</style>


<div class="container-fluid flex-grow-1 container-p-y">
  <h3 class="font-weight-bold py-3 mb-0">Ajout dépense</h3>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
  </div>
  <div class="card col-md-12">
    <h4 class="card-header">Créer Une Depense</h4>
    <div class="card-body">

      <form action="#" method="POST" id="form_depense">
        {{csrf_field()}}
        <div class="form-row">
          <div class="form-group col-md-6">

            <select class="custom-select flex-grow-1" id='numagence' name="numagence">
              <option value="-1">Choisir l'agence</option>
              @foreach($don as $ligne_agence)
              <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
              @endforeach
            </select>
            <span id="errSelect"></span>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <select class="form-control js-states" name="id_typdep" data-validation="" id="id_typdep" data-validation="required">
              <option value="-1">SELECT TYPE DEPENSE</option>
              <@foreach($typedep as $data) <option value="{!! $data->id_typdep !!}">{!! $data->type_dep !!}</option>
                @endforeach
            </select>
            <span id="errDepense"></span>
          </div>

          <div class="form-group col-md-6">
            <select class="form-control js-states" name="id_auto" data-validation="" id="id_auto" data-validation="required">
              <option value='-1'>AUTORISATION</option>
              <@foreach($auto as $data) <option value="{!! $data->id_auto !!}">{!! $data->nom_auto !!}</option>
                @endforeach
            </select>
            <span id="errAuto"></span>
          </div>

          <div class="form-group col-md-6">
            <select class="form-control js-states" name="devise" data-validation="" id="devise" data-validation="required">
              <option value="-1">SELECT DEVISE</option>
              <option value="2">CDF</option>
              <option value="1">USD</option>
            </select>
            <span id="errDevise"></span>
          </div>

          <div class="col-md-6">
            <label class="form-label">MONTANT </label>
            <div class="form-group">
              <input type="number" autocomplete="off" class="currency" name="montant" id="montant" data-validation="required"><br />
              <span id="errMontant"></span>
              <div class="clearfix"></div>
            </div>
          </div>

          <div class="form-group col-md-6">
            <label class="form-label">MOTIF DE DEPENSE</label>
            <textarea type="text" class="form-control rounded-0" id="motif" name="motif" rows="1"></textarea>
            <span id="errMotif"></span>
            <div class="clearfix"></div>
          </div>

        </div>

        <button type="button" class="btn btn-success" name="btnsave_depense" id="btnsave_depense">ENVOYER DEPENSE</button>
        <button type="reset" class="btn btn-danger">annule</button>
        <input type="hidden" class="form-control" placeholder="Saisir le nom de la personnel" id="code_id">
      </form>
    </div>
  </div>
  <hr class="border-light container-m--x my-4">
  <div class="card col-md-12">
    <h6 class="card-header">LISTE DES DEPENSES</h6>
    <div class="card-body">
      <table class="table card-table" id="tab_depense">
        <thead class="thead-light">
          <tr>
            <th>ID</th>
            <th>MOTIF</th>
            <th>DEVISE</th>
            <th>MATRICULE</th>
            <th>MONTANT</th>
            <th>ETAT</th>
            <th>AUTORISER PAR</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section ('javascript')
<script type="text/javascript">
  (function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $("#numagence").select2();

    $('#numagence').change(function() {
      if ($('#numagence').val() != '-1') {
        affiche_depense($('#numagence').val());
      } else {
        return '';
      }
    });


    $('#btnsave_depense').click(function() {
      var motif = $("#motif").val();
      var devise = $("#devise").val();
      var montant = $("#montant").val();
      var id_typdep = $("#id_typdep").val();
      var numagence = $("#numagence").val();
      var id_auto = $("#id_auto").val();

      if (numagence === '-1') {
        $('#errSelect').text('Veuillez selectionner une agence svp !!!')
        $('#errSelect').css('color', 'red')
      } else {
        $('#errSelect').text('')
      }

      if (id_typdep === '-1') {
        $('#errDepense').text('Veuillez selectionner un type de dépense svp !!!')
        $('#errDepense').css('color', 'red')
      } else {
        $('#errDepense').text('');
      }

      if (devise === '-1') {
        $('#errDevise').text('Veuillez selectionner une devise svp !!!')
        $('#errDevise').css('color', 'red')
      } else {
        $('#errDevise').text('')
      }

      if (motif === '') {
        $('#errMotif').text('Veuillez renseigner un motif svp !!!')
        $('#errMotif').css('color', 'red')
      } else {
        $('#errMotif').text('')
      }

      if (id_auto === '-1') {
        $('#errAuto').text('Veuillez selectionner une autorisation svp !!!')
        $('#errAuto').css('color', 'red')
      } else {
        $('#errAuto').text('')
      }

      if (montant === '') {
        $('#errMontant').text('Veuillez renseigner le montant svp !!!')
        $('#errMontant').css('color', 'red')
      } else {
        $('#errMontant').text('')
      }

      if (motif != '' && devise != '' && montant != '' && id_typdep != '-1' && id_auto != '-1' && numagence != '-1') {
        if ($("#code_id").val() == '') {

          Swal.fire({

            title: 'Etes-vous sûr ?',
            text: `Voulez-vous effectuer cette dépense au montant de  ${montant}  `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, je veux',

          }).then((response) => {
            $.ajax({
              url: "{{route('route_create_depense')}}",
              type: 'POST',
              async: false,
              data: {
                motif: motif,
                devise: devise,
                montant: montant,
                id_typdep: id_typdep,
                id_auto: id_auto,
                numagence: numagence,
              },
              success: function(data) {
                if (data.success == '1') {
                  Swal.fire(
                    'Succès',
                    'L\'opération a réussi.',
                    'success'
                  )
                  affiche_depense($('#numagence').val());
                  $("#motif").val("");
                  $("#devise").val('-1');
                  $("#montant").val("");
                  $("#id_typdep").val("-1");
                  $("#numagence").val("-1");
                  $("#id_auto").val('-1');
                } else {
                  Swal.fire(
                    'Echec',
                    'L\'opération n\'a pas réussi.',
                    'error'
                  )
                }
              },
              error: function(data) {
                alert(data.success);
              }
            })
          });
        } else {

          Swal.fire({

              title: 'Etes-vous sûr ?',
              text: `Acceptez vous d'apporter les modifications.`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Oui, j\'accepte',

            }).then(res => {
              $.ajax({
                url: "{{route('route_update_depense')}}",
                type: 'POST',
                async: false,
                data: {
                  motif: $("#motif").val(),
                  id_typdep: id_typdep,
                  id_auto: id_auto,
                  id_dep: $("#code_id").val(),

                },
                success: function(data) {
                  if (data.success == '1') {
                    Swal.fire(
                      'Succès',
                      'L\'opération a réussi.',
                      'success'
                    )
                    affiche_depense($('#numagence').val());
                    $("#code_id").val("")
                    $("#motif").val("");
                    $("#devise").val("-1");
                    $("#montant").val("");
                    $("#id_typdep").val("-1");
                    $("#numagence").val("-1");
                    $("#id_auto").val("-1");
                    document.getElementById('montant').readOnly = false;
                    document.getElementById('numagence').disabled = false;
                    document.getElementById('devise').disabled = false;
                  } else {
                    Swal.fire(
                      'Echec',
                      'L\'opération n\'a pas réussi.',
                      'success'
                    )
                  }
                }
              });
            })

            .then(function() {
              swal({
                type: 'info',
                title: 'la Colombe Money',
                html: 'les information de depense ne sont pas mofifier'
              })
            });
        }
      }

    });

    $('body').delegate('.modifier_depense', 'click', function() {
      var ids = $(this).data('id');
      $.ajax({
        url: "{{route('get_depense1')}}",
        type: 'POST',
        async: false,
        data: {
          code: ids
        },
        success: function(data) {
          $("#motif").val(data.motif);
          $("#numagence").val(data.numagence);
          $("#devise").val(data.devise);
          $("#montant").val(data.montant);
          $("#id_typdep").val(data.id_typdep);
          $("#id_auto").val(data.id_auto);
          $("#code_id").val(data.id_dep);
          document.getElementById('montant').readOnly = true;
          document.getElementById('numagence').disabled = true;
          document.getElementById('devise').disabled = true;
          $("#id_typdep").val(data.id_typdep);
          $("#id_auto").val(data.id_auto);
          $("#code_id").val(data.id_dep);
        }
      });
    });
  })();

  function affiche_depense(cod_agence) {
    var otableau = $('#tab_depense').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'print', 'copy', 'excel', 'pdf'
      ],
      "bProcessing": true,
      "sAjaxSource": "/admin/liste_depense=" + cod_agence,
      "columns": [{
          "data": 'id_dep'
        },
        {
          "data": 'motif'
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
        },
        {
          "data": 'matricule'
        },
        {
          "data": 'montant'
        },
        {
          "data": 'etat',
          "autoWidth": true,
          "render": function(data) {
            if (data == 1) {
              return 'Approuve';
            } else {
              return 'Not Approuve';
            }
          }
        },
        {
          "data": 'id_auto',
          "autoWidth": true,
          "render": function(data) {
            if (data == 1) {
              return 'PDG';
            } else if (data == 2) {
              return 'DGA';
            } else if (data == 3) {
              return 'DG';
            } else {
              return 'ENTREPRISE'
            }

          }
        },
        {
          "data": 'id_dep',
          "autoWidth": true,
          "render": function(data) {
            return '<button data-id=' + data + ' class="btn btn-info btn-circle modifier_depense" ><i class="fa fa-check"></i></button>';
          }
        }

      ],
      "pageLength": 10,
      "bDestroy": true
    });
  }
</script>
@endsection