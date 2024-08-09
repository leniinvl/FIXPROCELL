<?php

	spl_autoload_register(function($className){ 
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	});

	$objParametro =  new Sucursal();

 ?>
		<table class="table datatable-basic table-xxs table-hover">
						<thead>
							<tr>
								<th><b>No</b></th>
								<th><b>Nombre Establecimiento</b></th>
								<th><b>Dirección</b></th>
								<th><b>Teléfono</b></th>
								<th class="text-center"><b>Opciones</b></th>
							</tr>
						</thead>

						<tbody>

						  <?php
								$filas = $objParametro->Listar_Sucursal();
								if (is_array($filas) || is_object($filas))
								{
								foreach ($filas as $row => $column)
								{
									
								?>
									<tr>
					                	<td><?php print($column['idsucursal']); ?></td>
					                	<td><?php print($column['nombre']); ?></td>
					                	<td><?php print($column['direccion']); ?></td>
					                	<td><?php print($column['telefono']); ?></td>
					                	<td class="text-center">
										<ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<ul class="dropdown-menu dropdown-menu-right">
													<li><a
													href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
													onclick="openParametro('editar',
														'<?php print($column["idsucursal"]); ?>',
														'<?php print($column["nombre"]); ?>',
														'<?php print($column["direccion"]); ?>',
														'<?php print($column["telefono"]); ?>')">
												   <i class="icon-pencil6">
											       </i> Editar</a></li>
													<li><a
													href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
													onclick="openParametro('ver',
														'<?php print($column["idsucursal"]); ?>',
														'<?php print($column["nombre"]); ?>',
														'<?php print($column["direccion"]); ?>',
														'<?php print($column["telefono"]); ?>')">
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

<script type="text/javascript" src="web/custom-js/sucursal.js"></script>
