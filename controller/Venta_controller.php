<?php

	
	class Venta {

		public static function Ver_Moneda_Reporte(){

			$filas = VentaModel::Ver_Moneda_Reporte();
			return $filas;

		}

		public static function Listar_Ventas($criterio,$date,$date2,$estado,$idsucursal){

			$filas = VentaModel::Listar_Ventas($criterio,$date,$date2,$estado,$idsucursal);
			return $filas;

		}

		public static function Listar_Ventas_Productos($idproducto){

			$filas = VentaModel::Listar_Ventas_Productos($idproducto);
			return $filas;

		}

		public static function Listar_Facturas($criterio,$date,$date2,$estado,$idsucursal){

			$filas = VentaModel::Listar_Facturas($criterio,$date,$date2,$estado,$idsucursal);
			return $filas;

		}

		public static function Listar_Ventas_Totales($criterio,$date,$date2,$estado,$idsucursal){

			$filas = VentaModel::Listar_Ventas_Totales($criterio,$date,$date2,$estado,$idsucursal);
			return $filas;

		}

		public static function Listar_Ventas_Detalle($criterio,$date,$date2,$estado,$idsucursal){

			$filas = VentaModel::Listar_Ventas_Detalle($criterio,$date,$date2,$estado,$idsucursal);
			return $filas;

		}

		public static function Imprimir_Ticket_DetalleVenta($idVenta){

			$filas = VentaModel::Imprimir_Ticket_DetalleVenta($idVenta); 
			return $filas;

		}

		public static function Imprimir_Ticket_Venta($idVenta){

			$filas = VentaModel::Imprimir_Ticket_Venta($idVenta);
			return $filas;

		}

		/* FACTURACION */

		public static function Obtener_idventa_facturar($idcliente){

			$filas = VentaModel::Obtener_idventa_facturar($idcliente);
			return $filas;

		}
		
		public static function Obtener_datos_venta_facturar($idventa){

			$filas = VentaModel::Obtener_datos_venta_facturar($idventa);
			return $filas;

		}

		public static function actualizar_respuesta_factura($p_respuesta, $p_idventa){

			$cmd = VentaModel::actualizar_respuesta_factura($p_respuesta, $p_idventa);
	
		}

		public static function actualizar_clave_venta($p_claveacceso, $p_idventa){

			$cmd = VentaModel::actualizar_clave_venta($p_claveacceso, $p_idventa);
	
		}


		/* FACTURACION */

		public static function Imprimir_Corte_Z_Dia($date, $tipoComprobante, $idsucursal){

			$filas = VentaModel::Imprimir_Corte_Z_Dia($date, $tipoComprobante, $idsucursal);
			return $filas;

		}


		public static function Imprimir_Corte_Z_Mes($date, $tipoComprobante, $idsucursal){

			$filas = VentaModel::Imprimir_Corte_Z_Mes($date, $tipoComprobante, $idsucursal);
			return $filas;

		}


		public static function Listar_Detalle($idVenta){

			$filas = VentaModel::Listar_Detalle($idVenta);
			return $filas;

		}

		public static function Listar_Info($idVenta){

			$filas = VentaModel::Listar_Info($idVenta);
			return $filas;

		}

		public static function Count_Ventas($criterio,$date,$date2,$idsucursal){

			$filas = VentaModel::Count_Ventas($criterio,$date,$date2,$idsucursal);
			return $filas;

		}

		public static function Count_Facturas($criterio,$date,$date2,$idsucursal){

			$filas = VentaModel::Count_Facturas($criterio,$date,$date2,$idsucursal);
			return $filas;

		}

		public static function Listar_Clientes(){

			$filas = VentaModel::Listar_Clientes();
			return $filas;
 
		}

		public static function Listar_Comprobantes($idsucursal){

			$filas = VentaModel::Listar_Comprobantes($idsucursal);
			return $filas;

		}


		public static function Listar_Empresas(){

			$filas = VentaModel::Listar_Empresas();
			return $filas;

		}

		public static function Autocomplete_Producto($search, $idsucursal){
 
			$filas = VentaModel::Autocomplete_Producto($search, $idsucursal); 
			return $filas;

		}

		public static function Insertar_Venta($tipo_pago, $tipo_comprobante,
		$sumas, $iva, $exento, $retenido, $descuento, $total, $sonletras, $pago_efectivo, $pago_tarjeta, $numero_tarjeta, $tarjeta_habiente,
		$cambio, $estado, $idcliente, $idusuario, $idsucursal,$descripcion){

		$cmd = VentaModel::Insertar_Venta($tipo_pago, $tipo_comprobante,
		$sumas, $iva, $exento, $retenido, $descuento, $total, $sonletras, $pago_efectivo, $pago_tarjeta, $numero_tarjeta, $tarjeta_habiente,
		$cambio, $estado, $idcliente, $idusuario, $idsucursal,$descripcion);

		}

		public static function Insertar_DetalleVenta($idproducto, $cantidad, $precio_unitario, $exento, $descuento, $fecha_vence, $importe){

		$cmd = VentaModel::Insertar_DetalleVenta($idproducto, $cantidad, $precio_unitario, $exento, $descuento, $fecha_vence, $importe);

		}

		public static function Anular_Venta($idventa){

		$cmd = VentaModel::Anular_Venta($idventa);

		}


		public static function Fechas_Vencimiento($idproducto){

			$filas = VentaModel::Fechas_Vencimiento($idproducto);
			return $filas;

		}

		public static function Finalizar_Venta($idventa){

			$cmd = VentaModel::Finalizar_Venta($idventa);

		}

		public static function actualizar_venta($p_sucursal_venta, $p_sucursal_prod){

			$cmd = VentaModel::actualizar_venta($p_sucursal_venta, $p_sucursal_prod);
	
		}

		public static function precio_producto($idproducto, $tipoprecio){

			$cmd = VentaModel::precio_producto($idproducto, $tipoprecio);
	
		}

	}

 ?>