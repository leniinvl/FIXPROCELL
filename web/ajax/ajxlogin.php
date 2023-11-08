<?php 

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";
	
		require_once($model);
		require_once($controller);
	});
	$funcion = new Login();

 
	//Con este codigo hago logout

	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		#destruyo las sesiones muajajaja
		/*unset($_SESSION['user_name']);
		unset($_SESSION['user_tipo']);
		unset($_SESSION['user_name']);*/
		
		unset($_SESSION['user_id']);
		unset($_SESSION['user_name']); 
		unset($_SESSION['user_tipo']);
		unset($_SESSION['user_cargo']);
		unset($_SESSION['user_empleado']);
		unset($_SESSION['sucursal_name']);
		unset($_SESSION['sucursal_id']);

		if(session_destroy())
		{ 
			echo "<script>window.location.href = '../../?View=Login'</script>";
		}
	}

	//Con este codigo hago logout


	if(isset($_POST['usuario']) && isset($_POST['password']) && isset($_POST['nombre']) && isset($_POST['proceso'])){
		
		try {
			$proceso = trim($_POST['proceso']);
			$usuario = trim($_POST['usuario']);
			$password = trim($_POST['password']);
			$nombre = trim($_POST['nombre']);

			switch($proceso)
			{

				case 'login':
					$funcion->Login_Usuario($usuario,base64_decode($password),$nombre);
				break;

			}


			
	
		} catch (Exception $e) {
			
			$data = "Fake";
 	   		echo json_encode($data);
		}

	}

	


?>