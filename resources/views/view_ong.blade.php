@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">O.N.G</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-8">
                            <h4 class="card-header">ENREGISTREMENT D'UN O.N.G</h4>
                            <div class="card-body">
                                <form action="#" method="POST">
                                {{csrf_field()}}
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label class="form-label">NOM O.N.G</label>
                                            <input type="text" class="form-control" data-validation="required" name="nomong" style="text-transform:uppercase;" placeholder="" id="name_ong">
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label class="form-label">NOM PERSONNEL</label>
                                            <input type="text"  style="text-transform:uppercase;" class="form-control" data-validation="required" name="nompersonnel" placeholder="" id="name_Perso">
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label class="form-label">ADRESSE SIEGE</label>
                                            <input type="text" class="form-control" style="text-transform:uppercase;" data-validation="required" name="adresse" placeholder="" id="adresse_siege">
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label class="form-label">TELEPHONE</label>
                                            <input type="number" class="form-control" data-validation="required" name="telservice" placeholder="" id="tel_contact">
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success" name="btnsave_ong" id="btnsave_ong">Enregistre</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de l'ong" id="ong">
                                </form>

@endsection

@section('javascript')
<script type="text/javascript">
    (function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#btnsave_ong').click(function() {
            var name_ong = $("#name_ong").val();
            var name_Perso = $("#name_Perso").val();
            var adresse_siege = $("#adresse_siege").val();
            var tel_contact = $("#tel_contact").val();
            if ($("#name_ong").val() != '' && $("#name_Perso").val() != '' && $("#tel_contact").val() != '' && $("#adresse_siege").val() != '') {
                if ($("#ong").val() == '') {
                    Swal.fire({
                        title: 'Colombe Money',
                        html: "Vous voulez enregistrer",
                        width: 600,
                        padding: '3em',
                        showDenyButton: true,
                        confirmButtonText: `Enregistrer`,
                        denyButtonText: `Annuler`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{route('create_ong')}}",
                                type: 'POST',
                                async: false,
                                data: {
                                    ong: name_ong,
                                    Perso: name_Perso,
                                    siege: adresse_siege,
                                    tel: tel_contact
                                },
                                success: function(data) {
                                    if (data.success == '1') {
                                        Swal.fire('operation effectuée', '', 'success')
                                        affiche_ong1();
                                        $("#name_ong").val('');
                                        $("#name_Perso").val('');
                                        $("#adresse_siege").val('');
                                        $("#tel_contact").val('');
                                    } else {
                                        Swal.fire('operation echouée', '', 'error')
                                    }
                                },
                                error: function(data) {

                                    Swal.fire('operation echouée', '', 'error');
                                }
                            });

                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    });
                } else {

                    Swal.fire({
                        title: 'Colombe Money',
                        html: "Vous voulez Modifier",
                        width: 600,
                        padding: '3em',
                        showDenyButton: true,
                        confirmButtonText: `Modifier`,
                        denyButtonText: `Annuler`,
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({

                                url: "{{route('update_ong')}}",
                                type: 'POST',
                                async: false,
                                data: {
                                    name_ong: $("#name_ong").val(),
                                    name_Perso: $("#name_Perso").val(),
                                    adresse_siege: $("#adresse_siege").val(),
                                    tel_contact: $("#tel_contact").val(),
                                    id: $("#ong").val(),
                                },
                                success: function(data) {
                                    if (data.success == '1') {
                                        Swal.fire('operation effectuée', '', 'success')
                                        affiche_ong1();
                                        $("#name_ong").val('');
                                        $("#name_Perso").val('');
                                        $("#adresse_siege").val('');
                                        $("#tel_contact").val('');
                                    } else {
                                        Swal.fire('operation echoué', '', 'error')
                                    }

                                },
                                error: function(data) {
                                    Swal.fire('operation echouée', '', 'error');
                                }
                            });
                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    });

                }

            }

        });
        affiche_ong1();

        $('body').delegate('.modifier_ong1', 'click', function() {
            var ids = $(this).data('id');
            $.ajax({
                url: "{{route('get_ong')}}",
                type: 'POST',
                async: false,
                data: {
                    code: ids
                },
                success: function(data) {
                    $("#ong").val(data.id);
                    $("#name_ong").val(data.name_ong);
                    $("#name_Perso").val(data.name_Perso);
                    $("#adresse_siege").val(data.adresse_siege);
                    $("#tel_contact").val(data.tel_contact);


                }
            });
        });


        $('body').delegate('.supprimer_ong1', 'click', function() {
            var ids = $(this).data('id');

            $.ajax({
                url: "{{route('delete_ong')}}",
                type: 'POST',
                async: false,
                data: {
                    code: ids
                },
                success: function(data) {
                    if (data.success == '1') {
                        affiche_ong1();
                    } else {
                        alert('erreur dans la suppression');
                    }
                }
            });
        });
    })();

    function affiche_ong1() {
        var otableau = $('#tab_ong1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print', 'copy', 'excel', 'pdf'
            ],
            "bProcessing": true,
            "sAjaxSource": "{{route('get_list_ongc')}}",
            "columns": [{
                    "data": 'id'
                },
                {
                    "data": 'name_ong'
                },
                {
                    "data": 'name_Perso'
                },
                {
                    "data": 'tel_contact'
                },
                {
                    "data": 'adresse_siege'
                },
                {
                    "data": 'id',
                    "autoWidth": true,
                    "render": function(data) {
                        return '<button data-id=' + data + ' class="btn btn-danger btn-circle supprimer_ong1"><i class="fa fa-times"></i></button>' + ' ' +
                            '<button data-id=' + data + ' class="btn btn-info btn-circle modifier_ong1"><i class="fa fa-check"></i></button>';
                    }
                }
            ],
            "pageLength": 10,
            "bDestroy": true
        });
    }
</script>
@endsection
