<?php

	//session_start();
	//$tipo_usuario = $_SESSION['user_tipo'];
	$idsucursal = $_SESSION['sucursal_id'];

	$objVenta =  new Venta();
	$objProducto =  new Producto();
	$categoria = "TODOS";

 ?>

			<!-- Labels -->
			<div class="row" >
				<div class="col-lg-12">
					<div class="panel panel-flat">
						<div class="breadcrumb-line">
							<ul class="breadcrumb">
								<li><a href="?View=Inicio"><i class="icon-home2 position-left"></i> Inicio</a></li>
								<li><a href="javascript:;">Ventas</a></li>
								<li class="active">Reporte por Productos</li>
							</ul>
						</div>
						<div class="panel-heading">
							<h6 class="panel-title"><b>Ventas de Productos</b> <span class="text-danger">*</span></h6>

						<div class="row">
							 <div class="col-sm-12 col-md-8">
							 	<form role="form" autocomplete="off" class="form-validate-jquery" id="frmSearch">
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<select  data-placeholder="Seleccione una equipo..." id="cbEquipo" name="cbEquipo"
														class="select-search" style="text-transform:uppercase;"
														onkeyup="javascript:this.value = this.value.toUpperCase();">
															<?php
															$filas = $objProducto->Listar_Productos_Categoria($idsucursal, $categoria);
															if (is_array($filas) || is_object($filas)) {
																foreach ($filas as $row => $column) {
																	?>
															<option value="<?php print ($column["idproducto"]) ?>">
																	<?php print ($column["nombre_producto"].' '.$column["nombre_marca"].' '.$column["nombre_presentacion"].' '.$column["nombre_color"]) ?></option>
																<?php
															}
														}
														?>
												</select>
											</div>
											<div class="col-sm-4">
												<button style="margin-top: 0px;" id="btnGuardar" type="submit" class="btn btn-info btn-sm">
												<i class="icon-search4"></i> Consultar</button>
											</div>
										</div>
									</div>
								</form>
						   	</div>
						</div>

						</div>

					<div id="reload-div">
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
																$filas = $objVenta->Listar_Ventas_Productos(0);
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
					</div>



					</div>
				</div>
			</div>
			<!-- /labels -->


<!-- Iconified modal -->
	<div id="modal_detalle" class="modal fade">
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="modal-title"></i> &nbsp; <span class="title-form text-uppercase">Detalle de Venta</span></h5>
				</div>

		        <form role="form" autocomplete="off" class="form-validate-jquery" id="frmModal">
					<div class="modal-body" id="modal-container">

					<div id="reload-detalle">
							<!-- Collapsible with right control button -->
							<div class="panel-group panel-group-control panel-group-control-right content-group-lg">
								<div class="panel">
									<div class="panel-heading bg-info">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" href="#collapsible-control-right-group2">Clic para ver Información de la Venta</a>
										</h6>
									</div>
									<div id="collapsible-control-right-group2" class="panel-collapse collapse">
										<div class="panel-body">
											<div class="table-responsive">
												<table class="table table-xxs table-bordered">
												 <tbody class="border-solid">
												 <tr>
												 	<td width="5%" class="text-bold text-left">NO. VENTA</td>
													<td width="35%"></td>
													<td width="2%" class="text-bold text-left">FORMA PAGO</td>
													<td width="30%"></td>
												 </tr>
												<tr>
													<td width="5%" class="text-bold text-left">CLIENTE</td>
													<td width="30%"></td>
													<td width="2%" class="text-bold text-left">FECHA VENTA</td>
													<td width="30%"></td>
												</tr>
												<tr>
													<td width="20%" class="text-bold text-left">NO. COMPROBANTE</td>
													<td width="5%"></td>
													<td width="10%" class="text-bold text-left"></td>
													<td width="5%"></td>
												</tr>
												</tbody>
											</table>
										 </div>
										</div>
									</div>
								</div>
							</div>
							<!-- /collapsible with right control button -->

							<div class="panel-group panel-group-control panel-group-control-right content-group-lg">
								<div class="table-responsive">
									<table id="tbldetalle" class="table table-borderless table-striped table-xxs">
										<thead>
											<tr class="bg-blue">
												<th>Producto</th>
												<th>Cant.</th>
												<th>Precio</th>
												<th>Tot. SIN IGV</th>
												<th>Descuento</th>
												<th>Importe</th>
												<th>Vence</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
										<tfoot>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td width="10%">SUMAS</td>
												<td id="sumas"></td>
												<td></td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td width="10%">IGV %</td>
												<td id="iva"></td>
												<td></td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td width="10%">SUBTOTAL</td>
												<td id="subtotal"></td>
												<td></td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td width="10%">RET. (-)</td>
												<td id="ivaretenido"></td>
												<td></td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td width="10%">TOT. SIN IGV</td>
												<td id="exentas"></td>
												<td></td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td width="10%">DESCUENTO</td>
												<td id="descuentos"></td>
												<td></td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td width="10%">TOTAL</td>
												<td id="total"></td>
												<td></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>

						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /iconified modal -->

<script type="text/javascript" src="web/custom-js/ventaproductos.js"></script>
