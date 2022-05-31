@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0">CLOTURE AGENCE</h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
   </div>
   <div class="card col-md-12">
      <h4 class="card-header">ELEMENT DE CLOTURE DU JOUR</h4>
      <div class="card-body">
         <form action="#" method="POST" id="form_sous">
            {{csrf_field()}}
            <div class="form-row">
               <div class="form-group col-md-4">
                  <select class="custom-select flex-grow-1" id='name_agence' name="agence">
                     <option  style="border: 1px solid silver !important; padding-left: 8px !important" value='-1'>SELECTIONER L'AGENCE</option>
                     @foreach($don as $ligne_agence)
                     <option  style="border: 1px solid silver !important; padding-left: 8px !important" value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                     @endforeach
                  </select>
                  @foreach($don as $ligne_agence)
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="hidden"  class="form-control"  name="{{'agence'.$ligne_agence->numagence}}"  id="{{'agence'.$ligne_agence->numagence}}" value="{{$ligne_agence->nomagence}}">
                  @endforeach
               </div>

      <button type="button" class="btn btn-success" name="btn_checking" id="btn_checking">Verifier</button>
            </div>
          </br>
          </br>
          </br>
            <div class="form-row">
               <div class="form-group col-md-3">
                  <label class="form-label">Nouveau Depart USD</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="name_nouvusd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Nouveau Depart CDF</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="name_nouvcdf" value="0"readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Ancienne Depart USD</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="name_ancusd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Ancienne Depart CDF</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="name_anccdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                  <label class="form-label">Totales entrées USD</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important"  type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalentre_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totales entrées CDF</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalentre_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Totales Sortie USD</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="sortie_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totales Sortie CDF</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="sortie_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>

            </div>
            <div class="form-row">
               <div class="form-group col-md-3">
                  <label class="form-label">Total Pourcentage en USD</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Pourc_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Total Pourcentage en CDF</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Pourc_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Total Entréé Ong en USD</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Eong_usd" value="" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Total Entrée Ong en CDF</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Eong_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-3">
                  <label class="form-label">Total Sortie Ong en USD</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Song_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Total Sortie Ong en CDF</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Song_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Totale Entrée cash express en USD</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalentreecash_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totale Entrée cash express en Cdf</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalentreecash_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>

            </div>
            <div class="form-row">
                 <div class="form-group col-md-3">
                  <label class="form-label">Totale Sortie cash express en USD</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important"  type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="expresse_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totale Sortie cash express en Cdf</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="expresse_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Totale Depense en USD</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="depense_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totale Depense en Cdf</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="depense_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                  <label class="form-label">Totale Entrée Bank en USD</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important"  type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="entreeB_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totale Entrée Bank en Cdf</label>
                  <input style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="entreeB_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Totale Sortie Bank en USD</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="sortieB_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totale Sortie Bank en Cdf</label>
                  <input  style="border: 1px solid silver !important; padding-left: 8px !important" type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="sortieB_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
            </div>
            <button type="button" class="btn btn-success" name="btn_cloture" id="btn_cloture">Enregistre</button>
            <button type="reset" class="btn btn-danger">annule</button>
            <input type="hidden" class="form-control" placeholder="Saisir le nom de la ville" id="id_cloture">
         </form>
      </div>
   </div>
</div>
@endsection
@section('script')
$('#btn_checking').click(function() { 

           if($("#name_agence").val()!=''){ 
                    $.ajax({
                     url   : "{{route('check_clotures')}}",
                     type  : 'POST',
                     async : false,
                     data  : {numagence:$("#name_agence").val()
                     },
                     success:function(data)
                     {
                      
                         $("#name_nouvusd").val(data.data.nouvdepartusd);
                         $("#name_nouvcdf").val(data.data.nouvdepartcdf);
                         $("#name_ancusd").val(data.data.ancdepartUsd);
                         $("#name_anccdf").val(data.data.ancdepartCdf);
                         $("#totalentre_usd").val(data.data.totalentreusd);
                         $("#totalentre_cdf").val(data.data.totalentrecdf);
                         $("#sortie_usd").val(data.data.totalsortiusd);
                         $("#sortie_cdf").val(data.data.totalsorticdf);
                         $("#Pourc_usd").val(data.data.pourusd);
                         $("#Pourc_cdf").val(data.data.pourcdf);
                         $("#Eong_usd").val(data.data.totalEOngusd);
                         $("#Eong_cdf").val(data.data.totalEOngcdf);
                         $("#Song_usd").val(data.data.totalSONGusd);
                         $("#Song_cdf").val(data.data.totalSONGcdf);
                         $("#totalentreecash_usd").val(data.data.totaleusd);
                         $("#totalentreecash_cdf").val(data.data.totaleusd);
                         $("#expresse_usd").val(data.data.totalsusd);
                         $("#expresse_cdf").val(data.data.totalsusd);
                         $("#depense_usd").val(data.data.totaldepusd);
                         $("#depense_cdf").val(data.data.totaldepcdf);
                         $("#entreeB_usd").val(data.data.entrebankusd);
                         $("#entreeB_usd").val(data.data.entrebankcdf);
                         $("#sortieB_usd").val(data.data.sortiebankusd);
                         $("#sortieB_cdf").val(data.data.sortiebankcdf);
                         
                     },
                     error:function(data){

                       alert(data.success);                              
                       }
                 });  
        }
        else{
            $('#message').html('Saisisez le numero transaction svp !');
        }
   });

$('#btn_cloture').click(function () {
    var id=$("#id_cloture").val();
    var departcdf=$("#name_anccdf").val();
    var departusd=$("#name_ancusd").val();
    var nvdepartcdf=$("#name_nouvcdf").val();
    var nvdepartusd=$("#name_nouvusd").val();
    var totalentrecdf=$("#totalentre_cdf").val();
    var totalentreusd=$("#totalentre_usd").val();
    var pourcentagecdf=$("#Pourc_cdf").val();
    var pourcentageusd=$("#Pourc_usd").val();

   if (departcdf != '' && departusd != '' && nvdepartcdf != '' && nvdepartusd != '' && pourcentagecdf != ''&& pourcentageusd != '') {
       swal({
        title: 'ABT-TRANSFERT',
        text: "voulez vous cloture la journee?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,cloture!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {

         $.ajax({
            url: "{{route('store_cloture_agence')}}",
            type: 'POST',
            async: false,
            data: {
                    departcdf:departcdf,
                    departusd:departusd,
                    nvdepartcdf:nvdepartcdf,
                    nvdepartusd:nvdepartusd,
                    totalentrecdf:totalentrecdf,
                    totalentreusd:totalentreusd,
                    pourcentagecdf:pourcentagecdf,
                    pourcentageusd:pourcentageusd,
            },
            success: function (data) {
               if (data.success == '1') {
               swal({title: 'ABT COLOMBE!',
                text: 'la journee est bien cloture avec success!',
                type: 'success'
                })
                  
               } else {
                  swal({title: 'ABT COLOMBE!',
                text: 'le modification a été bien apportée!',
                type: 'success'
                })
               }
            },
            error: function (data) {
               alert(data.success);
            }
         });

            })
    }

      }).then(function () {
        swal({
            type: 'info',
            title: 'La Colombe Money',
            html: 'La journee n\'est encore pas cloturé'
        })
    });

    
   }
});

@endsection