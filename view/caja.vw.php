<?php

	$idsucursal = $_SESSION['sucursal_id'];

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

		foreach ($filas as $row => $column){
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

			<div id="reload-div">
				<!-- Basic initialization -->
				<div class="panel panel-flat">
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="?View=Inicio"><i class="icon-home2 position-left"></i> Inicio</a></li>
							<li><a href="javascript:;">Caja</a></li>
							<li class="active">Administración de Caja</li>
						</ul>
					</div>
						<div class="panel-heading">
							<h4 class="panel-title"><b>Administrar Movimientos de Caja</b></h4>

							<small class="display-block">Estado : <?php echo $c_fecha_apertura ?> - <strong>
							<?php echo $estado ?> </strong></small>

							<div class="heading-elements">
								<div class="btn-group heading-btn">
								<?php if ($veces_abierta == "0" && $estado_caja == "") { ?>
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<i class="icon-box position-left"></i> <strong>Opciones</strong> <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="#" data-toggle="modal" data-target="#modal_iconified"
										onclick="openMovimiento('abrir','')"><i class="icon-cash pull-right"></i> Abrir Caja</a></li>
									</ul>
								 </div>
								<?php } else if ($veces_abierta == "1" && $estado_caja == "1"){?>

									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<i class="icon-box position-left"></i> <strong>Opciones</strong> <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">

										<li><a href="#" data-toggle="modal" data-target="#modal_iconified"
										onclick="openMovimiento('update','')"><i class="icon-database-edit2 pull-right"></i> Ajustar Monto</a></li>

										<li><a href="#" data-toggle="modal" data-target="#modal_iconified"
										onclick="openMovimiento('cerrar','')"><i class="icon-box pull-right"></i> Cerrar Caja</a></li>
									</ul>
 								</div>


	                            <div class="btn-group heading-btn">
	                                <button type="button" class="btn bg-slate-700 dropdown-toggle" data-toggle="dropdown"><i class="icon-cash3 position-left"></i> <strong> Reporte de Caja</strong> <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a id="print_diario" href="javascript:void(0)"><i class="icon-clipboard2 pull-right"></i> Reporte - Diario</a></li>
										<li><a id="print_mes" href="javascript:void(0)"><i class="icon-clipboard2 pull-right"></i> Reporte - Mensual</a></li>
									</ul>
	                            </div>


	                            <div class="btn-group heading-btn">
	                                <button type="button" class="btn bg-blue-700 dropdown-toggle" data-toggle="dropdown"><i class="icon-coin-dollar position-left"></i> <strong> Movimientos de Caja</strong> <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="#" data-toggle="modal" data-target="#modal_iconified_movimiento"
										onclick="openMovimiento('devolucion','')"><i class="icon-rotate-ccw3 pull-right"></i>Registrar Devolucion</a></li>
										<li><a href="#" data-toggle="modal" data-target="#modal_iconified_movimiento"
										onclick="openMovimiento('prestamo','')"> <i class="icon-cash2 pull-right"></i>Registrar Prestamo</a></li>
										<li><a href="#" data-toggle="modal" data-target="#modal_iconified_movimiento"
										onclick="openMovimiento('gasto','')"><i class="icon-coins pull-right"></i>Registrar Gasto</a></li>
									</ul>
	                            </div>



								<?php } else if ($veces_abierta == "1" && $estado_caja == "0"){ ?>


								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<i class="icon-box position-left"></i> <strong>Opciones</strong> <span class="caret"></span></button>
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
							<div class="row" >

						 		<div class="col-md-6">
						 		  <!-- Navigation widget -->
								  <div class="panel panel-flat" style="background-color: #EAECEE;">
									<div class="table-responsive">
										<table class="table table-xxs">
											<tbody>
												<tr>
													<td><i class="icon-cash"  style="color:#34495E;" aria-hidden="true"></i></td>
													<td class="#444"><left><b>MONTO INICIAL</b></left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style='color:#5b5d5f'></a></td>
													<td></td>
													<td id="inicial" class="text-right text-bold"> <?php if($monto_inicial!='')echo  $simbolo.' '.$monto_inicial; else echo $simbolo.' 0.00'; ?></td>
													<input type="hidden" id="txtinicial" value="<?php echo  $monto_inicial; ?>"></td>
												</tr>
												<tr>
													<td><i class="icon-cash"  style="color:#2ECC71;" aria-hidden="true"></i></td>
													<td class="#444"><left><b>INGRESOS EN VENTAS</b></left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style='color:#5b5d5f'> </a></td>
													<td></td>
													<td id="ingresos" class="text-right text-bold"><?php if($ingresos!='')echo  $simbolo.' '.$ingresos; else echo $simbolo.' 0.00'; ?></td>
												</tr>
												<tr>
													<td><i class="icon-cash" style="color:#D68910;" aria-hidden="true"></i></td>
													<td><left><b>DEVOLUCIONES</b></left></td>
													<td></td>
													<td id="devoluciones" class="text-right text-bold"><?php if($devoluciones!='')echo  $simbolo.' '.$devoluciones; else $simbolo.' 0.00'; ?></td>
												</tr>
												<tr>
													<td><i class="icon-cash" style="color:#D4AC0D;" aria-hidden="true"></i></td>
													<td><left><b>PR&Eacute;STAMOS</b></left></td>
													<td></td>
													<td id="prestamos" class="text-right text-bold"><?php if($prestamos!='')echo  $simbolo.' '.$prestamos; else echo $simbolo.' 0.00'; ?></td>
												</tr>

												<tr>
													<td><i class="icon-cash"  style="color:#5499C7;" aria-hidden="true"></i></td>
													<td class=" "><left><b>GASTOS</b></left></td>
													<td></td>
													<td id="gastos" class="text-right text-bold"><?php if($gastos!='')echo  $simbolo.' '.$gastos; else echo $simbolo.' 0.00'; ?></td>
												</tr>
												<tr class="">
													<th class=""></th>
													<th class="text-success-700"><left><strong>INGRESOS TOTALES</strong></left></th>
													<th class=""></th>
													<th class="text-right text-success-700"><strong id="Ingresos"><?php if($ingresos_totales!='')
													echo  $simbolo.' '.$ingresos_totales; else echo  $simbolo.' 0.00'; ?></strong></th>
												</tr>
												<tr class="">
													<th class=""></th>
													<th class="text-danger-700"><left><strong>EGRESOS TOTALES</strong></left></th>
													<th class=""></th>
													<th class="text-right text-danger-700"><strong id="Egresos"><?php if($egresos!='')echo  $simbolo.' '.$egresos; else echo $simbolo.' 0.00'; ?></strong></th>
												</tr>
												<tr class="">
													<td class=""></td>
													<td class="text-teal-700"><left><strong>SALDO</strong></left></td>
													<th class=""></th>
													<th class="text-right text-teal-700"><strong id="Saldo"><?php if($saldo!='')echo  $simbolo.' '.$saldo; else echo $simbolo.' 0.00'; ?></strong></th>
												</tr>
												<tr class="">
													<td class=""></td>
													<td class="text-info-700"><left><strong>SALDO + MONTO INICIAL</strong></left></td>
													<th class=""></th>
													<th class="text-right text-info-700"><strong id="Diferencia"><?php if($diferencia!='')echo $simbolo.' '.number_format($diferencia, 2, '.', ','); else echo $simbolo.' 0.00';?></strong></th>
													<input type="hidden" id="txtdiferencia"  value="<?php echo  $diferencia; ?>"></th>
												</tr>
												<tr class="">
													<td class=""></td>
													<td class="text-indigo-800"><left><strong>TRANSFERENCIAS</strong></left></td>
													<th class=""></th>
													<th class="text-right text-indigo-800"><strong id="Transferencia"><?php if($ingreso_transferencia!='')echo $simbolo.' '.number_format($ingreso_transferencia, 2, '.', ','); else echo $simbolo.' 0.00';?></strong></th>
													<input type="hidden" id="txttransferencia"  value="<?php echo  $ingreso_transferencia; ?>"></th>
												</tr>
											</tbody>
										</table>
									 </div>
								   </div>
								</div>

								<div class="col-md-6" style="background-color: #EAECEE;">
									<div class="chart-container text-center">
										<div class="display-inline-block" id="c3-pie-chart"></div>
									</div>
								</div>		

							</div>


						<!-- Labels -->
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h6 class="panel-title"><b>Movimientos de Caja</b></h6>
									</div>
									<b></b>
									<div class="panel-body">
										<div class="tabbable">
											<ul class="nav nav-tabs nav-tabs-highlight">
												<li class="active"><a href="#label-tab1" data-toggle="tab">INGRESOS <span id="span-ing" class="label
												label-success position-right"></span></a></li>
												<li><a href="#label-tab2" data-toggle="tab">DEVOLUCIONES <span id="span-dev" class="label bg-danger
												position-right"></span></a></li>
												<li><a href="#label-tab3" data-toggle="tab">PR&Eacute;STAMOS <span id="span-pre" class="label bg-warning
												position-right"></span></a></li>
												<li><a href="#label-tab4" data-toggle="tab">GASTOS <span id="span-gas" class="label bg-info-800
												position-right"></span></a></li>
											</ul>

											<div class="tab-content">
												<div class="tab-pane active" id="label-tab1">
													<table class="table datatable-basic table-xxs table-hover">
														<thead>
															<tr>
																<th><b>Descripcion de movimiento</b></th>
																<th><b>Monto en dolares</b></th>
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
																<th><b>Descripcion de movimiento</b></th>
																<th><b>Monto en dolares</b></th>
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
																<th><b>Descripcion de movimiento</b></th>
																<th><b>Monto en dolares</b></th>
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
																<th><b>Descripcion de movimiento</b></th>
																<th><b>Monto en dolares</b></th>
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

			</div>
			  	<!-- Iconified modal -->
				<div id="modal_iconified_movimiento" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h5 class="modal-title"><i class="icon-pencil7"></i> &nbsp; <span class="title-form"></span></h5>
							</div>

					        <form role="form" autocomplete="off" class="form-validate-jquery" id="frmModal">
								<div class="modal-body" id="modal-container">

								<div class="alert alert-info alert-styled-left text-blue-800 content-group">
						                <span class="text-semibold">Estimado usuario</span>
						                los campos remarcados con <span class="text-danger"> * </span> son obligatorios.
						                <button type="button" class="close" data-dismiss="alert">×</button>
                                      	<input type="hidden" id="txtProceso" name="txtProceso" class="form-control" value="">
						           </div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label>Monto <span class="text-danger">*</span></label>
												<input type="text" id="txtMonto" name="txtMonto" placeholder="EJEMPLO: 25.00"
												class="touchspin-prefix" value="0" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>


									<div class="form-group">
										<div class="row">
											<div class="col-sm-12">
												<label>Descripcion de Movimiento <span class="text-danger"> * </span></label>
												<textarea id="txtDescripcion" name="txtDescripcion"
												 rows="3" cols="3" class="form-control" placeholder="INGRESE UNA BREVE DESCRIPCION"
												 style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
												 </textarea>
											</div>
										</div>
									</div>

								</div>

								<div class="modal-footer">
									<button  type="reset" class="btn btn-default" id="reset"
									class="btn btn-link" data-dismiss="modal">Cerrar</button>
									<button id="btnGuardar" type="submit" class="btn btn-info">Guardar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- /iconified modal -->


			  <!-- Iconified modal -->
				<div id="modal_iconified" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h5 class="modal-title"><i class="icon-pencil7"></i> &nbsp; <span class="title-form"></span></h5>
							</div>

					        <form role="form" autocomplete="off" class="form-validate-jquery" id="frmMonto">
								<div class="modal-body" id="modal-container">

								<div class="alert alert-info alert-styled-left text-blue-800 content-group">
						                <span class="text-semibold">Estimado usuario</span>
						                los campos remarcados con <span class="text-danger"> * </span> son obligatorios.
						                <button type="button" class="close" data-dismiss="alert">×</button>
                                      	<input type="hidden" id="txtProceso" name="txtProceso" class="form-control" value="">
						           </div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label>Monto <span class="text-danger">*</span></label>
												<input type="text" id="txtCantidad" name="txtCantidad" placeholder="EJEMPLO: 15.00"
												class="touchspin-prefix" value="0" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>

								</div>

								<div class="modal-footer">
									<button  type="reset" class="btn btn-default" id="reset"
									class="btn btn-link" data-dismiss="modal">Cerrar</button>
									<button id="btnGuardar" type="submit" class="btn btn-info">Guardar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- /iconified modal -->

				<?php include('./includes/footer.inc.php'); ?>
			</div>
			<!-- /content area -->
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->
</div>
<!-- /page container -->
</body>
</html>
<script type="text/javascript" src="web/custom-js/caja.js"></script>
