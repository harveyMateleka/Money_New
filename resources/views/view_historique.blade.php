@extends('layouts.header')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="font-weight-bold py-3 mb-0">Historisation</h3>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                        </div>
                        <div class="card col-md-12">
                            <hr class="border-light container-m--x my-4">
                           
                            <table class="table card-table" id="tab_historique">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Matricule</th>
                                        <th>Nom</th>
                                        <th>Postnom</th>
                                        <th>Operation</th>
                                        <th>Date/heure</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($resultat as $resultats)
                                  <tr>
                                    <td>{{$resultats->id}}</td>
                                     <td>{{$resultats->matricule}}</td>
                                     <td>{{$resultats->nom}}</td>
                                     <td>{{$resultats->postnom}}</td>
                                     <td>{{$resultats->operation}}</td>
                                     <td>{{$resultats->created_at}}</td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            
                          <div class="form-row" style="padding:10px">
                              <button type="button" class="btn btn-success" id="btn_historique">Supprimer</button>
                            </div>         
                        </div>                 
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

$('#tab_historique').DataTable({
     "lengthMenu": [[10, 25, 50, -1], [5, 25, 50, "All"]],
     "pageLength": 10, 
     "bDestroy":true
  });
  $('#btn_historique').click(function(){
      var data='';
    $.ajax({
                      url   : "{{route('delete_historique')}}",
                      type  : 'POST',
                      async : false,
                      data  : { data:data        
                      },
                      success:function(data)
                      {
                          if(data.success=='1'){
                            window.location.href=("{{route('index_historique')}}");
                          }
                           
                      },
                      error:function(data){
                        alert(data.success);                              
                        }
                  });
  });

})();
</script>

@endsection

