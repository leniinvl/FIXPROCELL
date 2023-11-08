<?php 

	session_set_cookie_params(60*60*24*365); session_start();
	$idsucursal = $_SESSION['sucursal_id'];

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";
	
		require_once($model);
		require_once($controller);
	}); 

	$funcion = new Caja();

	  $iva = isset($_GET['movimientos']) ? $_GET['movimientos'] : '';
		if(!$iva==""){
			$funcion->Get_Movimientos($idsucursal);
		}

	if(isset($_POST['proceso'])){
		
		try {

			$proceso = $_POST['proceso'];

			if($proceso != 'Validar' && $proceso!='Cerrar-M'){
				$monto = trim($_POST['monto']);
				$cantidad = trim($_POST['cantidad']);
				$descripcion = trim($_POST['descripcion']);
			} else if ($proceso == 'Cerrar-M'){
				$id = trim($_POST['id']);
			}


			switch($proceso){

			case 'Validar':
				$funcion->Validar_Caja($idsucursal);
			break;

			case 'Abrir':
				$funcion->Abrir_Caja($cantidad, $idsucursal);
			break;

			case 'Update':
				$funcion->Update_Caja($cantidad, $idsucursal);
			break;

			case 'Cerrar':
				$funcion->Cerrar_Caja($cantidad, $idsucursal);
			break;

			case 'Cerrar-M':
				$funcion->Cerrar_Caja_Manual($id);
			break;

			case 'Devolucion':
				$funcion->Insertar_Movimiento(2,$monto,$descripcion,$idsucursal);
			break;

			case 'Prestamo':
				$funcion->Insertar_Movimiento(3,$monto,$descripcion,$idsucursal);
			break;

			case 'Gasto':
				$funcion->Insertar_Movimiento(4,$monto,$descripcion,$idsucursal);
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
