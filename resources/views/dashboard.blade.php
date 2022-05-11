@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0">Accueil</h3>
   <div class="row">
      <div class="col-lg-5">
         <div class="row">
            <div class="col-md-6">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                           <p class="text-muted mb-0"><span class="badge badge-warning">{{ $nbr_conge }}</span>Personnel en Congé</p>
                        </div>
                        <a href="#" class="sidenav-link">
                           <div class="lnr lnr-chart-bars display-4 text-success"></div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <p class="text-muted mb-0"><span class="badge badge-primary">{{ $nbr_actif}}</span>Personnel Actif</p>
                        </div>
                        <a href="#" class="sidenav-link">
                           <div class="lnr lnr-magic-wand display-4 text-primary"></div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                           <p class="text-muted mb-0"><span class="badge badge-success">{{ $nbr_licencie}}</span>Personnel licencié</p>
                        </div>
                        <a href="#" class="sidenav-link">
                           <div class="lnr lnr-license display-4 text-primary"></div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                             <p class="text-muted mb-0"><span class="badge badge-danger">{{ $Totalentree}}</span> Total Entrée</p>
                          
                        </div>
                        <div class="lnr lnr-cart display-4 text-warning"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                           <p class="text-muted mb-0"><span class="badge badge-warning">{{$Totalsortie}}</span> Total Sortie</p>
                          
                        </div>
                        <div class="lnr lnr-gift display-4 text-success"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                           <p class="text-muted mb-0"><span class="badge badge-primary">{{$Totalcredit}}</span> Total Credit</p> 
                          
                        </div>
                        <div class="lnr lnr-rocket display-4 text-danger"></div>
                     </div>
                  </div>
               </div>
            </div>
            
            <div class="col-md-6">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                           <p class="text-muted mb-0"><span class="badge badge-warning">{{$Totalsortiemvt}}</span> Sortie Mouvement Banques</p>
                          
                        </div>
                        <div class="lnr lnr-gift display-4 text-success"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                           <p class="text-muted mb-0"><span class="badge badge-success">{{$TotalEntremvt}}</span> Entree Mouvement Banques</p> 
                          
                        </div>
                        <div class="lnr lnr-license display-4 text-primary"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-7">
         <div class="card mb-4">
            <div class="card-header with-elements">
               <h6 class="card-header-title mb-0">Statistics</h6>
               <div class="card-header-elements ml-auto">
                  <label class="text m-0">
                  <span class="text-light text-tiny font-weight-semibold align-middle">SHOW STATS</span>
                  <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2"><input type="checkbox" class="switcher-input" checked><span class="switcher-indicator"><span class="switcher-yes"></span><span
                     class="switcher-no"></span></span></span>
                  </label>
               </div>
            </div>
            <div class="card-body">
                  <canvas id="myChart" style="height:300px"></canvas> 
            </div>
         </div>
      </div>
      <!-- 1st row Start -->
   </div>
</div>
@endsection
@section('script')

var _ydata= JSON.parse('{!! json_encode($months) !!}');
var _xdata=JSON.parse('{!! json_encode($monthCount) !!}');

var ctx = document.getElementById("myChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: _ydata,
    datasets: [{
      label: "pourcentage",
      backgroundColor:  [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
      borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
      data: _xdata,
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 10,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});

@endsection