@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-8">
                            <h4 class="card-header">Creer une depense</h4>
                            <div class="card-body">
                            
                                <form action="#" method="POST" id="form_depense">
                                {{csrf_field()}}
                                <div class="form-row">
                                <div class="form-group col-md-6">
                                        
                                       <select  style="border: 1px solid silver !important; padding-left: 8px !important" style="text-transform:uppercase;"class="custom-select flex-grow-1" id='numagence' name="numagence">
                                       <option value="-1">Choisir une agence</option>
                                                @foreach($don as $ligne_agence)
                                                <option style="border: 1px solid silver !important; padding-left: 8px !important" style="text-transform:uppercase;" value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                                                @endforeach
                                            </select>
                                     </div>
                                </div>
                                    <div class="form-row">
                                       <div class="form-group col-md-6">
                                        <select  style="border: 1px solid silver !important; padding-left: 8px !important" style="text-transform:uppercase;" class="form-control js-states" name="id_typdep" data-validation="" id="id_typdep" data-validation="required">
                                        <option value="-1">SELECT TYPE DEPENSE</option>
                                        <@foreach($typedep as $data)
                                        <option value="{!! $data->id_typdep !!}">{!! $data->type_dep !!}</option>
                                        @endforeach
                                        </select>
                                        </div>

                                      <div class="form-group col-md-6">
                                        <select style="border: 1px solid silver !important; padding-left: 8px !important" style="text-transform:uppercase;"  class="form-control js-states" name="id_auto" data-validation="" id="id_auto" data-validation="required">
                                        <option value='-1'>AUTORISATION</option>
                                        <@foreach($auto as $data)
                                        <option value="{!! $data->id_auto !!}">{!! $data->nom_auto !!}</option>
                                        @endforeach
                                        </select>
                                        </div>
                                        
                                      <div class="form-group col-md-6">
                                        <select  style="border: 1px solid silver !important; padding-left: 8px !important" style="text-transform:uppercase;" class="form-control js-states" name="devise" data-validation="" id="devise" data-validation="required">
                                        <option value="-1">SELECT DEVISE</option>
                                        <option value="2">CDF</option>
                                        <option value="1">USD</option>
                                        </select>
                                        </div>

                                         <div class="form-group col-md-6">
                                            <input  style="border: 1px solid silver !important; padding-left: 8px !important" style="text-transform:uppercase;" type="number" class="form-control" name="montant" placeholder="ENTREE MONTANT" id="montant" data-validation="required">
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="form-label">MOTIF DE DEPENSE</label>
                                              <textarea  style="border: 1px solid silver !important; padding-left: 8px !important" style="text-transform:uppercase;" type="text" class="form-control rounded-0" id="motif" name="motif" rows="1"></textarea>
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
                                <div style="overflow-x:auto;">
                            <table class="table card-table" id="tab_depense">
                                <thead class="thead-dark">
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
                    </div>        
@endsection

@section ('script')
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

  if (motif != '' && devise != '' && montant != '' && id_typdep != '-1' && id_auto != '-1' && numagence != '-1') {
    if ($("#code_id").val() == '') {
      swal({
        title: 'la Colombe Money',
        text: "voulez vous effectuer cette depense au montant de "+ montant + " ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok,DEPENSER!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function() {
          return new Promise(function(resolve, reject) {
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
                if (data.success== '1') {
                  swal({
                    title: 'Colombe Money!',
                    text: 'depense effectuée et sera reduite dans votre especes!',
                    type: 'success'
                  });
                  affiche_depense($('#numagence').val());
                  $("#motif").val("");
                  $("#devise").val('-1');
                  $("#montant").val("");
                  $("#id_typdep").val("-1");
                  $("#numagence").val("-1");
                  $("#id_auto").val('-1');
                } else {
                  swal({
                    title: 'Colombe Money!',
                    text: data.success,
                    type: 'success'
                  });
                }
              },
              error: function(data) {
                alert(data.success);
              }
            });
          })
        }

      }).then(function() {
        swal({
          type: 'info',
          title: 'La Colombe Money',
          html: 'La depense a été annullée'
        })
      });
    } else {
      swal({
        title: 'Colombe Money',
        text: "Acceptez vous d'apporter les modifications",
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
        preConfirm: function() {
          return new Promise(function(resolve, reject) {
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
                  swal({
                    title: 'la Colombe Money',
                    text: 'modification effectuée',
                    type: 'success'
                  })
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
                  swal({
                    title: 'Colombe Money',
                    text: 'erreur de transaction',
                    type: 'success'
                  })
                }
              }
            });
          })

        }
      }).then(function() {
        swal({
          type: 'info',
          title: 'la Colombe Money',
          html: 'les information de depense ne sont pas mofifiées'
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
@endsection

