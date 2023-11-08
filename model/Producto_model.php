<?php

	require_once('Conexion.php');

	class ProductoModel extends Conexion
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
		
		public static function Print_Barcode($idproducto)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_print_barcode_producto(:idproducto);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idproducto",$idproducto);
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

		public static function Listar_Productos($idsucursal)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_producto(:idsucursal);";
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

		public static function Listar_Productos_Filtros($idsucursal, $idcategoria)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_producto_filtro(:idsucursal,:idcategoria);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idsucursal",$idsucursal);
				$stmt->bindParam(":idcategoria",$idcategoria);
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

		public static function Listar_Productos_Activos($idsucursal, $idcategoria)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_producto_activo(:idsucursal,:idcategoria);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idsucursal",$idsucursal);
				$stmt->bindParam(":idcategoria",$idcategoria);
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

		public static function Listar_Productos_Inactivos($idsucursal, $idcategoria)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_producto_inactivo(:idsucursal, :idcategoria);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idsucursal",$idsucursal);
				$stmt->bindParam(":idcategoria",$idcategoria);
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

		public static function Listar_Productos_Agotados($idsucursal, $idcategoria)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_producto_agotado(:idsucursal, :idcategoria);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idsucursal",$idsucursal);
				$stmt->bindParam(":idcategoria",$idcategoria);
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


		public static function Listar_Productos_Vigentes($idsucursal, $idcategoria)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_producto_vigente(:idsucursal, :idcategoria);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idsucursal",$idsucursal);
				$stmt->bindParam(":idcategoria",$idcategoria);
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

		public static function Listar_Perecederos()
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_producto_perecedero();";
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


		public static function Listar_No_Perecederos()
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_producto_no_perecedero();";
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

		public static function Listar_Proveedores()
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_proveedor_activo();";
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

		public static function Listar_Categorias()
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_categoria_activa();";
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

		public static function Listar_Marcas()
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_marca_activa();";
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

		public static function Listar_Presentaciones()
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_presentacion_activa();";
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

		 public static function Autocomplete_Producto($search, $idsucursal){

			try {

			$sugg_json = array();    // this is for displaying json data as a autosearch suggestion
			$json_row = array();     // this is for stroring mysql results in json string

			$keyword = preg_replace('/\s+/', ' ', $search); // it will replace multiple spaces from the input.

			$query = "CALL sp_search_producto(:search, :idsucursal)";
			$stmt = Conexion::Conectar()->prepare($query);
			$stmt->bindParam(":search", $keyword);
			$stmt->bindParam(":idsucursal", $idsucursal);
			$stmt->execute();

			if ($stmt->rowCount() > 0){

			while($recResult = $stmt->fetch(PDO::FETCH_ASSOC)) {

				$json_row["value"] = $recResult['idproducto'];
				$json_row["label"] = $recResult['codigo_barra'].' '.$recResult['nombre_producto'].' - '.$recResult['nombre_color']; 
				$json_row["producto"] = $recResult['nombre_producto'];
				$json_row["precio_compra"] = $recResult['precio_compra'];
				$json_row["exento"] = $recResult['exento'];
				$json_row["perecedero"] = $recResult['perecedero'];
				$json_row["datos"] = $recResult['nombre_marca'].' - '.$recResult['siglas'];

				array_push($sugg_json, $json_row);
			}

			} else {

				$json_row["value"] = "";
				$json_row["label"] = "";
				$json_row["datos"] = "";
				array_push($sugg_json, $json_row);
			}


			 $jsonOutput = json_encode($sugg_json, JSON_UNESCAPED_SLASHES);
 			 print $jsonOutput;


			} catch (Exception $e) {

				echo "Error al cargar el listado";
			}

		  }

		  public static function Eliminar_Producto($idproducto)
		  {
			$dbconec = Conexion::Conectar();
			try
			{
				$query = "CALL sp_delete_producto(:idproducto);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idproducto",$idproducto);

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
				//echo $e;
				$data = "Error";
				echo json_encode($data);
			}

		}  

		public static function Insertar_Producto($codigo_barra,$nombre_producto,$precio_compra,$precio_venta,
		$precio_venta_mayoreo,$precio_super_mayoreo,$stock,$stock_min,$idcategoria,$idmarca,$idpresentacion,$exento,$inventariable,$perecedero,$idsucursal,$idcolor,$precio_venta_minimo)
		{
			$dbconec = Conexion::Conectar();
			$dbconec2 = Conexion::Conectar();
			try
			{
				if($idsucursal <> 3){

					$stock_0 = 0;
					$stock_min_1 = 1;
					$query1 = "CALL sp_view_sucursal()";
					$stmt1 = $dbconec->prepare($query1);
					$stmt1->execute();

					if ($stmt1->rowCount() > 0){
						while($recResult = $stmt1->fetch(PDO::FETCH_ASSOC)){
							$Data = $recResult['idsucursal'];
							if ($Data<>3) {
								if ($Data==$idsucursal) {

									$query = "CALL sp_insert_producto(:codigo_barra,:nombre_producto,:precio_compra,:precio_venta,
									:precio_venta_mayoreo,:stock,:stock_min,:idcategoria,:idmarca,:idpresentacion,:exento,:inventariable,:perecedero,:idsucursal,:idcolor,:precio_super_mayoreo,:precio_venta_minimo)";
									$stmt = $dbconec2->prepare($query);
									$stmt->bindParam(":codigo_barra",$codigo_barra);
									$stmt->bindParam(":nombre_producto",$nombre_producto);
									$stmt->bindParam(":precio_compra",$precio_compra);
									$stmt->bindParam(":precio_venta",$precio_venta);
									$stmt->bindParam(":precio_venta_mayoreo",$precio_venta_mayoreo);
									$stmt->bindParam(":stock",$stock);
									$stmt->bindParam(":stock_min",$stock_min);
									$stmt->bindParam(":idcategoria",$idcategoria);
									$stmt->bindParam(":idmarca",$idmarca);
									$stmt->bindParam(":idpresentacion",$idpresentacion);
									$stmt->bindParam(":exento",$exento);
									$stmt->bindParam(":inventariable",$inventariable);
									$stmt->bindParam(":perecedero",$perecedero);
									$stmt->bindParam(":idsucursal",$Data);
									$stmt->bindParam(":idcolor",$idcolor);
									$stmt->bindParam(":precio_super_mayoreo",$precio_super_mayoreo);
									$stmt->bindParam(":precio_venta_minimo",$precio_venta_minimo);

									if($stmt->execute()){
										$count = $stmt->rowCount();
										if($count == 0){
											$data = "Duplicado";
										} else {
											$data = "Validado";
										}
									} else {
										$data = "Error";
									}

								}else{
								
									$dbconec2 = Conexion::Conectar();
									$query = "CALL sp_insert_producto(:codigo_barra,:nombre_producto,:precio_compra,:precio_venta,
									:precio_venta_mayoreo,:stock,:stock_min,:idcategoria,:idmarca,:idpresentacion,:exento,:inventariable,:perecedero,:idsucursal,:idcolor,:precio_super_mayoreo,:precio_venta_minimo)";
									$stmt = $dbconec2->prepare($query);
									$stmt->bindParam(":codigo_barra",$codigo_barra);
									$stmt->bindParam(":nombre_producto",$nombre_producto);
									$stmt->bindParam(":precio_compra",$precio_compra);
									$stmt->bindParam(":precio_venta",$precio_venta);
									$stmt->bindParam(":precio_venta_mayoreo",$precio_venta_mayoreo);
									$stmt->bindParam(":stock",$stock_0);
									$stmt->bindParam(":stock_min",$stock_min);
									$stmt->bindParam(":idcategoria",$idcategoria);
									$stmt->bindParam(":idmarca",$idmarca);
									$stmt->bindParam(":idpresentacion",$idpresentacion);
									$stmt->bindParam(":exento",$exento);
									$stmt->bindParam(":inventariable",$inventariable);
									$stmt->bindParam(":perecedero",$perecedero);
									$stmt->bindParam(":idsucursal",$Data);
									$stmt->bindParam(":idcolor",$idcolor);
									$stmt->bindParam(":precio_super_mayoreo",$precio_super_mayoreo);
									$stmt->bindParam(":precio_venta_minimo",$precio_venta_minimo);

									if($stmt->execute()){
										$count = $stmt->rowCount();
										if($count == 0){
											$data = "Duplicado";
										} else {
											$data = "Validado";
										}
									} else {
										$data = "Error";
									}

								}
							}
						} 
					}

				}else{

					$query = "CALL sp_insert_producto(:codigo_barra,:nombre_producto,:precio_compra,:precio_venta,
					:precio_venta_mayoreo,:stock,:stock_min,:idcategoria,:idmarca,:idpresentacion,:exento,:inventariable,:perecedero,:idsucursal,:idcolor,:precio_super_mayoreo,:precio_venta_minimo)";
					$stmt = $dbconec2->prepare($query);
					$stmt->bindParam(":codigo_barra",$codigo_barra);
					$stmt->bindParam(":nombre_producto",$nombre_producto);
					$stmt->bindParam(":precio_compra",$precio_compra);
					$stmt->bindParam(":precio_venta",$precio_venta);
					$stmt->bindParam(":precio_venta_mayoreo",$precio_venta_mayoreo);
					$stmt->bindParam(":stock",$stock);
					$stmt->bindParam(":stock_min",$stock_min);
					$stmt->bindParam(":idcategoria",$idcategoria);
					$stmt->bindParam(":idmarca",$idmarca);
					$stmt->bindParam(":idpresentacion",$idpresentacion);
					$stmt->bindParam(":exento",$exento);
					$stmt->bindParam(":inventariable",$inventariable);
					$stmt->bindParam(":perecedero",$perecedero);
					$stmt->bindParam(":idsucursal",$idsucursal);
					$stmt->bindParam(":idcolor",$idcolor);
					$stmt->bindParam(":precio_super_mayoreo",$precio_super_mayoreo);
					$stmt->bindParam(":precio_venta_minimo",$precio_venta_minimo);

					if($stmt->execute()){
						$count = $stmt->rowCount();
						if($count == 0){
							$data = "Duplicado";
						} else {
							$data = "Validado";
						}
					} else {
						$data = "Error";
					}

				}

				echo json_encode($data);
				$dbconec = null;
				$dbconec2 = null;
			} catch (Exception $e) {
				//echo $e;
				$data = "Error";
				echo json_encode($data);

			}

		}

		public static function Editar_Producto($idproducto, $codigo_barra,$nombre_producto,$precio_compra,$precio_venta,$precio_venta_mayoreo,$precio_super_mayoreo,$stock,$stock_min,
		$idcategoria,$idmarca,$idpresentacion,$estado,$exento,$inventariable,$perecedero,$idsucursal,$idcolor,$precio_venta_minimo)
		{
			$dbconec = Conexion::Conectar();
			try
			{
				$query = "CALL sp_update_producto(:idproducto,:codigo_barra,:nombre_producto,:precio_compra,:precio_venta,:precio_venta_mayoreo,:stock_min,
				:idcategoria,:idmarca,:idpresentacion,:estado,:exento,:inventariable,:perecedero,:idsucursal,:stock,:idcolor,:precio_super_mayoreo,:precio_venta_minimo);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idproducto",$idproducto);
				$stmt->bindParam(":codigo_barra",$codigo_barra);
				$stmt->bindParam(":nombre_producto",$nombre_producto);
				$stmt->bindParam(":precio_compra",$precio_compra);
				$stmt->bindParam(":precio_venta",$precio_venta);
				$stmt->bindParam(":precio_venta_mayoreo",$precio_venta_mayoreo);
				$stmt->bindParam(":stock_min",$stock_min);
				$stmt->bindParam(":idcategoria",$idcategoria);
				$stmt->bindParam(":idmarca",$idmarca);
				$stmt->bindParam(":idpresentacion",$idpresentacion);
				$stmt->bindParam(":estado",$estado);
				$stmt->bindParam(":exento",$exento);
				$stmt->bindParam(":inventariable",$inventariable);
				$stmt->bindParam(":perecedero",$perecedero);
				$stmt->bindParam(":idsucursal",$idsucursal);
				$stmt->bindParam(":stock",$stock);
				$stmt->bindParam(":idcolor",$idcolor);
				$stmt->bindParam(":precio_super_mayoreo",$precio_super_mayoreo);
				$stmt->bindParam(":precio_venta_minimo",$precio_venta_minimo);

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
				//echo $e;
				$data = "Error";
				echo json_encode($data);

			}

		}

		public static function Listar_CodigoProducto()
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_codigo_producto();";
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


		public static function Insertar_CodigoProducto($codigo_uno,$codigo_dos,$idproducto)
		{
			$dbconec = Conexion::Conectar();
			try
			{
				$dbconec = Conexion::Conectar();
				$query = "CALL sp_insert_codigo_producto(:codigo_uno,:codigo_dos,:idproducto)";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":codigo_uno",$codigo_uno);
				$stmt->bindParam(":codigo_dos",$codigo_dos);
				$stmt->bindParam(":idproducto",$idproducto);

				if($stmt->execute()){
					$count = $stmt->rowCount();
					if($count == 0){
						$data = "Duplicado";
					} else {
						$data = "Validado";
					}
				} else {
					$data = "Error";
				}

				echo json_encode($data);
				$dbconec = null;
			} catch (Exception $e) {
				//echo $e;
				$data = "Error";
				echo json_encode($data);
			}

		}


		public static function Editar_CodigoProducto($idcodigo,$codigo_uno,$codigo_dos,$idproducto)
		{
			$dbconec = Conexion::Conectar();
			try
			{
				$dbconec = Conexion::Conectar();
				$query = "CALL sp_update_codigo_producto(:idcodigo,:codigo_uno,:codigo_dos,:idproducto)";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idcodigo",$idcodigo);
				$stmt->bindParam(":codigo_uno",$codigo_uno);
				$stmt->bindParam(":codigo_dos",$codigo_dos);
				$stmt->bindParam(":idproducto",$idproducto);

				if($stmt->execute()){
					$count = $stmt->rowCount();
					if($count == 0){
						$data = "Duplicado";
					} else {
						$data = "Validado";
					}
				} else {
					$data = "Error";
				}

				echo json_encode($data);
				$dbconec = null;
			} catch (Exception $e) {
				//echo $e;
				$data = "Error";
				echo json_encode($data);
			}

		}

		public static function Listar_Productos_Categoria($idsucursal, $categoria)
		{
			$dbconec = Conexion::Conectar();

			try
			{
				$query = "CALL sp_view_producto_categoria(:idsucursal, :categoria);";
				$stmt = $dbconec->prepare($query);
				$stmt->bindParam(":idsucursal",$idsucursal);
				$stmt->bindParam(":categoria",$categoria);
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




	}


 ?>
