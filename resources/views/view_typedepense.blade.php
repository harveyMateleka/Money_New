@extends('layouts.header')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Page Type depense</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">

    </div>

    <div class="card col-md-12">
        <h4 class="card-header">Ajout type Depense</h4>
        <div class="card-body">
            <form action="#" method="POST" id="form_ville">
                {{csrf_field()}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Type Depense</label>
                        <input type="text" class="form-control" style="border:1px solid silver; padding-left: 8px !important" name="name_typedep" placeholder="Saisir le type Depense" id="name_typedep">
                        <div class="clearfix"></div>
                        <div class="clearfix" id="mes_type" style="color:red"></div>
                    </div>

                </div>
                <button type="button" class="btn btn-success" name="btnsave_typedep" id="btnsave_typedep">Enregistre</button>
                <button type="reset" class="btn btn-danger">annule</button>
                <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_typedep">
            </form>
        </div>
    </div>
    <hr class="border-light container-m--x my-4">
    <div class="card col-md-12">
        <h6 class="card-header">Liste de Type Depense</h6>
        <div class="card-body">
            <table class="table card-table" id="tab_typedep">
                <thead class="thead-light">
                    <tr>
                        <th>Id</th>
                        <th>Type Depense</th>
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
@endsection
@section('script')
$('#btnsave_typedep').click(function() {
    var name_typedep=$("#name_typedep").val();
    if(name_typedep!=''){
        if ($("#code_typedep").val()=='') {

            $.ajax({
            url : "{{route('create_typedep')}}",
            type : 'POST',
            async : false,
            data : {name_typedep:name_typedep
            },
            success:function(data)
            {
            if(data.success=='1'){
            affiche_typedep();
            $("#name_typedep").val("");
            }
            else{
            alert('existe deja');
            }
            },
                error:function(data){

                alert(data.success);
            }
        });
        }
else{
$.ajax({
url : "{{route('update_typedep')}}",
type : 'POST',
async : false,
data : {typedep: $("#name_typedep").val(),
code_typedep:$("#code_typedep").val(),
},
success:function(data)
{
if(data.success=='1'){
affiche_typedep();
$("#name_typedep").val("");
$("#code_typedep").val("");
}
else{
alert('operation non effectuée');
}

}
});
}


}else{
$("#mes_type").html("Vueillez saisir ce champ !");

}
});
$('body').delegate('.modifier_typedep','click',function(){
var ids=$(this).data('id');
$.ajax({
url : "{{route('get_id_typedep')}}",
type : 'POST',
async : false,
data : {code: ids
},
success:function(data)
{
$("#name_typedep").val(data.type_dep);
$("#code_typedep").val(data.id_typdep);
}
});
});

$('body').delegate('.supprimer_typedep','click',function(){
var ids=$(this).data('id');
$.ajax({
url : "{{route('delete_typedep')}}",
type : 'POST',
async : false,
data : {code: ids
},
success:function(data)
{
if(data.success=='1'){
affiche_typedep();
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