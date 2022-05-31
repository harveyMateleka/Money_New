@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">RETRAIT</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">   
                        </div>
                        <div class="card col-md-12">
                              <div class="card -header">    
                              </div>
                            <div class="card-body">
                                  <div id="message" style='color:red; font-size:15px;'>
                                  </div>
                                  <div class="row">
                                  <div class="col-md-12">
                                  <div class="row">
                                      <div class="col-md-5">
                                          <form action="#" method="POST" id="form_sortie">
                                                {{csrf_field()}}
                                                <div class="form-row">
                                                      <label class="form-label">Agence de Destination</label></br>         
                                                      <select class="custom-select flex-grow-1" id='agence' name="agence">
                                                      <option value='-1'>Choisir une agence</option>
                                                      @foreach($sortie_agence as $ligne_agence)
                                                      <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                                                      @endforeach
                                                    </select>
                                                </div></br>
                                                <div class="form-row">
                                                      <label class="form-label">Code de Transfert</label>
                                                      <input type="text"  style="border: 1px solid silver !important; padding-left: 8px !important" class="form-control"  name="name_transact" placeholder="Saisir le code ici" id="name_transact" value="">
                                                      <div class="clearfix"></div>
                                                </div></br>
                                                <button type="button" class="btn btn-success" name="btnsave_users" id="btn_check">Verifier</button>
                                          </form>
                                      </div>
                                      <div class="col-md-7" style="padding-left: 20px;">  
                                            <form action="#" method="POST">
                                                  {{csrf_field()}}
                                                  <div class="row">
                                                      <div class="col-md-6">
                                                              <div class="form-row"> 
                                                              <label class="form-label">Nom d'expediteur</label>
                                                              <input type="text" class="form-control" style="border: 1px solid silver !important; padding-left: 8px !important" name="name_expedit" placeholder="Expediteur" id="name_expedit" value="" readonly>
                                                                <div class="clearfix"></div> 
                                                              </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                              <div class="form-row"> 
                                                              <label class="form-label">Nom Beneficiaire</label> 
                                                              <input type="text" class="form-control"  style="border: 1px solid silver !important; padding-left: 8px !important" name="name_ben" placeholder="Beneficiaire" id="name_ben" value="" readonly>
                                                              <div class="clearfix"></div>
                                                              </div>
                                                      </div>
                                                  </div> </br>
                                                  <div class="row">
                                                        <div class="col-md-6">
                                                              <div class="form-row">
                                                                    <label class="form-label">Devise</label> 
                                                                    <input type="text" class="form-control"  style="border: 1px solid silver !important; padding-left: 8px !important" placeholder="la devise" name="devise"  id="devise" value="" readonly>
                                                                    <input type="hidden" class="form-control" placeholder="la devise" name="name_devise"  id="name_devise" value="" readonly>
                                                                   
                                                                                  <div class="clearfix"></div>
                                                              </div> 
                                                        </div>

                                                        <div class="col-md-6">
                                                              <div class="form-row">
                                                              <label class="form-label">Montant envoyé</label> 
                                                              <input type="text" class="form-control"   style="border: 1px solid silver !important; padding-left: 8px !important" name="name_montant" placeholder="le Montant" id="name_montant" value="" readonly>
                                                                <div class="clearfix"></div>
                                                              </div> 
                                                        </div>
                                                  </div></br>
                                                  <div class="row">
                                                        <div class="col-md-6">
                                                              <div class="form-row">
                                                              <label class="form-label">Pourcentage</label>  
                                                              <input type="text" class="form-control" style="border: 1px solid silver !important; padding-left: 8px !important" name="name_pourc" placeholder="montant Pourc." id="name_pourc" value="" readonly>
                                                                      <div class="clearfix"></div>
                                                              </div> 
                                                        </div>

                                                        <div class="col-md-6">
                                                              <div class="form-row">
                                                              <label class="form-label">Agence d'envoie</label>  
                                                              <input type="text" class="form-control" style="border: 1px solid silver !important; padding-left: 8px !important" name="name_agence" placeholder="Agence d'envois" id="name_agence" value="" readonly>
                                                                    <div class="clearfix"></div>
                                                              </div> 
                                                        </div>
                                                  </div></br>
                                                  <div class="row">
                                                      <div class="col-md-6">
                                                        <div class="form-row">
                                                        <label class="form-label">Date d'envoie</label>
                                                          <input type="date" class="form-control" style="border: 1px solid silver !important; padding-left: 8px !important"  name="name_date"  id="name_date" value="" readonly>
                                                                            <div class="clearfix"></div>
                                                        </div>
                                                           
                                                      </div> 
                                                  </div>  
                                            </form>   
                                      </div> 

                                  </div>
                                  
                                  </div>
                                  </div>
        
                   
                  </div>                 
                </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                            <h6 class="card-header">Liste des sorties</h6>
                            <div class="card-body">
                            <div style="overflow-x:auto;">
                            <table class="table card-table" id="tab_sortie">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                         <th>DATE</th>
                                        <th>PROVENANCE</th>
                                        <th>DESTINATION </th>
                                        <th>MONTANT</th>
                                        <th>DEVISE</th>        
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
$("#agence").select2();
$('#name_transact').on('input', function () {
  if($("#agence").val()=='-1'){
    $("#message").html("selectionnez l'agence");
    $('#name_transact').val("");
    return false; 
  }
 
});

