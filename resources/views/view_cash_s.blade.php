@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Rapport de Trasaction Cash express</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-12">
                            <h6 class="card-header">Rapport de Trasaction Cash express</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_cash">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Banque</th>
                                        <th>Depot en Usd</th>
                                        <th>Depot en Cdf</th>
                                        <th>Retrait en Usd</th>
                                        <th>Retrait en Cdf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                $banque="";
                                $var=0;
                                $count1=1;
                                $depotusd=0.0;
                                $depotcdf=0.0;
                                $retraitcdf=0.0;
                                $retraitusd=0.0;
                                @endphp
                                @foreach($resultat as $ligne_requette)
                                    @if($banque=='')
                                        @if($ligne_requette->operation=='2' && $ligne_requette->id_devise==1)
                                            @php
                                            $banque=$ligne_requette->type;
                                            $depotusd=$ligne_requette->montant;
                                            @endphp
                                        @elseif($ligne_requette->operation=='2' && $ligne_requette->id_devise==2)
                                            @php
                                            $banque=$ligne_requette->type;
                                            $depotcdf=$ligne_requette->montant;
                                            @endphp 
                                        @elseif($ligne_requette->operation=='1' && $ligne_requette->id_devise==1)
                                            @php
                                            $banque=$ligne_requette->type;
                                            $retraitusd=$ligne_requette->montant;
                                            @endphp
                                        @else
                                            @php
                                            $banque=$ligne_requette->type;
                                            $retraitcdf=$ligne_requette->montant;
                                            @endphp
                                        @endif
                                                @if($count1==count($resultat))
                                                <tr>
                                                    <td>
                                                        {{$banque}}
                                                    </td>
                                                    <td>
                                                        {{$depotusd}}
                                                    </td>
                                                    <td>
                                                        {{$depotcdf}}
                                                    </td>
                                                    <td>
                                                        {{$retraitusd}}
                                                    </td>
                                                    <td>
                                                        {{$retraitcdf}}
                                                    </td>
                                                </tr>
                                                @break
                                                @endif
                                    @elseif($banque==$ligne_requette->type)
                                            @if($ligne_requette->operation=='2' && $ligne_requette->id_devise==1)
                                                    @php
                                                    $banque=$ligne_requette->type;
                                                    $depotusd=$ligne_requette->montant;
                                                    @endphp
                                                @elseif($ligne_requette->operation=='2' && $ligne_requette->id_devise==2)
                                                    @php
                                                    $banque=$ligne_requette->type;
                                                    $depotcdf=$ligne_requette->montant;
                                                    @endphp 
                                                @elseif($ligne_requette->operation=='1' && $ligne_requette->id_devise==1)
                                                    @php
                                                    $banque=$ligne_requette->type;
                                                    $retraitusd=$ligne_requette->montant;
                                                    @endphp
                                                @else
                                                    @php
                                                    $banque=$ligne_requette->type;
                                                    $retraitcdf=$ligne_requette->montant;
                                                    @endphp
                                                @endif

                                                @if($count1==count($resultat))
                                                    <tr>
                                                        <td>
                                                            {{$banque}}
                                                        </td>
                                                        <td>
                                                            {{$depotusd}}
                                                        </td>
                                                        <td>
                                                            {{$depotcdf}}
                                                        </td>
                                                        <td>
                                                            {{$retraitusd}}
                                                        </td>
                                                        <td>
                                                            {{$retraitcdf}}
                                                        </td>
                                                    </tr>
                                                    @break
                                                    @endif
                                                    
                                    @else
                                        <tr>
                                        <td>
                                            {{$banque}}
                                        </td>
                                        <td>
                                            {{$depotusd}}
                                        </td>
                                        <td>
                                            {{$depotcdf}}
                                        </td>
                                        <td>
                                            {{$retraitusd}}
                                        </td>
                                        <td>
                                            {{$retraitcdf}}
                                        </td>
                                     </tr>
                                            @php
                                                $depotusd=0.0;
                                                $depotcdf=0.0;
                                                $retraitcdf=0.0;
                                                $retraitusd=0.0;
                                            @endphp
                                        @if($ligne_requette->operation=='2' && $ligne_requette->id_devise==1)
                                                @php
                                                $banque=$ligne_requette->type;
                                                $depotusd=$ligne_requette->montant;
                                                @endphp
                                            @elseif($ligne_requette->operation=='2' && $ligne_requette->id_devise==2)
                                                @php
                                                $banque=$ligne_requette->type;
                                                $depotcdf=$ligne_requette->montant;
                                                @endphp 
                                            @elseif($ligne_requette->operation=='1' && $ligne_requette->id_devise==1)
                                                @php
                                                $banque=$ligne_requette->type;
                                                $retraitusd=$ligne_requette->montant;
                                                @endphp
                                            @else
                                                @php
                                                $banque=$ligne_requette->type;
                                                $retraitcdf=$ligne_requette->montant;
                                                @endphp
                                            @endif
                                    @endif
                                    @if($count1==count($resultat))
                                    <tr>
                                        <td>
                                            {{$banque}}
                                        </td>
                                        <td>
                                            {{$depotusd}}
                                        </td>
                                        <td>
                                            {{$depotcdf}}
                                        </td>
                                        <td>
                                            {{$retraitusd}}
                                        </td>
                                        <td>
                                            {{$retraitcdf}}
                                        </td>
                                     </tr>
                                     @break
                                    @endif
                                
                                @php
                                ++$count1;
                                @endphp
                                @endforeach
                                </tbody>
                            </table>
                            <hr class="border-light container-m--x my-4">
                            <div class="row">
                                <div class="col-lg-12">
                                   <div class="row">
                                        <div class="col-md-6">
                                        <h3 class="font-weight py-3 mb-0"> </h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 class="font-weight py-3 mb-0"> </h3>
                                        </div>
                                  </div> 
                            </div> 
                        </div> 
                               
                    </div>
                        </div>
                    </div>        
@endsection
@section ('script')
 var table = $('#tab_cash').DataTable({
      "lengthMenu": [
        [10, 25, 50, -1],
        [5, 25, 50, "All"]
      ],

      dom: 'Bfrtip',
      buttons: [
        'print', 'copy', 'excel', 'pdf'

      ]
    });
@endsection

