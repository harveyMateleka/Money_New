@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0"></h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
   </div>
   <div class="card col-md-8">
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
               <div class="form-group col-md-5">
                  <select class="form-control "  name="ville" data-validation="required" id="ville">
                     <option value='-1'>SELECTION VILLE</option>
                     @foreach($resultat as $data)
                     <option value="{{$data->id_ville}}" style="text-transform:uppercase;">{{$data->ville}}</option>
                     @endforeach
                  </select>
               </div>
                <div class="form-group col-md-5">
                  <select class="form-control "  name="indiceag" data-validation="required" id="indiceag">
                     <option value='-1'>INDICE AGENCE</option>
                     <option value='0'>AGENCE</option>
                     <option value='1'>COFFRE</option>
                     <option value='2'>COFFRE DE CREANCE</option>
                     <option value='3'>COFFRE ONG</option>
                     <option value='4'>COFFRE DE DEPENSE</option>
                     <option value='5'>Creance ONG</option>
                    
                  </select>
               </div>
               <div class="form-group col-md-4">
                  <label class="form-label">INITIAL</label>
                  <input type="text" style="text-transform:uppercase;" class="form-control" required="" name="initial" placeholder="" id="initial">
                  <div id="ms" style="color : red"></div>
               </div>
            </div>
            <button type="button" class="btn btn-success" name="btnsave_agence" id="btnsave_agence">Enregistre</button>
            <button type="reset" class="btn btn-danger">annule</button>
            <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="code_agence">
         </form>
      </div>
   </div>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-10">
      <h6 class="card-header">Liste des agences</h6>
      <div class="card-body">
      <div style="overflow-x:auto;">
      <table class="table card-table" id="tab_agence">
            <thead class="thead-dark">
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
</div>
<script type="text/javascript">
   $(document).ready(function() {
    $('#tab_agence').DataTable({
    "lengthMenu": [[10, 25, 50, -1], [5, 25, 50, "All"]],
    "pageLength": 10, 
    "bDestroy":true,
    responsive:true,
     
      dom: 'Bfrtip',
        buttons: [
            'print', 'copy', 'excel', 'pdf'
            
        ]
  });
} );

</script>


@endsection
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
   var nomagence = $("#nomagence").val();
   var adresse = $("#adresse").val();
   var telservice = $("#telservice").val();
   var id_ville = $("#ville").val();
   var indiceag = $("#indiceag").val();
   var initial = $("#initial").val();
   if ($("#nomagence").val() != '' && $("#adresse").val() != '' && $("#ville").val() != '-1' && $("#telservice").val() != '' && $("#indiceag").val() != '' && $("#initial").val() != '') {
      if ($("#code_agence").val() == '') {

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
      }
   }else{
      $("#ms").html("Vveuillez remplire tout les champs !");
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
         $("#ville").val(data.id_ville);
         $("#ville").change();
         $("#indiceag").val(data.indiceag);
         $("#indiceag").change();
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
affiche_agence();
   })();

   function affiche_agence()
         {
         var otableau=$('#tab_agence').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"{{route('get_list_agence')}}",
             "columns":[
                 {"data":'numagence'},
                 {"data":'nomagence'},
                 {"data":'adresse'},
                 {"data":'telservice'},
                 {"data":'indiceag'},
                 {"data":'initial'},
                 {"data":'numagence',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_agence" ><i class="fa fa-times"></i></button>'+ ' ' +
                             '<button data-id='+data+' class="btn btn-info btn-circle modifier_agence" ><i class="fa fa-check"></i></button>';
                     }}
             ],
             "pageLength": 10,
             "bDestroy":true
         });
         
         }
</script>
@endsection