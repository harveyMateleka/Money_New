@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card col-md-12">
                            <h6 class="card-header">Envois de Code Ong</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_paiement">
                                <thead class="thead-light">
                                    <tr>
                                        <th>DATE</th>
                                        <th>ID</th>
                                        <th>ONG</th>
                                        <th>DEVISE</th>
                                        <th>MONTANT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                             @foreach($data_base as $ligne_base)
                                <tr>
                                <td>
                                {!! $ligne_base->created_at !!} 
                                </td>  
                                <td>
                                {!! $ligne_base->id !!} 
                                </td> 
                                <td>
                                {!! $ligne_base->name_ong !!} 
                                </td> 
                                <td>
                                    @if($ligne_base->devise==2)
                                    {!! 'CDF' !!} 
                                    @else
                                    {!! 'USD' !!}
                                    @endif
                                
                                </td> 
                                <td>
                                {!! $ligne_base->mont_trans !!} 
                                </td> 
                                <td>
                                <button data-id='{{$ligne_base->id}}' class="btn btn-info btn-circle repartition" ><i class="fa fa-check"></i></button>
                                 
                                </td>  
                               </tr>
                             @endforeach
                                </tbody>
                            </table>
                           
                        </div> 
                         </div>
                         </br>
                         
                         <div class="card col-md-12">
                            <h6 class="card-header">Repartition dans les agences</h6>
                            <div class="card-body">
                                 <form action="#" method="POST" id="form_affectation">
                                <div class="form-row">
                                    <div class="col-md-4">
                                    <label class="form-label">Nom Ong</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name_ong" placeholder="Nom de l'Ong" id="name_ong" data-validation="required" readOnly>
                                        <div class="clearfix"></div>
                                    </div>
                                    </div>
                                    <div class="col-md-4"> 
                                    <label class="form-label">Devise</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name_ong" placeholder="Devise" id="name_devise" data-validation="required" readOnly>
                                        <div class="clearfix"></div>
                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                    <label class="form-label">Montant</label>
                                    <div class="form-group">
                                        <input type="text" class="currency" name="name_ong" placeholder="Montant" id="name_Montant" data-validation="required"  style="text-transform:uppercase;" readOnly>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                    
                                </div>
                                </br>
                            <div class="form-row">
                            <div class="col-md-4">
                            <label class="form-label">Destination </label>
                            <div class="form-group"> 
                                        <select class="custom-select flex-grow-1" id='name_destination'>
                                            <option value='-1'>Selectionnez agence</option>
                                            @foreach($tbl_agence as $ligne_agence)
                                            <option value='{!! $ligne_agence->numagence !!}'>{!! $ligne_agence->nomagence !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-4"> 
                            <label class="form-label">Montant à Payer </label>   
                                    <div class="form-group ">
                                        <input type="text" class="currency" name="Montant" placeholder="" id="Montpaye" data-validation="required">
                                        <div class="clearfix"></div>
                                    </div>
                            </div>
                            <div class="col-md-4">
                            <label class="form-label">Code de Transaction </label> 
                                    <div class="form-group">
                                        
                                        <input type="text" class="form-control" name="code" placeholder="" id="code" data-validation="required" value="{{ old('code') ?? $code_trasanct}}" readonly>
                                        <div class="clearfix"></div>
                                    </div>
                                    </div>
                                    </div>
                                     <div class="form-row">
                                         <div class=" col-md-4">
                                        <button type="button" class="btn btn-success" name="btnsave_users" id="btnsave_ajout">Ajouter</button>
                                        <button type="reset" class="btn btn-danger" name="btn" id="reset">ANNULER</button>
                                        <input type="hidden" class="form-control"  id="name_id" value=''>
                                    </div>
                                    </div>
                            </form>
                                
                          </div>
                         </div>
                         </br>
                         <div class="card col-md-12">
                            <h6 class="card-header">Detail de Repartition</h6>
                            <div class="card-body">
                            <table class="table card-table" id="tab_repartition">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Agence</th>
                                        <th>Ong</th>
                                        <th>Code</th>
                                        <th>Devise</th>
                                        <th>MONTANT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                           
                        </div> 

                         </div> 
                        
                           
@endsection
@section ('javascript')

<script type="text/javascript">
    (function() {
    $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
            $('#name_destination').select2();
 var table = $('#tab_paiement').DataTable({
      "lengthMenu": [
        [10, 25, 50, -1],
        [5, 25, 50, "All"]
      ],

      dom: 'Bfrtip',
      buttons: [
        'print', 'copy', 'excel', 'pdf'

      ]
    });
    affiche_repartition();
    $('body').delegate('.supprimer_rep','click',function(){
        let varid=$(this).data('id');
        swal.fire({
            title: 'Colombe Money',
                  html: "cette operation est irreversible",
                  width: 600,
                  padding: '3em',
                  showDenyButton: true,
                  confirmButtonText: `Suppression`,
                  denyButtonText: `Annuler`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:"{{ route('delete_det')}}",
                    type:"POST",
                    async:false,
                    data:{
                        code:varid
                    },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire('operation reussie', '', 'success');
                            affiche_repartition();
                        }
                    }
                });
            } else if(result.isDenied) {
                Swal.fire('operation annulée', '', 'info');
            }
        });

    });
