@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0">Accueil</h3>
   <div class="row">
     
         <div class="row">
            <div class="col-md-2">
               <div class="card mb-6">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                           <p class="text-muted mb-0"><span class="badge badge-warning">{{ $TotalEntreUsd }}</span>TOTAL  ENTREE USD</p>
                        </div>
                        <a href="#" class="sidenav-link">
                           <div class="lnr lnr-chart-bars display-4 text-success"></div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            
            <div class="col-md-2">
               <div class="card mb-6">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <!-- <p class="text-muted mb-0"><span class="badge badge-warning">{{ $nbr_actif }}</span>Personnel en Congé</p>-->
                         <p class="text-muted mb-0"><span class="badge badge-primary">{{$TotalEntreCdf }}</span>TOTAL ENTREE CDF </p>
                        </div>
                        <a href="#" class="sidenav-link">
                           <div class="lnr lnr-magic-wand display-4 text-primary"></div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-2">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                           <p class="text-muted mb-0"><span class="badge badge-success">{{ $TotalsortieUsd}}</span>TOTAL SORTIE USD</p>
                        </div>
                        <a href="#" class="sidenav-link">
                           <div class="lnr lnr-license display-4 text-primary"></div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-2">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                             <p class="text-muted mb-0"><span class="badge badge-danger">{{ $TotalSortieCdf}}</span> TOTAL SORTIE CDF</p>
                          
                        </div>
                        <div class="lnr lnr-cart display-4 text-warning"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-2">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                           <p class="text-muted mb-0"><span class="badge badge-warning">{{$TotalcreditUsd}}</span> TOTAL CREDIT USD</p>
                          
                        </div>
                        <div class="lnr lnr-gift display-4 text-success"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-2">
               <div class="card mb-4">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                           <p class="text-muted mb-0"><span class="badge badge-primary">{{$TotalcreditCdf}}</span> TOTAL CREDIT CDF</p> 
                          
                        </div>
                        <div class="lnr lnr-rocket display-4 text-danger"></div>
                     </div>
                  </div>
               </div>
            </div> 
         </div>
     
      <!-- 1st row Start -->
   </div>
   <div class="row" >
   <div class="col-lg-6" >
         <div class="card mb-4">
            <div class="card-header with-elements">
               <h6 class="card-header-title mb-0">Statistics FRANCS</h6>
               <div class="card-header-elements ml-auto">
                  <label class="text m-0">
                  <span class="text-light text-tiny font-weight-semibold align-middle">SHOW STATS</span>
                  <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                     <input type="checkbox" class="switcher-input" checked>
                     <span class="switcher-indicator"><span class="switcher-yes"></span><span
                     class="switcher-no"></span></span></span>
                  </label>
               </div>
            </div>
            <div class="card-body">
                  <canvas id="myChart" style="height:300px"></canvas> 
            </div>
         </div>
         </div>


         <div class="col-lg-6" >
         <div class="card mb-4">
            <div class="card-header with-elements">
               <h6 class="card-header-title mb-0">Statistics DOLLARS </h6>
               <div class="card-header-elements ml-auto">
                  <label class="text m-0">
                  <span class="text-light text-tiny font-weight-semibold align-middle">SHOW STATS</span>
                  <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                     <input type="checkbox" class="switcher-input" checked>
                     <span class="switcher-indicator"><span class="switcher-yes"></span><span
                     class="switcher-no"></span></span></span>
                  </label>
               </div>
            </div>
            <div class="card-body">
                  <canvas id="myChart1" style="height:300px"></canvas> 
            </div>
         </div>
         </div>
         </div>
         
   </div>
</div>
@endsection
@section('script')

var _ydata= JSON.parse('{!! json_encode($months) !!}');
var _xdata=JSON.parse('{!! json_encode($monthCount) !!}');

var ctx = document.getElementById("myChart");

var BarChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: _ydata,
    datasets: [{
      label: "ENTREE FRANC CONGOLAIS",
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


var _ydata= JSON.parse('{!! json_encode($months1) !!}');
var _xdata=JSON.parse('{!! json_encode($monthCount1) !!}');

var ctx = document.getElementById("myChart1");

var myBarChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: _ydata,
    datasets: [{
      label: "ENTREE DOLLARS AMERICAINE",
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