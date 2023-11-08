<?php

	session_set_cookie_params(60*60*24*365); session_start();
	$idsucursal = $_SESSION['sucursal_id'];

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model); 
		require_once($controller);
	});

	$objCaja =  new Caja();
	$objParametro = new Parametro();

	$filas = $objCaja->Listar_Datos($idsucursal);
	$movimientos = $objCaja->Listar_Movimientos($idsucursal);
	$monedas = $objParametro->Ver_Moneda_Simbolo();

	if (is_array($monedas) || is_object($monedas)){
		foreach ($monedas as $row => $column){
			$simbolo = $column["Symbol"];
		}
	} else {
		$simbolo = '';
	}

	if (is_array($filas) || is_object($filas)){
		foreach ($filas as $row => $column)	{
			$estado_caja = $column['estado'];

			if($column['estado'] == '1'){
				$estado =  '<span class="label label-success label-rounded"><span
				class="text-bold">VIGENTE / ABIERTA</span></span>';
			}else{
				$estado = '<span class="label label-default label-rounded">
				<span class="text-bold">CERRADA</span></span>';
			}

			$fecha_apertura = $column["fecha_apertura"];
			$veces_abierta = $column["veces_abierta"];

			if(is_null($fecha_apertura)){
				$c_fecha_apertura = '';
			} else {
				$c_fecha_apertura = DateTime::createFromFormat('Y-m-d H:i:s',$fecha_apertura)->format('d/m/Y');
			}

		}

	} else {

		$c_fecha_apertura = ' / ';

		$estado = '<span class="label label-info label-rounded">
		<span class="text-bold">SIN ABRIR</span></span>';

		$estado_caja = '0';
	}


 if(is_array($movimientos) || is_object($movimientos)) {
	foreach ($movimientos as $row => $column) {

		$ingresos = $column['p_ingresos'];
		$devoluciones = $column['p_devoluciones'];
		$prestamos = $column['p_prestamos'];
		$gastos = $column['p_gastos'];
		$egresos = $column['p_egresos'];
		$saldo = $column['p_saldo'];
		$movimientos = $column['p_total_movimiento'];
		$diferencia = $column['p_diferencia'];
		$monto_inicial = $column['p_monto_inicial'];
		$ingresos_totales = $column['p_ingresos_totales'];
		$ingreso_transferencia = $column['p_ingreso_transferencia'];

	}

}


 ?>
				<!-- Basic initialization -->
				<div class="panel panel-flat">
					<div class="breadcrumb-line">
											<ul class="breadcrumb">
												<li><a href="?View=Inicio"><i class="icon-home2 position-left"></i> Inicio</a></li>
												<li><a href="javascript:;">Caja</a></li>
												<li class="active">Administrar Caja - Movimientos de Caja</li>
											</ul>
										</div>
											<div class="panel-heading">
												<h4 class="panel-title">Administrar Caja - Movimientos de Caja</h4>

												<small class="display-block">Fecha de Caja : <?php echo $c_fecha_apertura ?> - <strong>
												<?php echo $estado ?> </strong></small>

												<div class="heading-elements">
													<div class="btn-group heading-btn">
													<?php if ($veces_abierta == "0" && $estado_caja == "") { ?>
														<button type="button" class="btn bg-green-700 dropdown-toggle" data-toggle="dropdown">
														<i class="icon-cash3 position-left"></i> <strong>Opciones</strong> <span class="caret"></span></button>
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a href="#" data-toggle="modal" data-target="#modal_iconified"
															onclick="openMovimiento('abrir','')"><i class="icon-drawer-in pull-right"></i> Abrir Caja</a></li>
														</ul>
													 </div>
													<?php } else if ($veces_abierta == "1" && $estado_caja == "1"){?>

														<button type="button" class="btn bg-green-700 dropdown-toggle" data-toggle="dropdown">
														<i class="icon-cash3 position-left"></i> <strong>Opciones</strong> <span class="caret"></span></button>
														<ul class="dropdown-menu dropdown-menu-right">

															<li><a href="#" data-toggle="modal" data-target="#modal_iconified"
															onclick="openMovimiento('update','')"><i class="icon-database-edit2 pull-right"></i> Editar Monto Inicial</a></li>

															<li><a href="#" data-toggle="modal" data-target="#modal_iconified"
															onclick="openMovimiento('cerrar','')"><i class="icon-box pull-right"></i> Cerrar Caja</a></li>
														</ul>
					 								</div>


						                            <div class="btn-group heading-btn">
						                                <button type="button" class="btn bg-slate-700 dropdown-toggle" data-toggle="dropdown"><i class="icon-price-tag position-left"></i> <strong> Cortes de Caja</strong> <span class="caret"></span></button>
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a id="print_diario" href="javascript:void(0)"><i class="icon-flag8 pull-right"></i> Corte Z - Diario</a></li>
															<li><a id="print_mes" href="javascript:void(0)"><i class="icon-flag7 pull-right"></i> Corte Z - Mensual</a></li>
														</ul>
						                            </div>


						                            <div class="btn-group heading-btn">
						                                <button type="button" class="btn bg-blue-400 dropdown-toggle" data-toggle="dropdown"><i class="icon-coin-dollar position-left"></i> <strong> Movimientos de Caja</strong> <span class="caret"></span></button>
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a href="#" data-toggle="modal" data-target="#modal_iconified_movimiento"
															onclick="openMovimiento('devolucion','')"><i class="icon-rotate-ccw3 pull-right"></i> Devolucion</a></li>
															<li><a href="#" data-toggle="modal" data-target="#modal_iconified_movimiento"
															onclick="openMovimiento('prestamo','')"> <i class="icon-cash2 pull-right"></i> Prestamo</a></li>
															<li><a href="#" data-toggle="modal" data-target="#modal_iconified_movimiento"
															onclick="openMovimiento('gasto','')"><i class="icon-coins pull-right"></i> Gasto</a></li>
														</ul>
						                            </div>



													<?php } else if ($veces_abierta == "1" && $estado_caja == "0"){ ?>


													<button type="button" class="btn bg-green-700 dropdown-toggle" data-toggle="dropdown">
														<i class="icon-cash3 position-left"></i> <strong>Opciones</strong> <span class="caret"></span></button>
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a href="#" data-toggle="modal" data-target="#modal_iconified"
															onclick="openMovimiento('abrir','')"><i class="icon-drawer-in pull-right"></i> Abrir Caja</a></li>
														</ul>
					 								</div>

												    <?php } ?>
												</div>
											</div>
											<hr>
											<div class="panel-body">
												<div class="row">

													<div class="col-md-6">
															<div class="chart-container text-center">
															<div class="display-inline-block" id="c3-pie-chart"></div>
															</div>
													</div>

											 		<div class="col-md-5">
											 		  <!-- Navigation widget -->
													  <div class="panel panel-flat" style="background-color: #F4F6F6;">
														<div class="table-responsive">
															<table class="table table-xxs">
																<tbody>
																	<tr>
																		<td><i class="icon-cash"  style="color:#37474F;" aria-hidden="true"></i></td>
																		<td class="text-grey-800"><left><b>MONTO INICIAL</b></left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style='color:#5b5d5f'></a></td>
																		<td></td>
																		<td id="inicial" class="text-right text-bold"> <?php if($monto_inicial!='')echo  $simbolo.' '.$monto_inicial; else echo $simbolo.' 0.00'; ?></td>
																			<input type="hidden" id="txtinicial" value="<?php echo  $monto_inicial; ?>"></td>
																	</tr>
																	<tr>
																		<td><i class="icon-cash"  style="color:#5cb85c;" aria-hidden="true"></i></td>
																		<td class="text-grey-800"><left><b>INGRESOS</b></left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style='color:#5b5d5f'> </a></td>
																		<td></td>
																		<td id="ingresos" class="text-right text-bold"><?php if($ingresos!='')echo  $simbolo.' '.$ingresos; else echo $simbolo.' 0.00'; ?></td>
																	</tr>
																	<tr>
																		<td><i class="icon-cash" style="color:#e9573f;" aria-hidden="true"></i></td>
																		<td><left><b>DEVOLUCIONES</b></left></td>
																		<td></td>
																		<td id="devoluciones" class="text-right text-bold"><?php if($devoluciones!='')echo  $simbolo.' '.$devoluciones; else $simbolo.' 0.00'; ?></td>
																	</tr>
																	<tr>
																		<td><i class="icon-cash" style="color:#f6bb42;" aria-hidden="true"></i></td>
																		<td><left><b>PR&Eacute;STAMOS</b></left></td>
																		<td></td>
																		<td id="prestamos" class="text-right text-bold"><?php if($prestamos!='')echo  $simbolo.' '.$prestamos; else echo $simbolo.' 0.00'; ?></td>
																	</tr>

																	<tr>
																		<td><i class="icon-cash"  style="color:#63d3e9;" aria-hidden="true"></i></td>
																		<td class=" "><left><b>GASTOS</b></left></td>
																		<td></td>
																		<td id="gastos" class="text-right text-bold"><?php if($gastos!='')echo  $simbolo.' '.$gastos; else echo $simbolo.' 0.00'; ?></td>
																	</tr>
																	<tr class="">
																		<th class=""></th>
																		<th class="text-success "><h5><left><strong>INGRESOS TOTALES</strong></left></h5></th>
																		<th class=""></th>
																		<th class="text-right text-success"><h5><strong id="Ingresos"><?php if($ingresos_totales!='')
																		echo  $simbolo.' '.$ingresos_totales; else echo  $simbolo.' 0.00'; ?></strong></h5></th>
																	</tr>
																	<tr class="">
																		<th class=""></th>
																		<th class="text-danger "><h5><left><strong>EGRESOS TOTALES</strong></left></h5></th>
																		<th class=""></th>
																		<th class="text-right text-danger"><h5><strong id="Egresos"><?php if($egresos!='')echo  $simbolo.' '.$egresos; else echo $simbolo.' 0.00'; ?></strong></h5></th>
																	</tr>
																	<tr class="">
																		<td class=""></td>
																		<td class=""><h5><left><strong>SALDO</strong></left></h5></td>
																		<th class=""></th>
																		<th class="text-right"><h5><strong id="Saldo"><?php if($saldo!='')echo  $simbolo.' '.$saldo; else echo $simbolo.' 0.00'; ?></strong></h5></th>
																	</tr>
																	<tr class="">
																		<td class=""></td>
																		<td class="text-info"><h5><left><strong>MONTO INICIAL + SALDO </strong></left></h5></td>
																		<th class=""></th>
																		<th class="text-right text-info"><h5><strong id="Diferencia"><?php if($diferencia!='')echo $simbolo.' '.number_format($diferencia, 2, '.', ','); else echo $simbolo.' 0.00';?></strong></h5></th>
																		<input type="hidden" id="txtdiferencia"  value="<?php echo  $diferencia; ?>"></th>
																	</tr>
																	<tr class="">
																		<td class=""></td>
																		<td class="text-warning"><h5><left><strong>TRANSFERENCIAS </strong></left></h5></td>
																		<th class=""></th>
																		<th class="text-right text-warning"><h5><strong id="Transferencia"><?php if($ingreso_transferencia!='')echo $simbolo.' '.number_format($ingreso_transferencia, 2, '.', ','); else echo $simbolo.' 0.00';?></strong></h5></th>
																		<input type="hidden" id="txttransferencia"  value="<?php echo  $ingreso_transferencia; ?>"></th>
																	</tr>
																</tbody>
															</table>
														 </div>
													   </div>
													</div>
													
												</div>


						<!-- Labels -->
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h6 class="panel-title">Movimientos de Caja</h6>
									</div>

									<div class="panel-body">
										<div class="tabbable">
											<ul class="nav nav-tabs nav-tabs-highlight">
												<li class="active"><a href="#label-tab1" data-toggle="tab">INGRESOS <span id="span-ing" class="label
												label-success position-right"></span></a></li>
												<li><a href="#label-tab2" data-toggle="tab">DEVOLUCIONES <span id="span-dev" class="label bg-danger
												position-right"></span></a></li>
												<li><a href="#label-tab3" data-toggle="tab">PR&Eacute;STAMOS <span id="span-pre" class="label bg-warning
												position-right"></span></a></li>
												<li><a href="#label-tab4" data-toggle="tab">GASTOS <span id="span-gas" class="label bg-info
												position-right"></span></a></li>
											</ul>

											<div class="tab-content">
												<div class="tab-pane active" id="label-tab1">
													<table class="table datatable-basic table-xxs table-hover">
														<thead>
															<tr>
																<th><b>Descripcion</b></th>
																<th><b>Monto</b></th>
															</tr>
														</thead>

														<tbody>

														  <?php
																$filas = $objCaja->Listar_Ingresos($idsucursal);
																if (is_array($filas) || is_object($filas))
																{
																foreach ($filas as $row => $column)
																{
																?>
																	<tr>
													                	<td><?php print($column['descripcion_movimiento']); ?></td>
													                	<td><?php print($column['monto_movimiento']); ?></td>
													                </tr>
																<?php
																		}
																	}
																?>
																</tbody>
														</table>
												</div>

												<div class="tab-pane" id="label-tab2">

													<table class="table datatable-basic table-xxs table-hover">
														<thead>
															<tr>
																<th><b>Descripcion</b></th>
																<th><b>Monto</b></th>
															</tr>
														</thead>

														<tbody>

														  <?php
																$filas = $objCaja->Listar_Devoluciones($idsucursal);
																if (is_array($filas) || is_object($filas))
																{
																foreach ($filas as $row => $column)
																{
																?>
																	<tr>
													                	<td><?php print($column['descripcion_movimiento']); ?></td>
													                	<td><?php print($column['monto_movimiento']); ?></td>
													                </tr>
																<?php
																		}
																	}
																?>
																</tbody>
														</table>

												</div>

												<div class="tab-pane" id="label-tab3">

													<table class="table datatable-basic table-xxs table-hover">
														<thead>
															<tr>
																<th><b>Descripcion</b></th>
																<th><b>Monto</b></th>
															</tr>
														</thead>

														<tbody>

														  <?php
																$filas = $objCaja->Listar_Prestamos($idsucursal);
																if (is_array($filas) || is_object($filas))
																{
																foreach ($filas as $row => $column)
																{
																?>
																	<tr>
													                	<td><?php print($column['descripcion_movimiento']); ?></td>
													                	<td><?php print($column['monto_movimiento']); ?></td>
													                </tr>
																<?php
																		}
																	}
																?>
																</tbody>
														</table>

												</div>

												<div class="tab-pane" id="label-tab4">
													<table class="table datatable-basic table-xxs table-hover">
														<thead>
															<tr>
																<th><b>Descripcion</b></th>
																<th><b>Monto</b></th>
															</tr>
														</thead>

														<tbody>

														  <?php
																$filas = $objCaja->Listar_Gastos($idsucursal);
																if (is_array($filas) || is_object($filas))
																{
																foreach ($filas as $row => $column)
																{
																?>
																	<tr>
													                	<td><?php print($column['descripcion_movimiento']); ?></td>
													                	<td><?php print($column['monto_movimiento']); ?></td>
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
						<!-- /labels -->
					</div>
				</div>

<script type="text/javascript" src="web/custom-js/caja.js"></script>
