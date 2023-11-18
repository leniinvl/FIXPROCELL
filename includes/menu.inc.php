			<li class="<?php if($_GET['View']=="Inicio"){echo 'active';} ?>" ><a href="./?View=Inicio"><i class="icon-home"></i> <span>Inicio</span></a></li>

			<?php  if($tipo_usuario == '1'){ ?>
						<!-- Almacen -->
						<li>
							<a href="#"><i class="icon-box-add"></i> <span>Almacen</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Producto"){echo 'active';} ?>" ><a href="./?View=Producto"> <i class="icon-briefcase"></i> Producto </a></li>
								<li class="<?php if($_GET['View']=="Categoria"){echo 'active';} ?>" ><a href="./?View=Categoria"> <i class="icon-price-tag2"></i> Categoría</a></li>
								<li class="<?php if($_GET['View']=="Marca"){echo 'active';} ?>" ><a href="./?View=Marca"> <i class="icon-pushpin"></i> Marca </a></li>
								<li class="<?php if($_GET['View']=="Presentacion"){echo 'active';} ?>" ><a href="./?View=Presentacion"><i class="icon-attachment"></i> Modelo </a></li>
								<li class="<?php if($_GET['View']=="Color"){echo 'active';} ?>" ><a href="./?View=Color"> <i class="icon-droplet"></i> Color</a></li>
								<li class="<?php if($_GET['View']=="Perecederos"){echo 'active';} ?>" ><a href="./?View=Perecederos"> <i class="icon-calendar"></i> Caducidad</a></li>
								<li class="<?php if($_GET['View']=="Codigo"){echo 'active';} ?>" ><a href="./?View=Codigo"> <i class="icon-qrcode"></i> Codificación</a></li>
							</ul>
						</li>
						<!-- /Almacen -->


						<!-- Ventas directas -->
						<li>
							<a href="#"><i class="icon-cart"></i> <span>Ventas</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="POS"){echo 'active';} ?>" ><a href="./?View=POS"> <i class="icon-credit-card"></i> <b>Realizar Venta</b></a></li>
								<li class="<?php if($_GET['View']=="Clientes"){echo 'active';} ?>" ><a href="./?View=Clientes"> <i class="icon-users"></i> Clientes</a></li>
								<li class="<?php if($_GET['View']=="Venta-Diaria"){echo 'active';} ?>" ><a href="./?View=Venta-Diaria"> <i class="icon-clipboard3"></i> Reporte del Dia</a></li>
								<li class="<?php if($_GET['View']=="Ventas-Fecha"){echo 'active';} ?>" ><a href="./?View=Ventas-Fecha"> <i class="icon-clipboard3"></i> Reporte por Fecha</a></li>
								<li class="<?php if($_GET['View']=="Ventas-Productos"){echo 'active';} ?>" ><a href="./?View=Ventas-Productos"> <i class="icon-clipboard3"></i> Reporte por Productos</a></li>
								<li class="<?php if($_GET['View']=="Ventas-Mes"){echo 'active';} ?>" ><a href="./?View=Ventas-Mes"> <i class="icon-clipboard3"></i> Reporte General</a></li>
							</ul>
						</li>
						<!-- /Ventas directas-->


						<!-- Compras -->
						<li>
							<a href="#"><i class="icon-truck"></i> <span>Compras</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Compras"){echo 'active';} ?>" ><a href="./?View=Compras"> <i class="icon-briefcase3"></i> <b>Registrar Compra</b></a></li>		
								<li class="<?php if($_GET['View']=="Proveedor"){echo 'active';} ?>" ><a href="./?View=Proveedor"> <i class="icon-user-check"></i> Proveedores</a></li>
								<li class="<?php if($_GET['View']=="Compras-Mes"){echo 'active';} ?>" ><a href="./?View=Compras-Mes"> <i class="icon-clipboard2"></i> Reporte por Mes</a></li>
								<li class="<?php if($_GET['View']=="Compras-Fecha"){echo 'active';} ?>" ><a href="./?View=Compras-Fecha"> <i class="icon-clipboard2"></i> Reporte por Fecha</a></li>
								<!--<li><a href="./?View=Historico-Precios">Historial de Precios</a></li>-->
							</ul>
						</li>
						<!-- /Compras -->


						<!-- Caja -->
						<li>
							<a href="#"><i class="icon-cash3"></i> <span>Caja</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Caja"){echo 'active';} ?>" ><a href="./?View=Caja"> <i class="icon-calculator3"></i> Gestionar Caja</a></li>
								<li class="<?php if($_GET['View']=="Historico-Caja"){echo 'active';} ?>" ><a href="./?View=Historico-Caja"> <i class="icon-keyboard"></i> Historial de Caja</a></li>
							</ul>
						</li>
						<!-- /Caja -->


						<!-- Creditos  -->
						<li>
							<a href="#"><i class="icon-credit-card2"></i> <span>Créditos</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Creditos"){echo 'active';} ?>" ><a href="./?View=Creditos"> <i class="icon-coin-dollar"></i> Créditos por cobrar</a></li>
								<!--<li class="<?php // if($_GET['View']=="null"){echo 'active';} ?>" ><a href="./?View="> <i class="icon-coins"></i> Creditos por pagar</a></li>-->
							</ul>
						</li>
						<!-- /Creditos -->


						<!-- Taller  --->
						<li>
							<a href="#"><i class="icon-wrench"></i> <span>Servicio Técnico</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Taller"){echo 'active';} ?>" ><a href="./?View=Taller"> <i class="icon-clipboard"></i>  Órden de Trabajo </a></li>
								<li class="<?php if($_GET['View']=="Tecnicos"){echo 'active';} ?>" ><a href="./?View=Tecnicos"> <i class="icon-user"></i> Personal Técnicos </a></li>	
							</ul>
						</li>
						<!-- Taller --->


						<!-- Cotizaciones -->
						<li>
							<a href="#"><i class="icon-file-spreadsheet"></i> <span>Cotizaciones</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Cotizacion"){echo 'active';} ?>" ><a href="./?View=Cotizacion"> <i class="icon-stats-bars2"></i> Realizar Cotización</a></li>
								<li class="<?php if($_GET['View']=="Cotizaciones"){echo 'active';} ?>" ><a href="./?View=Cotizaciones"> <i class="icon-eye"></i> Ver Cotizaciones</a></li>
							</ul>
						</li>
						<!-- /Cotizaciones -->


						<!-- Ventas reservadas -->
						<!-- 
						<li>
							<a href="#"><i class="icon-calendar"></i> <span>Reservar Venta</span></a>
							<ul>
								<li><a href="./?View=POS-A"> <i class="icon-sort-time-asc"></i>  Nueva Reservación</a></li>
								<li><a href="./?View=Apartados-Diarios"> <i class="icon-clipboard"></i>  Detalles del Dia</a></li>
								<li><a href="./?View=Apartados-Mes"> <i class="icon-clipboard2"></i>  Detalles por Mes</a></li>
								<li><a href="./?View=Apartados-Fecha"> <i class="icon-clipboard3"></i>  Detalles por Fecha</a></li>
							</ul>
						</li> 
						-->
						<!--  /Ventas reservadas -->


						<!-- Inventario -->
						<li>
							<a href="#"><i class="icon-ungroup"></i> <span>Inventario</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Kardex"){echo 'active';} ?>" ><a href="./?View=Kardex"> <i class="icon-dropbox"></i> Kardex</a></li>
								<li class="<?php if($_GET['View']=="Abrir-Inventario"){echo 'active';} ?>" ><a href="./?View=Abrir-Inventario"> <i class="icon-checkbox-checked"></i> Estado de Inventario</a></li>
							</ul>
						</li>
						<!-- /Inventario -->


						<!-- Cuentas -->
						<li>
							<a href="#"><i class="icon-file-zip"></i> <span>Facturas</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Consulta-factura"){echo 'active';} ?>" ><a href="./?View=Consulta-factura"> <i class="icon-file-text"></i> Gestión Facturas</a></li>	
								<!-- 
								<li class="<?//php if($_GET['View']=="null"){echo 'active';} ?>" ><a href="./?View="> <i class="icon-upload"></i>Control de gastos</a></li>
								<li class="<?//php if($_GET['View']=="null"){echo 'active';} ?>" ><a href="./?View="> <i class="icon-download"></i> Control de ingresos</a></li>
								<li class="<?//php if($_GET['View']=="null"){echo 'active';} ?>" ><a href="./?View="> <i class="icon-file-zip"></i> Estado Financiero</a></li>
								-->
							</ul>
						</li>
						<!-- /Cuentas-->


						<!-- Usuarios -->
						<li>
							<a href="#"><i class="icon-users"></i> <span>Usuarios</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Empleados"){echo 'active';} ?>" ><a href="./?View=Empleados"> <i class="icon-man-woman"></i> Empleados</a></li>
								<li class="<?php if($_GET['View']=="Usuario"){echo 'active';} ?>" ><a href="./?View=Usuario"> <i class="icon-address-book"></i> Rol de sistema</a></li>
								<li class="<?php if($_GET['View']=="Asistencia-registro"){echo 'active';} ?>" ><a href="./?View=Asistencia-registro"> <i class="icon-point-up"></i> Asistencias</a></li>
								<li class="<?php if($_GET['View']=="Asistencia-reporte"){echo 'active';} ?>" ><a href="./?View=Asistencia-reporte"> <i class="icon-profile"></i> Reporte asistencia</a></li>
							</ul>
						</li>
						<!-- /Usuarios -->


						<!-- Ajustes -->
						<li>
							<a href="#"><i class="icon-equalizer"></i> <span>Configuración</span></a>
							<ul>
                                <!-- <li><a href="./?View=Monedas">Monedas</a></li> -->
								<li class="<?php if($_GET['View']=="Parametros"){echo 'active';} ?>" ><a href="./?View=Parametros"> <i class="icon-database"></i> Negocio</a></li>
								<li class="<?php if($_GET['View']=="Sucursal"){echo 'active';} ?>" ><a href="./?View=Sucursal"> <i class="icon-location3"></i> Establecimientos</a></li>
								<li class="<?php if($_GET['View']=="Tipo-Comprobante"){echo 'active';} ?>" ><a href="./?View=Tipo-Comprobante"> <i class="icon-certificate"></i> Comprobantes</a></li>
								<li class="<?php if($_GET['View']=="Tirajes"){echo 'active';} ?>" ><a href="./?View=Tirajes"> <i class="icon-libreoffice"> </i> Series y Numeración</a></li>
							</ul>
						</li>
						<!-- /Ajustes -->


						<!-- /Acera de -->
						<li>
							<li class="<?php if($_GET['View']=="Acerca-de"){echo 'active';} ?>" ><a href="./?View=Acerca-de"> <i class="icon-info22"> </i> <span>Acerca de<span> </a></li>
						</li>
						<!--Acerca de  -->


			<?php } else { ?>

						
						<!-- Almacen -->
						<li>
							<a href="#"><i class="icon-box-add"></i> <span>Almacen</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Producto"){echo 'active';} ?>" ><a href="./?View=Producto"> <i class="icon-briefcase"></i> Producto</a></li>
							</ul>
						</li>
						<!-- /Almacen -->


						<!-- Ventas directas -->
						<li>
							<a href="#"><i class="icon-cart"></i> <span>Ventas</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="POS"){echo 'active';} ?>" ><a href="./?View=POS"> <i class="icon-credit-card"></i> <b>Realizar Venta</b></a></li>
								<li class="<?php if($_GET['View']=="Clientes"){echo 'active';} ?>" ><a href="./?View=Clientes"> <i class="icon-users"></i> Clientes</a></li>
								<li class="<?php if($_GET['View']=="Venta-Diaria"){echo 'active';} ?>" ><a href="./?View=Venta-Diaria"> <i class="icon-clipboard3"></i> Reporte del Dia</a></li>
								<li class="<?php if($_GET['View']=="Ventas-Fecha"){echo 'active';} ?>" ><a href="./?View=Ventas-Fecha"> <i class="icon-clipboard3"></i> Reporte por Fecha</a></li>
								<li class="<?php if($_GET['View']=="Ventas-Productos"){echo 'active';} ?>" ><a href="./?View=Ventas-Productos"> <i class="icon-clipboard3"></i> Reporte por Productos</a></li>
							</ul>
						</li>
						<!-- /Ventas directas-->


						<!-- Cotizaciones -->
						<li>
							<a href="#"><i class="icon-file-spreadsheet"></i> <span>Cotizaciones</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Cotizacion"){echo 'active';} ?>" ><a href="./?View=Cotizacion"> <i class="icon-stats-bars2"></i> Realizar Cotización</a></li>
								<li class="<?php if($_GET['View']=="Cotizaciones"){echo 'active';} ?>" ><a href="./?View=Cotizaciones"> <i class="icon-eye"></i> Ver Cotizaciones</a></li>
							</ul>
						</li>
						<!-- /Cotizaciones -->


						
						<!-- Creditos  -->
						<li>
							<a href="#"><i class="icon-credit-card2"></i> <span>Créditos</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Creditos"){echo 'active';} ?>" ><a href="./?View=Creditos"> <i class="icon-coin-dollar"></i> Créditos por cobrar</a></li>
								<!--<li class="<?php // if($_GET['View']=="null"){echo 'active';} ?>" ><a href="./?View="> <i class="icon-coins"></i> Creditos por pagar</a></li>-->
							</ul>
						</li>
						<!-- /Creditos -->


						<!-- Caja -->
						<li>
							<a href="#"><i class="icon-cash3"></i> <span>Caja</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Caja"){echo 'active';} ?>" ><a href="./?View=Caja"> <i class="icon-calculator3"></i> Gestionar Caja</a></li>
							</ul>
						</li>
						<!-- /Caja -->


						<!-- Ventas reservadas -->
						<!-- 
						<li>
							<a href="#"><i class="icon-calendar"></i> <span>Reservar Venta</span></a>
							<ul>
								<li><a href="./?View=POS-A"> <i class="icon-sort-time-asc"></i>  Nueva Reservación</a></li>
								<li><a href="./?View=Apartados-Diarios"> <i class="icon-clipboard"></i>  Detalles del Dia</a></li>
								<li><a href="./?View=Apartados-Mes"> <i class="icon-clipboard2"></i>  Detalles por Mes</a></li>
								<li><a href="./?View=Apartados-Fecha"> <i class="icon-clipboard3"></i>  Detalles por Fecha</a></li>
							</ul>
						</li> 
						-->
						<!--  /Ventas reservadas -->


						<!-- Taller  --->
						<li>
							<a href="#"><i class="icon-wrench"></i> <span>Servicio Técnico</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Taller"){echo 'active';} ?>" ><a href="./?View=Taller"> <i class="icon-clipboard"></i>  Órden de Trabajo </a></li>
							</ul>
						</li>
						<!-- Taller --->


						<!-- Inventario -->
						<li>
							<a href="#"><i class="icon-ungroup"></i> <span>Inventario</span></a>
							<ul>
								<li class="<?php if($_GET['View']=="Kardex"){echo 'active';} ?>" ><a href="./?View=Kardex"> <i class="icon-dropbox"></i> Kardex</a></li>
							</ul>
						</li>
						<!-- /Inventario -->

						<!-- /Acera de -->
						<li>
							<li class="<?php if($_GET['View']=="Acerca-de"){echo 'active';} ?>" ><a href="./?View=Acerca-de"> <i class="icon-info22"> </i> <span>Acerca de<span> </a></li>
						</li>
						<!--Acerca de  -->

			<?php } ?>
