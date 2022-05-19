@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
  <h3 class="font-weight-bold py-3 mb-0">Credit clients</h3>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb"></div>
  <!--   ===================================modal 2================================-->
  <div class="modal fade bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid flex-grow-1 container-p-y">
            <div class="text-muted small mt-0 mb-4 d-block breadcrumb"></div>
            <div class="card col-md-12">
              <h4 class="card-header">UPDATE CREDIT CLIENTS</h4>
              <div class="card-body">
                <form action="#" method="POST">
                  {{csrf_field()}}
                  
                  <div class="form-row">
                    <div class="form-group col-md-4">
                    <select class="custom-select flex-grow-1" id='numagence' name="agence" >
                      <option value='-1'>Agence de provenance</option> @foreach($agence as $ligne_agence) <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option> @endforeach
                    </select> 
                  </div>  

                    <div class="form-group col-md-4">
                      <label class="form-label">Nom Beneficiere</label>
                      <input type="text" class="form-control" name="" id='beneficiere'>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="form-label">TELPHONE</label>
                      <input type="text" class="form-control" name="" id='telphone'>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <select class="custom-select flex-grow-1" id='destination' name="name_ville">
                        <option value='-1'>Agence Destination</option> @foreach($tab_ville as $ligne_tab_ville) <option value='{!! $ligne_tab_ville->id_ville !!}'>{!! $ligne_tab_ville->ville !!}</option> @endforeach
                      </select> @foreach($tab_ville as $ligne_tab_ville) <input type="hidden" class="form-control" name="{{'ville'.$ligne_tab_ville->id_ville}}" id="{{'ville'.$ligne_tab_ville->id_ville}}" value="{{$ligne_tab_ville->ville}}">
                      <input type="hidden" class="form-control" name="{{'vil_init'.$ligne_tab_ville->id_ville}}" id="{{'vil_init'.$ligne_tab_ville->id_ville}}" value="{{$ligne_tab_ville->initial}}"> @endforeach
                    </div>
                    <div class="form-group col-md-4">
                      <select class="custom-select flex-grow-1" id='devise' name="name_devise">
                        <option class="form-label" value='-1'>Devise</option> @foreach($tab_devise as $ligne_devise) <option value='{!! $ligne_devise->id !!}'>{!! $ligne_devise->intitule !!}</option> @endforeach
                      </select> @foreach($tab_devise as $ligne_devise) <input type="hidden" class="form-control" name="{{'taux'.$ligne_devise->id}}" id="{{'taux'.$ligne_devise->id}}" value="{{$ligne_devise->taux}}">
                      <input type="hidden" class="form-control" name="{{'devise'.$ligne_devise->id}}" id="{{'devise'.$ligne_devise->id}}" value="{{$ligne_devise->intitule}}"> @endforeach
                    </div>

                    <div class="form-group col-md-4">
                      <label class="form-label">MONTANT</label>
                      <input type="text" class="form-control" name="" id='montenvoi'>
                    </div>
                  </div>
                  <button type="button"  class="btn btn-success" name="btndisplay" id='modifier_'>modifier</button>
                  <button type="reset" class="btn btn-danger">annule</button>
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="depot_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="numagence_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="montenvoi_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="nomben_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="devise_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="pourc">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="tel_code">
              
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <hr class="border-light container-m--x my-4">
  <div class="card col-md-12">
    <h6 class="card-header">LISTE DES CREDIT</h6>
    <div class="card-body">
        <div style="overflow-x:auto;">
        <table class="table card-table" id="update">
                                <thead class="thead-dark">
                                    <tr>
                                         <th>ID</th>
                                        <th>DATE</th>
                                        <th>CODE</th>
                                        <th>PROVENANCE</th>
                                        <th>DESTINATION</th>
                                        <th>EXPEDITEUR</th>
                                        <th>BENEFICIARE</th>
                                        <th>MONTANT</th>
                                        <th>DEVISE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @php
                                $totalcdf=0;
                                $totalusd=0;
                                @endphp

                                  @foreach ($resultat as $resultats)
                                  <tr>
                                  @php

                                  $create =$resultats->created_at;
                                  $create_at_difference = Carbon\Carbon::createFromTimestamp(strtotime($create))->diff(\Carbon\Carbon::now())->days;
                                

                                  
                               @endphp
                                @if($resultats->id_devise==1)
                                    @php
                                        $totalusd+=$resultats->montenvoi;
                                    @endphp
                                 
                                    @else
                                    @php     
                                       $totalcdf+=$resultats->montenvoi;
                                       @endphp
                                 
                               @endif  
                                 

                                  @if($create_at_difference >= 30)
                                     <td style="color:red">{{$resultats->id}}</td>
                                     <td style="color:red">{{$resultats->created_at}}</td>
                                     <td style="color:red">{{$resultats->numdepot}}</td>
                                     <td style="color:red">{{$resultats->nomagence}}</td>
                                     <td style="color:red">{{$resultats->ville}}</td>
                                      <td style="color:red">{{$resultats->nomclient}}</td>
                                     <td style="color:red">{{$resultats->nomben}}</td>
                                      <td style="color:red">{{$resultats->montenvoi}}</td>
                                      <td style="color:red">{{$resultats->intitule}}</td>
                                  
                                     <td>
                                   

             <button  data-id='{{$resultats->id}}' class="btn btn-primary   checking" type='button'>RETIRE</button>
                                     </td>
                                  @else
                                  <td style="color:green">{{$resultats->id}}</td>
                                     <td style="color:green">{{$resultats->created_at}}</td>
                                     <td style="color:green">{{$resultats->numdepot}}</td>
                                     <td style="color:green">{{$resultats->nomagence}}</td>
                                     <td style="color:green">{{$resultats->ville}}</td>
                                      <td style="color:green">{{$resultats->nomclient}}</td>
                                     <td style="color:green">{{$resultats->nomben}}</td>
                                      <td style="color:green">{{$resultats->montenvoi}}</td>
                                      <td style="color:green">{{$resultats->intitule}}</td>
                                     
                                     <td>
                                       <button href="javascript:void(0)"  class="btn btn-danger" disabled><i class="fa fa-times"></i>BLOCK</button>
                                      <button  data-id='{{$resultats->id}}' class="btn btn-success fa fa-edit update" type='button'>EDIT</button>
                                      <button  data-id='{{$resultats->id}}' class="btn btn-warning fa fa-check-circle" type='button'>RETRAIT</button>
                                     </td>
                                  @endif

                                  
                                  </tr>
                                      
          </tr> @endforeach </tbody>
      </table>
        </div>
      
       {{csrf_field()}}
      <div class="form-row" style="padding-left:30%">
    <div class=" col-md-4">
        <label class="form-label" for="floatingInputInvalid">TOTAL CREDIT EN CDF</label>
      <input type="text" class="form-control"  name="totalcdf" id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  data-type="currency" placeholder="$1,000,000.00" value='{{$totalcdf}}'><span>CDF</span></input>
    </div>
    <div class=" col-md-4">
        <label class="form-label" for="floatingInputInvalid">TOTAL CREDIT EN USD</label>
      <input type="text" value='{{$totalusd}}' class="form-control" placeholder="TOTAL CREDIT EN USD"><span>USD</span></input>
    </div>
  </div>
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

