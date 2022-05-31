@extends('layouts.header')
@section('content')
<div class="modal fade" style="width:90%;" id="modal_sortie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="example_ModalLabel">Servir le Client Ici</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div id="message" style='color:red; font-size:15px;'>
            </div>
            <form action="#" method="POST" id="form_sortie">
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btn_servir">Servir</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0">Page de Sortie Ong</h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">   
   </div>
   <div class="card col-md-8">
      <div class="card -header">    
      </div>
      <div class="card-body">
         <form action="#" method="POST">
            {{csrf_field()}}
            <div id="message" style='color:red; font-size:15px;'>
            </div>
            <div class="form-row">
        
                    <div class="form-group col-md-6">         
                          <select class="custom-select flex-grow-1" id="agence" name="agence">
                          <option value='-1'>Sectionnez l'agence</option>
                          @foreach($agence as $ligne_agence)
                          <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                          @endforeach
                        </select>
                    </div>
                  </div>
            <div class="form-row">
               <div class="form-group col-md-8">
                  <label class="form-label">Code des ong </label>          
                  <div class="input-group col-md-6">
                     <input type="text" class="form-control"  name="name_transact" placeholder="Saisir le code ici" id="name_transact" value="">
                     <div class="clearfix"></div>
                  </div>
               </div>
               <div class="form-group col-md-4">         
                  <button type="button" class="btn btn-success" name="btnsave_users" id="btn_check">Verifier</button>     
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-4">
                  <label class="form-label">Nom du Ong </label>         
                  <input type="text" class="form-control"  name="name_ong" placeholder="afficher l'ong" id="name_ong" value="" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-4">
                  <label class="form-label">Devise</label>           
                     <input type="text" class="form-control"  name="name_devise" placeholder="afficher devise" id="name_devise" value="" readonly>
                     <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-4">
                  <label class="form-label">Montant à payer </label>            
                     <input type="text" class="form-control"  name="name_montant" placeholder="le Montant à payer" id="name_montant" value="" readonly>
                     <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-6">
                  <label class="form-label">Montant payé </label>           
                     <input type="text" class="form-control"  name="Pmontant" placeholder="le saisir le montant" id="Pmontant" value="" readonly>
                     <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-6">
                  <label class="form-label">Rester </label>          
                     <input type="text" class="form-control"  name="name_reste" placeholder="reste à payer" id="name_reste" value="" readonly>
                     <div class="clearfix"></div>
               </div>
            </div>
            <hr class="border-light container-m--x my-4">
            <h3 class="font-weight-bold py-3 mb-0">Faite le paiement ici</h3>
            <div class="form-row">
               <div class="form-group col-md-6">
                     <input type="text" class="form-control"  name="montant" placeholder="le saisir le montant" id="montant" value="">
                     <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-6">         
                  <button type="button" class="btn btn-success" name="btnsave_banque" id="btnsave_sortie">Sortie</button>
                  <button type="reset" class="btn btn-danger">annule</button> 
               </div>
            </div>
         </form>
      </div>
   </div>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-12">
      <h6 class="card-header">Liste de Sortie</h6>
      <div class="card-body">
         <table class="table card-table" id="tab_sortie">
            <thead class="thead-light">
               <tr>
                  <th>Id</th>
                  <th>Agence Envois</th>
                  <th>Ville </th>
                  <th>Date.</th>
                  <th>Devise</th>
                  <th>Montant Env.</th>
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
var transact = 0;
$('#btn_check').click(function () {
  if ($("#name_transact").val() != '' && $("#agence").val()!='-1') {
    $.ajax({
      url: "{{route('route_paie')}}",
      type: 'POST',
      async: false,
      data: {
        code: $("#name_transact").val(),
        agence:$("#agence").val()
      },
      success: function (data) {
        if (data.success == '1') {
          transact = data.data.id_detail;
          document.getElementById('name_transact').readOnly = true;
          $("#name_ong").val(data.data.name_ong);
          if (data.data.devise == '1') {
            $("#name_devise").val("USD");
          } else {
            $("#name_devise").val("CDF");
          }
          $("#name_montant").val(data.data.montp);
          if (data.total == null) {
            $("#Pmontant").val("0");
          } else {
            $("#Pmontant").val(data.total);
          }
          $("#name_paye").val(data.total);
          var dif = data.data.montp - data.total;
          $("#name_reste").val(dif);
        } else {
          $("#message").html(data.success);
        }
      },
      error: function (data) {
        alert(data.success);
      }
    });
  } else {
    $('#message').html('Veuillez saisir le numero de transaction !');
  }
});
$('#montant').on('input', function () {
  if (!isNaN($('#montant').val())) {
    if (parseFloat($('#montant').val()) > parseFloat($('#name_reste').val())) {
      $('#montant').val('');
    }
  } else {
    $('#montant').val('');
  }
});
$('#btnsave_sortie').click(function () {
  if ($('#montant').val() != '' && $('#name_reste').val() != '' && $("#agence").val()!='-1')) {
    if (parseFloat($('#montant').val()) > 0 && transact != 0) {
      $.ajax({
        url: "{{route('sortie_ong')}}",
        type: 'POST',
        async: false,
        data: {
          code_detail: transact,
          montant: parseFloat($('#montant').val()),
          agence:$("#agence").val()
        },
        success: function (data) {
          if (data.success == '1') {
            window.location.href = ("{{route('index_paie_ong')}}");
          } else {
            $("#message").html(data.success);
          }
        },
        error: function (data) {
          alert(data.success);
        }
      });
    } else {
      alert('ok');
    }
  }
});
@endsection