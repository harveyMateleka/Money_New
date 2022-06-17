<!DOCTYPE html>
<html lang="en" class="material-style layout-fixed">
   <head>
      <title>La colombe MONEY</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
      <meta name="description" content="Empire Bootstrap admin template made using Bootstrap 4, it has tons of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
      <meta name="keywords" content="Empire, bootstrap admin template, bootstrap admin panel, bootstrap 4 admin template, admin template">
      <meta name="csrf-token" content="{{ csrf_token()}}">
      <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
      <!-- Google fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
      <!-- Icon fonts -->0
      <link rel="icon" type="text/css" href="../abt_app/public/colombelogo.jpeg">
      <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/ionicons.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/linearicons.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/open-iconic.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/pe-icon-7-stroke.css')}}">
      <ink rel="stylesheet" href="{{ asset('assets/fonts/feather.css')}}">
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
         font-size:15px;
         text-align:center;
         }
         .currency:after{ content: '.00'; }
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
                              <a href="{{url('admin/deconnexion')}}" class="dropdown-item">
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
    


      <script type="text/javascript">
         $(document).ready(function() { 
           

                         //   var phoneInputField = $("#tel_expedit").val();// document.querySelector("#tel_expedit");
                         // const phoneInput = window.intlTelInput(phoneInputField, {
                         //     preferredCountries: ["us", "co", "in", "de"],
                         //     utilsScript:
                         //       "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                         //   });

             affiche_ville();
             affiche_fonction();
             affiche_typedep();
             affiche_menu();
             affiche_smenu();
             affiche_droit();
             affiche_agent();
             affiche_users();
             affiche_affect();
             affiche_affectation();
             affiche_agence();
             affiche_personnel();
             affiche_taux();
             affiche_banque();
             affiche_agence1();
             affiche_mouvement();
             affiche_ong();
             affiche_ong1()
             affiche_partenaire();
             affiche_transfert_partenaire();
             @yield('script');
             
         });
         jQuery(function($) {  
             $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         
                }); 
              
         });





              //____________________________fin
              //___________________________debut fonction_________________________________
              $('#btnsave_fonction').click(function() { 
             var name_fonct=$("#name_fonction").val();
             if(name_fonct!=''){ 
                 if ($("#code_fonction").val()=='') {
                     swal({
                        title: 'Voulez vous ajouter une fonction?',
                        text: " est vous sure!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes,Ajouter!',
                        cancelButtonText: 'No, ANNULE!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false,
                        allowOutsideClick: false,
                        showLoaderOnConfirm: true,
                         preConfirm: function () {
                            return new Promise(function (resolve, reject) {
                         $.ajax({
                                    url   : "{{route('create_fonction')}}",
                                    type  : 'POST',
                                    async : false,
                                    data  : {name_fonction:name_fonct
                                    },
                                    success:function(data)
                                    {
                                        if(data.success=='1'){
                                            swal({title: 'ABT COLOMBE!',
                                            text: 'Un nauveau fonction ajouter avec success!',
                                            type: 'success'
                                            })
                                             window.location.href=("{{route('route_index_fonct')}}");
                                        }else{
                                             alert('existe deja');
                                        } 
                                    },
                                        error:function(data){
                                        alert(data.success);                              
                                    }
                                });
                        })
                    }
                    }).then(function () {
                        swal({
                            type: 'info',
                            title: 'ABT COLOMBE',
                            html: 'fonction ne pas ajouter'
                        })
                    });
                 }
         else{
                swal({
                title: 'Voulez vous modifier une fonction?',
                text: " est vous sure!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes,Modifier!',
                cancelButtonText: 'No, ANNULE!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                allowOutsideClick: false,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                return new Promise(function (resolve, reject) {
                     $.ajax({
                           url   : "{{route('update_fonction')}}",
                           type  : 'POST',
                           async : false,
                           data  : {fonction: $("#name_fonction").val(),
                                    code_fonction:$("#code_fonction").val(),
                           },
                           success:function(data)
                           {
                             if(data.success=='1'){
                                 swal({title: 'ABT COLOMBE!',
                        text: 'modification fonction avec success!',
                        type: 'success'
                        })
                                 affiche_fonction();
                                 $("#name_fonction").val("");
                                 $("#code_fonction").val("");
                                 //window.location.href=("{{route('route_index_fonct')}}");
                             }
                             else{
                                 alert('erreur de transaction');
                             }
                            
                           }
                       });
                    })
                }
      }).then(function () {
        swal({
            type: 'info',
            title: 'ABT COLOMBE',
            html: 'fonction n\'est  pas modifié'
        })
    });
                 }
                 
               
             }else{
        $("#mes_fonc").html("Veuillez saisir ce champ !");
   }
         });
         
         $('body').delegate('.modifier_fonction','click',function(){
                       var ids=$(this).data('id');
                       $.ajax({
                           url   : "{{route('get_id_f')}}",
                           type  : 'POST',
                           async : false,
                           data  : {code: ids
                           },
                           success:function(data)
                           {
                             $("#name_fonction").val(data.fonction);
                             $("#code_fonction").val(data.id_fonction);
                           }
                       });
              });
              $('body').delegate('.supprimer_fonction','click',function(){
                       var ids=$(this).data('id');
                       swal({
        title: 'Voulez supprimer le donnes dans la base de donnees?',
        text: "le donnes ne seront plus trouvables apres suppression!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,SUPRIMER!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                       $.ajax({
                           url   : "{{route('delete_fonction')}}",
                           type  : 'POST',
                           async : false,
                           data  : {code: ids
                           },
                           success:function(data)
                           {
                             if(data.success=='1'){
                                  swal({title: 'ABT COLOMBE!',
                text: 'compte fonction suprimer avec success!',
                type: 'success'
                })
                                 affiche_fonction();
                                 //window.location.href=("{{route('route_index_fonct')}}");
                             }
                             else{
                                 alert('erreur dans la suppression');
                             }
                           },
                           error:function(data){
         
                           alert(data.success);                              
                           }
                       });
            })
   }
 }).then(function () {
        swal({
            type: 'info',
            title: 'ABT COLOMBE',
            html: 'La fonction ne pas supprimer'
        })
    });
              });
         
         function affiche_ville()
         {
           var otableau=$('#tab_ville').DataTable({
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_ville')}}",
                 "columns":[
                     {"data":'id_ville'},
                     {"data":'ville'},
                     {"data":'initial'},
                     {"data":'id_ville',"autoWidth":true,"render":function (data) {
         
                             return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_ville" ><i class="fa fa-times"></i></button>'+ ' ' +
                                 '<button data-id='+data+' class="btn btn-info btn-circle modifier_ville" ><i class="fa fa-check"></i></button>';
                         }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
           function affiche_ong()
    {
    var otableau=$('#tab_save_ong').DataTable({
        dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
        "bProcessing":true,
        "sAjaxSource":"{{route('charger_ong')}}",
        "columns":[
            {"data":'id'},
            {"data":'created_at'},
            {"data":'name_ong'},
             {"data":'devise',"autoWidth":true,"render":function (data){
                   if (data==2) {
                        return 'CDF';
                    }else{
                        return 'USD';
                    }
                      }},
            {"data":'mont_trans'},
            {"data":'taux'},
            {"data":'mont_com'},
            {"data":'mont_dep'},
            
                {"data":'montpayé',"autoWidth":true,"render":function (data){
                   if (data==null) {
                        return 0;
                    }else{
                        return data;
                    }
                      }},
                 // {"data":'type',"autoWidth":true,"render":function (data){
                 //   if (data==1) {
                 //        return 'Agence';
                 //    }else{
                 //        return 'Banque';
                 //    }
                 //      }},
            {"data":'id',"autoWidth":true,"render":function (data) {
                return '<button data-id='+data+' class="btn btn-info btn-circle modifier_desa" ><i class="fa fa-check"></i></button>';
                }}
        ],
        "bDestroy":true
    }); 
    }
         
         function affiche_fonction()
         {
           var otableau=$('#tab_fonction').DataTable({
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_f')}}",
                 "columns":[
                     {"data":'id_fonction'},
                     {"data":'fonction'},
                     {"data":'dates'},
                     {"data":'id_fonction',"autoWidth":true,"render":function (data) {
         
                             return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_fonction" ><i class="fa fa-times"></i></button>'+ ' ' +
                                 '<button data-id='+data+' class="btn btn-info btn-circle modifier_fonction" ><i class="fa fa-check"></i></button>';
                         }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
         
         function affiche_partenaire()
         {
           var otableau=$('#tab_partenaire').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_partenaire')}}",
                 "columns":[
                     {"data":'id_partenaire'},
                     {"data":'type'},
                     {"data":'id_partenaire',"autoWidth":true,"render":function (data) {
                          return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_partenaire" ><i class="fa fa-times"></i></button>'+ ' ' +
                             '<button data-id='+data+' class="btn btn-info btn-circle modifier_partenaire" ><i class="fa fa-check"></i></button>';
                     }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
         
         function affiche_typedep()
         {
           var otableau=$('#tab_typedep').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_typedep')}}",
                 "columns":[
                     {"data":'id_typdep'},
                     {"data":'type_dep'},
                     {"data":'dates'},
                     {"data":'id_typdep',"autoWidth":true,"render":function (data) {
         
                             return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_typedep" ><i class="fa fa-times"></i></button>'+ ' ' +
                                 '<button data-id='+data+' class="btn btn-info btn-circle modifier_typedep" ><i class="fa fa-check"></i></button>';
                         }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         } 
         function affiche_menu()
         {
           var otableau=$('#tab_menu').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_menu')}}",
                 "columns":[
                     {"data":'id_menu'},
                     {"data":'item_menu'},
                     {"data":'icon'},
                     {"data":'dates'},
                     {"data":'id_menu',"autoWidth":true,"render":function (data) {
         
                             return '<button data-id='+data+' class="btn btn-info btn-circle modifier_menu" ><i class="fa fa-check"></i></button>';
                         }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true,
                 responsive:true
             });
         
         } 
         function affiche_smenu()
         {
           var otableau=$('#tab_smenu').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_smenu')}}",
                 "columns":[
                     {"data":'id_sous'},
                     {"data":'item_menu'},
                     {"data":'item_sous'},
                     {"data":'lien'},
                     {"data":'dates'},
                     {"data":'id_sous',"autoWidth":true,"render":function (data) {
         
                             return '<button data-id='+data+' class="btn btn-info btn-circle modifier_smenu" ><i class="fa fa-check"></i></button>';
                         }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
         
         function affiche_droit()
         {
           var otableau=$('#tab_droit').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_list_droit')}}",
                 "columns":[
                     {"data":'id_droit'},
                     {"data":'item_sous'},
                     {"data":'fonction'},
                     {"data":'id_droit',"autoWidth":true,"render":function (data) {
                         return'<input type="checkbox" checked data-id='+data+' class=" supprimer_droit"/>';
                         }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
         
         function affiche_agent()
         {
           var otableau=$('#tab_personnelle').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_agent')}}",
                 "columns":[
                     {"data":'matricule'},
                     {"data":'nom'},
                     {"data":'postnom'},
                     {"data":'prenom'},
                     {"data":'matricule',"autoWidth":true,"render":function (data) {
                         return'<button data-id='+data+' class="btn btn-info btn-circle afficher_matr" ><i class="fa fa-check"></i></button>';
                         }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
         
         function affiche_agence1()
         {
         var otableau=$('#tab_agence1').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"{{route('get_list_agence')}}",
             "columns":[
                 {"data":'numagence'},
                 {"data":'nomagence'},
                 {"data":'telservice'},
                 {"data":'Montcdf'},
                 {"data":'Montusd'},
                 {"data":'numagence',"autoWidth":true,"render":function (data) {
                         return'<button data-id='+data+' class="btn btn-info btn-circle modifier_agence1" ><i class="fa fa-check"></i></button>';
                     }}
             ],
             "pageLength": 10,
             "bDestroy":true
         });
         
         }
         
         function affiche_affect()
         {
           var otableau=$('#tab_person').DataTable({
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_affectation')}}",
                 "columns":[
                     {"data":'matricule'},
                     {"data":'nom'},
                     {"data":'postnom'},
                     {"data":'prenom'},
                     {"data":'matricule',"autoWidth":true,"render":function (data) {
                         return'<button data-id='+data+' class="btn btn-info btn-circle afficher_matri" ><i class="fa fa-check"></i></button>';
                         }}
                 ],
                 "pageLength": 5, 
                 "bDestroy":true
             });
         
         }
         function affiche_affectation()
         {
           var otableau=$('#tab_affectation').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_afectation')}}",
                 "columns":[
                     {"data":'id'},
                     {"data":'nomagence'},
                     {"data":'matricule'},
                     {"data":'nom'},
                     {"data":'postnom'},
                     {"data":'prenom'},
                     {"data":'created_at'},
                     {"data":'id',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_aff" ><i class="fa fa-times"></i></button>';
                          }}
                 ],
                 "pageLength": 5, 
                 "bDestroy":true
             });
         
         }
         
         
         function affiche_entree(code_agence)
         {
           var otableau=$('#tab_entree').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"/admin/liste_agence="+code_agence,
                 "columns":[
                     {"data":'created_at'},
                     {"data":'numdepot'},
                     {"data":'nomagence'},
                     {"data":'ville'},
                     {"data":'montenvoi'},
                      {"data":'intitule'},
                     {"data":'montpour'},
                    
                     
                     {"data":'id',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-warning btn-circle print" >Print</button>';
                          }}
                    
                 ],
                 "pageLength": 10, 
                 "bDestroy":true,
                 responsive:true,
             });
         
         }
         function affiche_sortie(code_agence)
         {
           var otableau=$('#tab_sortie').DataTable({
                 "bProcessing":true,
                 "sAjaxSource":"/admin/liste_sortie="+code_agence,
                 "columns":[
                     {"data":'id'},
                     {"data":'created_at'},
                     {"data":'nomagence'},
                     {"data":'ville'},
                     {"data":'montenvoi'},
                     {"data":'intitule'},
                     {"data":'id',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-info btn-circle aff_sortie" ><i class="fa fa-check"></i></button>';
                          }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true,
                 "responsive": true
             });
         
         }
         function affiche_mouvement()
         {
           var otableau=$('#tab_mouvement').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
                 "bProcessing":true,
                 "sAjaxSource":"{{route('get_mvt')}}",
                 "columns":[
                     {"data":'id'},
                     {"data":'detail_prov'},
                     {"data":'detail_des'},
                     {"data":'etatmvt',"autoWidth":true,"render":function (data){
                         if (data==0) {   
                             return 'Suspense';
                         }
                     }},
                     {"data":'Montmvt'},
                     {"data":'devise',"autoWidth":true,"render":function (data){
                         if (data==1) {   
                             return 'Usd';
                         }
                         else{
                             return 'Cdf';
                         }
                     }},
                     {"data":'created_at'},
                     {"data":'id',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-info btn-circle update" ><i class="fa fa-check">Confirmer</i></button>';
                          }}
                 ],
                 "pageLength": 10, 
                 "bDestroy":true
             });
         
         }
         
         function affiche_banque()
         {
         var otableau=$('#tab_banque').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"{{route('get_list_banque')}}",
             "columns":[
                 {"data":'id'},
                 {"data":'numero_compte'},
                 {"data":'intitulecompte'},
                {"data":'devise',"autoWidth":true,"render":function (data){
                        if (data!=1 ) {
                             return 'cdf';
                         }else{
                             return 'Usd'
                         }
         
                 }},
                 {"data":'Montant'},
                 {"data":'id',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_banque" ><i class="fa fa-times"></i></button>'+ ' ' +
                             '<button data-id='+data+' class="btn btn-info btn-circle modifier_banque" ><i class="fa fa-check"></i></button>';
                     }}
             ],
             "pageLength": 10,
             "bDestroy":true
         });
         
         }
         function affiche_users() {
            var otableau = $('#tab_users').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print', 'copy', 'excel', 'pdf'
                ],
                "bProcessing": true,
                "sAjaxSource": "{{route('get_list_users')}}",
                "columns": [{
                        "data": 'id'
                    },
                    {
                        "data": 'nom'
                    },
                    {
                        "data": 'email'
                    },
                    {
                        "data": 'etatcon',
                        "autoWidth": true,
                        "render": function(data) {
                            if (data != '0') {
                                return 'Connecté';
                            } else {
                                return 'Deconnecté';
                            }
                        }
                    },
                    {
                        "data": 'id',
                        "autoWidth": true,
                        "render": function(data) {
                            return `
                                <button data-id=${data} class="btn btn-danger btn-circle supprimer_users" ><i class="fa fa-trash"></i></button> 
                                <button data-id=${data} class="btn btn-success btn-circle editUser" ><i class="fa fa-edit"></i></button>
                            `;
                        }
                    }
                ],
                "pageLength": 7,
                "bDestroy": true
            });
        }
         function affiche_agence()
         {
         var otableau=$('#tab_agence').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"{{route('get_list_agence')}}",
             "columns":[
                 {"data":'numagence'},
                 {"data":'nomagence'},
                 {"data":'adresse'},
                 {"data":'telservice'},
                 {"data":'indiceag'},
                 {"data":'initial'},
                 {"data":'numagence',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_agence" ><i class="fa fa-times"></i></button>'+ ' ' +
                             '<button data-id='+data+' class="btn btn-info btn-circle modifier_agence" ><i class="fa fa-check"></i></button>';
                     }}
             ],
             "pageLength": 10,
             "bDestroy":true
         });
         
         }
         



               function affiche_transfert_partenaire()
         {
         var otableau=$('#transfert').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"{{route('get_list_transfert')}}",
             "columns":[
                 {"data":'date_T'},
                 {"data":'nomagence'},
                 {"data":'matricule'},
                  {"data":'type'},
                  {"data":'montant'},
                 {"data":'intitule'},
                 {"data":'operation',"autoWidth":true,"render":function (data){
                       if (data!='1') {
                             return 'depot';
                         }else{
                             return 'retrait';
                         }
                 }},
             ],
             "pageLength": 10,
             "bDestroy":true
         });
         
         }

  
         function affiche_personnel()
         {

         var otableau=$('#tab_personnel').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"{{route('get_list_personnel')}}",
             "columns":[
                 {"data":'matricule'},
                 {"data":'nom'},
                 {"data":'prenom'},
                 {"data":'adresse'},
                 {"data":'tel'},
                 {"data":'occupation',"autoWidth":true,"render":function (data){
                       if (data!='0') {
                             return 'Agence';
                         }else{
                             return 'Direction';
                         }
                 }},
                 {"data":'fonction'},
                 {"data":'etat',"autoWidth":true,"render":function (data){
                        if (data==1) {
                             return 'actif';
                         }
                         else if(data==2){
                             return 'Conge'; 
                         }else{
                             return 'licencie'
                         }
         
                 }},
                 {"data":'matricule',"autoWidth":true,"render":function (data) {
         
                         return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_personnel" ><i class="fa fa-times"></i></button>'+ ' ' +
                             '<button data-id='+data+' class="btn btn-info btn-circle modifier_personnel" ><i class="fa fa-check"></i></button>';
                     }}
             ],
             "pageLength": 10, 
             "bDestroy":true
         });
         
         }
         function affiche_taux()
         {
         var otableau=$('#tab_taux').DataTable({
             dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"{{route('get_list_taux')}}",
             "columns":[
                 {"data":'id'},
                 {"data":'intitule'},
                 {"data":'taux'},
                 {"data":'dates'},
                 {"data":'id',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_taux" ><i class="fa fa-times"></i></button>'+ ' ' +
                             '<button data-id='+data+' class="btn btn-info btn-circle modifier_taux" ><i class="fa fa-check"></i></button>';
                     }}
             ],
             "pageLength": 10,
             "bDestroy":true
         }); 
         }
         
       function affiche_depense(cod_agence)
         {
         var otableau=$('#tab_depense').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"/admin/liste_depense="+ cod_agence,
             "columns":[
                 {"data":'id_dep'},
                 {"data":'motif'},
                 {"data":'devise',"autoWidth":true,"render":function (data){
                        if (data==2) {
                             return 'CDF';
                         }else{
                             return 'USD';
                         }
                           }},
                     {"data":'matricule'},
                     {"data":'montant'},
                      {"data":'etat',"autoWidth":true,"render":function (data){
                        if (data==1) {
                             return 'Approuve';
                         }else{
                             return 'Not Approuve';
                         }
                           }},
                     {"data":'id_auto',"autoWidth":true,"render":function (data){
                        if (data==1) {
                             return 'PDG';
                         }
                         else if(data==2){
                             return 'DGA'; 
                         }else if(data==3){
                             return 'DG';
                         }else {
                             return'ENTREPRISE'
                         }
         
                 }},
                 {"data":'id_dep',"autoWidth":true,"render":function (data) {
                         return '<button data-id='+data+' class="btn btn-info btn-circle modifier_depense" ><i class="fa fa-check"></i></button>';
                     }}
         
             ],
             "pageLength": 10,
             "bDestroy":true
         }); 
         }
        
         function formateIndianCurrency(rupees) {
           let value = OSREC.CurrencyFormatter.format(rupees, { currency: 'EUR', locale: 'fr' });
           return value;
         }



          function affiche_ong1()
         {
         var otableau=$('#tab_ong1').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
             "bProcessing":true,
             "sAjaxSource":"{{route('get_list_ongc')}}",
             "columns":[
                 {"data":'id'},
                 {"data":'name_ong'},
                 {"data":'name_Perso'},
                 {"data":'tel_contact'},
                 {"data":'adresse_siege'},
                 {"data":'id',"autoWidth":true,"render":function (data) 
                 {return '<button data-id='+data+' class="btn btn-danger btn-circle supprimer_ong1"><i class="fa fa-times"></i></button>'+ ' ' +
                             '<button data-id='+data+' class="btn btn-info btn-circle modifier_ong1"><i class="fa fa-check"></i></button>';
                     }}
             ],
             "pageLength": 10,
             "bDestroy":true
         }); 
         }
      </script>
   </body>
</html>