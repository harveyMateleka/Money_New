@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Partenaire</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
    </div>
    <div class="card col-md-12">
        <h4 class="card-header">Partenaire</h4>
        <div class="card-body">
            <form action="#" method="POST">
                {{csrf_field()}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Agence</label>
                        <select class="form-control" name="agence" style="border: 1px solid silver">
                            @foreach($resultat as $agences)
                            <option value="{{$agences->numagence}}">{{$agences->nomagence}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Partenaire</label>
                        <select class="form-control" name="partenaire" style="border: 1px solid silver">
                            @foreach($part as $banques)
                            <option value="{{$banques->id_partenaire}}">{{$banques->type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Devise</label>
                        <select class="form-control" name="devise" style="border: 1px solid silver">
                            @foreach($devise as $devises)
                            <option value="{{$devises->id}}">{{$devises->intitule}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Operation</label>
                        <select class="form-control" name="operation" style="border: 1px solid silver">
                            <option value="2">Depot</option>
                            <option value="1">Retrait</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Montant</label>
                        <input type="number" autocomplete="off" class="currency form-control" name="montant" style="border: 1px solid silver">
                    </div>
                </div>
                <button type="submit" class="btn btn-success" name="btnsave_taux">Enregistre</button>
                <button type="reset" class="btn btn-danger">annule</button>
            </form>
        </div>
    </div>
    <hr class="border-light container-m--x my-4">
    <div class="card col-md-12">
        <h6 class="card-header">Transaction</h6>
        <div class="card-body">
            <table class="table card-table" id='transfert'>
                <thead class="thead-lisght">
                    <tr>
                        <th>Date</th>
                        <th>Agence</th>
                        <th>Agent</th>
                        <th>Partenaire</th>
                        <th>Montant</th>
                        <th>Devise</th>
                        <th>Operation</th>

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
$(document).ready(function() {
$('#update').DataTable({
"lengthMenu": [[10, 25, 50, -1], [5, 25, 50, "All"]],
});
} );
@endsection