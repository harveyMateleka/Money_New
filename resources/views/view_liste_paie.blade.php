@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">




    <div class="card col-md-12">
        <h2 class="card-header">Rapport Ong</h2>
        <div class="card-body">
            <ul class="nav nav-tabs mb-3" id="ex-with-icons" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="ex-with-icons-tab-1" data-toggle="tab" href="#first" role="tab" aria-controls="ex-with-icons-tabs-1" aria-selected="true"><i class="fas fa-chart-line fa-fw me-2"></i>Rapport du paiement d'aujord'hui</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-3" data-toggle="tab" href="#tree" role="tab" aria-controls="ex-with-icons-tabs-3" aria-selected="true"><i class="fas fa-chart-line fa-fw me-2"></i>Paiment d'une periode</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-2" data-toggle="tab" href="#second" role="tab" aria-controls="ex-with-icons-tabs-2" aria-selected="true"><i class="fas fa-chart-line fa-fw me-2"></i>Total Entrée/Periode</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-3" data-toggle="tab" href="#four" role="tab" aria-controls="ex-with-icons-tabs-3" aria-selected="true"><i class="fas fa-chart-line fa-fw me-2"></i>Solde Actuel Coffre</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="ex-with-icons-tab-1">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="card-header">Rapport de paiement Ong d'aujordui par agence</h4></br></br>
                                    <table class="table card-table" id="tab_paiement">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Agence</th>
                                                <th>Montant</th>
                                                <th>Devise</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $dollars=0.0;
                                            $francdf=0.0;
                                            @endphp
                                            @foreach($requette as $ligne_requette)
                                            <tr>
                                                <td>
                                                    {!! $ligne_requette->nomagence !!}
                                                </td>
                                                <td>
                                                    {!! $ligne_requette->mont !!}
                                                </td>
                                                @if($ligne_requette->devise=='1')
                                                <td>USD</td>
                                                @php
                                                $dollars+=$ligne_requette->mont;
                                                @endphp
                                                @else
                                                <td>CDF</td>
                                                @php
                                                $francdf+=$ligne_requette->mont;
                                                @endphp
                                                @endif
                                                <td>
                                                    {!! $ligne_requette->created_at !!}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr class="border-light container-m--x my-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="font-weight py-3 mb-0"> Montant en usd {{$dollars}}</h3>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="font-weight py-3 mb-0"> Montant en Cdf {{$francdf}}</h3>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="tab-pane " id="tree" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="card-header">Situation de Paie d'une periode</h4></br></br>
                            <form action="#" method="POST">
                                {{csrf_field()}}
                                <div id="affichage" style='color:red; font-size:15px;'>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Date Debut</label>
                                        <input type="date" class="form-control" name="name_datedebut" id='name_datedebut'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Date Fin</label>
                                        <input type="date" class="form-control" name="name_datefin" id='name_datefin'>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" name="btndisplay" id='btndisplay'>Afficher</button>
                                <button type="reset" class="btn btn-danger">annule</button>
                            </form> </br></br>
                            <table class="table card-table" id="tab_rapport">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Agence</th>
                                        <th>Ong</th>
                                        <th>Montant</th>
                                        <th>Devise</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="second" role="tabpanel" aria-labelledby="ex-with-icons-tab-3">

                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="card-header">Totale Entrée d'une Periode</h4></br></br>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="#" method="POST">
                                        {{csrf_field()}}
                                        <div id="affichage" style='color:red; font-size:15px;'>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="form-label">Date Debut</label>
                                                <input type="date" class="form-control" name="name_datedebut" id='datedebut'>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label">Date Fin</label>
                                                <input type="date" class="form-control" name="name_datefin" id='datefin'>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success" name="btndisplay" id='btndisplays'>Afficher</button>
                                        <button type="reset" class="btn btn-danger" id='annuler'>annule</button>
                                    </form>
                                </div>

                            </div></br></br>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="card-header">Entrée en CDF :  <span id="entrecdf" style="font-size:15px; color:red;"></span></h6>
                                    <h6 class="card-header"> Entrée en USD : <span id="entreusd" style="font-size:15px;color:red"></span></h4>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="card-header"> Pourcentage en CDF : <span id="pourcdf" style="font-size:15px;color:red"></span></h6>
                                    <h6 class="card-header"> Pourcentage en USD : <span id="pourusd" style="font-size:15px;color:red"></span></h6>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="card-header"> Deplacement en CDF : <span id="deplcdf" style="font-size:15px;color:red"></span></h6>
                                    <h6 class="card-header"> Deplacement en USD : <span id="deplusd" style="font-size:15px;color:red"></span></h6>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>
                <div class="tab-pane" id="four" role="tabpanel" aria-labelledby="ex-with-icons-tab-3">
                <div class="row">
                        <div class="col-lg-12">
                            <h4 class="card-header">Solde Actuel Ong</h4></br></br>
                             </br>
                            <table class="table card-table" id="tab_rapport">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Numero Ag.</th>
                                        <th>Description</th>
                                        <th>Montant en USD</th>
                                        <th>Montant en CDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($resultat as $ligne)
                                    <tr>
                                    <td>{{$ligne->numagence }}</td> 
                                    <td>{{$ligne->nomagence  }}</td> 
                                    <td>{{$ligne->Montusd  }}</td> 
                                    <td>{{$ligne->Montcdf }}</td>
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
































        </div>
    </div>
