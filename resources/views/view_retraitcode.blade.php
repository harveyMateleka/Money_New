@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Retrait Code</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        
                        <hr class="border-light container-m--x my-6">
                        <div class="card col-md-18">
                            <h6 class="card-header">LISTE DES CODES A RETIRE</h6>
                            <div style="overflow-x:auto;">
                            <div class="card-body">
                            <table class="table card-table" id="update">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>CODE</th>
                                        <th>EXPEDITEURE</th>
                                        <th>BENEFICIARE</th>
                                        <th>PROVENANCE</th>
                                        <th>DESTINATION</th>
                                        <th>MONTANT</th>
                                        <th>DEVISE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  @foreach ($resultat as $resultats)
                                  <tr>
                                  @php

                                  $create =$resultats->created_at;
                                  $create_at_difference = Carbon\Carbon::createFromTimestamp(strtotime($create))->diff(\Carbon\Carbon::now())->days;
                                  @endphp

                                
                                     <td >{{$resultats->id}}</td>
                                     <td >{{$resultats->numdepot}}</td>
                                     <td >{{$resultats->nomclient}}</td>
                                     <td >{{$resultats->nomben}}</td>
                                      <td >{{$resultats->nomagence}}</td>
                                       <td >{{$resultats->ville}}</td>
                                     <td >{{$resultats->montenvoi}}</td>
                                     <td >{{$resultats->intitule}}</td>
                                     <td>
                                   

                                 <button  data-id='{{$resultats->id}}' class="btn btn-success fa fa-edit checking" type='button'>RETRAIT</button>
                                     </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
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
} );

$(".checking").click(function(e){ 
    var ids = $(e.target).attr("data-id");
    swal({
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
                        swal({title: 'La Colombe Moneys!',
                        text: 'code retire avec success!',
                        type: 'success'
                })
                         window.location.href=("{{route('index_retrait')}}");
                      }

         });
         })

   }
 }).then(function () {
        swal({
            type: 'info',
            title: 'la colombe Money',
            html: 'Le code retrait a ??t?? annul?? avec success !'
        })
    });

              
 });



@endsection

