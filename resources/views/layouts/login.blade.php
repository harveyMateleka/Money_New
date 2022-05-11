<!DOCTYPE html>
<html lang="en" class="material-style layout-fixed">
   <head>
      <title>La Colombe Money</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="csrf-token" content="{{ csrf_token()}}">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
      <meta name="description" content="Empire Bootstrap admin template made using Bootstrap 4, it has tons of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
      <meta name="keywords" content="Empire, bootstrap admin template, bootstrap admin panel, bootstrap 4 admin template, admin template">
      <meta name="author" content="Srthemesvilla" />
      <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
      <!-- Google fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
      <!-- Icon fonts -->
      <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/ionicons.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/linearicons.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/open-iconic.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/pe-icon-7-stroke.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css')}}">
      <!-- Core stylesheets -->
      <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/css/shreerang-material.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/css/uikit.css')}}">
      <!-- Libs -->
      <link rel="stylesheet" href="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
      <!-- Page -->
      <link rel="stylesheet" href="{{ asset('assets/css/pages/authentication.css')}}">
   </head>
   <body>
  <div class="modal fade" id="modal_oublie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="modal_update">Mot de Passe oublié</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            <form action="#" method="POST">
            {{csrf_field()}}
            <div class="form-row">
            <div id="message" style='color:red; font-size:15px;'>

            </div>
            <div class="form-group col-md-6">
                  <input type="text" class="form-control" name="email_oublie" placeholder="Veuillez saisir votre email" id="name_email" data-validation="required">
                  <div class="clearfix"></div>
            </div>
            <div class="form-group col-md-4">
                 <button type="button" class="btn btn-success" id='btn_send'>Envoyez</button>
            </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
                  <input type="text" class="form-control" name="new_pass" placeholder="" id="new_pass" data-validation="required" readonly>
                  <div class="clearfix"></div>
            </div>
            </div>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn_update">Modifier</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
  </div>
</div>
      @yield('login')
      <script src="{{ asset('assets/js/demo.js')}}"></script>
      <script src="{{ asset('assets/js/jquery-3.2.1.min.js')}}"></script>
      <script src="{{ asset('assets/js/bootstrap.js')}}"></script>
      <script src="{{ asset('assets/libs/popper/popper.js')}}"></script>
      
     
   <script type="text/javascript">
    $(document).ready(function() { 
      $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         
                }); 

      $('#checking').change(function(){
         if(document.getElementById("checking").checked){
          $('#modal_oublie').modal('show');
    }

    $('#btn_update').click(function(){

    });

    $('#btn_send').click(function(){
        if ($('#name_email').val()!='') {
          $.ajax({
            url:"{{route('email_oublie')}}",
            type:'POST',
            async:false,
            data:{
              email_oublie:$('#name_email').val()
              },
              success:function (data){
                if (data.success=='1') {
                  $("#new_pass").val(data.new_passe);
                } else {
                    $("#message").html("votre adresse email est invalide");
                }
              }
          });
        }
     });

});  
    });
   </script>
   </body>
</html>