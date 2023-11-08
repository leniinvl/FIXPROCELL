<?php

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	}); 

	$funcion = new Venta();

	if (isset($_POST['idproducto']))
	{
		try {

			$idproducto = trim($_POST['idproducto']);
			$tipoprecio = trim($_POST['tipoprecio']);
		
			$funcion->precio_producto($idproducto, $tipoprecio);

		} catch (Exception $e) {
			$data = "Error";
 	   	 	echo json_encode($data);
		}

	}

?>
