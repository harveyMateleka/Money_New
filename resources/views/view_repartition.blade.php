@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">REPARTITION</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-12">
                            <h4 class="card-header">
                            <div>
                        
                          <label>REPARTITION D'ARGENT PAR AGENCE</label>
                          </h4>
                            <div class="red box">
                           </div>
                        <div class="green box">
                      
                    </div>  
                      <div class="card-body">
                            <form action="#" method="POST" id="form_agence">
                            
                                <div class="form-row">
                                      <div class="form-group col-md-4">
                                         {{csrf_field()}}
                                        <select class="form-control js-states" name="id_agence"
                                        style="border:1px solid silver !important"
                                         id="id_agence" data-validation="required">
                                        <option value='-1' >Selectionez l'agence</option>
                                        @foreach($resultat as $data)
                                        <option value="{!! $data->numagence !!}">{!! $data->nomagence !!}</option>
                                        @endforeach
                                        </select>
                                      </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Montant CDF</label>
                                        <input type="number" class="currency" autocomplete="off" data-validation="required" name="Montcdf"  id="Montcdf">
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="form-label">Montant USD</label>
                                        <input type="number" class="currency" autocomplete="off" data-validation="required" name="Montusd"  id="Montusd">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                
                                 </div>
                                
                                <button type="button" class="btn btn-success" name="btnsave_repartition" id="btnsave_repartition">REPARTIR</button>
                                <button type="button" class="btn btn-danger">annule</button>
                                <input type="hidden" class="form-control" placeholder="Saisir le nom de la agence" id="code_agence1">
                            </form>
                        </div> 
                </div>   

                        
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                            <h6 class="card-header">Liste de agence</h6>
                            <div class="card-body">
                                <div style="overflow-x:auto;">
                            <table class="table card-table" id="tab_agence1">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>NOM AGENCE</th>
                                        <th>TEL SERVICE</th>
                                        <th>MONTANTCDF</th>
                                        <th>MONTANTUSD</th>
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
 
                                               
@endsection
@section('script')
        $('#btnsave_repartition').click(function() {
        var nomagence=$("#id_agence").val();
        var Montcdf=$("#Montcdf").val();
        var Montusd=$("#Montusd").val();

        
        if(Montcdf!='' && Montusd!=''){ 
            if ($("#code_agence1").val()=='') {
                       swal({
        title: 'La Colombe Money',
        text: "Voulez vous repartir argent pour cette agence?!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,Repartir!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                     $.ajax({
                      url   : "{{route('route_update_repartition')}}",
                      type  : 'POST',
                      async : false,
                      data  : {Montcdf:$("#Montcdf").val(),
                               Montusd:$("#Montusd").val(),
                               numagence:$("#id_agence").val(),
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                         swal({title: 'la colombe Money!',
                         text: 'repartition successfully!',
                         type: 'success'
                         })
                            affiche_agence1();
                            $("#id_agence").val('-1');
                            $("#Montcdf").val('');
                            $("#Montusd").val('');
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
            title: 'la colombe Money',
            html: 'pas de repartition ne pas faite'
        })
    });
                
            }
            else{
              alert('erreur de transaction');
            }
            
        }

    });

  
   $('body').delegate('.modifier_agence1','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('get_agence')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        $("#id_agence").val(data.numagence);
                        $("#Montcdf").val(data.Montcdf);
                        $("#Montusd").val(data.Montusd);
                        $("#code_agence").val(data.numagence);
                      }
                  });
         });
    

 
    
@endsection
