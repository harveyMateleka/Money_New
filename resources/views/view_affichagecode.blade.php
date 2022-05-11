@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
        <h3 class="font-weight-bold py-3 mb-0">Affichage des codes servis</h3>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">  
        </div>
        <hr class="border-light container-m--x my-4">
        <div class="card col-md-8">
            <h6 class="card-header">Liste des codes servvis</h6>
            <div class="card-body">
            <table class="table card-table" id='update'>
                <thead class="thead-light">
                    <tr>
                        <th>Agence</th>
                        <th>Agent</th>
                        <th>Codes</th>
                        <th>Montant</th>
                        <th>Devise</th>
                        <th>Date</th>   
                    </tr>
                </thead>
                <tbody>
                    @foreach($codes as $codess)
                    <tr>
                        <td>{{$codess->nomagence}}</td>
                        <td>{{$codess->nom}}-{{$codess->prenom}}</td>
                        <td>{{$codess->numdepot}}</td>
                        <td>{{$codess->montenvoi}}</td>
                        <td>{{$codess->intitule}}</td>
                        <td>{{$codess->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>        
@endsection
@section('javascript')
<script type="text/javascript">
    (function() {
        $('#update').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [5, 25, 50, "All"]],
        });
    })();
</script>
@endsection