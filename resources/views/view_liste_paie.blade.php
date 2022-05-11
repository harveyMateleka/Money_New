@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card col-md-10">
                            <h6 class="card-header">Liste de paiement de la journée</h6>
                            <div class="card-body">
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
                            <hr class="border-light container-m--x my-4">
                            <div class="row">
                                <div class="col-lg-12">
                                   <div class="row">
                                        <div class="col-md-6">
                                        <h3 class="font-weight py-3 mb-0"> Montant en usd  {{$dollars}}</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 class="font-weight py-3 mb-0"> Montant en Cdf {{$francdf}}</h3>
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
})();
</script>
@endsection

