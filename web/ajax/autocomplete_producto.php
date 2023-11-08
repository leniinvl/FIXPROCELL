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

	 $keyword = trim($_REQUEST['term']);

	 $idsucursalcom = isset($_GET['id']) ? $_GET['id'] : '';
	 $funcion->Autocomplete_Producto($keyword, $idsucursalcom);
	  

?>