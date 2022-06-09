@extends('layouts.header')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="container-fluid flex-grow-1 container-p-y">
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Menu Principal</a></li>
    <li><a data-toggle="tab" href="#menu1">Sous menu</a></li>
  </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
        <div class="card col-md-12">
            <h4 class="card-header">Ajout de Menu</h4>
            <div class="card-body">
                <form action="#" method="POST" id="form_ville">
                    {{csrf_field()}}
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-label">Nom du menu</label>
                            <input type="text" style="text-transform:uppercase;" class="form-control" name="name_menu" placeholder="Saisir le menu" id="name_menu" style="border:1px solid silver; padding-left: 8px !important">
                            <div class="clearfix"></div>
                            <div class="clearfix" id="mes_naex" style="color:red;"></div>

                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label">Icon de Menu</label>
                            <input type="text" style="text-transform:uppercase;" class="form-control" name="name_icon" placeholder="Saisir le menu" id="name_icon" style="border:1px solid silver; padding-left: 8px !important">
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success" name="btnsave_menu" id="btnsave_menu">Enregistre</button>
                    <button type="reset" class="btn btn-danger">annule</button>
                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_menu">
                </form>
            </div>
        </div>
        <hr class="border-light container-m--x my-12">
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
    </div>
    <div id="menu1" class="tab-pane fade">
        <div class="card col-md-12">
            <h4 class="card-header">Ajout de Sous Menu</h4>
            <div class="card-body">
                <form action="#" method="POST" id="form_sous">
                    {{csrf_field()}}
                    <div class="form-row">
                        <div class="input-group col-md-6">
                            <select class="custom-select flex-grow-1" id='name_menu' style="border:1px solid silver; padding: 8px !important">
                                <option value='-1'>SELECTIONER LE MENU</option>
                                @foreach($resultat as $ligne_menu)
                                <option value='{!! $ligne_menu->id_menu !!}'>{!! $ligne_menu->item_menu !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </br>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-label">NOM DU SOUS MENU</label>
                            <input type="text" style="text-transform:uppercase;" class="form-control" name="name_menu" placeholder="Sous menu" id="name_smenu" * style="border:1px solid silver; padding-left: 8px !important">
                            <div class="clearfix" id="mes_naex" style="color:red;"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">LIEN DU ROUTE</label>
                            <input type="text" style="text-transform:uppercase;" class="form-control" style="border:1px solid silver; padding-left: 8px !important" placeholder="Lien" name="name_lien" placeholder="" id="name_lien">
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success" name="btnsave_smenu" id="btnsave_smenu">Enregistre</button>
                    <button type="reset" class="btn btn-danger">annule</button>
                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_smenu">
                </form>
            </div>
        </div>
        <hr class="border-light container-m--x my-12">
        <div class="card col-md-12">
            <h6 class="card-header">Liste de Sous Menu</h6>
            <div class="card-body">
                <table class="table card-table" id="tab_smenu">
                    <thead class="thead-light">
                        <tr>
                            <th>Id</th>
                            <th>Nom de Menu</th>
                            <th>Nom de Sous Menu</th>
                            <th>Lien du route</th>
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
            }else{
                $('#affichage_message').html('la donnée existe deja');
                $('#modal_message').modal('show');
            }
            },
            error:function(data){
                alert(data.success);
            }
        });
    }else{
        $.ajax({
            url : "{{route('update_menu')}}",
            type : 'POST',
            async : false,
            data : {menu: $("#name_menu").val(),
            name_icon:name_icon,
            code_menu:$("#code_menu").val(),
            },
            success:function(data){
                if(data.success=='1'){
                    affiche_menu();
                    $("#name_menu").val("");
                    $("#name_icon").val("");
                    $("#code_menu").val("");
                }
            }
        });
    }
}else{
    $("#mes_naex").html("tout les champs doivent etre obligatoirement remplire !");
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
            success:function(data){
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
            data : {code: ids},
            success:function(data){
                if(data.success=='1'){
                    affiche_menu();
                }else{
                    $('#affichage_message').html('operation non effectué');
                    $('#modal_message').modal('show');
                }
            },
            error:function(data){
                alert(data.success);
            }
        });
    });


//le sous menu

$('#btnsave_smenu').click(function() {
var name_menu=$("#name_menu").val();
var name_smenu=$("#name_smenu").val();
var name_lien=$("#name_lien").val();
if(name_menu!='-1' && name_smenu!='' && name_lien!=''){
if ($("#code_smenu").val()=='') {

$.ajax({
url : "{{route('create_smenu')}}",
type : 'POST',
async : false,
data : {name_menu:name_menu,
name_smenu:name_smenu,
name_lien:name_lien
},
success:function(data)
{
if(data.success=='1'){
affiche_smenu();
$("#name_smenu").val("");
$("#name_menu").val("-1");
$("#name_lien").val("");
}
else{
$('#affichage_message').html('ce sous menu existe deja');
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
url : "{{route('update_smenu')}}",
type : 'POST',
async : false,
data : {menu: $("#name_menu").val(),
name_smenu:name_smenu,
name_lien:name_lien,
code_smenu:$("#code_smenu").val()
},
success:function(data)
{
if(data.success=='1'){
affiche_smenu();
$("#name_smenu").val("");
$("#name_menu").val("-1");
$("#name_lien").val("");
$("#code_smenu").val("");
}
else{
alert('operation non effectuée');
}

}
});
}


}else{
    $("#mes_naex").html("tout les champs doivent etre obligatoirement remplire !");
}
});
$('body').delegate('.modifier_smenu','click',function(){
var ids=$(this).data('id');
$.ajax({
url : "{{route('get_id_smenu')}}",
type : 'POST',
async : false,
data : {code: ids
},
success:function(data)
{
$("#code_smenu").val(data.id_sous);
$("#name_lien").val(data.lien);
$("#name_smenu").val(data.item_sous);
$("#name_menu").val(data.id_menu);
}
});
});

$('body').delegate('.supprimer_smenu','click',function(){
var ids=$(this).data('id');
$.ajax({
url : "{{route('delete_smenu')}}",
type : 'POST',
async : false,
data : {code: ids
},
success:function(data)
{
if(data.success=='1'){
affiche_smenu();
}
else{
alert('erreur dans la suppression');
}
},
error:function(data){

alert(data.success);
}
});
});
@endsection