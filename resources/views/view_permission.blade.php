@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0">Page de Permission</h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
   </div>
   <div class="card col-md-8">
      <h4 class="card-header">Droit d'access</h4>
      <div class="card-body">
         <form action="#" method="POST" id="form_sous">
            {{csrf_field()}}
            <div class="form-row">
               <div class="input-group col-md-6">
                  <select class="custom-select flex-grow-1" id='name_fonction'>
                     <option value='-1'>Selectionnez la fonction</option>
                     @foreach($resultat as $ligne_fonction)
                     <option value='{!! $ligne_fonction->id_fonction !!}'>{!! $ligne_fonction->fonction !!}</option>
                     @endforeach
                  </select>
               </div>
            </div>
         </form>
      </div>
      <hr class="border-light container-m--x my-4">
      <table class="table card-table" id="tab_permi">
         <thead class="thead-light">
            <tr>
               <th>Id</th>
               <th>Nom de l'option</th>
               <th>Donnez Droit</th>
            </tr>
         </thead>
         <tbody>
            @foreach($resul_smenu as $ligne_menu)
            <tr>
               <td>
                  {!! $ligne_menu->id_sous !!}
               </td>
               <td>
                  {!! $ligne_menu->item_sous !!}
               </td>
               <td>

                  <input type="checkbox" data-id='{{ $ligne_menu->id_sous }}'  class=" checking"/><br>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
      </br>
      <div class="form-row">
        <ddiv class="form-group col-md-8" style="padding-left: 30%">
      <button type="submit" class="btn btn-success" id="btnactualise" >SAUVERGARDE LE SOUS MENU</button>
      </div> 
      </div>         
   
    </br>  </br>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-8">
      <h6 class="card-header">Tableau du droit d'access</h6>
      <div class="card-body">
         <table class="table card-table" id="tab_droit">
            <thead class="thead-light">
               <tr>
                  <th>Id</th>
                  <th>Fonction</th>
                  <th>Option de Menu</th>
                  <th>Retirer</th>
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
$('#tab_permi').DataTable({
  "lengthMenu": [
    [10, 25, 50, -1],
    [5, 25, 50, "All"]
  ],
  "pageLength": 7,
  "bDestroy": true
});
$('body').delegate('.checking', 'click', function () {
  var ids = $(this).data('id');
  var name_fonction = $("#name_fonction").val()
  if (name_fonction != '-1') {
    $.ajax({
      url: "{{route('create_droit')}}",
      type: 'POST',
      async: false,
      data: {
        name_fonction: name_fonction,
        name_smenu: ids
      },
      success: function (data) {
        if (data.success == '1') {
          affiche_droit();
        }
      },
      error: function (data) {
        alert(data.success);
      }
    });
  } else {
    $('#affichage_message').html('Veuillez selectionner la fonction');
    $('#modal_message').modal('show');
    $(".checking").prop('checked', false);
  }
});
$('body').delegate('.supprimer_droit', 'click', function (e) {
  var idss = $(e.target).attr("data-id");
  //alert(idss);
  $.ajax({
    url: "{{route('delete_droit')}}",
    type: 'POST',
    async: false,
    data: {
      code: idss
    },
    success: function (data) {
      if (data.success == '1') {
        affiche_droit();
      }
    },
    error: function (data) {
      alert(data.success);
    }
  });
});
$('#btnactualise').click(function () {
  window.location.href = ("{{route('index_droit_access')}}");
});
@endsection