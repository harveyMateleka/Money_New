@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Page Utilisateur</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">

    </div>

    <div class="card col-md-12">
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
                        <div class="clearfix" id="emailErr"></div>
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
                <div class="d-flex">
                    <button type="button" class="btn btn-success" style='margin-right:10px' name="btnsave_users" id="btnsave_users">Créer</button>
                    <button type="button" class="btn btn-success" style='display:none; margin-right:10px' name="updateUser" id="updateUser">Modifier</button>

                    <button type="button" class="btn btn-danger" id="btnreset_users">annuler</button>
                </div>
                <input type="hidden" class="form-control" id="code_users" name='code_users'>
                <input type="hidden" class="form-control" id="matr_users">
            </form>
        </div>
    </div>
    <hr class="border-light container-m--x my-4">
    <div class="card col-md-12">
        <h6 class="card-header">Liste des Utilisateur</h6>
        <div class="card-body">
            <table class="table card-table" id="tab_users">
                <thead class="thead-light">
                    <tr>
                        <th>Id</th>
                        <th>Nom du Personnel</th>
                        <th>Email</th>
                        <th>Date création</th>
                        <th>Date modification</th>
                        <th>Etat</th>
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
    // Pattern pour un email valide
    let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    let emailErr = $('#emailErr');

    let dataUser = {};

    if ($('#name_email').val() === "") {
        $('#btnsave_users').prop('disabled', true);
        $('#updateUser').prop('disabled', true);
    } else {
        $('#btnsave_users').prop('disabled', false);
        $('#updateUser').prop('disabled', false);
    }

    $('#name_email').change(function() {
        if ($('#name_email').val() === "") {
            $('#btnsave_users').prop('disabled', true);
            $('#updateUser').prop('disabled', true);
        } else {
            $('#btnsave_users').prop('disabled', false);
            $('#updateUser').prop('disabled', false);
        }

        if ($('#name_email').val().match(pattern)) {
            $('#btnsave_users').prop('disabled', false);
            $('#updateUser').prop('disabled', false);
            $('#emailErr').text('');
            $('#emailErr').text('Adresse email valide');
            $('#emailErr').css('color', 'green');

            let matricule = $('#name_matr').val();
            let email = $('#name_email').val();
            let name_passe = $('#name_password').val();

            dataUser.email = email;
            dataUser.password = name_passe;
            dataUser.matricule = matricule = matricule;

        } else {
            $('#btnsave_users').prop('disabled', true);
            $('#updateUser').prop('disabled', true);
            $('#emailErr').text('Adresse email non valide');
            $('#emailErr').css('color', 'red');
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
                    "data": 'created_at'
                },
                {
                    "data": 'updated_at'
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
                        return `
                            <button data-id=${data} class="btn btn-success btn-circle editerUser"><i class="fa fa-edit"></i></button>
                            <button data-id=${data} class="btn btn-warning btn-circle deleteUser"><i class="fa fa-trash"></i></button>
                        `;
                    }
                }
            ],
            "pageLength": 7,
            "bDestroy": true
        });
    }

    // CREATION D'UN NOUVEL UTILISATEUR

    $('#btnsave_users').click(() => {
        $('#btnsave_users').text('Patientez...')

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('save_users')}}",
            type: 'POST',
            async: false,
            data: {
                name_matr: $("#matr_users").val(),
                name_email: $("#name_email").val(),
                name_passe: $("#name_password").val()
            },
            success: function(res) {

                if (res.status === 200) {
                    Swal.fire(
                        'Ajouté',
                        res.message,
                        'success'
                    )
                    $("#name_matr").val('');
                    $("#name_email").val('');
                    $("#matr_users").val('');
                    affiche_users();
                } else {
                    $('#affichage_message').html("l'utilisateur existe deja");
                    $('#modal_message').modal('show');
                    $("#name_matr").val('');
                    $("#name_email").val('');
                    $("#matr_users").val('');
                }
                $('#btnsave_users').text('Enregistrer')
                $('#emailErr').text('');
                $('#btnsave_users').prop('disabled', true);
            },
            error: function(err) {
                console.log(err.message);
                $('#btnsave_users').text('Enregistrer')
                $('#emailErr').text('');
                $('#btnsave_users').prop('disabled', true);
            }
        });

    });

    // EDITION DE L'USER, APPEL DU FORM POUR REMPLIR LES DATA DU USER SELON SON ID

    let editBtn = $('.editerUser');

    $('body').delegate('.editerUser', 'click', function() {
        let idUser = $(this).data('id');
        $('#btnsave_users').css('display', 'none');

        $('#updateUser').css('display', 'block');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('get_id_user')}}",
            method: 'POST',
            data: {
                id: idUser,
            },
            success: function(res) {
                $('#code_users').val(res.id)
                $('#name_matr').val(res.matricule)
                $('#name_email').val(res.email)
                $('#matr_users').val(res.matricule)
                $('#btnsave_users').prop('disabled', false);
            },
            error: function(err) {
                console.log("ERREURS ::: ", err);
            }
        })
    });

    // UPDATE USER 

    $('#updateUser').click(function() {
        let dataUser = {};

        let id = $('#code_users').val();
        let email = $("#name_email").val();
        let matricule = $("#name_matr").val();
        let pwd = $("#name_password").val();
        let new_password = 'Mtp-' + parseInt(Math.random() * 10000);

        dataUser.id = id;
        dataUser.email = email;
        dataUser.password = new_password;
        dataUser.matricule = matricule;

        console.log('Données users ::: ', dataUser)

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('update_users')}}",
            method: 'POST',
            data: dataUser,
            success: function(res) {
                if (res.status == 200) {
                    Swal.fire(
                        'Modifié',
                        res.message,
                        'success',
                    )
                    affiche_users();
                }
                $('#btnsave_users').css('display', 'block');
                $('#updateUser').css('display', 'none');
                $('#code_users').val('')
                $('#name_matr').val('')
                $('#name_email').val('')
                $('#matr_users').val('')
                $('#btnsave_users').prop('disabled', true);
                $('#emailErr').text('');
            },
            error: function(error) {
                console.log("ERREURS : " + error);
            }
        });


        let deleteBtn = $('.deleteUser');

        $('body').delegate('.deleteBtn', 'click', function() {
            let idUser = $(this).data('id');
            console.log("IUSERS");
        });


    })
</script>






@endsection