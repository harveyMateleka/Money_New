@extends('layouts.header')
@section('content')
<div class="modal fade bd-example-modal-lg" id="modal_banque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <h4 class="card-header">Transfert Banque</h4>
              <div class="card-body">
              <form action="#" method="POST" id="form_personnel">
                                {{csrf_field()}}
                                <div id="message" style='color:red; font-size:15px;'>
                                    </div>
                                    <div class="form-row">
                                   
                                        <div class="form-group col-md-6">
                                        <label class="form-label">COMPTE DE PROVENANCE </label>
                                            <select class="custom-select flex-grow-1" id='bank_prov'>
                                                <option value='-1'>choisir un compte</option>
                                                @foreach($resul_bank  as $ligne_banque)
                                                <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                        <label class="form-label">VERS QUEL COMPTE </label>
                                            <select class="custom-select flex-grow-1" id='bank_desti'>
                                                <option value='-1'>vers un autre compte</option>
                                                @foreach($resul_bank  as $ligne_banque)
                                                <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                      <div class="form-group col-md-6">
                                                <select class="form-control js-states" name="devise" data-validation="" id="tdevise" data-validation="required">
                                                <option value='-1'>SELECT DEVISE</option>
                                                <option value="2">CDF</option>
                                                <option value="1">USD</option>                                     
                                                </select>
                                        </div>

                                         <div class="form-group col-md-6">
                                            <label class="form-label">MONTANT </label>
                                            <input type="number" class="currency" name="Montant"  id="Montantt" data-validation="required">
                                            <div class="clearfix" id='montt'></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label">CONFIRMER EMAIL/PHONE</label>
                                            <input type="email" class="form-control" name="email" placeholder="saisir votre email" id="name_email" data-validation="required">
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label">CONFIRMER MOT DE PASSE</label>
                                            <input type="password" class="form-control" name="" placeholder="" id="pass" data-validation="required">
                                            <div class="clearfix"></div>
                                        </div>

                                    </div>
  
                                    <button type="button" class="btn btn-success" name="btnsave_banque" id="btnsave_banque">ENREGISTRE</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la personnel" id="code_banque">
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
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Page Mouvement</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-12">
                            <h4 class="card-header">Mouvement Banque</h4>
                            <div class="card-body">
                                <form action="#" method="POST" id="form_personnel">
                                {{csrf_field()}}
                                <div id="message" style='color:red; font-size:15px;'>
                                </div>

                                    <div class="row">

                                    <div class="col-md-3">
                                                <div class="form-check form-check-inline">
            
                                                    <input class="form-check-input" type="radio" name="etat" checked id="etat_ag" value="1">
                                                    <label class="form-check-label"  for="inlineRadio1"  checked >Agence/Agence</label>
                                                </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="etat" id="etat_bank" value="2">
                                            <label class="form-check-label" for="inlineRadio2">Agence/Banque</label>
                                        </div>
                                    </div>
                                        <div class="col-md-3">
                                           <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="etat" id="etat_BA" value="3">
                                            <label class="form-check-label" for="inlineRadio3">Bank/Agence</label>
                                        </div> 
                                        </div>
                                        <div class="col-md-3">
                                           <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="etat" id="banks" value="4">
                                            <label class="form-check-label" for="inlineRadio4">Banque/Banque</label>
                                        </div> 
                                        </div>     
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6" id='premiere'>
                                                   <div class="form-group" >
                                                    <select class="custom-select flex-grow-1" id='name_prov'>
                                                        <option value='-1'>Agence de Provenance</option>
                                                        @foreach($resul_ag as $ligne_ag)
                                                        <option value='{!! $ligne_ag->numagence !!}'>{!! $ligne_ag->nomagence !!}</option>
                                                        @endforeach
                                                    </select>
                                                        @foreach($resul_ag as $ligne_ag)
                                                        <input type="hidden"  class="form-control"  name="{{'prov_ag'.$ligne_ag->numagence}}"  id="{{'prov_ag'.$ligne_ag->numagence}}" value="{{$ligne_ag->nomagence}}">
                                                        @endforeach
                                                     </div>
                                       </div>

                                       <div class="col-md-6" id='premieres'>
                                                <div class="form-group">
                                                <select class="custom-select flex-grow-1" id='name_desti'>
                                                    <option value='-1'>Agence de Destination</option>
                                                    @foreach($resul_ag as $ligne_dest)
                                                    <option value='{!! $ligne_dest->numagence !!}'>{!! $ligne_dest->nomagence !!}</option>
                                                    @endforeach
                                                </select>
                                                @foreach($resul_ag as $ligne_dest)
                                                <input type="hidden"  class="form-control"  name="{{'desti_ag'.$ligne_dest->numagence}}"  id="{{'desti_ag'.$ligne_dest->numagence}}" value="{{$ligne_dest->nomagence}}">
                                                @endforeach
                                        </div>
                                       </div>

                                    </div>
                                      <div class="row">
                                                 <div class="col-md-6" id='deuxieme'>
                                                      <div class="form-group">
                                                            <select class="custom-select flex-grow-1" id='name_prov1'>
                                                                <option value='-1'>Agence de Provenance</option>
                                                                @foreach($resul_ag as $ligne_ag2)
                                                                <option value='{!! $ligne_ag2->numagence !!}'>{!! $ligne_ag2->nomagence !!}</option>
                                                                @endforeach
                                                            </select>
                                                        @foreach($resul_ag as $ligne_banque)
                                                        <input type="hidden"  class="form-control"  name="{{'prov_ag1'.$ligne_ag2->numagence}}"  id="{{'prov_ag1'.$ligne_ag2->numagence}}" value="{{$ligne_ag2->nomagence}}">
                                                        @endforeach
                                                     </div>  
                                                 </div>
                                              <div class="col-md-6" id='deuxiemes'>
                                                      <div class="form-group" id='prov_bank'>
                                                            <select class="custom-select flex-grow-1" id='name_bank'>
                                                            <option value='-1'>Banque de Destination</option>
                                                            @foreach($resul_bank as $ligne_banque)
                                                            <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                                                            @endforeach
                                                        </select>
                                                        @foreach($resul_bank as $ligne_banque)
                                                        <input type="hidden"  class="form-control"  name="{{'bank'.$ligne_banque->id}}"  id="{{'bank'.$ligne_banque->id}}" value="{{$ligne_banque->intitulecompte}}">
                                                        @endforeach
                                                     </div>  
                                                 </div>  
                                      </div>     
                                      <div class="row" >
                                               <div class="col-md-6" id='troisieme'>
                                                      <div class="form-group" id='prov_bank1'>
                                                            <select class="custom-select flex-grow-1" id='name_bank1'>
                                                            <option value='-1'>Banque de Provenance</option>
                                                            @foreach($resul_bank as $ligne_banque)
                                                            <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                                                            @endforeach
                                                        </select>
                                                        @foreach($resul_bank as $ligne_banque)
                                                        <input type="hidden"  class="form-control"  name="{{'bank1'.$ligne_banque->id}}"  id="{{'bank1'.$ligne_banque->id}}" value="{{$ligne_banque->intitulecompte}}">
                                            @endforeach
                                                     </div>  
                                                 </div>  
                                                 <div class="col-md-6" id='troisiemes'>
                                                      <div class="form-group" id='prov_ag'>
                                                            <select class="custom-select flex-grow-1" id='name_prov2'>
                                                                <option value='-1'>Agence de Destination</option>
                                                                @foreach($resul_ag as $ligne_banque)
                                                                <option value='{!! $ligne_banque->numagence !!}'>{!! $ligne_banque->nomagence !!}</option>
                                                                @endforeach
                                                            </select>
                                                        @foreach($resul_ag as $ligne_banque)
                                                        <input type="hidden"  class="form-control"  name="{{'prov_ag2'.$ligne_banque->numagence}}"  id="{{'prov_ag2'.$ligne_banque->numagence}}" value="{{$ligne_banque->nomagence}}">
                                                        @endforeach
                                                     </div>  
                                                 </div>
                                       
                                      </div> 
                                        
                                       <div class="row">

                                            <div class="col-md-6">
                                                 <label class="form-label">Devise </label>
                                                    <div class="form-group">
                                                        <select class="form-control js-states" name="devise" data-validation="" id="devise" data-validation="required">
                                                        <option value='-1'>Selectionnez la devise</option>
                                                        <option value="2">CDF</option>
                                                        <option value="1">USD</option>                                        
                                                    </select>
                                                 </div>
                                            </div> 

                                            <div class="col-md-6">
                                                   <label class="form-label">MONTANT </label>
                                             <div class="form-group">
                                            
                                            <input type="number" autocomplete="off" class="currency" name="Montant"  id="Montant" data-validation="required">
                                            <div class="clearfix" id='mvtmont'></div>
                                             </div>
                                            </div>

                                        </div> 

                                          <div class="row">
                                              <div class="form-group col-md-6">
                                                    <label class="form-label">Motif </label>
                                                    <textarea class="form-control rounded-0" id="motif" name="motif" rows="1"></textarea>
                                                     <div class="clearfix" ></div>
                                              </div>   

                                            <div class="col-md-6">
                                                    <button type="button" class="btn btn-success" name="btnsave_banque" id="btnsave_transfert">ENREGISTRE</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la personnel" id="code_banque">
                                             
                                            </div>

                                        </div> 
  
                                </form>
                            </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                            <h6 class="card-header">Tableau du droit d'access</h6>
                            <div class="card-body">
                                <div style="overflow-x:auto;">
                                      <table class="table card-table" id="tab_mouvement">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Id</th>
                                        <th>Provenance</th>
                                        <th>Destination</th>
                                        <th>Etat</th>
                                        <th>Montant</th>
                                        <th>devise</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                         
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

