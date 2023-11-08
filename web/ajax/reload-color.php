<?php 

	spl_autoload_register(function($className){
		$model = "../../model/". $className ."_model.php";
		$controller = "../../controller/". $className ."_controller.php";
	
		require_once($model);
		require_once($controller);
	});

	$objColor =  new Color();

 ?>
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

<script type="text/javascript" src="web/custom-js/color.js"></script>
