<?php

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	}); 

	$funcion = new Producto();

	if (!empty($_POST))
	{
	if(isset($_POST['idproducto'])){
 
		try {

			$proceso = trim($_POST['proceso']);
			$id = trim($_POST['id']);
			$idproducto = trim($_POST['idproducto']);
			$codigo_uno = trim($_POST['codigo_uno']);
			$codigo_dos = trim($_POST['codigo_dos']);
			
			switch($proceso){

			case 'Registro':
				$funcion->Insertar_CodigoProducto($codigo_uno, $codigo_dos, $idproducto);
			break;

			case 'Edicion':
				$funcion->Editar_CodigoProducto($id, $codigo_uno, $codigo_dos, $idproducto);
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
