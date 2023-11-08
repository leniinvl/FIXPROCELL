<?php
	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	}); 

	$funcion = new Sucursal();

	if (!empty($_POST))
	{
	if(isset($_POST['nombre'])){
 
		try {

			$proceso = trim($_POST['proceso']);
			$id = trim($_POST['id']);
			$nombre = trim($_POST['nombre']);
			$direccion = trim($_POST['direccion']);
			$telefono = trim($_POST['telefono']);
			
			switch($proceso){

			case 'Registro':
				$funcion->Insertar_Sucursal($nombre, $direccion, $telefono);
			break;

			case 'Edicion':
				$funcion->Editar_Sucursal($id, $nombre, $direccion, $telefono);
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

}



?>
