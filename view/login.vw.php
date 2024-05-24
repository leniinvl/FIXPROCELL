
	<script type="text/javascript" src="web/custom-js/login.js"></script>
	<!-- /*CAMBIO FONDO LOGIN*/ -->
	<style type="text/css">
		body{
			background: linear-gradient(to left, #7C8B87, #3E7362, #245244, #030A08);
		}
		.select-search {
			height: 37px;
			line-height: 32px;
			border-radius: 3px ;
			border: 2.5px solid #ccc;
			padding-left: 4px;
			width: 100%;
			font-size: 14px;
			font-weight: bold;
		}
		.row {
			text-align: center;
		}
		label {
			text-align: center;
			color: #414141;
			font-size: 15px;
			font-weight: bold;
		}
	</style>	

<div class="panel-body">
	
<div class="row">

	<div class="col-sm-6">

		<!-- Form with validation -->
		<form autocomplete="off" action="" class="form-validate">
			<div class="panel panel-body login-form" style="width: 350px; background-color: #D3DEDC;">
				<div class="text-center">
					<h4 class="content-group"><b><?php echo COMPANY;?></b></h4>
					<img width="295" height="200"  src="./web/assets/images/acceso.png">
					<h5 class="content-group"> </h5>
				</div>

				<div class="form-group has-feedback has-feedback-center">
					<div class="row">
						<div class="col-sm-12">
							<!-- <label>Establecimiento:</label> -->
							<select  data-placeholder="Seleccionar establecimiento" id="nombre" name="nombre"
								class="select-search"
								onkeyup="javascript:this.value=this.value.toUpperCase();">
								<option value="" selected disabled> Seleccionar establecimiento </option>
								</div>
									<?php
										session_set_cookie_params(60*60*24*365);
										$objParametro =  new Sucursal(); 
										$filas = $objParametro->Listar_Sucursal();
											if (is_array($filas) || is_object($filas))
											{
											foreach ($filas as $row => $column)
											{
										?>
											<option value="<?php print ($column["idsucursal"])?>">
											<?php print ($column["nombre"])?>
											</option>
										<?php
											}
										}
									?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group has-feedback has-feedback-left">
					<input type="text" class="form-control" id="username" placeholder="Usuario" name="username" required="required">
					<div class="form-control-feedback">
						<i class="icon-user-check text-muted"></i>
					</div>
					<span id="error-user" class="label label-danger label-block"></span>
				</div> 

				<div class="form-group has-feedback has-feedback-left">
					<input type="password" class="form-control" id="password" placeholder="Contraseña" name="password" required="required">
					<div class="form-control-feedback">
						<i class="icon-lock5 text-muted"></i>
					</div>
				</div>

				<div class="form-group">
					<button type="submit" class="btn bg-success btn-block">Ingresar al sistema &nbsp; <i class="icon-key"></i></button>
				</div>
		</form>
		<!-- /form with validation -->

	</div>
</div>

<div class="row">
	<div class="col-sm-6">
			<?php
				echo '<img src="web/assets/images/initVenta.png" width="70%" class="img-responsive" alt="">';
			?>
	</div>
</div>

</div>