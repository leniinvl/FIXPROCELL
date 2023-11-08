<?php 

	session_set_cookie_params(60*60*24*365); session_start();
	$idsucursal_sesion = $_SESSION['sucursal_id'];
	$tipo_usuario = $_SESSION['user_tipo'];
	
	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";
	
		require_once($model);
		require_once($controller);
	});

	$objProducto =  new Producto();

	$idsucursal_filtro = isset($_GET['id']) ? $_GET['id'] : '';
	$idcategoria_filtro = isset($_GET['idcat']) ? $_GET['idcat'] : '';

	if($idsucursal_filtro!=''){
		$idsucursal_filtro = $idsucursal_filtro;
	} else {
		$idsucursal_filtro = $idsucursal_sesion;
	}
	if($idcategoria_filtro!=''){
		$idcategoria_filtro = $idcategoria_filtro;
	} else {
		$idcategoria_filtro = '0';
	}

 ?>
	<table class="table datatable-basic table-xxs table-hover">
						<thead>
							<tr>
								<th><b>Código/Barra</b></th>
								<th><b>Producto</b></th>
								<th><b>Marca</b></th>
								<th><b>Categoría</b></th>
								<th><b>Modelo</b></th>
								<th><b>Color</b></th>
								<th><b>Stock</b></th>
								<th><b>Estado</b></th> 
								<th><b>P.Venta</b></th>
								<th><b>P.Min</b></th>
								<th><b>Dist.1</b></th>
								<th><b>Dist.2</b></th>
								<th><b>P.Compra</b></th>
								<th><b>Bodega</b></th>
								<th class="text-center"><b>Opciones</b></th>
							</tr>
						</thead>

						<tbody>
						
						  <?php 
								$filas = $objProducto->Listar_Productos_Filtros($idsucursal_filtro, $idcategoria_filtro); 
								if (is_array($filas) || is_object($filas))
								{
								foreach ($filas as $row => $column) 
								{
									$stock_print = "";
									$codigo_print = "";
									$codigo_barra = $column['codigo_barra'];
									$inventariable = $column['inventariable'];
									$stock = $column['stock'];
									$stock_min = $column['stock_min'];

									if($codigo_barra == '')
									{
										$codigo_print = $column['codigo_interno'];

									} else {

										$codigo_print = $codigo_barra;
									}

									if($inventariable == 1){

										if ($stock >= 1 && $stock < $stock_min) {

											$stock_print = '<span class="label label-warning label-rounded"><span
												class="text-bold">POR AGOTARSE</span></span>';
										} else if ($stock == $stock_min) {
		
											$stock_print = '<span class="label label-info label-rounded"><span
												class="text-bold">EN MINIMO</span></span>';
										} else if ($stock > $stock_min) {
		
											$stock_print = '<span class="label label-success label-rounded"><span
												class="text-bold">DISPONIBLE</span></span>';
										} else if ($stock == 0 && $stock_min >= 1) {
		
											$stock_print = '<span class="label label-danger label-rounded">
												<span class="text-bold">AGOTADO</span></span>';
										} else if ($stock == 0 && $stock_min == 0) {
		
											$stock_print = '<span class="label label-default label-rounded">
												<span class="text-bold">POR INVENTARIAR</span></span>';
										} 

									} else {

											$stock_print = '<span class="label label-primary label-rounded"><span 
						                	class="text-bold">SERVICIO</span></span>';
									}

									$idsucursal = $column['idsucursal'];
									$nombre_sucursal = $column['nombre_sucursal'];
									$print_sucursal = '<span class="label label-success label-rounded"><span
									class="text-bold">'.$nombre_sucursal.'</span></span>';
									if ($idsucursal == 2) {
										$print_sucursal = '<span class="label label-info label-rounded"><span
												class="text-bold">'.$nombre_sucursal.'</span></span>';
									}elseif ($idsucursal == 3) {
										$print_sucursal = '<span class="label label-warning label-rounded"><span
												class="text-bold">'.$nombre_sucursal.'</span></span>';
									}elseif ($idsucursal == 4) {
										$print_sucursal = '<span class="label label-primary label-rounded"><span 
						                	class="text-bold">'.$nombre_sucursal.'</span></span>';
									}elseif ($idsucursal == 5) {
										$print_sucursal = '<span class="label label-default label-rounded">
												<span class="text-bold">'.$nombre_sucursal.'</span></span>';
									}elseif ($idsucursal == 6) {
										$print_sucursal = '<span class="label label-danger label-rounded">
										<span class="text-bold">'.$nombre_sucursal.'</span></span>';
									}


								?>
									<tr>
										<td><?php print($codigo_print); ?></td>
					                	<td><?php print($column['nombre_producto']); ?></td>
					                	<td><?php print($column['nombre_marca']); ?></td>
										<td><?php print($column['nombre_categoria']); ?></td>
					                	<td><?php print($column['nombre_presentacion']); ?></td>
										<td><?php print($column['nombre_color']); ?></td>
					                	<td><?php print($column['stock']); ?></td>
					                	<td class="success"><?php print($stock_print); ?></td>
					                	<td><?php print($column['precio_venta']); ?></td>
										<td><?php print($column['precio_venta_minimo']); ?></td>
										<td><?php print($column['precio_venta_mayoreo']); ?></td>
										<td><?php print($column['precio_super_mayoreo']); ?></td>
										<td><?php print($column['precio_compra']); ?></td>
										<td class="success"><?php print($print_sucursal); ?></td>
					                	<td class="text-center">
										<ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<ul class="dropdown-menu dropdown-menu-right">
												<?php if ($tipo_usuario == '1' && $idsucursal_sesion == $idsucursal) { ?>
													<li><a 
													href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
													onclick="openProducto('editar',
								                     '<?php print($column["idproducto"]); ?>',
								                     '<?php print($column["codigo_interno"]); ?>',
								                     '<?php print($column["codigo_barra"]); ?>',
								                     '<?php print($column["nombre_producto"]); ?>',
								                     '<?php print($column["precio_compra"]); ?>',
								                     '<?php print($column["precio_venta"]); ?>',
													 '<?php print($column["precio_venta_minimo"]); ?>',
								                     '<?php print($column["precio_venta_mayoreo"]); ?>',
													 '<?php print($column["precio_super_mayoreo"]); ?>',
								                     '<?php print($column["stock"]); ?>',
								                     '<?php print($column["stock_min"]); ?>',
								                     '<?php print($column["idcategoria"]); ?>',
								                     '<?php print($column["idmarca"]); ?>',
								                     '<?php print($column["idpresentacion"]); ?>',
								                     '<?php print($column["estado"]); ?>',
								                     '<?php print($column["exento"]); ?>',
								                     '<?php print($column["inventariable"]); ?>',
								                     '<?php print($column["perecedero"]); ?>',
													 '<?php print($column["idcolor"]); ?>')">
												   <i class="icon-pencil6">
											       </i> Editar</a></li>
												<?php } ?>

												<!--	<li><a
													href="javascript:;" data-toggle="modal" 
													data-target="#modal_iconified_barcode"
													onclick="openBarcode(
													'<?php //print($column["codigo_barra"]); ?>',
													'<?php //print($column["codigo_interno"]); ?>',
													'<?php //print($column["nombre_producto"]); ?>',
													'<?php //print($column["idproducto"]); ?>')">
													<i class="icon-barcode2">
													</i>Codigo de Barra</a></li> -->
													<li><a
													href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
													onclick="openProducto('ver',
								                     '<?php print($column["idproducto"]); ?>',
								                     '<?php print($column["codigo_interno"]); ?>',
								                     '<?php print($column["codigo_barra"]); ?>',
								                     '<?php print($column["nombre_producto"]); ?>',
								                     '<?php print($column["precio_compra"]); ?>',
								                     '<?php print($column["precio_venta"]); ?>',
													 '<?php print($column["precio_venta_minimo"]); ?>',
								                     '<?php print($column["precio_venta_mayoreo"]); ?>',
													 '<?php print($column["precio_super_mayoreo"]); ?>',
								                     '<?php print($column["stock"]); ?>',
								                     '<?php print($column["stock_min"]); ?>',
								                     '<?php print($column["idcategoria"]); ?>',
								                     '<?php print($column["idmarca"]); ?>',
								                     '<?php print($column["idpresentacion"]); ?>',
								                     '<?php print($column["estado"]); ?>',
								                     '<?php print($column["exento"]); ?>',
								                     '<?php print($column["inventariable"]); ?>',
								                     '<?php print($column["perecedero"]); ?>',
													 '<?php print($column["idcolor"]); ?>')">
													<i class=" icon-eye8">
													</i> Ver</a></li>
													<?php if ($tipo_usuario == '1' && $idsucursal_sesion == $idsucursal) { ?>	
														<li><a id="delete_product"
														data-id="<?php print($column['idproducto']); ?>"
														href="javascript:void(0)">
														<i class=" icon-trash">
														</i> Eliminar</a></li>
													<?php } ?>
												</ul>
											</li>
										</ul>
									</td>
					                </tr>
								<?php  
								}
							}
							?>
						
						</tbody>
					</table>

<script type="text/javascript" src="web/custom-js/producto.js"></script>
