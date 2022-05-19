@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Page de Sortie</h3>
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
                                                      <input type="text" class="form-control"  name="name_transact" placeholder="Saisir le code ici" id="name_transact" value="">
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
                                                              <input type="text" class="form-control"  name="name_expedit" placeholder="Expediteur" id="name_expedit" value="" readonly>
                                                                <div class="clearfix"></div> 
                                                              </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                              <div class="form-row"> 
                                                              <label class="form-label">Nom Beneficiaire</label> 
                                                              <input type="text" class="form-control"  name="name_ben" placeholder="Beneficiaire" id="name_ben" value="" readonly>
                                                              <div class="clearfix"></div>
                                                              </div>
                                                      </div>
                                                  </div> </br>
                                                  <div class="row">
                                                        <div class="col-md-6">
                                                              <div class="form-row">
                                                                    <label class="form-label">Devise</label> 
                                                                    <input type="text" class="form-control" placeholder="la devise" name="devise"  id="devise" value="" readonly>
                                                                    <input type="hidden" class="form-control" placeholder="la devise" name="name_devise"  id="name_devise" value="" readonly>
                                                                   
                                                                                  <div class="clearfix"></div>
                                                              </div> 
                                                        </div>

                                                        <div class="col-md-6">
                                                              <div class="form-row">
                                                              <label class="form-label">Montant envoyé</label> 
                                                              <input type="text" class="form-control"  name="name_montant" placeholder="le Montant" id="name_montant" value="" readonly>
                                                                <div class="clearfix"></div>
                                                              </div> 
                                                        </div>
                                                  </div></br>
                                                  <div class="row">
                                                        <div class="col-md-6">
                                                              <div class="form-row">
                                                              <label class="form-label">Pourcentage</label>  
                                                              <input type="text" class="form-control"  name="name_pourc" placeholder="montant Pourc." id="name_pourc" value="" readonly>
                                                                      <div class="clearfix"></div>
                                                              </div> 
                                                        </div>

                                                        <div class="col-md-6">
                                                              <div class="form-row">
                                                              <label class="form-label">Agence d'envois</label>  
                                                              <input type="text" class="form-control"  name="name_agence" placeholder="Agence d'envois" id="name_agence" value="" readonly>
                                                                    <div class="clearfix"></div>
                                                              </div> 
                                                        </div>
                                                  </div></br>
                                                  <div class="row">
                                                      <div class="col-md-6">
                                                        <div class="form-row">
                                                        <label class="form-label">Date de l'envois</label>
                                                          <input type="date" class="form-control"  name="name_date"  id="name_date" value="" readonly>
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
                            <h6 class="card-header">Liste de Sortie</h6>
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
@section('javascript')
<script type="text/javascript">
  (function() {
      $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
                });
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
                        let message="Voulez vous servir cette transaction au code de " + $("#name_transact").val() + " avec qu'un montant de ";
                        message += $("#name_montant").val() + " " + $("#devise").val() + " à Mr/Madame " + $("#name_ben").val();
                                Swal.fire({  
                                title: 'Colombe Money',
                                html: message, 
                                width: 600,
                                padding: '3em',  
                                showDenyButton: true,   
                                confirmButtonText: `Retirer`,  
                                denyButtonText: `Annuler`,
                          }).then((result) => {   
                                if (result.isConfirmed) {                             
                                    $.ajax({
                                    url   : "{{route('save_sortie')}}",
                                    type  : 'POST',
                                    async : false,
                                    data  : {code:$("#name_transact").val(),
                                              montant:$("#name_montant").val(),
                                              devise:$("#name_devise").val(),
                                              agence:$("#agence").val()
                                    },   
                                      success:function(data)
                                      {
                                            if(data.success=='1'){
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
                                                  Swal.fire('operation effectuée', '', 'success') 
                                                                        
                                                  }
                                                  else if(data.success=='3'){
                                                      Swal.fire('Coffre Insuffisant', '', 'error') 
                                                  } 
                                                  else{
                                                    Swal.fire('Argent déja servis', '', 'error') 
                                                  }
                                                            },
                                    error:function(data){
                                          console.log(data.success);
                                          Swal.fire('error', '', 'error')                              
                                          }
                                    });
                                                                                    
                                    } else if (result.isDenied) {    
                                      Swal.fire('Changes are not saved', '', 'info')  
                                    }
                                });
                              }
                              },
                                error:function(data){                         
                          }
                          });                    
                             
        }
        else{
            $('#message').html('Veuillez saisir le numero de transaction');
        }
   });

  })(); 

   function affiche_sortie(code_agence)
         {
           var otableau=$('#tab_sortie').DataTable({
                 "bProcessing":true,
                 "sAjaxSource":"/admin/liste_sortie="+code_agence,
                 "columns":[
                     {"data":'id'},
                     {"data":'created_at'},
                     {"data":'nomagence'},
                     {"data":'ville'},
                     {"data":'montenvoi'},
                     {"data":'intitule'},
                     {"data":'id',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-info btn-circle aff_sortie" ><i class="fa fa-check"></i></button>';
                          }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true,
                 "responsive": true
             });
         
         }
  
   
</script>
@endsection
