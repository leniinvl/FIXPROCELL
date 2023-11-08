<?php 
	 
	class Login
	
	{ 

		public static function Restaurar_Password($usuario,$contrasena){

			$cmd = LoginModel::Restaurar_Password($usuario,$contrasena);
			
		}

		public static function Login_Usuario($usuario,$contrasena,$nombre){

			$cmd = LoginModel::Login_Usuario($usuario,$contrasena,$nombre);
			
		}

		
	}
		
 ?>