@extends('layouts.login')
@section('login')
<!-- [ Preloader ] End -->
<!-- [ content ] Start -->

<div class="authentication-wrapper authentication-1 ">
    <div class="authentication-inner">
        
        <div class="card" style="width: 18rem;">
    <div class="card-body">
        <!-- [ Logo ] Start -->
        <h2 class="mt-4" style="text-align:center">S'authentifier</h2>
        <div style=" text-align:center; ">

            <img src="{{ URL::to('../abt_app/public/colombelogo.jpeg') }}" alt="Logo Lacolombe" style="max-width:100%; 
            width: 40%; border-radius:100%; ">
        </div>
        <hr />

        <!-- [ Logo ] End -->
           
        <!-- [ Form ] Start -->
        <form class="my-3" action="{{route('create_login')}}" method="POST">
            {{ csrf_field() }}
            @if(empty($message))
            @else
            <div class="alert alert-danger" style="color: black">{{$message}}</div>
            @endif
            <div class="form-group">
                <input type="text" class="form-control" id="email" name="email" placeholder="Renseigner votre adresse email">
               
            </div>
            <div class="form-group">
                <input type="password" class="form-control fadeIn second" id="password" name="password" placeholder="Renseigner votre mot de passe ">
               
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <label class="custom-control custom-checkbox ">
                   
                </label>
                <button type="submit" class="btn btn-success" name="login" id='login' style='margin-bottom: 40px; margin-top:10px'>
                    Se Connecter</button>
            </div>
        </form>
        <!-- [ Form ] End -->
    </div>
</div>

</div>
</div>
<!-- meme une horloge en pangne donne lheure deux fois par jours-->
@endsection