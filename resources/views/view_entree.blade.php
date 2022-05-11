@extends('layouts.header')
@section('content')
<style type="text/css">
.currency:after{ content: '.00'; }
</style>
<div class="modal fade" id="modal_entree" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div id="message">
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btn_saveT">ok</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0">DEPOT</h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">   
   </div>
   <div class="card col-md-12">
      <div class="card -header">    
      </div>
      <div class="card-body">
         <form action="#" method="POST" id="form_affectation">
            {{csrf_field()}}
            <div class="row">
               <div class="col-md-4">
                  <label class="form-label"> Agence de Provenance</label>
                  <select class="custom-select flex-grow-1" id='name_agence' name="agence" required>
                     <option value='-1'>Choisir une agence</option>
                     @foreach($don as $ligne_agence)
                     <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                     @endforeach
                  </select>
                  @foreach($don as $ligne_agence)
                  <input type="hidden"  class="form-control"  name="{{'agence'.$ligne_agence->numagence}}"  id="{{'agence'.$ligne_agence->numagence}}" value="{{$ligne_agence->nomagence}}">
                   <input type="hidden"  class="form-control"  name="{{'ag_init'.$ligne_agence->numagence}}"  id="{{'ag_init'.$ligne_agence->numagence}}" value="{{$ligne_agence->initial}}">
                  @endforeach
               </div></br>

               <div class="col-md-4">
                  <label class="form-label"> Ville du Beneficiare</label></br>
                           <select  class="custom-select flex-grow-1" id='name_ville' name="name_ville" required>
                              <option value='-1'>Choisir la Ville</option>
                              @foreach($tab_ville as $ligne_tab_ville)
                              <option value='{!! $ligne_tab_ville->id_ville !!}'>{!! $ligne_tab_ville->ville !!}</option>
                              @endforeach
                           </select>
                           @foreach($tab_ville as $ligne_tab_ville)
                           <input type="hidden"  class="form-control"  name="{{'ville'.$ligne_tab_ville->id_ville}}"  id="{{'ville'.$ligne_tab_ville->id_ville}}" value="{{$ligne_tab_ville->ville}}">
                           <input type="hidden"  class="form-control"  name="{{'vil_init'.$ligne_tab_ville->id_ville}}"  id="{{'vil_init'.$ligne_tab_ville->id_ville}}" value="{{$ligne_tab_ville->initial}}">
                         
                           @endforeach
                </div></br>
               <div class="col-md-4">
                  <div class="form-row">
                     <label class="form-label">Code de Transfert</label> 
                     <input type="text" class="form-control"  name="transact" placeholder="" id="name_transact" value="" readonly required>
                     <div class="clearfix"></div>
                  </div> 
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-row">
                          <label class="form-label">Nom Expediteur</label>
                              <input type="text" style="text-transform:uppercase;" class="form-control"  name="expedieteur" placeholder="" id="name_expedit" required>
                              <div id="mes_naex" style="color:red; font-size:10px;" class="clearfix"></div>
                        </div>
               </div>
                  <div class="col-md-4">
                        <div class="form-row">
                          <label class="form-label"><NAV>Phone Expediteur</NAV></label>
                              <input type="tel" maxlength="15" class="form-control" min="0" max="2"  name="telexpedit" placeholder="" id="tel_expedit" required='Veuillez saisir cette zone'>
                              <div id="mes_ex" style="color:red; font-size:10px;" class="clearfix"></div>
                        </div>
                  </div>
                   <div class="col-md-4">
                        <div class="form-row">
                          <label class="form-label">Nom Beneficiaire</label>
                              <input type="text" style="text-transform:uppercase;" class="form-control"  name="ben" placeholder="" id="name_benefic" required>
                              <div id="id_ben"class="clearfix"></div>
                        </div>
                     </div>
            </div>
            <div class="row"> 
                     <div class="col-md-3">
                        <div class="form-row">
                        <label class="form-label">Phone Beneficiere</label>                              
                        <input type="tel" maxlength="15" class="form-control"  name="tel_benefic" placeholder="" id="tel_benefic" required>
                        <div id="mes_ben" style="color:red; font-size:10px;" class="clearfix"></div>
                        </div>
                     </div>

                  <div class="col-md-3">
                  <label class="form-label">Devise</label>
                           <div class="form-group">
                           <select class="custom-select flex-grow-1" id='name_devise' name="name_devise" required>
                              <option  class="form-label" value='-1'>Choisir la devise</option>
                              @foreach($tab_devise as $ligne_devise)
                              <option value='{!! $ligne_devise->id !!}'>{!! $ligne_devise->intitule !!}</option>
                              @endforeach
                           </select>
                           @foreach($tab_devise as $ligne_devise)
                           <input type="hidden"  class="form-control"  name="{{'taux'.$ligne_devise->id}}"  id="{{'taux'.$ligne_devise->id}}" value="{{$ligne_devise->taux}}">
                           <input type="hidden"  class="form-control"  name="{{'devise'.$ligne_devise->id}}"  id="{{'devise'.$ligne_devise->id}}" value="{{$ligne_devise->intitule}}">
                           @endforeach
                     
                     </div>
                  </div>
                   <div class="col-md-3">
                      <div class="form-group">
                          <label class="form-label">Montant d'envoi</label>
                              <input type="number" autocomplete="off" class="currency"  name="name_montexp" placeholder=""   id="name_montexp" required="Veuillez saisir cette zone">
                              <div class="clearfix" id='msgmont'></div>
                        </div>
                   </div>

                     <div class="col-md-3">
                        <label class="form-label">Pourcentage</label>
                      <div class="form-group">
                          
                              <input type="text"  class="currency"  name="telexpedit" placeholder="" id="name_montcom" readonly required>
                              <div class="clearfix" id='msgpour'></div>
                        </div>
                   </div>
            </div>

            <div class='row'>
                <div class="col-md-4">
                     <label class="form-label">Raison de Transfert</label>
                     <textarea id="raison" rows="3" class="form-control" placeholder="Ecrivez votre raison"></textarea>
                  </div>
                   
                </div>

           
            <br>
            <button type="button" class="btn btn-success" name="btnsave_users" id="btnsave_envois">Envoyez</button>
            <button type="reset" class="btn btn-danger" id="btnreset_affectation">annule</button>
            <input type="hidden" class="form-control"  id="name_occupation">
         </form>
      </div>
   </div>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-12">
      <h6 class="card-header">Liste de depots</h6>
      <div class="card-body">
      <div style="overflow-x:auto;">
      <table class="table" id="tab_entree">
            <thead class="thead-dark">
               <tr>
                  <th>DATE.</th> 
                  <th>CODE.</th>
                  <th>PROV.</th>
                  <th>DESTINA.</th>
                  <th>MONTANT ENV.</th>
                  <th>%</th>
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
         $("#tel_expedit").val("+243");
         $('#tel_benefic').val("+243");

         $("#tel_expedit").focusout(function(){
               let telephone=$('#tel_expedit').val();
               if(telephone.length < 13){
               $("#mes_ex").html(" le numero telephone doit avoir au moins 12 chiffres");
               }
               else{
               return  $("#mes_ex").html("");
               } 
            });

            $("#tel_benefic").focusout(function(){
               let teleben=$('#tel_benefic').val();
               if(teleben.length < 13){
               $("#mes_ben").html(" le numero telephone doit avoir au moins 12 chiffres");
               }
               else{
               return $("#mes_ben").html("");
               } 
            });

            $("#name_expedit").focusout(function(){
                  if(regexverification($("#name_expedit").val())){
                     return $("#mes_naex").html("");
                  }
                  else{
                     
                     $("#mes_naex").html("ecrivez toutes l'identité tout en le separant par espace");
                  }
               });
               $("#name_expedit").focusin(function(){
                  return $("#mes_naex").html("");
               });

                  $("#name_benefic").focusout(function(){
                     if(regexverification($("#name_benefic").val())){
                        return $("#id_ben").html("");
                     }
                     else{
                        
                        $("#id_ben").html("ecrivez toutes l'identité tout en le separant par espace");
                     }
                  });
                  $("#name_expedit").focusin(function(){
                     return $("#mes_naex").html("");
                  });

                  $("#name_benefic").focusin(function(){
                     return $("#mes_naex").html("");
                  });

                  $('#name_devise').change(function() {
                     $('#name_montcom').val(calcul_com());
                     });

                     $('#name_ville').change(function() {
                        if ($('#name_ville').val() != '-1') {
                           code_transfert();
                        } else {
                           return '';
                        }
                        });

                     $('#name_agence').change(function() {
                     if ($('#name_agence').val() != '-1') {
                        $("#msgmont").html("");
                        affiche_entree($('#name_agence').val());
                        code_transfert();
                     } else {
                        return '';
                     }
                     });
                     $("#name_agence").select2();
                     $("#name_ville").select2();


                     $('#name_montexp').on('input', function() {
                     if (!isNaN($('#name_montexp').val()) && $('#name_devise').val()!='-1') {
                        $('#name_montcom').val(calcul_com());
                        
                     } else {
                        $("#msgmont").html("veuillez choisir la devise").css("color", "red");
                        $('#name_montexp').val('');
                     }
                     });

                     $('#tel_benefic').on('input', function() {
                        var teleben=$('#tel_benefic').val();
                     if (!isNaN($('#tel_benefic').val())) {
                              if(teleben.length < 4 || teleben.substring(0,4) !='+243') {
                                    $('#tel_benefic').val('+243');
                                 }
                                 else if(teleben.length > 13 ){
                                    $("#mes_ben").html("Vous avez depassé le nombre");
                                 }
                                 else {
                                    return $("#mes_ben").html("");
                                 }
                     } else {
                        $('#tel_benefic').val('+243');
                     }
                     });

                     $('#tel_expedit').on('input', function() {
                        var telephone=$('#tel_expedit').val();
                     if (!isNaN($('#tel_expedit').val())) {
                                 if(telephone.length < 4 || telephone.substring(0,4) !='+243') {
                                    $('#tel_expedit').val('+243');
                                 }
                                 else if(telephone.length > 13 ){
                                    $("#mes_ex").html("Vous avez depassé le nombre");
                                 }
                                 else {
                                    $("#mes_ex").html("");
                                 }

                     } else {
                           $('#tel_expedit').val('+243');
                        } 
                     
                     });

                     $('body').delegate('.print','click',function(e){
                        var ids=$(this).data('id');
                        window.location.href = ("/admin/print/" + ids);      
                     });

      $('#btnsave_envois').click(function() {
                  if ($("#name_expedit").val() != '' && $("#tel_expedit").val() != '' && $("#name_benefic").val() != '' && $("#tel_benefic").val() != '' && $("#name_montexp").val() != '' && $("#name_montcom").val() != '') {

                    if ($('#name_devise').val() != '-1' && $('#name_ville').val() != '-1' && $('#name_agence').val() != '-1' && $('#raison').val()!= '') {
                     let id_vil = $("#name_ville").val();
                     let dev = $('#name_devise').val();
                     let message = "vous voulez envoyer de l'argent à "; 
                      message += $('#ville' + id_vil).val() + ' provenant de ';
                      message += $("#name_expedit").val() + ', destiné à ' + $("#name_benefic").val();
                      message += ' au code de transfert de ' + $("#name_transact").val() + ' pour un montant de ' + $("#name_montexp").val() + ' ' + $('#devise' + dev).val();
                      Swal.fire({  
                                 title: 'Colombe Money',
                                 html: message, 
                                 width: 600,
                                 padding: '3em',  
                                 showDenyButton: true,   
                                 confirmButtonText: `Enregistrer`,  
                                 denyButtonText: `Annuler`,
                                 }).then((result) => {   
                                       if (result.isConfirmed) { 
                                          
                                          $.ajax({
                                             url: "{{route('route_entree')}}",
                                             type: 'POST',
                                             async: false,
                                             data: {
                                             agence: $("#name_agence").val(),
                                             ville: $("#name_ville").val(),
                                             devise: $("#name_devise").val(),
                                             expediteur: $("#name_expedit").val(),
                                             expeditel: $("#tel_expedit").val(),
                                             benefic: $("#name_benefic").val(),
                                             tel_ben: $("#tel_benefic").val(),
                                             montenv: $("#name_montexp").val(),
                                             montcom: $("#name_montcom").val(),
                                             transact: $("#name_transact").val(),
                                             raison: $("#raison").val(),
                                             },
                                             success:function(data)
                                             {
                                                   if(data.success=='1'){
                                                      affiche_entree($('#name_agence').val());
                                                      let id_ag = $('#name_agence').val();
                                                      let tab = ['1', $('#agence' + id_ag).val(), $('#ville' + id_vil).val(),
                                                         $("#name_transact").val(), $("#name_expedit").val(), $("#tel_expedit").val(),
                                                   $("#name_benefic").val(), $("#tel_benefic").val(), $("#name_montexp").val(), $("#name_montcom").val(), $('#devise' + dev).val(),$("#raison").val()
                                                      ];
                                                      window.location.href = ("/pdf/generate/" + tab);
                                                      Swal.fire('operation effectuée', '', 'success') 
                                                      $("#name_transact").val("");
                                                      $("#name_ville").val('-1');
                                                      $("#name_devise").val('-1');
                                                      $("#name_expedit").val('');
                                                      $("#name_montcom").val('');
                                                      $("#name_benefic").val('');
                                                      $("#name_montexp").val('');
                                                      $("#tel_expedit").val('+243');
                                                      $("#tel_benefic").val('+243');
                                                      $("#raison").val("");
                                                      $("#msgmont").html("");
                                                      $("#msgpour").html("");
                                                   }
                                                   else{
                                                      alert('existe deja');
                                                   } 
                                             },
                                             error:function(data){
                              
                                                   Swal.fire('error', '', 'succerroress')                              
                                             }
                                          });
                                       
                                          
                                       } else if (result.isDenied) {    
                                          Swal.fire('Changes are not saved', '', 'info')  
                                       }
                                 });      
                    
                }
              }
});


        })();


        function affiche_entree(code_agence)
         {
           var otableau=$('#tab_entree').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"/admin/liste_agence="+code_agence,
                 "columns":[
                     {"data":'created_at'},
                     {"data":'numdepot'},
                     {"data":'nomagence'},
                     {"data":'ville'},
                     {"data":'montenvoi'},
                     {"data":'montpour'},
                     {"data":'intitule'},
                     
                     {"data":'id',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-warning btn-circle print" >Print</button>';
                          }}
                    
                 ],
                 "pageLength": 10, 
                 "bDestroy":true,
                 responsive:true,
             });
         
         }
