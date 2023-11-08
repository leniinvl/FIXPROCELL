<?php 

	class Usuario {

		public static function Listar_Usuarios(){

			$filas = UsuarioModel::Listar_Usuarios();
			return $filas;
		
		}

		public static function Listar_Empleados(){

			$filas = UsuarioModel::Listar_Empleados();
			return $filas;
		
		}

		public static function Insertar_Usuario($usuario, $contrasena, $tipo_usuario, $idempleado){

			$cmd = UsuarioModel::Insertar_Usuario($usuario, $contrasena, $tipo_usuario, $idempleado);
			
		}

		public static function Editar_Usuario($idusuario, $usuario, $contrasena, $tipo_usuario, $estado, $idempleado){

			$cmd = UsuarioModel::Editar_Usuario($idusuario, $usuario, $contrasena, $tipo_usuario, $estado, $idempleado);
			
		}

		public static function Consulta_asistencia($idempleado, $fecha){

			$cmd = UsuarioModel::Consulta_asistencia($idempleado, $fecha);
			return $cmd;
			
		}

		public static function Registro_asistencia($idempleado, $fecha, $tipo_asistencia){

			$cmd = UsuarioModel::Registro_asistencia($idempleado, $fecha, $tipo_asistencia);
			
		}

		public static function Update_asistencia($idempleado, $fecha, $tipo_asistencia){

			$cmd = UsuarioModel::Update_asistencia($idempleado, $fecha, $tipo_asistencia);
			
		}

		public static function Delete_asistencia($idempleado, $fecha){

			$cmd = UsuarioModel::Delete_asistencia($idempleado, $fecha);
			
		}

	}


 ?>