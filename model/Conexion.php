<?php

	class Conexion {

		public static function Conectar(){


			$driver = 'mysql'; //mysql 
			$host = 'localhost'; //localhost
			$dbname = 'datacell'; //bdd
			$username ='root'; //usuario
			$passwd = ''; //contra

			//BDD   : lideres1_db_datacell - lideres1_db_datacell_dev
			//Server: lideres1_lideres1 - lideres1_password  
			//Local : root - ''

			$server=$driver.':host='.$host.';dbname='.$dbname;

			try {

				$conexion = new PDO($server,$username,$passwd);
				//$conexion = exec("SET CHARACTER SET utf8");
				$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} catch (Exception $e) {

				$conexion = null;
            	echo '<span class="label label-danger label-block">ERROR AL CONECTARSE A LA BASE DE DATOS, PRESIONE F5</span>';
            	exit();
			}


			return $conexion;

		}

	}
