<?php
	session_set_cookie_params(60*60*24*365); session_start();
	$tipo_usuario = $_SESSION['user_tipo'];
	$idsucursal = $_SESSION['sucursal_id'];
	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	});

	$objCredito = new Credito();
	$count_creditos = $objCredito->Count_Creditos($idsucursal);

	foreach ($count_creditos as $row => $column) {
		$total_vigentes = $column["count_pendientes"];
		$total_pagados = $column["count_pagados"];
	}



 ?>
 <div class="panel-body">
	 <div class="tabbable">
		 <ul class="nav nav-tabs nav-tabs-highlight">
			 <li class="active"><a href="#label-tab1" data-toggle="tab">VIGENTES <span id="span-ing" class="label
			 label-success position-right"><?php echo $total_vigentes  ?></span></a></li>
			 <li><a href="#label-tab2" data-toggle="tab">FINALIZADOS <span id="span-dev" class="label bg-warning
			 position-right"><?php echo $total_pagados  ?></span></a></li>
			 <li><a href="#label-tab3" data-toggle="tab">PAGOS <span id="span-pre" class="label bg-info-600
			 position-right"><?php echo "--" ?></span></a></li>
		 </ul>

		 <div class="tab-content">
			 <div class="tab-pane active" id="label-tab1">
				 <!-- Basic initialization -->
				 <div class="panel panel-flat">
					 <div class="panel-heading">
						 <h5 class="panel-title">Créditos Vigentes</h5>
						 <div class="heading-elements">

						 </div>
					 </div>
						 <div class="panel-body">
							 <table class="table datatable-basic table-xs table-hover">
								 <thead>
									 <tr>
										 <th><b>Crédito</b></th>
										 <th><b>No. Venta</b></th>
										 <th><b>Monto</b></th>
										 <th><b>Abonado</b></th>
										 <th><b>Restante</b></th>
										 <th><b>Nombre Cliente</b></th>
										 <th><b>Opciones</b></th>
									 </tr>
								 </thead>

								 <tbody>

									 <?php
										 $filas = $objCredito->Listar_Creditos(0,$idsucursal);
										 if (is_array($filas) || is_object($filas))
										 {
										 foreach ($filas as $row => $column)
										 {

											 $fecha_credito = $column["fecha_credito"];
											 if(is_null($fecha_credito))
											 {
												 $c_fecha_credito = '';

											 } else {

												 $c_fecha_credito = DateTime::createFromFormat('Y-m-d H:i:s',$fecha_credito)->format('d/m/Y H:i:s');
											 }

										 ?>
											 <tr>
													 <td><?php print($column['codigo_credito']); ?></td>
													 <td><?php print($column['numero_venta']); ?></td>
													 <td><?php print($column['monto_credito']); ?></td>
													 <td><?php print($column['monto_abonado']); ?></td>
													 <td><?php print($column['monto_restante']); ?></td>
													 <td><?php print($column['cliente']); ?></td>

												 <td class="text-center">
													 <ul class="icons-list">
														 <li class="dropdown">
															 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
																 <i class="icon-menu9"></i>
															 </a>
															 <ul class="dropdown-menu dropdown-menu-right">
																 <?php if($tipo_usuario == 1){ ?>
																 <li><a
																 href="javascript:;" data-toggle="modal" data-target="#Modal_Credito"
																 onclick="openCredito('editar',
																		'<?php print($column["idcredito"]); ?>',
																		'<?php print($column["codigo_credito"]); ?>',
																		'<?php print($column["nombre_credito"]); ?>',
																		'<?php print($c_fecha_credito); ?>',
																		'<?php print($column["monto_credito"]); ?>',
																		'<?php print($column["monto_abonado"]); ?>',
																		'<?php print($column["monto_restante"]); ?>',
																		'<?php print($column["estado_credito"]); ?>')">
																	<i class="icon-pencil6">
																		</i> Editar</a></li>
																		<?php } ?>

																	<li><a id="detail_pay"  data-toggle="modal" data-target="#modal_detalle" data-toggle="modal" data-target="#modal_detalle"
																	data-id="<?php print($column['idcredito']); ?>"
																 href="javascript:void(0)">
																	<i class="icon-file-spreadsheet">
																		</i> Ver Detalle</a></li>

																		<li><a id="print_estado"
																	data-id="<?php print($column['codigo_credito'].','.$column['idcredito']); ?>"
																 href="javascript:void(0)">
																	<i class="icon-typewriter">
																	</i> Estado de Cuenta</a></li>

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
						 <h5 class="panel-title">Créditos Finalizados</h5>
						 <div class="heading-elements">

						 </div>
					 </div>
						 <div class="panel-body">
							 <table class="table datatable-basic table-xs table-hover">
								 <thead>
									 <tr>
										 <th><b>Crédito</b></th>
										 <th><b>No. Venta</b></th>
										 <th><b>Monto</b></th>
										 <th><b>Abonado</b></th>
										 <th><b>Restante</b></th>
										 <th><b>Nombre Cliente</b></th>
										 <th><b>Opciones</b></th>
									 </tr>
								 </thead>

								 <tbody>

									 <?php
										 $filas = $objCredito->Listar_Creditos(1,$idsucursal);
										 if (is_array($filas) || is_object($filas))
										 {
										 foreach ($filas as $row => $column)
										 {


										 ?>
											 <tr>
													 <td><?php print($column['codigo_credito']); ?></td>
													 <td><?php print($column['numero_venta']); ?></td>
													 <td><?php print($column['monto_credito']); ?></td>
													 <td><?php print($column['monto_abonado']); ?></td>
													 <td><?php print($column['monto_restante']); ?></td>
													 <td><?php print($column['cliente']); ?></td>

												 <td class="text-center">
													 <ul class="icons-list">
														 <li class="dropdown">
															 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
																 <i class="icon-menu9"></i>
															 </a>
															 <ul class="dropdown-menu dropdown-menu-right">

																	<li><a id="detail_pay"  data-toggle="modal" data-target="#modal_detalle" data-toggle="modal" data-target="#modal_detalle"
																	data-id="<?php print($column['idcredito']); ?>"
																 href="javascript:void(0)">
																	<i class="icon-file-spreadsheet">
																		</i> Ver Detalle</a></li>

																		<li><a id="print_estado"
																	data-id="<?php print($column['codigo_credito'].','.$column['idcredito']); ?>"
																 href="javascript:void(0)">
																	<i class="icon-typewriter">
																	</i> Estado de Cuenta</a></li>


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


			 <div class="tab-pane" id="label-tab3">
				 <!-- Basic initialization -->
				 <div class="panel panel-flat">
					 <div class="panel-heading">
						 <h5 class="panel-title">Pagos</h5>
						 <div class="heading-elements">
							 <?php $filas = $objCredito->Listar_Creditos(0,$idsucursal);
							 if (is_array($filas) || is_object($filas))
							 { ?>
							 <button type="button" class="btn btn-info heading-btn"
							 onclick="newAbono()">
							 <i class="icon-database-add"></i> Abonar Crédito</button>
							 <?php } ?>

							 <button type="button" class="btn btn-default heading-btn"
							 data-toggle="modal" data-target="#modal_print">
							 <i class="icon-printer2"></i> Imprimir Reporte</button>
						 </div>
					 </div>
						 <div class="panel-body">
							 <table class="table datatable-basic table-xs table-hover">
								 <thead>
									 <tr>
										 <th><b>Crédito</b></th>
										 <th><b>Fecha Abono</b></th>
										 <th><b>Monto Abonado</b></th>
										 <th><b>Opciones</b></th>
									 </tr>
								 </thead>

								 <tbody>

									 <?php
										 $filas = $objCredito->Listar_Abonos_All($idsucursal);
										 if (is_array($filas) || is_object($filas))
										 {
										 foreach ($filas as $row => $column)
										 {
											 $fecha_abono = $column["fecha_abono"];
											 if(is_null($fecha_abono))
											 {
												 $c_fecha_abono = '';

											 } else {

												 $c_fecha_abono = DateTime::createFromFormat('Y-m-d H:i:s',$fecha_abono)->format('d/m/Y H:i:s');
											 }

										 ?>
											 <tr>
													 <td><?php print($column['codigo_credito']); ?></td>
													 <td><?php print($c_fecha_abono); ?></td>
													 <td><?php print($column['monto_abono']); ?></td>


												 <td class="text-center">
													 <ul class="icons-list">
														 <li class="dropdown">
															 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
																 <i class="icon-menu9"></i>
															 </a>
															 <ul class="dropdown-menu dropdown-menu-right">

																 <li><a
																 href="javascript:;" data-toggle="modal" data-target="#Modal_Abono"
																 onclick="openAbono('ver',
																		'<?php print($column["idabono"]); ?>',
																		'<?php print($column['codigo_credito']); ?>',
																		'<?php print($c_fecha_abono); ?>',
																		'<?php print($column['monto_abono']); ?>',
																		'<?php print($column["idcredito"]); ?>')">
																	<i class="icon-eye8">
																	</i> Ver</a></li>

																	<?php if($tipo_usuario==1){ ?>
																		 <li><a id="delete_abono"
																		 data-id="<?php print($column['idabono']); ?>"
																		 href="javascript:void(0)">
																		 <i class=" icon-trash">
																		 </i> Borrar</a></li>
																	<?php } ?>

																	<li><a href="javascript:;" data-toggle="modal" data-target="#modal_ticket"
																	onclick="Print_Ticket('<?php print($column["idabono"]); ?>')">
																	 <i class="icon-printer">
																	 </i> Comprobante </a></li>

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
<script type="text/javascript" src="web/custom-js/credito.js"></script>
