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
              <form class="needs-validation" novalidate>
                <form action="#" method="POST">
                {{csrf_field()}}
                <div class="row">
                  <div class="col-md-6">
                  <select class="custom-select" id='numagence' name="agence" style="text-transform:uppercase;" >
                     @foreach($agence as $ligne_agence) <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option> @endforeach
                    </select>
                  </div> 
                  <div class="col-md-6">
                  <select class="custom-select flex-grow-1" id='destination' name="name_ville" style="text-transform:uppercase;">
                        <option value='-1'>Agence Destination</option> @foreach($tab_ville as $ligne_tab_ville) <option value='{!! $ligne_tab_ville->id_ville !!}'>{!! $ligne_tab_ville->ville !!}</option> @endforeach
                      </select> @foreach($tab_ville as $ligne_tab_ville) <input type="hidden" class="form-control" name="{{'ville'.$ligne_tab_ville->id_ville}}" id="{{'ville'.$ligne_tab_ville->id_ville}}" value="{{$ligne_tab_ville->ville}}">
                      <input type="hidden" class="form-control" name="{{'vil_init'.$ligne_tab_ville->id_ville}}" id="{{'vil_init'.$ligne_tab_ville->id_ville}}" value="{{$ligne_tab_ville->initial}}"> @endforeach
                  </div> 
                </div> 
                <div class="row">
                    <div class="col-md-6">
                    <label class="form-label">NOM EXPEDITEUR</label>
                      <input type="text" class="form-control" name="" id='expediteur' style="text-transform:uppercase;">
                    </div> 
                    <div class="col-md-6">
                    <label class="form-label">TELEPHONE</label>
                      <input type="text" class="form-control" name="" id='telphoneex' style="text-transform:uppercase;">
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <label class="form-label">NOM BENEFICIAIRE</label>
                      <input type="text" class="form-control" name="" id='beneficiere' style="text-transform:uppercase;">
                    </div> 
                    <div class="col-md-6">
                    <label class="form-label">TELEPHONE</label>
                      <input type="text" class="form-control" name="" id='telphone' style="text-transform:uppercase;">
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <label class="form-label">MONTANT</label>
                      <input type="text" class="form-control" name="" id='montenvoi' style="text-transform:uppercase;">
                    </div> 
                    <div class="col-sm-2">
                    <select class="custom-select flex-grow-1" id='devise' name="name_devise" style="text-transform:uppercase;">
                        <option class="form-label" value='-1' readonly>Devise</option> @foreach($tab_devise as $ligne_devise) <option value='{!! $ligne_devise->id !!}'>{!! $ligne_devise->intitule !!}</option> @endforeach
                      </select> @foreach($tab_devise as $ligne_devise) <input type="hidden" class="form-control" name="{{'taux'.$ligne_devise->id}}" id="{{'taux'.$ligne_devise->id}}" value="{{$ligne_devise->taux}}">
                      <input type="hidden" class="form-control" name="{{'devise'.$ligne_devise->id}}" id="{{'devise'.$ligne_devise->id}}" value="{{$ligne_devise->intitule}}"> @endforeach
                    </div> 
                    <div class="col-md-4">
                    <label class="form-label">DATE DE TRANSFERT</label>
                      <input type="text" class="form-control" name="" id='date' style="text-transform:uppercase;">
                    </div>
                </div> 
                </div>
                <div class="row">
                <div class="col-md-2">
                     <button type="button"  class="btn btn-success" name="btndisplay" id='modifier_'>modifier</button>
                </div>
                <div class="col-md-3">
                <button type="reset" class="btn btn-danger">annule</button>
                </div>
                </div>
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="depot_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="numagence_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="montenvoi_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="nomben_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="nomclient_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="devise_code">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="pourc">
                  <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="tel_code">
              
                </form>
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
  <div class="card col-md-18">
    <h6 class="card-header">LISTE DES CREDIT</h6>
    <div style="overflow-x:auto;">
    <div class="card-body">
       <table class="table card-table" id="update">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>DATE</th>
                                        <th>CODE</th>
                                        <th>PROVENANCE</th>
                                         <th>DESTINATION</th>
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
                                      <!-- <td style="color:red">{{$resultats->nomclient}}</td>-->
                                      <td style="color:red">{{$resultats->nomagence}}</td>
                                     <td style="color:red">{{$resultats->ville}}</td>
                                      <td style="color:red">{{$resultats->montenvoi}}</td>
                                      <td style="color:red">{{$resultats->intitule}}</td>
                                     
                                     <td>
                                   
             <button  data-id='{{$resultats->id}}' class="btn btn-success fa fa-level-up checking" type='button'>RETIRE</button>
             <button  data-id='{{$resultats->id}}' class="btn btn-warning fa fa-plus checkings" type='button'>RETRAIT</button>
                                     </td>
                                  @else
                                     <td style="color:green">{{$resultats->id}}</td>
                                     <td style="color:green">{{$resultats->created_at}}</td>
                                     <td style="color:green">{{$resultats->numdepot}}</td>
                                      <td style="color:green">{{$resultats->nomagence}}</td>
                                     <td style="color:green">{{$resultats->ville}}</td>
                                      <td style="color:green">{{$resultats->montenvoi}}</td>
                                      <td style="color:green">{{$resultats->intitule}}</td>

                                     <td>
                                       <button href="javascript:void(0)"  class="btn btn-danger" disabled><i class="fa fa-times"></i></button>
                                           <button  data-id='{{$resultats->id}}' class="btn btn-success fa fa-edi update" type='button'>EDIT</button>
                                           <button  data-id='{{$resultats->id}}' class="btn btn-warning fa fa-plus checkings" type='button'>RETRAIT</button>
                                           
                                     </td>
                                  @endif
                                  </tr>
                                      
          </tr> @endforeach </tbody>
      </table>
       {{csrf_field()}}
      <div class="form-row" style="padding-left:40%">
    <div class=" col-md-4">
        <label class="form-label" for="floatingInputInvalid">TOTAL CREDIT EN CDF</label>
      <input type="text"  style="border: 1px solid silver !important; padding-left: 8px !important" class="form-control"  name="totalcdf" id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  data-type="currency" placeholder="$1,000,000.00" value='{{$totalcdf}}' <span>CDF</span></input>
    </div>
    <div class=" col-md-4">
        <label class="form-label" for="floatingInputInvalid">TOTAL CREDIT EN USD</label>
      <input type="text" style="border: 1px solid silver !important; padding-left: 8px !important" data-type="currency" value='{{$totalusd}}' <span>USD</span></input>
    </div>
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
swal.fire({
        title: ' la Colombe Money',
        text: "Voulez vous retire le Code:{{$resultats->numdepot}},Du:{{$resultats->created_at}},Pour le Montant:{{$resultats->montenvoi}}{{$resultats->intitule}},De:{{$resultats->nomclient}}!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OUI,RETIRE!',
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
    swal.fire({title: 'la colombe Money!',
                text: 'Le Credit Code est retire avec sucess !',
                type: 'success'
                })
      window.location.href = ("{{route('index_credit')}}");
    }

  });

   })

   }
 }).then(function () {
        swal.fire({
            type: 'info',
            title: 'la colombe Money',
            html: 'Le retrait est annulé du code: {{$resultats->numdepot}} par vous '
        })
    });

});



