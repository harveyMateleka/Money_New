@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0">TRANFERT ONG </h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">   
   </div>
   <div class="card col-md-12">
      <div class="card -header">    
      </div>
      <div class="card-body">
         <form action="#" method="POST" id="form_affectation">
            {{csrf_field()}}
            <div id="message" style='color:red; font-size:15px;'>
            </div>
            <div class="form-row">
               <div class="form-group col-md-6">
                  <label class="form-label"></label> 
                  <select class="custom-select flex-grow-1" id='name_ong' name="name_ong">
                     <option value='-1'>Choisir l'ong</option>
                     @foreach($ong as $ligne_ong)
                     <option value='{!! $ligne_ong->id !!}'>{!! $ligne_ong->name_ong !!}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group col-md-6">
                  <label class="form-label">EXPEDITEUR</label>         
                     <input type="text" class="form-control"  name="name_transact"  style="text-transform:uppercase;" placeholder="EXPEDITEUR" id="name_exp" value="" >
                     <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-12">
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" checked type="radio" name="etat" id="etat_ag" value="1">
                     <label class="form-check-label"  for="inlineRadio1">Agence</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input"  type="radio" name="etat" id="etat_bank" value="2">
                     <label class="form-check-label" for="inlineRadio2">Banque</label>
                  </div>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-8" id='prov_bank'>
                  <select class="custom-select flex-grow-1" id='name_bank'>
                     <option value='-1'>Selectionnez Bank</option>
                     @foreach($tbl_banque as $ligne_banque)
                     <option value='{!! $ligne_banque->id !!}'>{!! $ligne_banque->intitulecompte !!}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group col-md-8" id='prov_ag'>
                  <select class="custom-select flex-grow-1" id='name_prov'>
                     <option value='-1'>Agence de Provenance</option>
                     @foreach($tbl_agence as $ligne_agence)
                     <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-6">
                  <select class="form-control js-states" name="devise" data-validation="" id="devise" data-validation="required">
                     <option value='-1'>Selectionnez la devise</option>
                     <option value="2">CDF</option>
                     <option value="1">USD</option>
                  </select>
               </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label class="form-label">MONTANT </label>
                  <input type="text" class="form-control" name="Montant" placeholder="" id="Montant" data-validation="required">
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-6">
                  <label class="form-label">Taux </label>
                  <input type="text" class="form-control" name="Montant" placeholder="" id="taux" value="3">
                  <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label class="form-label">Montant Pourc. </label>
                  <input type="text" class="form-control" name="Montant" placeholder="" id="montant_pourc" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-6">
                  <label class="form-label">Frais Deplacement.</label>
                  <input type="text" class="form-control" id='frais' name="frais" placeholder="" id="mont_dep">
                  <div class="clearfix"></div>
               </div>
            </div>
            <hr class="border-light container-m--x my-4">
            
            <hr class="border-light container-m--x my-4">
            <button type="button" class="btn btn-success" name="btnsave_users" id="btnsave_ong">Save</button>
            <button type="reset" class="btn btn-danger" id="btnreset_affectation">annule</button>
            <input type="hidden" class="form-control"  id="name_id" value=''>
         </form>
      </div>
   </div>
   <hr class="border-light container-m--x my-4">
   <div class="card col-md-12">
      <h6 class="card-header">Liste de transfert des ong</h6>
      <div class="card-body">
         <table class="table card-table" id="tab_save_ong">
            <thead class="thead-light">
               <tr>
                  <th>Id</th>
                  <th>Date</th>
                  <th>Nom ong</th>
                  <th>Devise</th>
                  <th>Montant Trans</th>
                  <th>Taux</th>
                  <th>Pourc.</th>
                  <th>Frais Dep.</th>
                  <th>Montant Payé</th>
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