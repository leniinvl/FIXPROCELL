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

	if(isset($_POST['nombre_producto']) && isset($_POST['precio_compra']) && isset($_POST['precio_venta'])){

		try {

			$proceso = $_POST['proceso'];
			$id = $_POST['id'];
			$codigo_barra = trim($_POST['codigo_barra']);
			$nombre_producto = trim($_POST['nombre_producto']);
			$precio_compra = trim($_POST['precio_compra']);
			$precio_venta = trim($_POST['precio_venta']);
			$precio_venta_mayoreo = trim($_POST['precio_venta_mayoreo']);
			$precio_super_mayoreo = trim($_POST['precio_super_mayoreo']);
			$stock = trim($_POST['stock']);
			$stock_min = trim($_POST['stock_min']);
			$idcategoria = trim($_POST['idcategoria']);
			$idmarca = trim($_POST['idmarca']);
			$idpresentacion = trim($_POST['idpresentacion']);
			$estado = trim($_POST['estado']);
			$exento = trim($_POST['exento']);
			$inventariable = trim($_POST['inventariable']);
			$perecedero = trim($_POST['perecedero']);
			$idcolor = trim($_POST['idcolor']);
			$precio_venta_minimo = trim($_POST['precio_venta_minimo']);


			/* N/A = 1 */
			if($idmarca == '') 
			{
				$idmarca = NULL;
			}
			if($idpresentacion == '') 
			{
				$idpresentacion = NULL;
			}
			if($idcolor == '') 
			{
				$idcolor = 1;
			}


			switch($proceso){

			case 'Registro':
				$funcion->Insertar_Producto($codigo_barra,$nombre_producto,$precio_compra,$precio_venta,
				$precio_venta_mayoreo,$precio_super_mayoreo,$stock,$stock_min,
				$idcategoria,$idmarca,$idpresentacion,$exento,$inventariable,$perecedero, $idsucursal,$idcolor,$precio_venta_minimo);
			break;

			case 'Edicion':
				$funcion->Editar_Producto($id,$codigo_barra, $nombre_producto, $precio_compra, $precio_venta, $precio_venta_mayoreo,$precio_super_mayoreo,
				$stock, $stock_min, $idcategoria, $idmarca, $idpresentacion, $estado, $exento, $inventariable, $perecedero, $idsucursal,$idcolor,$precio_venta_minimo);
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
