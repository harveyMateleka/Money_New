@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Page Utilisateur</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">

    </div>

    <div class="card col-md-8">
        <h3 class="card-header">Créer Un Utilisateur</h3>
        <div class="card-body">
            <form action="#" method="POST" id="form_utilisateur">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-row">
                                    <input type="text" class="form-control" name="name_matr" placeholder="Afficher le matricule" id="name_matr">
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_personnel" name="btnsave_smenu" id="btnsave_smenu">Personnel</button>
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="email" class="form-control" name="name_email" placeholder="Saisir votre Email" id="name_email">
                        <div class="clearfix"></div>
                    </div>

                </div>
                </br>
                <div class="form-row">
                    <div class="input-group col-md-6">
                        <input type="text" class="form-control" disabled name="name_password" placeholder="" id="name_password" value="{!! $result_users !!}">
                        <div class="clearfix"></div>
                    </div>
                </div>

                <hr class="border-light container-m--x my-4">
                <button type="button" class="btn btn-success" name="btnsave_users" id="btnsave_users">Enregistre</button>
                <button type="button" class="btn btn-danger" id="btnreset_users">annule</button>
                <input type="hidden" class="form-control" id="code_users">
                <input type="hidden" class="form-control" id="matr_users">
            </form>
        </div>
    </div>
    <hr class="border-light container-m--x my-4">
    <div class="card col-md-8">
        <h6 class="card-header">Liste des Utilisateur</h6>
        <div class="card-body">
            <table class="table card-table" id="tab_users">
                <thead class="thead-light">
                    <tr>
                        <th>Id</th>
                        <th>Nom du Personnel</th>
                        <th>Email</th>
                        <th>Etat Con</th>
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
    if ($('#name_email').val() === "") {
        $('#btnsave_users').prop('disabled', true);
    } else {
        $('#btnsave_users').prop('disabled', false);
    }

    $('#name_email').change(function() {
        if ($('#name_email').val() === "") {
            $('#btnsave_users').prop('disabled', true);
        } else {
            $('#btnsave_users').prop('disabled', false);
        }
    });

    (function() {
        affiche_users();
        $('body').delegate('.afficher_matr', 'click', function() {
            var ids = $(this).data('id');
            $("#name_matr").val(ids);
            $("#matr_users").val(ids);
        });


    })();

    function affiche_users() {
        var otableau = $('#tab_users').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print', 'copy', 'excel', 'pdf'
            ],
            "bProcessing": true,
            "sAjaxSource": "{{route('get_list_users')}}",
            "columns": [{
                    "data": 'id'
                },
                {
                    "data": 'nom'
                },
                {
                    "data": 'email'
                },
                {
                    "data": 'etatcon',
                    "autoWidth": true,
                    "render": function(data) {
                        if (data != '0') {
                            return 'Connecté';
                        } else {
                            return 'Deconnecté';
                        }
                    }
                },
                {
                    "data": 'id',
                    "autoWidth": true,
                    "render": function(data) {
                        return '<button data-id=' + data + ' class="btn btn-warning btn-circle supprimer_users" ><i class="fa fa-times"></i></button>';
                    }
                }
            ],
            "pageLength": 7,
            "bDestroy": true
        });
    }
</script>






@endsection