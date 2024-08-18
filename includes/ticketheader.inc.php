<?php

    if($idsucursal == 1){
        $pdf->Image('../web/assets/images/logoBN.png', 21, 1, 35, 14, '', '', '', true, 72);
    }else{
        $pdf->Image('../web/assets/images/logo2BN.png', 13, 2, 52, 0, '', '', '', true, 72);
    }

    $pdf->SetFont('Times', 'B', 12);
    $pdf->setXY(2,15);
    $pdf->MultiCell(73, 4.2, $nombre_sucursal, 0,'C',0 ,1);

    $pdf->setXY(2,19);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(73, 4.2, $propietario, 0,'C',0 ,1);

    $pdf->setXY(2,22.5);
    $pdf->SetFont('Arial', '', 9);
    $pdf->MultiCell(73, 4.2, 'R.U.C.: '.$nrc, 0,'C',0 ,1);

    $get_YD = $pdf->GetY();
    $pdf->setXY(2,$get_YD - 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(73, 4.2, $direccion1, 0,'C',0 ,1);
    $pdf->setXY(2,$get_YD + 2);
    $pdf->MultiCell(73, 4.2, $direccion2, 0,'C',0 ,1);

    $pdf->setXY(2,$get_YD + 5);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(73, 4.2, 'CORREO: lideresentecnologia1997@gmail.com', 0,'C',0 ,1); 

    $pdf->setXY(2,$get_YD + 8);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(73, 4.2, 'TELEFONO: '.$telefono_sucursal, 0,'C',0 ,1); 

    //$pdf->SetFont('Arial', '', 8);
    //$pdf->setXY(2,$get_YD + 2);
    //$pdf->MultiCell(73, 3, 'No. Autorizacion: '.$numero_resolucion, 0,'C',0 ,1);

    //$pdf->setXY(2,$get_YD + 2);
    //$pdf->MultiCell(73, 3, 'Clave de acceso: '.$clave_acceso, 0,'C',0 ,1);

    //$pdf->setXY(2,$get_YD + 16);
    //$pdf->MultiCell(73, 4.2, 'Serie: '.$serie, 0,'C',0 ,1);

    $get_YH = $pdf->GetY() + 1;