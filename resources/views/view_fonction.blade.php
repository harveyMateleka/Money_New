@extends('layouts.header')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Page Fonction</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            
                        </div>

                        <div class="card col-md-8">
                            <h4 class="card-header">Ajout Fonction</h4>
                            <div class="card-body">
                                <form action="#" method="POST" id="form_ville">
                                {{csrf_field()}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Fonction occupée</label>
                                            <input type="text" class="form-control" name="name_fonction" placeholder="Saisir la fonction" id="name_fonction">
                                            <div class="clearfix"></div>
                                        </div>
                                       
                                    </div>
                                    <button type="button" class="btn btn-success" name="btnsave_fonction" id="btnsave_fonction">Enregistre</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_fonction">
                                </form>
                            </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-8">
                            <h6 class="card-header">Liste de Fonction</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_fonction">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fonction </th>
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
affiche_fonction()
$('body').delegate('.modifier_fonction','click',function(){
                       var ids=$(this).data('id');
                       $.ajax({
                           url   : "{{route('get_id_f')}}",
                           type  : 'POST',
                           async : false,
                           data  : {code: ids
                           },
                           success:function(data)
                           {
                             $("#name_fonction").val(data.fonction);
                             $("#code_fonction").val(data.id_fonction);
                           }
                       });
              });

              $('body').delegate('.supprimer_fonction','click',function(){
                       var ids=$(this).data('id');
                       swal({
        title: 'Voulez supprimer le donnes dans la base de donnees?',
        text: "le donnes ne seront plus trouvables apres suppression!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,SUPRIMER!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                       $.ajax({
                           url   : "{{route('delete_fonction')}}",
                           type  : 'POST',
                           async : false,
                           data  : {code: ids
                           },
                           success:function(data)
                           {
                             if(data.success=='1'){
                                  swal({title: 'ABT COLOMBE!',
                                        text: 'compte fonction suprimer avec success!',
                                        type: 'success'
                                        })
                                 affiche_fonction();
                                 }
                             else{
                                 alert('erreur dans la suppression');
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
            title: 'ABT COLOMBE',
            html: 'La fonction ne pas supprimer'
        })
    });
              });

              $('#btnsave_fonction').click(function() { 
             var name_fonct=$("#name_fonction").val();
             if(name_fonct!=''){ 
                 if ($("#code_fonction").val()=='') {
                        swal({
                        title: 'Voulez vous ajouter une fonction?',
                        text: " est vous sure!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes,Ajouter!',
                        cancelButtonText: 'No, ANNULE!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false,
                        allowOutsideClick: false,
                        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                     $.ajax({
                           url   : "{{route('create_fonction')}}",
                           type  : 'POST',
                           async : false,
                           data  : {name_fonction:name_fonct
                           },
                           success:function(data)
                           {
                             if(data.success=='1'){
                                 swal({title: 'ABT COLOMBE!',
                text: 'Un nauveau fonction ajouter avec success!',
                type: 'success'
                })
                                 window.location.href=("{{route('route_index_fonct')}}");
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
            title: 'ABT COLOMBE',
            html: 'fonction ne pas ajouter'
        })
    });
                 }
                 else{
                     swal({
                    title: 'Voulez vous modifier une fonction?',
                    text: " est vous sure!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes,Modifier!',
                    cancelButtonText: 'No, ANNULE!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                     $.ajax({
                           url   : "{{route('update_fonction')}}",
                           type  : 'POST',
                           async : false,
                           data  : {fonction: $("#name_fonction").val(),
                                    code_fonction:$("#code_fonction").val(),
                           },
                           success:function(data)
                           {
                             if(data.success=='1'){
                                 swal({title: 'ABT COLOMBE!',
                text: 'modification fonction avec success!',
                type: 'success'
                })
                                 affiche_fonction();
                                 $("#name_fonction").val("");
                                 $("#code_fonction").val("");
                                 //window.location.href=("{{route('route_index_fonct')}}");
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
            title: 'ABT COLOMBE',
            html: 'fonction ne pas modifier'
        })
    });
                 }
                 
               
             }
         });

         
        })();
        function affiche_fonction()
         {
           var otableau=$('#tab_fonction').DataTable({
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_f')}}",
                 "columns":[
                     {"data":'id_fonction'},
                     {"data":'fonction'},
                     {"data":'id_fonction',"autoWidth":true,"render":function (data) {
         
                             return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_fonction" ><i class="fa fa-times"></i></button>'+ ' ' +
                                 '<button data-id='+data+' class="btn btn-info btn-circle modifier_fonction" ><i class="fa fa-check"></i></button>';
                         }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
</script>
@endsection



