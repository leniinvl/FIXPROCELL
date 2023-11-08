<?php
set_time_limit(300);
require_once ("ctr_pdf.php");
require_once ("ctr_funciones.php");
require_once ("../facturacionphp/lib/nusoap.php");

class autorizar{
   public function autorizar_xml($namefile,$correo,$id_venta){

        //Respuesta procesamiento
        $retorno='';
        //$correo='vlakdeath@gmail.com'; // Dev

        if($correo==''){
            $correo='cusinadriana@gmail.com';
        }
        //Ruta archivo p12
        $firma = '../facturacionphp/controladores/6101215_identity.p12';
        $clave = 'Adri@na.2022';

        if (!$almacen_cert = file_get_contents($firma)) {
            return 'No se puede leer archivo del certificado';
            //echo "Error: No se puede leer el fichero del certificado\n";
            //exit;
        }

        if (openssl_pkcs12_read($almacen_cert, $info_cert, $clave)) {
            $func = new fac_ele();
            /***************************/
            /*PARAMETROS DE FACTURACION*/
            /***************************/
            $vtipoambiente = 1; // 1 PRUEBAS - 2 PRODUCCION
            /***************************/
            /*PARAMETROS DE FACTURACION*/
            /***************************/
            $wsdls = $func->wsdl($vtipoambiente);
            $recepcion = $wsdls['recepcion'];        
            $autorizacionws = $wsdls['autorizacion'];

            /********/
            /* PATH */
            /********/
            $CPANEL='/home/palaciod/public_html/web/facturacionphp';
            $LOCAL='../facturacionphp';
            $path=$LOCAL;

            //RUTAS PARA LOS ARCHIVOS XML
            $ruta_no_firmados = $path.'/comprobantes/no_firmados/'.$namefile.'.xml';
            $ruta_si_firmados = $path.'/comprobantes/si_firmados/';
            $ruta_autorizados = $path.'/comprobantes/autorizados/';
            $pathPdf = $path.'/comprobantes/pdf/';
            $p12 = $path.'/controladores/6101215_identity.p12';
            $tipo='FV';
            $nuevo_xml = $namefile.'.xml';
            $controlError = false;
            $m = '';
            $show = '';

            //VERIFICAMOS SI EXISTE EL XML NO FIRMADO CREADO
            if (file_exists($ruta_no_firmados)) {
                $argumentos = $ruta_no_firmados . ' ' . $ruta_si_firmados . ' ' . $nuevo_xml . ' ' . $p12 . ' ' . $clave;
                
                /********/
                /* PATH */
                /********/
                $CPANEL2='/home/palaciod/public_html/web/firmaComprobanteElectronico/dist/firmaComprobanteElectronico.jar';
                $LOCAL2='../firmaComprobanteElectronico/dist/firmaComprobanteElectronico.jar';
                $path2=$LOCAL2;

                //FIRMA EL XML 
                $comando = ('java -jar '. $path2 .' '. $argumentos);
                $resp = shell_exec($comando);
                $claveAcces = simplexml_load_file($ruta_si_firmados . $nuevo_xml);
            	$claveAcceso['claveAccesoComprobante'] = substr($claveAcces->infoTributaria[0]->claveAcceso, 0, 49);
            	//var_dump($claveAcceso);
                //var_dump($comando);
                //var_dump($resp);

                    //$pdf = new pdf();
                    //$pdf->pdfFactura($correo,$namefile,$id_venta,'10/01/2023 12:02:88', 2,'0801202301100433792700110020010000000011234567816');
                    //$func->correos($correo,$namefile,'0801202301100433792700110020010000000011234567816');   
                    //return 'Test pdf';

                switch (substr($resp, 0, 7)) {
                    case 'FIRMADO':
                        $xml_firmado = file_get_contents($ruta_si_firmados . $nuevo_xml);
                        $dataXml['xml'] = base64_encode($xml_firmado);
                        try {
                            $client = new nusoap_client($recepcion, true);
                            $client->soap_defencoding = 'utf-8';
                            $client->xml_encoding = 'utf-8';
                            $client->decode_utf8 = false;
                            $response = $client->call('validarComprobante', $dataXml);
                            //var_dump($response);
                            //echo 'COMPROBANTE FIRMADO<br>';
                            $retorno .= 'COMPROBANTE FIRMADO --> ';
                        } catch (Exception $e) {
                            return 'Error: Validacion comprobante: '. $client->response;
                            //echo "Error!<br />";
                            //echo $e->getMessage();
                            //echo 'Last response: ' . $client->response . '<br />';
                        }
                        switch ($response["RespuestaRecepcionComprobante"]["estado"]) {
                            case 'RECIBIDA':
                                //echo $response["RespuestaRecepcionComprobante"]["estado"] . '<br>';
                                $retorno .= $response["RespuestaRecepcionComprobante"]["estado"] .' --> ';
                                $client = new nusoap_client($autorizacionws, true);
                                $client->soap_defencoding = 'utf-8';
                                $client->xml_encoding = 'utf-8';
                                $client->decode_utf8 = false;
                                try{
                                    $responseAut = $client->call('autorizacionComprobante', $claveAcceso);
                                }catch(Exception $e) {
                                    return 'Error: SRI no completo autorizacion: '. $client->response;
                                    //echo "Error!<br>";
                                    //echo $e->getMessage();
                                    //echo 'Last response: ' . $client->response . '<br />';
                                }
                                switch ($responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['estado']) {
                                    case 'AUTORIZADO':
                                        $autorizacion = $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion'];
                                        $estado = $autorizacion['estado'];
                                        $numeroAutorizacion = $autorizacion['numeroAutorizacion'];
                                        $fechaAutorizacion = $autorizacion['fechaAutorizacion'];
                                        $comprobanteAutorizacion = $autorizacion['comprobante'];
                                        //echo '<script>alert("COMPROBANTE AUTORIZADO Y ENVIADO AL CORREO");location.href="../vistas/index.php";</script>';
                                        //echo '<script>alert(Comprobante AUTORIZADO y enviado con exito con autoricacion N° '.$numeroAutorizacion.');</script>';
                                        $vfechaauto = substr($fechaAutorizacion, 0, 10) . ' ' . substr($fechaAutorizacion, 11, 8);
                                        //echo 'Xml ' .
                                        $func->crearXmlAutorizado($estado, $numeroAutorizacion, $vfechaauto, $comprobanteAutorizacion, $ruta_autorizados, $nuevo_xml);
                                        $pdf = new pdf();
                                        $pdf->pdfFactura($correo,$namefile,$id_venta,$vfechaauto,$vtipoambiente,$numeroAutorizacion);
                                        $func->correos($correo,$namefile,$numeroAutorizacion);    
                                        $retorno .= 'Comprobante AUTORIZADO y enviado con exito, autoricacion:'.$numeroAutorizacion.' --> ';        
                                        //return "Comprobante AUTORIZADO y enviado al correo";                        
                                        //unlink($ruta_si_firmados . $nuevo_xml);
                                        //require_once './funciones/factura_pdf.php';
                                        //var_dump($func);
                                    break;
                                    case 'EN PROCESO':
                                        $retorno .= 'El comprobante se encuentra EN PROCESO: '. $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['estado'] .' --> ';
                                        //return "El comprobante generado se encuentra EN PROCESO";
                                        //echo '<script>alert(Comprobante AUTORIZADO y enviado con exito);</script>';
                                        //echo "El comprobante se encuentra EN PROCESO:<br>";
                                        //echo $responseAut['RespuestaAutorizacionComprobante']['autorizaciones']['autorizacion']['estado'] . '<br>';
                                        //$m .= 'El documento se encuentra en proceso<br>';
                                        $controlError = true;
                                    break;
                                    default:
                                        if ($responseAut['RespuestaAutorizacionComprobante']['numeroComprobantes'] == "0") {
                                            //echo 'No autorizado</br>';
                                            //echo 'No se encontro informacion del comprobante en el SRI, vuelva an enviarlo.</br>';
                                            $retorno .= 'No se encontro informacion del comprobante en el SRI, vuelva a enviarlo --> ';
                                        } else if ($responseAut['RespuestaAutorizacionComprobante']['numeroComprobantes'] == "1") {
                                            //echo $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["estado"].'</br>';
                                            //echo $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"].'</br>';
                                            $retorno .= $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["estado"]. ' --> ';
                                            $retorno .= $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"]. ' --> ';
                                            if(isset($responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"]["informacionAdicional"])){
                                                //echo $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"]["informacionAdicional"].'</br>';
                                                $retorno .= $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"]["informacionAdicional"]. ' --> ';
                                                $ms = $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"].' => '.
                                                        $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"]["informacionAdicional"];
                                            }else{
                                                $ms = $responseAut['RespuestaAutorizacionComprobante']["autorizaciones"]["autorizacion"]["mensajes"]["mensaje"]["mensaje"];
                                            }
                                            //BORRAR EL VAR_DUMP 
                                            //echo '<br/><br/>'.var_dump($responseAut).'<br/><br/>';
                                        } else {
                                            //echo 'No autorizado<br/>';
                                            //echo "Esta es la respuesta de SRI:<br/>";
                                            //echo var_dump($responseAut);
                                            //echo "<br/>";
                                            //echo 'INFORME AL ADMINISTRADOR!</br>';
                                            $retorno .= 'No autorizado, informe al administrador  --> ';
                                        }
                                        //return "Comprobante NO AUTORIZADO registre un informe";
                                    break;
                                }
                                break;
                            case 'DEVUELTA':
                                $m .= $response["RespuestaRecepcionComprobante"]["estado"] . ' --> ';
                                $m .= $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["claveAcceso"] . ' --> ';
                                $m .= $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["mensaje"] . ' --> ';
                                if (isset($response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["informacionAdicional"])) {
                                    $m .= $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["informacionAdicional"] . ' --> ';
                                    $ms = $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["mensaje"] . ' => ' . $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["informacionAdicional"];
                                } else {

                                    $ms = $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["mensaje"];
                                }

                                $m .= $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["tipo"] . ' --> ';
                                //echo $response["RespuestaRecepcionComprobante"]["estado"] . '<br>';
                                //echo $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["claveAcceso"] . '<br>';
                                //echo $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["mensaje"] . '<br>';
                                if (isset($response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["informacionAdicional"])) {
                                    //echo $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["informacionAdicional"] . '<br>';
                                }
                                //echo $response["RespuestaRecepcionComprobante"]["comprobantes"]["comprobante"]["mensajes"]["mensaje"]["tipo"] . '<br><br>';
                                $retorno .= $m;
                                $controlError = true;
                            break;
                            case  false:
                                $retorno .= 'Sin respuesta SRI, informe al adminsitrador. --> ';
                            	//echo 'nose';
                            break;
                            default:
                                //echo "<br>Se ha producido un problema. Vuelve a intentarlo.<br>";
                                //echo "Esta es la respuesta de SRI:<br/>";
                                //echo var_dump($response).'<br>';
                                //$m .= var_dump($response).'<br>';
                                //echo "<br><br>";
                                $controlError = true;
                                //return "Se ha producido un problema en el SRI, sera procesada posteriormente";
                                $retorno .= 'Se ha producido un problema SRI, informe al adminsitrador. --> ';
                            break;
                        }      
                    break;
                    default:
                        //echo 'no se puede firmar el doc';
                        //return "No se puede firmar el COMPROBANTE, sera procesada posteriormente";
                        $retorno .= 'No se puede firmar el COMPROBANTE, sera procesada posteriormente --> ';
                    break;
                }
               // echo 'veamos';
            } else {
                //echo "Error: No se puede leer el almacén de certificados o clave del cert p12 es incorrecta.\n";
                //exit;
                //return "Certificado no encontrado, sera procesada posteriormente";
                $retorno .= 'Error: No se puede leer el almacén de certificados o clave del cert p12 es incorrecta --> ';
            }
        } else {
            //echo 'cargar un comprobante';
            //return "Genere un comprobante para procesada";
            $retorno .= 'Comprobante no generado --> ';
        }

        return $retorno;
   }
}

?>