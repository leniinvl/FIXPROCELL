<?php

	$objColor =  new Color();
	if($tipo_usuario==1){
?>

			<!-- Basic initialization -->
			<div class="panel panel-flat">
				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a href="?View=Inicio"><i class="icon-home2 position-left"></i> Inicio</a></li>
						<li><a href="javascript:;">Bodega</a></li>
						<li class="active"> Color de Productos</li>
					</ul>
				</div>
					<div class="panel-heading">
						<h5 class="panel-title">Color de Productos</h5>

						<div class="heading-elements">
							<button type="button" class="btn btn-primary heading-btn"
							onclick="newColor()">
							<i class="icon-database-add"></i> Agregar Nuevo/a</button>

					<!--
							<button type="button" id="print_marca" class="btn btn-info heading-btn">
							<i class="icon-file-pdf"></i> Imprimir Reporte</button>
					-->
						</div>
					</div>
					<div class="panel-body">
					</div>
					<div id="reload-div">
					<table class="table datatable-basic table-xxs table-hover">
						<thead>
							<tr>
								<th><b>No</b></th>
								<th><b>Color</b></th>
								<th class="text-center"><b>Opciones</b></th>
							</tr>
						</thead>

						<tbody>

						  <?php
								$filas = $objColor->Listar_Colores();
								if (is_array($filas) || is_object($filas))
								{
								foreach ($filas as $row => $column)
								{
								?>
									<tr>
					                	<td><?php print($column['idcolor']); ?></td>
					                	<td><?php print($column['nombre_color']); ?></td>
					                	<td class="text-center">
											<ul class="icons-list">
												<li class="dropdown">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>

													<ul class="dropdown-menu dropdown-menu-right">
														<li><a
															href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
															onclick="openColor('editar',
															'<?php print($column["idcolor"]); ?>',
															'<?php print($column["nombre_color"]); ?>')">
															<i class="icon-pencil6">
														</i> Editar</a></li>

														<li><a
															href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
															onclick="openColor('ver',
															'<?php print($column["idcolor"]); ?>',
															'<?php print($column["nombre_color"]); ?>')">
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
						                los campos remarcados con <span class="text-danger"> * </span> son necesarios.
						                <button type="button" class="close" data-dismiss="alert">×</button>
						                <input type="hidden" id="txtID" name="txtID" class="form-control" value="">
                                      	<input type="hidden" id="txtProceso" name="txtProceso" class="form-control" value="">
						           </div>

									<div class="form-group">
										<div class="row">
											<div class="col-sm-8">
												<label>Color <span class="text-danger">*</span></label>
												<input type="text" id="txtColor" name="txtColor" placeholder="EJEMPLO: GREEN"
												 class="form-control" style="text-transform:uppercase;"
                                        		onkeyup="javascript:this.value=this.value.toUpperCase();">
											</div>
										</div>
									</div>

								</div>

								<div class="modal-footer">
									<button id="btnGuardar" type="submit" class="btn btn-primary">Guardar</button>
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
<script type="text/javascript" src="web/custom-js/color.js"></script>

<?php } else { ?>

	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">

				<!-- Widget with rounded icon -->
				<div class="panel">
					<div class="panel-body text-center">
						<div class="icon-object border-danger-400 text-primary-400"><i class="icon-lock5 icon-3x text-danger-400"></i>
						</div>
						<h2 class="no-margin text-semibold"> SU USUARIO NO POSEE PERMISOS SUFICIENTES </h2>
						<span class="text-uppercase text-size-mini text-muted">Su usuario no posee los permisos respectivos
						para poder accesar a este modulo. Lo invitamos a dar click </span> <a href="./?View=Inicio">AQUI</a> <br><br>

					</div>
				</div>
				<!-- /widget with rounded icon -->
			</div>
		</div>

<?php } ?>
