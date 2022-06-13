@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">PAGE ONG</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-12">
                            <h4 class="card-header">ENREGISTREMENT ONG</h4>
                            <div class="card-body">
                                <form action="#" method="POST">
                                {{csrf_field()}}
                                    <div class="form-row">
                                        <div class='col-md-3'>
                                            <label class="form-label">NOM ONG</label>
                                            <div class="form-group">
                                                <input type="text" class="currency" data-validation="required" name="nomong" style="text-transform:uppercase;" placeholder="" id="name_ong" required>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <label class="form-label">ADRESSE SIEGE</label>
                                                <div class="form-group col-md-3">
                                                    <input type="text"class="currency" style="text-transform:uppercase;" data-validation="required" name="adresse" placeholder="" id="adresse_siege" required>
                                                    <div class="clearfix"></div>
                                                </div>
                                        </div>
                                        <div class='col-md-3'>
                                        <label class="form-label">ADRESSE EMAIL</label>
                                        <div class="form-group">
                                            <input type="text" class="currency"  data-validation="required" name="adresse" placeholder="" id="adresse_email" required>
                                            <div class="clearfix" id='mes_email'></div>
                                        </div>
                                        </div>
                                        <div class='col-md-3'>
                                        <label class="form-label">CONTACT 1</label>
                                            <div class="form-group">
                                                <input type="text" class="currency" style="text-transform:uppercase;" data-validation="required" name="adresse" placeholder="" id="telcontact" required>
                                                <div class="clearfix" id='mes_ex'></div>
                                            </div>
                                        </div>
                                       
                                       
                                        
                                    </div>

                                    <div class="form-row">
                                    <div class='col-md-3'>
                                    <label class="form-label">CONTACT 2</label>
                                    <div class="form-group">
                                            <input type="text" class="currency" data-validation="required" name="telservice" placeholder="" id="tel_contact" required>
                                            <div class="clearfix" id='mes_ex1'></div>
                                        </div>
                                        </div>
                                        <div class='col-md-3'>
                                        <label class="form-label">NOM  DU RESPONSABLE</label>
                                        <div class="form-group">
                                            <input type="text"  style="text-transform:uppercase;" class="currency" data-validation="required" name="nompersonnel" placeholder="" id="name_Perso" required>
                                            <div class="clearfix"></div>
                                        </div>
                                        </div>
                                        <div class='col-md-3'>
                                        <label class="form-label">POSTNOM</label>
                                    <div class="form-group">
                                            <input type="text"  style="text-transform:uppercase;" class="currency" data-validation="required" name="past_Perso" placeholder="" id="past_Perso" required>
                                            <div class="clearfix"></div>
                                        </div>
                                        </div>
                                        <div class='col-md-3'>
                                        <label class="form-label">PRENOM </label>
                                        <div class="form-group">
                                            
                                            <input type="text"  style="text-transform:uppercase;" class="currency" data-validation="required" name="pre_Perso" placeholder="" id="pre_Perso" required>
                                            <div class="clearfix"></div>
                                        </div>
                                        </div>
                                        
                                       
                                     
                                    </div>
                                    <button type="button" class="btn btn-success" name="btnsave_ong" id="btnsave_ong">Sauvegarder</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de l'ong" id="ong">
                                </form>

                                
                                
                            </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                            <h6 class="card-header">LITE DES ONG</h6>
                            <div class="card-body">
                            <div style="overflow-x:auto;">
                            <table class="table card-table" id="tab_ong1">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>NOM ONG</th>
                                        <th>ADRESSE SIEGE</th>
                                        <th>ADRESSE EMAIL</th>
                                        <th>TEL CONTACT</th>
                                        <th>TEL CONTACT2</th>
                                        <th>NOM</th>
                                        <th>POSTNOM</th>
                                        <th>PRENOM </th>
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

     $("#tel_contact").val("+243");
     $('#telcontact').val("+243");

     $("#tel_contact").on('input', function(){
        var telephone = $('#tel_contact').val();
         if (!isNaN($('#tel_contact').val())) {
            if (telephone.length < 4 || telephone.substring(0, 4) != '+243') {
               $('#tel_contact').val('+243');
            } else if (telephone.length > 13) {
               let newnumber = telephone.substring(0,telephone.length -1);
               $('#tel_contact').val(newnumber);
               //$("#mes_ex").html("Vous avez depassé le nombre");
            } else {
               $("#mes_ex").html("");
            }

         } else {
            $('#tel_contact').val('+243');
         }
     });

     
     $("#telcontact").on('input', function(){
        var telephone = $('#telcontact').val();
         if (!isNaN($('#telcontact').val())) {
            if (telephone.length < 4 || telephone.substring(0, 4) != '+243') {
               $('#telcontact').val('+243');
            } else if (telephone.length > 13) {
               let newnumber = telephone.substring(0,telephone.length -1);
               $('#telcontact').val(newnumber);
               //$("#mes_ex").html("Vous avez depassé le nombre");
            } else {
               $("#mes_ex1").html("");
            }

         } else {
            $('#telcontact').val('+243');
         }
     });

     const validateEmail = (email) => {
  return email.match(
    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  );
};

     $('#btnsave_ong').click(function() {
        if($("#name_ong").val()!='' && $("#name_Perso").val()!='' && $("#tel_contact").val()!='' && $("#adresse_email").val()!='' && $("#adresse_siege").val()!='' && $("#past_Perso").val()!=''){
                if ($("#pre_Perso").val()!='' && $("#telcontact").val()!='') {
                    if (validateEmail($("#adresse_email").val())) {
                        if ($("#ong").val()=='') {
                            Swal.fire({
                            title: 'Colombe Money',
                            html:"Vous voulez enregistrer", 
                            width: 600,
                            padding: '3em',  
                            showDenyButton: true,   
                            confirmButtonText: `Enregistrer`,  
                            denyButtonText: `Annuler`,
                        }).then((result) => { 
                            if (result.isConfirmed) { 
                                $.ajax({
                                    url   : "{{route('create_ong')}}",
                                    type  : 'POST',
                                    async : false,
                                    data  : { ong:$("#name_ong").val(),
                                                Perso:$("#name_Perso").val(),
                                                past_name:$("#past_Perso").val(),
                                                pre_name:$("#pre_Perso").val(),
                                                email:$("#adresse_email").val(),
                                                siege:$("#adresse_siege").val(),
                                                tel:$("#tel_contact").val(),
                                                tele:$("#telcontact").val()
                                    },
                                    success:function(data)
                                    {
                                        if(data.success=='1'){
                                            Swal.fire('operation effectuée', '', 'success')
                                            affiche_ong1();
                                            clear();
                                            
                                        }
                                        else{
                                            Swal.fire('operation echouée', '', 'error')
                                        } 
                                    },
                                    error:function(data){

                                        Swal.fire('operation echouée', '', 'error');                            
                                        }
                                });
                                    
                            } else if (result.isDenied) {    
                                                        Swal.fire('Changes are not saved', '', 'info')  
                                                    }
                            });

                           }
                            else{
                                Swal.fire({
                                title: 'Colombe Money',
                                html:"Vous voulez Modifier", 
                                width: 600,
                                padding: '3em',  
                                showDenyButton: true,   
                                confirmButtonText: `Modifier`,  
                                denyButtonText: `Annuler`,
                            }).then((result) => {
                                if (result.isConfirmed) { 

                                    $.ajax({
                                        
                                        url   : "{{route('update_ong')}}",
                                        type  : 'POST',
                                        async : false,
                                        data  : {name_ong: $("#name_ong").val(),
                                                name_Perso: $("#name_Perso").val(),
                                                adresse_siege: $("#adresse_siege").val(),
                                                tel_contact: $("#tel_contact").val(),
                                                id: $("#ong").val(),
                                                past_name:$("#past_Perso").val(),
                                                pre_name:$("#pre_Perso").val(),
                                                email:$("#adresse_email").val(),
                                                tele:$("#telcontact").val()
                                                
                                        },
                                        success:function(data)
                                        {
                                            if(data.success=='1'){
                                                Swal.fire('operation effectuée', '', 'success')
                                                affiche_ong1();
                                                clear();
                                            }
                                            else{
                                                Swal.fire('operation echoué', '', 'error')
                                            }
                                        
                                        },
                                        error:function(data){
                                        Swal.fire('operation echouée', '', 'error');                            
                                        }
                                    });
                                    } else if (result.isDenied) {    
                                                            Swal.fire('Changes are not saved', '', 'info')  
                                                        }
                                    });
                            }

                            
                        } else {
                            $("#mes_email").html("verifier bien si les coordonnées sont email").css("color","red");
                        }
                    
                }
        }
       
     });
