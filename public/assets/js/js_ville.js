(function() {
    //affiche_ville();
    $('#btnsave_ville').click(function() { 
        var name_ville=$("#name_ville").val();
        var initial=$("#initial").val();
        if(name_ville!=''){ 
            if ($("#code_ville").val()=='') {
               swal({
               title: 'La Colombe money',
               text: "voulez vous ajouter une ville?",
               type: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Oui,Ajouter!',
               cancelButtonText: 'No, ANNULE!',
               confirmButtonClass: 'btn btn-success',
               cancelButtonClass: 'btn btn-danger',
               buttonsStyling: false,
               allowOutsideClick: false,
               showLoaderOnConfirm: true,
               preConfirm: function () {
               return new Promise(function (resolve, reject) {
                $.ajax({
                      url   : "{{route('route_create_ville')}}",
                      type  : 'POST',
                      async : false,
                      data  : {
                                name_ville:name_ville,
                                initial:initial
                            },
                       
                     
                      success:function(data)
                      {
                        if(data.success=='1'){
          
                            affiche_ville();
                            $("#name_ville").val("");
                            $("#initial").val("");
                        }
                        else{
                            alert('existe deja');
                        } 
                      },
                      error:function(data){
    
                        alert(data.success);                              
                       }
                  });
                  
               })
           }

 }).then(function () {
   swal({
       type: 'info',
       title: 'La Colombe Money',
       html: 'la ville ne pas ajouter '
   })
});

            }
            else{
                swal({
   title: 'La Colombe Money',
   text: "Voulez vous modifier?",
   type: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: 'Oui,Modifier!',
   cancelButtonText: 'No, ANNULE!',
   confirmButtonClass: 'btn btn-success',
   cancelButtonClass: 'btn btn-danger',
   buttonsStyling: false,
   allowOutsideClick: false,
   showLoaderOnConfirm: true,
   preConfirm: function () {
       return new Promise(function (resolve, reject) {
                $.ajax({
                      url   : "{{route('route_update_ville')}}",
                      type  : 'POST',
                      async : false,
                      data  : {ville: $("#name_ville").val(),
                               initial: $("#initial").val(),
                               code_ville:$("#code_ville").val(),
                      },
                      success:function(data)
                      {
                        if(data.success=='1'){
                            swal({title: 'La Colombe Money',
           text: 'modification ville avec success!',
           type: 'success'
           })
                                affiche_ville();
                                $("#name_ville").val("");
                                $("#initial").val("");
                        }
                        else{
                            alert('erreur de transaction');
                        }
                       
                      }
                  });
       })

}
}).then(function () {
   swal({
       type: 'info',
       title: 'La Colombe Money',
       html: 'les information ne sont pas mofifier'
   })
});
            }
            
          
        }
    });

    function affiche_ville()
    {
      var otableau=$('#tab_ville').DataTable({
            "bProcessing":true,
            "sAjaxSource":"{{route('get_list_ville')}}",
            "columns":[
                {"data":'id_ville'},
                {"data":'ville'},
                {"data":'initial'},
                {"data":'id_ville',"autoWidth":true,"render":function (data) {
    
                        return '<button data-id='+data+' class="btn btn-warning btn-circle supprimer_ville" ><i class="fa fa-times"></i></button>'+ ' ' +
                            '<button data-id='+data+' class="btn btn-info btn-circle modifier_ville" ><i class="fa fa-check"></i></button>';
                    }}
            ],
            "pageLength": 10, 
            "bDestroy":true
        });
    
    }
  })();