@section ('javascript')
<script type="text/javascript">
(function() {
    $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
                });
                affiche_mouvement();
$("#name_bank1,#name_bank,#name_prov2,#name_prov1,#name_desti,#name_prov,#devise").select2();

document.getElementById("deuxieme").style.display = "none"; 
document.getElementById("deuxiemes").style.display = "none";
document.getElementById("troisieme").style.display = "none"; 
document.getElementById("troisiemes").style.display = "none"; 

$('#etat_bank').change(function(){
    if(document.getElementById("etat_bank").checked){
        document.getElementById("premieres").style.display = "none"; 
        document.getElementById("premiere").style.display = "none"; 
        document.getElementById("deuxieme").style.display = "block";
        document.getElementById("deuxiemes").style.display = "block";
        document.getElementById("troisieme").style.display = "none"; 
        document.getElementById("troisiemes").style.display = "none";        
    }

});

$('#banks').change(function(){
    if(document.getElementById("banks").checked){
        $("#modal_banque").modal('show');
    }
});

$('#etat_ag').change(function(){
    if(document.getElementById("etat_ag").checked){
         document.getElementById("premieres").style.display = "block"; 
        document.getElementById("premiere").style.display = "block"; 
        document.getElementById("deuxieme").style.display = "none";
        document.getElementById("deuxiemes").style.display = "none";
        document.getElementById("troisieme").style.display = "none"; 
        document.getElementById("troisiemes").style.display = "none";
             
    }

});

