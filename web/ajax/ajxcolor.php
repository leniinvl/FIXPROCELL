<?php 

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";
	
		require_once($model);
		require_once($controller);
	});

	$funcion = new Color();

	if(isset($_POST['color'])){
		
		try {

			$proceso = $_POST['proceso'];
			$id = $_POST['id'];
			$color = trim($_POST['color']);

			switch($proceso){

			case 'Registro':
				$funcion->Insertar_Color($color);
			break;

			case 'Edicion':
				$funcion->Editar_Color($id,$color);
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
