@extends('layouts.header')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Page Fonction</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            
                        </div>

                        <div class="card col-md-8">
                            <h4 class="card-header">Ajout Fonction</h4>
                            <div class="card-body">
                                <form action="#" method="POST" id="form_ville">
                                {{csrf_field()}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Fonction occupée</label>
                                            <input type="text" class="form-control" name="name_fonction" placeholder="Saisir la fonction" id="name_fonction">
                                            <div class="clearfix"></div>
                                        </div>
                                       
                                    </div>
                                    <button type="button" class="btn btn-success" name="btnsave_fonction" id="btnsave_fonction">Enregistre</button>
                                    <button type="reset" class="btn btn-danger">annule</button>
                                    <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="code_fonction">
                                </form>
                            </div>
                        </div>
                        <hr class="border-light container-m--x my-4">
                        <div class="card col-md-8">
                            <h6 class="card-header">Liste de Fonction</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_fonction">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fonction </th>
                                        <th>ACTION</th>   
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                            </div>
                        </div>

                        

                      

                       
                       

                    </div>        
@endsection



