<?php

	session_set_cookie_params(60*60*24*365); session_start();
	//$tipo_usuario = $_SESSION['user_tipo'];
	$idsucursal = $_SESSION['sucursal_id'];	

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	});

	$idproducto = isset($_GET['idproducto']) ? $_GET['idproducto'] : '';

	if($idproducto=='empty')
	{
		$idproducto = 0;
	} else {
		$idproducto = $idproducto;
	}



	$objVenta =  new Venta();

?>
<div class="panel-body">
	<div class="tabbable">
		
		<div class="tab-content">
			<div class="tab-pane active" id="label-tab1">
				<!-- Basic initialization -->
					<div class="panel panel-flat">
						<div class="panel-body">
							<table class="table datatable-basic table-xs table-hover">
								<thead>
									<tr>
										<th><b>No. Venta</b></th>
										<th><b>Comprobante</b></th>
										<th><b>No.Comprobante</b></th>
										<th><b>Fecha y Hora</b></th>
										<th><b>Metodo Pago</b></th>
										<th><b>Cantidad</b></th>
										<th><b>Total</b></th>
										<th><b>Vendedor</b></th>
										<th><b>Opciones</b></th>
									</tr>
								</thead>

								<tbody>

								  <?php
										$filas = $objVenta->Listar_Ventas_Productos($idproducto);
										if (is_array($filas) || is_object($filas))
										{
										foreach ($filas as $row => $column)
										{

										$fecha_venta = $column["fecha_venta"];
										if(is_null($fecha_venta))
										{
											$c_fecha_venta = '';

										} else {

											$c_fecha_venta = DateTime::createFromFormat('Y-m-d H:i:s',$fecha_venta)->format('d/m/Y H:i:s');
										}

										$tipo_comprobante = $column["tipo_comprobante"];
										if($tipo_comprobante == '1')
										{
											$tipo_comprobante = 'RECIBO';

										} else if ($tipo_comprobante == '2'){

											$tipo_comprobante = 'FACTURA';

										} else if ($tipo_comprobante == '3'){

											$tipo_comprobante = 'BOLETA';
										}


										$tipo_pago = $column["tipo_pago"];
										if($tipo_pago == '1')
										{
											$tipo_pago = 'CONTADO';

										} else if ($tipo_pago == '2'){

											$tipo_pago = 'CREDITO';

										}

										?>
											<tr>
												<td><?php print($column['numero_venta']); ?></td>
												<td><?php print($tipo_comprobante); ?></td>
							                	<td><?php print($column['serie_comprobante']); ?></td>
							                	<td><?php print($c_fecha_venta); ?></td>
							                	<td><?php print($tipo_pago); ?></td>
							                	<td><?php print($column['cantidad']); ?></td>
												<td><?php print($column['total']); ?></td>
												<td><?php print($column['empleado']); ?></td>
												<td class="text-center">
													<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																<i class="icon-menu9"></i>
															</a>
															<ul class="dropdown-menu dropdown-menu-right">
															   
														       <li><a id="print_receip"
															   data-id="<?php print($column['idventa']); ?>"
																href="javascript:void(0)">
															   <i class="icon-typewriter">
														       </i> Comprobante</a></li>

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
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="web/custom-js/ventaproductos.js"></script>
