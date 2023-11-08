<?php 

	require_once('Conexion.php');

	class UsuarioModel extends Conexion
	{
		public static function Listar_Usuarios()
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_view_usuario();";
				$stmt = $dbconec->prepare($query);
				$stmt->execute();
				$count = $stmt->rowCount();

				if($count > 0)
				{
					return $stmt->fetchAll();
				}
				
				$dbconec = null;
			} catch (Exception $e) {
				
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}

		public static function Listar_Empleados()
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_view_empleado_activo();";
				$stmt = $dbconec->prepare($query);
				$stmt->execute();
				$count = $stmt->rowCount();

				if($count > 0)
				{
					return $stmt->fetchAll();
				}

				
				$dbconec = null;
			} catch (Exception $e) {
				
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}


		public static function Insertar_Usuario($usuario, $contrasena, $tipo_usuario, $idempleado)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				//y ahora cifro la clave usando un hash
				$contrasena1 = password_hash($contrasena, PASSWORD_DEFAULT, array("cost"=>10));
				$query = "CALL sp_insert_usuario(:usuario, :contrasena, :tipo_usuario, :idempleado)";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":usuario",$usuario);
				$stmt->bindParam(":contrasena",$contrasena1);
				$stmt->bindParam(":tipo_usuario",$tipo_usuario);
				$stmt->bindParam(":idempleado",$idempleado);

				if($stmt->execute())
				{
					$count = $stmt->rowCount();
					if($count == 0){
						$data = "Duplicado";
 	   					echo json_encode($data);
					} else {
						$data = "Validado";
 	   					echo json_encode($data);
					}
				} else {

					$data = "Error";
 	   		 	 	echo json_encode($data);
				}
				$dbconec = null;
			} catch (Exception $e) {
				$data = "Error";
				echo json_encode($data);
				
			}

		}

		public static function Consulta_asistencia($idempleado, $fecha)
		{	
			$dbconec = Conexion::Conectar();
			try 
			{	
				$query = "CALL sp_consulta_asistencia(:idempleado, :fecha);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idempleado",$idempleado);
				$stmt->bindParam(":fecha",$fecha);
				$stmt->execute();
				$count = $stmt->rowCount();
				if($count > 0)
				{
					if($recResult = $stmt->fetch(PDO::FETCH_ASSOC)){
						return $recResult["tipo_asistencia"];
					}
				}		
				$dbconec = null;		
			} catch (Exception $e) {
				
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}

		public static function Editar_Usuario($idusuario, $usuario, $contrasena, $tipo_usuario, $estado, $idempleado)
		{
			

			$dbconec = Conexion::Conectar();
			try 
			{
				//y ahora cifro la clave usando un hash
				$contrasena1 = password_hash($contrasena, PASSWORD_DEFAULT, array("cost"=>10));
				if(strlen($contrasena) <= 3){$contrasena1='';}
				$query = "CALL sp_update_usuario(:idusuario, :usuario, :contrasena, :tipo_usuario, :estado, :idempleado);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idusuario",$idusuario);
				$stmt->bindParam(":usuario",$usuario);
				$stmt->bindParam(":contrasena",$contrasena1);
				$stmt->bindParam(":tipo_usuario",$tipo_usuario);
				$stmt->bindParam(":estado",$estado);
				$stmt->bindParam(":idempleado",$idempleado);


				if($stmt->execute())
				{

				  $data = "Validado";
   				  echo json_encode($data);
				
				} else {

					$data = "Error";
 	   		 	 	echo json_encode($data);
				}
				$dbconec = null;
			} catch (Exception $e) {
				$data = "Error";
				echo json_encode($data);
			
			}

		}

		public static function Registro_asistencia($idempleado, $fecha, $tipo_asistencia)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$query = "CALL sp_registro_asistencia(:idempleado, :fecha, :tipo_asistencia);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idempleado",$idempleado);
				$stmt->bindParam(":fecha",$fecha);
				$stmt->bindParam(":tipo_asistencia",$tipo_asistencia);

				if($stmt->execute())
				{
				  	$data = "Registrado";
   				  	echo json_encode($data);
				} else {
					$data = "Error";
 	   		 	 	echo json_encode($data);
				}
				$dbconec = null;
			} catch (Exception $e) {
				$data = "Error";
				echo json_encode($data);
			}
		}

		public static function Update_asistencia($idempleado, $fecha, $tipo_asistencia)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$query = "CALL sp_update_asistencia(:idempleado, :fecha, :tipo_asistencia);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idempleado",$idempleado);
				$stmt->bindParam(":fecha",$fecha);
				$stmt->bindParam(":tipo_asistencia",$tipo_asistencia);

				if($stmt->execute())
				{
				  $data = "Actualizado";
   				  echo json_encode($data);
				} else {
					$data = "Error";
 	   		 	 	echo json_encode($data);
				}
				$dbconec = null;
			} catch (Exception $e) {
				$data = "Error";
				echo json_encode($data);
			}
		}

		public static function Delete_asistencia($idempleado, $fecha)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$query = "CALL sp_delete_asistencia(:idempleado, :fecha);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idempleado",$idempleado);
				$stmt->bindParam(":fecha",$fecha);

				if($stmt->execute())
				{
				  $data = "Eliminado";
   				  echo json_encode($data);
				
				} else {
					$data = "Error";
 	   		 	 	echo json_encode($data);
				}
				$dbconec = null;
			} catch (Exception $e) {
				$data = "Error";
				echo json_encode($data);
			}
		}

	}


 ?>