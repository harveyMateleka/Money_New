@extends('layouts.login')
    <!-- [ Preloader ] Start -->
@section('login')
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ content ] Start -->
    <div class="authentication-wrapper authentication-1 px-4">
        <div class="authentication-inner py-5">

            <!-- [ Logo ] Start -->
            <div class="d-flex justify-content-center align-items-center">
                <div class="ui-w-60">
                    <div class="w-100 position-relative">
                        <i class="fa fa-user-circle" style="font-size : 50px;"></i>
                    </div>
                </div>
            </div>
            <!-- [ Logo ] End -->

            <!-- [ Form ] Start -->
            <form class="my-5" method="POST" action="{{route('update_login')}}">
                {{ csrf_field() }}
                     @if(empty($message))
                        @else
                        <p style="font-size : 30px; color:red"> {{$message}}</p>
                        @endif
                <div class="form-group">
                    <label class="form-label">Ancien mot de passe</label>
                    <input type="text" class="form-control"  name='password' value="{{$motdepasse}}" readonly>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="form-label d-flex justify-content-between align-items-end">
                        <span>Nouveau mot de passe</span>
                    </label>
                    <input type="password" class="form-control" name='new_password' id='new_password'>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="form-label d-flex justify-content-between align-items-end">
                        <span>Confirmation</span>
                    </label>
                    <input type="password" class="form-control" name='confirm' id='confirm'>
                    <div class="clearfix"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center m-0">
                    <button type="submit" class="btn btn-primary" id='btnlogin'>Modifier</button>
                </div>
            </form>
            <!-- [ Form ] End -->
        </div>
    </div>
    <!-- [ content ] End -->
@endsection
