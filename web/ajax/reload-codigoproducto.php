<?php

	session_set_cookie_params(60*60*24*365); session_start();
	$idsucursalfilter = $_SESSION['sucursal_id'];

	spl_autoload_register(function($className){ 
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	});

	$objProducto =  new Producto();

 ?>
		<table class="table datatable-basic table-xxs table-hover">
						<thead>
							<tr>
								<th><b>Código</b></th>
								<th><b>IMEI</b></th>
								<th><b>Detalle</b></th>
								<th><b>Nombre Equipo</b></th>
								<th><b>Registro</b></th>
								<th><b>Establecimiento</b></th>
								<th class="text-center"><b>Opciones</b></th>
							</tr>
						</thead>

						<tbody>

						  <?php
								$filas = $objProducto->Listar_CodigoProducto();
								if (is_array($filas) || is_object($filas))
								{
								foreach ($filas as $row => $column)
								{

									$idsucursal = $column['idsucursal'];
									$nombre_sucursal = $column['sucursal'];
									
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
					                	<td><?php print($column['idcodigo']); ?></td>
					                	<td><?php print($column['codigo_uno']); ?></td>
					                	<td><?php print($column['codigo_dos']); ?></td>
										<td><?php print($column['producto']); ?></td>
					                	<td><?php print($column['fecha_registro']); ?></td>
					                	<td><?php print($print_sucursal); ?></td>
					                	<td class="text-center">
										<ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<ul class="dropdown-menu dropdown-menu-right">
												<?php if($idsucursalfilter == $idsucursal){ ?>
													<li><a
													href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
													onclick="openParametro('editar',
														'<?php print($column["idcodigo"]); ?>',
														'<?php print($column["codigo_uno"]); ?>',
														'<?php print($column["codigo_dos"]); ?>',
														'<?php print($column["idproducto"]); ?>')">
												   <i class="icon-pencil6">
											       </i> Editar</a></li>
												<?php }?>   
													<li><a
													href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
													onclick="openParametro('ver',
														'<?php print($column["idcodigo"]); ?>',
														'<?php print($column["codigo_uno"]); ?>',
														'<?php print($column["codigo_dos"]); ?>',
														'<?php print($column["idproducto"]); ?>')">
													<i class=" icon-eye8">
													</i> Ver</a></li>
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

<script type="text/javascript" src="web/custom-js/codigo.js"></script>
