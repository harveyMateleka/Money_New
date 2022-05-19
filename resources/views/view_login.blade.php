@extends('layouts.login')
@section('login')
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->
    <!-- [ content ] Start -->
    <div class="authentication-wrapper authentication-1 px-4">
        <div class="authentication-inner">

        <div class="card" style="width: 18rem;">
    <div class="card-body">
        <!-- [ Logo ] Start -->
        <h2 class="mt-4" style="text-align:center">S'authentifier</h2>
        <div style=" text-align:center; ">

            <!-- [ Logo ] Start -->
            
            <img src="{{ URL::to('../abt_app/public/colombelogo.jpeg') }}" alt="Logo Lacolombe" style="max-width:100%; 
            width: 40%; border-radius:100%; ">

</div>
        <hr />
            
            <!-- [ Logo ] End -->

            <!-- [ Form ] Start -->
            <form class="my-5" action="{{route('login')}}" method="POST">
                {{ csrf_field() }}
                        @if(empty($message))
                        @else
                        <p style="font-size :10px; color:red"> {{$message}}</p>
                        @endif
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Saisir votre email">
                    <div class="clearfix" style="color: red; font-size:15px;">
                         @error('email')
                             {{$message}}
                        @enderror

                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label d-flex justify-content-between align-items-end">
                        <span>Mot de passe</span>
                    </label>
                    <input type="password" class="form-control fadeIn second" id="password" name="password" placeholder="Saisir votre mot de passe">
                    
                   <div class="clearfix" style="color: red; font-size:15px;">
                         @error('password')
                             {{$message}}
                        @enderror

                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center m-0">
                    <button type="submit" class="btn btn-success" name="login" id='login'>Se connecter</button>
                </div>
            </form>
            <!-- [ Form ] End -->
        </div>
    </div>

    </div>
</div>
    <!-- meme une horloge en pangne donne lheure deux fois par jours-->
@endsection
