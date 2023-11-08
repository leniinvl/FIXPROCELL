<?php

	class Dashboard {

		public static function Ver_Moneda_Reporte(){

			$filas = DashboardModel::Ver_Moneda_Reporte();
			return $filas;

		}


		public static function Datos_Paneles($idsucursal){

			$filas = DashboardModel::Datos_Paneles($idsucursal);
			return $filas;

		}

		public static function Compras_Anuales($idsucursal){

			$filas = DashboardModel::Compras_Anuales($idsucursal);
			return $filas;

		}

		public static function Ventas_Anuales($idsucursal){

			$filas = DashboardModel::Ventas_Anuales($idsucursal);
			return $filas;

		}

	}


?>