$('#etat_BA').change(function(){
    if(document.getElementById("etat_BA").checked){

        document.getElementById("premieres").style.display = "none"; 
        document.getElementById("premiere").style.display = "none"; 
        document.getElementById("deuxieme").style.display = "none";
        document.getElementById("deuxiemes").style.display = "none";
        document.getElementById("troisieme").style.display = "block"; 
        document.getElementById("troisiemes").style.display = "block";    
    }

});

$('#Montant').on('input', function(){
    if($('#Montant').val()!=''){
            let formatmont=formateIndianCurrency($("#Montant").val());
            let new_amount=formatmont.substring(0,formatmont.length - 1);
            $("#mvtmont").html(new_amount);
    }

    else if($("#Montant").val() == 0) {
             $("#mvtmont").html(0);
         }
         else {
             $("#mvtmont").html("");
         }     
});

$("#Montantt").on('input',function(){
         if($("#Montantt").val()!=''){
            let formatmont=formateIndianCurrency($("#Montantt").val());
            let new_amount=formatmont.substring(0,formatmont.length - 1);
            $("#montt").html(new_amount);
         }
         else if($("#Montantt").val()==0) {
             $("#montt").html(0);
         }
         else {
             $("#montt").html("");
         }

      });

$('#btnsave_transfert').click(function() {   
var provenance=0;
var destinance=0;
var indice=0;
var detail_prov='';
var detail_desti='';
let message="";
let devise="";
if($("#devise").val()!='-1' && $("#Montant").val()!='' && $("#motif").val()!=''){
    if ($("#devise").val()=='1') {
        devise="USD";
    }
    else{
        devise="CDF";
    }
    if(document.getElementById("etat_ag").checked){
                    if($("#name_prov").val()!='-1' && $("#name_desti").val()!='-1'){
                        if($("#name_prov").val()!= $("#name_desti").val()){
                            provenance=$("#name_prov").val();
                            destinance=$("#name_desti").val();
                            detail_prov=$('#prov_ag'+ provenance).val();
                            detail_desti=$('#desti_ag'+ destinance).val();
                            indice=1;
                            message="vous voulez faire une sortie banque dans l'agence "+ detail_prov + " vers l'agence "+ detail_desti;
                            message += " au montant de " + $("#Montant").val() + " " + devise;
                         }
                         else{
                            $("#message").html("Vous ne pouvez pas faire le mouvement dans une meme agence");
                               return false;
                           }
                       
                    }
                     else{
                            $("#message").html("verifiez et remplissez les zones");
                               return false;
                           }
              
    }
    else if(document.getElementById("etat_bank").checked){
             if($("#name_prov1").val()!='-1' && $("#name_bank").val()!='-1'){
                        provenance=$("#name_prov1").val();
                        destinance=$("#name_bank").val();
                        detail_prov=$('#prov_ag1'+provenance).val();
                        detail_desti=$('#bank'+destinance).val();
                        indice=2;
                        message="vous voulez faire une sortie banque dans l'agence "+ detail_prov + " vers la banque "+ detail_desti;
                        message += " au montant de " + $("#Montant").val() + " " + devise;
                }
               
    }
    else{
                   if($("#name_bank1").val()!='-1' && $("#name_prov2").val()!='-1'){                  
                        provenance=$("#name_bank1").val();
                        destinance=$("#name_prov2").val();
                        detail_prov=$('#bank1'+provenance).val();
                        detail_desti=$('#prov_ag2'+destinance).val();
                        indice=3;
                        message="vous voulez faire une sortie banque dans la banque "+ detail_prov + " vers la banque "+ detail_desti;
                        message += " au montant de " + $("#Montant").val() + " " + devise ;
                    }
                     
       }
    if(provenance!=0 && destinance!=0 && indice!=0 && detail_desti !='' && detail_prov!=''){
      
        swal.fire({
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
                     url   : "{{route('create_mvt')}}",
                     type  : 'POST',
                     async : false,
                     data  : {prov:provenance,
                              desti:destinance,
                              devise:$("#devise").val(),
                              montant:$("#Montant").val(),
                              motif:$("#motif").val(),
                              indice:indice,
                              det_prov:detail_prov,
                              det_desti:detail_desti

                     },
                     success:function(data)
                     {
                      if(data.success=='1'){
                        Swal.fire('Opération reussie', '', 'success')  
                            affiche_mouvement();
                            $("#name_prov1").val("-1");
                            $("#name_bank").val("-1");
                            $("#name_prov").val('-1');
                            $("#name_desti").val('-1');
                            $("#name_bank1").val('-1');
                            $("#name_prov2").val('-1');
                            $("#devise").val("-1");
                            $("#Montant").val("");
                            $("#motif").val("");
                      }
                      else{
                        Swal.fire('le coffre est insuffisant pour faire cette transaction', '', 'info')  
                      }  
                     },
                     error:function(data){

                       alert(data.success);                              
                       }
                 });
                } else if (result.isDenied) {    
                                          Swal.fire('Changes are not saved', '', 'info')  
                                       }
                }); 
                 
    }
    else{
        Swal.fire('verifier bien les zones de saisies ', '', 'info')  
    }      
} 
});

