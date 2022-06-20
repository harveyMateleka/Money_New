@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Ville</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            
                        </div>

                        <div class="card col-md-8">
                            <h4 class="card-header">Ajout Ville</h4>
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
@section('script')
  //____________________ajout ville
         $('#btnsave_ville').click(function() { 
             var name_ville=$("#name_ville").val();
             var initial=$("#initial").val();
             if(name_ville!=''){ 
                 if ($("#code_ville").val()=='') {
                    swal({
                    title: 'La Colombe money',
                    text: "voulez vous ajouter une ville?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui,Ajouter!',
                    cancelButtonText: 'No, ANNULE!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    showLoaderOnConfirm: true,
                    preConfirm: function () {
                    return new Promise(function (resolve, reject) {
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
               
                                 window.location.href=("{{route('route_index_ville')}}");
                             }
                             else{
                                 alert('existe deja');
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
            html: 'la ville n\'est pas ajoutée ! '
        })
    });

                 }
                 else{
                     swal({
        title: 'La Colombe Money',
        text: "Voulez vous modifier?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui,Modifier!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                     $.ajax({
                           url   : "{{route('route_update_ville')}}",
                           type  : 'POST',
                           async : false,
                           data  : {ville: $("#name_ville").val(),
                                    initial: $("#initial").val(),
                                    code_ville:$("#code_ville").val(),
                           },
                           success:function(data)
                           {
                             if(data.success=='1'){
                                 swal({title: 'La Colombe Money',
                text: 'modification ville avec success!',
                type: 'success'
                })
                                 window.location.href=("{{route('route_index_ville')}}");
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
            title: 'La Colombe Money',
            html: 'les information ne sont pas mofifiées'
        })
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
                        swal({
        title: 'La Colombe Money',
        text: "Voulez supprimer le donnes dans la base de donnees?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui,SUPRIMER!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                       $.ajax({
                           url   : "{{route('delete_ville')}}",
                           type  : 'POST',
                           async : false,
                           data  : {code: ids
                           },
                           success:function(data)
                           {
                             if(data.success=='1'){
                                  swal({title: 'La Colombe Money!',
                text: 'ville suprimer avec success!',
                type: 'success'
                })
                                 window.location.href=("{{route('route_index_ville')}}");
                             }
                             else{
                                 alert('erreur dans la suppression');
                             }
                           }
                       });
            })
   }
 }).then(function () {
        swal({
            type: 'info',
            title: 'La Colombe Money',
            html: 'La ville n\'est pas supprimée !'
        })
    });
@endsection
