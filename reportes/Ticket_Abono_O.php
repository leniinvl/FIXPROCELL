<?php
	$idabono =  base64_decode(isset($_GET['abono']) ? $_GET['abono'] : '');
	require('ClassTicket.php');

	try
	{

	function __autoload($className){
            $model = "../model/". $className ."_model.php";
            $controller = "../controller/". $className ."_controller.php";

           require_once($model);
           require_once($controller);
    }

    $objCredito = new Credito();
    $datos = $objCredito->Imprimir_Ticket_Abono($idabono);

    foreach ($datos as $row => $column) {

    	$empresa = $column["p_empresa"];
    	$propietario = $column["p_propietario"];
    	$direccion = $column["p_direccion"];
    	$nit = $column["p_numero_nit"];
    	$nrc = $column["p_numero_nrc"];

    	$p_fecha_abono = $column["p_fecha_abono"];
    	$p_monto_abono = $column["p_monto_abono"];
    	$p_codigo_credito = $column["p_codigo_credito"];
    	$p_monto_credito = $column["p_monto_credito"];
    	$p_monto_abonado = $column["p_monto_abonado"];
    	$p_monto_restante = $column["p_monto_restante"];
    	$p_total_abonado = $column["p_total_abonado"];
    	$p_restante_credito = $column["p_restante_credito"];
      $moneda = $column["p_moneda"];
      $simbolo = $column["p_simbolo"];
      $cliente = $column["p_cliente"];
			$usuario = $column["p_usuario"];
    }

    $p_fecha_abono = DateTime::createFromFormat('Y-m-d H:i:s', $p_fecha_abono)->format('d/m/Y H:i:s');

		 $pdf = new TICKET('P','mm',array(76,297));
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetAutoPageBreak(true,1);

    include('../includes/ticketheadersample.inc.php');

    $pdf->SetFont('Arial', '', 9.2);
    $pdf->Text(2, $get_YH + 3, '------------------------------------------------------------------');

    $get_Y = $pdf->GetY();
    $pdf->SetFont('Arial','B',10);
    $pdf->Text(12,$get_Y + 7,'TICKET DE ABONO A CREDITO');
    $pdf->Text(28, $get_Y + 12, $p_codigo_credito);
    $pdf->Text(17,$get_Y + 18,'Abonado por : ');
    $pdf->SetFont('Arial','BI',8.5);
    $pdf->Text(42,$get_Y + 18, $usuario);
    $pdf->SetFont('Arial','B',10);
    $pdf->Text(26,$get_YH + 24,'FECHA Y HORA');
    $pdf->SetFont('Arial','',10);

    $pdf->setXY(4,$get_YH + 26);
    $pdf->SetFont('Arial', '', 8.5);
    $pdf->MultiCell(70, 4.2,
    $p_fecha_abono, 0,'C',0 ,1);

    $pdf->SetFont('Arial','B',12);
    $pdf->Text(20,$get_YH + 37,'VALOR ABONADO');
    $pdf->Text(30,$get_YH + 43, $simbolo.' '.$p_monto_abono);

    $pdf->SetFont('Arial','B',11);
    $pdf->Text(14.5,$get_Y + 50,'Total Credito :');
    $pdf->Text(48,$get_Y + 50, $simbolo.' '.$p_monto_credito);

    $pdf->Text(11,$get_Y + 55,'Total Abonado :');
    $pdf->Text(48,$get_Y + 55, $simbolo.' '.$p_total_abonado);

    $pdf->Text(9,$get_Y + 60,'Total Pendiente :');
    $pdf->Text(48,$get_Y + 60, $simbolo.' '.$p_restante_credito);

  	    $pdf->Line(73,$get_YH + 80 ,5,$get_YH + 80);

    $pdf->SetFont('Arial','BI',8.5);


    $pdf->setXY(4,$get_YH + 81);
    $pdf->MultiCell(70, 4.2,
    $cliente, 0,'C',0 ,1);


    /*$pdf->SetFont('Arial','I',8.5);
    $pdf->Text(4.5,$get_Y + 100,'********************** ORIGINAL **********************');*/
  

	$pdf->Output('I','ABONO_CREDITO_O'.$p_codigo_credito.'.pdf',true);


	} catch (Exception $e) {

		$pdf->Text(22.8, 5, 'ERROR AL IMPRIMIR TICKET');
		$pdf->Output('I','Ticket_ERROR.pdf',true);

	}








 ?>