$("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});
 
function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val = "" + left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = "" + input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}























    // DataTables initialisation
    var table = $('#update').DataTable({
      "lengthMenu": [
        [10, 25, 50, -1],
        [5, 25, 50, "All"]
      ],
      responsive:true,

      dom: 'Bfrtip',
      buttons: [
        'print', 'copy', 'excel', 'pdf'

      ]
    });

    $("#modifier_").click(function () {  
      if($("#destination").val()!='-1' && $("#devise").val()!='-1' && $("#telphone").val()!='' && $("#montenvoi").val()!='' && $("#beneficiere").val()!=''){ 
        $.ajax({
            url: "{{route('up_credit_client')}}",
            type: 'POST',
            async: false,
            data: {
             montenvoi: $("#montenvoi").val(),
             agence: $("#numagence").val(),
             montenvoi_code:$("#montenvoi_code").val(),
             id_devise: $("#devise").val(),
             code_devise:$("#devise_code").val(),
             ville:$("#destination").val(),
             ben:$("#beneficiere").val(),
             telben:$("#telphone").val(),
             pourc:$("#pourc").val(),
             id_code : $("#depot_code").val()      

            },
          success: function (data) {

          alert(data.success);
          window.location.href = ("{{route('index_credit')}}");
  }

});
      }
    });


$(".checking").click(function (e) {
  var ids = $(e.target).attr("data-id");
swal({
        title: ' la Colombe Money',
        text: "Voulez vous retire le credit client d un mois?il sont restituer seulement au de reclamations!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,RETIRE!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
  $.ajax({
    url: "{{route('update_credit')}}",
    type: 'POST',
    async: false,
    data: {
      code: ids,

    },
    success: function (data) {
    swal({title: 'la colombe Money!',
                text: 'credit client retire!',
                type: 'success'
                })
      window.location.href = ("{{route('index_credit')}}");
    }

  });

   })

   }
 }).then(function () {
        swal({
            type: 'info',
            title: 'la colombe Money',
            html: 'credit ne pas encore retire'
        })
    });

});






$(".update").click(function (e) {
  var ids = $(e.target).attr("data-id");
  $.ajax({
    url: "{{route('get_id_credit')}}",
    type: 'POST',
    async: false,
    data: {
      code: ids,
    },
    success: function (data) {

      $("#beneficiere").val(data.nomben);
         $("#numagence").val(data.numagence);
         document.getElementById('numagence').disabled = true;
         $("#devise").val(data.id_devise);
         $("#destination").val(data.id_ville);
         $("#telphone").val(data.telclient);
         $("#montenvoi").val(data.montenvoi);
         $("#devise_code").val(data.id_devise);
         $("#montenvoi_code").val(data.montenvoi);
         $("#depot_code").val(data.id);
         $("#pourc").val(data.montpour);
        $('#exampleModal2').modal('show');  
    
    }

  });

});






$('body').delegate('.update_credit', 'click', function () {
  var ids = $(e.target).attr("data-id");
  alert(ids);

  $.ajax({
    url: "{{route('update_credit')}}",
    type: 'POST',
    async: false,
    data: {
      code: ids,

    },
    success: function (data) {
      window.location.href = ("{{route('index_credit')}}");
    }
  });
});

$('body').delegate('.supprimer_banque', 'click', function () {
  var ids = $(this).data('id');
  $.ajax({
    url: "{{route('delete_banque')}}",
    type: 'POST',
    async: false,
    data: {
      code: ids
    },
    success: function (data) {
      if (data.success == '1') {
        window.location.href = ("{{route('index_banque')}}");
      } else {
        alert('erreur dans la suppression');
      }
    }
  });
});
})();
</script>
@endsection

