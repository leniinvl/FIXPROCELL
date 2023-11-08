<?php
	require('ClassTicket.php');

	try
	{

	function __autoload($className){
            $model = "../model/". $className ."_model.php";
            $controller = "../controller/". $className ."_controller.php";

           require_once($model);
           require_once($controller);
    }

    $mes = isset($_GET['mes']) ? $_GET['mes'] : '';
    $mes = DateTime::createFromFormat('m/Y', $mes)->format('m-Y');
    $ano = substr($mes,3,4);

	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto",
    "Septiembre","Octubre","Noviembre","Diciembre");

    $objVenta = new Venta();
    $datos = $objVenta->Imprimir_Ticket_Venta('0');


	session_set_cookie_params(60*60*24*365); session_start();
	//$tipo_usuario = $_SESSION['user_tipo'];
	$idsucursal = $_SESSION['sucursal_id'];

    if($mes == ""){

    	$detalle = $objVenta->Imprimir_Corte_Z_Mes(date('m-Y'),1,$idsucursal);
		$detalle2 = $objVenta->Imprimir_Corte_Z_Mes(date('m-Y'),2,$idsucursal);

    } else {

    	$detalle = $objVenta->Imprimir_Corte_Z_Mes($mes,1,$idsucursal);
		$detalle2 = $objVenta->Imprimir_Corte_Z_Mes($mes,2,$idsucursal);

    }

    foreach ($datos as $row => $column) {

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
    	$exento = $column["p_exento"];
    	$descuento = $column["p_descuento"];
    	$total = $column["p_total"];
    	$numero_productos = $column["p_numero_productos"];
    }

    foreach ($detalle as $row => $column) {

    	$p_desde_impreso = $column["p_desde_impreso"];
    	$p_hasta_impreso = $column["p_hasta_impreso"];
    	$p_venta_gravada = $column["p_venta_gravada"];
    	$p_venta_iva = $column["p_venta_iva"];
    	$p_total_exento = $column["p_total_exento"];
    	$p_total_gravado = $column["p_total_gravado"];
    	$p_total_venta = $column["p_total_venta"];
    }

	foreach ($detalle2 as $row2 => $column2) {

    	$p_desde_impreso2 = $column2["p_desde_impreso"];
    	$p_hasta_impreso2 = $column2["p_hasta_impreso"];
    	$p_venta_gravada2 = $column2["p_venta_gravada"];
    	$p_venta_iva2 = $column2["p_venta_iva"];
    	$p_total_exento2 = $column2["p_total_exento"];
    	$p_total_gravado2 = $column2["p_total_gravado"];
    	$p_total_venta2 = $column2["p_total_venta"];
    }

    

	$pdf = new TICKET('P','mm',array(76,297));
	$pdf->AddPage();

	if($tipo_comprobante == '1')
	{

		$pdf->SetFont('Arial', '', 10);
		$pdf->SetAutoPageBreak(true,1);

		include('../includes/ticketheader.inc.php');

		$pdf->SetFont('Arial', '', 9.2);
		$pdf->Text(2, $get_YH + 1, '------------------------------------------------------------------');

		$get_Y = $pdf->GetY();
		$pdf->SetFont('Arial','B',14);
		$pdf->Text(13,$get_Y + 8,'CORTE Z - MENSUAL');

		$pdf->SetFont('Arial','B',9.5);
		$pdf->Text(20, $get_Y + 14,'COMPR. ACTUAL # '.$p_hasta_impreso);

		$pdf->SetFont('Arial','B',10);
		$pdf->Text(33,$get_Y + 20,'MES');

		$pdf->setXY(4,$get_Y + 22);
	    $pdf->SetFont('Arial', '', 10);
	    $pdf->MultiCell(70, 4.2,
	    strtoupper($meses[date(substr($mes,0,2))-1].' del '.$ano), 0,'C',0 ,1);
		


		$pdf->SetFont('Arial','B',10);
	    $pdf->Text(21,$get_Y + 31,'FACTURAS IMPRESOS');
		$pdf->SetFont('Arial','B',10);

		$pdf->Text(26,$get_Y + 36,'DESDE : ');
		$pdf->Text(40,$get_Y + 36,' '.$p_desde_impreso2);

		$pdf->Text(26,$get_Y + 41,'HASTA : ');
		$pdf->Text(40,$get_Y + 41,' '.$p_hasta_impreso2);

		//$pdf->Text(18,$get_Y + 48,'DEVOLUCIONES : 0.00');

		$pdf->SetFont('Arial','B',12);
		$pdf->Text(16,$get_Y + 48,'VENTA POR FACTURA');

		$pdf->SetFont('Arial','',10);
		$pdf->Text(13,$get_Y + 55,'VENTA GRAVADA :');
		$pdf->SetFont('Arial','B',10);
		$pdf->Text(50,$get_Y + 55,$p_venta_gravada2);
		$pdf->SetFont('Arial','',10);
		$pdf->Text(25,$get_Y + 60,'VENTA IVA :');
		$pdf->SetFont('Arial','B',10);
		$pdf->Text(50,$get_Y + 60,$p_venta_iva2);
		$pdf->SetFont('Arial','',10);
		$pdf->Text(13,$get_Y + 65,'TOTAL GRAVADO :');
		$pdf->SetFont('Arial','B',10);
		$pdf->Text(50,$get_Y + 65,$p_total_gravado2);
		$pdf->SetFont('Arial','',10);
		$pdf->Text(18,$get_Y + 70,'TOTAL EXENTO :');
		$pdf->SetFont('Arial','B',10);
		$pdf->Text(50,$get_Y + 70,$p_total_exento2);
		$pdf->SetFont('Arial','',10);
		$pdf->Text(20,$get_Y + 75,'TOTAL VENTA :');
		$pdf->SetFont('Arial','B',10);
		$pdf->Text(50,$get_Y + 75,$p_total_venta2);

		//F

		$pdf->SetFont('Arial','B',10);
	    $pdf->Text(21,$get_Y + 84,'RECIBOS IMPRESOS');
		$pdf->SetFont('Arial','B',10);

		$pdf->Text(26,$get_Y + 89,'DESDE : ');
		$pdf->Text(40,$get_Y + 89,' '.$p_desde_impreso);

		$pdf->Text(26,$get_Y + 94,'HASTA : ');
		$pdf->Text(40,$get_Y + 94,' '.$p_hasta_impreso);

		//$pdf->Text(18,$get_Y + 48,'DEVOLUCIONES : 0.00');

		$pdf->SetFont('Arial','B',12);
		$pdf->Text(16,$get_Y + 102,'VENTA POR RECIBO');

		$pdf->SetFont('Arial','',10);
		$pdf->Text(20,$get_Y + 108,'TOTAL VENTA :');
		$pdf->SetFont('Arial','B',10);
		$pdf->Text(50,$get_Y + 108,$p_total_venta);

		$pdf->SetFont('Arial','B',14);
		$pdf->Text(16,$get_Y + 117,'TOTAL :');
		$pdf->SetFont('Arial','B',14);
		$pdf->Text(36,$get_Y + 117,'$ '.number_format(($p_total_venta + $p_total_venta2), 2));

		$pdf->SetFont('Arial', '', 10);
		$pdf->Text(2, $get_Y + 122, '-------------------------------------------------------------');

		$pdf->IncludeJS("print('true');");



    } else {

		$pdf->SetFont('Arial', '', 10);
		$pdf->Text(7, 58, '* EL COMPROBANTE DE VENTA*');
		$pdf->Text(20, 65, '* NO ES TICKET*');
	}


	$pdf->Output('I','Corte_Z_'.strtoupper($meses[date(substr($mes,0,2))-1].' del '.$ano).'.pdf',true);
	} catch (Exception $e) {

		$pdf->Text(22.8, 5, 'ERROR AL IMPRIMIR TICKET');
		$pdf->Output('I','Ticket_ERROR.pdf',true);

	}








 ?>
