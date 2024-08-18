<?php

	require_once('Conexion.php');

	class SucursalModel extends Conexion
	{
		public static function Listar_Sucursal()
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_sucursal();";
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
		
		public static function Consultar_Sucursal($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_consulta_sucursal(:idsucursal);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idsucursal",$idsucursal);
				$stmt->execute();
				$count = $stmt->rowCount();

				if($count > 0)
				{
					return $stmt->fetchAll();
				} 

				$dbconec = null;
			} catch (Exception $e) {
				echo "Error al cargar el listado";
			}
			
		}
			
		public static function Insertar_Sucursal($nombre, $direccion, $telefono)
		{
			$dbconec = Conexion::Conectar();
			try
			{
				$query = "CALL sp_insert_sucursal(:nombre,:direccion,:telefono);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":nombre",$nombre);
				$stmt->bindParam(":direccion",$direccion);
				$stmt->bindParam(":telefono",$telefono);

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

		public static function Editar_Sucursal($idsucursal, $nombre, $direccion, $telefono)
		{
			$dbconec = Conexion::Conectar();
			try
			{
				$query = "CALL sp_update_sucursal(:idsucursal,:nombre,:direccion,:telefono);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idsucursal",$idsucursal);
				$stmt->bindParam(":nombre",$nombre);
				$stmt->bindParam(":direccion",$direccion);
				$stmt->bindParam(":telefono",$telefono);

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

	}


 ?>
