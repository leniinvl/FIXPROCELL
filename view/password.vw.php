<?php
	$usuario_login = $_SESSION['user_name'];
?>

			<!-- Basic initialization -->
			<div class="panel panel-flat">
				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a href="?View=Inicio"><i class="icon-home2 position-left"></i> Inicio</a></li>
						<li class="active">Cambiar contraseña</li>
					</ul>
				</div>
					<div class="panel-heading">
						<h5 class="panel-title">Cambiar contraseña</h5>
					</div>

					<div class="panel-body">
						<div id="reload-div">

							<div class="modal-body col-sm-4">
							 <!-- Password recovery -->
								<form id="frmResend" role="form" autocomplete="off" class="form-validate-jquery">
									<div class="panel panel-body">
										
										<div class="text-center">
											<div class="icon-object border-info text-info"><i class=" icon-user-lock"></i></div>
											<h5 class="content-group">Restaurar Contraseña <small class="display-block">Ingrese su nueva contraseña  <i class="icon-eye-blocked" id="viewPassword"></i></small></h5>
										</div>

										<div class="form-group has-feedback">
											<label>Usuario</label>
											<input type="text" id="usernamer" name="usernamer" value="<?php echo $usuario_login?>" class="form-control" readonly disabled="disabled">
											<div class="form-control-feedback">
												<i class="icon-user text-muted"></i>
											</div>
										</div>

										<div class="form-group has-feedback">
											<label>Nueva contraseña <span class="text-danger">*</span></label>
											<input type="password" id="passwordr" name="passwordr" class="form-control" placeholder="Ingresar contraseña">
											<div class="form-control-feedback">
												<i class="icon-spell-check text-muted"></i>
											</div>
										</div>

										<div class="form-group has-feedback">
											<label>Repita contraseña <span class="text-danger">*</span></label>
											<input type="password" id="rpasswordr" name="rpasswordr" class="form-control" placeholder="Repetir contraseña">
											<div class="form-control-feedback">
												<i class="icon-spell-check text-muted"></i>
											</div>
										</div>

										<div class="text-center">
											<button type="reset" id="cancelPass" class="btn bg-orange">Cancelar<i class="icon-cross position-right"></i></button>
											<button type="submit" class="btn bg-info">Restaurar<i class="icon-checkmark position-right"></i></button>
										</div>
											
									</div>
								</form>
								<!-- /password recovery -->
							</div>

						</div>
					</div>
				</div>
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
<script type="text/javascript" src="web/custom-js/password.js"></script>

