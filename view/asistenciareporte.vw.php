<?php



 ?>

			<!-- Labels -->
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-flat">
						<div class="breadcrumb-line">
							<ul class="breadcrumb">
								<li><a href="?View=Inicio"><i class="icon-home2 position-left"></i> Inicio</a></li>
								<li><a href="javascript:;">Usuarios</a></li>
								<li class="active">Reporte de asistencia</li>
							</ul>
						</div>
						<div class="panel-heading">
							<h6 class="panel-title">Asistencia de Empleados</h6>

							<div class="row">
								 <div class="col-sm-6 col-md-5">
								 	<form role="form" autocomplete="off" class="form-validate-jquery" id="frmSearch">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-5">
													<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar3"></i></span>
													<input type="text" id="txtF1" name="txtF1" placeholder=""
													 class="form-control input-sm" style="text-transform:uppercase;"
							                		onkeyup="javascript:this.value=this.value.toUpperCase();">
							                		</div>
												</div>
												<div class="col-sm-5">
													<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar3"></i></span>
													<input type="text" id="txtF2" name="txtF2" placeholder=""
													 class="form-control input-sm" style="text-transform:uppercase;"
							                		onkeyup="javascript:this.value=this.value.toUpperCase();">
							                		</div>
												</div>
												<div class="col-sm-2">
													<button style="margin-top: 0px;" id="btnGuardar"
													type="submit" class="btn btn-primary btn-sm">
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
								<div id="data">
									<p class="alert alert-success">No hay datos, por favor selecciona un rango de fechas.</p>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<!-- /labels -->

<script type="text/javascript" src="web/custom-js/asistenciareporte.js"></script>
