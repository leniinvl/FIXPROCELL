<?php
	session_set_cookie_params(60*60*24*365); session_start();
	$idsucursal = $_SESSION['sucursal_id'];
	require_once("../../config/money_string.php");
	
	//Clases Facturacion
	//include("../facturacionphp/controladores/ctr_xml.php");
	//include("../facturacionphp/controladores/ctr_firmarxml.php");

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	}); 


		$funcion = new Venta();

		$caja_funcion = new Caja();

		$sucursal = new Sucursal();

		date_default_timezone_set("America/Guayaquil");  


		$idproducto = isset($_GET['idproducto']) ? $_GET['idproducto'] : '';
		if(!$idproducto==""){
			$funcion->Fechas_Vencimiento($idproducto);
		}


	if (!empty($_POST))
	{
		try {

		  $cuantos = $_POST['cuantos'];
		  $stringdatos = $_POST['stringdatos'];
		  $listadatos=explode('#',$stringdatos);
			$pagado = trim($_POST['pagado']);
		  $comprobante = trim($_POST['comprobante']);
		  $tipo_pago = trim($_POST['tipo_pago']);
		  $idcliente = trim($_POST['idcliente']);
		  $sumas = trim($_POST['sumas']);
		  $iva = trim($_POST['iva']);
		  $exento = trim($_POST['exento']);
		  $retenido = trim($_POST['retenido']);
		  $descuento = trim($_POST['descuento']);
		  $total = trim($_POST['total']);
			$cambio = trim($_POST['cambio']);
			$efectivo = trim($_POST['efectivo']);
			$pago_tarjeta = trim($_POST['pago_tarjeta']);
			$numero_tarjeta = trim($_POST['numero_tarjeta']);
			$tarjeta_habiente = trim($_POST['tarjeta_habiente']);
			$descripcion = trim($_POST['descripcion']);
			
		  $fecha= date("Y-m-d");
		  if($total < 1){
			$money=explode('.',$total);
			$son_letras = "Cero ".$money[1]."/100 USD";
		  }else{
			$son_letras = num2letras($total);
		  }
			$numero_tarjeta =  str_replace ( "-", "", $numero_tarjeta);

			if($tipo_pago == '1'){
				$tipo_pago = 'EFECTIVO';
			} else if ($tipo_pago =='2'){
				$tipo_pago = 'TRANSFERENCIA';
			} else if ($tipo_pago =='3'){
				$tipo_pago = 'EFECTIVO Y TRANSFERENCIA';
			}

			if($idcliente==''){
				if($pagado == '1'){
						$funcion->Insertar_Venta($tipo_pago,$comprobante,$sumas,$iva,$exento,$retenido,$descuento,$total,$son_letras,$efectivo,
						$pago_tarjeta,$numero_tarjeta,$tarjeta_habiente,$cambio,1,0,$_SESSION['user_id'],$idsucursal,$descripcion);
				} else if ($pagado == '0') {
						$funcion->Insertar_Venta($tipo_pago,$comprobante,$sumas,$iva,$exento,$retenido,$descuento,$total,$son_letras,$efectivo,
						$pago_tarjeta,$numero_tarjeta,$tarjeta_habiente,$cambio,2,0,$_SESSION['user_id'],$idsucursal,$descripcion);
				}
			} else if ($idcliente!='') {
				if($pagado == '1'){
					$funcion->Insertar_Venta($tipo_pago,$comprobante,$sumas,$iva,$exento,$retenido,$descuento,$total,$son_letras,$efectivo,
					$pago_tarjeta,$numero_tarjeta,$tarjeta_habiente,$cambio,1,$idcliente,$_SESSION['user_id'],$idsucursal,$descripcion);
				} else if ($pagado == '0') {
					$funcion->Insertar_Venta($tipo_pago,$comprobante,$sumas,$iva,$exento,$retenido,$descuento,$total,$son_letras,$efectivo,
					$pago_tarjeta,$numero_tarjeta,$tarjeta_habiente,$cambio,2,$idcliente,$_SESSION['user_id'],$idsucursal,$descripcion);
				}
			}



		for ($i=0;$i<$cuantos ;$i++){

		  	list($idproducto,$cantidad,$precio_unitario,$exentos,$descuento,$fecha_vence,$importe)=explode('|',$listadatos[$i]);

		  	if($fecha_vence==''){
				$fecha_vence = '2021-01-01';
			} else {
				$fecha_vence = DateTime::createFromFormat('d/m/Y', $fecha_vence)->format('Y-m-d');
			}

		  	$funcion->Insertar_DetalleVenta($idproducto,$cantidad,$precio_unitario,$exentos,$descuento,$fecha_vence,$importe);

		}

		$filas1 = $sucursal->Listar_Sucursal();
		$filas2 = $sucursal->Listar_Sucursal();
		if ((is_array($filas1) || is_object($filas1)) and
			(is_array($filas2) || is_object($filas2))){

			foreach ($filas1 as $row1 => $column1){
				$p_sucursal_venta = $column1["idsucursal"];

				foreach ($filas2 as $row2 => $column2){
					$p_sucursal_prod = $column2["idsucursal"];
					
					if($p_sucursal_venta != $p_sucursal_prod){
						$funcion->actualizar_venta($p_sucursal_venta, $p_sucursal_prod);
					}

				}

			}

		}

		/*FACTURACION ELECTRONICA V1.0.0		
		if($comprobante == '99'){ //2-FAC
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
			$xmla->autorizar_xml($namefile,$correo,$id_venta);
		}*/

		} catch (Exception $e) {
			$data = "Error";
 	   	 	echo json_encode($data);
		}

}



?>
