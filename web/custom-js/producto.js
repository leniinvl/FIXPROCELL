console.log("Init producto.js");

$(function() {

  $(document).on('click', '#print_activos', function(e){

       Print_Report('Activos');
       e.preventDefault();
  });

  $(document).on('click', '#print_inactivos', function(e){

       Print_Report('Inactivos');
       e.preventDefault();
 });

$(document).on('click', '#print_agotados', function(e){

       Print_Report('Agotados');
       e.preventDefault();
 });

$(document).on('click', '#print_vigentes', function(e){

       Print_Report('Vigentes');
       e.preventDefault();
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
    $('.dataTables_filter input[type=search]').attr('placeholder','Escriba para buscar...');


    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });


    jQuery.validator.addMethod("greaterThan",function (value, element, param) {
      var $min = $(param);
      if (this.settings.onfocusout) {
        $min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
          $(element).valid();
        });
      }return parseInt(value) > parseInt($min.val());}, "Maximo debe ser mayor a minimo");

    jQuery.validator.addMethod("lettersonly", function(value, element) {
         return this.optional(element) || /^[a-z\s 0-9 , . / () # -]+$/i.test(value);
    }, "No se permiten caracteres especiales");


     var validator2 = $("#frmPrint").validate({

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
        txtProductoP:{
          required: true
        },
        txtCodigoBarraP:{
          required: true
        },
        txtCant:{
          required: true
        },
        txtAncho:{
          required:true
        },
        txtAlto:{
          required: true
        }
      },
    validClass: "validation-valid-label",
     success: function(label) {
          label.addClass("validation-valid-label").text("Correcto.")
      },

       submitHandler: function (form) {
           Imprimir_Barra();
        }
     });

