<?php

	require_once('Conexion.php');

	class DashboardModel extends Conexion
	{

		public static function Ver_Moneda_Reporte(){

			$dbconec = Conexion::Conectar();

			try {
				$query = "CALL sp_view_money()";
				$stmt = $dbconec->prepare($query);
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
		
		public static function Datos_Paneles($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_panel_dashboard(:idsucursal);";
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

		public static function Compras_Anuales($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_compras_anual(:idsucursal);";
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
				//echo $e;
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}

		public static function Ventas_Anuales($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_ventas_anual(:idsucursal);";
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
				//echo $e;
				echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}


	}

?>
