<?php 

	class Caja {

		public static function Validar_Caja($idsucursal){

			$cmd = CajaModel::Validar_Caja($idsucursal);
			
		}

		public static function Listar_Datos($idsucursal){

			$filas = CajaModel::Listar_Datos($idsucursal);
			return $filas;
		
		}

		public static function Listar_Historico($date,$date2,$idsucursal){

			$filas = CajaModel::Listar_Historico($date,$date2,$idsucursal);
			return $filas;
		
		}

		public static function Cerrar_Caja_Manual($id){

			$filas = CajaModel::Cerrar_Caja_Manual($id);
			return $filas;
		
		}

		public static function Listar_Movimientos($idsucursal){

			$filas = CajaModel::Listar_Movimientos($idsucursal);
			return $filas;
		
		}

		public static function Get_Movimientos($idsucursal){

			$filas = CajaModel::Get_Movimientos($idsucursal);
			return $filas;
		
		}

		public static function Listar_Ingresos($idsucursal){

			$filas = CajaModel::Listar_Ingresos($idsucursal);
			return $filas;
		
		}

		public static function Listar_Devoluciones($idsucursal){

			$filas = CajaModel::Listar_Devoluciones($idsucursal);
			return $filas;
		
		}

		public static function Listar_Prestamos($idsucursal){

			$filas = CajaModel::Listar_Prestamos($idsucursal);
			return $filas;
		
		}

		public static function Listar_Gastos($idsucursal){

			$filas = CajaModel::Listar_Gastos($idsucursal);
			return $filas;
		
		}

		public static function Insertar_Movimiento($tipo_movimiento,$monto,$descripcion,$idsucursal){

			$cmd = CajaModel::Insertar_Movimiento($tipo_movimiento,$monto,$descripcion,$idsucursal);
			
		}

		public static function Abrir_Caja($monto, $idsucursal){

			$cmd = CajaModel::Abrir_Caja($monto, $idsucursal);
			
		}

		public static function Update_Caja($monto, $idsucursal){

			$cmd = CajaModel::Update_Caja($monto, $idsucursal);
			
		}

		public static function Cerrar_Caja($monto, $idsucursal){

			$cmd = CajaModel::Cerrar_Caja($monto, $idsucursal);
			
		}

		public static function Insertar_Caja_Venta($monto){

			$cmd = CajaModel::Insertar_Caja_Venta($monto);
			
		}
	}


 ?>