/**************************************************/
var validator = $("#frmFilter").validate({

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
    cbSucursal:{
        required: true
    },
    cbFCategoria:{
      required: true
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
/**************************************************/

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
        txtProducto:{
          maxlength:175,
          minlength: 4,
          required: true,
          //lettersonly:true
        },
        txtPCompra:{
          required: true
        },
        txtPVenta:{
          required: true
        },
        txtPVentaMinimo:{
          required: true
        },
        txtPVentaM:{
          required: false
        },
        txtPSuperM:{
          required: false
        },
        txtStock:{
          required:true
        },
        txtSMin:{
          required: true
        },
        cbCategoria:{
          required: true
        },
        cbMarca:{
          required: true
        },
        cbPresentacion:{ //modelo
          required: true
        },
        cbColor:{
          required: false
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
      
       $('#cbCategoria', form).change(function () {
            form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });

       $('#cbPresentacion', form).change(function () {
            form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });

       $('#cbColor', form).change(function () {
          form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });

    $('#btnEditar').hide();

    // Prefix
    $("#txtPCompra").TouchSpin({
        min: 0.00,
        max: 100000000,
        step: 0.01,
        decimals: 2,
        prefix: '<i class="icon-coin-dollar"></i>'
    });

    $("#txtPVenta").TouchSpin({
        min: 0.00,
        max: 100000000,
        step: 0.01,
        decimals: 2,
        prefix: '<i class="icon-coin-dollar"></i>'
    });

    $("#txtPVentaMinimo").TouchSpin({
        min: 0.00,
        max: 100000000,
        step: 0.01,
        decimals: 2,
        prefix: '<i class="icon-coin-dollar"></i>'
    });

    $("#txtPVentaM").TouchSpin({
      min: 0.00,
      max: 100000000,
      step: 0.01,
      decimals: 2,
      prefix: '$'
    });

    $("#txtPSuperM").TouchSpin({
      min: 0.00,
      max: 100000000,
      step: 0.01,
      decimals: 2,
      prefix: '$'
  });

    $("#txtSMin").TouchSpin({
        min: 0,
        max: 100000000,
        step: 1,
        decimals: 2,
        prefix: '<i class="icon-box-add"></i>'
    });

    $("#txtStock").TouchSpin({
        min: 0.00,
        max: 100000000,
        step: 1,
        decimals: 2,
        prefix: '<i class="icon-box"></i>'
    });

    $("#txtCant").TouchSpin({
        min: 0.00,
        max: 100000000,
        step: 5.00,
        decimals: 2
    });

    $("#txtAncho").TouchSpin({
        min: 0.00,
        max: 40.00,
        step: 0.01,
        decimals: 2,
        prefix: '<i class="icon-rulers"></i>'
    });

    $("#txtAlto").TouchSpin({
        min: 0.00,
        max: 100000000,
        step: 0.01,
        decimals: 2,
        prefix: '<i class="icon-rulers"></i>'
    });

    $('.select-search').select2();

        // Default initialization
    $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });

    $(document).on('click', '#delete_product', function(e){
      var productId = $(this).data('id');
      SwalDelete(productId);
      e.preventDefault();
    });

        /*Evento change de ChkEstado en el cual al chequear o deschequear cambia el label*/
    $("#chkEstado").change(function() {
        if(this.checked) {
           $("#chkEstado").val(true);
           document.getElementById("lblchk").innerHTML = 'VIGENTE';
        } else {
          $("#chkEstado").val(false);
          document.getElementById("lblchk").innerHTML = 'DESCONTINUADA';
        }
    });

    $("#chkPerece").change(function() {
        if(this.checked) {
           $("#chkPerece").val(true);
           document.getElementById("lblchk-p").innerHTML = 'PERECEDERO';
        } else {
          $("#chkPerece").val(false);
          document.getElementById("lblchk-p").innerHTML = 'NO PERECEDERO';
        }
    });

    $("#chkExento").change(function() {
        if(this.checked) {
           $("#chkExento").val(true);
           document.getElementById("lblchk-e").innerHTML = 'NO APLICA IVA';
        } else {
          $("#chkExento").val(false);
          document.getElementById("lblchk-e").innerHTML = 'APLICA IVA';
        }
    });

    $("#chkInven").change(function() {
        if(this.checked) {
           $("#chkInven").val(true);
           document.getElementById("lblchk-i").innerHTML = 'INVENTARIABLE';
        } else {
          $("#chkInven").val(false);
          document.getElementById("lblchk-i").innerHTML = 'NO INVENTARIABLE';
        }
    });

  $.fn.modal.Constructor.prototype.enforceFocus = function() {};


});

  function buscar_datos()
  {
  console.log("producto.js search");
  var idsucursal = $("#cbSucursal").val();
  var idcat = $("#cbFCategoria").val();

      if(idsucursal!="")
      {
          $.ajax({

            type:"GET",
            url:"web/ajax/reload-producto.php?id="+idsucursal+"&idcat="+idcat,
            success: function(data){
                $('#reload-div').html(data);
            }

        });
      }

  }

  function limpiarform(){

    var form = $( "#frmModal" ).validate();
    form.resetForm();

  }

  function setSwitchery(switchElement, checkedBool) {
    if((checkedBool && !switchElement.isChecked()) || (!checkedBool && switchElement.isChecked())) {
        switchElement.setPosition(true);
        switchElement.handleOnchange(true);
    }
}

function openBarcode(codigo_barra,codigo_interno,nombre_producto,idproducto){

   $('#modal_iconified_barcode').on('shown.bs.modal', function () {

      $('#txtIDP').val(idproducto);
      if(codigo_barra == ''){
        $('#txtCodigoBarraP').val(codigo_interno);
      } else {
        $('#txtCodigoBarraP').val(codigo_barra);
      }

      $('#txtProductoP').val(nombre_producto);

      $('#txtCodigoBarraP').prop( "disabled" ,  true);
      $('#txtProductoP').prop( "disabled" ,  true);

      var modal = $(this);

       modal.find('.title-form').text('Imprimir Codigo de Barra');
 
   });


}


function newProducto()
 {
    openProducto('nuevo',null,null,null,null,null,null,null,null,null,null);
    $('#modal_iconified').modal('show');
 }
