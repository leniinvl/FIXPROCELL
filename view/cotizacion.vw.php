<style type="text/css">
		.select-search { /*CAMBIO*/
			height: 30px;
			line-height: 30px;
			border-radius: 5px;
			border: 1.5px solid #3AB7C5;
			font-size: 13.9px;
			background-color: #3AB7C5; 
			color:white;
		}
</style>

<?php

	$idsucursal = $_SESSION['sucursal_id'];
	$sucursal = $_SESSION['sucursal_name'];

	$objProducto =  new Producto();
	$objVenta = new Venta();

	//Recuperacion de datos empresa
	$objParametro =  new Parametro();
	$parametros = $objParametro->Listar_Parametros();
	if (is_array($parametros) || is_object($parametros)){
		foreach ($parametros as $row => $column){
			$nombre_empresa = $column['nombre_empresa'];
			$direccion_empresa = $column['direccion_empresa'];
			$valorTarifaIVA = $column['porcentaje_iva'];
		}
	}
	$textoPorcetajeIVA = (round((float)$valorTarifaIVA)).'%';
?>
			 <div class="row">
				 <div class="col-md-12 col-lg-12">
			      	<!-- Detalle de Compra -->
						<div class="panel panel-default">
							<div class="panel-heading" style="background-color:#D1E3DF;">
								<h3 class="panel-title"><b>COTIZACIONES</b></h3>
								<!-- Variable sucursal --> 
								<input type="hidden" value="<?php echo $idsucursal ?>" id="idSucursalVenta"> 
									<div class="heading-elements">
										<form class="heading-form" action="#">
											
											<div class="form-group">
												<div class="checkbox checkbox-switchery switchery-sm">
													<label>
														<input type="checkbox" id="chkBusqueda" name="chkBusqueda"
														class="switchery" checked="checked" >
														<i class="icon-search4"></i> <span id="lblchk3">BUSCAR POR DETALLE</span>
													</label>
												</div>
											</div>

											<!-- Check oculto -switch- --> 
											<div class="form-group" style="padding-top: 4px; padding-left: 10px;">
												<label>
													<input type="hidden" id="chkPrecio"
													data-on-text="PRECIO-NORMAL" data-off-text="PRECIO-OFERTA" class="-switch-" data-size="mini"
													data-on-color="info" data-off-color="warning" checked="checked">
												</label>
											</div>

											<!-- Check oculto --> 
											<div class="form-group" style="padding-top: 3px;">
												<select  data-placeholder="..." id="tipoPrecio" name="tipoPrecio"
													class="select-search" style="text-transform:uppercase;"
													onkeyup="javascript:this.value=this.value.toUpperCase();">
													<option value="PRECIO NORMAL"> &nbsp &nbsp PRECIO NORMAL &nbsp &nbsp</option>
													<option value="PRECIO OFERTA"> &nbsp &nbsp PRECIO OFERTA &nbsp &nbsp</option>
													<!--<option value="DISTRIBUIDOR UNO"> &nbsp DISTRIBUIDOR UNO</option>--> 
													<!--<option value="DISTRIBUIDOR DOS"> &nbsp DISTRIBUIDOR DOS</option>--> 
												</select>
											</div>
											<!-- Check oculto --> 

										</form>
									</div>
							</div>
							<div class="panel-heading" style="background-color:#2b2b2b;">
								<h4 class="panel-title"><h1 id="big_total" class="panel-title text-center text-black text-green"
									style="font-size:40px;">0.00</h1></h4>
							</div>
							<div class="panel-body" style="background-color:#D1E3DF;">
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-barcode2"></i></span>
												<input type="text" id="buscar_producto" name="buscar_producto"  placeholder="BUSCAR PRODUCTO..."
												class="form-control" style="text-transform:uppercase;"
												onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>
								</div>

								<div class="table-responsive">
									<table id="tbldetalle" class="table table-xxs">
										<thead>
											<tr class="bg-info-800">
												<th class="text-center">ID</th>
												<th class="text-center">PRODUCTO</th>
												<th class="text-center">DISPONIBLE</th>
												<th class="text-center">CANTIDAD</th>
												<th class="text-center">PRECIO</th>
												<th class="text-center">EXENTO</th>
												<th class="text-center">DESCUENTO</th>
												<th class="text-center">TOTAL</th>
												<th class="text-center">ELIMINAR</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
										<tfoot id="totales_foot">
											<tr class="bg-info-800">
												<td align="center" width="10%">SUBTOTAL</td>
												<td align="center" width="26%">IVA <?php echo $textoPorcetajeIVA?></td>
												<td align="center" width="10%">TOTAL</td>
												<td align="center" width="10%">RET. (-)</td>
												<td align="center" width="10%">IVA 0%</td>
												<td align="center" width="10%">DESCUENTO</td>
												<td align="center" width="10%">TOTAL</td>
												<td align="center" width="30%"><b><i class="icon-cash"></i>
												</b></td>
												<td align="center" width="30%"><b>
												<i class="icon-cancel-circle2"></i>
												</b></td>
											</tr>
											<tr>
												<td align="center" id="sumas"></td>
												<td align="center" id="iva"></td>
												<td align="center" id="subtotal"></td>
												<td align="center" id="ivaretenido"></td>
												<td align="center" id="exentas"></td>
												<td align="center" id="descuentos"></td>
												<td align="center" id="total"></td>
												<td align="center"><button type="button" id="btnguardar" data-toggle="modal" data-target="#modal_iconified_cash"
												class="btn bg-success btn-sm">&nbsp Guardar &nbsp</button></td>
												<td align="center"><button type="submit" id="btncancelar" class="btn bg-warning btn-sm">
												</b> Cancelar </button></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					<!-- /Detalle de Compra -->

			   	  </div>
			  </div>

			<!-- Iconified modal -->
				<div id="modal_iconified_cash" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h5 class="modal-title"><i class="icon-file-text2"></i> &nbsp; <span class="title-form">Datos de Cotizacion</span></h5>
							</div>

					    <form role="form" autocomplete="off" class="form-validate-jquery" id="frmPago">
								<div class="modal-body" id="modal-container">

									<div class="form-group">
										<div class="row">
											<div class="col-sm-12">
												<label>Seleccione el Cliente</label>
												<select  data-placeholder="..." id="cbCliente" name="cbCliente"
													class="select-size-xs" style="text-transform:uppercase;"
				                   onkeyup="javascript:this.value=this.value.toUpperCase();">
													 <option value=""></option>
			                     <?php
														$filas = $objVenta->Listar_Clientes();
														if (is_array($filas) || is_object($filas))
														{
														foreach ($filas as $row => $column)
														{
														?>
															<option value="<?php print ($column["idcliente"])?>">
															<?php print ($column["nombre_cliente"])?></option>
														<?php
															}
														}
														 ?>
												 </select>
											</div>

										</div>
									</div>


						    <div class="form-group">
									<div class="row">

										<div class="col-sm-6">
											<label>Seleccione la condicion de pago</label>
											<div class="checkbox checkbox-switchery switchery-sm">
												<label>
												<input type="checkbox" id="chkPagado" name="chkPagado"
												 class="switchery" checked="checked" >
												 <span id="lblchk2">AL CONTADO</span>
											   </label>
											</div>
										</div>

										<div id="div-cbEntrega" class="col-sm-6">
										 <label>Forma de Entrega</label>
											 <select id="cbEntrega" name="cbEntrega" data-placeholder="Seleccione metodo de pago..." class="select-icons">
													 <option value="1" data-icon="store">INMEDIATA</option>
													 <option value="2" data-icon="truck">POR PEDIDO</option>
											 </select>
										</div>


									</div>
								</div>

								</div>

								<div class="modal-footer">
									<button  type="reset" class="btn btn-default" id="reset"
									class="btn btn-link" data-dismiss="modal">Cerrar</button>
									<button type="submit" id="btnRegistrar" class="btn bg-info-800 btn-labeled"><b><i class="icon-printer4"></i>
									</b> Guardar e Imprimir</button>
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
<script type="text/javascript" src="web/custom-js/cotizacion.js"></script>
