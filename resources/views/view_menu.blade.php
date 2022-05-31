@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Page de Menu</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">

    </div>

    <div class="card col-md-12">
        <h4 class="card-header">Ajout de Menu</h4>
        <div class="card-body">
            <form action="#" method="POST" id="form_ville">
                {{csrf_field()}}
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="form-label">Nom du menu</label>
                        <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="name_menu" style="border:1px solid silver; padding-left: 8px !important">
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label">Icon de Menu</label>
                        <input type="text" class="form-control" name="name_icon" placeholder="Saisir le menu" id="name_icon" style="border:1px solid silver; padding-left: 8px !important">
                        <div class="clearfix"></div>
                    </div>
                </div>

                <button type="button" class="btn btn-success" name="btnsave_menu" id="btnsave_menu">Enregistre</button>
                <button type="reset" class="btn btn-danger">annule</button>
                <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_menu">
            </form>
        </div>
    </div>
    <hr class="border-light container-m--x my-4">
    <div class="card col-md-12">
        <h6 class="card-header">Liste de Menu</h6>
        <div class="card-body">
            <div style="overflow-x:auto;">
                <table class="table card-table" id="tab_menu">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Nom de Menu</th>
                            <th>Icon de Menu</th>
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
$('#btnsave_menu').click(function() {
var name_menu=$("#name_menu").val();
var name_icon=$("#name_icon").val();
if(name_menu!='' && name_icon!=''){
if ($("#code_menu").val()=='') {

$.ajax({
url : "{{route('create_menu')}}",
type : 'POST',
async : false,
data : {name_menu:name_menu,
name_icon:name_icon
},
success:function(data)
{
if(data.success=='1'){
affiche_menu();
$("#name_menu").val("");
$("#name_icon").val("");
}
else{
$('#affichage_message').html('la donnée existe deja');
$('#modal_message').modal('show');
}
},
error:function(data){

alert(data.success);
}
});
}
else{
$.ajax({
url : "{{route('update_menu')}}",
type : 'POST',
async : false,
data : {menu: $("#name_menu").val(),
name_icon:name_icon,
code_menu:$("#code_menu").val(),
},
success:function(data)
{
if(data.success=='1'){
affiche_menu();
$("#name_menu").val("");
$("#name_icon").val("");
$("#code_menu").val("");
}


}
});
}


}
});
$('body').delegate('.modifier_menu','click',function(){
var ids=$(this).data('id');
alert(ids);
$.ajax({
url : "{{route('get_id_menu')}}",
type : 'POST',
async : false,
data : {code: ids
},
success:function(data)
{
$("#code_menu").val(data.id_menu);
$("#name_icon").val(data.icon);
$("#name_menu").val(data.item_menu);
}
});
});

$('body').delegate('.supprimer_menu','click',function(){
var ids=$(this).data('id');
$.ajax({
url : "{{route('delete_menu')}}",
type : 'POST',
async : false,
data : {code: ids
},
success:function(data)
{
if(data.success=='1'){
affiche_menu();
}
else{
$('#affichage_message').html('operation non effectué');
$('#modal_message').modal('show');
}
},
error:function(data){

alert(data.success);
}
});
});
@endsection