@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <hr class="border-light container-m--x my-4">
    <div class="card col-md-12">
        <h6 class="card-header">Transaction</h6>
        <div class="card-body">
        <table class="table card-table" id='update'>
            <thead class="thead-lisght">
                <tr>
                    <th>Date</th>
                    <th>Partenaire</th>
                    <th>Operation</th>
                    <th>Devise</th>
                    <th>Montant</th>   
                </tr>
            </thead>
            <tbody>
                @foreach($banques as $cloture)
                <tr>
                    <td>{{$cloture->date_T}}</td>
                    <td>{{$cloture->type}}</td>
                    @if($cloture->operation == 1)
                        <td>Depot </td>
                    @elseif($cloture->operation == 2)
                        <td>Retrait </td>
                    @endif
                    @if($cloture->id_devise == 1)
                        <td>Usd </td>
                    @elseif($cloture->id_devise == 2)
                        <td>CDF </td>
                    @endif
                    <td>{{$cloture->montants}}</td>             
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
         <form action="#" method="POST" id="form_agence">         
                {{csrf_field()}}
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <h5>ACCESS BANK SA :</h5>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="form-label">Total USD</label>
                        <input type="text"  class="form-control desabled" name="agence" readonly  value="{{$totusdAcess}}">
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="form-label">Total CDF</label>
                        <input type="text"  class="form-control desabled" name="agence" readonly  value="{{$totcdfAcess}}">
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <h5>Equity Bank :</h5>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="form-label">Total USD</label>
                        <input type="text"  class="form-control desabled" name="agence" readonly  value="{{$totusdEquity}}">
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="form-label">Total CDF</label>
                        <input type="text"  class="form-control desabled" name="agence" readonly  value="{{$totcdfEquity}}">
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
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