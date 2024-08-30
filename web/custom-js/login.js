/* ------------------------------------------------------------------------------
*
*  # Login form with validation
*
*  Specific JS code additions for login_validation.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {


  // Style checkboxes and radios
  $("#error-user").hide();

  $('.styled').uniform();

    // Setup validation
    $(".form-validate").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
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

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        /* validClass: "validation-valid-label",
        success: function(label) {
            label.addClass("validation-valid-label").text("Correcto")
        },*/
        rules: {
            nombre:{
                required:true,
            },
            username: {
                required:true,
                maxlength: 16,
                minlength:4
            },
            password:{
                required:true,
                minlength:4,
                maxlength: 20
            }
        },
        messages: {
            nombre:{
                required:"Seleccione un establecimiento",
            },
            username:{
                required:"Ingrese su usuario",
                maxlength :"No pueden ser mas de 8 caracteres",
                minlength: jQuery.validator.format("Debe ingresar {0} caracteres minimo")
            },
            password: {
                required: "Ingrese su contraseña",
                maxlength :"No pueden ser mas de 12 caracteres",
                minlength: jQuery.validator.format("Debe ingresar {0} caracteres minimo")
            }
        },
        submitHandler: function(form) {
                enviar_frm(); // form validation success, call ajax form submit
            }
    });

});


function enviar_frm()
{
     var urlprocess = 'web/ajax/ajxlogin.php';
     var usuario=$("#username").val();
     var password=$("#password").val();
     var nombre=$("#nombre").val();

     var dataString='usuario='+usuario+'&password='+btoa(password)+'&nombre='+nombre;

     $.ajax({
            type:'POST',
            url:urlprocess,
            data: dataString+'&proceso=login',
            dataType: 'json',
            success: function(data){

             if(data == "Validado"){
              swal({ title: "Bienvenido...",
              confirmButtonColor: "#16A085", /*CAMBIO COLOR BOTON*/
              confirmButtonText: "Ingresar",
              imageUrl: "web/assets/images/unlock.gif"});
              setTimeout(function(){
                  window.location.href = "./?View=Inicio";
                }, 1000);

               } else if (data == "Bad Pass"){ 

                    swal({
                            title: "Verifica tus datos de sesion!",
                            text: "Tu usuario o contraseña son incorrectos",
                            confirmButtonColor: "#EF5350",
                            type: "warning"
                     });
                } else if (data == "Inactive"){

                    swal({
                            title: "Se ha desactivado tu usuario!",
                            text: "Para ingresar, comunicate con el Administrador",
                            confirmButtonColor: "#EF5350",
                            type: "error"
                     });
                }

            }, // END THIRST SUCCESS
             error: function() {

                swal({
                title: "Lo sentimos...",
                text: "No pudimos ingresarte al sistema!",
                confirmButtonColor: "#EF5350",
                type: "error"
                });
           }

         }); /// END THIRST AJAX

}
