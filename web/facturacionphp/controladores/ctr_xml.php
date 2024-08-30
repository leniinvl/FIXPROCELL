<?php 
include 'digito_verificador.php';

spl_autoload_register(function($className){	
	$model = "../../model/". $className ."_model.php";
	$controller = "../../controller/". $className ."_controller.php";

	require_once($model);
	require_once($controller);
});

class xml{
	public function xmlFactura($idventa, $idsucursal){

		//Recuperacion de datos factura
		$objVenta = new Venta();
		$detalle = $objVenta->Imprimir_Ticket_DetalleVenta($idventa); 
    	$datos = $objVenta->Imprimir_Ticket_Venta($idventa);

		foreach ($datos as $row => $column) {
			$clave = $column["p_clave_acceso"];
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
			$correo = $column["p_cliente_correo"];
		}

		//Recuperacion de datos empresa
		$objParametro =  new Parametro();
      	$parametros = $objParametro->Listar_Parametros();

		if (is_array($parametros) || is_object($parametros)){
			foreach ($parametros as $row => $column){
				$nombre_empresa = $column['nombre_empresa'];
				$razon_social = $column['propietario'];
				$numero_ruc = $column['numero_nrc'];
				$direccion_empresa = $column['direccion_empresa'];
				$valorTarifaIVA = $column['porcentaje_iva'];
			}
		}

		//Recuperacion de datos sucursal
		$objSucursal =  new Sucursal();
      	$sucursal = $objSucursal->Consultar_Sucursal($idsucursal);

		if (is_array($sucursal) || is_object($sucursal)){
			foreach ($sucursal as $row => $column){
				$nombre_sucursal = $column['nombre'];
				$direccion_sucursal = $column['direccion'];
				$telefono_sucursal = $column['telefono'];
			}
		}

		/***************************/
		/***************************/
		/*PARAMETROS DE FACTURACION*/
		/***************************/
		/***************************/

		//Recuperacion de parametros generales
		$parametro_general = $objParametro->Consultar_Parametro_General('PRM_FACTURACION_AMBIENTE');
		$ambiente = '1'; // 1 Pruebas - 2 Produccion
		if (is_array($parametro_general) || is_object($parametro_general)){
			foreach ($parametro_general as $row => $column){
				$ambiente = $column['valor_cadena'];
				$prm_ambiente = $column['estado'];
			}
		}

		$codigoNumerico = '12345678';
		$puntoEmision = '001';
		$tipoComprobante = '01';
		$tipoEmision = '1';
		$obligadoContabilidad = 'NO';

		$ruc = $numero_ruc;
		$establecimiento = substr($serie_comprobante, 0, 3); // 001  -  002
		$secuencial=substr($serie_comprobante, 8);
		$dirEstablecimiento = $direccion_sucursal;
		$numserie= $establecimiento.$puntoEmision;
		$tipoIdentificacionComprador='05'; //cedula:05  ruc:04  pasaporte:06
		if(strlen($cliente_ruc)==13 && substr($cliente_ruc, 10)=="001"){
			$tipoIdentificacionComprador='04';
		}
		/*if(strlen($cliente_ruc)>=13 && substr($cliente_ruc, 10)!="001"){
			$tipoIdentificacionComprador='06';
		}*/
		/*if($idsucursal == 2){
			$establecimiento = '002';
			$dirEstablecimiento = 'IMBABURA / OTAVALO / JORDAN / SALINAS V1P55355 Y BOLIVAR';
			$numserie='002001';
		}*/

		$fecha_claveacceso = DateTime::createFromFormat('d/m/Y H:i', $fecha_venta)->format('dmY');
		$fecha_emision = DateTime::createFromFormat('d/m/Y H:i', $fecha_venta)->format('d/m/Y');
		if($correo==''){
			$correo='lideresentecnologia1997@gmail.com';
		}

		/***************************/
		/***************************/
		/*PARAMETROS DE FACTURACION*/
		/***************************/
		/***************************/
		
		
		$xml = new DOMDocument('1.0', 'UTF-8');
		$xml->formatOutput = true;

		//FORMATOS XML VERSIÓN 1.1.0 
		//PRIMERA PARTE ---------------------------------------------------------
		$xml_fac = $xml->createElement('factura');
			$cabecera = $xml->createAttribute('id');
			$cabecera->value = 'comprobante';
			$cabecerav = $xml->createAttribute('version');
			$cabecerav->value = '1.0.0';

		$xml_inf = $xml->createElement('infoTributaria');
			$xml_amb = $xml->createElement('ambiente',$ambiente);
			$xml_tip = $xml->createElement('tipoEmision',$tipoEmision);
			$xml_raz = $xml->createElement('razonSocial',$razon_social);
			$xml_nom = $xml->createElement('nombreComercial',$nombre_sucursal);
			$xml_ruc = $xml->createElement('ruc', $ruc);
			$dig = new modulo();
			$clave_acceso=$fecha_claveacceso.$tipoComprobante.$ruc.$ambiente.$numserie.$secuencial.$codigoNumerico.$tipoEmision;
			$clave_acceso=$clave_acceso.$dig->getMod11Dv($clave_acceso);
			$xml_cla = $xml->createElement('claveAcceso', $clave_acceso);
			$xml_doc = $xml->createElement('codDoc',$tipoComprobante);
			$xml_est = $xml->createElement('estab',$establecimiento);
			$xml_emi = $xml->createElement('ptoEmi',$puntoEmision);
			$xml_sec = $xml->createElement('secuencial',$secuencial);
			$xml_dir = $xml->createElement('dirMatriz', $direccion_empresa);

		//PRIMERA PARTE
			$xml_inf->appendChild($xml_amb);
			$xml_inf->appendChild($xml_tip);
			$xml_inf->appendChild($xml_raz);
			$xml_inf->appendChild($xml_nom);
			$xml_inf->appendChild($xml_ruc);
			$xml_inf->appendChild($xml_cla);
			$xml_inf->appendChild($xml_doc);
			$xml_inf->appendChild($xml_est);
			$xml_inf->appendChild($xml_emi);
			$xml_inf->appendChild($xml_sec);
			$xml_inf->appendChild($xml_dir);
			$xml_fac->appendChild($xml_inf);



		$tipoImpuestoIVA = '2';

		$codigoTarifaIva0 = '0';
		$codigoTarifaIva12 = '2';
		$codigoTarifaIva14 = '3';
		$codigoTarifaIva15 = '4';
		$codigoTarifaIva5 = '5';
		$codigoTarifaIvaNA = '6';
		$codigoTarifaIvaExento = '7';
		$codigoTarifaIvaDiferenciado = '8';
		$codigoTarifaIva13 = '10';

		$tipoMoneda = 'DOLAR';

		$valorPorcentajeIVA = ( (float)$valorTarifaIVA ) / 100;
		$porcentajeIVAMasUno = $valorPorcentajeIVA + 1;

		//SEGUNDA PARTE ---------------------------------------------------------
		$xml_def = $xml->createElement('infoFactura');
			$xml_fec = $xml->createElement('fechaEmision',$fecha_emision);
			$xml_des = $xml->createElement('dirEstablecimiento',$dirEstablecimiento);
			//$xml_con = $xml->createElement('contribuyenteEspecial','NO');
			$xml_obl = $xml->createElement('obligadoContabilidad',$obligadoContabilidad);
			$xml_ide = $xml->createElement('tipoIdentificacionComprador',$tipoIdentificacionComprador);
			$xml_rco = $xml->createElement('razonSocialComprador',$cliente_nombre);
			$xml_idc = $xml->createElement('identificacionComprador',$cliente_ruc);
			$xml_tsi = $xml->createElement('totalSinImpuestos',round((($sumas - ($descuento / $porcentajeIVAMasUno)) + $exento),2));
			$xml_tds = $xml->createElement('totalDescuento', round(($descuento / $porcentajeIVAMasUno),2));

		//SEGUNDA PARTE 2.2
		$xml_imp = $xml->createElement('totalConImpuestos');
		$xml_tim = $xml->createElement('totalImpuesto');
			$xml_tco = $xml->createElement('codigo',$tipoImpuestoIVA);
			$xml_cpr = $xml->createElement('codigoPorcentaje',$codigoTarifaIva15);
			$xml_bas = $xml->createElement('baseImponible',round(($sumas - ($descuento / $porcentajeIVAMasUno)),2));
			$xml_val = $xml->createElement('valor', round((($sumas - ($descuento / $porcentajeIVAMasUno)) * $valorPorcentajeIVA),2));

		//PARTE 2.3
		$xml_pro = $xml->createElement('propina', '0.00');
		$xml_imt = $xml->createElement('importeTotal', $total);
		$xml_mon = $xml->createElement('moneda',$tipoMoneda);


		//SEGUNDA PARTE
		$xml_def->appendChild($xml_fec);
		$xml_def->appendChild($xml_des);
		//$xml_def->appendChild($xml_con);
		$xml_def->appendChild($xml_obl);
		$xml_def->appendChild($xml_ide);
		$xml_def->appendChild($xml_rco);
		$xml_def->appendChild($xml_idc);
		$xml_def->appendChild($xml_tsi);
		$xml_def->appendChild($xml_tds);
		$xml_def->appendChild($xml_imp);
		$xml_imp->appendChild($xml_tim);
		$xml_tim->appendChild($xml_tco);
		$xml_tim->appendChild($xml_cpr);
		$xml_tim->appendChild($xml_bas);
		$xml_tim->appendChild($xml_val);
		$xml_fac->appendChild($xml_def);

		//SEGUNDA PARTE 2.3
		$xml_def->appendChild($xml_pro);
		$xml_def->appendChild($xml_imt);
		$xml_def->appendChild($xml_mon);



		$formaPago = '01';

		//PARTE PAGOS ---------------------------------------------------------
		$xml_pgs = $xml->createElement('pagos');
		$xml_pag = $xml->createElement('pago');
			$xml_fpa = $xml->createElement('formaPago',$formaPago);
			$xml_tot = $xml->createElement('total',$total);
			$xml_pla = $xml->createElement('plazo','1');
			$xml_uti = $xml->createElement('unidadTiempo','dias');
			

		$xml_def->appendChild($xml_pgs);
		$xml_pgs->appendChild($xml_pag);
		$xml_pag->appendChild($xml_fpa);
		$xml_pag->appendChild($xml_tot);
		$xml_pag->appendChild($xml_pla);
		$xml_pag->appendChild($xml_uti);



		//DETALLES ---------------------------------------------------------
		$xml_dts = $xml->createElement('detalles');
		$xml_fac->appendChild($xml_dts);  // 1.0

		while($row = $detalle->fetch(PDO::FETCH_ASSOC)) {
			$xml_det = $xml->createElement('detalle');
			$xml_cop = $xml->createElement('codigoPrincipal', $row['codigo']);
			$xml_dcr = $xml->createElement('descripcion', $row['descripcion']);
			$xml_can = $xml->createElement('cantidad', $row['cantidad']);
			$xml_pru = $xml->createElement('precioUnitario', round($row['precio_unidad'],2));
			$xml_dsc = $xml->createElement('descuento', $row['descuento']);
			$xml_tsm = $xml->createElement('precioTotalSinImpuesto', $row['sin_impuesto_total']);
	
			$xml_ips = $xml->createElement('impuestos');
			$xml_ipt = $xml->createElement('impuesto');
			$xml_cdg = $xml->createElement('codigo',$tipoImpuestoIVA);
			
			$codigoPorcentaje = $codigoTarifaIva15;
			$tarifa = $valorTarifaIVA;
			$baseImponible = $row['sin_impuesto_total'];
			$valor_iva = $row['iva'];

			if($row['producto_exento']=='1'){
				$codigoPorcentaje = $codigoTarifaIva0;
				$tarifa = '0.00';
				//$baseImponible = '0.00';
				$valor_iva = '0.00';
			}

			$xml_cpt = $xml->createElement('codigoPorcentaje', $codigoPorcentaje);
			$xml_trf = $xml->createElement('tarifa', $tarifa);
			$xml_bsi = $xml->createElement('baseImponible', $baseImponible);
			$xml_vlr = $xml->createElement('valor', $valor_iva);

			$xml_dts->appendChild($xml_det);
			$xml_det->appendChild($xml_cop);
			$xml_det->appendChild($xml_dcr);
			$xml_det->appendChild($xml_can);
			$xml_det->appendChild($xml_pru);
			$xml_det->appendChild($xml_dsc);
			$xml_det->appendChild($xml_tsm);
			$xml_det->appendChild($xml_ips);
			$xml_ips->appendChild($xml_ipt);
			$xml_ipt->appendChild($xml_cdg);
			$xml_ipt->appendChild($xml_cpt);
			$xml_ipt->appendChild($xml_trf);
			$xml_ipt->appendChild($xml_bsi);
			$xml_ipt->appendChild($xml_vlr);
		}



		//INFO ADICIONAL ---------------------------------------------------------
		$xml_ifa = $xml->createElement('infoAdicional');
			$xml_cp1 = $xml->createElement('campoAdicional',$correo);
			$atributo = $xml->createAttribute('nombre');
			$atributo->value = 'Email';

		$xml_fac->appendChild($xml_ifa);
		$xml_ifa->appendChild($xml_cp1);
		$xml_cp1->appendChild($atributo);
		
		$xml_fac->appendChild($cabecera);
		$xml_fac->appendChild($cabecerav);
		$xml->appendChild($xml_fac);

		//$xml->save("file.xml");
		//print_r ($xml->saveXML());

		$xml->save('../facturacionphp/comprobantes/no_firmados/'.$clave_acceso.'.xml');

		return $clave_acceso;

	}
}

?>