<?php
	require('ClassTicket.php');
	include ('phpqrcode/qrlib.php');
	$idventa =  base64_decode(isset($_GET['venta']) ? $_GET['venta'] : '');
	try
	{

	spl_autoload_register(function($className){
		$model = "../model/". $className ."_model.php";
		$controller = "../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	});

    $objVenta = new Venta();

    if($idventa == ""){
    	$detalle = $objVenta->Imprimir_Ticket_DetalleVenta('0');
    	$datos = $objVenta->Imprimir_Ticket_Venta('0');
    } else {
    	$detalle = $objVenta->Imprimir_Ticket_DetalleVenta($idventa);
    	$datos = $objVenta->Imprimir_Ticket_Venta($idventa);
    }

	foreach ($datos as $row => $column) {

		$clave_acceso = $column["p_clave_acceso"];
		$serie_comprobante = $column["p_serie_comprobante"];
		$cliente_nombre = $column["p_cliente_nombre"];
		$cliente_ruc = $column["p_cliente_ruc"];
		$cliente_direccion = $column["p_cliente_direccion"];

    	$tipo_comprobante = $column["p_tipo_comprobante"];
    	$empresa = $column["p_empresa"];
    	$propietario = $column["p_propietario"];
    	$direccion = $column["p_direccion"];
    	$nit = $column["p_numero_nit"];
    	$nrc = $column["p_numero_nrc"];
    	$fecha_resolucion = $column["p_fecha_resolucion"];
    	$numero_resolucion = $column["p_numero_resolucion"];
    	$serie = $column["p_serie"];
    	$numero_comprobante = $column["p_numero_comprobante"];
    	$empleado = $column["p_empleado"];
    	$numero_venta = $column["p_numero_venta"];
    	$fecha_venta = $column["p_fecha_venta"];
    	$subtotal = $column["p_subtotal"];
		$sumas = $column["p_sumas"];
		$iva = $column["p_iva"];
    	$exento = $column["p_exento"];
    	$descuento = $column["p_descuento"];
    	$total = $column["p_total"];
    	$numero_productos = $column["p_numero_productos"];
		$tipo_pago = $column["p_tipo_pago"];
		$efectivo = $column["p_pago_efectivo"];
		$pago_tarjeta = $column["p_pago_tarjeta"];
		$numero_tarjeta = $column["p_numero_tarjeta"];
		$tarjeta_habiente = $column["p_tarjeta_habiente"];
		$cambio = $column["p_cambio"];
		$moneda = $column["p_moneda"];
		$estado = $column["p_estado"];
		$desc = $column["p_descripcion"];
		$idsucursal = $column["p_idsucursalventa"];
    }

    //$numero_tarjeta = substr($numero_tarjeta,0,4).'-XXXX-XXXX-'.substr($numero_tarjeta,12,16);


	//Recuperacion de datos empresa
	$objParametro =  new Parametro();
	$parametros = $objParametro->Listar_Parametros();

	if (is_array($parametros) || is_object($parametros)){
		foreach ($parametros as $row => $column){
			$nombre_empresa = $column['nombre_empresa'];
			$direccion_empresa = $column['direccion_empresa'];
			$valorTarifaIVA = $column['porcentaje_iva'];
		}
	}

	//Recuperacion de datos sucursal
	$objSucursal =  new Sucursal();
	$sucursal = $objSucursal->Consultar_Sucursal($idsucursal);

	if (is_array($sucursal) || is_object($sucursal)){
		foreach ($sucursal as $row => $column){
			$nombre_sucursal = $column['nombre'];
			$direccion_sucursal = $column['direccion'];
			$telefono_sucursal = $column['telefono'];
		}
	}

    $direccion1 = $direccion_empresa;
    $direccion2 = ' ';
	if($idsucursal == 2){
		$direccion2= $direccion_sucursal;
	}else{
		$sucursal2 = $objSucursal->Consultar_Sucursal(2);
		if (is_array($sucursal2) || is_object($sucursal2)){
			foreach ($sucursal2 as $row => $column){
				$direccion_2 = $column['direccion'];
			}
			$direccion2= $direccion_2;
		}
	}

	$textoPorcetajeIVA = (round((float)$valorTarifaIVA)).'%';
	$valorPorcentajeIVA = ( (float)$valorTarifaIVA ) / 100;
	$porcentajeIVAMasUno = $valorPorcentajeIVA + 1;

	$pdf = new TICKET('P','mm',array(76,250));
	$pdf->AddPage();
	
	
	if($tipo_comprobante == '1')
	{
		$pdf->SetFont('Arial', '', 12);
		$pdf->SetAutoPageBreak(true,1);

		include('../includes/ticketheadersample.inc.php');

		$pdf->SetFont('Arial', 'B', 8.5);
		$pdf->Text(2, $get_YH + 3 , '-----------------------------------------------------------------------');
		$pdf->SetFont('Arial', '', 8);
		$pdf->Text(4, $get_YH + 6, 'No. Comprobante : '.$serie_comprobante);
		$pdf->Text(4, $get_YH + 9, 'Fecha Emision : '.$fecha_venta);
		$pdf->Text(4, $get_YH  + 12, 'Cliente : '.$cliente_nombre);
		$pdf->Text(4, $get_YH  + 15, 'R.U.C./CI : '.$cliente_ruc);
		$pdf->Text(4, $get_YH  + 18, 'Direccion : '.$cliente_direccion);
		//$pdf->Text(55, $get_YH + 5, 'Caja No.: 1');
		$pdf->Text(4, $get_YH  + 21, 'Usuario : '.$empleado);

		$pdf->SetFont('Arial', 'B', 8.5);
		$pdf->Text(2, $get_YH + 23.5, '-----------------------------------------------------------------------');
		$pdf->SetXY(2,$get_YH + 23);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',8.5);
		$pdf->Cell(10,4,'Cant.',0,0,'L',1);
		$pdf->Cell(38,4,'Descripcion',0,0,'L',1);
		$pdf->Cell(12,4,'Precio',0,0,'L',1);
		$pdf->Cell(12,4,'Total',0,0,'L',1);
		$pdf->SetFont('Arial','B',8.5);
		$pdf->Text(2, $get_YH + 28, '-----------------------------------------------------------------------');
		$pdf->SetFont('Arial','',7);
		$pdf->Ln(5);
		$item = 0;
		while($row = $detalle->fetch(PDO::FETCH_ASSOC)) {
			$item = $item + 1;
			$pdf->setX(1.4);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(10,4,$row['cantidad'],0,0,'L');
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(39,4,$row['descripcion'],0,0,'L',1);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(11,4,$row['precio_unitario'],0,0,'L',1);
			$pdf->Cell(8,4,$row['importe'],0,0,'L',1);
			$pdf->Ln(3.5);
			$get_Y = $pdf->GetY();
		}
		$pdf->SetFont('Arial', 'B', 8.5);
		$pdf->Text(2, $get_Y+2, '-----------------------------------------------------------------------');
		$pdf->SetFont('Arial','B',9);
		//$pdf->Text(4,$get_Y + 5,'G = GRAVADO');
		//$pdf->Text(30,$get_Y + 5,'E = EXENTO');
		$pdf->Text(25,$get_Y + 5,'SUBTOTAL :');
		$pdf->Text(57,$get_Y + 5,$subtotal);
		$pdf->Text(25,$get_Y + 8,'DESCUENTO :');
		$pdf->Text(57,$get_Y + 8,$descuento);
		$pdf->Text(25,$get_Y + 11,'TOTAL A PAGAR :');
		$pdf->SetFont('Arial','B',9);
		$pdf->Text(57,$get_Y + 11,$total);
		$pdf->SetFont('Arial', 'B', 8.5);
		$pdf->Text(2, $get_Y+ 14, '-----------------------------------------------------------------------');
		$pdf->SetFont('Arial','',8);
		$pdf->Text(7,$get_Y + 17,'Forma de pago :');
		$pdf->Text(29,$get_Y + 17, $tipo_pago);
		$pdf->Text(7,$get_Y + 20,'Numero de Productos :');
		$pdf->Text(40,$get_Y + 20,$numero_productos);

		if($tipo_pago == 'EFECTIVO'){

			$pdf->Text(25,$get_Y + 23,'Efectivo :');
			$pdf->Text(40,$get_Y + 23,$efectivo);
			$pdf->Text(25,$get_Y + 26,'Cambio :');
			$pdf->Text(40,$get_Y + 26,$cambio);

			$pdf->SetFont('Arial', 'B', 8.5);	
			$pdf->Text(2, $get_Y+28, '-----------------------------------------------------------------------');
			
			$pdf->SetFont('Arial','I',8);
			if($estado == '2'):
				$pdf->Text(7, $get_Y+31, 'Esta venta ha sido al credito');
			endif;
			
			/*
			$pdf->SetFont('Arial','',8.5);
			$pdf->Text(10, $get_Y+38, '________________');
			$pdf->Text(11, $get_Y+41, 'Firma responsable');

			$pdf->Text(41, $get_Y+38, '________________');
			$pdf->Text(46, $get_Y+41, 'Firma cliente');
			*/

			$pdf->SetFillColor(0,0,0);
			$pdf->Code39(9,$get_Y+34,$serie_comprobante,0.7,5);
			$pdf->Text(28, $get_Y+42, ''.$numero_venta.'');

			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(0,0,0);
			$pdf->Text(17.5,$get_Y+46, 'Documento sin validez tributaria' );

			$pdf->SetFont('Arial','',8);
			$pdf->Text(19, $get_Y+49, '**GRACIAS POR SU COMPRA**');
			
			$pdf->SetFont('Arial','',7);
			$pdf->Text(7, $get_Y+54, empty($desc)?'':'Garantia');
			$pdf->Text(7, $get_Y+57, $desc);

		} else if ($tipo_pago == 'TRANSFERENCIA'){

			$pdf->Text(15,$get_Y + 23,'No. Documento :');
			$pdf->Text(40,$get_Y + 23,$numero_tarjeta);
			$pdf->Text(18,$get_Y + 26,'Monto Trans. :');
			$pdf->Text(40,$get_Y + 26,$total);

			$pdf->SetFont('Arial', 'B', 8.5);
			$pdf->Text(2, $get_Y+28, '-----------------------------------------------------------------------');
			$pdf->SetFont('Arial','I',8);
			//$pdf->Text(3, $get_Y+52, 'Precios en : '.$moneda);
			//$pdf->SetFont('Arial','B',8.5);

			if($estado == '2'):
				$pdf->Text(7, $get_Y+31, 'Esta venta ha sido al credito');
			endif;

			/*
			$pdf->SetFont('Arial','',8.5);
			$pdf->Text(10, $get_Y+38, '________________');
			$pdf->Text(11, $get_Y+41, 'Firma responsable');

			$pdf->Text(41, $get_Y+38, '________________');
			$pdf->Text(46, $get_Y+41, 'Firma cliente');
			*/

			$pdf->SetFillColor(0,0,0);
			$pdf->Code39(9,$get_Y+34,$serie_comprobante,0.7,5);
			$pdf->Text(28, $get_Y+42, ''.$numero_venta.'');

			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(0,0,0);
			$pdf->Text(17.5,$get_Y+46, 'Documento sin validez tributaria' );

			$pdf->SetFont('Arial','',8);
			$pdf->Text(19, $get_Y+49, '**GRACIAS POR SU COMPRA**');
			
			$pdf->SetFont('Arial','',7);
			$pdf->Text(7, $get_Y+54, empty($desc)?'':'Garantia');
			$pdf->Text(7, $get_Y+57, $desc);


		} else if ($tipo_pago == 'EFECTIVO Y TRANSFERENCIA'){ // Y TRANSFERENCIA

			$pdf->Text(24.5,$get_Y + 23,'Efectivo :');
			$pdf->Text(40,$get_Y + 23,$efectivo);
			$pdf->Text(15,$get_Y + 26,'No. Documento :');
			$pdf->Text(40,$get_Y + 26,$numero_tarjeta);
			$pdf->Text(18,$get_Y + 29,'Monto Trans. :');
			$pdf->Text(40,$get_Y + 29,$pago_tarjeta);

			$pdf->SetFont('Arial', 'B', 8.5);
			$pdf->Text(2, $get_Y+31, '-----------------------------------------------------------------------');
			$pdf->SetFont('Arial','I',8);
			//$pdf->Text(3, $get_Y+58, 'Precios en : '.$moneda);
			//$pdf->SetFont('Arial','',8.5);
			//$pdf->Text(3, $get_Y+63, 'Venta realizada con dos metodos de pago');
			//$pdf->SetFont('Arial','B',8.5);
			if($estado == '2'):
				$pdf->Text(7, $get_Y+34, 'Esta venta ha sido al credito');
			endif;

			/*
			$pdf->SetFont('Arial','',8.5);
			$pdf->Text(10, $get_Y+40, '________________');
			$pdf->Text(11, $get_Y+43, 'Firma responsable');

			$pdf->Text(41, $get_Y+40, '________________');
			$pdf->Text(46, $get_Y+43, 'Firma cliente');
			*/

			$pdf->SetFillColor(0,0,0);
			$pdf->Code39(9,$get_Y+37,$serie_comprobante,0.7,5);
			$pdf->Text(28, $get_Y+45, ''.$numero_venta.'');

			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(0,0,0);
			$pdf->Text(17.5,$get_Y+49, 'Documento sin validez tributaria' );

			$pdf->SetFont('Arial','',8);
			$pdf->Text(19, $get_Y+52, '**GRACIAS POR SU COMPRA**');
			
			$pdf->SetFont('Arial','',7);
			$pdf->Text(7, $get_Y+58, empty($desc)?'':'Garantia');
			$pdf->Text(7, $get_Y+60, $desc);
			} 
	
			//$pdf->IncludeJS("print('true');");
	
		} else if ($tipo_comprobante == '2') {
	
			$pdf->SetFont('Arial', '', 12);
			$pdf->SetAutoPageBreak(true,1);

			include('../includes/ticketheader.inc.php');

			$pdf->SetFont('Arial', '', 9.2);
			$pdf->Text(2, $get_YH + 2 , '------------------------------------------------------------------');
			$pdf->SetFont('Arial', '', 8);
			$pdf->Text(4, $get_YH + 5, 'Factura : '.$serie_comprobante);
			$pdf->Text(4, $get_YH + 8, 'Fecha Emision : '.$fecha_venta);
			$pdf->Text(4, $get_YH  + 11, 'Cliente : '.$cliente_nombre);
			$pdf->Text(4, $get_YH  + 14, 'R.U.C./CI : '.$cliente_ruc);
			$pdf->Text(4, $get_YH  + 17, 'Direccion : '.$cliente_direccion);
			//$pdf->Text(55, $get_YH + 5, 'Caja No.: 1');
			$pdf->Text(4, $get_YH  + 20, 'Usuario : '.$empleado);
			
			$pdf->SetFont('Arial', '', 9.2);
			$pdf->Text(2, $get_YH + 22, '------------------------------------------------------------------');
			$pdf->SetXY(2,$get_YH + 22);
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(7,4,'Cant.',0,0,'L',1);
			$pdf->Cell(32,4,'Descripcion',0,0,'L',1);
			$pdf->Cell(11,4,'Precio',0,0,'L',1);
			$pdf->Cell(9,4,'Desct.',0,0,'L',1);
			$pdf->Cell(12,4,'Total',0,0,'L',1);
			$pdf->SetFont('Arial', '', 9.2);
			$pdf->Text(2, $get_YH + 27, '------------------------------------------------------------------');
			$pdf->SetFont('Arial','',7);

			$pdf->Ln(5);
			$item = 0;
			while($row = $detalle->fetch(PDO::FETCH_ASSOC)) {
				$item = $item + 1;
				$pdf->setX(1.4);
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(7,4,$row['cantidad'],0,0,'L');
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(32,4,$row['descripcion'],0,0,'L',1);
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(12,4,$row['precio_unidad'],0,0,'L',1);
				$pdf->Cell(9,4,$row['descuento'],0,0,'L',1);
				$pdf->Cell(8,4,$row['sin_impuesto_total'],0,0,'L',1);
				$pdf->Ln(3.5);
				$get_Y = $pdf->GetY();
			}
			$pdf->SetFont('Arial', '', 9.2);
			$pdf->Text(2, $get_Y+2, '------------------------------------------------------------------');
			$pdf->SetFont('Arial','',8);
			$pdf->Text(15,$get_Y + 4,'SUBTOTAL SIN IMPUESTOS');
			$pdf->Text(58,$get_Y + 4, number_format((($sumas - ($descuento / $porcentajeIVAMasUno)) + $exento) , 2));
			$pdf->Text(15,$get_Y + 7,'SUBTOTAL '.$textoPorcetajeIVA.' :');
			$pdf->Text(58,$get_Y + 7, number_format(($sumas - ($descuento / $porcentajeIVAMasUno)),2));
			$pdf->Text(15,$get_Y + 10,'SUBTOTAL 0% :');
			$pdf->Text(58,$get_Y + 10, $exento);
			$pdf->Text(15,$get_Y + 13,'IVA '.$textoPorcetajeIVA.' :');
			$pdf->Text(58,$get_Y + 13, number_format((($sumas - ($descuento / $porcentajeIVAMasUno)) * $valorPorcentajeIVA),2));
			$pdf->Text(15,$get_Y + 16,'DESCUENTO :');
			$pdf->Text(58,$get_Y + 16, number_format(($descuento / $porcentajeIVAMasUno),2));
			$pdf->Text(15,$get_Y + 19,'TOTAL A PAGAR :');
			$pdf->SetFont('Arial','B', 9);
			$pdf->Text(58,$get_Y + 19, $total);
			$pdf->SetFont('Arial', '', 9.2);
			$pdf->Text(2, $get_Y + 21, '------------------------------------------------------------------');
			$pdf->SetFont('Arial','',8);
			$pdf->Text(7,$get_Y + 24,'Forma de pago :');
			$pdf->Text(29,$get_Y + 24, $tipo_pago);
			$pdf->Text(7,$get_Y + 27,'Numero de Productos :');
			$pdf->Text(40,$get_Y + 27,$numero_productos);
	
			if($tipo_pago == 'EFECTIVO'){

				$pdf->Text(24.5,$get_Y + 30,'Efectivo :');
				$pdf->Text(40,$get_Y + 30,$efectivo);
				$pdf->Text(25,$get_Y + 33,'Cambio :');
				$pdf->Text(40,$get_Y + 33,$cambio);

				$pdf->SetFont('Arial', '', 9.2);
				$pdf->Text(2, $get_Y + 36, '------------------------------------------------------------------');
				
				$pdf->SetFont('Arial','I',7);
				if($estado == '2'):
					$pdf->Text(3, $get_Y + 38, 'Esta venta ha sido al credito');
				endif;
				
				/*
				$rnd = rand(1,5);
				$pdf->SetFillColor(0,0,0);
				QRcode::png($clave_acceso, 'code'.$rnd.'.png', QR_ECLEVEL_L, 10, 2);
				$pdf->Image('code'.$rnd.'.png',28, $get_Y + 40, 20);
				$pdf->SetFont('Arial','',7);
				$pdf->Text(3.5, $get_Y + 62, 'AC:');
				$pdf->Text(3, $get_Y + 64, $clave_acceso);
				$pdf->Text(8, $get_Y + 68, 'Su comprobante sera emitido al correo electronico');

				$pdf->SetFont('Arial','',7);
				$pdf->Text(8, $get_Y + 72, empty($desc)?'':'Garantia:');
				$pdf->Text(8, $get_Y + 75, $desc);
				*/

				$pdf->Code39(3, $get_Y + 41 , $clave_acceso, 0.25, 8);
				$pdf->SetFont('Arial','',7);
				//$pdf->Text(3.5, $get_Y + 53, 'AC:');
				$pdf->Text(4, $get_Y + 53, $clave_acceso);
				$pdf->Text(10, $get_Y + 60, 'Su comprobante sera emitido al correo electronico');

				$pdf->SetFont('Arial','',7);
				$pdf->Text(8, $get_Y + 69, empty($desc)?'':'Garantia:');
				$pdf->Text(8, $get_Y + 72, $desc);

				$pdf->Text(20, $get_Y + 64, '**GRACIAS POR SU COMPRA**');

			} else if ($tipo_pago == 'TRANSFERENCIA'){
				
				$pdf->SetFont('Arial','',8);
				$pdf->Text(15,$get_Y + 30,'No. Documento :');
				$pdf->Text(40,$get_Y + 30,$numero_tarjeta);
				$pdf->Text(18,$get_Y + 33,'Monto Trans. :');
				$pdf->Text(40,$get_Y + 33,$total);

				$pdf->SetFont('Arial', '', 9.2);
				$pdf->Text(2, $get_Y + 36, '------------------------------------------------------------------');
				
				$pdf->SetFont('Arial','I',7);
				if($estado == '2'):
					$pdf->Text(3, $get_Y + 38, 'Esta venta ha sido al credito');
				endif;
				
				/*
				$rnd = rand(1,5);
				$pdf->SetFillColor(0,0,0);
				QRcode::png($clave_acceso, 'code'.$rnd.'.png', QR_ECLEVEL_L, 10, 2);
				$pdf->Image('code'.$rnd.'.png',28, $get_Y + 40, 20);
				$pdf->SetFont('Arial','',7);
				$pdf->Text(3.5, $get_Y + 62, 'AC:');
				$pdf->Text(3, $get_Y + 64, $clave_acceso);
				$pdf->Text(8, $get_Y + 68, 'Su comprobante sera emitido al correo electronico');

				$pdf->SetFont('Arial','',7);
				$pdf->Text(8, $get_Y + 72, empty($desc)?'':'Garantia:');
				$pdf->Text(8, $get_Y + 75, $desc);
				*/

				$pdf->Code39(3, $get_Y + 41 , $clave_acceso, 0.25, 8);
				$pdf->SetFont('Arial','',7);
				//$pdf->Text(3.5, $get_Y + 53, 'AC:');
				$pdf->Text(4, $get_Y + 53, $clave_acceso);
				$pdf->Text(10, $get_Y + 60, 'Su comprobante sera emitido al correo electronico');

				$pdf->SetFont('Arial','',7);
				$pdf->Text(8, $get_Y + 69, empty($desc)?'':'Garantia:');
				$pdf->Text(8, $get_Y + 72, $desc);

				$pdf->Text(20, $get_Y + 64, '**GRACIAS POR SU COMPRA**');

			} else if ($tipo_pago == 'EFECTIVO Y TRANSFERENCIA'){ // Y TRANSFERENCIA
				
				$pdf->SetFont('Arial','',8);
				$pdf->Text(24.5,$get_Y + 30,'Efectivo :');
				$pdf->Text(40,$get_Y + 30,$efectivo);
				$pdf->Text(15,$get_Y + 33,'No. Documento :');
				$pdf->Text(40,$get_Y + 33,$numero_tarjeta);
				$pdf->Text(18,$get_Y + 36,'Monto Trans. :');
				$pdf->Text(40,$get_Y + 36,$pago_tarjeta);

				$pdf->SetFont('Arial', '', 9.2);
				$pdf->Text(2, $get_Y + 39, '------------------------------------------------------------------');
				
				$pdf->SetFont('Arial','I',7);
				if($estado == '2'):
					$pdf->Text(3, $get_Y + 41, 'Esta venta ha sido al credito');
				endif;
				
				/*
				$rnd = rand(1,5);
				$pdf->SetFillColor(0,0,0);
				QRcode::png($clave_acceso, 'code'.$rnd.'.png', QR_ECLEVEL_L, 10, 2);
				$pdf->Image('code'.$rnd.'.png',28, $get_Y + 43, 20);
				$pdf->SetFont('Arial','',7);
				$pdf->Text(3.5, $get_Y + 65, 'AC:');
				$pdf->Text(3, $get_Y + 67, $clave_acceso);
				$pdf->Text(8, $get_Y + 71, 'Su comprobante sera emitido al correo electronico');

				$pdf->SetFont('Arial','',7);
				$pdf->Text(8, $get_Y + 75, empty($desc)?'':'Garantia:');
				$pdf->Text(8, $get_Y + 78, $desc);
				*/

				$pdf->Code39(3, $get_Y + 44 , $clave_acceso, 0.25, 8);
				$pdf->SetFont('Arial','',7);
				//$pdf->Text(3.5, $get_Y + 56, 'AC:');
				$pdf->Text(4, $get_Y + 56, $clave_acceso);
				$pdf->Text(8, $get_Y + 63, 'Su comprobante sera emitido al correo electronico');

				$pdf->SetFont('Arial','',7);
				$pdf->Text(8, $get_Y + 72, empty($desc)?'':'Garantia:');
				$pdf->Text(8, $get_Y + 75, $desc);

				$pdf->Text(20, $get_Y + 67, '**GRACIAS POR SU COMPRA**');

			}
	
			//Tope factura 76x150mm
			//$pdf->Text(5, $get_YH + 107 , '_');
				
		} else if ($tipo_comprobante == '3') {

			$pdf->SetFont('Arial', '', 12);
			$pdf->SetAutoPageBreak(true,1);

			include('../includes/ticketheadersample.inc.php');

			$pdf->SetFont('Arial', 'B', 8.5);
			$pdf->Text(2, $get_YH + 3 , '-----------------------------------------------------------------------');
			$pdf->SetFont('Arial', '', 8);
			$pdf->Text(4, $get_YH + 6, 'No. Comprobante : '.$serie_comprobante);
			$pdf->Text(4, $get_YH + 9, 'Fecha Emision : '.$fecha_venta);
			$pdf->Text(4, $get_YH  + 12, 'Cliente : '.$cliente_nombre);
			$pdf->Text(4, $get_YH  + 15, 'R.U.C./CI : '.$cliente_ruc);
			$pdf->Text(4, $get_YH  + 18, 'Direccion : '.$cliente_direccion);
			//$pdf->Text(55, $get_YH + 5, 'Caja No.: 1');
			$pdf->Text(4, $get_YH  + 21, 'Usuario : '.$empleado);

			$pdf->SetFont('Arial', 'B', 8.5);
			$pdf->Text(2, $get_YH + 23.5, '-----------------------------------------------------------------------');
			$pdf->SetXY(2,$get_YH + 23);
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Cell(10,4,'Cant.',0,0,'L',1);
			$pdf->Cell(38,4,'Descripcion',0,0,'L',1);
			$pdf->Cell(12,4,'Precio',0,0,'L',1);
			$pdf->Cell(12,4,'Total',0,0,'L',1);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Text(2, $get_YH + 28, '-----------------------------------------------------------------------');
			$pdf->SetFont('Arial','',7);
			$pdf->Ln(5);
			$item = 0;
			while($row = $detalle->fetch(PDO::FETCH_ASSOC)) {
				$item = $item + 1;
				$pdf->setX(1.4);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(10,4,$row['cantidad'],0,0,'L');
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(39,4,$row['descripcion'],0,0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(11,4,$row['precio_unitario'],0,0,'L',1);
				$pdf->Cell(8,4,$row['importe'],0,0,'L',1);
				$pdf->Ln(3.5);
				$get_Y = $pdf->GetY();
			}
			$pdf->SetFont('Arial', 'B', 8.5);
			$pdf->Text(2, $get_Y+2, '-----------------------------------------------------------------------');
			$pdf->SetFont('Arial','B',9);
			//$pdf->Text(4,$get_Y + 5,'G = GRAVADO');
			//$pdf->Text(30,$get_Y + 5,'E = EXENTO');
			$pdf->Text(25,$get_Y + 5,'SUBTOTAL :');
			$pdf->Text(57,$get_Y + 5,$subtotal);
			$pdf->Text(25,$get_Y + 8,'DESCUENTO :');
			$pdf->Text(57,$get_Y + 8,$descuento);
			$pdf->Text(25,$get_Y + 11,'TOTAL A PAGAR :');
			$pdf->SetFont('Arial','B',9);
			$pdf->Text(57,$get_Y + 11,$total);
			$pdf->SetFont('Arial', 'B', 8.5);
			$pdf->Text(2, $get_Y+ 14, '-----------------------------------------------------------------------');
			$pdf->SetFont('Arial','',8);
			$pdf->Text(7,$get_Y + 17,'Forma de pago :');
			$pdf->Text(29,$get_Y + 17, $tipo_pago);
			$pdf->Text(7,$get_Y + 20,'Numero de Productos :');
			$pdf->Text(40,$get_Y + 20,$numero_productos);

			if($tipo_pago == 'EFECTIVO'){

				$pdf->Text(25,$get_Y + 23,'Efectivo :');
				$pdf->Text(40,$get_Y + 23,$efectivo);
				$pdf->Text(25,$get_Y + 26,'Cambio :');
				$pdf->Text(40,$get_Y + 26,$cambio);

				$pdf->SetFont('Arial', 'B', 8.5);	
				$pdf->Text(2, $get_Y+28, '-----------------------------------------------------------------------');
				
				$pdf->SetFont('Arial','I',8);
				if($estado == '2'):
					$pdf->Text(7, $get_Y+31, 'Esta venta ha sido al credito');
				endif;
				
				/*				
				$pdf->SetFont('Arial','',8.5);
				$pdf->Text(10, $get_Y+38, '________________');
				$pdf->Text(11, $get_Y+41, 'Firma responsable');
	
				$pdf->Text(41, $get_Y+38, '________________');
				$pdf->Text(46, $get_Y+41, 'Firma cliente');
				*/
	
				$pdf->SetFont('Arial','',8);
				$pdf->SetFillColor(0,0,0);
				$pdf->Text(17.5,$get_Y+45, 'Documento sin validez tributaria' );
	
				$pdf->SetFont('Arial','',8);
				$pdf->Text(19, $get_Y+48, '**GRACIAS POR SU COMPRA**');
				//$pdf->SetFillColor(0,0,0);
				//$pdf->Code39(9,$get_Y+64,$serie_comprobante,1,5);
				//$pdf->Text(28, $get_Y+74, '*'.$numero_venta.'*');

			} else if ($tipo_pago == 'TRANSFERENCIA'){

				$pdf->Text(15,$get_Y + 23,'No. Documento :');
				$pdf->Text(40,$get_Y + 23,$numero_tarjeta);
				$pdf->Text(18,$get_Y + 26,'Monto Trans. :');
				$pdf->Text(40,$get_Y + 26,$total);

				$pdf->SetFont('Arial', 'B', 8.5);
				$pdf->Text(2, $get_Y+28, '-----------------------------------------------------------------------');
				$pdf->SetFont('Arial','I',8.5);
				//$pdf->Text(3, $get_Y+52, 'Precios en : '.$moneda);
				//$pdf->SetFont('Arial','B',8.5);

				if($estado == '2'):
					$pdf->Text(7, $get_Y+31, 'Esta venta ha sido al credito');
				endif;

				/*
				$pdf->SetFont('Arial','',8.5);
				$pdf->Text(10, $get_Y+38, '________________');
				$pdf->Text(11, $get_Y+41, 'Firma responsable');

				$pdf->Text(41, $get_Y+38, '________________');
				$pdf->Text(46, $get_Y+41, 'Firma cliente');
				*/

				$pdf->SetFont('Arial','',8);
				$pdf->SetFillColor(0,0,0);
				$pdf->Text(17.5,$get_Y+45, 'Documento sin validez tributaria' );

				$pdf->SetFont('Arial','',8);
				$pdf->Text(19, $get_Y+48, '**GRACIAS POR SU COMPRA**');
				//$pdf->SetFillColor(0,0,0);
				//$pdf->Code39(9,$get_Y+64,$numero_venta,1,5);
				//$pdf->Text(28, $get_Y+74, '*'.$numero_venta.'*');


			} else if ($tipo_pago == 'EFECTIVO Y TRANSFERENCIA'){ // Y TRANSFERENCIA

				$pdf->Text(24.5,$get_Y + 23,'Efectivo :');
				$pdf->Text(40,$get_Y + 23,$efectivo);
				$pdf->Text(15,$get_Y + 26,'No. Documento :');
				$pdf->Text(40,$get_Y + 26,$numero_tarjeta);
				$pdf->Text(18,$get_Y + 29,'Monto Trans. :');
				$pdf->Text(40,$get_Y + 29,$pago_tarjeta);

				$pdf->SetFont('Arial', 'B', 8.5);
				$pdf->Text(2, $get_Y+31, '-----------------------------------------------------------------------');
				$pdf->SetFont('Arial','I',8.5);
				//$pdf->Text(3, $get_Y+58, 'Precios en : '.$moneda);
				//$pdf->SetFont('Arial','',8.5);
				//$pdf->Text(3, $get_Y+63, 'Venta realizada con dos metodos de pago');
				//$pdf->SetFont('Arial','B',8.5);
				if($estado == '2'):
					$pdf->Text(7, $get_Y+34, 'Esta venta ha sido al credito');
				endif;

				/*
				$pdf->SetFont('Arial','',8.5);
				$pdf->Text(10, $get_Y+40, '________________');
				$pdf->Text(11, $get_Y+43, 'Firma responsable');

				$pdf->Text(41, $get_Y+40, '________________');
				$pdf->Text(46, $get_Y+43, 'Firma cliente');
				*/

				$pdf->SetFont('Arial','',8);
				$pdf->SetFillColor(0,0,0);
				$pdf->Text(17.5,$get_Y+47, 'Documento sin validez tributaria' );

				$pdf->SetFont('Arial','',8);
				$pdf->Text(19, $get_Y+50, '**GRACIAS POR SU COMPRA**');
				//$pdf->SetFillColor(0,0,0);
				//$pdf->Code39(9,$get_Y+75,$numero_venta,1,5);
				//$pdf->Text(28, $get_Y+84, '*'.$numero_venta.'*');
			} 

			//$pdf->IncludeJS("print('true');");

		}
	
		$pdf->Output('','Ticket_'.$numero_comprobante.'.pdf',true);

	} catch (Exception $e) {
		//echo "<script>console.log('Console: " . $e . "' );</script>";
		$pdf->Text(22.8, 5, 'ERROR AL IMPRIMIR TICKET');
		$pdf->Output('I','Ticket_ERROR.pdf',true);

	}


?>
