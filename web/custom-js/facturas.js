$(function () {


$(document).on('click', '#print_vigentes', function(e){

       Print_Report('Vigentes');
       e.preventDefault();
  });

  $(document).on('click', '#print_anuladas', function(e){

       Print_Report('Anuladas');
       e.preventDefault();
 });


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
$('.dataTables_filter input[type=search]').attr('placeholder','Escriba para buscar...');


// Enable Select2 select for the length option
$('.dataTables_length select').select2({
    minimumResultsForSearch: Infinity,
    width: 'auto'
});


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


     var validator = $("#frmSearch").validate({

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

  $(document).on('click', '#detail_pay', function(e){

       var productId = $(this).data('id');
       detalle_venta(productId);
       e.preventDefault();
  });

  $(document).on('click', '#print_receip', function(e){

       var productId = $(this).data('id');
       Imprimir_Ticket(productId);
       e.preventDefault();
  });

  /* FACTURACION */
  var isRequestInProgress = false;

  $(document).off('click', '#facturacion').on('click', '#facturacion', function(e){
    if (isRequestInProgress) {
        e.preventDefault(); // Evita la ejecución del código si ya hay una petición en curso
        return;
    }
    isRequestInProgress = true; // Establece la bandera para indicar que la petición está en curso

    var productId = $(this).data('id');
    generarFactura(productId);
    e.preventDefault();
  });
  /* FACTURACION */

});

var isRequestInProgress = false;

/* FACTURACION */
function generarFactura(VentaNo)
{
    var datos = 'idventa='+VentaNo;
    $.ajax({
        type:'POST',
        url:'web/ajax/ajxventafacturar.php',
        data: datos,
        cache: false,
        dataType: 'json',
        success: function(data){

          if(data != "Error"){
            //cargarDiv("#reload-div","web/ajax/reload-facturas.php");
            location.reload();
            alert(data);
          }

        },error: function() {
            //cargarDiv("#reload-div","web/ajax/reload-facturas.php");
            location.reload();
            alert("Comprobante Electronico no procesado");
        }
    });
}
/* FACTURACION */

function cargarDiv(div,url)
{
      $(div).load(url);
}

function buscar_datos()
{
  var fecha1 = $("#txtF1").val();
  var fecha2 = $("#txtF2").val();

    if(fecha1!="" && fecha2!="")
    {
        $.ajax({

           type:"GET",
           url:"web/ajax/reload-facturas.php?fecha1="+fecha1+"&fecha2="+fecha2,
           success: function(data){
              $('#reload-div').html(data);
           }

       });
    } else {

      $.ajax({

           type:"GET",
           url:"web/ajax/reload-facturas.php?fecha1=empty&fecha2=empty",
           success: function(data){
              $('#reload-div').html(data);
           }

       });

    }

}

function detalle_venta(VentaNo)
{
    $.ajax({

       type:"GET",
       url:"web/ajax/reload-detalle-venta.php?numero_transaccion="+VentaNo,
       success: function(data){
          $('#reload-detalle').html(data);
       }

   });

}

function Imprimir_Ticket(VentaNo)
{
   window.open('reportes/TicketV.php?venta='+btoa(VentaNo),
  'win2','status=yes,toolbar=yes,scrollbars=yes,titlebar=yes,menubar=yes,'+
  'resizable=yes,width=600,height=600,directories=no,location=no'+
  'fullscreen=yes');

}

  function Print_Report(Criterio)
{

  var fecha1 = $("#txtF1").val();
  var fecha2 = $("#txtF2").val();

    if(fecha1!="" && fecha2!="")
    {
        if(Criterio == 'Vigentes')
        {
             window.open('reportes/Facturas_Vigentes_Fechas.php?fecha1='+fecha1+'&fecha2='+fecha2,
            'win2',
            'status=yes,toolbar=yes,scrollbars=yes,titlebar=yes,menubar=yes,'+
            'resizable=yes,width=800,height=800,directories=no,location=no'+
            'fullscreen=yes');

        } else if (Criterio == 'Anuladas') {

             window.open('reportes/Facturas_Anuladas_Fechas.php?fecha1='+fecha1+'&fecha2='+fecha2,
            'win2',
            'status=yes,toolbar=yes,scrollbars=yes,titlebar=yes,menubar=yes,'+
            'resizable=yes,width=600,height=600,directories=no,location=no'+
            'fullscreen=yes');

        } 

    } else {

        swal({
                title: "Ops!",
                imageUrl: "web/assets/images/calendar.png",
                text: "Debes seleccionar 2 fechas",
                confirmButtonColor: "#EF5350"
         });


    }

}

/* EMERGENTE */
function facturar(VentaNo)
{

    var datos = 'idventa='+VentaNo;
    $.ajax({
        type:'POST',
        url:'web/ajax/ajxventafacturar.php',
        data: datos,
        cache: false,
        dataType: 'json',
        success: function(data){

          if(data != "Error"){
            alert(data);
            $('#reload-detalle').html(data);
          }

        },error: function() {
            alert("Comprobante Electronico no procesado");
            $('#reload-detalle').html(data);
        }
    });

}
/* EMERGENTE */