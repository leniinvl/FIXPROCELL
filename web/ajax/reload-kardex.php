<?php 

	session_set_cookie_params(60*60*24*365); session_start();
	$idsucursal = $_SESSION['sucursal_id'];
	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";
	
		require_once($model);
		require_once($controller);
	});

	$objInventario =  new Inventario();

	$mes = isset($_GET['mes']) ? $_GET['mes'] : '';

	if($mes!='reload')
	{
		$mes = DateTime::createFromFormat('m/Y', $mes)->format('Y-m');

	} else {

		$mes = '';
	}
	
?>


	   <div class="panel panel-body">
		<table class="table datatable-basic table-borderless table-hover table-xs">
			<thead>
				<tr>
					<th><b>No</b></th>
					<th><b>PRODUCTO</b></th>
					<th><b>MARCA</b></th>
					<th><b>SALDO INICIAL</b></th>
					<th><b>ENTRADAS</b></th>
					<th><b>SALIDAS</b></th>
					<th><b>SALDO</b></th>
				</tr>
			</thead>

			<tbody>
			
			  <?php 

					$filas = $objInventario->Listar_Kardex($mes,$idsucursal); 
					if (is_array($filas) || is_object($filas))
					{
					foreach ($filas as $row => $column) 
					{
					?>
						<tr>
		                	<td><?php print($column['idproducto']); ?></td>
		                	<td><?php print($column['producto']); ?></td>
		                	<td><?php print($column['nombre_marca']); ?></td>
		                	<td><?php print($column['saldo_inicial']); ?></td>
		                	<td><?php print($column['entradas']); ?></td>
		                	<td><?php print($column['salidas']); ?></td>
		                	<td><?php print($column['saldo_final']); ?></td>
		                </tr>
					<?php  
					}
				}
				?>
			
			</tbody>
		</table>
		</div>
	<script type="text/javascript" src="web/custom-js/kardex.js"></script>