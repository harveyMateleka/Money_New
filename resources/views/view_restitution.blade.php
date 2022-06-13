@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">RESTITUTION DE L'ARGENT DE CREDIT</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-18">
                            <h6 class="card-header">LISTE DES CREDIT</h6>
                            <div class="card-body">
                            <table class="table card-table" id="update">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>NUMERO DEPOT</th>
                                        <th>BENEFICIARE</th>
                                        <th>MONTANT</th>
                                        <th>VILLE</th>
                                        <th>AGENCE</th>
                                        <th>EXPEDITEURE</th>
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

                                  @if($create_at_difference >= 30)
                                     <td style="color:red">{{$resultats->id}}</td>
                                     <td style="color:red">{{$resultats->numdepot}}</td>
                                     <td style="color:red">{{$resultats->nomben}}</td>
                                     <td style="color:red">{{$resultats->montenvoi}}</td>
                                     <td style="color:red">{{$resultats->ville}}</td>
                                     <td style="color:red">{{$resultats->nomagence}}</td>
                                     <td style="color:red">{{$resultats->nomclient}}</td>
                                     <td style="color:red">{{$resultats->intitule}}</td>
                                     <td>
                                   

             <button  data-id='{{$resultats->id}}' class="btn btn-success fa fa-edit checking" type='button'>RESTITUTUER</button>
                                     </td>
                                  @else
                                    <td style="color:green">{{$resultats->id}}</td>
                                     <td style="color:green">{{$resultats->numdepot}}</td>
                                     <td style="color:green">{{$resultats->nomben}}</td>
                                     <td style="color:green">{{$resultats->montenvoi}}</td>
                                     <td style="color:green">{{$resultats->ville}}</td>
                                     <td style="color:green">{{$resultats->nomagence}}</td>
                                     <td style="color:green">{{$resultats->nomclient}}</td>
                                     <td style="color:green">{{$resultats->intitule}}</td>
                                     <td>
                                       <button href="javascript:void(0)"  class="btn btn-danger" disabled><i class="fa fa-times"></i>BLOQUE</button>
                                     </td>
                                  @endif
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div> 



@endsection
@section ('javascript')
<script type="text/javascript">
$(document).ready(function() {
    $('#update').DataTable({
    "lengthMenu": [[10, 25, 50, -1], [5, 25, 50, "All"]],
     
      dom: 'Bfrtip',
        buttons: [
            'print', 'copy', 'excel', 'pdf'
            
        ]
  });
});

$(".checking").click(function(e){ 
    var ids = $(e.target).attr("data-id");
    swal.fire({
        title: 'Voulez vous restitutue le credit client?',
        icon: 'info',
        text: "il sont restituer seulement au cas de reclamations!",
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
                      url   : "{{route('update_restitution')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids, 
                                  
                      },
                      success:function(data)
                      {
                        swal.fire({title: 'la colombe Money!',
                        text: 'credit client restituer avec success!',
                        type: 'success'
                })
                         window.location.href=("{{route('index_restitution')}}");
                      }

         });
         })

   }
 }).then(function () {
        swal.fire({
            type: 'info',
            icon: 'info',
            title: 'la colombe Money',
            html: 'credit ne pas encore restituer'
        })
    });

              
 });



$('body').delegate('.update_credit','click',function(){
               var ids = $(e.target).attr("data-id");
                  alert(ids);
               
                  $.ajax({
                      url : "{{route('update_credit')}}",
                      type : 'POST',
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
</script> 
@endsection