$('body').delegate('.repartition', 'click', function () {
  var ids = $(this).data('id');
  $.ajax({
                                url: "{{route('chercher')}}",
                                type: 'POST',
                                async: false,
                                data: {
                                    code_tra: ids
                                },
                                success: function (data) {
                                   $('#name_id').val(data.id);
                                   
                                   $('#name_ong').val(data.name_ong);
                                    if(data.devise=='1'){
                                        $('#name_devise').val('USD');   
                                    }
                                    else{
                                        $('#name_devise').val('CDF');
                                    }
                                   
                                   $('#name_Montant').val(data.mont_trans);
                                },
                                error: function (data) {
                                    alert(data.success);
                                }
                        }); 
  
  
});
    var total_Mont = 0.0;
$('#btnsave_ajout').click(function () {
    if ($('#name_Montant').val() != '' && $('#name_ong').val() != '' && $('#name_destination').val() != '-1' && $('#Montpaye').val() != '' && $('#name_Montant').val()!='') {
        var montat = parseFloat($('#Montpaye').val());
        total_Mont += montat;
        if (total_Mont <= parseFloat($('#name_Montant').val())) {
            swal.fire({
            title: 'Colombe Money',
                  html: "vous voulez enregistrer cet information",
                  width: 600,
                  padding: '3em',
                  showDenyButton: true,
                  confirmButtonText: `Suppression`,
                  denyButtonText: `Annuler`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                                url: "{{route('save_detail')}}",
                                type: 'POST',
                                async: false,
                                data: {
                                    code_tra: $("#code").val(),
                                    montant: montat,
                                    desti: $('#name_destination').val(),
                                    code: $('#name_id').val(),
                                    total_Mont: $('#name_Montant').val()
                                },
                                success: function (data) {
                                    if (data.success == '2') {
                                        swal.fire("l'argent de cette transaction est deja repartie",'','error');
                                        
                                    } else {
                                        $("#code").val(data.success);
                                        swal.fire("operation reussie",'','success')
                                        $('#Montpaye').val('');
                                        $('#name_destination').val('-1');
                                        affiche_repartition();
                                    }
                                },
                                error: function (data) {
                                    alert(data.success);
                                }
                        });
                
            } else if(result.isDenied) {
                swal.fire("operation annulée",'','error');                  
            }
        });
                                       
        }
         else {
            swal.fire("vous avez depassé le montant prevue"+ total_Mont,'','error');
           // $('#message').html('vous avez depassé le montant prevue ' + total_Mont);
            total_Mont -= montat;
        }
    } else {
        $('#message').html('verifiez bien les zones de destination');
    }
});
})();

function affiche_repartition()
    {
    var otableau=$('#tab_repartition').DataTable({
        dom: 'Bfrtip',
            buttons: [
            'print', 'copy', 'excel', 'pdf'
             ],
        "bProcessing":true,
        "sAjaxSource":"{{route('get_all_detail')}}",
        "columns":[
            {"data":'id'},
            {"data":'created_at'},
            {"data":'nomagence'},
            {"data":'name_ong'},
            {"data":'code_tr'},
             {"data":'devise',"autoWidth":true,"render":function (data){
                   if (data==2) {
                        return 'CDF';
                    }else{
                        return 'USD';
                    }
                      }},
            {"data":'montp',"autoWidth":true,"render":function (data){
                let values = formateIndianCurrency(data);
                return values.substring(0,values.length - 1);
            }},
              
            {"data":'id',"autoWidth":true,"render":function (data) {
                return '<button data-id='+data+' class="btn btn-danger btn-circle supprimer_rep" ><i class="fa fa-times"></i></button>';
                }}
        ],
        order:[[0,"DESC"]],
        "bDestroy":true
    }); 
    }
</script> 
@endsection