function calcul_com() {
  if ($('#name_devise').val() != '-1' && $('#name_montexp').val() != '') {
    var id_devise = $('#name_devise').val();
    var taux = $('#taux' + id_devise).val();
    var montant = $('#name_montexp').val() * taux / 100;
    var montantt = parseFloat(montant).toFixed(2);
    let montfloat = parseFloat($('#name_montexp').val()).toFixed(2);
    let aff=formateIndianCurrency(montfloat);
    let new_value1 = formateIndianCurrency(montantt);
    let new_pour = new_value1.substring(0,new_value1.length - 1);
    let devise=$('#name_devise').val();
    let value_devise = $('#devise' + devise ).val();
    let new_value=aff.substring(0,aff.length - 1);
    new_value += value_devise
    new_pour += value_devise;
    $("#msgmont").html(new_value);
    $("#msgpour").html(new_pour);
    return montantt;
  } else {
   $("#msgmont").html('');
   $("#msgpour").html('');
    return '';
  }
}

function code_transfert(){

   if($('#name_agence').val()!='-1' && $("#name_ville").val()!='-1'){
      var code_vil=$("#name_ville").val();
      var code_ag=$("#name_agence").val();
      var init_ag = $('#ag_init' + code_ag).val();
      var init_vil = $('#vil_init' + code_vil).val();
      $.ajax({
      url: "{{route('route_generate')}}",
      type: 'POST',
      async: false,
      data:{ 
         initial_ag:init_ag,
         initial_vil:init_vil

      },
      success:function(data){
         $("#name_transact").val(data.success);
      },
      error: function(data) {
         alert(data.success);
      }
   });
   }
  
}


    



</script>

@endsection