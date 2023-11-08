<?php
    $direccion1 ='CAYAMBE, LIBERTAD OE1-20 Y RESTAURACION';
    $direccion2 ='OTAVALO, JORDAN-SALINAS V1P55355 Y BOLIVAR';

    if($idsucursal == 1){
        $pdf->Image('../web/assets/images/logo.png', 21, 2, 36, 0, '', '', '', true, 72);
    }else{
        $pdf->Image('../web/assets/images/logo2.png', 20, 1, 36, 0, '', '', '', true, 72);
    }

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->setXY(2,13);
    if($idsucursal <> 3){
        $pdf->MultiCell(73, 4.2, $empresa, 0,'C',0 ,1);
    }else{
        $pdf->MultiCell(73, 4.2, 'MEGA TIENDA DEL CELULAR', 0,'C',0 ,1);
    }

    $pdf->setXY(2,16);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(73, 4.2, $propietario, 0,'C',0 ,1);

    $pdf->setXY(2,19);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(73, 4.2, $direccion1, 0,'C',0 ,1);
    if($idsucursal <> 3){
        $pdf->setXY(2,22);
        $pdf->MultiCell(73, 4.2, $direccion2, 0,'C',0 ,1);
    }
    $get_YD = $pdf->GetY();

    $pdf->setXY(2,$get_YD - 1);
    $pdf->MultiCell(73, 4.2, 'R.U.C.: '.$nrc, 0,'C',0 ,1);

    /*INGRESAR EN ESTA LINEA EL TELEFONO DEL TICKET*/

    $pdf->setXY(2,$get_YD + 2);
    $pdf->MultiCell(73, 4.2, 'TELEFONOS : 0985161086 / 0985355664', 0,'C',0 ,1); 

    /*$pdf->SetFont('Arial', '', 8);
    $pdf->setXY(2,$get_YD + 7);
    $pdf->MultiCell(73, 3, 'No. Autorizacion : '.$numero_resolucion, 0,'C',0 ,1);

    $pdf->setXY(2,$get_YD + 14);
    $pdf->MultiCell(73, 3, 'Clave de acceso : '.$clave_acceso, 0,'C',0 ,1);*/

    $pdf->setXY(2,$get_YD + 2);
    $pdf->MultiCell(75, 3, '', 0,'C',0 ,1);

    //$pdf->setXY(2,$get_YD + 16);
    //$pdf->MultiCell(73, 4.2, 'Serie : '.$serie, 0,'C',0 ,1);


    $get_YH = $pdf->GetY();