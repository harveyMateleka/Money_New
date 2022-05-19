@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
   <h3 class="font-weight-bold py-3 mb-0">Cloture agence</h3>
   <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
   </div>
   <div class="card col-md-12">
      <h4 class="card-header">ELEMENT DE CLOTURE DU JOUR</h4>
      <div class="card-body">
         <form action="#" method="POST" id="form_sous">
            {{csrf_field()}}
            <div class="form-row">
               <div class="form-group col-md-6">
                     <label class="form-label">Agence</label>
                        <select class="custom-select flex-grow-1" id='name_agence' name="agence">
                           <option value='-1'>Choisir Agence</option>
                           @foreach($don as $ligne_agence)
                           <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                           @endforeach
                        </select>
                        @foreach($don as $ligne_agence)
                        <input type="hidden"  class="form-control"  name="{{'agence'.$ligne_agence->numagence}}"  id="{{'agence'.$ligne_agence->numagence}}" value="{{$ligne_agence->nomagence}}">
                        @endforeach
               </div>
               <div class="form-group col-md-6">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="name_datedebut" id='name_datedebut'>
               </div>
            </div>
            <div class="form-row">
            <button type="button" class="btn btn-success" name="btn_checking" id="btn_checking">Verifier</button>
            </div>
          </br>
          </br>
            <div class="form-row">
               <div class="form-group col-md-3">
                  <label class="form-label">Nouveau Depart USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="name_nouvusd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Nouveau Depart CDF</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="name_nouvcdf" value="0"readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Ancienne Depart USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="name_ancusd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Ancienne Depart CDF</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="name_anccdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                  <label class="form-label">Totales entrées USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalentre_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totales entrées CDF</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalentre_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Totales Sortie USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="sortie_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totales Sortie CDF</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="sortie_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>

            </div>
            <div class="form-row">
               <div class="form-group col-md-3">
                  <label class="form-label">Total Pourcentage en USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Pourc_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Total Pourcentage en CDF</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Pourc_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Total Entréé Ong en USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Eong_usd" value="" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Total Entrée Ong en CDF</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Eong_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-3">
                  <label class="form-label">Total Sortie Ong en USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Song_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Total Sortie Ong en CDF</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="Song_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Totale Entrée cash express en USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalentreecash_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totale Entrée cash express en Cdf</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalentreecash_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>

            </div>
            <div class="form-row">
                 <div class="form-group col-md-3">
                  <label class="form-label">Totale Sortie cash express en USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="expresse_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totale Sortie cash express en Cdf</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="expresse_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Totale Depense en USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="depense_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totale Depense en Cdf</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="depense_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                  <label class="form-label">Totale Entrée Bank en USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="entreeB_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totale Entrée Bank en Cdf</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="entreeB_cdf" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
                <div class="form-group col-md-3">
                  <label class="form-label">Totale Sortie Bank en USD</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="sortieB_usd" value="0" readonly>
                  <div class="clearfix"></div>
               </div>
               <div class="form-group col-md-3">
                  <label class="form-label">Totale Sortie Bank en Cdf</label>
                  <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="sortieB_cdf" value="0" readonly>
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
@section('javascript')
<script type="text/javascript">
    (function() {
      $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
                });
                $('#name_agence').select2();