function clear(){
    $("#name_ong").val('');
    $("#name_Perso").val('');
    $("#adresse_siege").val('');
    $("#tel_contact").val('');
    $("#telcontact").val('');
    $("#adresse_email").val('');
    $("#pre_Perso").val('');
    $("#past_Perso").val('');
}
    
    affiche_ong1();

    $('body').delegate('.modifier_ong1','click',function(){
                  var ids=$(this).data('id');
                  $.ajax({
                      url   : "{{route('get_ong')}}",
                      type  : 'POST',
                      async : false,
                      data  : {code: ids
                      },
                      success:function(data)
                      {
                        $("#ong").val(data.id);
                        $("#name_ong").val(data.name_ong);
                        $("#name_Perso").val(data.name_Perso);
                        $("#adresse_siege").val(data.adresse_siege);
                        $("#tel_contact").val(data.tel_contact);
                        $("#telcontact").val(data.tel_contact2);
                        $("#adresse_email").val(data.email);
                        $("#pre_Perso").val(data.prename);
                        $("#past_Perso").val(data.postnom);
    
                        
                      }
                  });
         });
    

//  $('body').delegate('.supprimer_ong1','click',function(){
//         var ids=$(this).data('id');

//             $.ajax({
//             url   : "{{route('delete_ong')}}",
//             type  : 'POST',
//             async : false,
//             data  : {code: ids
//             },
//             success:function(data)
//             {
//               if(data.success=='1'){
//                 affiche_ong1();
//               }
//               else{
//                   alert('erreur dans la suppression');
//               }
//             }
//         });
//     });
})();
function affiche_ong1()
         {
         var otableau=$('#tab_ong1').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"{{route('get_list_ongc')}}",
             "columns":[
                 {"data":'id'},
                 {"data":'name_ong'},
                 {"data":'adresse_siege'},
                 {"data":'email'},
                 {"data":'tel_contact'},
                 {"data":'tel_contact2'},
                 {"data":'name_Perso'},
                 {"data":'postnom'},
                 {"data":'prename'},
                 {"data":'id',"autoWidth":true,"render":function (data) 
                 {return '<button data-id='+data+' class="btn btn-info btn-circle modifier_ong1"><i class="fa fa-check"></i></button>';
                     }}
             ],
             order:[[0,"DESC"]],
             "pageLength": 10,
             "bDestroy":true
         });
         }
</script>  
@endsection
