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

?>
			 <div class="row">
				 <div class="col-md-12 col-lg-12">
			      	<!-- Detalle de Compra -->
						<div class="panel panel-success">
							<div class="panel-heading">
								<h3 class="panel-title"><b>SISTEMA DE VENTAS</b></h3>
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

										<!-- Check oculto --> 
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
							<div class="panel-heading" style="background-color:#1B2631;">
								<h4 class="panel-title"><h1 id="big_total" class="panel-title text-center text-black text-green"
									style="font-size:42px;">0.00</h1></h4>
							</div>

							<div class="panel-body" style="background-color:#EAECEE;">
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-barcode2"></i></span>
												<input type="text" id="buscar_producto" name="buscar_producto"  placeholder="BUSCAR..."
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
												<th></th>
												<th class="text-center">PRODUCTO</th>
												<th class="text-center">CANTIDAD</th>
												<th class="text-center">PRECIO</th>
												<th class="text-center">PRECIO FINAL</th>	<!-- DESCUENTOS 12MAY2023-->
												<th class="text-center">EXENTO IVA</th>
												<th class="text-center">DESCUENTO</th>
												<th class="text-center">AGREGADO</th>
												<th class="text-center">IMPORTE</th>
												<!--1 <th class="text-center text-bold">Vence</th>-->
												<th class="text-center">ELIMINAR</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
										<tfoot id="totales_foot">
											<tr class="bg-info-800">
												<td align="center" width="10%"></td>
												<td align="center" width="30%"></td> 		<!-- DESCUENTOS 12MAY2023-->
												<td align="center" width="10%">TARIFA 12%</td>
												<td align="center" width="10%">IVA 12%</td>
												<td align="center" width="10%">SUBTOTAL</td>
												<!--1 <td align="center" width="10%">RET. (-)</td> -->
												<td align="center" width="13%">TARIFA 0%</td>
												<td align="center" width="10%">DESCUENTO</td>
												<td align="center" width="10%">TOTAL</td>
												<td align="center" width="20%"><b><i class="icon-cash3"></i></b></td>
												<td align="center" width="20%"><b><i class="icon-cancel-circle2"></i></b></td>
												
											</tr>
											<tr>
												<td align="center" id=""></td>		<!-- DESCUENTOS 12MAY2023-->
												<td align="center" id="agredado"></td>
												<td align="center" id="sumas"></td>
												<td align="center" id="iva"></td>
												<td align="center" id="subtotal"></td>
												<!--1 <td align="center" id="ivaretenido"></td> -->
												<td align="center" id="exentas"></td>
												<td align="center" id="descuentos"></td>
												<td align="center" id="total"></td>
												<td align="center"><button type="button" id="btnguardar" data-toggle="modal" data-target="#modal_iconified_cash"
												class="btn bg-success-700 btn-sm ">&nbsp Cobrar &nbsp</button></td>
												<td align="center"><button type="submit" id="btncancelar" class="btn bg-danger-700 btn-sm">
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
								<h5 class="modal-title"><i class="icon-cash"></i> &nbsp; <span class="title-form">TERMINAR VENTA</span></h5>
							</div>

					    <form role="form" autocomplete="off" class="form-validate-jquery" id="frmPago">
								<div class="modal-body" id="modal-container">

									<div class="form-group">
										<div class="row">
											
											<div class="col-sm-1">
												<label> &nbsp; </label>	
												<button type="button" class="btn btn-default" id="addUser" name="addUser" class="btn btn-link"> 
													<b><i class="icon-user-plus"></i></b> 
												</button>
											</div>

											<div class="col-sm-8">
												<label>Seleccione el Cliente<span class="text-danger"> * </span></label>
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
															<?php print ($column["numero_nit"].' - '.
															 $column["nombre_cliente"])?></option>
														<?php
															}
														}
														 ?>
												 </select>
											</div>

											<div class="col-sm-3">
													<label>Cupo Crédito <span class="text-danger"></span></label>
														<div class="input-group">
														<span class="input-group-addon"><i class="icon-cash3"></i></span>
														<input type="text" id="txtLimitC" name="txtLimitC" placeholder="0.00"
														 class="form-control" style="text-transform:uppercase;"
															onkeyup="javascript:this.value=this.value.toUpperCase();" readonly="readonly" disabled="disabled">
														</div>
												</div>

										</div>
									</div>


						    <div class="form-group">
									<div class="row">

										<div class="col-sm-6">
											<label>Seleccione comprobante de Venta</label>
											<select  data-placeholder="..." id="cbCompro" name="cbCompro"
												class="select-size-xs" style="text-transform:uppercase;"
												onkeyup="javascript:this.value=this.value.toUpperCase();">
																				<?php
													$filas = $objVenta->Listar_Comprobantes($idsucursal);
													if (is_array($filas) || is_object($filas))
													{
													foreach ($filas as $row => $column)
													{
													?>
														<option value="<?php print ($column["idcomprobante"])?>">
														<?php print ($column["nombre_comprobante"])?></option>
													<?php
														}
													}
													 ?>
											 </select>
										</div>

									</div>
								</div>

								<div class="form-group">
									
									<div class="col-sm-6">
										<label>Seleccione el tipo de venta</label>
										<div class="checkbox checkbox-switchery switchery-sm">
											<label>
											<input type="checkbox" id="chkPagado" name="chkPagado"
												class="switchery" checked="checked" >
												<span id="lblchk2">VENTA AL CONTADO</span>
											</label>
										</div>
									</div>
										<div class="row">
										<div id="div-cbMPago" class="col-sm-6">
										 <label>Metodo de Pago</label>
											 <select id="cbMPago" name="cbMPago" data-placeholder="Seleccione un metodo de pago..." class="select-icons">
													 <option value="1" data-icon="cash">EFECTIVO</option>
													 <option value="2" data-icon="credit-card">TRANSFERENCIA</option>
													 <option value="3" data-icon="cash4">EFECTIVO Y TRANSFERENCIA</option>
											 </select>
										</div>
									</div>
								</div>


								<div class="form-group">
									<div class="row">
											<div class="col-sm-4">
													<label>A Pagar <span class="text-danger"> * </span></label>
													<div class="input-group">
													<span class="input-group-addon"><i class="icon-cash3"></i></span>
													<input type="text" id="txtDeuda" name="txtDeuda" placeholder="0.00"
													 class="form-control input-sm" style="text-transform:uppercase;"
			                     onkeyup="javascript:this.value=this.value.toUpperCase();"
													 readonly="readonly" disabled="disabled">
			                 	</div>
											</div>

										<div id="div-txtMonto" class="col-sm-4">
											<label>Efectivo Recibido <span class="text-danger"> * </span></label>
											<input type="text" id="txtMonto" name="txtMonto" placeholder="0.00"
											 class="form-control input-sm" style="text-transform:uppercase;"
	                     onkeyup="javascript:this.value=this.value.toUpperCase();">
										</div>

											<div id="div-txtCambio" class="col-sm-4">
													<label>Cambio <span class="text-danger"> * </span></label>
													<div class="input-group">
													<span class="input-group-addon"><i class="icon-cash"></i></span>
													<input type="text" id="txtCambio" name="txtCambio" placeholder="0.00"
													 class="form-control input-sm" style="text-transform:uppercase;"
		                  		onkeyup="javascript:this.value=this.value.toUpperCase();"
													readonly="readonly" disabled="disabled">
		                  </div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
											<div id="div-txtNoTarjeta" class="col-sm-6">
													<label> Nro. Comprobante <span class="text-danger"> * </span></label>
													<div class="input-group">
													<span class="input-group-addon"><i class="icon-credit-card"></i></span>
													<input type="text" id="txtNoTarjeta" name="txtNoTarjeta" placeholder="00121482254"
													 class="form-control input-sm" style="text-transform:uppercase;"
													 onkeyup="javascript:this.value=this.value.toUpperCase();">
												</div>
											</div>

											<div id="div-txtHabiente" class="col-sm-6">
													<label> Tipo de Banco <span class="text-danger"> * </span></label>
													<div class="input-group">
													<span class="input-group-addon"><i class="icon-user"></i></span>
													<input type="text" id="txtHabiente" name="txtHabiente" placeholder="Banco Pichincha"
													 class="form-control input-sm" style="text-transform:uppercase;"
													 onkeyup="javascript:this.value=this.value.toUpperCase();">
												</div>
											</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
											<div id="div-txtMontoTar" class="col-sm-5">
													<label> Monto Transferencia <span class="text-danger"> * </span></label>
													 <input type="text" id="txtMontoTar" name="txtMontoTar" placeholder="0.00"
													 class="touchspin-prefix" value="0" style="text-transform:uppercase;"
													 onkeyup="javascript:this.value=this.value.toUpperCase();">
												</div>
									</div>
								</div>
								
								<div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
											<textarea rows="2" class="form-control"
												placeholder="serie/código/IMEI/observación..." id="txtDescripcion" name="txtDescripcion"
												value="" style="text-transform:uppercase;"
												onkeyup="javascript:this.value=this.value.toUpperCase();">
											</textarea>
                                        </div>
                                    </div>
								</div>

								<div class="modal-footer">
									<button  type="reset" class="btn btn-default" id="reset"
									class="btn btn-link" data-dismiss="modal">Cerrar</button>
									<button onDblClick="disabled=true" type="submit" id="btnRegistrar" class="btn bg-success-800 btn-labeled"><b><i class="icon-printer4"></i>
									</b> Facturar e Imprimir</button>
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
								<h5 class="modal-title"><i class="icon-pencil7"></i> &nbsp; Registrar cliente </h5>
							</div>

					        <form role="form" autocomplete="off" class="form-validate-jquery" id="frmModal">
								<div class="modal-body" id="modal-container">

								<div class="alert alert-info alert-styled-left text-blue-800 content-group">
						                <span class="text-semibold">Estimado usuario</span>
						                los campos remarcados con <span class="text-danger"> * </span> son obligatorios.
						                <button type="button" class="close" data-dismiss="alert">×</button>
						                <input type="hidden" id="txtID" name="txtID" class="form-control" value="">
                          	<input type="hidden" id="txtProceso" name="txtProceso" class="form-control" value="">
						           </div>


						           <div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label>Codigo</label>
												<input type="text" id="txtCodigo" name="txtCodigo" placeholder="AUTOGENERADO"
												 class="form-control" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();" readonly="" disabled="disabled">
											</div>

											<div class="col-sm-6">
													<label>Tipo <span class="text-danger">* Requerido</span></label>
												<!--	<input type="text" id="txtGiro" name="txtGiro" placeholder="EJEMPLO:"
													 class="form-control" style="text-transform:uppercase;"
	                         						onkeyup="javascript:this.value=this.value.toUpperCase();"> -->

												<select  data-placeholder="Seleccione un tipo..." id="txtGiro" name="txtGiro"
													class="select-search2" style="text-transform:uppercase;"
													onkeyup="javascript:this.value = this.value.toUpperCase();">
													<option value="CLIENTE NORMAL"> CLIENTE NORMAL</option>
													<option value="CLIENTE FAVORITO"> CLIENTE FAVORITO</option>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-12">
												<label>Nombre Cliente / Empresa <span class="text-danger">* Requerido</span></label>
												<input type="text" id="txtNombre" name="txtNombre" placeholder="EJEMPLO: FRANCISCO MORALES / SMART MOVIL S.A."
												 class="form-control" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label>Cédula / RUC <span class="text-danger"> * Requerido </span></label>
												<input type="text" id="txtNIT" name="txtNIT" placeholder="EJEMPLO: 1725465045001"
												 class="form-control" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
											<div class="col-sm-6">
												<label>Teléfono</label>
												<input type="text" id="txtTelefono" name="txtTelefono" placeholder="EJEMPLO: 0961445569"
												 class="form-control" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label>Email <span class="text-danger"> * Requerido </span></label>
												<input type="email" id="txtEmail" name="txtEmail" placeholder="EJEMPLO: fraciscomorales@gmail.com"
												 class="form-control">
											</div>
											<div class="col-sm-6">
												<label>Limite Crédito Venta <span class="text-danger">*</span></label>
												<input type="text" id="txtC" name="txtC" placeholder="250.00"
												class="touchspin-prefix" value="0" style="text-transform:uppercase;"
												onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>
									<!-- hidden -->  
									<div class="form-group" style="visibility: hidden; height: 0px; margin: auto;">
										<div class="row" style="height: 0px;">
											<div class="col-sm-6" style="height: 0px;">
												<label>RUC</label>
												<input type="text" id="txtNRC" name="txtNRC" placeholder="EJEMPLO: 1725465045001"
												 class="form-control" style="text-transform:uppercase;"
																						onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>
									<!-- hidden -->  

									<div class="form-group">
										<div class="row">
											<div class="col-sm-12">
												<label>Direccion <span class="text-danger"> * Requerido </span></label>
												<input type="text" id="txtDireccion" name="txtDireccion" placeholder="EJEMPLO: AVENIDA NATALIA JARRIN, CAYAMBE"
												 class="form-control" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>

								</div>

								<div class="modal-footer">
									<button id="btnGuardarCliente" type="reset" class="btn btn-primary" data-dismiss="modal"> Guardar </button>
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
<script type="text/javascript" src="web/custom-js/new-venta.js"></script>
