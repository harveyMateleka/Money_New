@extends('layouts.login')
@section('login')
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->
    <!-- [ content ] Start -->
    <div class="authentication-wrapper authentication-1 px-4">
        <div class="authentication-inner py-5">

            <!-- [ Logo ] Start -->
            
            <img src="{{ URL::to('../abt_app/public/colombelogo.jpeg') }}" style=" border: 5px ;border-radius: 50%;width:250px"  >
            
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
                    <label class="custom-control custom-checkbox m-0">
                        <input type="checkbox" class="custom-control-input" id="checking">
                        <span class="custom-control-label">Mot de passe oublié</span>
                    </label>
                    <button type="submit" class="btn btn-success" name="login" id='login'>Se connecter</button>
                </div>
            </form>
            <!-- [ Form ] End -->
        </div>
    </div>
    <!-- meme une horloge en pangne donne lheure deux fois par jours-->
@endsection
