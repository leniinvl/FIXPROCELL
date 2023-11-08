<?php 

	class Color {

		public static function Listar_Colores(){

			$filas = ColorModel::Listar_Colores();
			return $filas;
		
		}

		public static function Insertar_Color($nombre_color){

			$cmd = ColorModel::Insertar_Color($nombre_color);
			
		}

		public static function Editar_Color($idcolor,$nombre_color){

			$cmd = ColorModel::Editar_Color($idcolor,$nombre_color);
			
		}

	}


 ?>