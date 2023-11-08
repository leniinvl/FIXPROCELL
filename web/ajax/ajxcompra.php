<?php 
	session_set_cookie_params(60*60*24*365); session_start();
	$idsucursal = $_SESSION['sucursal_id'];
	require_once("../../config/money_string.php");

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";
	
		require_once($model);
		require_once($controller);
	});


		$funcion = new Compra();
		
		date_default_timezone_set("America/Guayaquil");
	

		try {

		  $accion = $_POST['accion'];	
		  
		 
		   switch($accion){

				case 'Cabeza':

				  $comprobante = trim($_POST['comprobante']);
				  $numero_comprobante = trim($_POST['numero_comprobante']);
				  $fecha_comprobante = trim($_POST['fecha_comprobante']);
				  $tipo_pago = trim($_POST['tipo_pago']);
				  $idproveedor = trim($_POST['idproveedor']);
				  $sumas = trim($_POST['sumas']);
				  $iva = trim($_POST['iva']);
				  $exento = trim($_POST['exento']);
				  $retenido = trim($_POST['retenido']);
				  $total = trim($_POST['total']);
				  $fecha_transaccion = date("Y-m-d H:i:s");
				  $fecha= date("Y-m-d");
				  $son_letras = num2letras($total);

				  $c_fecha_comprobante = DateTime::createFromFormat('d/m/Y', $fecha_comprobante)->format('Y-m-d');


				$funcion->Insertar_Compra($fecha_transaccion,$idproveedor,$tipo_pago,$numero_comprobante,$comprobante,
	  			$c_fecha_comprobante,$sumas,$iva,$exento,$retenido,$total,strtoupper($son_letras),$idsucursal);

				break;

				case 'Detalle':

				 $stringdatos = $_POST['stringdatos'];
		 		 $listadatos=explode('#',$stringdatos);
		 		 $cuantos = $_POST['cuantos'];


				   for ($i=0;$i<$cuantos ;$i++){

				  	 list($idproducto,$cantidad,$precio_unitario,$exentos,$fecha_vence,$importe)=explode('|',$listadatos[$i]);

				  	 	if($fecha_vence=='/')
						{
							$fecha_vence = '2000-01-01';

						} else {

							$fecha_vence = DateTime::createFromFormat('d/m/Y', $fecha_vence)->format('Y-m-d');
						}


					  	 $funcion->Insertar_DetalleCompra($idproducto,$cantidad,$precio_unitario,$exentos,$fecha_vence,$importe);

				   }
				break;

		   }



		} catch (Exception $e) {

			 $data = "Error";
 	   		 echo json_encode($data);
			
		}


	
	

?>