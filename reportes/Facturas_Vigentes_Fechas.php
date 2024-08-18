<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    private $idsucursal;

    // Pase imagen
    function SetIdSucursal($idsucursal) {
        $this->idsucursal = $idsucursal;
    }

    // Page header
    function Header()
    {
        if ($this->page == 1)
        {

            // Logo
            //  $this->Image('logo.png',10,6,30);
            // Arial bold 15
            $this->SetFont('Arial','B',15);
            // Move to the right
            $this->Cell(98);
            // Title
            $fecha1 = isset($_GET['fecha1']) ? $_GET['fecha1'] : '';
            $fecha2 = isset($_GET['fecha2']) ? $_GET['fecha2'] : '';

            $this->Cell(105,10,'FACTURAS VIGENTES ENTRE EL '.$fecha1.' Y '.$fecha2,0,0,'C');
            if ($this->idsucursal == 1) {
                $this->Image('../web/assets/images/logo.png', 8, 5, 40, 22, '', '', '', true, 72);
            } else {
                $this->Image('../web/assets/images/logo2.png', 8, 8, 65, 0, '', '', '', true, 72);
            }
            // Line break
            $this->Ln(20);
        }
    }


// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(275,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'L');
        $this->Cell(43.2,10,date('d/m/Y H:i:s'),0,0,'C');
    }
}

    spl_autoload_register(function($className){
            $model = "../model/". $className ."_model.php";
            $controller = "../controller/". $className ."_controller.php";

           require_once($model);
           require_once($controller);
    });

    $fecha1 = isset($_GET['fecha1']) ? $_GET['fecha1'] : '';
    $fecha2 = isset($_GET['fecha2']) ? $_GET['fecha2'] : '';


    $fecha1 = DateTime::createFromFormat('d/m/Y', $fecha1)->format('Y-m-d');
    $fecha2 = DateTime::createFromFormat('d/m/Y', $fecha2)->format('Y-m-d');


    session_set_cookie_params(60*60*24*365); session_start();
	//$tipo_usuario = $_SESSION['user_tipo'];
	$idsucursal = $_SESSION['sucursal_id'];	

    $objVenta =  new Venta();
    $listado = $objVenta->Listar_Facturas('FECHAS',$fecha1,$fecha2,1,$idsucursal);
    $parametros = $objVenta->Ver_Moneda_Reporte();

    foreach ($parametros as $row => $column) {

        $moneda = $column['CurrencyName'];

    }

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
    $textoPorcetajeIVA = (round((float)$valorTarifaIVA)).'%';
	$valorPorcentajeIVA = ( (float)$valorTarifaIVA ) / 100;
	$porcentajeIVAMasUno = $valorPorcentajeIVA + 1;

    $fecha1 = DateTime::createFromFormat('Y-m-d', $fecha1)->format('d/m/Y');
    $fecha2 = DateTime::createFromFormat('Y-m-d', $fecha2)->format('d/m/Y');

