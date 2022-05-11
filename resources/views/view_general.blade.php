@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Page de Cloture general</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            
                        </div>
                       
                        <div class="card col-md-12">
                            <div class="card-body">
                                <form action="#" method="POST" id="general">
                                {{csrf_field()}}

                                <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" style="font-size:20px">CAPITAL  USD</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalespeseusd" value="{{$capitalusd}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="form-label" style="font-size:20px">CAPITAL CDF</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalespesecdf" value="{{$capitalcdf}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                       
                                    </div>
                                      <h4 class="card-header" style="padding-left:30%"> CLOTURE GENERALE DU CAPITAL </h4>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTAL ESPECES USD</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalespeseusd" value="{{$totalespeseusd}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTAL ESPECES CDF</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalespesecdf" value="{{$totalespesecdf}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTAL COFFRE EN CDF</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalespesecdf" value="{{$coffre_cdf}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTAL COFFRE EN USD</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalespesecdf" value="{{$coffre_usd}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                       
                                    </div>
                                    <hr class="border-light container-m--x my-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTAL BANK USD</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="nouvdepartusd" value="{{$total_bankusd}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTAL BANK CDF</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="nouvdepartcdf" value="{{$total_bankcdf}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTAL SUSPENSE MVT USD</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalcreditusd" value="{{$totalmvtusd}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTAL SUSPENSE MVT CDF</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalcreditcdf" value="{{$totalmvtcdf}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <hr class="border-light container-m--x my-4">
                                    <div class="form-row">
                                    <div class="form-group col-md-6">
                                            <label class="form-label">TOTAL CREDIT USD</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="nouvdepartusd" value="{{$totalcreditusd}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label">TOTAL CREDIT CDF</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="nouvdepartcdf" value="{{$totalcreditcdf}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <hr class="border-light container-m--x my-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTAL % USD</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalpourcentageusd" value="{{$totalpourcentageusd}}" readonly >
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTAL % CDF</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalpourcentagecdf" value="{{$totalpourcentagecdf}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTALE DEPENSE EN USD</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalusd"  value="{{$depenseusd}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="form-label">TOTALE DEPENSE EN CDF</label>
                                            <input type="text" class="form-control" name="name_menu" placeholder="Saisir le menu" id="totalcdf" value="{{$depensecdf}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                       
                                    </div>
                                    <hr class="border-light container-m--x my-4">
                                     <div class="form-row">
                                     <div class="form-group col-md-4">
                                            <label class="form-label">DIFFERENCE EN CDF</label>
                                            <input type="text" class="form-control" name="totalcdf" id="df_cdf" placeholder="Saisir le menu" id="diffcdf" value="{{$diffcdf}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="form-label">DIFFERENCE EN USD</label>
                                            <input type="text" class="form-control" name="totalusd" id="df_usd" placeholder="Saisir le menu" id="diffusd" value="{{$diffusd}}" readonly>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                           <button name='btn_retrait' class="btn btn-success fa fa-edit" type='button' id='btn_retrait'>RETIRE POURCENTAGE</button>
                                        </div> 
                                        </div>
                                    </div>
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
$('#btn_retrait').click(function () {
    var totalcdf = parseFloat($("#df_cdf").val()).toFixed(2);
    var totalusd = parseFloat($("#df_usd").val()).toFixed(2);
    var x=0
    if(totalcdf==0 && totalusd==0){
      return false;
  } 
  else{
     swal({
        title: 'Voulez vous retire le pourcentage?',
        text: "il ya pas moyen de modifie!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,RETIRE!',
        cancelButtonText: 'No, ANNULE!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: "{{route('update_pourcentage')}}",
                    type: 'POST',
                    async: false,
                    data: {
                        totalcdf: parseFloat($("#df_cdf").val()).toFixed(2),
                        totalusd: parseFloat($("#df_usd").val()).toFixed(2)
                    },
                    success: function (data) {


                        if (data.success == '1') {
                            swal({
                                title: 'ABT COLOMBE!',
                                text: 'le pourecentage retiré!',
                                type: 'success'
                            })
                            window.location.href = ("{{route('index_cloture1')}}");
                            

                        } else if(data.success == '2') {
                            swal({
                                title: 'ABT COLOMBE!',
                                text: 'vous ne pouvez pas retirer le pourcentage car le montant est negatif',
                                type: 'info'
                            })
                        }
                        else{
                            swal({
                                title: 'ABT COLOMBE!',
                                text: 'le pourcentage est deja retiré',
                                type: 'info'
                            })
                        }

                    }

                });
            })
        }
    }).then(function () {
        swal({
            type: 'info',
            title: 'ABT COLOMBE',
            html: 'Pourcentage ne pas retire'
        })
    });
  } 
});
})();
</script>
@endsection
