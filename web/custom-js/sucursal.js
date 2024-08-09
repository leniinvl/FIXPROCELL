$(function() {

  // Table setup
  // ------------------------------

  // Setting datatable defaults
  $.extend( $.fn.dataTable.defaults, {
      autoWidth: false,
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

    $('.select-search').select2();


  jQuery.validator.addMethod("greaterThan",function (value, element, param) {
    var $min = $(param);
    if (this.settings.onfocusout) {
      $min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
        $(element).valid();
      });
    }return parseInt(value) > parseInt($min.val());}, "Maximo debe ser mayor a minimo");

  jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-z\s 0-9, / # . ()]+$/i.test(value);
  }, "No se permiten caracteres especiales");


   var validator = $("#frmModal").validate({

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
      cbMoneda:{
        required:true
      },
      txtSucursal:{
        maxlength:200,
        minlength: 4,
        required: true,
        //lettersonly:true
      },
      txtDireccion:{
        minlength:4,
        maxlength:270
      },
      txtTelefono:{
        maxlength:70,
      }
    },
  validClass: "validation-valid-label",
   success: function(label) {
        label.addClass("validation-valid-label").text("Correcto.")
    },

     submitHandler: function (form) {
         enviar_frm();
      }
   });

   var form = $('#frmModal');

    $('#cbMoneda', form).change(function () {
         form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
     });

  $('#btnEditar').hide();

$.fn.modal.Constructor.prototype.enforceFocus = function() {};


});

function limpiarform(){

  var form = $( "#frmModal" ).validate();
  form.resetForm();

}


function newSucursal()
{
  openParametro('nuevo',null,null,null);
  $('#modal_iconified').modal('show');
}
function openParametro(action, idsucursal, nombre, direccion, telefono)
{

  $('#modal_iconified').on('shown.bs.modal', function () {
   var modal = $(this);
   if (action == 'nuevo'){

    $('#txtProceso').val('Registro');
    $('#txtSucursal').val('');
    $('#txtDireccion').val('');
    $('#txtTelefono').val('');

    $('#txtSucursal').prop( "disabled" , false);
    $('#txtDireccion').prop( "disabled" , false);
    $('#txtTelefono').prop( "disabled" , false);
    
    $('#btnEditar').hide();
    $('#btnGuardar').show();
    limpiarform();

    modal.find('.title-form').text('Ingresar Establecimiento');
   }else if(action=='editar') {

    $('#modal_iconified').modal('show');

    $('#txtProceso').val('Edicion');
    $('#txtID').val(idsucursal);
    $('#txtSucursal').val(nombre);
    $('#txtDireccion').val(direccion);
    $('#txtTelefono').val(telefono);


    $('#txtSucursal').prop( "disabled" , false);
    $('#txtDireccion').prop( "disabled" , false);
    $('#txtTelefono').prop( "disabled" , false);

    $('#btnEditar').show();
    $('#btnGuardar').hide();

    modal.find('.title-form').text('Actualizar Establecimiento');
   } else if(action=='ver'){
    $('#txtProceso').val('');
    $('#txtID').val(idsucursal);
    $('#txtSucursal').val(nombre);
    $('#txtDireccion').val(direccion);
    $('#txtTelefono').val(telefono);


    $('#txtSucursal').prop( "disabled" , true);
    $('#txtDireccion').prop( "disabled" , true);
    $('#txtTelefono').prop( "disabled" , true);

    $('#btnEditar').hide();
    $('#btnGuardar').hide();

    modal.find('.title-form').text('Ver Establecimiento');
   }

});

}

function enviar_frm()
{ 
var urlprocess = 'web/ajax/ajxsucursal.php';
var proceso = $("#txtProceso").val();
var id = $("#txtID").val();
var nombre =$("#txtSucursal").val();
var direccion =$("#txtDireccion").val();
var telefono =$("#txtTelefono").val();

var dataString='proceso='+proceso+'&id='+id+'&nombre='+nombre+'&direccion='+direccion;
dataString+='&telefono='+telefono;


$.ajax({
   type:'POST',
   url:urlprocess,
   data: dataString,
   dataType: 'json',
   success: function(data){

      if(data=="Validado"){

           if(proceso=="Registro"){

            swal({
                title: "Exito!",
                timer: 1000,
                text: "Sucursal registrado correctamente",
                confirmButtonColor: "#66BB6A",
                type: "success"
            });

            $('#modal_iconified').modal('toggle');

            cargarDiv("#reload-div","web/ajax/reload-sucursal.php");
            limpiarform();

            } else if(proceso == "Edicion") {


                swal({
                    title: "Exito!",
                    timer: 1000,
                    text: "Sucursal modificado correctamente",
                    confirmButtonColor: "#2196F3",
                    type: "info"
                });
                 $('#modal_iconified').modal('toggle');
                cargarDiv("#reload-div","web/ajax/reload-sucursal.php");

            }

      } else if (data=="Duplicado"){

         swal({
                title: "Lo sentimos!",
                text: "La sucursal ya existe en el sistema",
                confirmButtonColor: "#EF5350",
                type: "warning"
         });


      } else if(data =="Error"){

             swal({
              title: "Lo sentimos...",
              text: "No procesamos bien tus datos!",
              confirmButtonColor: "#EF5350",
              type: "error"
          });
      }

   },error: function() {

       swal({
          title: "Lo sentimos ...",
          text: "Algo sucedio mal!",
          confirmButtonColor: "#EF5350",
          type: "error"
      });


   }

});

}

function cargarDiv(div,url)
{
    $(div).load(url);
}