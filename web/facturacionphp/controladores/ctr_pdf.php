<?php

include ("../facturacionphp/lib/FPDF/fpdf.php");
include ("../facturacionphp/lib/codigo_barras/barcode.inc.php");

class pdf extends FPDF{

	public function pdfFactura($correo,$namefile,$idventa,$fechaAutorizacion,$vtipoambiente,$numeroAutorizacion){

		//Recuperacion de datos factura
		$objVenta = new Venta();
		$detalle = $objVenta->Imprimir_Ticket_DetalleVenta($idventa); 
		$datos = $objVenta->Imprimir_Ticket_Venta($idventa);

		$ambiente = 'PRUEBAS';
		if($vtipoambiente==2){
			$ambiente = 'PRODUCCION';
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
		}


		$pdf = new FPDF();
		$pdf->SetCreator('PALACIO DEL CELULAR');
		$pdf->SetAuthor('PALACIO DEL CELULAR');
		$pdf->SetTitle('factura');
		$pdf->SetSubject('PDF');
		$pdf->SetKeywords('FPDF, PDF, cheque, impresion, guia');
		$pdf->SetMargins('10', '10', '10');
		$pdf->SetAutoPageBreak(TRUE);
		$pdf->SetFont('Arial', '', 7);
		$pdf->AddPage();
		$pdf->Image('../facturacionphp/img/logo.png',20,15,70);
		$pdf->SetXY(107, 10);
		$pdf->Cell(93, 84, '', 1, 1);
		$pdf->SetXY(10, 54);
		$pdf->Cell(93, 40, '', 1, 1);
		$pdf->SetXY(10, 98);
		$pdf->Cell(190, 12, '', 1, 1);
		$pdf->SetXY(10, 114);
		$pdf->Cell(190, 173, '', 0, 1);
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(12, 54);$pdf->Cell(93, 10, $propietario , 0 , 1, 'L');
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(12, 59);$pdf->Cell(93, 10, $empresa , 0 , 1, 'L');
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(12, 68);$pdf->MultiCell(15, 4, 'Direccion Matriz', 0 , 'L');
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(26, 68);$pdf->MultiCell(78, 4, 'PICHINCHA / CAYAMBE / CAYAMBE / LIBERTAD OE1-20 Y RESTAURACION', 0 , 'L');
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(11, 80);$pdf->MultiCell(15, 4, 'Direccion Sucursal', 0 , 'C');
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(26, 80);$pdf->MultiCell(78, 4, 'IMBABURA / OTAVALO / JORDAN / SALINAS V1P55355 Y BOLIVAR', 0 , 'L');
		$pdf->SetFont('Arial', '', 9);$pdf->SetXY(110, 10);$pdf->Cell(40, 8, 'R.U.C.: '.$nrc , 0 , 1);
		$pdf->SetFont('Arial', '', 9);$pdf->SetXY(110, 16);$pdf->Cell(93, 8, 'FACTURA', 0 , 1);
		$pdf->SetFont('Arial', '', 9);$pdf->SetXY(110, 20);$pdf->Cell(40, 8, 'No: '.$serie_comprobante , 0 , 1);
		$pdf->SetFont('Arial', '', 9);$pdf->SetXY(110, 26);$pdf->Cell(40, 10, 'Numero de Autorizacion: ', 0 , 1);
		$pdf->SetFont('Arial', '', 9);$pdf->SetXY(110, 30);$pdf->Cell(40, 10, $numeroAutorizacion , 0 , 1);
		$pdf->SetFont('Arial', '', 9);$pdf->SetXY(110, 37);$pdf->Cell(40, 10, 'FECHA AUTORIZACION: '.$fechaAutorizacion , 0 , 1);
		$pdf->SetFont('Arial', '', 9);$pdf->SetXY(110, 45);$pdf->Cell(93, 8, 'AMBIENTE: '.$ambiente , 0 , 1, 'L');
		$pdf->SetFont('Arial', '', 9);$pdf->SetXY(110, 52);$pdf->Cell(93, 8, 'EMISION: NORMAL', 0 , 1, 'L');
		$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(107, 62);$pdf->Cell(93, 4, 'CLAVE DE ACCESO', 0 , 1, 'C');
		new barCodeGenrator($clave_acceso, 1, 'barra.gif', 455, 60, false);
		$pdf->Image('barra.gif', 109, 67, 90, 10);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->SetXY(107, 80);
		$pdf->Cell(93, 5, $clave_acceso, 0 , 1, 'C');


		$pdf->SetFont('Arial', 'B', 6);$pdf->SetXY(12, 100);$pdf->Cell(30, 3, 'RAZON SOCIAL / NOMBRES Y APELLIDOS ', 0 , 1, 'L');
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(60, 100);$pdf->MultiCell(160, 3, $cliente_nombre ,0,'L');
		$pdf->SetFont('Arial', 'B', 6);$pdf->SetXY(12, 104);$pdf->Cell(30, 6, 'FECHA DE EMISION', 0 , 1, 'L');
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(40, 104);$pdf->Cell(100, 6, substr($fecha_venta,0,10) , 0 , 1);
		$pdf->SetFont('Arial', 'B', 6);$pdf->SetXY(125, 100);$pdf->Cell(30, 3, 'IDENTIFICACION:', 0 , 1);
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(145, 100);$pdf->Cell(30, 3, $cliente_ruc, 0 , 1);
		$pdf->SetFont('Arial', 'B', 6);$pdf->SetXY(125, 105);$pdf->Cell(30, 3, 'DIRECCION:', 0 , 1);
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(145, 105);$pdf->Cell(30, 3, $cliente_direccion, 0 , 1);
		$pdf->SetFont('Arial', 'B', 7);

		$pdf->SetXY(10, 114);$pdf->Cell(13, 6, false, 1 , 1);
		$pdf->SetXY(10, 114);$pdf->Cell(13, 3, 'Cod.', 0 , 1, 'C');
		$pdf->SetXY(10, 117);$pdf->Cell(13, 3, 'Principal', 0 , 1, 'C');
		$pdf->SetXY(23, 114);$pdf->Cell(13, 6, false, 1 , 1);
		$pdf->SetXY(23, 114);$pdf->Cell(13, 3, 'Cod.', 0 , 1, 'C');
		$pdf->SetXY(23, 117);$pdf->Cell(13, 3, 'Auxiliar', 0 , 1, 'C');
		$pdf->SetXY(36, 114);$pdf->Cell(13, 6, 'Cant', 1 , 1, 'C');
		$pdf->SetXY(49, 114);$pdf->Cell(110, 6, 'DESCRIPCION', 1 , 1, 'C');
		$pdf->SetXY(159, 114);$pdf->Cell(13, 6, false, 1 , 1);
		$pdf->SetXY(159, 114);$pdf->Cell(13, 3, 'Precio', 0 , 1, 'C');
		$pdf->SetXY(159, 117);$pdf->Cell(13, 3, 'Unitario', 0 , 1, 'C');
		$pdf->SetXY(172, 114);$pdf->Cell(15, 6, 'Descuento', 1 , 1, 'C');
		$pdf->SetXY(187, 114);$pdf->Cell(13, 6, false, 1 , 1);
		$pdf->SetXY(187, 114);$pdf->Cell(13, 3, 'Precio', 0 , 1, 'C');
		$pdf->SetXY(187, 117);$pdf->Cell(13, 3, 'Total', 0 , 1, 'C');

		//CABECERA KARDEX TOTALES
		$pdf->SetFont('Arial', '', 7);
		$ejey = 120;
		while($row = $detalle->fetch(PDO::FETCH_ASSOC)) {
			$pdf->SetXY(10, $ejey);$pdf->Cell(13, 10, $row['codigo'], 1 , 1, 'C');
			$pdf->SetXY(23, $ejey);$pdf->Cell(13, 10, '', 1 , 1, 'C');
			$pdf->SetXY(36, $ejey);$pdf->Cell(13, 10, $row['cantidad'], 1 , 1, 'C');$pdf->SetFont('Arial', '', 7);
			$pdf->SetXY(49, $ejey);$pdf->Cell(110, 10, '', 1 , 0);
			$pdf->SetXY(49, $ejey);$pdf->MultiCell(110, 5, $row['descripcion'] ,'L');$pdf->SetFont('Arial', '', 7);
			$pdf->SetXY(159, $ejey);$pdf->Cell(13, 10, $row['precio_unidad'] , 1 , 1, 'C');
			$pdf->SetXY(172, $ejey);$pdf->Cell(15, 10, $row['descuento'] , 1 , 1, 'C');
			$pdf->SetXY(187, $ejey);$pdf->Cell(13, 10, $row['sin_impuesto_total'] , 1 , 1, 'C');
			$ejey += 10;
		}

		$ejey += 4;
		//KARDEX TOTALES
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->SetXY(120, $ejey);$pdf->Cell(50, 4, 'SUBTOTAL SIN IMPUESTOS', 1 , 1, 'L');
		$pdf->SetXY(120, $ejey+4);$pdf->Cell(50, 4, 'SUBTOTAL 12%', 1 , 1, 'L');
		$pdf->SetXY(120, $ejey+8);$pdf->Cell(50, 4, 'SUBTOTAL 0%', 1 , 1, 'L');
		$pdf->SetXY(120, $ejey+12);$pdf->Cell(50, 4, 'IVA 12%', 1 , 1, 'L');
		$pdf->SetXY(120, $ejey+16);$pdf->Cell(50, 4, 'DESCUENTO', 1 , 1, 'L');
		$pdf->SetXY(120, $ejey+20);$pdf->Cell(50, 4, 'VALOR TOTAL', 1 , 1, 'L');

		$pdf->SetXY(170, $ejey);$pdf->Cell(30, 4, number_format((($sumas - ($descuento / 1.12)) + $exento) , 2), 1 , 1, 'R');
		$pdf->SetXY(170, $ejey+4);$pdf->Cell(30, 4, number_format(($sumas - ($descuento / 1.12)),2) , 1 , 1, 'R');
		$pdf->SetXY(170, $ejey+8);$pdf->Cell(30, 4, $exento , 1 , 1, 'R');
		$pdf->SetXY(170, $ejey+12);$pdf->Cell(30, 4, number_format((($sumas - ($descuento / 1.12)) * 0.12),2) , 1 , 1, 'R');
		$pdf->SetXY(170, $ejey+16);$pdf->Cell(30, 4, number_format(($descuento / 1.12),2) , 1 , 1, 'R');
		$pdf->SetXY(170, $ejey+20);$pdf->Cell(30, 4, $total, 1 , 1, 'R');

		//INFO ADICIONAL
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->SetXY(10, $ejey);$pdf->Cell(105, 6, 'INFORMACION ADICIONAL', 1 , 1, 'C');
		$pdf->SetFont('Arial', '', 7);
		$pdf->SetXY(10, $ejey+6);$pdf->Cell(20, 6, '       Email: ', 'L' , 1, 'L');
		$pdf->SetXY(10, $ejey+12);$pdf->Cell(20, 6, '', 'L' , 1, 'L');
		$pdf->SetXY(10, $ejey+18);$pdf->Cell(20, 6, '', 'L' , 1, 'L');
		$pdf->SetXY(30, $ejey+6);$pdf->Cell(85, 6, $correo, 'R' , 1, 'L');
		$pdf->SetXY(30, $ejey+12);$pdf->Cell(85, 6, '', 'R' , 1, 'L');
		$pdf->SetXY(30, $ejey+18);$pdf->Cell(85, 6, '', 'R' , 1, 'L');
		$pdf->SetXY(10, $ejey+24);$pdf->MultiCell(105, 10, '', 'LRB', 'L');
		
		//FORMA DE PAGO
		$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(10, $ejey+39);$pdf->Cell(75, 6, 'Forma de pago', 1 , 1, 'C');
		$pdf->SetFont('Arial', 'B', 7);$pdf->SetXY(85, $ejey+39);$pdf->Cell(30, 6, 'Valor', 1 , 1, 'C');
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(10, $ejey+45);$pdf->Cell(75, 6, '01 - SIN UTILIZACION DEL SISTEMA FINANCIERON', 'LRB' , 1, 'L');
		$pdf->SetFont('Arial', '', 7);$pdf->SetXY(85, $ejey+45);$pdf->Cell(30, 6, $total, 'RB' , 1, 'L');
		
		//SAVE
		$pdf->Output('../facturacionphp/comprobantes/pdf/'.$namefile.'.pdf','F');
	}
}
/*$pdf = new pdf();
$pdf->pdfFacTura('555');*/

?>