function openProducto(action, idproducto, codigo_interno, codigo_barra, nombre_producto, precio_compra, precio_venta, precio_venta_minimo, precio_venta_mayoreo, precio_super_mayoreo, stock, stock_min, idcategoria, idmarca,
idpresentacion, estado, exento, inventariable, perecedero, idcolor)

 {
      var mySwitch = new Switchery($('#chkEstado')[0], {
          size:"small",
          color: '#0D74E9'
      });

      var mySwitch2 = new Switchery($('#chkPerece')[0], {
          size:"small",
          color: '#8E24AA'
      });

      var mySwitch3 = new Switchery($('#chkExento')[0], {
          size:"small",
          color: '#03A9F4'
      });

      var mySwitch4 = new Switchery($('#chkInven')[0], {
          size:"small",
          color: '#8BC34A'
      });

    $('#modal_iconified').on('shown.bs.modal', function () {
     var modal = $(this);
     if (action == 'nuevo'){

      $('#txtProceso').val('Registro');
      $('#txtID').val('');
      $('#txtCodigo').val('');
      $('#txtCodigoBarra').val('');
      $('#txtProducto').val('');
      $('#txtStock').val('');
      $('#txtPCompra').val('');
      $('#txtPVenta').val('');
      $('#txtPVentaMinimo').val('');
      $('#txtPVentaM').val('');
      $('#txtPSuperM').val('');
      $('#txtSMin').val('');
      $("#cbCategoria").select2("val", "All");
      $("#cbMarca").select2("val", "All");
      $("#cbPresentacion").select2("val", "All"); 
      $("#cbColor").select2("val", "All"); 
      setSwitchery(mySwitch, true);
      setSwitchery(mySwitch2, false);
      setSwitchery(mySwitch3, false);
      setSwitchery(mySwitch4, true);

      $('#txtCodigo').prop( "disabled" , false);
      $('#txtCodigoBarra').prop( "disabled" , false);
      $('#txtProducto').prop( "disabled" , false);
      $('#txtStock').prop( "disabled" , false);
      $('#txtPCompra').prop( "disabled" , false);
      $('#txtPVenta').prop( "disabled" , false);
      $('#txtPVentaMinimo').prop( "disabled" , false);
      $('#txtPVentaM').prop( "disabled" , false);
      $('#txtPSuperM').prop( "disabled" , false);
      $('#txtSMin').prop( "disabled" , false);
      $('#cbCategoria').prop( "disabled" , false);
      $('#cbMarca').prop( "disabled" , false);
      $('#cbPresentacion').prop( "disabled" , false);
      $('#cbColor').prop( "disabled" , false);
      $('#chkEstado').prop( "disabled" , true);
      $('#chkPerece').prop( "disabled" , false);
      $('#chkExento').prop( "disabled" , false);
      $('#chkInven').prop( "disabled" , false);


      $('#btnEditar').hide();
      $('#btnGuardar').show();
      limpiarform();

      modal.find('.title-form').text('Ingresar Producto');
     }else if(action=='editar') {

      $('#modal_iconified').modal('show');

      $('#txtProceso').val('Edicion');
      $('#txtID').val(idproducto);
      $('#txtCodigo').val(codigo_interno);
      $('#txtCodigoBarra').val(codigo_barra);
      $('#txtProducto').val(nombre_producto);
      $('#txtStock').val(stock);
      $('#txtPCompra').val(precio_compra);
      $('#txtPVenta').val(precio_venta);
      $('#txtPVentaMinimo').val(precio_venta_minimo);
      $('#txtPVentaM').val(precio_venta_mayoreo);
      $('#txtPSuperM').val(precio_super_mayoreo);
      $('#txtSMin').val(stock_min);
      $("#cbCategoria").val(idcategoria).trigger("change");
      $("#cbMarca").val(idmarca).trigger("change");
      $("#cbPresentacion").val(idpresentacion).trigger("change");
      $("#cbColor").val(idcolor).trigger("change");

      if (estado == '1')
        {
          $("#chkEstado").val(true);
          setSwitchery(mySwitch, true);
          document.getElementById("chkEstado").checked = true;
          document.getElementById("lblchk").innerHTML = 'VIGENTE';
        }else {
          $("#chkEstado").val(false);
          setSwitchery(mySwitch, false);
          document.getElementById("chkEstado").checked = false;
          document.getElementById("lblchk").innerHTML = 'DESCONTINUADO';
        }

       if (perecedero == '1')
        {
          $("#chkPerece").val(true);
          setSwitchery(mySwitch2, true);
          document.getElementById("chkPerece").checked = true;
          document.getElementById("lblchk-p").innerHTML = 'PERECEDERO';
        }else {
          $("#chkPerece").val(false);
          setSwitchery(mySwitch2, false);
          document.getElementById("chkPerece").checked = false;
          document.getElementById("lblchk-p").innerHTML = 'NO PERECEDERO';
        }

        if (exento == '1')
          {
            $("#chkExento").val(true);
            setSwitchery(mySwitch3, true);
            document.getElementById("chkExento").checked = true;
            document.getElementById("lblchk-e").innerHTML = 'NO APLICA IVA';
          }else {
            $("#chkExento").val(false);
            setSwitchery(mySwitch3, false);
            document.getElementById("chkExento").checked = false;
            document.getElementById("lblchk-e").innerHTML = 'APLICA IVA';
          }

        if (inventariable == '1')
        {
          $("#chkInven").val(true);
          setSwitchery(mySwitch4, true);
          document.getElementById("chkInven").checked = true;
          document.getElementById("lblchk-i").innerHTML = 'INVENTARIABLE';
        }else {
          $("#chkInven").val(false);
          setSwitchery(mySwitch4, false);
          document.getElementById("chkInven").checked = false;
          document.getElementById("lblchk-i").innerHTML = 'NO INVENTARIABLE';
        }

      $('#txtCodigo').prop( "disabled" , false);
      $('#txtCodigoBarra').prop( "disabled" , false);
      $('#txtProducto').prop( "disabled" , false);
      $('#txtStock').prop( "disabled" , false);
      $('#txtPCompra').prop( "disabled" , false);
      $('#txtPVenta').prop( "disabled" , false);
      $('#txtPVentaMinimo').prop( "disabled" , false);
      $('#txtPVentaM').prop( "disabled" , false);
      $('#txtPSuperM').prop( "disabled" , false);
      $('#txtSMin').prop( "disabled" , false);
      $('#cbCategoria').prop( "disabled" , false);
      $('#cbMarca').prop( "disabled" , false);
      $('#cbPresentacion').prop( "disabled" , false);
      $('#cbColor').prop( "disabled" , false);
      $('#chkEstado').prop( "disabled" , false);
      $('#chkPerece').prop( "disabled" , false);
      $('#chkExento').prop( "disabled" , false);
      $('#chkInven').prop( "disabled" , false);


      $('#btnEditar').show();
      $('#btnGuardar').hide();

      modal.find('.title-form').text('Actualizar Producto');
     } else if(action=='ver'){
      $('#txtProceso').val('');
      $('#txtID').val(idproducto);
      $('#txtCodigo').val(codigo_interno);
      $('#txtCodigoBarra').val(codigo_barra);
      $('#txtProducto').val(nombre_producto);
      $('#txtStock').val(stock);
      $('#txtPCompra').val(precio_compra);
      $('#txtPVenta').val(precio_venta);
      $('#txtPVentaMinimo').val(precio_venta_minimo);
      $('#txtPVentaM').val(precio_venta_mayoreo);
      $('#txtPSuperM').val(precio_super_mayoreo);
      $('#txtSMin').val(stock_min);
      $("#cbCategoria").val(idcategoria).trigger("change");
      $("#cbMarca").val(idmarca).trigger("change");
      $("#cbPresentacion").val(idpresentacion).trigger("change");
      $("#cbColor").val(idcolor).trigger("change");

      if (estado == '1')
        {
          $("#chkEstado").val(true);
          setSwitchery(mySwitch, true);
          document.getElementById("chkEstado").checked = true;
          document.getElementById("lblchk").innerHTML = 'VIGENTE';
        }else {
          $("#chkEstado").val(false);
          setSwitchery(mySwitch, false);
          document.getElementById("chkEstado").checked = false;
          document.getElementById("lblchk").innerHTML = 'DESCONTINUADO';
        }

       if (perecedero == '1')
        {
          $("#chkPerece").val(true);
          setSwitchery(mySwitch2, true);
          document.getElementById("chkPerece").checked = true;
          document.getElementById("lblchk-p").innerHTML = 'PERECEDERO';
        }else {
          $("#chkPerece").val(false);
          setSwitchery(mySwitch2, false);
          document.getElementById("chkPerece").checked = false;
          document.getElementById("lblchk-p").innerHTML = 'NO PERECEDERO';
        }

        if (exento == '1')
          {
            $("#chkExento").val(true);
            setSwitchery(mySwitch3, true);
            document.getElementById("chkExento").checked = true;
            document.getElementById("lblchk-e").innerHTML = 'NO APLICA IVA';
          }else {
            $("#chkExento").val(false);
            setSwitchery(mySwitch3, false);
            document.getElementById("chkExento").checked = false;
            document.getElementById("lblchk-e").innerHTML = 'APLICA IVA';
          }

        if (inventariable == '1')
        {
          $("#chkInven").val(true);
          setSwitchery(mySwitch4, true);
          document.getElementById("chkInven").checked = true;
          document.getElementById("lblchk-i").innerHTML = 'INVENTARIABLE';
        }else {
          $("#chkInven").val(false);
          setSwitchery(mySwitch4, false);
          document.getElementById("chkInven").checked = false;
          document.getElementById("lblchk-i").innerHTML = 'NO INVENTARIABLE';
        }


      $('#txtCodigo').prop( "disabled" , true);
      $('#txtCodigoBarra').prop( "disabled" , true);
      $('#txtProducto').prop( "disabled" , true);
      $('#txtStock').prop( "disabled" , true);
      $('#txtPCompra').prop( "disabled" , true);
      $('#txtPVenta').prop( "disabled" , true);
      $('#txtPVentaMinimo').prop( "disabled" , true);
      $('#txtPVentaM').prop( "disabled" , true);
      $('#txtPSuperM').prop( "disabled" , true);
      $('#txtSMin').prop( "disabled" , true);
      $('#cbCategoria').prop( "disabled" , true);
      $('#cbMarca').prop( "disabled" , true);
      $('#cbPresentacion').prop( "disabled" , true);
      $('#cbColor').prop( "disabled" , true);
      $('#chkEstado').prop( "disabled" , true);
      $('#chkPerece').prop( "disabled" , true);
      $('#chkExento').prop( "disabled" , true);
      $('#chkInven').prop( "disabled" , true);


      $('#btnEditar').hide();
      $('#btnGuardar').hide();

      modal.find('.title-form').text('Ver Producto');
     }

  });

}