$(".checkings").click(function(e){ 
    var ids = $(e.target).attr("data-id");
    swal.fire({
        title: 'La Colombe Money',
        text: "Vous Voulez faire un retrait code",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OUI,RETRAIT!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
       $.ajax({
                      url   : "{{route('update_retrait')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids, 
                                  
                      },
                      success:function(data)
                      {
                        swal.fire({title: 'La Colombe Moneys!',
                        text: 'code retire avec success!',
                        type: 'success'
                })
                         window.location.href=("{{route('index_credit')}}");
                      }

         });
         })

   }
 }).then(function () {
        swal.fire({
            type: 'info',
            title: 'la colombe Money',
            html: 'Code Retrait annuler avec success'
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
         $("#telphoneex").val(data.tel);
         $("#montenvoi").val(data.montenvoi);
         $("#devise_code").val(data.id_devise);
         $("#expediteur").val(data.nomclient);
         $("#montenvoi_code").val(data.montenvoi);
         $("#date").val(data.created_at);
         $("#depot_code").val(data.id);
         $("#pourc").val(data.montpour);
        $('#exampleModal2').modal('show');  
    
    }

  });

});






$('body').delegate('.update_credit', 'click', function () {
  var ids = $(e.target).attr("data-id");
  //alert(ids);

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

