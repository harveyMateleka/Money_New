@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">MOUVEMENT BANQUE</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-8">
                            <h4 class="card-header">Mouvement</h4>
                            <div class="card-body">
                                <form action="#" method="POST" id="form_personnel">
                                {{csrf_field()}}
                                <div id="message" style='color:red; font-size:15px;'>
                                </div>
                                    <div class="form-row">
                                    <div class="form-group col-md-12">
                                                <div class="form-check form-check-inline">
            
                                                    <input class="form-check-input" type="radio" name="etat" checked id="etat_ag" value="1">
                                                    <label class="form-check-label"  for="inlineRadio1"  checked >Agence/Agence</label>
                                                </div>
                                        <div class="form-check form-check-inline">
                                            <input style="border: 1px solid silver !important; padding-left: 8px !important"  class="form-check-input" type="radio" name="etat" id="etat_bank" value="2">
                                            <label class="form-check-label" for="inlineRadio2">Agence/Banque</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input  style="border: 1px solid silver !important; padding-left: 8px !important"  class="form-check-input" type="radio" name="etat" id="etat_BA" value="3">
                                            <label class="form-check-label" for="inlineRadio3">Bank/Agence</label>
                                        </div>
                                    </div>
                                           
                                        <div class="form-group col-md-6" id='prov_ag'>
                                            <select  style="border: 1px solid silver !important; padding-left: 8px !important"  class="custom-select flex-grow-1" id='name_prov'>
                                                <option value='-1'>Agence de Provenance</option>
                                                @foreach($resul_ag as $ligne_banque)
                                                <option value='{!! $ligne_banque->numagence !!}'>{!! $ligne_banque->nomagence !!}</option>
                                                @endforeach
                                            </select>
                                            @foreach($resul_ag as $ligne_banque)
                                            <input type="hidden"  class="form-control"  name="{{'prov_ag'.$ligne_banque->numagence}}"  id="{{'prov_ag'.$ligne_banque->numagence}}" value="{{$ligne_banque->nomagence}}">
                                            @endforeach
                                        </div>
                                        <div class="form-group col-md-6" id='desti_ag'>
                                            <select style="border: 1px solid silver !important; padding-left: 8px !important"  class="custom-select flex-grow-1" id='name_desti'>
                                                <option value='-1'>Agence</option>
                                                @foreach($resul_ag as $ligne_banque)
                                                <option value='{!! $ligne_banque->numagence !!}'>{!! $ligne_banque->nomagence !!}</option>
                                                @endforeach
                                            </select>
                                            @foreach($resul_ag as $ligne_banque)
                                            <input type="hidden"  class="form-control"  name="{{'desti_ag'.$ligne_banque->numagence}}"  id="{{'desti_ag'.$ligne_banque->numagence}}" value="{{$ligne_banque->nomagence}}">
                                            @endforeach
                                        </div>
                                        <div class="form-group col-md-6" id='prov_bank'> 
                                            <select  style="border: 1px solid silver !important; padding-left: 8px !important"  class="custom-select flex-grow-1" id='name_bank'>
                                                <option value='-1'>Selectionnez une banque</option>
                                                @foreach($resul_bank as $ligne_banque)
                                                <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                                                @endforeach
                                            </select>
                                            @foreach($resul_bank as $ligne_banque)
                                            <input type="hidden"  class="form-control"  name="{{'bank'.$ligne_banque->id}}"  id="{{'bank'.$ligne_banque->id}}" value="{{$ligne_banque->intitulecompte}}">
                                            @endforeach
                                        </div>
                                        
                                      
                                      <div class="form-group col-md-6">
                                                <select  style="border: 1px solid silver !important; padding-left: 8px !important"  class="form-control js-states" name="devise" data-validation="" id="devise" data-validation="required">
                                                <option value='-1'>Selectionnez une devise</option>
                                                <option value="2">CDF</option>
                                                <option value="1">USD</option>                                        
                                                </select>
                                        </div>

                                         <div class="form-group col-md-6">
                                          
                                            <input  style="border: 1px solid silver !important; padding-left: 8px !important"  type="text" class="form-control" name="Montant" placeholder="ENTREE MONTANT" id="Montant" data-validation="required">
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Motif </label>
                                            <textarea  style="border: 1px solid silver !important; padding-left: 8px !important"  class="form-control rounded-0" id="motif" name="motif" rows="1"></textarea>
                                             <div class="clearfix"></div>
                                        </div>                                    
                                  
                                    </div>
  
                                    <button type="button" class="btn btn-success" name="btnsave_banque" id="btnsave_transfert">ENREGISTRE</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la personnel" id="code_banque">
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