function enviar_frm()
{
  console.log("producto.js save");
  var urlprocess = 'web/ajax/ajxproducto.php';
  var proceso = $("#txtProceso").val();
  var id = $("#txtID").val();
  var codigo_barra =$("#txtCodigoBarra").val();
  var nombre_producto =$("#txtProducto").val();
  var precio_compra  =$("#txtPCompra").val();
  var precio_venta =$("#txtPVenta").val();
  var precio_venta_minimo  =$("#txtPVentaMinimo").val();
  var precio_venta_mayoreo  =$("#txtPVentaM").val();
  var precio_super_mayoreo  =$("#txtPSuperM").val();
  var stock = $("#txtStock").val();
  var stock_min =$("#txtSMin").val();
  var idcategoria  =$("#cbCategoria").val();
  var idmarca  =$("#cbMarca").val();
  var idpresentacion  =$("#cbPresentacion").val();
  var idcolor  =$("#cbColor").val();
  var estado = $('#chkEstado').is(':checked') ? 1 : 0;
  var exento = $('#chkExento').is(':checked') ? 1 : 0;
  var perecedero = $('#chkPerece').is(':checked') ? 1 : 0;
  var inventariable = $('#chkInven').is(':checked') ? 1 : 0; 

  if (idmarca == null)
  {
    idmarca = '';
  }
  if (idpresentacion == null)
  {
    idpresentacion = '';
  }
  if (idcolor == null)
  {
    idcolor = '';
  }

  var dataString='proceso='+proceso+'&id='+id+'&codigo_barra='+codigo_barra+'&nombre_producto='+nombre_producto+'&precio_compra='+precio_compra;
  dataString+='&precio_venta='+precio_venta+'&precio_venta_mayoreo='+precio_venta_mayoreo+'&precio_super_mayoreo='+precio_super_mayoreo+'&stock='+stock+'&stock_min='+stock_min+'&idcategoria='+idcategoria;
  dataString+='&idmarca='+idmarca+'&idpresentacion='+idpresentacion+'&estado='+estado+'&exento='+exento+'&inventariable='+inventariable+'&perecedero='+perecedero+'&idcolor='+idcolor+'&precio_venta_minimo='+precio_venta_minimo;

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
                  text: "Producto registrado",
                  confirmButtonColor: "#66BB6A",
                  type: "success"
              });

              $('#modal_iconified').modal('toggle');

              cargarDiv("#reload-div","web/ajax/reload-producto.php");
              limpiarform();

              } else if(proceso == "Edicion") {


                  swal({
                      title: "Exito!",
                      timer: 1000,
                      text: "Producto modificado",
                      confirmButtonColor: "#2196F3",
                      type: "info"
                  });
                   $('#modal_iconified').modal('toggle');
                  cargarDiv("#reload-div","web/ajax/reload-producto.php");

              }

        } else if (data=="Duplicado"){

           swal({
                  title: "Ops!",
                  text: "El dato que ingresaste ya existe",
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
            title: "Lo sentimos...",
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

function Print_Report(Criterio)
{
  var sucursal=$("#cbSucursal").val();
  var categoria=$("#cbFCategoria").val();
  if (sucursal!=null && categoria!=null) {

      if(Criterio == 'Activos')
      {
          window.open('reportes/Productos_Activos.php?id='+sucursal+'&categoria='+categoria,
          'win2','status=yes,toolbar=yes,scrollbars=yes,titlebar=yes,menubar=yes,'+
          'resizable=yes,width=800,height=800,directories=no,location=no'+
          'fullscreen=yes');

      } else if (Criterio == 'Inactivos') {

          window.open('reportes/Productos_Inactivos.php?id='+sucursal+'&categoria='+categoria,
          'win2','status=yes,toolbar=yes,scrollbars=yes,titlebar=yes,menubar=yes,'+
          'resizable=yes,width=600,height=600,directories=no,location=no'+
          'fullscreen=yes');

      } else if (Criterio == 'Agotados') {

          window.open('reportes/Productos_Agotados.php?id='+sucursal+'&categoria='+categoria,
          'win2','status=yes,toolbar=yes,scrollbars=yes,titlebar=yes,menubar=yes,'+
          'resizable=yes,width=600,height=600,directories=no,location=no'+
          'fullscreen=yes');

      } else if (Criterio == 'Vigentes'){

          window.open('reportes/Productos_Vigentes.php?id='+sucursal+'&categoria='+categoria,
          'win2','status=yes,toolbar=yes,scrollbars=yes,titlebar=yes,menubar=yes,'+
          'resizable=yes,width=600,height=600,directories=no,location=no'+
          'fullscreen=yes');
      }
    } else {


      swal({
              title: "No pudimos generarlo!",
              imageUrl: "web/assets/images/trolley.png",
              text: "Debes seleccionar una SUCURSAL y CATEGORIA...",
              confirmButtonColor: "#EF5350"
       });

    }


}

function Imprimir_Barra(){

      var id = $("#txtIDP").val();
      var cant = $("#txtCant").val();
      var ancho = $("#txtAncho").val();
      var alto = $("#txtAlto").val();

      window.open('reportes/Print_Barras.php?ref='+btoa(id)+'&ancho='+ancho+'&alto='+alto+'&cant='+cant,
      'win2',
      'status=yes,toolbar=yes,scrollbars=yes,titlebar=yes,menubar=yes,'+
      'resizable=yes,width=900,height=600,directories=no,location=no'+
      'fullscreen=yes');
}

function SwalDelete(productId){
  swal({
    title: "¿Está seguro que desea eliminar permanentemente el producto?",
    text: "Este proceso es irreversible!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#EF5350",
    confirmButtonText: "Si, Eliminar",
    cancelButtonText: "No, volver atras",
    closeOnConfirm: false,
    closeOnCancel: false
},
function(isConfirm){
    if (isConfirm) {
         return new Promise(function(resolve) {
            $.ajax({
            url: 'web/ajax/ajxproductodelete.php',
            type: 'POST',
            data: 'proceso=Eliminar&id='+productId,
            dataType: 'json'
            })
            .done(function(response){
             swal('Eliminado!', response.message, response.status);
             cargarDiv("#reload-div","web/ajax/reload-producto.php");
            })
            .fail(function(){
             swal('Oops...', 'Algo salio mal al procesar tu peticion!', 'error');
            });
         });
    }
    else {
        swal({
            title: "Eliminación cancelada",
            text: "Puedes seguir donde te quedaste",
            confirmButtonColor: "#2196F3",
            type: "info"
        });
    }
});

}

function IrInventario(){
  swal({
    title: "Abrir Inventario",
    text: "A continuacion debe abrir el inventario para este nuevo mes",
    confirmButtonColor: "#EF5350",
    imageUrl: "web/assets/images/unpacking.png"
  },
  function() {
  setTimeout(function() {
    window.location.href = "?View=Abrir-Inventario";
  }, 1200);
  });
}
