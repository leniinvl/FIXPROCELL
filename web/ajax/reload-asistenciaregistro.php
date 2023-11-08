<?php

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	});

	$fecha1 = isset($_GET['fecha1']) ? $_GET['fecha1'] : '';

	if($fecha1 == 'empty'){
		$fecha1 = "";
	} else {
		$fecha1 = DateTime::createFromFormat('d/m/Y', $fecha1)->format('Y-m-d');
	}

	$objEmpleado =  new Usuario();

	$empleado = $objEmpleado->Listar_Empleados();
	if(isset($empleado)){
		// si hay usuarios
?>


<div class="panel-body">
		<div class="box box-primary">
			<table class="table table-bordered table-hover">
				<thead>
					<th><b>EMPLEADO</b></th>
					<th><b>TIPO DE ASISTENCIA</b></th>
				</thead>
			<?php
			foreach($empleado as $row => $column){
				$asistencia = $objEmpleado->Consulta_asistencia($column["idempleado"], $fecha1);
				$values = array(""=>"Seleccione una accion","1"=>"Asistencia","2"=>"Falta","3"=>"Retardo","4"=>"Justificacion");
			?>
				<tr>
					<td style="width:250px;"><?php echo $column["nombre_empleado"]." ".$column["apellido_empleado"]; ?></td>

					<td >
						<form id="form-<?php echo $column["idempleado"]; ?>">
							<input type="hidden" name="empleado_id" value="<?php echo $column["idempleado"]; ?>">
							<input type="hidden" name="fecha_registro" value="<?php echo $fecha1; ?>">
							<select class="form-control input-sm"  name="tipo" id="select-<?php echo $column["idempleado"]; ?>">
								<?php foreach($values as $k=>$v):?>
									<option value="<?php echo $k; ?>"  <?php if($asistencia!=null && $asistencia==$k){ echo "selected"; }?>> <?php echo $v;?> </option>
								<?php endforeach; ?>
							</select>
						</form>
				
						<script>
							$("#select-<?php echo $column["idempleado"]; ?>").change(function(){
								
								$.post("web/ajax/ajxasistencia.php",$("#form-<?php echo $column["idempleado"]; ?>").serialize(), function(data){
									console.log(data);
									swal({
										title: "",
										timer: 800,
										text: "Asistencia registrada",
										confirmButtonColor: "#66BB6A",
										type: "success"
									});
								});

							});
						</script>
					</td>

				</tr>
			<?php
			}

			echo "</table></div>";

		}else{
			echo "<p class='alert alert-danger'>No hay Grupos</p>";
		}
		?>
</div>
<script type="text/javascript" src="web/custom-js/asistenciaregistro.js"></script>
