<?php 

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";
	
		require_once($model);
		require_once($controller);
	});

	$funcion = new Login();

	if(isset($_POST['usuario']) && isset($_POST['password'])){
		
		try {

			$user = trim($_POST['usuario']);
			$pass = trim($_POST['password']);

			$funcion->Restaurar_Password($user,$pass);

	
		} catch (Exception $e) {
			
			$data = "Error";
 	   		echo json_encode($data);
			
		}

	}

	


?>