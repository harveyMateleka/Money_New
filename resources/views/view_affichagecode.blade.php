@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
        
        <hr class="border-light container-m--x my-4">
        <div class="card col-md-10">
            <h6 class="card-header">Liste des codes servis</h6>
            <div class="card-body">
            <table class="table card-table" id='update'>
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>  
                        <th>Destination</th>
                        <th>Agent</th>
                        <th>Code</th>
                        <th>Montant</th>
                        <th>Devise</th>
                         
                    </tr>
                </thead>
                <tbody>
                    @foreach($codes as $codess)
                    <tr>
                        <td>{{$codess->created_at}}</td>
                        <td>{{$codess->nomagence}}</td>
                        <td>{{$codess->nom}}-{{$codess->prenom}}</td>
                        <td>{{$codess->numdepot}}</td>
                        <td>{{$codess->montenvoi}}</td>
                        <td>{{$codess->intitule}}</td>
                        
                    </tr>
                    @endforeach
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