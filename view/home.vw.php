<?php

	$idsucursal = $_SESSION['sucursal_id'];	
	$sucursal = $_SESSION['sucursal_name'];

	$objDashboard =  new Dashboard();

	$parametros = $objDashboard->Ver_Moneda_Reporte();
	if (is_array($parametros) || is_object($parametros))
	{
		foreach ($parametros as $row => $column) {

				$nombre_mon = $column['CurrencyISO'];
				$moneda = $column['Symbol'];

		}
	} else {
		$moneda = '';
	}

	$filas = $objDashboard->Datos_Paneles($idsucursal);
	$compras = $objDashboard->Compras_Anuales($idsucursal);
	$ventas = $objDashboard->Ventas_Anuales($idsucursal);

	if (is_array($filas) || is_object($filas))
	{
		foreach ($filas as $row => $column)
		{
			$compras_mes = $column["compras_mes"];
			$ventas_dia = $column["ventas_dia"];
			$inversion_stock = $column["inversion_stock"];
			$proveedores = $column["proveedores"];
			$marcas = $column["marcas"];
			$presentaciones = $column["presentaciones"];
			$productos = $column["productos"];
			$dinero_caja  = $column["dinero_caja"];
			$perecederos  = $column["perecederos"];
			$a_vencer  = $column["a_vencer"];
			$clientes  = $column["clientes"];
			$creditos  = $column["creditos"];
		}
	}


