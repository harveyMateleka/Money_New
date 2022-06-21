@extends('layouts.header')
@section('content')


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
                     <input type="text" class="form-control" style="text-transform:uppercase;" name="name_matr" placeholder="Afficher le matricule" id="name_matr">
                     <div class="clearfix"></div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-row">
                     <label class="form-label">NOM</label>
                     <input type="text" class="form-control" style="text-transform:uppercase;" name="nom" placeholder="Afficher le matricule" id="nom">
                     <div class="clearfix"></div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-row">
                     <label class="form-label">PRENOM</label>
                     <input type="text" class="form-control" style="text-transform:uppercase;" name="postnom" placeholder="Afficher le matricule" id="postnom">
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
                     <select class="custom-select flex-grow-1" id='name_agence' name="name_agence">
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
                  <button type="button" class="btn btn-danger" id="btnreset_affectation" style='margin-left:10px'>annuler</button>
                  <input type="hidden" class="form-control" id="name_occupation">
               </div>
            </div>
         </form>
      </div>


   </div>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-12" style='overflow-x: auto;'>
      <h6 class="card-header">Liste des agents affectées</h6>
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
                  <th>Date d'affectation</th>
                  <th>Occupation0</th>
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
@section('javascript')
<script type="text/javascript">
   (function() {
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      affiche_affectation();
      $("#name_agence").select2();

      $('body').delegate('.afficher_matri', 'click', function() {
         var ids = $(this).data('id');
         $.ajax({
            url: "{{route('get_affecter')}}",
            type: 'POST',
            async: false,
            data: {
               code: ids
            },
            success: function(data) {
               $("#name_matr").val(ids);
               $("#nom").val(data.nom);
               $("#postnom").val(data.postnom);
               $("#prenom").val(data.prenom);
            }
         });

      });

      $('body').delegate('.supprimer_aff', 'click', function() {
         var ids = $(this).data('id');
         Swal.fire({
            title: 'Colombe Money',
            html: " Voulez vous supprimer cette affetation",
            width: 600,
            padding: '3em',
            showDenyButton: true,
            confirmButtonText: `Supprimer`,
            denyButtonText: `Annuler`,
         }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
                  url: "{{route('destroy_affecter')}}",
                  type: 'POST',
                  async: false,
                  data: {
                     code: ids
                  },
                  success: function(data) {
                     if (data.success == '1') {
                        affiche_affectation();
                        Swal.fire('operation effectuée', '', 'success')

                     } else {
                        Swal.fire('Suppression', '', 'error')
                     }
                  },
                  error: function(data) {

                     Swal.fire('error', '', 'error')
                  }
               });

            } else if (result.isDenied) {
               Swal.fire('Changes are not saved', '', 'info')
            }
         });

      });

      $('#btnsave_affectation').click(function() {
         if ($("#name_agence").val() != '-1' && $("#name_matr").val() != '') {
            Swal.fire({
               title: 'Colombe Money',
               html: " Voulez vous affecter un agent!",
               width: 600,
               padding: '3em',
               showDenyButton: true,
               confirmButtonText: `Affecter`,
               denyButtonText: `Annuler`,
            }).then((result) => {
               if (result.isConfirmed) {
                  $.ajax({
                     url: "{{route('create_affectation')}}",
                     type: 'POST',
                     async: false,
                     data: {
                        name_matr: $("#name_matr").val(),
                        name_agence: $("#name_agence").val()
                     },
                     success: function(data) {
                        console.log('DATA DATA DATA :::: ', data.success)
                        if (data.success === 1) {
                           affiche_affectation();
                           $("#name_matr").val("");
                           $("#name_agence").val("-1");
                           Swal.fire('operation effectuée', '', 'success')

                        } else {
                           Swal.fire('Affectation', '', 'error')
                        }
                     },
                     error: function(data) {

                        Swal.fire('error', '', 'succerroress')
                     }
                  });

               } else if (result.isDenied) {
                  Swal.fire('Changes are not saved', '', 'info')
               }
            });
         }

      });
   })();

   function affiche_affectation() {
      var otableau = $('#tab_affectation').DataTable({
         dom: 'Bfrtip',
         buttons: [
            'print', 'copy', 'excel', 'pdf'
         ],
         "bProcessing": true,
         "sAjaxSource": "{{route('get_afectation')}}",
         "columns": [{
               "data": 'id'
            },
            {
               "data": 'nomagence'
            },
            {
               "data": 'matricule'
            },
            {
               "data": 'nom'
            },
            {
               "data": 'postnom'
            },
            {
               "data": 'prenom'
            },
            {
               "data": 'created_at'
            },
            {
               "data": 'occupation',
               "autoWidth": true,
               "render": function(data) {
                  if (data == '1') {
                     return 'Agence';
                  } else {
                     return 'Direction';
                  }
               }
            },
            {
               "data": 'id',
               "autoWidth": true,
               "render": function(data) {
                  return '<button data-id=' + data + ' class="btn btn-warning btn-circle supprimer_aff" ><i class="fa fa-times"></i></button>';
               }
            }
         ],
         "pageLength": 5,
         "bDestroy": true
      });


      $('body').delegate('.afficher_matr', 'click', function() {
         var ids = $(this).data('id');
         let nom = $(this).data('nom');
         let postnom = $(this).data('postnom');
         let prenom = $(this).data('prenom');

         $("#name_matr").val(ids);
         $("#matr_users").val(ids);

         console.log("#DATA   ::: ", ids, nom, postnom, prenom)
      });

   }
</script>
@endsection