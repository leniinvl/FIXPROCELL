<?php

	session_set_cookie_params(60*60*24*365); session_start();
	$idsucursal = $_SESSION['sucursal_id'];
	
	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	});

	$funcion = new Producto();

	if(isset($_POST['id'])){

		try {

			$proceso = $_POST['proceso'];
			$id = $_POST['id'];
			
			switch($proceso){

			case 'Eliminar':
				$funcion->Elimimar_Producto($id);
			break;

			default:
				$data = "Error";
 	   		 	echo json_encode($data);
			break;
		}

		} catch (Exception $e) {

			$data = "Error";
 	   		echo json_encode($data);
		}

	}

?>
