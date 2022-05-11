<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">
<head>
    <title>ABT-Colombe</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Empire Bootstrap admin template made using Bootstrap 4, it has tons of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="Empire, bootstrap admin template, bootstrap admin panel, bootstrap 4 admin template, admin template">
    <meta name="csrf-token" content="{{ csrf_token()}}"> 
    

    <!-- Google fonts -->

    <!-- Icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/ionicons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/linearicons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/open-iconic.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/pe-icon-7-stroke.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css')}}">
    <link rel="stylesheet" href="{{ asset('DataTables/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('DataTables/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css')}}">
    <!-- Core stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/shreerang-material.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.css')}}">

    <!-- Libs -->
    <link rel="stylesheet" href="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/libs/flot/flot.css')}}">
    <style type="text/css">
            .affichage {
            color: red;
            font-size:15px;
            text-align:center;
            }
      </style>

</head>

<body>
 
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
   
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
           
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-white logo-dark"> 
            </div>
          
            <div class="layout-container">
              
                <div class="layout-content">
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Page d'envois</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">   
                        </div>
                        <div class="card col-md-12">
                        <div class="card -header">
                        <div class="row">
                                <div class="col-lg-12">
                                   <div class="row">
                                        <div class="col-md-6">
                                        <h3 class="font-weight-bold py-3 mb-0">{{$heading}}</h3>
                                        <h3 class="font-weight-bold py-3 mb-0">{{$heading1}}</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 class="font-weight-bold py-3 mb-0">Date: {{$date}}</h3>
                                        </div>
                                  </div> 
                            </div> 
                        </div>     
                        </div>
                            <div class="card-body">
                            <h3 style="padding-left:35%;" class="font-weight-bold py-3 mb-0">{{$entete}}</h3>
                                <form action="#" method="POST">
                                <hr class="border-light container-m--x my-4">
                                <h3 style='text-align:center;' class="font-weight-bold py-3 mb-0">Information du Transfert</h3>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label class="form-label">Agence de l'envoie.</label>         
                                    <div class="input-group col-md-6">
                                                <input type="text" class="form-control"  name="agence" placeholder="" value='{{$agence}}'>
                                                <div class="clearfix"></div>
                                                </div>
                                     </div>
                                     <div class="form-group col-md-6"> 
                                     <label class="form-label">Vers la ville du Destination</label>         
                                                 <div class="input-group col-md-6">
                                                    <input type="text" class="form-control"  name="ville" placeholder="" id="name_transact" value="{{$ville}}">
                                                <div class="clearfix"></div>
                                                </div>
                                     </div>
                               </div>
                                <hr class="border-light container-m--x my-4">
                                <h3 style='text-align:center;' class="font-weight-bold py-3 mb-0">Information de l'expediteur</h3>  
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label class="form-label">Expediteur</label>         
                                    <div class="input-group col-md-6">
                                                <input type="text" class="form-control"  name="expediteur" placeholder="Expediteur" value='{{$expiditeur}}'>
                                                <div class="clearfix"></div>
                                                </div>
                                     </div>
                                     <div class="form-group col-md-6">
                                     <label class="form-label">Tel Exepediteur</label>          
                                                 <div class="input-group col-md-6">
                                                    <input type="text" class="form-control"  name="telexp" placeholder="" id="" value="{{$telexp}}" readonly>
                                                <div class="clearfix"></div>
                                                </div>
                                     </div>
                               </div>
                               <hr class="border-light container-m--x my-4">
                                <h3 style='text-align:center;' class="font-weight-bold py-3 mb-0">Information du beneficiaire</h3>  
                               <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label class="form-label">Nom du Beneficiaraire</label>         
                                    <div class="input-group col-md-6">
                                                <input type="text" class="form-control"  name="ben" placeholder="" value='{{$beneficiere}}'>
                                                <div class="clearfix"></div>
                                                </div>
                                     </div>
                                     <div class="form-group col-md-6"> 
                                     <label class="form-label">Tel Ben</label>        
                                                 <div class="input-group col-md-6">
                                                    <input type="text" class="form-control"  name="telexp" placeholder="" id="" value="{{$tel1}}" >
                                                <div class="clearfix"></div>
                                                </div>
                                     </div>
                               </div>
                               <hr class="border-light container-m--x my-4">
                                <h3 style='text-align:center;' class="font-weight-bold py-3 mb-0">Information du transfert</h3>  
                               <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label class="form-label">Numero Transfert</label>         
                                    <div class="input-group col-md-6">
                                                <input type="text" class="form-control"  name="transf" placeholder="" value='{{$trans}}'>
                                                <div class="clearfix"></div>
                                                </div>
                                     </div>
                                     <div class="form-group col-md-6"> 
                                     <label class="form-label">Date du Transfert</label>        
                                                 <div class="input-group col-md-6">
                                                    <input type="text" class="form-control"  name="date" placeholder="" id="" value="{{$date}}" >
                                                <div class="clearfix"></div>
                                                </div>
                                     </div>
                               </div>
                               <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label class="form-label">Montant Envoyé</label>         
                                    <div class="input-group col-md-6">
                                                <input type="text" class="form-control"  name="montant" placeholder="" value='{{$montant}}'>
                                                <div class="clearfix"></div>
                                                </div>
                                     </div>
                                     <div class="form-group col-md-6"> 
                                     <label class="form-label">Pourcentage</label>        
                                                 <div class="input-group col-md-6">
                                                    <input type="text" class="form-control"  name="date" placeholder="" id="" value="{{$montantcom}}" >
                                                <div class="clearfix"></div>
                                                </div>
                                     </div>
                               </div>
                                </form>
                            </div>
                        </div>
                        
                        
</div>

                    <!-- [ Layout footer ] End -->
                </div>
                <!-- [ Layout content ] Start -->
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper] End -->

    <!-- Core scripts -->
    <script src="{{ asset('assets/js/demo.js')}}"></script>
    <script src="{{ asset('assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/js/sidenav.js')}}"></script>
    <script src="{{ asset('assets/js/layout-helpers.js')}}"></script>
    <script src="{{ asset('assets/js/material-ripple.js')}}"></script>

    <!-- Libs -->
    <script src="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('assets/libs/eve/eve.js')}}"></script>
    <script src="{{ asset('assets/libs/flot/flot.js')}}"></script>
    <script src="{{ asset('assets/libs/flot/curvedLines.js')}}"></script>
    <script src="{{ asset('assets/libs/chart-am4/core.js')}}"></script>
    <script src="{{ asset('assets/libs/chart-am4/charts.js')}}"></script>
    <script src="{{ asset('assets/libs/chart-am4/animated.js')}}"></script>
    <script src="{{ asset('assets/js/demo.js')}}"></script>
    <script src="{{ asset('assets/js/analytics.js')}}"></script>
    <script src="{{ asset('assets/js/pages/dashboards_index.js')}}"></script>
    <script src="{{ asset('DataTables/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('DataTables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('js/dropzone.min.js')}}"></script>
    </body>

</html>

