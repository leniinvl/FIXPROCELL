<?php 

	session_set_cookie_params(60*60*24*365); session_start();
	$idsucursal = $_SESSION['sucursal_id'];

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";
	
		require_once($model);
		require_once($controller);
	});

	$fecha1 = isset($_GET['fecha1']) ? $_GET['fecha1'] : '';
	$fecha2 = isset($_GET['fecha2']) ? $_GET['fecha2'] : '';
	if($fecha1 == 'empty' && $fecha2 == 'empty'){

		$fecha1 = '';
		$fecha2 = '';

	} else {

		$fecha1 = DateTime::createFromFormat('d/m/Y', $fecha1)->format('Y-m-d');
		$fecha2 = DateTime::createFromFormat('d/m/Y', $fecha2)->format('Y-m-d');
	}

	
	$objCaja =  new Caja();

 ?>
	<table class="table datatable-basic table-xxs table-hover">
		<thead>
			<tr>
				<th><b>Fecha Apertura</b></th>
				<th><b>Monto Apertura</b></th>
				<th><b>Monto Cierre</b></th>
				<th><b>Fecha Cierre</b></th>
				<th><b>Estado</b></th>
				<th class="text-center"><b>Opciones</b></th> 
			</tr>
		</thead>

		<tbody>

		  <?php 
				$filas = $objCaja->Listar_Historico($fecha1,$fecha2,$idsucursal); 
				if (is_array($filas) || is_object($filas))
				{
				foreach ($filas as $row => $column) 
				{

					$fecha_apertura = $column["fecha_apertura"];
					if(is_null($fecha_apertura))
					{
						$envio_date = '';

					} else {

					$envio_date = DateTime::createFromFormat('Y-m-d H:i:s',$fecha_apertura)->format('d/m/Y H:i:s');

					}

					$fecha_cierre = $column["fecha_cierre"];
					if(is_null($fecha_cierre))
					{
						$envio_date2 = '';

					} else {

					$envio_date2 = DateTime::createFromFormat('Y-m-d H:i:s',$fecha_cierre)->format('d/m/Y H:i:s');

					}

				?>
					<tr>
	                	<td><?php print($envio_date); ?></td>
	                	<td><?php print($column['monto_apertura']); ?></td>
	                	<td><?php print($column['monto_cierre']); ?></td>
	                	<td><?php print($envio_date2 ); ?></td>
	                	<td><?php if($column['estado'] == '1')
								echo '<span class="label label-success label-rounded"><span 
								class="text-bold">ABIERTA</span></span>';
	                		else 
								echo '<span class="label label-info label-rounded">
								<span 
								class="text-bold">CERRADA</span></span>'
		                ?></td>
	                	<td class="text-center">
							<?php if($column['estado']=='1'){ ?>
							<ul class="icons-list">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="icon-menu9"></i>
									</a>

									<ul class="dropdown-menu dropdown-menu-right">
										<li><a id="delete_product" 	
										data-id="<?php print($column['idcaja']); ?>" 
										href="javascript:void(0)">
										<i class="icon-safe">
										</i> Cerrar</a></li>
									</ul>
								</li>
							</ul>
							<?php } ?>
						</td>
	                </tr>
				<?php  
				}
			}
			?>
		
		</tbody>
	</table>

<script type="text/javascript" src="web/custom-js/hcaja.js"></script>