$('body').delegate('.update','click',function(e){
            var ids=$(this).data('id');
            $.ajax({
                     url   : "{{route('update_mvt')}}",
                     type  : 'POST',
                     async : false,
                     data  : {id_mvt:ids      
                     },
                     success:function(data)
                     {
                      if(data.success=='1'){
                        window.location.href=("{{route('index_mvtbank')}}");
                      }
                    
                     },
                     error:function(data){

                       alert(data.success);                              
                       }
                 });
                 
         });


$('#btnsave_banque').click(function() {
if($("#bank_prov").val()!='-1' && $("#bank_desti").val()!='-1' && $("#tdevise").val()!='' && $("#Montantt").val()!='' && $("#pass").val()!='' && $("#name_email").val()!=''){
    if($("#bank_prov").val()== $("#bank_desti").val()){
        $("#message").html('vous ne devez pas transferer dans un meme compte');
    }
    else{
        swal.fire({
        title: 'Colombe Money',
        html:"souhaitez vous effectuer cette opération",
        width: 600,
        padding: '3em',  
        showDenyButton: true,   
        confirmButtonText: `Enregistrer`,  
        denyButtonText: `Annuler`,
    }).then((result) => { 
        if (result.isConfirmed) {
        $.ajax({
                     url   : "{{route('transfert')}}",
                     type  : 'POST',
                     async : false,
                     data  : {prov:$("#bank_prov").val(),
                              desti:$("#bank_desti").val(),
                              devise:$("#tdevise").val(),
                              montant:$("#Montantt").val(),
                              username:$("#name_email").val(),
                              password:$("#pass").val()
                     },
                     success:function(data)
                     {
                      if(data.success=='1'){
                        Swal.fire('operation reussie', '', 'success') 
                            $("#bank_prov").val('-1');
                             $("#bank_desti").val('-1');
                             $("#tdevise").val('-1');
                             $("#Montantt").val('');
                             $("#name_email").val('');
                             $("#pass").val('');
                             //window.location.href=("{{route('index_transfert')}}");
                     
                      }
                      else{
                        Swal.fire(data.success, '', 'error') 
                      }
                        
                       
                     },
                     error:function(data){

                       alert(data.success);                              
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

        function affiche_mouvement()
         {
           let values=0;
           var otableau=$('#tab_mouvement').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_mvt')}}",
                 "columns":[
                     {"data":'id'},
                     {"data":'detail_prov'},
                     {"data":'detail_des'},
                     {"data":'etatmvt',"autoWidth":true,"render":function (data){
                         values = data;
                         if (values==0) {   
                             return 'Suspense';
                         }
                         else{
                           return 'mouvement effectué';
                         }
                     }},
                     {"data":'Montmvt'},
                     {"data":'devise',"autoWidth":true,"render":function (data){
                         if (data==1) {   
                             return 'Usd';
                         }
                         else{
                             return 'Cdf';
                         }
                     }},
                     {"data":'created_at'},
                     {"data":'id',"autoWidth":true,"render":function (data) {
                         if (values == 0) {
                            return '<button data-id='+data+' class="btn btn-info btn-circle update" ><i class="fa fa-check">Confirmer</i></button>';
                          
                         }
                         else{
                            return '<button data-id='+data+' disabled  class="btn btn-info btn-circle update" ><i class="fa fa-check">Done</i></button>';
                        
                         }
                          }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
        </script>  

@endsection

