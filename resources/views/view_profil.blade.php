@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="font-weight-bold py-3 mb-0">Mon Profil</h3>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
    </div>
    <form action="{{'/admin/profil'}}" enctype="multipart/form-data" method="POST" id="form_ville">
            {{csrf_field()}}
    <div class="col-md-12">
    	<div class="row">
    		<div class="card col-md-8">
        <h4 class="card-header">Mofication de mon profil</h4>
        <div class="card-body">
            
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Mot de passe </label>
                        <input type="text" class="form-control" name="password" value="{{session('password')}}" >
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Nom </label>
                        <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}" >
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" value="{{Auth::user()->email}}" >
                        <div class="clearfix"></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" name="mdf_profil" >Modifier</button>
                <button type="button" class="btn btn-danger">annule</button>
                <input type="hidden" class="form-control" name="image" placeholder="Saisir le nom de la ville" >

            
        </div>
    </div>
    <div class="col-md-4">
    	<h4 class="card-header">
    		<i class="fa fa-user-circle"> </i>Photo
    	</h4>
    	<div class="card-body">
    		<center>
    			<img src="../abt_app/public/img/image_user/{{Auth::user()->image}}" width="150" height="150" style="border-radius: 50%;"><br>
    			<input type="file" name="profil">
    		</center>
    	</div>	
    </div>
    </form>

    </div>
    </div>
    
    <hr class="border-light container-m--x my-4">
</div>      
@endsection