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
              $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto",
            "Septiembre","Octubre","Noviembre","Diciembre");

             $mes = isset($_GET['mes']) ? $_GET['mes'] : '';
             $ano = substr($mes,3,4);

            $this->Cell(110,10,'VENTAS VIGENTES DEL MES '.strtoupper($meses[date(substr($mes,0,2))-1].' del '.$ano),0,0,'C');
            if ($this->idsucursal == 1) {
                $this->Image('../web/assets/images/logo.png', 8, 5, 45, 24, '', '', '', true, 72);
            } else {
                $this->Image('../web/assets/images/logo2.png', 8, 8, 70, 0, '', '', '', true, 72);
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

    session_set_cookie_params(60*60*24*365); session_start();
    $idsucursal = $_SESSION['sucursal_id'];	

   $mes = isset($_GET['mes']) ? $_GET['mes'] : '';
   $mes = DateTime::createFromFormat('m/Y', $mes)->format('m-Y'); 


    $objVenta =  new Venta();
    $listado = $objVenta->Listar_Ventas('MES',$mes,'',1,'');
    $parametros = $objVenta->Ver_Moneda_Reporte();

    foreach ($parametros as $row => $column) {

        $moneda = $column['CurrencyName'];

    }

    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto",
    "Septiembre","Octubre","Noviembre","Diciembre");

    $mes_actual = strtoupper($meses[date(substr($mes, 0,2))-1]);
    $ano = substr($mes, 3,4);

try {
    // Instanciation of inherited class
    $pdf = new PDF('L','mm',array(216,330));
    $pdf->AliasNbPages();
    $pdf->SetIdSucursal($idsucursal);
    $pdf->AddPage();
    $pdf->SetFont('Arial','',10);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(30,5,'No. Venta',0,0,'L',1);
    $pdf->Cell(30,5,'Comprobante',0,0,'L',1);
    $pdf->Cell(40,5,'No. Comprobante',0,0,'L',1);
    $pdf->Cell(40,5,'Fecha y Hora',0,0,'L',1);
    $pdf->Cell(80,5,'Cliente',0,0,'L',1);
    $pdf->Cell(65,5,'Metodo Pago',0,0,'L',1);
    $pdf->Cell(22,5,'Total',0,0,'C',1);
    $pdf->Line(322,28,10,28);
    $pdf->Line(322,37,10,37);
    $pdf->Ln(9);
    $total = 0;
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
            $pdf->Cell(30,5,$column["numero_venta"],0,0,'L',1);
            $pdf->Cell(30,5,$tipo_comprobante,0,0,'L',1);
            $pdf->Cell(40,5,$column["serie_comprobante"],0,0,'L',1);
            $pdf->Cell(40,5,$c_fecha_venta,0,0,'L',1);
            $pdf->Cell(80,5,$column["cliente"],0,0,'L',1);
            $pdf->Cell(65,5,$tipo_pago,0,0,'L',1);
            $pdf->Cell(22,5,$column["total"],0,0,'C',1);
            $total = $total + $column["total"];
            $pdf->Ln(6);
            $get_Y = $pdf->GetY();
        }

        $pdf->Line(322,$get_Y+1,10,$get_Y+1);
        $pdf->SetFont('Arial','B',11);
        $pdf->Text(10,$get_Y + 10,'VALOR TOTAL INGRESADO POR VENTAS ESTE MES : '.number_format($total, 2, '.', ','));
        //$pdf->Text(10,$get_Y + 15,'PRECIOS EN : '.$moneda);
    }


    $pdf->Output('I','Ventas_Vigentes_'.$mes_actual.'_del_'.$ano.'.pdf');



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
