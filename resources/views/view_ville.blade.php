@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Ajout Ville</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            
                        </div>

                        <div class="card col-md-8">
                            <h4 class="card-header">Mise à Jour Ville</h4>
                            <div class="card-body">
                                <form action="#" method="POST" id="form_ville">
                                {{csrf_field()}}
                                @if(empty($message))
                                @else
                                <p style="font-size :10px; color:red"> {{$message}}</p>
                                 @endif
                                    <div class="form-row">
                        
                                        <div class="form-group col-md-6">
                                            <label class="form-label">NOM DE LA VILLE/SECTEUR</label>
                                            
                                            <input type="text" style="text-transform:uppercase;" class="form-control" name="name_ville" placeholder="Saisir le nom de la ville" id="name_ville">
                                            
                                           <div class="clearfix"></div>
                                        </div>
                                       
                                        <div class="form-group col-md-6">
                                            <label class="form-label">INITIAL</label>
                                            <input type="text" style="text-transform:uppercase;" class="form-control" name="initial" placeholder="Saisir l'initial de la ville" id="initial">
                                            <div class="clearfix"></div>
                                        </div>
                                       
                                    </div>
                                    <button type="button" class="btn btn-success" name="btnsave_ville" id="btnsave_ville">Enregistre</button>
                                    <button type="button" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_ville">
                                </form>
                            </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-8">
                            <h6 class="card-header">Liste de ville</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_ville">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>NOM DU VILLE</th>
                                        <th>INITIAL</th>
                                        <th>ACTION</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
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

    affiche_ville();
    $('#btnsave_ville').click(function() { 
        var name_ville=$("#name_ville").val();
        var initial=$("#initial").val();
        if(name_ville!=''){ 
            if ($("#code_ville").val()=='') {
                Swal.fire({  
                    title: 'Colombe Money',
                    html: 'Vous voulez enregistrer modifier', 
                    width: 600,
                    padding: '3em',  
                    showDenyButton: true,   
                    confirmButtonText: `save`,  
                    denyButtonText: `Annuler`,
                    }).then((result) => {   
                        if (result.isConfirmed) { 
                            
                            $.ajax({
                                url   : "{{route('route_create_ville')}}",
                                type  : 'POST',
                                async : false,
                                data  : {
                                            name_ville:name_ville,
                                            initial:initial
                                        },
                                
                                
                                success:function(data)
                                {
                                    if(data.success=='1'){
                                        Swal.fire('save', '', 'success') 
                                        affiche_ville();
                                        $("#name_ville").val("");
                                        $("#initial").val("");
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
            else{

                Swal.fire({  
                    title: 'Colombe Money',
                    html: 'Vous voulez vraiment modifier', 
                    width: 600,
                    padding: '3em', 
                    showDenyButton: true,   
                    confirmButtonText: `save`,  
                    denyButtonText: `Annuler`,
                    }).then((result) => {   
                        if (result.isConfirmed) { 
                            
                            $.ajax({
                                url   : "{{route('route_update_ville')}}",
                                type  : 'POST',
                                async : false,
                                data  : {
                                        ville: $("#name_ville").val(),
                                        initial: $("#initial").val(),
                                        code_ville:$("#code_ville").val(),
                                        },
                                
                                
                                success:function(data)
                                {
                                    if(data.success=='1'){
                                        Swal.fire('modification', '', 'success') 
                                        affiche_ville();
                                        $("#name_ville").val("");
                                        $("#initial").val("");
                                        $("#code_ville").val("");
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

    $('body').delegate('.modifier_ville','click',function(){
                       var ids=$(this).data('id');
                       $.ajax({
                           url   : "{{route('get_ville')}}",
                           type  : 'POST',
                           async : false,
                           data  : {code: ids
                           },
                           success:function(data)
                           {
                             $("#name_ville").val(data.ville);
                             $("#code_ville").val(data.id_ville);
                             $("#initial").val(data.initial);
                           }
                       });
              });


              $('body').delegate('.supprimer_ville','click',function(){
                  var ids=$(this).data('id');
                    Swal.fire({  
                    title: 'Voulez vous supprimer cette ville',  
                    showDenyButton: true,   
                    confirmButtonText: `Supprimer`,  
                    denyButtonText: `Annuler`,
                    }).then((result) => {   
                        if (result.isConfirmed) {   
                        $.ajax({
                           url   : "{{route('delete_ville')}}",
                           type  : 'POST',
                           async : false,
                           data  : {code: ids
                           },
                           success:function(data)
                           {
                            if(data.success=='1'){
                                Swal.fire('supprimer', '', 'success') 
                                affiche_ville();
                                }
                                else{
                                    Swal.fire('error', '', 'error') 
                                }
                           }
                       });
                             
                        } else if (result.isDenied) {    
                            Swal.fire('Changes are not saved', '', 'info')  
                        }
                    });      
    });
    
  })();
  function affiche_ville()
    {
      var otableau=$('#tab_ville').DataTable({
            "bProcessing":true,
            "sAjaxSource":"{{route('get_list_ville')}}",
            "columns":[
                {"data":'id_ville'},
                {"data":'ville'},
                {"data":'initial'},
                {"data":'id_ville',"autoWidth":true,"render":function (data) {
    
                        return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_ville" ><i class="fa fa-times"></i></button>'+ ' ' +
                            '<button data-id='+data+' class="btn btn-info btn-circle modifier_ville" ><i class="fa fa-check"></i></button>';
                    }}
            ],
            "pageLength": 10, 
            "bDestroy":true
        });
    
    }
</script>       
@endsection
