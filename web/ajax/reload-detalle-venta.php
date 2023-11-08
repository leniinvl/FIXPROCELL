<?php

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	});


	$idventa = isset($_GET['numero_transaccion']) ? $_GET['numero_transaccion'] : '';

	$objVenta =  new Venta();
	$detalle = $objVenta->Listar_Detalle($idventa); 
	$info = $objVenta->Listar_Info($idventa);

	foreach ($info as $row => $column) {

		$numero_venta = $column["numero_venta"];
		$fecha_venta = $column["fecha_venta"];
		$tipo_pago = $column["tipo_pago"];
		$cliente = $column["cliente"];
		$numero_comprobante = $column["numero_comprobante"];
		$serie_comprobante = $column["serie_comprobante"];
		$tipo_comprobante = $column["tipo_comprobante"];
		$sumas = $column["sumas"];
		$iva = $column["iva"];
		$subtotal = $column["subtotal"];
		$total_exento = $column["total_exento"];
		$retenido = $column["retenido"];
		$total_descuento = $column["total_descuento"];
		$total = $column["total"];
		$pago_efectivo = $column['pago_efectivo'];
		$pago_tarjeta = $column['pago_tarjeta'];
		$numero_tarjeta = $column['numero_tarjeta'];
		$tarjeta_habiente = $column['tarjeta_habiente'];
		$cambio = $column['cambio'];
	}

	if($tipo_pago=="1")
	{
		$tipo_pago = "EFECTIVO";

	} else if ($tipo_pago=="2"){

		$tipo_pago = "TRANSFERENCIA";

	} else if ($tipo_pago == "3"){

		$tipo_pago = "EFECTIVO Y TRANS.";
	}

?>

	<!-- Collapsible with right control button -->
	<div class="panel-group panel-group-control panel-group-control-right content-group-lg">
		<div class="panel">
			<div class="panel-heading bg-success">
				<h6 class="panel-title">
					<a class="collapsed" data-toggle="collapse" href="#collapsible-control-right-group2">Clic para ver Información de la Venta</a>
				</h6>
			</div>
			<div id="collapsible-control-right-group2" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-borderless table-striped table-xxs">
							<thead>
								<th>No. Venta</th>
								<th>Forma Pago</th>
								<th>Efectivo</th>
								<th>No. Documento</th>
								<th>Transferencia</th>
								<th>Cliente</th>
								<th>Fecha</th>
								<th>Comprobante</th>
								<th>No. Comprobante</th>
							</thead>
						 <tbody class="border-solid">
							 <tr>
							 	<td><?php echo $numero_venta; ?></td>
								<td><?php echo $tipo_pago; ?></td>
								<td><?php echo $pago_efectivo; ?></td>
								<td><?php echo $numero_tarjeta; ?></td>
								<td><?php echo $pago_tarjeta; ?></td>
								<td><?php echo $cliente; ?></td>
								<td><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $fecha_venta)->format('d/m/Y H:i:s');?></td>
								<td><?php if($tipo_comprobante == "1"){ echo "RECIBO"; }elseif ($tipo_comprobante=="2") {echo "FACTURA";}
								elseif ($tipo_comprobante=="3"){ echo "BOLETA";} ?></td>
								<td><?php echo $serie_comprobante; ?></td>
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
					<tr class="bg-info">
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Tot. SIN IVA</th>
						<th>Descuento</th>
						<th>Importe</th>
					</tr>
				</thead>
				<tbody>

				 <?php
					if (is_array($detalle) || is_object($detalle))
					{
					foreach ($detalle as $row => $column)
					{

						$fecha_vence = $column["fecha_vence"];

						if($fecha_vence==""){
							$fecha_vence = "NO VENCE";
						} else {
							$fecha_vence = DateTime::createFromFormat('Y-m-d', $column['fecha_vence'])->format('d/m/Y');
						}

					?>
						<tr>
		                	<td><?php print($column['nombre_producto']." ".$column['nombre_marca']." ".$column['siglas']." ".$column['nombre_color']); ?></td>
		                	<td><?php print($column['cantidad']); ?></td>
		                	<td><?php print($column['precio_unitario']); ?></td>
		                	<td><?php print($column['exento']); ?></td>
		                	<td><?php print($column['descuento']); ?></td>
		                	<td><?php print($column['importe']); ?></td>
		                </tr>
					<?php
					}
				}
				?>

				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td width="10%">TARIFA 12%</td>
						<td id="sumas"><?php echo $sumas; ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td width="10%">IVA 12%</td>
						<td id="iva"><?php echo $iva; ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td width="10%">SUBTOTAL</td>
						<td id="subtotal"><?php echo $subtotal; ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td width="10%">TOT. SIN IVA</td>
						<td id="exentas"><?php echo $total_exento; ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td width="10%">DESCUENTO</td>
						<td id="descuentos"><?php echo $total_descuento; ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td width="10%"><b>TOTAL</b></td>
						<td id="total"><b><?php echo $total; ?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
