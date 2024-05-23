<?php
	$idsucursalfilter = $_SESSION['sucursal_id'];
	$categoria = "CELULAR";
	$objProducto =  new Producto();
?>

			<!-- Basic initialization -->
			<div class="panel panel-flat">
				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a href="?View=Inicio"><i class="icon-home2 position-left"></i> Inicio</a></li>
						<li><a href="?View=Producto">Productos</a></li>
						<li class="active">Codificación</li>
					</ul>
				</div>
					<div class="panel-heading">
						<h5 class="panel-title">Codificación USSD</h5>

						<div class="heading-elements">
							<button type="button" class="btn btn-info heading-btn"
							onclick="newCodigo()">
							<i class="icon-database-add"></i> Agregar Nuevo/a</button>
						</div>
					</div>
					<div class="panel-body">
						<div id="reload-div">
							<table class="table datatable-basic table-xxs table-hover">
								<thead>
									<tr>
										<th><b>Código</b></th>
										<th><b>IMEI</b></th>
										<th><b>Nombre Equipo</b></th>
										<th><b>Detalle</b></th>
										<th><b>Registro</b></th>
										<th><b>Establecimiento</b></th>
										<th class="text-center"><b>Opciones</b></th>
									</tr>
								</thead>

								<tbody>

								<?php 
										$filas = $objProducto->Listar_CodigoProducto();
										if (is_array($filas) || is_object($filas))
										{
										foreach ($filas as $row => $column)
										{
											
										$idsucursal = $column['idsucursal'];
										$nombre_sucursal = $column['sucursal'];
										
											$print_sucursal = '<span class="label label-success label-rounded"><span
												class="text-bold">'.$nombre_sucursal.'</span></span>';
										if ($idsucursal == 2) {
											$print_sucursal = '<span class="label label-info label-rounded"><span
												class="text-bold">'.$nombre_sucursal.'</span></span>';
										}elseif ($idsucursal == 3) {
											$print_sucursal = '<span class="label label-warning label-rounded"><span
												class="text-bold">'.$nombre_sucursal.'</span></span>';
										}elseif ($idsucursal == 4) {
											$print_sucursal = '<span class="label label-primary label-rounded"><span 
												class="text-bold">'.$nombre_sucursal.'</span></span>';
										}elseif ($idsucursal == 5) {
											$print_sucursal = '<span class="label label-default label-rounded">
												<span class="text-bold">'.$nombre_sucursal.'</span></span>';
										}elseif ($idsucursal == 6) {
											$print_sucursal = '<span class="label label-danger label-rounded">
												<span class="text-bold">'.$nombre_sucursal.'</span></span>';
										}

										?>
											<tr>
												<td><?php print($column['idcodigo']); ?></td>
												<td><?php print($column['codigo_uno']); ?></td>
												<td><?php print($column['producto']); ?></td>
												<td><?php print($column['codigo_dos']); ?></td>
												<td><?php print($column['fecha_registro']); ?></td>
												<td><?php print($print_sucursal); ?></td>
												<td class="text-center">
												<ul class="icons-list">
													<li class="dropdown">
														<a href="#" class="dropdown-toggle" data-toggle="dropdown">
															<i class="icon-menu9"></i>
														</a>

														<ul class="dropdown-menu dropdown-menu-right">
														<?php if($idsucursalfilter == $idsucursal){ ?>	
															<li><a
															href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
															onclick="openParametro('editar',
															'<?php print($column["idcodigo"]); ?>',
															'<?php print($column["codigo_uno"]); ?>',
															'<?php print($column["codigo_dos"]); ?>',
															'<?php print($column["idproducto"]); ?>')">
														<i class="icon-pencil6">
														</i> Editar</a></li>
														<?php }?>
															<li><a
															href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
															onclick="openParametro('ver',
															'<?php print($column["idcodigo"]); ?>',
															'<?php print($column["codigo_uno"]); ?>',
															'<?php print($column["codigo_dos"]); ?>',
															'<?php print($column["idproducto"]); ?>')">
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
										<br><span> Ingresar : puede ingresar varios codigos separados por coma ( , ).</span>
										<br><span> Actualizar : solo puede editar un codigo por producto.</span>
						                <button type="button" class="close" data-dismiss="alert">×</button>
						                <input type="hidden" id="txtID" name="txtID" class="form-control" value="">
                                      	<input type="hidden" id="txtProceso" name="txtProceso" class="form-control" value="">
						           </div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-12">
												<label>Equipo<span class="text-danger">*</span></label>
												<select  data-placeholder="Seleccione una equipo..." id="cbEquipo" name="cbEquipo"
														class="select-search" style="text-transform:uppercase;"
														onkeyup="javascript:this.value = this.value.toUpperCase();">
															<?php
															$filas = $objProducto->Listar_Productos_Categoria($idsucursalfilter, $categoria);
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
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-12">
												<label>IMEI<span class="text-danger">*</span></label>
												<input type="text" id="txtImei1" name="txtImei1" placeholder="EJEMPLO: 102012000123891, 188552000123893, 1899952000123111"
												class="form-control" style="text-transform:uppercase; width: 100%; height: 50px;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label>Detalle estado</label>
												<input type="text" id="txtImei2" name="txtImei2" placeholder="EJEMPLO: VENDIDO / ALMACEN"
												 class="form-control" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
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
<script type="text/javascript" src="web/custom-js/codigo.js"></script>