</div>
@endsection
@section ('javascript')
<script type="text/javascript">
    (function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#tab_paiement').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [5, 25, 50, "All"]
            ],

            dom: 'Bfrtip',
            buttons: [
                'print', 'copy', 'excel', 'pdf'

            ]
        });
        $('#annuler').click(function(){
            $('#entreusd').html('');
            $('#pourusd').html('');
            $('#deplusd').html('');
            $('#entrecdf').html('');
            $('#pourcdf').html('');
            $('#deplcdf').html('');  
        });
        $('#btndisplay').click(function() {
            if ($('#name_datefin').val() >= $('#name_datedebut').val()) {
                $('#affichage').html('');
                affiche_paiements($('#name_datedebut').val(), $('#name_datefin').val());
            } else {
                $('#affichage').html('la date debut ne peux pas etre superieure à la date de la fin');
            }
        });
        $('#btndisplays').click(function() {
            if ($('#datefin').val() >= $('#datedebut').val()) {
                $('#affichage').html('');
                //affiche_paiements($('#name_datedebut').val(),$('#name_datefin').val());
                $.ajax({
                    url: "{{route('gettotalentre')}}",
                    type: 'POST',
                    async: false,
                    data: {
                        date_debut: $('#datedebut').val(),
                        date_fin: $('#datefin').val()
                    },
                    success: function(data) {
                        if (data.success == '200') {
                            console.log(data.donnee);



                            if (data.donnee.length > 0) {

                                data.donnee.forEach(function(val) {
                                    let montants = formateIndianCurrency(val.montant);
                                    let montantpour = formateIndianCurrency(val.montantcom);
                                    let montcom = formateIndianCurrency(val.montantdep);
                                    if (val.devise == '1') {
                                        $('#entreusd').html(montants.substring(0, montants.length - 1));
                                        $('#pourusd').html(montantpour.substring(0,montantpour.length -1));
                                        $('#deplusd').html(montcom.substring(0,montcom.length -1));
                                    } else {
                                        $('#entrecdf').html(montants.substring(0, montants.length - 1));
                                        $('#pourcdf').html(montantpour.substring(0,montantpour.length -1));
                                        $('#deplcdf').html(montcom.substring(0,montcom.length -1));
                                    }

                                })

                            }
                        }

                    },
                    error: function(data) {
                        console.log(data.success);
                    }
                });
            } else {
                $('#affichage').html('la date debut ne peux pas etre superieure à la date de la fin');
            }
        });
    })();


    function affiche_paiements(debut, fin) {
        let tableau = [debut, fin]
        var otableau = $('#tab_rapport').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print', 'copy', 'excel', 'pdf'
            ],
            "bProcessing": true,
            "sAjaxSource": "/admin/getMontant/" + tableau,
            "columns": [{
                    "data": 'created_at'
                },
                {
                    "data": 'nomagence'
                },
                {
                    "data": 'name_ong'
                },
                {
                    "data": 'total',
                    "autoWidth": true,
                    "render": function(data) {
                        let values = formateIndianCurrency(data);
                        return values.substring(0, values.length - 1);
                    }
                },
                {
                    "data": 'devise',
                    "autoWidth": true,
                    "render": function(data) {
                        if (data == 2) {
                            return 'CDF';
                        } else {
                            return 'USD';
                        }
                    }
                },
            ],
            order: [
                [0, "DESC"]
            ],
            "bDestroy": true
        });
    }
</script>
@endsection