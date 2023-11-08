<?php 

	require_once('Conexion.php');

	class ColorModel extends Conexion
	{
		public static function Listar_Colores()
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_view_color();";
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

		public static function Insertar_Color($nombre_color)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$query = "CALL sp_insert_color(:nombre_color)";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":nombre_color",$nombre_color);

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

		public static function Editar_Color($idcolor,$nombre_color)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$query = "CALL sp_update_color(:idcolor,:nombre_color);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idcolor",$idcolor);
				$stmt->bindParam(":nombre_color",$nombre_color);


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

	}


 ?>