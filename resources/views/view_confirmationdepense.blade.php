
@extends('layouts.header')
@section('content')
<div class="modal fade" id="modal_depense" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modification Depense</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div id="message">
            </div>
            <form action="#" method="POST" id="form_confir_depense">
            {{csrf_field()}}
            <div class="form-row">
            <div class="form-group col-md-6">
                    <select class="custom-select flex-grow-1" id='numagence' name="numagence">
                    <option value="-1">Choisir l'agence</option>
                            @foreach($agence as $ligne_agence)
                            <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                    <select class="form-control js-states" name="devise" data-validation="" id="devise" data-validation="required">
                        <option value="-1">SELECT DEVISE</option>
                        <option value="2">CDF</option>
                        <option value="1">USD</option>
                        </select>
                    </div>
                   </div>
                   <div class="form-row">
                   <div class="form-group col-md-6">
                    <label class="form-label">MONTANT </label>
                    <input type="number" class="form-control" name="montant" placeholder="ENTREE MONTANT" id="montant" data-validation="required">
                    <div class="clearfix"></div>
                </div>
                   </div>
            </form>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btn_modifier">Modifier</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            <input type="hidden" class="form-control" placeholder="" id="code_agence">
            <input type="hidden" class="form-control" placeholder="" id="code_devise">
            <input type="hidden" class="form-control" placeholder="" id="code_montant">
            <input type="hidden" class="form-control" placeholder="" id="code_dep">
         </div>
      </div>
   </div>
</div>
<div class="container-fluid flex-grow-1 container-p-y">
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                            <h6 class="card-header">LISTE DES DEPENSES</h6>
                            <div class="card-body">
                            <form action="#" method="POST">
                                 {{csrf_field()}}
                                <div id="affichage" style='color:red; font-size:15px;'>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Date Debut</label>
                                        <input  style="border: 1px solid silver !important; padding-left: 8px !important" style="text-transform:uppercase;" type="date" class="form-control" name="name_datdep" id='name_datdep'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Date Fin</label>
                                        <input  style="border: 1px solid silver !important; padding-left: 8px !important" style="text-transform:uppercase;" type="date" class="form-control" name="name_datdepfin" id='name_datdepfin'>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" name="btndisplay" id='btnaff'>Afficher</button>
                                <button type="reset" class="btn btn-danger">annule</button>
                            </form>
                            <hr class="border-light container-m--x my-4">
                            <div style="overflow-x:auto;">
                            <table class="table card-table" id="tab_depenseconfi">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>DATE</th>
                                        <th>AGENCE</th>
                                        <th>DEVISE</th>
                                        <th>MONTANT</th>
                                        <th>TYPE DEP.</th>
                                        <th>AUTORISE</th>
                                        <th>ETAT</th>
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

@section ('script')

$('#btnaff').click(function(){
    if($('#name_datdepfin').val() >= $('#name_datdep').val()){
        affiche_confirm($('#name_datdep').val(),$('#name_datdepfin').val());
    }
    else {
       $('#affichage').html('La date debut ne peut pas etre superieure à la date de la fin'); 
    }
});

function affiche_confirm(date_debut,date_fin){
var tableau=[date_debut,date_fin];
var code_dep=0;
    var otableau=$('#tab_depenseconfi').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
            "bProcessing":true,
            "sAjaxSource":"/admin/liste_confir/"+tableau,
            "columns":[
                {"data":'id_dep',"autoWidth":true,"render":function (data){
                    code_dep=data;
                    return code_dep;
                }},
                {"data":'created_at'},
                 {"data":'nomagence'},
                 {"data":'devise',"autoWidth":true,"render":function (data){
                        if (data==2) {
                             return 'CDF';
                         }else{
                             return 'USD';
                         }
                           }},
                           {"data":'montant'},
                           {"data":'type_dep'},
                           {"data":'id_auto',"autoWidth":true,"render":function (data){
                        if (data==1) {
                             return 'PDG';
                         }
                         else if(data==2){
                             return 'DGA'; 
                         }else if(data==3){
                             return 'DG';
                         }else {
                             return'ENTREPRISE'
                         }
                      }},

                      {"data":'etat',"autoWidth":true,"render":function (data){
                      etatbutton = data;
                      if(etatbutton==1 ){
                            return '<button data-id='+code_dep+' class="btn btn-info btn-circle modifier_desa" ><i class="fa fa-check">Desapprouve</i></button>'; 
                         }else{
                             return '<button data-id='+code_dep+' class="btn btn-info btn-circle modifier_app" ><i class="fa fa-check"> Approuve</i></button>'; 
                         }
                           }},
                   
         
                 {"data":'id_dep',"autoWidth":true,"render":function (data) {
         
                         
                            return '<button data-id='+data+' class="btn btn-info btn-circle edit" ><i class="fa fa-check">edit</i></button>'; 
                        
         
                     }}
            ],
            "pageLength": 7, 
            "bDestroy":true
        });
}

$('body').delegate('.modifier_app','click',function(){
                  var ids=$(this).data('id');
                  var etat=1;
                  $.ajax({
                      url   : "{{route('get_depense')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids,
                               etat: etat
                      },
                      success:function(data)
                      {
                      location.reload();
                       //window.location.href=("{{route('index_confirdep')}}");
                      }
                  });
         });
         $('body').delegate('.modifier_desa','click',function(){

                  var ids=$(this).data('id');
                  var etat=0;
                  $.ajax({
                      url   : "{{route('get_depense')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids,
                               etat: etat
                      },
                      success:function(data)
                      {
                      location.reload();
                       //window.location.href=("{{route('index_confirdep')}}");
                      }
                  });
         });

        $('body').delegate('.edit','click',function(){
        var ids=$(this).data('id');
            $.ajax({
            url   : "{{route('get_depense1')}}",
            type  : 'POST',
            async : false,
            data  : {code: ids
            },
            success:function(data)
            {
                $("#numagence").val(data.numagence);
                document.getElementById('numagence').disabled = true;
                $("#devise").val(data.devise);
                $("#montant").val(data.montant);
                $("#code_agence").val(ids);
                $("#code_devise").val(data.devise);
                $("#code_montant").val(data.montant);
                ("#code_dep").val(ids);
                $("#modal_depense").modal('show');  
            }
        });
        $("#modal_depense").modal('show'); 
    });

    $("#btn_modifier").click(function(){
        
        if($("#numagence").val()!='-1' && $("#devise").val()!='-1' && $("#montant").val()!="" && $("#code_agence").val()!=""){
            $.ajax({
                url:"{{route('update_depense_mod')}}",
                type:'POST',
                async:false,
                data:{
                    agence:$("#numagence").val(),
                    montant:$("#montant").val(),
                    devise:$("#devise").val(),
                    code_agence:$("#code_agence").val(),
                    code_montant:$("#code_montant").val(),
                    code_devise:$("#code_devise").val(),
                    id_dep:$("#code_agence").val()

                },
                success:function(data){
                    if(data.success=='1'){
                    $("#numagence").val("-1");
                    $("#montant").val("");
                    $("#devise").val("-1");
                    $("#code_agence").val("");
                    $("#code_montant").val("");
                    $("#code_devise").val("");
                    $("#code_id").val(""); 
                    $("#modal_depense").modal('hide');
                    if($('#name_datdepfin').val() >= $('#name_datdep').val()){
                        affiche_confirm($('#name_datdep').val(),$('#name_datdepfin').val());
                        }
                        else {
                        $('#affichage').html('La date debut ne peut pas etre superieure à la date de la fin'); 
                        }
                    }
                },
                error:function(data){
                    alert(data.success);
                }

            });
        }
    });
@endsection

