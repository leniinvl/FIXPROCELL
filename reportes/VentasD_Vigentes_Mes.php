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
            $this->SetFont('Arial','B',14);
            // Move to the right
            $this->Cell(98);
            // Title
              $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto",
            "Septiembre","Octubre","Noviembre","Diciembre");

             $mes = isset($_GET['mes']) ? $_GET['mes'] : '';
             $ano = substr($mes,3,4);

            $this->Cell(120,10,'DETALLES DE VENTAS VIGENTES DEL MES '.strtoupper($meses[date(substr($mes,0,2))-1].' del '.$ano),0,0,'C');
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

   $mes = isset($_GET['mes']) ? $_GET['mes'] : '';
   $mes = DateTime::createFromFormat('m/Y', $mes)->format('m-Y');
   
   session_set_cookie_params(60*60*24*365); session_start();
   //$tipo_usuario = $_SESSION['user_tipo'];
   $idsucursal = $_SESSION['sucursal_id'];	


    $objVenta =  new Venta();
    $listado = $objVenta->Listar_Ventas_Detalle('MES',$mes,'',1,''); 
    $totales = $objVenta->Listar_Ventas_Totales('MES',$mes,'',1,'');
    $parametros = $objVenta->Ver_Moneda_Reporte();

    foreach ($parametros as $row => $column) {

        $moneda = $column['CurrencyName'];

    }

    foreach ($totales as $row => $column) {
      $total_iva = $column['total_iva'];
      $total_exento = $column['total_exento'];
      $total_retenido = $column['total_retenido'];
      $total_descuento = $column['total_descuento'];
      $total_vendido = $column['total_vendido'];
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
    $pdf->Cell(30,5,'Cantidad',0,0,'L',1);
    $pdf->Cell(120,5,'Producto',0,0,'L',1);
    $pdf->Cell(32,5,'Precio Venta',0,0,'C',1);
    $pdf->Cell(25,5,'Costo',0,0,'C',1);
    $pdf->Cell(25,5,'Exento',0,0,'C',1);
    $pdf->Cell(25,5,'Descuento',0,0,'C',1);
    $pdf->Cell(25,5,'Total',0,0,'C',1);
    $pdf->Cell(25,5,'Utilidad',0,0,'C',1);
    $pdf->Line(322,28,10,28);
    $pdf->Line(322,37,10,37);
    $pdf->Ln(9);
    $total = 0;
    $importe = 0;
    $utilidad = 0;
    if (is_array($listado) || is_object($listado))
    {
        foreach ($listado as $row => $column) {

        $pdf->setX(9);
        $pdf->Cell(30,5,$column["cantidad"],0,0,'L',1);
        $pdf->Cell(120,5,$column["codigo_barra"].' - '.$column["nombre_producto"].' '.$column["siglas"].' '.$column["nombre_marca"],0,0,'L',1);
        $pdf->Cell(32,5,$column["precio_unitario"],0,0,'C',1);
        $pdf->Cell(25,5,$column["precio_compra"],0,0,'C',1);
        $pdf->Cell(25,5,$column["exento"],0,0,'C',1);
        $pdf->Cell(25,5,$column["descuento"],0,0,'C',1);
        $pdf->Cell(25,5,$column["importe"],0,0,'C',1);
        $pdf->Cell(25,5,number_format($column["utilidad_total"], 2, '.', ','),0,0,'C',1);
        $pdf->Ln(6);
        $get_Y = $pdf->GetY();
        $total = $total + $column["cantidad"];
        $utilidad = $utilidad + $column["utilidad_total"];
      }

      $importe =  (($column["sumas"] + $column["iva"] + $column["total_exento"]) - $column["retenido"]) - $column["total_descuento"];

      $pdf->Line(322,$get_Y+1,10,$get_Y+1);
      $pdf->SetFont('Arial','B',11);
      $pdf->Text(10,$get_Y + 10,'TOTAL DE PRODUCTOS VENDIDOS : '.number_format($total, 2, '.', ','));
      $pdf->Text(10,$get_Y + 15,'VALOR INGRESADO POR VENTAS : '.number_format($total_vendido, 2, '.', ','));
      $pdf->Text(10,$get_Y + 20,'VALOR IMPUESTOS EN VENTAS : '.number_format($total_iva, 2, '.', ','));
      //$pdf->Text(10,$get_Y + 25,'VALOR RETENIDO : '.number_format($total_retenido, 2, '.', ','));
      $pdf->Text(10,$get_Y + 25,'VALOR EXENTO : '.number_format($total_exento, 2, '.', ','));
      $pdf->Text(10,$get_Y + 30,'VALOR EN DESCUENTOS : '.number_format($total_descuento, 2, '.', ','));
      $pdf->Text(10,$get_Y + 35,'***GANANCIA TOTAL POR VENTAS : '.number_format($utilidad, 2, '.', ','));
      //$pdf->Text(250,$get_Y + 45,'PRECIOS EN : '.$moneda);
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
