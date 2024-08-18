<?php

	$objCliente =  new Cliente();

?>

			<!-- Basic initialization -->
			<div class="panel panel-flat">

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a href="?View=Inicio"><i class="icon-home2 position-left"></i> Inicio</a></li>
						<li><a href="javascript:;">Ventas</a></li>
						<li class="active">Clientes</li>
					</ul>
				</div>

				<div class="panel-heading">
					<h5 class="panel-title">Gestión Clientes</h5>

					<div class="heading-elements">
						<button type="button" class="btn btn-info heading-btn"
						onclick="newCliente()">
						<i class="icon-database-add"></i> Agregar Nuevo/a</button>

						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<i class="icon-printer2 position-left"></i> Imprimir Reporte
							<span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-right">
								<li><a id="print_activos" href="javascript:void(0)"
								><i class="icon-file-pdf"></i> Clientes Activos</a></li>
								<li class="divider"></li>
								<li><a id="print_inactivos" href="javascript:void(0)">
								<i class="icon-file-pdf"></i> Clientes Inactivos</a></li>
							</ul>
						</div>

					</div>
				</div>

				<div class="panel-body">
					<div id="reload-div">
						<table class="table datatable-basic table-xxs table-hover">
							<thead>
								<tr>
									<th><b>Código</b></th>
									<th><b>Nombre de Cliente</b></th>
									<th><b>Cédula/RUC</b></th>
									<th><b>Telefono</b></th>
									<th><b>Email</b></th>
									<th><b>Tipo</b></th>
									<th><b>Estado</b></th>
									<th class="text-center"><b>Opciones</b></th>
								</tr>
							</thead>

							<tbody>

							<?php
									$filas = $objCliente->Listar_Clientes();
									if (is_array($filas) || is_object($filas))
									{
									foreach ($filas as $row => $column)
									{
									?>
										<tr>
											<td><?php print($column['codigo_cliente']); ?></td>
											<td><?php print($column['nombre_cliente']); ?></td>
											<td><?php print($column['numero_nit']); ?></td>
											<td><?php print($column['numero_telefono']); ?></td>
											<td><?php print($column['email']); ?></td>
											<td><?php if($column['giro'] == 'CLIENTE NORMAL')
												echo '<span class="label label-success label-rounded"><span
												class="text-bold">CLIENTE NORMAL</span></span>';
												else
												echo '<span class="label label-warning label-rounded">
											<span
												class="text-bold">CLIENTE FAVORITO</span></span>'
											?></td>
											<td><?php if($column['estado'] == '1')
												echo '<span class="label label-success label-rounded"><span
												class="text-bold">ACTIVO</span></span>';
												else
												echo '<span class="label label-default label-rounded">
											<span
												class="text-bold">INACTIVO</span></span>'
											?></td>
											<td class="text-center">
											<ul class="icons-list">
												<li class="dropdown">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>

													<ul class="dropdown-menu dropdown-menu-right">
														<li><a
														href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
														onclick="openCliente('editar',
														'<?php print($column["idcliente"]); ?>',
														'<?php print($column["codigo_cliente"]); ?>',
														'<?php print($column["nombre_cliente"]); ?>',
														'<?php print($column["numero_nit"]); ?>',
																			'<?php print($column["numero_nrc"]); ?>',
														'<?php print($column["direccion_cliente"]); ?>',
														'<?php print($column["numero_telefono"]); ?>',
														'<?php print($column["email"]); ?>',
																			'<?php print($column["giro"]); ?>',
																			'<?php print($column["limite_credito"]); ?>',
														'<?php print($column["estado"]); ?>')">
													<i class="icon-pencil6">
													</i> Editar</a></li>
														<li><a
														href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
														onclick="openCliente('ver',
																			'<?php print($column["idcliente"]); ?>',
																			'<?php print($column["codigo_cliente"]); ?>',
																			'<?php print($column["nombre_cliente"]); ?>',
																			'<?php print($column["numero_nit"]); ?>',
																			'<?php print($column["numero_nrc"]); ?>',
																			'<?php print($column["direccion_cliente"]); ?>',
																			'<?php print($column["numero_telefono"]); ?>',
																			'<?php print($column["email"]); ?>',
																			'<?php print($column["giro"]); ?>',
																			'<?php print($column["limite_credito"]); ?>',
																			'<?php print($column["estado"]); ?>')">
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
					</div>
				</div>	
			</div>

			<!-- Iconified modal -->
				<div id="modal_iconified" class="modal fade">
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
												<label>Tipo <span class="text-danger">*</span></label>
												<!--	<input type="text" id="txtGiro" name="txtGiro" placeholder="EJEMPLO:"
													 class="form-control" style="text-transform:uppercase;"
	                         						onkeyup="javascript:this.value=this.value.toUpperCase();"> -->

												<select  data-placeholder="Seleccione un tipo..." id="txtGiro" name="txtGiro"
													class="select-search" style="text-transform:uppercase;"
													onkeyup="javascript:this.value = this.value.toUpperCase();">
													<option selected value="CLIENTE NORMAL"> CLIENTE NORMAL</option>
													<option value="CLIENTE FAVORITO"> CLIENTE FAVORITO</option>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-12">
												<label>Nombre Cliente o Empresa <span class="text-danger">*</span></label>
												<input type="text" id="txtNombre" name="txtNombre" placeholder="EJEMPLO: FRANCISCO AVALOS"
												 class="form-control" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label>Cédula/RUC <span class="text-danger"> * </span></label>
												<input type="text" id="txtNIT" name="txtNIT" placeholder="EJEMPLO: 1725885641"
												 class="form-control" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
											<div class="col-sm-6">
												<label>Teléfono</label>
												<input type="text" id="txtTelefono" name="txtTelefono" placeholder="EJEMPLO: 0960660665"
												 class="form-control" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label>Email</label>
												<input type="email" id="txtEmail" name="txtEmail" placeholder="EJEMPLO: franavalos@hotmail.com"
												 class="form-control">
											</div>
											<div class="col-sm-6">
												<label>Limite Crédito Venta <span class="text-danger">*</span></label>
												<input type="text" id="txtLimitC" name="txtLimitC" placeholder="100.00"
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
												<input type="text" id="txtNRC" name="txtNRC" placeholder="EJEMPLO: 1725885641001"
												 class="form-control" style="text-transform:uppercase;"
																						onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>
									<!-- hidden -->  

									<div class="form-group">
										<div class="row">
											<div class="col-sm-12">
												<label>Direccion</label>
												 <textarea rows="2" class="form-control"
													placeholder="EJEMPLO: LIBERTAD OE1-20 Y RESTAURACION"
													id="txtDireccion" name="txtDireccion"
													value="" style="text-transform:uppercase;"
													onkeyup="javascript:this.value=this.value.toUpperCase();">
													</textarea>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-8">
												<div class="checkbox checkbox-switchery switchery-sm">
													<label>
													<input type="checkbox" id="chkEstado" name="chkEstado"
													 class="switchery" checked="checked" >
													 <span id="lblchk">ACTIVO</span>
												   </label>
												</div>
											</div>
										</div>
									</div>

								</div>

								<div class="modal-footer">
									<button id="btnGuardar" type="submit" class="btn btn-info">Guardar</button>
									<button id="btnEditar" type="submit" class="btn btn-warning">Editar</button>
									<button  type="reset" class="btn btn-default" id="reset"
									class="btn btn-link" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="web/custom-js/cliente.js"></script>