try {
    // Instanciation of inherited class
    $pdf = new PDF('L','mm',array(216,330));
    $pdf->AliasNbPages();
    $pdf->SetIdSucursal($idsucursal);
    $pdf->AddPage();
    $pdf->SetFont('Arial','',10);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(25,5,'No. Venta',0,0,'L',1);
    $pdf->Cell(25,5,'Comprobante',0,0,'L',1);
    $pdf->Cell(35,5,'No. Factura',0,0,'L',1);
    $pdf->Cell(40,5,'Fecha y Hora',0,0,'L',1);
    $pdf->Cell(80,5,'Cliente',0,0,'L',1);
    $pdf->Cell(29,5,'Tipo Pago',0,0,'L',1);
    $pdf->Cell(15,5,'Subtotal',0,0,'L',1);
    $pdf->Cell(15,5,'IVA 0%',0,0,'L',1);
    $pdf->Cell(15,5,'IVA '.$textoPorcetajeIVA,0,0,'L',1);
    $pdf->Cell(15,5,'Desc.',0,0,'L',1);
    $pdf->Cell(15,5,'Total',0,0,'C',1);
    $pdf->Line(322,28,10,28);
    $pdf->Line(322,37,10,37);
    $pdf->Ln(9);
    $total = 0;
    $subtotal = 0;
    $iva0 = 0;
    $iva12 = 0;
    $descuento = 0;
    if (is_array($listado) || is_object($listado))
    {
        foreach ($listado as $row => $column) {

        $fecha_venta = $column["fecha_venta"];
        if(is_null($fecha_venta))
        {
            $c_fecha_venta = '';

        } else {

            $c_fecha_venta = DateTime::createFromFormat('Y-m-d H:i:s',$fecha_venta)->format('d/m/Y H:i:s');
        }

        $tipo_comprobante = $column["tipo_comprobante"];
        if($tipo_comprobante == '1')
        {
            $tipo_comprobante = 'RECIBO';

        } else if ($tipo_comprobante == '2'){

            $tipo_comprobante = 'FACTURA';

        } else if ($tipo_comprobante == '3'){

            $tipo_comprobante = 'BOLETA';
        }


        $tipo_pago = $column["tipo_pago"];
        if($tipo_pago == '1')
        {
            $tipo_pago = 'CONTADO';

        } else if ($tipo_pago == '2'){

            $tipo_pago = 'CREDITO';
        }

            $pdf->setX(9);
            $pdf->Cell(25,5,$column["numero_venta"],0,0,'L',1);
            $pdf->Cell(25,5,$tipo_comprobante,0,0,'L',1);
            $pdf->Cell(35,5,$column["serie_comprobante"],0,0,'L',1);
            $pdf->Cell(40,5,$c_fecha_venta,0,0,'L',1);
            $pdf->Cell(80,5,$column["cliente"],0,0,'L',1);
            $pdf->Cell(30,5,$tipo_pago,0,0,'L',1);
            $pdf->Cell(15,5,$column["sumas"],0,0,'L',1);
            $pdf->Cell(15,5,$column["total_exento"],0,0,'L',1);
            $pdf->Cell(15,5,$column["iva"],0,0,'L',1);
            $pdf->Cell(15,5,$column["total_descuento"],0,0,'L',1);
            $pdf->Cell(15,5,$column["total"],0,0,'C',1);
            $total = $total + $column["total"];
            $subtotal = $subtotal + $column["sumas"];
            $iva0 = $iva0 + $column["total_exento"];
            $iva12 = $iva12 + $column["iva"];
            $descuento = $descuento + $column["total_descuento"];
            $pdf->Ln(6);
            $get_Y = $pdf->GetY();
        }

        $pdf->Line(322,$get_Y+1,10,$get_Y+1);
        $pdf->SetFont('Arial','B',11);
        $pdf->Text(10,$get_Y + 10,'VALOR SUBTOTAL : '.number_format($subtotal, 2, '.', ','));
        $pdf->Text(10,$get_Y + 15,'VALOR SIN IVA : '.number_format($iva0, 2, '.', ','));
        $pdf->Text(10,$get_Y + 20,'VALOR IVA '.$textoPorcetajeIVA.' : '.number_format($iva12, 2, '.', ','));
        $pdf->Text(10,$get_Y + 25,'VALOR DESCUENTO : '.number_format($descuento, 2, '.', ','));
        $pdf->Text(10,$get_Y + 30,'VALOR TOTAL INGRESADO POR VENTAS : '.number_format($total, 2, '.', ','));
        //$pdf->Text(10,$get_Y + 15,'PRECIOS EN : '.$moneda);
    }


    $pdf->Output('I','Facturas_Vigentes_del_'.$fecha1.'_al_'.$fecha2.'.pdf');



} catch (Exception $e) {

    // Instanciation of inherited class
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L','Letter');
    $pdf->Text(50,50,'ERROR AL IMPRIMIR');
    $pdf->SetFont('Times','',12);
    $pdf->Output();

}

?>
