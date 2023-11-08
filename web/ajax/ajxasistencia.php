<?php
	
	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	}); 

	$objEmpleado =  new Usuario();

	if(!empty($_POST)){

		$fecha = $_POST["fecha_registro"];
		$idempleado = $_POST["empleado_id"];
		$asistencia_tipo = $_POST["tipo"];
		
		$asistencia = $objEmpleado->Consulta_asistencia($idempleado, $fecha);
		
		if($asistencia==null && $asistencia_tipo!=""){
			$objEmpleado->Registro_asistencia($idempleado, $fecha, $asistencia_tipo);
		}else if($asistencia=!null && $asistencia_tipo!=""){
			$objEmpleado->Update_asistencia($idempleado, $fecha, $asistencia_tipo);
		}else if($asistencia_tipo==""){
			$objEmpleado->Delete_asistencia($idempleado, $fecha);
		}
	}

?>
