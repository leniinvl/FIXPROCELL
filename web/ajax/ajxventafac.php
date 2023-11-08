<?php 

	session_set_cookie_params(60*60*24*365); session_start();
	$idsucursal = $_SESSION['sucursal_id'];

	//Clases Facturacion
	include("../facturacionphp/controladores/ctr_xml.php");
	include("../facturacionphp/controladores/ctr_firmarxml.php");

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";
	
		require_once($model);
		require_once($controller);
	});

	$funcion = new Venta();

	if(isset($_POST['idcliente'])){
		
		try {

			$idcliente = $_POST['idcliente'];
			/*******************************/
			/*******************************/
			//FACTURACION ELECTRONICA V1.0.0		
			/*******************************/
			/*******************************/
			//Obtener identificador venta
			$datos = $funcion->Obtener_idventa_facturar($idcliente);
			foreach ($datos as $row => $column) {
				$id_venta = $column["p_idventa"];
				$correo = $column["p_correo"];
			}			
			
			//Generacion xml
			$xmlf=new xml();
			$namefile = $xmlf->xmlFactura($id_venta, $idsucursal);

			//Actualizar clave acceso
			$datos = $funcion->actualizar_clave_venta($namefile, $id_venta);

			//Autorizacion xml
			$xmla=new autorizar();
			$response = $xmla->autorizar_xml($namefile,$correo,$id_venta);

			$data = $response;
			echo json_encode($data);
		
			
		} catch (Exception $e) {
			$data = "Error";
 	   		echo json_encode($data);
		}

	}
	

?>
