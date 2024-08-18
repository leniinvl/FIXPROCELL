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
            $this->Cell(105);
            // Title
            $this->Cell(105,10,'Reporte de productos disponibles en almacen',0,0,'C');
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

    $idsucursal = isset($_GET['id']) ? $_GET['id'] : '';
    $idcategoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

    $objProducto = new Producto();
    $listado = $objProducto->Listar_Productos_Vigentes($idsucursal, $idcategoria);

try {
    // Instanciation of inherited class
    $pdf = new PDF('L','mm',array(216,330));
    $pdf->AliasNbPages();
    $pdf->SetIdSucursal($idsucursal);
    $pdf->AddPage();
    $pdf->SetFont('Arial','',9);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(28,5,'Codigo',0,0,'L',1);
    $pdf->Cell(80,5,'Producto',0,0,'L',1);
    $pdf->Cell(25,5,'Marca',0,0,'L',1);
    $pdf->Cell(30,5,'Modelo',0,0,'L',1);
    //$pdf->Cell(22,5,'Color',0,0,'L',1);
    $pdf->Cell(25,5,'Categoria',0,0,'L',1);
    $pdf->Cell(35,5,'Almacen',0,0,'L',1);
    $pdf->Cell(20,5,'P.Costo',0,0,'L',1);
    $pdf->Cell(20,5,'P.Venta',0,0,'L',1);
    $pdf->Cell(20,5,'P.Oferta',0,0,'L',1);
    //$pdf->Cell(14,5,'Dist.1',0,0,'L',1);
    //$pdf->Cell(14,5,'Dist.2',0,0,'L',1);
    $pdf->Cell(14,5,'Stock',0,0,'L',1);
    $pdf->Line(322,28,10,28);
    $pdf->Line(322,37,10,37);
    $pdf->Ln(9);
    $total = 0;
    if (is_array($listado) || is_object($listado))
    {
        foreach ($listado as $row => $column) {

            $pdf->setX(9);
            if ($column["codigo_barra"]=="") {
                $pdf->Cell(29,5,$column["codigo_interno"],0,0,'L',1);
            }else {
                $pdf->Cell(29,5,$column["codigo_barra"],0,0,'L',1);
            }
            $pdf->Cell(80,5,$column["nombre_producto"],0,0,'L',1);
            $pdf->Cell(25,5,$column["nombre_marca"],0,0,'L',1);
            $pdf->Cell(30,5,$column["nombre_presentacion"],0,0,'L',1);
            //$pdf->Cell(22,5,$column["nombre_color"],0,0,'L',1);
            $pdf->Cell(25,5,$column["nombre_categoria"],0,0,'L',1);
            $pdf->Cell(35,5,$column["nombre_sucursal"],0,0,'L',1);
            $pdf->Cell(20,5,$column["precio_compra"],0,0,'L',1);
            $pdf->Cell(20,5,$column["precio_venta"],0,0,'L',1);
            $pdf->Cell(20,5,$column["precio_venta_minimo"],0,0,'L',1);
            //$pdf->Cell(14,5,$column["precio_venta_mayoreo"],0,0,'L',1);
            //$pdf->Cell(14,5,$column["precio_super_mayoreo"],0,0,'L',1);
            $pdf->Cell(14,5,$column["stock"],0,0,'L',1);
            $pdf->Ln(6);
            $get_Y = $pdf->GetY();
            $total = $total + 1;
        }

        $pdf->Line(322,$get_Y+1,10,$get_Y+1);
        $pdf->SetFont('Arial','B',11);
        $pdf->Text(10,$get_Y + 10,'TOTAL DE PRODUCTOS DISPONIBLES: '.number_format($total, 2, '.', ','));
    }

    $pdf->Output('I','Productos_Vigentes.pdf',true);



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