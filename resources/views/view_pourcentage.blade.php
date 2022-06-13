@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">POURCENTAGE DU JOURS</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>

    
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-18">
                            <h6 class="card-header">LISTE DES POURCENTAGE</h6>
                            <div class="card-body">
                              <table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>DATE DU:</td>
            <td><input type="text" id="min" name="min"></td>
        </tr>
        <tr>
            <td>AU DATE:</td>
            <td><input type="text" id="max" name="max"></td>
        </tr>
    </tbody></table>
                            <table class="table card-table" id="update">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>AGENCE</th>
                                        <th>% CDF</th>
                                        <th>% USD</th>
                                        <th>DEPENSE CDF</th>
                                        <th>DEPENSE USD</th>
                                        <th>RESTE % CDF</th>
                                        <th>RESTE % USD</th>
                                        <th>DATE</th>
                                        
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

                                $restcdf=$resultats->pourcentagecdf-$resultats->depensecdf;
                                $restusd=$resultats->pourcentageusd-$resultats->depenseusd;

                                $totalcdf+=$restcdf;
                                $totalusd+=$restusd;

                                @endphp
                              
                                     <td>{{$resultats->id_cloture}}</td>
                                     <td>{{$resultats->nomagence}}</td>
                                     <td>{{$resultats->pourcentagecdf}}</td>
                                     <td>{{$resultats->pourcentageusd}}</td>
                                     <td>{{$resultats->depensecdf}}</td>
                                     <td>{{$resultats->depenseusd}}</td>
                                     <td>{{$restcdf}}</td>
                                     <td>{{$restusd}}</td>
                                     <td>{{$resultats->datecloture}}</td>
                                     
                                     
                                  @endforeach
                                </tbody>
                            </table>
                            <div class="form-row">
                                    {{csrf_field()}}
                                        <div class="form-group col-md-3">
                                           <label class="form-label">POURCENTAGE USD</label>
                                            <input type="text"  class="form-control" data-validation="required" name="totalusd" placeholder="" id="totalusd" value="{{$totalusd}}">
                                            <div class="clearfix"></div>
                                        </div>
                                       <div class="form-group col-md-3">
                                           <label class="form-label">POURCENTAGE FRANCS</label>
                                            <input type="text"  class="form-control" data-validation="required" name="totalcdf" placeholder="" id="totalcdf" value="{{$totalcdf}}">
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group col-md-3"
                                            <input type="hidden"  class="form-control" data-validation="required" name="numagence" placeholder="Saisir le nom de la agence" id="numagence">
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-5">
                                        <button  data-id='' class="btn btn-success fa fa-edit checking" type='button'>RETIRE POURCENTAGE</button>
                                        </div>

                                    </div>
                            </div>
                        </div>
                    </div> 



@endsection
@section ('script')
$(document).ready(function() {
 
    $('#update').DataTable({
     "lengthMenu": [[10, 25, 50, -1], [5, 25, 50, "All"]],

      dom: 'Bfrtip',
        buttons: [
            'print', 'copy', 'excel', 'pdf'
            
        ]
  });


 var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();

        var created_at = new Date( data[4] );
 
        if (
            ( min === null && max === null ) ||
            ( min === null && created_at <= max ) ||
            ( min <= created_at   && max === null ) ||
            ( min <= created_at   && created_at <= max )
        ) {
            return true;
        }
        return false;
    }
);
 
$(document).ready(function() {
    // Create date inputs
    minDate = new DateTime($('#min'),{
        format: 'MMMM Do YYYY'
    });
    maxDate = new DateTime($('#max'),{
        format: 'MMMM Do YYYY'
    });
 
    // DataTables initialisation
    var table = $('#update').DataTable();
 
    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });
});

} );



$('.checking').click(function() {



var id_banq=$("#id_banque").val(); 
var totalcdf=$("#totalcdf").val();
var totalusd=$("#totalusd").val();

 swal({
        title: 'La Colombe Money',
        text: "Voulez vous retire le pourcentage?!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui,RETIRE!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {

        $.ajax({
              url   : "{{route('update_pourcentage')}}",
              type  : 'POST',
              async : false,
              data  : { totalcdf: $("#totalcdf").val(),
                       totalusd: $("#totalusd").val(),
                        ids:$("#code_banque").val(),
              },
              success:function(data)
              {
                    

              if(data.success=='1'){
                    swal({
                        title: 'La Colombe!',
                        text: 'le pourecentage a etait retire!',
                        type: 'success'
                    })
                        window.location.href=("{{route('index_pourcentage')}}");
                    }
                   else{
                        alert('erreur de transaction');
                  }
               
              }

          });     
              })
        }
    }).then(function () {
        swal({
            type: 'info',
            title: 'La Colombe Money',
            html: 'Pourcentage ne pas retire'
        })
    });


});

$('body').delegate('.modifier_banque','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('get_banque')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        $("#numero_compte").val(data.numero_compte);
                        $("#intitulecompte").val(data.intitulecompte);
                        $("#Montant").val(data.Montant);
                        $("#devise").val(data.devise);
                        $("#code_banque").val(data.id_banq);
                      }
                  });
         });
         $('body').delegate('.supprimer_banque','click',function(){
        var ids=$(this).data('id');
            $.ajax({
            url   : "{{route('delete_banque')}}",
            type  : 'POST',
            async : false,
            data  : {code: ids
            },
            success:function(data)
            {
              if(data.success=='1'){
                  window.location.href=("{{route('index_banque')}}");
              }
              else{
                  alert('erreur dans la suppression');
              }
            }
        });
    });








$('body').delegate('.update_credit','click',function(){
               var ids = $(e.target).attr("data-id");
                  alert(ids);
               
                  $.ajax({
                      url   : "{{route('update_credit')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids, 
                                  
                      },
                      success:function(data)
                      {
                         window.location.href=("{{route('index_credit')}}");
                      }
                  });
        });


         $('body').delegate('.supprimer_banque','click',function(){
         var ids=$(this).data('id');
            $.ajax({
            url   : "{{route('delete_banque')}}",
            type  : 'POST',
            async : false,
            data  : {code: ids
            },
            success:function(data)
            {
              if(data.success=='1'){
                  window.location.href=("{{route('index_banque')}}");
              }
              else{
                  alert('erreur dans la suppression');
              }
            }
        });
    });

@endsection

