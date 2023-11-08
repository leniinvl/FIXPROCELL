<?php

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";

		require_once($model);
		require_once($controller);
	});

	$fecha1 = isset($_GET['fecha1']) ? $_GET['fecha1'] : '';
	$fecha2 = isset($_GET['fecha2']) ? $_GET['fecha2'] : '';

	if($fecha1 == 'empty' && $fecha2 == 'empty'){
		$fecha1 = "";
		$fecha2 = "";
	} else {
		$fecha1 = DateTime::createFromFormat('d/m/Y', $fecha1)->format('Y-m-d');
		$fecha2 = DateTime::createFromFormat('d/m/Y', $fecha2)->format('Y-m-d');
	}

	$objEmpleado =  new Usuario();

	$range = 0;
	if($fecha1 <= $fecha2){
		$range= ((strtotime($fecha2) - strtotime($fecha1))+(24*60*60)) /(24*60*60);
		if($range>365){
			echo " <div class='panel-body'>
						<p class='alert alert-danger'>El Rango Maximo es 31 Dias.</p>
				   </div>";
			exit(0);
		}
	}else{
		echo "<div class='panel-body'
				<p class='alert alert-danger'>Rango de fechas invalido!</p>
			  </div>";
		exit(0);
	}

	$empleado = $objEmpleado->Listar_Empleados();
	if(isset($empleado)){
		// si hay usuarios
?>

<style type="text/css">         
    div.scrollmenu {
		background-color: #FDFEFE;
		overflow: auto;
		white-space: nowrap;
	}
</style>	

<div class="panel-body">
		<div class="panel-heading" style="background-color: #F4F6F6;">
			<h5><b>Lista de Asistencia</b></h5>
			<b>A</b>=Asistencia   <b>R</b>=Retrasado   <b>J</b>=Justificado   <b>F</b>=Falta
		</div>
		
		<div class="scrollmenu">

				<table class="table table-bordered table-hover">
					<thead>
						<th><b>EMPLEADO</b></th>
							<?php for($i=0;$i<$range;$i++):?>
						<th>
							<b><?php echo date("d-M",strtotime($fecha1)+($i*(24*60*60)));?></b>
						</th>
							<?php endfor;?>
						<th><b>RESUMEN</b></th>	
					</thead>
						<?php
						foreach($empleado as $row => $column){
							$values = array(""=>"Sin seleccion","1"=>"Asistencia","2"=>"Falta","3"=>"Retardo","4"=>"Justificacion");
							$A=0;
							$R=0;
							$J=0;
							$F=0;
							?>
							<tr>
								<td style="width:250px;"><?php echo $column["nombre_empleado"]." ".$column["apellido_empleado"]; ?></td>
									<?php for($i=0;$i<$range;$i++):
										$date_at= date("Y-m-d",strtotime($fecha1)+($i*(24*60*60)));
										$asistencia = $objEmpleado->Consulta_asistencia($column["idempleado"], $date_at);
									?>
								<td style="text-align: center; width:2px; padding: 0px;">
									<?php
										if(isset($asistencia)){
											if($asistencia==1){ $A++; echo "<i class='icon-checkmark'></i>"; }
											else if($asistencia==2){ $F++; echo "<b>F</b>"; }
											else if($asistencia==3){ $R++; echo "<b>R</b>"; }
											else if($asistencia==4){ $J++; echo "<b>J</b>"; }
										}
									?>
								</td>
									<?php endfor; ?>
								<td>
									<?php echo "<b>A</b>=".$A."  <b>R</b>=".$R."  <b>J</b>=".$J."  <b>F</b>=".$F."  (".$column["nombre_empleado"].")" ?>
								</td>
							</tr>
						<?php

						}
				echo "</table>";

			}else{
				echo "<div class='panel-body'>
						<p class='alert alert-danger'>No hay Grupos</p>
						</div>";
			}
			?>
		</div>
</div>
<script type="text/javascript" src="web/custom-js/asistenciareporte.js"></script>