$('#btn_checking').click(function() { 

           if($("#name_agence").val()!='' && $("#name_datedebut").val()!=''){ 
                    $.ajax({
                     url   : "{{route('check_clotures')}}",
                     type  : 'POST',
                     async : false,
                     data  : {
                        numagence:$("#name_agence").val(),
                        name_date:$("#name_datedebut").val()
                     },
                     success:function(data)
                     {
                        let mont=formateIndianCurrency(data.data.nouvdepartusd);
                        let monts=formateIndianCurrency(data.data.nouvdepartcdf);
                        let montancU=formateIndianCurrency(data.data.ancdepartUsd);
                        let montancC=formateIndianCurrency(data.data.ancdepartCdf);
                        let totalEU=formateIndianCurrency(data.data.totalentreusd);
                        let totalEC=formateIndianCurrency(data.data.totalentrecdf);
                        let SortieU=formateIndianCurrency(data.data.totalsortiusd);
                        let SortieC=formateIndianCurrency(data.data.totalsorticdf);
                        let PourU=formateIndianCurrency(data.data.pourusd);
                        let PourC=formateIndianCurrency(data.data.pourcdf);
                        let Eong_usd=formateIndianCurrency(data.data.totalEOngusd);
                        let Eong_cdf=formateIndianCurrency(data.data.totalEOngcdf);

                        let Song_usd=formateIndianCurrency(data.data.totalSONGusd);
                        let Song_cdf=formateIndianCurrency(data.data.totalSONGcdf);
                        let totalentreecash_usd=formateIndianCurrency(data.data.totaleusd);
                        let totalentreecash_cdf=formateIndianCurrency(data.data.totalecdf);
                        let expresse_usd=formateIndianCurrency(data.data.totalsusd);
                        let expresse_cdf=formateIndianCurrency(data.data.totalscdf);

                        let depense_usd=formateIndianCurrency(data.data.totaldepusd);
                        let depense_cdf=formateIndianCurrency(data.data.totaldepcdf);
                        let entreeB_usd=formateIndianCurrency(data.data.entrebankusd);
                        let entreeB_cdf=formateIndianCurrency(data.data.entrebankcdf);
                        let sortieB_usd=formateIndianCurrency(data.data.sortiebankusd);
                        let sortieB_cdf=formateIndianCurrency(data.data.sortiebankcdf);

                         $("#name_nouvusd").val(mont.substring(0,mont.length - 1));
                         $("#name_nouvcdf").val(monts.substring(0,monts.length - 1));
                         $("#name_ancusd").val(montancU.substring(0,montancU.length - 1));
                         $("#name_anccdf").val(montancC.substring(0,montancC.length - 1));
                         $("#totalentre_usd").val(totalEU.substring(0,totalEU.length - 1));
                         $("#totalentre_cdf").val(totalEC.substring(0,totalEC.length - 1));
                         $("#sortie_usd").val(SortieU.substring(0,SortieU.length - 1));
                         $("#sortie_cdf").val(SortieC.substring(0,SortieC.length - 1));
                         $("#Pourc_usd").val(PourU.substring(0,PourU.length - 1));
                         $("#Pourc_cdf").val(PourC.substring(0,PourC.length - 1));
                         $("#Eong_usd").val(Eong_usd.substring(0,Eong_usd.length - 1));
                         $("#Eong_cdf").val(Eong_cdf.substring(0,Eong_cdf.length - 1));
                         $("#Song_usd").val(Song_usd.substring(0,Song_usd.length - 1));
                         $("#Song_cdf").val(Song_cdf.substring(0,Song_cdf.length - 1));
                         $("#totalentreecash_usd").val(totalentreecash_usd.substring(0,totalentreecash_usd.length - 1));
                         $("#totalentreecash_cdf").val(totalentreecash_cdf.substring(0,totalentreecash_cdf.length - 1));
                         $("#expresse_usd").val(expresse_usd.substring(0,expresse_usd.length - 1));
                         $("#expresse_cdf").val(expresse_cdf.substring(0,expresse_cdf.length - 1));

                         $("#depense_usd").val(depense_usd.substring(0,depense_usd.length -1));
                         $("#depense_cdf").val(depense_cdf.substring(0,depense_cdf.length -1));
                         $("#entreeB_usd").val(entreeB_usd.substring(0,entreeB_usd.length -1));
                         $("#entreeB_cdf").val(entreeB_cdf.substring(0,entreeB_cdf.length -1));
                         $("#sortieB_usd").val(sortieB_usd.substring(0,sortieB_usd.length -1));
                         $("#sortieB_cdf").val(sortieB_cdf.substring(0,sortieB_cdf.length -1));
                         
                     },
                     error:function(data){

                       alert(data.success);                              
                       }
                 });  
        }
        else{
            $('#message').html('verifier bien les données à verifier');
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

   if (departcdf != 0 && departusd != 0 && nvdepartcdf != 0 && nvdepartusd != 0 && pourcentagecdf != 0 && pourcentageusd != 0 && totalentrecdf != 0 && totalentreusd != 0) {
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
                    name_date:$("#name_datedebut").val(),
                    numagence:$("#name_agence").val(),
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
            title: 'ABT COLOMBE',
            html: 'la journee ne pas cloture'
        })
    });

    
   }
});
})();
</script>
@endsection