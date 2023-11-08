<?php

	class Sucursal {
		
		public static function Listar_Sucursal(){
			$filas = SucursalModel::Listar_Sucursal();
			return $filas;

		}

		public static function Insertar_Sucursal($nombre, $direccion, $telefono){
			
			$cmd = SucursalModel::Insertar_Sucursal($nombre, $direccion, $telefono);

		}

		public static function Editar_Sucursal($idsucursal, $nombre, $direccion, $telefono){

			$cmd = SucursalModel::Editar_Sucursal($idsucursal, $nombre, $direccion, $telefono);

		}

	}


 ?>
