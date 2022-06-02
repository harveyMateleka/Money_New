<!DOCTYPE html>
<html lang="en" class="material-style layout-fixed">

<head>
   <title>La colombe MONEY</title>
   <meta charset="utf-8">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
   <meta name="description" content="Empire Bootstrap admin template made using Bootstrap 4, it has tons of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
   <meta name="keywords" content="Empire, bootstrap admin template, bootstrap admin panel, bootstrap 4 admin template, admin template">
   <meta name="csrf-token" content="{{ csrf_token()}}">
   <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
   <!-- Google fonts -->
   <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
   <!-- Icon fonts -->
   <link rel="icon" type="text/css" href="../abt_app/public/colombelogo.jpeg">
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
   <link rel="stylesheet" href="{{ asset('css/select2.min.css')}}">
   <!-- Libs -->
   <link rel="stylesheet" href="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
   <link rel="stylesheet" href="{{ asset('assets/libs/flot/flot.css')}}">

   <link rel="stylesheet" href=" https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href=" https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">


   <style type="text/css">
      .affichage {
         color: red;
         font-size: 15px;
         text-align: center;
      }

      .currency:after {
         content: '.00';
      }
   </style>
</head>

<body>
   <!-- [ Preloader ] Start -->
   <div class="page-loader">
      <div class="bg-primary"></div>
   </div>
   <!-- [ Preloader ] End -->
   <!-- [ Layout wrapper ] Start -->
   <div class="layout-wrapper layout-2">
      <div class="layout-inner">
         <!-- [ Layout sidenav ] Start -->
         <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-white logo-dark">
            <!-- Brand demo (see assets/css/demo/demo.css) -->
            <div class="app-brand demo">
               <span class="app-brand-logo demo">
                  <img src="{{ URL::to('../abt_app/public/colombelogo.jpeg') }}" style="border : 5px; 
  border-radius: 50%;
  padding: 0px;
  width: 100px;" alt="Brand Logo" class="img-fluid">
               </span>
               <a href="index.html" class="app-brand-text demo sidenav-text font-weight-normal ml-2"></a>
               <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
                  <i class="ion ion-md-menu align-middle"></i>
               </a>
            </div>
            <div class="sidenav-divider mt-0"></div>
            <!-- Links -->
            <ul class="sidenav-inner py-1">
               <!-- Dashboards -->
               <li class="sidenav-item active">
                  <a href="{{route('index')}}" class="sidenav-link">
                     <i class="sidenav-icon feather icon-home"></i>
                     <div>ACCUEIL</div>
                  </a>
               </li>
               @php
               $var=0;
               $var1=count($donnees);
               $indice=1
               @endphp
               @foreach($donnees as $ligne_donnes)
               @if($var==0)
               @php
               $var= $ligne_donnes->id_menu;
               @endphp
               <li class="sidenav-divider mb-1"></li>
               <li class="sidenav-item">
                  <a href="javascript:" class="sidenav-link sidenav-toggle ">
                     <i class="{!! $ligne_donnes->icon !!}"></i>
                     <div>{!! $ligne_donnes->item_menu !!}</div>
                  </a>
                  <ul class="sidenav-menu">
                     <li class="sidenav-item">
                        <a href="{{route($ligne_donnes->lien)}}" class="sidenav-link ">
                           <div>{!! $ligne_donnes->item_sous !!}</div>
                        </a>
                     </li>
                     @elseif($ligne_donnes->id_menu==$var)
                     <li class="sidenav-item">
                        <a href="{{route($ligne_donnes->lien)}}" class="sidenav-link">
                           <div>{!! $ligne_donnes->item_sous !!}</div>
                        </a>
                     </li>
                     @if($indice==$var1)
                  </ul>
               </li>
               @endif
               @else
            </ul>
            </li>
            @php
            $var= $ligne_donnes->id_menu;
            @endphp
            <li class="sidenav-divider mb-1"></li>
            <li class="sidenav-item">
               <a href="javascript:" class="sidenav-link sidenav-toggle">
                  <i class="{!! $ligne_donnes->icon !!}"></i>
                  <div>{!! $ligne_donnes->item_menu !!}</div>
               </a>
               <ul class="sidenav-menu">
                  <li class="sidenav-item">
                     <a href="{{route($ligne_donnes->lien)}}" class="sidenav-link">
                        <div>{!! $ligne_donnes->item_sous !!}</div>
                     </a>
                  </li>
                  @if($indice==count($donnees))
               </ul>
            </li>
            @endif
            @endif
            @php
            ++$indice;
            @endphp
            @endforeach
            </ul>
         </div>
         <!-- [ Layout sidenav ] End -->
         <!-- [ Layout container ] Start -->
         <div class="layout-container">
            <!-- [ Layout navbar ( Header ) ] Start -->
            <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-dark container-p-x" id="layout-navbar">
               <!-- Brand demo (see assets/css/demo/demo.css) -->

               <!-- Sidenav toggle (see assets/css/demo/demo.css) -->
               <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
                  <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
                     <i class="ion ion-md-menu text-large align-middle"></i>
                  </a>
               </div>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
                  <span class="navbar-toggler-icon"></span>
               </button>
               <div class="navbar-collapse collapse" id="layout-navbar-collapse">
                  <!-- Divider -->
                  <hr class="d-lg-none w-100 my-2">
                  <div class="navbar-nav align-items-lg-center">
                     <!-- Search -->
                     <!-- <label class="nav-item navbar-text navbar-search-box p-0 active">
                        <i class="feather icon-search navbar-icon align-middle"></i>
                        <span class="navbar-search-input pl-2">
                        <input type="text" class="form-control navbar-text mx-2" placeholder="Search...">
                        </span>
                        </label> -->
                  </div>
                  <div class="navbar-nav align-items-lg-center ml-auto">
                     <div class="demo-navbar-notifications nav-item dropdown mr-lg-3">
                        <a class="nav-link dropdown-toggle hide-arrow" href="#" data-toggle="dropdown">
                           <i class="feather icon-bell navbar-icon align-middle"></i>
                           <span class="badge badge-danger badge-dot indicator"></span>
                           <span class="d-lg-none align-middle">&nbsp; Notifications</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                           <div class="bg-primary text-center text-white font-weight-bold p-3">
                              4 New Notifications
                           </div>
                           <div class="list-group list-group-flush">
                              <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                 <div class="ui-icon ui-icon-sm feather icon-home bg-secondary border-0 text-white"></div>
                                 <div class="media-body line-height-condenced ml-3">
                                    <div class="text-dark">Login from 192.168.1.1</div>
                                    <div class="text-light small mt-1">
                                       Aliquam ex eros, imperdiet vulputate hendrerit et.
                                    </div>
                                    <div class="text-light small mt-1">12h ago</div>
                                 </div>
                              </a>
                              <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                 <div class="ui-icon ui-icon-sm feather icon-user-plus bg-info border-0 text-white"></div>
                                 <div class="media-body line-height-condenced ml-3">
                                    <div class="text-dark">You have
                                       <strong>4</strong> new followers
                                    </div>
                                    <div class="text-light small mt-1">
                                       Phasellus nunc nisl, posuere cursus pretium nec, dictum vehicula tellus.
                                    </div>
                                 </div>
                              </a>
                              <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                 <div class="ui-icon ui-icon-sm feather icon-power bg-danger border-0 text-white"></div>
                                 <div class="media-body line-height-condenced ml-3">
                                    <div class="text-dark">Server restarted</div>
                                    <div class="text-light small mt-1">
                                       19h ago
                                    </div>
                                 </div>
                              </a>
                              <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                 <div class="ui-icon ui-icon-sm feather icon-alert-triangle bg-warning border-0 text-dark"></div>
                                 <div class="media-body line-height-condenced ml-3">
                                    <div class="text-dark">99% server load</div>
                                    <div class="text-light small mt-1">
                                       Etiam nec fringilla magna. Donec mi metus.
                                    </div>
                                    <div class="text-light small mt-1">
                                       20h ago
                                    </div>
                                 </div>
                              </a>
                           </div>
                           <a href="javascript:" class="d-block text-center text-light small p-2 my-1">Show all notifications</a>
                        </div>
                     </div>
                     <div class="demo-navbar-messages nav-item dropdown mr-lg-3">
                        <a class="nav-link dropdown-toggle hide-arrow" href="#" data-toggle="dropdown">
                           <i class="feather icon-mail navbar-icon align-middle"></i>
                           <span class="badge badge-success badge-dot indicator"></span>
                           <span class="d-lg-none align-middle">&nbsp; Messages</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                           <div class="bg-primary text-center text-white font-weight-bold p-3">
                              4 New Messages
                           </div>
                           <div class="list-group list-group-flush">
                              <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                 <img src="assets/img/avatars/6-small.png" class="d-block ui-w-40 rounded-circle" alt>
                                 <div class="media-body ml-3">
                                    <div class="text-dark line-height-condenced">Lorem ipsum dolor consectetuer elit.</div>
                                    <div class="text-light small mt-1">
                                       Josephin Doe &nbsp;·&nbsp; 58m ago
                                    </div>
                                 </div>
                              </a>
                              <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                 <img src="assets/img/avatars/4-small.png" class="d-block ui-w-40 rounded-circle" alt>
                                 <div class="media-body ml-3">
                                    <div class="text-dark line-height-condenced">Lorem ipsum dolor sit amet, consectetuer.</div>
                                    <div class="text-light small mt-1">
                                       Lary Doe &nbsp;·&nbsp; 1h ago
                                    </div>
                                 </div>
                              </a>
                              <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                 <img src="assets/img/avatars/5-small.png" class="d-block ui-w-40 rounded-circle" alt>
                                 <div class="media-body ml-3">
                                    <div class="text-dark line-height-condenced">Lorem ipsum dolor sit amet elit.</div>
                                    <div class="text-light small mt-1">
                                       Alice &nbsp;·&nbsp; 2h ago
                                    </div>
                                 </div>
                              </a>
                              <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                 <img src="assets/img/avatars/11-small.png" class="d-block ui-w-40 rounded-circle" alt>
                                 <div class="media-body ml-3">
                                    <div class="text-dark line-height-condenced">Lorem ipsum dolor sit amet consectetuer amet elit dolor sit.</div>
                                    <div class="text-light small mt-1">
                                       Suzen &nbsp;·&nbsp; 5h ago
                                    </div>
                                 </div>
                              </a>
                           </div>
                           <a href="javascript:" class="d-block text-center text-light small p-2 my-1">Show all messages</a>
                        </div>
                     </div>
                     <!-- Divider -->
                     <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
                     <div class="demo-navbar-user nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                           <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                              <img src="../abt_app/public/img/image_user/{{Auth::user()->image}}" height="100" width="100" style="border-radius: 100%;" alt class="d-block ui-w-30 rounded-circle">
                              <span class="px-1 mr-lg-2 ml-2 ml-lg-0">
                                 @Auth
                                 {{Auth::user()->name}}
                                 @else
                                 @endAUth
                              </span>
                           </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                           <a href="{{ url('admin/profil') }}" class="dropdown-item">
                              <i class="feather icon-user text-muted"></i> &nbsp; Mon profile</a>

                           <div class="dropdown-divider"></div>
                           <a href="{{ route('logout') }}" class="dropdown-item">
                              <i class="feather icon-power text-danger"></i> &nbsp; Deconnexion</a>
                        </div>
                     </div>
                  </div>
               </div>
            </nav>
            <div class="layout-content">
               <div class="modal fade" id="modal_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="modal_messagelabel">Agence Baudouin Transfert</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div id="affichage_message" class="affichage">
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">ok</button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal fade" id="modal_personnel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">LISTE DES AGENTS</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <table class="table card-table" id='tab_personnelle'>
                              <thead class="thead-light">
                                 <tr>
                                    <th>Matricule</th>
                                    <th>Nom</th>
                                    <th>PostNom</th>
                                    <th>Prenom</th>
                                    <th>ACTION</th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                     </div>
                  </div>
               </div>
               @yield('content')
               <!-- [ content ] End -->
               <!-- [ Layout footer ] Start -->
               <nav class="layout-footer footer bg-white">
                  <div class="container-fluid d-flex flex-wrap justify-content-between text-center container-p-x pb-3">
                     <div class="pt-3">
                        <span class="footer-text font-weight-semibold">&copy; <a href="" class="footer-link" target="_blank">LA COLOMBE MONEY@2021</a></span>
                     </div>
                     <div>
                        <!-- <a href="javascript:" class="footer-link pt-3">About Us</a>
                              <a href="javascript:" class="footer-link pt-3 ml-4">Help</a>
                              <a href="javascript:" class="footer-link pt-3 ml-4">Contact</a>
                              <a href="javascript:" class="footer-link pt-3 ml-4">Terms &amp; Conditions</a>-->
                     </div>
                  </div>
               </nav>
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
   <script src="{{url('/assets/js/sweet_alert_2.js')}}"></script>
   <script src="{{url('/assets/js/chart.min.js')}}"></script>
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
   <script src="{{ asset('js/select2.min.js')}}"></script>
   <script src="{{ asset('currencyFormatter/currencyFormatter.js')}}"></script>

   <!--a ajouter dans herve -->
   <script src=" https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
   <script src="https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js"></script>

   <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

   <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
   <script src="https://osrec.github.io/currencyFormatter.js"></script>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   @yield('javascript')
   <script type="text/javascript">
      (function() {
         affiche_agent();
      })();

      function affiche_agent() {
         var otableau = $('#tab_personnelle').DataTable({
            dom: 'Bfrtip',
            buttons: [
               'print', 'copy', 'excel', 'pdf'
            ],
            "bProcessing": true,
            "sAjaxSource": "{{route('get_affectation')}}",
            "columns": [{
                  "data": 'matricule'
               },
               {
                  "data": 'nom'
               },
               {
                  "data": 'postnom'
               },
               {
                  "data": 'prenom'
               },
               {
                  "data": 'matricule',
                  "autoWidth": true,
                  "render": function(data) {
                     return '<button data-id=' + data + ' class="btn btn-info btn-circle afficher_matr" ><i class="fa fa-check"></i></button>';
                  }
               }
            ],
            "pageLength": 10,
            "bDestroy": true
         });

      }

      function formateIndianCurrency(rupees) {
         let value = OSREC.CurrencyFormatter.format(rupees, {
            currency: 'EUR',
            locale: 'fr'
         });
         return value;
      }
   </script>


</body>

</html>