$(function() {


 $('#txtF1').datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY',
        useCurrent:true,
        viewDate: moment()

  });

  $('#txtF2').datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY',
        useCurrent: false
  }); 

$("#txtF1").on("dp.change", function (e) {
            $('#txtF2').data("DateTimePicker").minDate(e.date);
        });
$("#txtF2").on("dp.change", function (e) {
    $('#txtF1').data("DateTimePicker").maxDate(e.date);
});

    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        pageLength: 50,
        columnDefs: [{ 
            orderable: false,
            width: '100px'
        }],
        dom: '<"datatable-header"fpl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Buscar:</span> _INPUT_',
            lengthMenu: '<span>Ver:</span> _MENU_',
            emptyTable: "No existen registros",
            sZeroRecords:    "No se encontraron resultados",
            sInfoEmpty:      "No existen registros que contabilizar",
            sInfoFiltered:   "(filtrado de un total de _MAX_ registros)",
            sInfo:           "Mostrando del registro _START_ al _END_ de un total de _TOTAL_ datos",
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }

        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });


    // Basic datatable
    $('.datatable-basic').DataTable();

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Escriba para filtrar...');


    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });


     var validator2 = $("#frmSearch").validate({

      ignore: '.select2-search__field', // ignore hidden fields
      errorClass: 'validation-error-label',
      successClass: 'validation-valid-label',

      highlight: function(element, errorClass) {
          $(element).removeClass(errorClass);
      },
      unhighlight: function(element, errorClass) {
          $(element).removeClass(errorClass);
      },
      // Different components require proper error label placement
      errorPlacement: function(error, element) {

        // Input with icons and Select2
         if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
              error.appendTo( element.parent() );
          }

         // Input group, styled file input
          else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
              error.appendTo( element.parent().parent() );
          }

        else {
            error.insertAfter(element);
        }

      },

      rules: {
        txtF1:{
          required: true
        },
        txtF2:{
          required:true
        }
      },
    validClass: "validation-valid-label",
     success: function(label) {
          label.addClass("validation-valid-label").text("Correcto.")
      },

       submitHandler: function (form) {
           buscar_datos();
        }
     });


 $(document).on('click', '#delete_product', function(e){
   
       var productId = $(this).data('id');
       SwalDelete(productId);
       e.preventDefault();
  });


});


function buscar_datos()
{
  var fecha1 = $("#txtF1").val();
  var fecha2 = $("#txtF2").val();

    if(fecha1!="" && fecha2!="")
    {
        $.ajax({

           type:"GET",
           url:"web/ajax/reload-hcaja.php?fecha1="+fecha1+"&fecha2="+fecha2,
           success: function(data){
              $('#reload-div').html(data);
           }

       });
    } else {

      $.ajax({

           type:"GET",
           url:"web/ajax/reload-hcaja.php?fecha1=empty&fecha2=empty",
           success: function(data){
              $('#reload-div').html(data);
           }

       });

    }

}


function cargarDiv(div,url)
{
      $(div).load(url);
}

    function SwalDelete(productId){
              swal({
                title: "¿Está seguro que desea cerrar la caja?",
                text: "Este proceso es irreversible!",
                showCancelButton: true,
                confirmButtonColor: "#EF5350",
                confirmButtonText: "Si, Cerrar",
                cancelButtonText: "No, volver atras",
                closeOnConfirm: false,
                closeOnCancel: false,
                imageUrl: "web/assets/images/wallet.png",
                allowOutsideClick: false
            },
            function(isConfirm){
                if (isConfirm) {
                     return new Promise(function(resolve) {
                        $.ajax({
                        url: 'web/ajax/ajxcaja.php',
                        type: 'POST',
                        data: 'proceso=Cerrar-M&id='+productId,
                        dataType: 'json'
                        })
                        .done(function(response){
                         swal('Cerrada!', response.message, response.status);
                         buscar_datos();
                        })
                        .fail(function(){
                         swal('Oops...', 'Algo salio mal al procesar tu peticion!', 'error');
                        });
                     });
                }
                else {
                    swal({
                        title: "Esta bien",
                        text: "Puedes seguir donde te quedaste",
                        confirmButtonColor: "#2196F3",
                        type: "info"
                    });
                }
            });

 }