@section ('script')
document.getElementById("prov_bank").style.display = "none"; 
   
$('#etat_bank').change(function(){
    if(document.getElementById("etat_bank").checked){
        document.getElementById("desti_ag").style.display = "none"; 
        document.getElementById("prov_bank").style.display = "block";
        document.getElementById("prov_ag").style.display = "block";       
    }

});

$('#etat_ag').change(function(){
    if(document.getElementById("etat_ag").checked){
    document.getElementById("prov_bank").style.display = "none"; 
    document.getElementById("desti_ag").style.display = "block";     
    }

});

$('#etat_BA').change(function(){
    if(document.getElementById("etat_BA").checked){
    document.getElementById("prov_bank").style.display = "block"; 
    document.getElementById("desti_ag").style.display = "block";
    document.getElementById("prov_ag").style.display = "none";      
    }

});

$('#btnsave_transfert').click(function() {   
var provenance=0;
var destinance=0;
var indice=0;
var detail_prov='';
var detail_desti='';
if($("#devise").val()!='-1' && $("#Montant").val()!='' && $("#motif").val()!=''){
    if(document.getElementById("etat_ag").checked){
                    if($("#name_prov").val()!='-1' && $("#name_desti").val()!='-1'){
                        if($("#name_prov").val()!=$("#name_desti").val()){
                            provenance=$("#name_prov").val();
                            destinance=$("#name_desti").val();
                            detail_prov=$('#prov_ag'+provenance).val();
                            detail_desti=$('#desti_ag'+destinance).val();
                            indice=1;
                         }
                         else{
                            $("#message").html("erreur dans le choix de compte d'agence");
                               return false;
                           }
                       
                    }
              
    }
    else if(document.getElementById("etat_bank").checked){
             if($("#name_prov").val()!='-1' && $("#name_bank").val()!='-1'){
                        provenance=$("#name_prov").val();
                        destinance=$("#name_bank").val();
                        detail_prov=$('#prov_ag'+provenance).val();
                        detail_desti=$('#bank'+destinance).val();
                        indice=2;
                }
               
    }
    else{
                   if($("#name_bank").val()!='-1' && $("#name_desti").val()!='-1'){                  
                        provenance=$("#name_bank").val();
                        destinance=$("#name_desti").val();
                        detail_prov=$('#bank'+provenance).val();
                        detail_desti=$('#desti_ag'+destinance).val();
                        indice=3;
                    }
                     
       }
            if(provenance!=0 && destinance!=0 && indice!=0 && detail_desti !='' && detail_prov!=''){
        swal({
        title: 'La Colombe Money',
        text: "voulez vous faire un mouvement banque?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'oui,Transfere!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
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
                      swal({title: 'La Colombe Money!',
                      text: 'mouvement banque succeffuly!',
                      type: 'success'
                       })
                        window.location.href=("{{route('index_mvtbank')}}");
                      }
                      else{
                         swal({title: 'La Colombe Money!',
                      text: 'Montant insuffisant pour faire ce mouvement!',
                      type: 'danger'
                       });  
                      }  
                     },
                     error:function(data){

                       alert(data.success);                              
                       }
                 });
                   })
    }

      }).then(function () {
        swal({
            type: 'info',
            title: 'La Colombe Money',
            html: 'mouvement banque annuler'
        })
    });

             } 
             else{
                 alert('non');
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
       

@endsection

