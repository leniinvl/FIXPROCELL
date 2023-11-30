$(function() {

    // Table setup
    // ------------------------------

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


     var validator = $("#frmResend").validate({

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
        passwordr:{
          minlength: 4,
          required: true
        },
        rpasswordr:{
          minlength: 4,
          required: true,
          equalTo: "#passwordr"
        }
      },
      messages: {
        passwordr: {
            required: "Este campo es obligatorio.",
            minlength: "Por favor, se requiere mas de 4 caracteres."
        },
        rpasswordr: {
            required: "Este campo es obligatorio.",
            minlength: "Por favor, se requiere mas de 4 caracteres.",
            equalTo: "Por favor, ingrese la misma contraseña nueva."
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

});

function limpiarform(){

  var form = $( "#frmResend" ).validate();
  form.resetForm();

}

function enviar_frm()
{
  var urlprocess = 'web/ajax/ajxpassword.php';
  var usuario =$("#usernamer").val();
  var password = $("#passwordr").val();
  var passwordRepit = $("#rpasswordr").val();

  var dataString='usuario='+usuario+'&password='+password;
  console.log(dataString)
  if(password != passwordRepit){

    swal({
      title: "Contraseñas no coinciden!",
      text: "Asegurese de ingresar la contrañas correctamente",
      confirmButtonColor: "#16A085",
      imageUrl: "web/assets/images/unlock.gif",
      confirmButtonText: "Aceptar",
      timer: 1500
    });

  }else{

    $.ajax({
      type:'POST',
      url:urlprocess,
      data: dataString,
      dataType: 'json',
      success: function(data){
 
        if(data!="Error"){
    
            swal({
                title: "Exito!",
                timer: 1000,
                text: "Constraseña actualizada correctamente",
                confirmButtonColor: "#66BB6A",
                type: "success"
            },function() {
                setTimeout(function() {
                  window.location.href = "./?View=Inicio";
                }, 500);
            });

        } else {

          swal('Lo sentimos, no pudimos registrar tu informacion!', "Intentalo nuevamente", "error");

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
}

$('#cancelPass').click(function(){
  window.location.href = "./?View=Inicio";
});

$('#viewPassword').click(function(){
  visibility();
});

function visibility() {
  
  var eye = document.getElementById("viewPassword");
  eye.classList.toggle("icon-eye");
  eye.classList.toggle("icon-eye-blocked");

  var x = document.getElementById("passwordr");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

  var y = document.getElementById("rpasswordr");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }

}