?>

				<div class="row">
					
					<div class="col-md-6">
						<!-- Widget with rounded icon -->
						<div class="panel panel-body bg-white has-bg-image">
							<div class="panel-body text-center">
								<div class="icon-obj border-slate-700 text-slate-700">
									<?php
										if($idsucursal == 1){
											echo '<img src="web/assets/images/logo.png" width="500px" height="500px" class="img-responsive" alt="">';
										}else{
											echo '<img src="web/assets/images/logo2.png" width="200px" height="200px" class="img-responsive" alt="">';
										}
									?>
								</div>
							</div>
						</div>
						<!-- /widget with rounded icon -->
					</div>

					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-success has-bg-image">
							<div class="media no-margin">
								<div class="media-left media-middle">
									<i class="icon-coin-dollar icon-3x opacity-100"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="no-margin"><?php echo $moneda.' '.number_format($dinero_caja, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini"><?php echo strtoupper($nombre_mon) ?> EN CAJA</span>
								</div>

							</div>
							<a>
						</div>
					</div>

					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-blue-800 has-bg-image">
							<div class="media no-margin">
								<div class="media-left media-middle">
									<i class="icon-cash3 icon-3x opacity-100"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="no-margin"><?php echo $moneda.' '.number_format($ventas_dia, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">VENTAS DEL DÍA</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-orange-600 has-bg-image">
							<div class="media no-margin">
								<div class="media-left media-middle">
									<i class="icon-wallet icon-3x opacity-100"></i>
								</div>	
								<div class="media-body text-right">
									<h3 class="no-margin"><?php echo number_format($creditos, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">CRÉDITOS POR COBRAR</span>
								</div>

								
							</div>
						</div>
					</div>
									

					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-danger-400 has-bg-image">
							<div class="media no-margin">
								<div class="media-left media-middle">
									<i class="icon-bag icon-3x opacity-100"></i>
								</div>
								<div class="media-body text-right">
									<h3 class="no-margin"><?php echo $moneda.' '.number_format($compras_mes, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">COMPRAS DEL MES </span>
								</div>
							</div>
						</div>
					</div>


					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-purple-400 has-bg-image">
							<div class="media no-margin">
								<div class="media-left media-middle">
									<i class="icon-users icon-3x opacity-100"></i>
								</div>
								<div class="media-body text-right">
									<h3 class="no-margin"><?php echo number_format($clientes, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">CLIENTES</span>
								</div>								
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-teal-400 has-bg-image"> 
							<div class="media no-margin">
								<div class="media-left media-middle">
									<i class="icon-truck icon-3x opacity-100"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="no-margin"><?php echo number_format($proveedores, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">PROVEEDORES</span>
								</div>
							</div>
						</div>
					</div>


				<!--
					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-indigo-400 has-bg-image">
							<div class="media no-margin">
								<div class="media-left media-middle">
									<i class="icon-price-tags icon-3x opacity-75"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="no-margin"><?php //echo $moneda.' '.number_format($inversion_stock, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">invertido en stock</span>
								</div>
							</div>
						</div>
					</div>
				-->

					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-violet has-bg-image">
							<div class="media no-margin">
								<div class="media-left media-middle">
									<i class="icon-dropbox icon-3x opacity-100"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="no-margin"><?php echo number_format($productos, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">PRODUCTOS EN ALMACEN</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-green-600 has-bg-image">
							<div class="media no-margin">
								<div class="media-left media-middle">
									<i class="icon-price-tags icon-3x opacity-100"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="no-margin"><?php echo number_format($marcas, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">Marcas</span>
								</div>
							</div>
						</div>
					</div>

				<!--
					 <div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-orange-400 has-bg-image">
							<div class="media no-margin">
								<div class="media-left media-middle">
									<i class="icon-stack-star icon-3x opacity-75"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="no-margin"><?php //echo number_format($presentaciones, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">Presentaciones</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-danger-600 has-bg-image">
							<div class="media no-margin">
								<div class="media-body">
									<h3 class="no-margin"><?php //echo number_format($perecederos, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">Perecederos</span>
								</div>

								<div class="media-right media-middle">
									<i class="icon-calendar icon-3x opacity-75"></i>
								</div>
							</div>
						</div>
					</div>


					<div class="col-sm-6 col-md-3">
						<div class="panel panel-body bg-info-300 has-bg-image">
							<div class="media no-margin">
								<div class="media-body">
									<h3 class="no-margin"><?php //echo number_format($a_vencer, 2, '.', ','); ?></h3>
									<span class="text-uppercase text-size-mini">Venceran en 30 dias</span>
								</div>

								<div class="media-right media-middle">
									<i class="icon-sort-time-asc icon-3x opacity-75"></i>
								</div>
							</div>
						</div>
					</div>
				-->
				</div>

			<!--		
				<div class="row">
					<div class="col-lg-6">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h6 class="panel-title text-center text-uppercase">Ventas del Año</h6>
								<div class="chart-container text-center">
									<div class="display-inline-block" id="c3-pie-chart"></div>
								</div>
							</div>
						</div>
				   </div>
				</div>
			-->

				<!-- Main charts -->
				<div class="row">
					<div class="col-lg-6">

						<!-- Traffic sources -->
						<div class="panel-flat bg-teal-600">
							<div class="panel-heading">
								<h6 class="panel-title bg-teal-600 text-center text-uppercase text-black">VENTAS (<?php echo date('Y') ?>) </h6>
							</div>
							<div class="panel panel-flat bg-white has-bg-image" style="padding-top: 30px;padding-bottom: 20px;">
								<div class="chart-container text-center">
									<div class="display-inline-block" id="chart-ventas"></div>
								</div>
							</div>
						</div>
						<!-- /traffic sources -->

					</div>

					<div class="col-lg-6">

						<!-- Sales stats -->
						<div class="panel-flat bg-teal-600">
							<div class="panel-heading">
								<h6 class="panel-title bg-teal-600 text-center text-uppercase text-black">COMPRAS (<?php echo date('Y') ?>)</h6>
							</div>
							<div class="panel panel-flat bg-white has-bg-image" style="padding-top: 30px;padding-bottom: 20px;">
								<div class="chart-container text-center">
									<div class="display-inline-block" id="chart-compras"></div>
								</div>
							</div>
						</div>
						<!-- /sales stats -->
					</div>
				</div>
				<!-- /main charts -->

				<div class="row">
					<div class="col-lg-12">
						<!-- Simple line chart ---->
							<div class="panel-flat bg-teal-600">
								<div class="panel-heading">
									<h6 class="panel-title bg-teal-600 text-center text-uppercase text-black">GRÁFICO DE VENTAS Y COMPRAS (<?php echo date('Y') ?>) </h6>
								</div>
								<div class="panel panel-flat bg-white has-bg-image" style="padding: 25px;">
									<div class="chart-container">
										<div class="chart" id="c3-line-chart"></div>
									</div>
								</div>
							</div>
						<!-- /simple line chart -->
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

<script>

// Line chart
 // ------------------------------

 // Generate chart
 var line_chart = c3.generate({
		 bindto: '#c3-line-chart',
		 point: {
				 r: 8
		 },
		 size: { height: 400, width: 1150 },
		 color: {
				 pattern: ['#66BB6A', '#54CFDF', '#1E88E5']
		 },
		 data: {
				 x: 'x', //add
				 columns: [
						 ['x', <?php if (!empty($ventas)){
  										foreach ($ventas as $row => $column) {  if($column['mes']=='JAN'){ //add
																					print('"ENE",');
																				}else if($column['mes']=='FEB'){
																					print('"FEB",');
																				}else if($column['mes']=='MAR'){
																					print('"MAR",');
																				}else if($column['mes']=='APR'){
																					print('"ABR",');
																				}else if($column['mes']=='MAY'){
																					print('"MAY",');
																				}else if($column['mes']=='JUN'){
																					print('"JUN",');
																				}else if($column['mes']=='JUL'){
																					print('"JUL",');
																				}else if($column['mes']=='AUG'){
																					print('"AGO",');
																				}else if($column['mes']=='SEP'){
																					print('"SEP",');
																				}else if($column['mes']=='OCT'){
																					print('"OCT",');
																				}else if($column['mes']=='NOV'){
																					print('"NOV",');
																				}else if($column['mes']=='DEC'){
																					print('"DIC",');
																				}else{
																					print('"'.$column['mes'].'",'); //ORIGINAL
																				}
																			 }
						  				}
						  ?>], 
						 ['COMPRAS', <?php if (!empty($compras)){ foreach ($compras as $row => $column) {print($column['total'].',');} } ?>],
						 ['VENTAS', <?php if (!empty($ventas)){ foreach ($ventas as $row => $column) {print($column['total'].',');} } ?>]
				 ],
				 type: 'area-spline'
		 },
		 axis : {
	    	x:{
	    		type: 'category',
	    	},
	        y : {
	            tick: {
	                format: d3.format(",.2f")
	            }
	        }
	    },
		 grid: {
				y: {
					show: true
				}
		 }
 });


    var pie_chart_compras = c3.generate({
        bindto: '#chart-compras',
        size: { width: 500 },
        data: {
	        x: 'x',
	        columns: [
	            ['x', <?php if (!empty($compras)){ 
							foreach ($compras as $row => $column) {if($column['mes']=='JAN'){ //add
																		print('"ENE",');
																	}else if($column['mes']=='FEB'){
																		print('"FEB",');
																	}else if($column['mes']=='MAR'){
																		print('"MAR",');
																	}else if($column['mes']=='APR'){
																		print('"ABR",');
																	}else if($column['mes']=='MAY'){
																		print('"MAY",');
																	}else if($column['mes']=='JUN'){
																		print('"JUN",');
																	}else if($column['mes']=='JUL'){
																		print('"JUL",');
																	}else if($column['mes']=='AUG'){
																		print('"AGO",');
																	}else if($column['mes']=='SEP'){
																		print('"SEP",');
																	}else if($column['mes']=='OCT'){
																		print('"OCT",');
																	}else if($column['mes']=='NOV'){
																		print('"NOV",');
																	}else if($column['mes']=='DEC'){
																		print('"DIC",');
																	}else{
																		print('"'.$column['mes'].'",'); //ORIGINAL
																	}
																	}
							}
				?>],
	            ['VALOR', <?php if (!empty($compras)){ foreach ($compras as $row => $column) {print($column['total'].',');} } ?>]
	        ],
	        type : 'bar',
	        colors: {
				VALOR: '#66BB6A'
        	},
	    },
	    axis : {
	    	x:{
	    		type: 'category',
	    	},
	        y : {
	            tick: {
	                format: d3.format(",.2f")
	                //format: function (d) { return "$ " + d; }
	            }
	        }
	    },
		grid: {
				y: {
						show: true
				}
		}
    });

    var pie_chart_ventas = c3.generate({
        bindto: '#chart-ventas',
        size: { width: 500 },
        data: {
	        x: 'x',
	        columns: [
	            ['x', <?php if (!empty($ventas)){ 
							foreach ($ventas as $row => $column) { if($column['mes']=='JAN'){ //add
																		print('"ENE",');
																	}else if($column['mes']=='FEB'){
																		print('"FEB",');
																	}else if($column['mes']=='MAR'){
																		print('"MAR",');
																	}else if($column['mes']=='APR'){
																		print('"ABR",');
																	}else if($column['mes']=='MAY'){
																		print('"MAY",');
																	}else if($column['mes']=='JUN'){
																		print('"JUN",');
																	}else if($column['mes']=='JUL'){
																		print('"JUL",');
																	}else if($column['mes']=='AUG'){
																		print('"AGO",');
																	}else if($column['mes']=='SEP'){
																		print('"SEP",');
																	}else if($column['mes']=='OCT'){
																		print('"OCT",');
																	}else if($column['mes']=='NOV'){
																		print('"NOV",');
																	}else if($column['mes']=='DEC'){
																		print('"DIC",');
																	}else{
																		print('"'.$column['mes'].'",'); //ORIGINAL
																	}
																  }
							}
				?>],
	            ['VALOR', <?php if (!empty($ventas)){ foreach ($ventas as $row => $column) {print($column['total'].',');} } ?>]
	        ],
	        type : 'bar',
	        colors: {
				VALOR: '#54CFDF'
        	},
	    },
	    axis : {
	    	x:{
	    		type: 'category',
	    	},
	        y : {
	            tick: {
	                format: d3.format(",.2f")
	                //format: function (d) { return "$ " + d; }
	            }
	        }
	    },
		grid: {
				y: {
						show: true
				}
		}
    });



</script>