$('#agence').change(function () {
  if ($('#agence').val() != '-1') {
    affiche_sortie($('#agence').val());
  } else {
    $('#tab_sortie').dataTable().clear();
  }
});

$('#btn_check').click(function() { 

       if($("#name_transact").val()!='' && $("#agence").val()!='-1'){ 
         $.ajax({
                     url   : "{{route('route_check')}}",
                     type  : 'POST',
                     async : false,
                     data  : {code:$("#name_transact").val(),
                              agence:$("#agence").val()
                     },
                     success:function(data)
                     {
                      if(data.success=='1'){
                        transact=data.data.numdepot;
                        document.getElementById('name_transact').readOnly = true;
                        $("#name_ben").val(data.data.nomben);
                        $("#devise").val(data.data.intitule);
                        $("#name_expedit").val(data.data.nomclient);
                        $("#name_montant").val(data.data.montenvoi);
                        $("#name_agence").val(data.data.nomagence);
                        $("#name_date").val(data.data.created_at);
                        $("#name_devise").val(data.data.id_devise);
                        $("#name_pourc").val(data.data.montpour);
                        var message="Voulez-vous servir cette transaction au code de " + $("#name_transact").val() + " avec qu'un montant un ";
                        message += $("#name_montant").val() + " " + $("#devise").val() + " à Mr/Madame " + $("#name_ben").val();
                        swal({
                              title: 'ABT-TRANSFERT',
                              text: message,
                              type: 'warning',
                              showCancelButton: true,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Yes,Envoyez!',
                              cancelButtonText: 'No, ANNULE!',
                              confirmButtonClass: 'btn btn-success',
                              cancelButtonClass: 'btn btn-danger',
                              buttonsStyling: false,
                              allowOutsideClick: false,
                              showLoaderOnConfirm: true,
                              preConfirm: function() {
                                return new Promise(function(resolve, reject) {
                                      if($("#name_transact").val()!='' && $("#name_montant").val()!='' && $("#agence").val()!='-1'){
                                        $.ajax({
                                              url   : "{{route('save_sortie')}}",
                                              type  : 'POST',
                                              async : false,
                                              data  : {code:$("#name_transact").val(),
                                                        montant:$("#name_montant").val(),
                                                        devise:$("#name_devise").val(),
                                                        agence:$("#agence").val()
                                              },
                                              success:function(response)
                                              {
                                                swal({
                                                                        type: 'info',
                                                                        title: 'La Colombe Money',
                                                                        html: response.success
                                                                    })
                                                if(response.success=='1'){
                                                                
                                                  document.getElementById('name_transact').readOnly = false;
                                                  var tab=['2',$("#name_agence").val(),'ville',
                                                  $("#name_transact").val(),$("#name_expedit").val(),'tel',
                                                  $("#name_ben").val(),'telben', $("#name_montant").val(),$("#name_pourc").val(),$("#devise").val(),'herve'];
                                                  window.location.href=("/pdf/generate/"+ tab);
                                                      $("#name_ben").val("");
                                                      $("#devise").val("");
                                                      $("#name_expedit").val("");
                                                      $("#name_montant").val("");
                                                      $("#name_agence").val("");
                                                      $("#name_date").val("");
                                                      $("#name_pourc").val("");
                                                      $("#name_devise").val("");
                                                      $("#agence").val("");
                                                      $("#name_transact").val("");
                                                      swal({
                                                                        type: 'info',
                                                                        title: 'La Colombe Money',
                                                                        html: "L'operation a été reussi"
                                                                    }) 
                                                }else if(response.success=='3'){
                                                                swal({
                                                                        type: 'info',
                                                                        title: 'La Colombe Money',
                                                                        html: "Le coffre est insuffisant pour effectuer cette transaction svp"
                                                                    })
                                                }
                                                else{
                                                                swal({
                                                                        type: 'info',
                                                                        title: 'La Colombe Money',
                                                                        html: "l'argent est deja servi"
                                                                    })  
                                                  }
                                                  
                                                
                                              },
                                              error:function(response){

                                                alert(response.success);                              
                                                }
                                          });
                                      }
                                      else {
                                          swal({
                                              type: 'info',
                                              title: 'La Colombe Money',
                                              html: "veuillez bien verifiez les valeurs affichées"
                                          })
                                      }
                                 
                              })
                              }

                          }).then(function() {
                                      swal({
                                      type: 'info',
                                      title: 'La Colombe Money',
                                      html: "l'operation a été annulée"
                                      })
                          }); 
                      }
                      else{
                        $("#message").html(data.success);  
                      }
                        
                       
                     },
                     error:function(data){

                       alert(data.success);                              
                       }
                 });  
        }
        else{
            $('#message').html('Saisiez le numero de transaction svp !');
        }
   });


  
   

@endsection
