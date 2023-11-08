<?php 

	require_once('Conexion.php');

	class CajaModel extends Conexion
	{

		public static function Validar_Caja($idsucursal)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$query = "CALL sp_validar_caja(:idsucursal)";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idsucursal",$idsucursal);

				if($stmt->execute())
				{
					$count = $stmt->rowCount();
					if($count == 0){
						$data = "Cerrada";
 	   					echo json_encode($data);
					} else {
						$data = "Abierta";
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

		public static function Listar_Datos($idsucursal) 
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_view_datos_caja(:idsucursal);";
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
				
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}

		public static function Listar_Historico($date,$date2,$idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_historico_caja(:date,:date2,:idsucursal);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":date",$date);
				$stmt->bindParam(":date2",$date2);
				$stmt->bindParam(":idsucursal",$idsucursal);
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


		public static function Listar_Movimientos($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_view_movimientos_caja(:idsucursal);";
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
				
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}


		public static function Get_Movimientos($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_view_movimientos_caja(:idsucursal);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idsucursal",$idsucursal);
				$stmt->execute();
				$count = $stmt->rowCount();
				$Data = array();
				if($count > 0)
				{
					while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		  				$Data[] = $row;
					}
					echo json_encode($Data);
				}

				
				$dbconec = null;
			} catch (Exception $e) {
				//echo $e;
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}

		public static function Listar_Ingresos($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_view_ingresos_caja(:idsucursal);";
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
				
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}

		public static function Listar_Devoluciones($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_view_devoluciones_caja(:idsucursal);";
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
				
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}


		public static function Listar_Prestamos($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_view_prestamos_caja(:idsucursal);";
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
				
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}

		public static function Listar_Gastos($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try 
			{
				$query = "CALL sp_view_gastos_caja(:idsucursal);";
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
				
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}


		public static function Abrir_Caja($monto, $idsucursal)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$query = "CALL sp_abrir_caja(:monto,:idsucursal)";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":monto",$monto);
				$stmt->bindParam(":idsucursal",$idsucursal);
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


		public static function Update_Caja($monto, $idsucursal)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$query = "CALL sp_update_monto_inicial(:monto,:idsucursal)";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":monto",$monto);
				$stmt->bindParam(":idsucursal",$idsucursal);	
				if($stmt->execute()){

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

		public static function Cerrar_Caja($monto, $idsucursal)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$query = "CALL sp_cerrar_caja(:monto,:idsucursal)";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":monto",$monto);
				$stmt->bindParam(":idsucursal",$idsucursal);	
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

		public static function Cerrar_Caja_Manual($id)
		{
			$dbconec = Conexion::Conectar();
			try 
			{
				$query = "CALL sp_cerrar_caja_manual(:id)";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":id",$id);

				if($stmt->execute())
				{
					$response['status']  = 'success';
					$response['message'] = 'Caja cerrada Correctamente!';
				} else {

					$response['status']  = 'error';
					$response['message'] = 'No pudimos cerrar la caja!';
				}
				echo json_encode($response);
				$dbconec = null;
			} catch (Exception $e) {
				$data = "Error";
				echo json_encode($data);
				
			}
		}

			public static function Insertar_Movimiento($tipo_movimiento,$monto,$descripcion,$idsucursal)
			{
				$dbconec = Conexion::Conectar();
				try 
				{
					$query = "CALL sp_insert_caja_movimiento(:tipo_movimiento,:monto,:descripcion,:idsucursal)";
					$stmt = $dbconec->prepare($query);
					$stmt->bindParam(":tipo_movimiento",$tipo_movimiento);
					$stmt->bindParam(":monto",$monto);
					$stmt->bindParam(":descripcion",$descripcion);
					$stmt->bindParam(":idsucursal",$idsucursal);	

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

			public static function Insertar_Caja_Venta($monto)
			{
				$dbconec = Conexion::Conectar();
				try 
				{
					$query = "CALL sp_insert_caja_venta(:monto)";
					$stmt = $dbconec->prepare($query);
					$stmt->bindParam(":monto",$monto);

					$stmt->execute();
					
					$dbconec = null;

				} catch (Exception $e) {
					//$data = "Error";
					//echo json_encode($data);
					echo $e;
				}

			}


	}


 ?>