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

	$fecha1 = isset($_GET['fecha1']) ? $_GET['fecha1'] : '';
	$fecha2 = isset($_GET['fecha2']) ? $_GET['fecha2'] : '';

	if($fecha1 == 'empty' && $fecha2 == 'empty'){

		$fecha1 = "";
		$fecha2 = "";

	} else {

		$fecha1 = DateTime::createFromFormat('d/m/Y', $fecha1)->format('Y-m-d');
		$fecha2 = DateTime::createFromFormat('d/m/Y', $fecha2)->format('Y-m-d');
	}


	$objVenta =  new Venta();
	$count_ventas = $objVenta->Count_Facturas('FECHAS',$fecha1,$fecha2,$idsucursal);

	foreach ($count_ventas as $row => $column) {

		$ventas_anuladas = $column["ventas_anuladas"];
		$ventas_vigentes = $column["ventas_vigentes"];

	}



?>
<div class="panel-body">
	<div class="tabbable">
		<ul class="nav nav-tabs nav-tabs-highlight">
			<li class="active"><a href="#label-tab1" data-toggle="tab">VIGENTES <span id="span-ing" class="label
			label-success position-right"><?php echo $ventas_vigentes ?></span></a></li>
			<li><a href="#label-tab2" data-toggle="tab">ANULADAS <span id="span-dev" class="label bg-danger
			position-right"><?php echo $ventas_anuladas ?></span></a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="label-tab1">
				<!-- Basic initialization -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">FACTURAS VIGENTES</h5>
						<div class="heading-elements">
							<button type="button" id="print_vigentes"
							class="btn bg-info-800 heading-btn" id="btnPrint" value="vigentes">
							<i class="icon-printer2"></i> Imprimir Reporte</button>
						</div>
					</div>
						<div class="panel-body">
							<table class="table datatable-basic table-xs table-hover">
								<thead>
									<tr>
										<th><b>No. Venta</b></th>
										<th><b>Comprobante</b></th>
										<th><b>No.Comprobante</b></th>
										<th><b>Fecha y Hora</b></th>
										<th><b>Metodo Pago</b></th>
										<th><b>Total</b></th>
										<th><b>Estado</b></th>
										<th><b>Opciones</b></th>
									</tr>
								</thead>

								<tbody>

								  <?php
										$filas = $objVenta->Listar_Facturas('FECHAS',$fecha1,$fecha2,1,$idsucursal);
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
							                	<td><?php print($column['total']); ?></td>
							                	<td><?php if($column['estado_venta'] == '1')
							                		echo '<span class="label label-success label-rounded"><span
							                		class="text-bold">VIGENTE</span></span>';
							                		else
							                		echo '<span class="label label-default label-rounded">
							                	<span
							                	    class="text-bold">ANULADA</span></span>'
								                ?></td>
												<td class="text-center">
													<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																<i class="icon-menu9"></i>
															</a>
															<ul class="dropdown-menu dropdown-menu-right">
															   <li><a id="detail_pay"  data-toggle="modal" data-target="#modal_detalle"
															   data-id="<?php print($column['idventa']); ?>"
																href="javascript:void(0)">
															   <i class="icon-file-spreadsheet">
														       </i> Ver Detalle</a></li>

														       <li><a id="print_receip"
															   data-id="<?php print($column['idventa']); ?>"
																href="javascript:void(0)">
															   <i class="icon-typewriter">
														       </i> Comprobante</a></li>

															    <!-- EMERGENTE -->
																
																	<li><a id="facturation"
																	data-id="<?php print($column['idventa']); ?>"
																		href="javascript:void(0)">
																	<i class="icon-qrcode">
																	</i> Facturar</a></li>
																
																<!-- EMERGENTE -->

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

			<div class="tab-pane" id="label-tab2">
				<!-- Basic initialization -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">FACTURAS ANULADAS</h5>
						<div class="heading-elements">
							<button type="button" id="print_anuladas"
							class="btn bg-info-800 heading-btn" id="btnPrint" value="anuladas">
							<i class="icon-printer2"></i> Imprimir Reporte</button>
						</div>
					</div>
						<div class="panel-body">
							<table class="table datatable-basic table-xs table-hover">
								<thead>
									<tr>
										<th><b>No. Venta</b></th>
										<th><b>Comprobante</b></th>
										<th><b>No.Comprobante</b></th>
										<th><b>Fecha y Hora</b></th>
										<th><b>Metodo Pago</b></th>
										<th><b>Total</b></th>
										<th><b>Estado</b></th>
										<th><b>Opciones</b></th>
									</tr>
								</thead>

								<tbody>

								  <?php
										$filas = $objVenta->Listar_Facturas('FECHAS',$fecha1,$fecha2,0,$idsucursal);
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
							                	<td><?php print($column['total']); ?></td>
							                	<td><?php if($column['estado_venta'] == '1')
							                		echo '<span class="label label-success label-rounded"><span
							                		class="text-bold">VIGENTE</span></span>';
							                		else
							                		echo '<span class="label label-default label-rounded">
							                	<span
							                	    class="text-bold">ANULADA</span></span>'
								                ?></td>
		                						<td class="text-center">
													<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																<i class="icon-menu9"></i>
															</a>
															<ul class="dropdown-menu dropdown-menu-right">

															   <li><a id="detail_pay"  data-toggle="modal" data-target="#modal_detalle"
															   data-id="<?php print($column['idventa']); ?>"
																href="javascript:void(0)">
															   <i class="icon-file-spreadsheet">
														       </i> Ver Detalle</a></li>

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
<script type="text/javascript" src="web/custom-js/facturas.js"></script>
