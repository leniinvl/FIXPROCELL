<?php 

	session_set_cookie_params(60*60*24*365); session_start();
	require_once('Conexion.php');

	class LoginModel extends Conexion
	{

		public static function Restaurar_Password($usuario,$contrasena)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$contrasena1 = password_hash($contrasena, PASSWORD_DEFAULT, array("cost"=>10));
				$query = "CALL sp_reset_password_usuario(:usuario,:contrasena)";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":usuario",$usuario);
				$stmt->bindParam(":contrasena",$contrasena1);

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

		
		public static function Login_Usuario($usuario,$contrasena,$nombre)
		{
			$dbconec = Conexion::Conectar(); 
			try 
			{

				$query = "SELECT * FROM usuario where usuario = :usuario";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":usuario",$usuario);

				if($stmt->execute()) 
				{
					$row = $stmt->fetch(PDO::FETCH_ASSOC);

					/*if($row['contrasena'] == $contrasena){*/
					if ($row && password_verify($contrasena, $row['contrasena'])){
						$stmt2 = $dbconec->prepare("SELECT * FROM empleado WHERE idempleado = ?");
						$stmt2->execute([$row['idempleado']]);
						$user = $stmt2->fetch();

						$stmt3 = $dbconec->prepare("SELECT * FROM sucursal WHERE idsucursal = :idsucursal");
						$stmt3->bindParam(":idsucursal",$nombre);
						$stmt3->execute();
						$sucur = $stmt3->fetch();

						/* Iniciamos variables de sesion */
						$_SESSION['user_id'] = $row['idusuario'];
						$_SESSION['user_name'] = $row['usuario'];
						$_SESSION['user_tipo'] = $row['tipo_usuario'];
						if ($row['tipo_usuario'] == 1) {
							$_SESSION['user_cargo']="ADMINISTRADOR";
						}else {
							$_SESSION['user_cargo']="VENDEDOR/A"; 
						}
						if ($row['estado'] == 0) {
							$data = "Inactive";
						}else{
							$data = "Validado";
						}
						$_SESSION['user_empleado'] = $user['nombre_empleado']." ".$user['apellido_empleado'];
						$_SESSION['sucursal_name'] = $sucur['nombre'];
						$_SESSION['sucursal_id'] = $nombre;

					   echo json_encode($data);

					} else {

						$data = "Bad Pass";
						echo json_encode($data);

					}

				}

			}  catch (Exception $e) {

				$data = "Error";
				echo json_encode($data);
			
			}
						
		}

}

?>