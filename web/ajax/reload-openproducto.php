<?php
session_set_cookie_params(60*60*24*365); session_start();
$tipo_usuario = $_SESSION['user_tipo'];
$idsucursal_filtro = /*-1;*/ $_SESSION['sucursal_id']; /*CAMBIO FILTRO INICIAL*/
$idsucursal_selection = $_SESSION['sucursal_id'];

spl_autoload_register(function($className) {
    $model = "../../model/" . $className . "_model.php";
    $controller = "../../controller/" . $className . "_controller.php";

    require_once($model);
    require_once($controller);
});

$objProducto = new Producto();
$objSucursal = new Sucursal();
$objCategoria = new Categoria();

?>

<!-- Basic initialization -->
<div class="panel panel-flat">
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="?View=Inicio"><i class="icon-home2 position-left"></i> Inicio</a></li>
            <li><a href="javascript:;">Almacen</a></li>
            <li class="active">Productos</li>
        </ul>
    </div>
    <div class="panel-heading">
        <h5 class="panel-title">Administración de productos</h5>

        <div class="heading-elements" >
            <?php if ($tipo_usuario == '1') { ?>
                
                <button type="button" class="btn btn-info heading-btn"
                        onclick="newProducto()">
                    <i class="icon-database-add"></i> Agregar Nuevo/a</button>

                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-printer2 position-left"></i> Reporte Productos
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a id="print_agotados" href="javascript:void(0)">
                                <i class="icon-file-pdf"></i> Agotados</a></li>
                        <li class="divider"></li>
                        <li><a id="print_vigentes" href="javascript:void(0)">
                                <i class="icon-file-pdf"></i> Disponibles</a></li>
                        <li class="divider"></li>
                        <li><a id="print_activos" href="javascript:void(0)">
                                <i class="icon-file-pdf"></i> Activos</a></li>
                        <li class="divider"></li>
                        <li><a id="print_inactivos" href="javascript:void(0)">
                                <i class="icon-file-pdf"></i> Inactivos</a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>


        <div class="btn-group">
            <div class="row">
                <form role="form" autocomplete="off" class="form-validate-jquery" id="frmFilter">
                    <div class="col-sm-5"><b>Establecimiento:</b>
                        <select  data-placeholder="Seleccione una sucursal..." id="cbSucursal" name="cbSucursal"
                            class="select-search" style="text-transform:uppercase;"
                            onkeyup="javascript:this.value = this.value.toUpperCase();">
                                <option value="" selected disabled> Seleccione una sucursal... </option>
                                <option value="0"> TODOS </option>
                                <?php
                                $filas = $objSucursal->Listar_Sucursal();
                                if (is_array($filas) || is_object($filas)) {
                                    foreach ($filas as $row => $column) {
                                        ?>
                                        <option value="<?php print ($column["idsucursal"]) ?>"
                                            <?php if($column["idsucursal"]==$idsucursal_selection){print('selected');} ?> >
                                            <?php print ($column["nombre"]) ?></option>
                                        <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>

                    <div class="col-sm-5"><b>Categoría:</b>
                        <select  data-placeholder="Seleccione una categoria..." id="cbFCategoria" name="cbFCategoria"
                            class="select-search" style="text-transform:uppercase;"
                            onkeyup="javascript:this.value = this.value.toUpperCase();">
                                <option value="" selected disabled> Seleccione una categoria... </option>
                                <option value="0" selected> TODOS </option>
                                <?php
                                $filas = $objCategoria->Listar_Categorias();
                                if (is_array($filas) || is_object($filas)) {
                                    foreach ($filas as $row => $column) {
                                        ?>
                                    <option value="<?php print ($column["idcategoria"]) ?>">
                                            <?php print ($column["nombre_categoria"]) ?></option>
                                        <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <button style="margin-top: 20px;" id="btnFiltrar" type="submit" class="btn btn-info btn-m"> 
                        <i class="icon-search4"></i> BUSCAR </button>
                    </div>  
                </form>      
            </div>
        </div>
    </div>

    <div class="panel-body">
    
        <div id="reload-div">
            <table class="table datatable-basic table-borderless table-hover table-xxs">
                <?php if ($tipo_usuario == '1') { ?>
                    <thead>
                        <tr>
                            <th><b>Código barra</b></th>
                            <th><b>Nombre Producto</b></th>
                            <th><b>Categoría producto</b></th>
                            <th><b>Marca producto</b></th>
                            <th><b>Modelo producto</b></th>
                            <!---<th><b>Color</b></th>-->
                            <th><b>Stock disponible</b></th>
                            <th><b>Precio normal</b></th>
                            <th><b>Precio oferta</b></th>
                            <!---<th><b>Dist.1</b></th>-->
                            <!---<th><b>Dist.2</b></th>-->
                            <th><b>Precio compra</b></th>
                            <th><b>Estado</b></th> 
                            <th><b>Almacen</b></th>
                            <th class="text-center"><b>Opciones</b></th>
                        </tr>
                    </thead>


                    <tbody>

        <?php
                        $filas = $objProducto->Listar_Productos($idsucursal_filtro);
                        if (is_array($filas) || is_object($filas)) {
                            foreach ($filas as $row => $column) {
                                $stock_print = "";
                                $codigo_print = "";
                                $codigo_barra = $column['codigo_barra'];
                                $inventariable = $column['inventariable'];
                                $stock = $column['stock'];
                                $stock_min = $column['stock_min'];

                                if ($codigo_barra == '') {
                                    $codigo_print = $column['codigo_interno'];
                                } else {

                                    $codigo_print = $codigo_barra;
                                }

                                if ($inventariable == 1) {

                                    if ($stock >= 1 && $stock < $stock_min) {

                                        $stock_print = '<span class="label label-warning label-rounded"><span
                                            class="text-bold">POR AGOTARSE</span></span>';
                                    } else if ($stock == $stock_min) {

                                        $stock_print = '<span class="label label-info label-rounded"><span
                                            class="text-bold">EN MINIMO</span></span>';
                                    } else if ($stock > $stock_min) {

                                        $stock_print = '<span class="label label-success label-rounded"><span
                                            class="text-bold">DISPONIBLE</span></span>';
                                    } else if ($stock <= 0 && $stock_min >= 1) {

                                        $stock_print = '<span class="label label-danger label-rounded">
                                            <span class="text-bold">AGOTADO</span></span>';
                                    } else if ($stock == 0 && $stock_min == 0) {

                                        $stock_print = '<span class="label label-default label-rounded">
                                            <span class="text-bold">POR INVENTARIAR</span></span>';
                                    } 

                                } else {

                                    $stock_print = '<span class="label label-primary label-rounded"><span
                                            class="text-bold">SERVICIO</span></span>';
                                }

                                $idsucursal = $column['idsucursal'];
                                $nombre_sucursal = $column['nombre_sucursal'];
                                $print_sucursal = '<span class="label label-success label-rounded"><span
                                class="text-bold">'.$nombre_sucursal.'</span></span>';
                                if ($idsucursal == 2) {
                                    $print_sucursal = '<span class="label label-info label-rounded"><span
                                            class="text-bold">'.$nombre_sucursal.'</span></span>';
                                }elseif ($idsucursal == 3) {
                                    $print_sucursal = '<span class="label label-warning label-rounded"><span
                                            class="text-bold">'.$nombre_sucursal.'</span></span>';
                                }elseif ($idsucursal == 4) {
                                    $print_sucursal = '<span class="label label-primary label-rounded"><span 
                                        class="text-bold">'.$nombre_sucursal.'</span></span>';
                                }elseif ($idsucursal == 5) {
                                    $print_sucursal = '<span class="label label-default label-rounded">
                                            <span class="text-bold">'.$nombre_sucursal.'</span></span>';
                                }elseif ($idsucursal == 6) {
                                    $print_sucursal = '<span class="label label-danger label-rounded">
                                    <span class="text-bold">'.$nombre_sucursal.'</span></span>';
                                }

                                ?>
                                <tr>
                                    <td><?php print($codigo_print); ?></td>
                                    <td><?php print($column['nombre_producto']); ?></td>
                                    <td><?php print($column['nombre_categoria']); ?></td>
                                    <td><?php print($column['nombre_marca']); ?></td>
                                    <td><?php print($column['nombre_presentacion']); ?></td>
                                    <!--<td><?//php print($column['nombre_color']); ?></td>-->
                                    <td><?php print($column['stock']); ?></td>
                                    <td>$ <?php print($column['precio_venta']); ?></td>
                                    <td>$ <?php print($column['precio_venta_minimo']); ?></td>
                                    <!--<td><?//php print($column['precio_venta_mayoreo']); ?></td>-->
                                    <!--<td><?//php print($column['precio_super_mayoreo']); ?></td>-->
                                    <td>$ <?php print($column['precio_compra']); ?></td>
                                    <td><?php print($stock_print); ?></td>
                                    <td><?php print($print_sucursal); ?></td>
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a
                                                            href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
                                                            onclick="openProducto('editar',
                                                                '<?php print($column["idproducto"]); ?>',
                                                                '<?php print($column["codigo_interno"]); ?>',
                                                                '<?php print($column["codigo_barra"]); ?>',
                                                                '<?php print($column["nombre_producto"]); ?>',
                                                                '<?php print($column["precio_compra"]); ?>',
                                                                '<?php print($column["precio_venta"]); ?>',
                                                                '<?php print($column["precio_venta_minimo"]); ?>',
                                                                '<?php print($column["precio_venta_mayoreo"]); ?>',
                                                                '<?php print($column["precio_super_mayoreo"]); ?>',
                                                                '<?php print($column["stock"]); ?>',
                                                                '<?php print($column["stock_min"]); ?>',
                                                                '<?php print($column["idcategoria"]); ?>',
                                                                '<?php print($column["idmarca"]); ?>',
                                                                '<?php print($column["idpresentacion"]); ?>',
                                                                '<?php print($column["estado"]); ?>',
                                                                '<?php print($column["exento"]); ?>',
                                                                '<?php print($column["inventariable"]); ?>',
                                                                '<?php print($column["perecedero"]); ?>',
                                                                '<?php print($column["idcolor"]); ?>')">
                                                            <i class="icon-pencil6">
                                                            </i> Editar</a></li>
                                                    <li>
                                                        <a
                                                            href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
                                                            onclick="openProducto('ver',
                                                                '<?php print($column["idproducto"]); ?>',
                                                                '<?php print($column["codigo_interno"]); ?>',
                                                                '<?php print($column["codigo_barra"]); ?>',
                                                                '<?php print($column["nombre_producto"]); ?>',
                                                                '<?php print($column["precio_compra"]); ?>',
                                                                '<?php print($column["precio_venta"]); ?>',
                                                                '<?php print($column["precio_venta_minimo"]); ?>',
                                                                '<?php print($column["precio_venta_mayoreo"]); ?>',
                                                                '<?php print($column["precio_super_mayoreo"]); ?>',
                                                                '<?php print($column["stock"]); ?>',
                                                                '<?php print($column["stock_min"]); ?>',
                                                                '<?php print($column["idcategoria"]); ?>',
                                                                '<?php print($column["idmarca"]); ?>',
                                                                '<?php print($column["idpresentacion"]); ?>',
                                                                '<?php print($column["estado"]); ?>',
                                                                '<?php print($column["exento"]); ?>',
                                                                '<?php print($column["inventariable"]); ?>',
                                                                '<?php print($column["perecedero"]); ?>',
                                                                '<?php print($column["idcolor"]); ?>')">
                                                            <i class=" icon-eye8">
                                                            </i> Ver</a></li>
                                                        <li><a
                                                            href="javascript:;" data-toggle="modal" data-target="#modal_iconified_barcode"
                                                            onclick="openBarcode(
                                                                '<?php print($column["codigo_barra"]); ?>',
                                                                '<?php print($column["codigo_interno"]); ?>',
                                                                '<?php print($column["nombre_producto"]); ?>',
                                                                '<?php print($column["idproducto"]); ?>')">
                                                            <i class="icon-barcode2">
                                                            </i>Código de Barra</a></li>
                                                            <li><a id="delete_product"
                                                            data-id="<?php print($column['idproducto']); ?>"
                                                            href="javascript:void(0)">
                                                            <i class=" icon-trash">
                                                            </i> Eliminar</a></li>
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

        <?php } else { ?>
                    <thead>
                        <tr>
                            <th> <b> Código barra </b> </th>
                            <th> <b> Nombre Producto </b> </th>
                            <th> <b> Categoría producto </b> </th>
                            <th> <b> Marca producto </b> </th>
                            <th> <b> Modelo producto </b> </th>
                            <!--<th> <b> Color </b> </th>-->
                            <th> <b> Stock disponible </b> </th>
                            <th> <b> Precio normal </b> </th>
                            <th> <b> Precio oferta </b> </th>
                            <!--<th> <b> Dist.1 </b> </th>-->
                            <!--<th> <b> Dist.2 </b> </th>-->
                            <th> <b> Precio compra </b> </th>
                            <th> <b> Estado </b> </th>
                            <th> <b> Almacen </b> </th>
                            <th class="text-center"> <b> Opciones <b> </th>
                        </tr>
                    </thead>


                    <tbody>

        <?php
        $filas = $objProducto->Listar_Productos($idsucursal_filtro);
        if (is_array($filas) || is_object($filas)) {
            foreach ($filas as $row => $column) {
                $stock_print = "";
                $codigo_print = "";
                $codigo_barra = $column['codigo_barra'];
                $inventariable = $column['inventariable'];
                $stock = $column['stock'];
                $stock_min = $column['stock_min'];

                if ($codigo_barra == '') {
                    $codigo_print = $column['codigo_interno'];
                } else {

                    $codigo_print = $codigo_barra;
                }

                if ($inventariable == 1) {

                    if ($stock >= 1 && $stock < $stock_min) {

                        $stock_print = '<span class="label label-warning label-rounded"><span
                            class="text-bold">POR AGOTARSE</span></span>';
                    } else if ($stock == $stock_min) {

                        $stock_print = '<span class="label label-info label-rounded"><span
                            class="text-bold">EN MINIMO</span></span>';
                    } else if ($stock > $stock_min) {

                        $stock_print = '<span class="label label-success label-rounded"><span
                            class="text-bold">DISPONIBLE</span></span>';
                    } else if ($stock <= 0 && $stock_min >= 1) {

                        $stock_print = '<span class="label label-danger label-rounded">
                            <span class="text-bold">AGOTADO</span></span>';
                    } else if ($stock == 0 && $stock_min == 0) {

                        $stock_print = '<span class="label label-default label-rounded">
                            <span class="text-bold">POR INVENTARIAR</span></span>';
                    } 

                } else {

                    $stock_print = '<span class="label label-primary label-rounded"><span
                                            class="text-bold">SERVICIO</span></span>';
                }

                
                $idsucursal = $column['idsucursal'];
                $nombre_sucursal = $column['nombre_sucursal'];
                $print_sucursal = '<span class="label label-success label-rounded"><span
                class="text-bold">'.$nombre_sucursal.'</span></span>';
                if ($idsucursal == 2) {
                    $print_sucursal = '<span class="label label-info label-rounded"><span
                            class="text-bold">'.$nombre_sucursal.'</span></span>';
                }elseif ($idsucursal == 3) {
                    $print_sucursal = '<span class="label label-warning label-rounded"><span
                            class="text-bold">'.$nombre_sucursal.'</span></span>';
                }elseif ($idsucursal == 4) {
                    $print_sucursal = '<span class="label label-primary label-rounded"><span 
                        class="text-bold">'.$nombre_sucursal.'</span></span>';
                }elseif ($idsucursal == 5) {
                    $print_sucursal = '<span class="label label-default label-rounded">
                            <span class="text-bold">'.$nombre_sucursal.'</span></span>';
                }elseif ($idsucursal == 6) {
                    $print_sucursal = '<span class="label label-danger label-rounded">
                    <span class="text-bold">'.$nombre_sucursal.'</span></span>';
                }


                ?>
                                <tr>
                                    <td><?php print($codigo_print); ?></td>
                                    <td><?php print($column['nombre_producto']); ?></td>
                                    <td><?php print($column['nombre_categoria']); ?></td>
                                    <td><?php print($column['nombre_marca']); ?></td>
                                    <td><?php print($column['nombre_presentacion']); ?></td>
                                    <!--<td><?//php print($column['nombre_color']); ?></td>-->
                                    <td><?php print($column['stock']); ?></td>
                                    <td>$ <?php print($column['precio_venta']); ?></td>
                                    <td>$ <?php print($column['precio_venta_minimo']); ?></td>
                                    <!--<td><?//php print($column['precio_venta_mayoreo']); ?></td>-->
                                    <!--<td><?//php print($column['precio_super_mayoreo']); ?></td>-->
                                    <td>$ <?php print($column['precio_compra']); ?></td>
                                    <td class="success"><?php print($stock_print); ?></td>
                                    <td><?php print($print_sucursal); ?></td>
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    
                                                    <li><a
                                                        href="javascript:;" data-toggle="modal" data-target="#modal_iconified"
                                                        onclick="openProducto('ver',
                                                            '<?php print($column["idproducto"]); ?>',
                                                            '<?php print($column["codigo_interno"]); ?>',
                                                            '<?php print($column["codigo_barra"]); ?>',
                                                            '<?php print($column["nombre_producto"]); ?>',
                                                            '<?php print($column["precio_compra"]); ?>',
                                                            '<?php print($column["precio_venta"]); ?>',
                                                            '<?php print($column["precio_venta_minimo"]); ?>',
                                                            '<?php print($column["precio_venta_mayoreo"]); ?>',
                                                            '<?php print($column["precio_super_mayoreo"]); ?>',
                                                            '<?php print($column["stock"]); ?>',
                                                            '<?php print($column["stock_min"]); ?>',
                                                            '<?php print($column["idcategoria"]); ?>',
                                                            '<?php print($column["idmarca"]); ?>',
                                                            '<?php print($column["idpresentacion"]); ?>',
                                                            '<?php print($column["estado"]); ?>',
                                                            '<?php print($column["exento"]); ?>',
                                                            '<?php print($column["inventariable"]); ?>',
                                                            '<?php print($column["perecedero"]); ?>',
                                                            '<?php print($column["idcolor"]); ?>')">
                                                        <i class=" icon-eye8">
                                                        </i> Ver</a></li>
                                                    <li><a
                                                        href="javascript:;" data-toggle="modal" data-target="#modal_iconified_barcode"
                                                        onclick="openBarcode(
                                                            '<?php print($column["codigo_barra"]); ?>',
                                                            '<?php print($column["codigo_interno"]); ?>',
                                                            '<?php print($column["nombre_producto"]); ?>',
                                                            '<?php print($column["idproducto"]); ?>')">
                                                        <i class="icon-barcode2">
                                                        </i>Codigo de Barra</a></li> 
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


        <?php } ?>
            </table>
        </div> 
    
    </div>
</div>

<!-- Iconified modal -->
<div id="modal_iconified" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title"><i class="icon-pencil7"></i> &nbsp; <span class="title-form"></span></h5>
            </div>

            <form role="form" autocomplete="off" class="form-validate-jquery" id="frmModal">
                <div class="modal-body" id="modal-container">

                    <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                        <span class="text-semibold">Estimado usuario</span>
                        los campos remarcados con <span class="text-danger"> * </span> son obligatorios.
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <input type="hidden" id="txtID" name="txtID" class="form-control" value="">
                        <input type="hidden" id="txtProceso" name="txtProceso" class="form-control" value="">
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Código de sistema</label>
                                <input type="text" id="txtCodigo" name="txtCodigo" placeholder="AUTOGENERADO"
                                       class="form-control" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();" readonly disabled="disabled">
                            </div>

                            <div class="col-sm-6">
                                <label>Código de Barra</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon-barcode2"></i></span>
                                    <input type="text" id="txtCodigoBarra" name="txtCodigoBarra" placeholder="100200102030"
                                           class="form-control" style="text-transform:uppercase;"
                                           onkeyup="javascript:this.value = this.value.toUpperCase();">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Nombre de Producto <span class="text-danger">*</span></label>
                                <input type="text" id="txtProducto" name="txtProducto" placeholder="EJEMPLO: HONOR MAGIC 5LITE 8/256GB"
                                       class="form-control" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-sm-6">
                                <label>Categoría de producto<span class="text-danger"> * </span></label>
                                <select  data-placeholder="Seleccione una categoria..." id="cbCategoria" name="cbCategoria"
                                         class="select-search" style="text-transform:uppercase;"
                                         onkeyup="javascript:this.value = this.value.toUpperCase();">
                                            <?php
                                            $filas = $objProducto->Listar_Categorias();
                                            if (is_array($filas) || is_object($filas)) {
                                                foreach ($filas as $row => $column) {
                                                    ?>
                                                                                        <option value="<?php print ($column["idcategoria"]) ?>">
                                                    <?php print ($column["nombre_categoria"]) ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label>Modelo de producto <span class="text-danger">*</span></label>
                                <select  data-placeholder="Seleccione un modelo..." id="cbPresentacion" name="cbPresentacion"
                                         class="select-search" style="text-transform:uppercase;"
                                         onkeyup="javascript:this.value = this.value.toUpperCase();">
                                            <?php
                                            $filas = $objProducto->Listar_Presentaciones();
                                            if (is_array($filas) || is_object($filas)) {
                                                foreach ($filas as $row => $column) {
                                            ?>
                                            <option value="<?php print ($column["idpresentacion"]) ?>">
                                                     <?php print ($column["siglas"]) ?></option>
                                                     <?php
                                                 }
                                            }
                                            ?>
                                </select>
                            </div>
                            
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                        
                            <div class="col-sm-6">
                                <label>Marca de producto <span class="text-danger">*</span></label>
                                <select  data-placeholder="Seleccione una marca..." id="cbMarca" name="cbMarca"
                                         class="select-search" style="text-transform:uppercase;"
                                         onkeyup="javascript:this.value = this.value.toUpperCase();">
                                             <?php
                                             $filas = $objProducto->Listar_Marcas();
                                             if (is_array($filas) || is_object($filas)) {
                                                 foreach ($filas as $row => $column) {
                                                     ?>
                                            <option value="<?php print ($column["idmarca"]) ?>">
                                                     <?php print ($column["nombre_marca"]) ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                </select>
                            </div>

                            <?php if ($tipo_usuario == '1'): ?>
                                <div class="col-sm-6">
                                    <label>Precio Compra <span class="text-danger">*</span></label>
                                    <input type="text" id="txtPCompra" name="txtPCompra" placeholder="0.00"
                                           class="touchspin-prefix" value="0" style="text-transform:uppercase;"
                                           onkeyup="javascript:this.value = this.value.toUpperCase();">
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Stock <span class="text-danger"> *</span></label>
                                <input type="text" id="txtStock" name="txtStock" placeholder="0.00"
                                       class="touchspin-prefix" value="0" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>

                            <div class="col-sm-6">
                                <label>Stock Mínino <span class="text-danger">*</span></label>
                                <input type="text" id="txtSMin" name="txtSMin" placeholder="0.00"
                                       class="touchspin-prefix" value="0" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>


                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Precio Venta Normal <span class="text-danger">*</span></label>
                                <input type="text" id="txtPVenta" name="txtPVenta" placeholder="0.00"
                                       class="touchspin-prefix" value="0" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>

                            <div class="col-sm-6">
                                <label>Precio Venta Oferta <span class="text-danger">*</span></label>
                                <input type="text" id="txtPVentaMinimo" name="txtPVentaMinimo" placeholder="0.00"
                                       class="touchspin-prefix" value="0" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>

                        </div>
                    </div>

                    <!--
                    <div class="form-group">
                        <div class="row">

                        </div>
                    </div>
                    -->

                    <div class="form-group" >
                        <div class="row" >

                            <div class="col-sm-4">
                                <div class="checkbox checkbox-switchery switchery-sm">
                                    <label>
                                        <input type="checkbox" id="chkExento" name="chkExento"
                                               class="switchery">
                                        <span id="lblchk-e">APLICA IVA</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-4" >
                                <div class="checkbox checkbox-switchery switchery-sm">
                                    <label>
                                        <input type="checkbox" id="chkPerece" name="chkPerece"
                                               class="switchery">
                                        <span id="lblchk-p">NO CADUCO</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-4" >
                                <div class="checkbox checkbox-switchery switchery-sm">
                                    <label>
                                        <input type="checkbox" id="chkInven" name="chkInven"
                                               class="switchery" checked="checked" >
                                        <span id="lblchk-i">INVENTARIABLE</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- hidden  col-sm-2  --> 
                    <div class="form-group" style="visibility: hidden; height: 0px; margin: auto;">
                        <div class="row" style="height: 0px;" >
                        
                            <div class="col-sm-2">
                                <div class="checkbox checkbox-switchery switchery-sm">
                                    <label>
                                        <input type="checkbox" id="chkEstado" name="chkEstado"
                                               class="switchery" checked="checked" >
                                        <span id="lblchk">VIGENTE</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <label>Color <span class="text-danger">*</span></label>
                                <select  data-placeholder="Seleccione un color..." id="cbColor" name="cbColor"
                                         class="select-search" style="text-transform:uppercase;"
                                         onkeyup="javascript:this.value = this.value.toUpperCase();">
                                            <?php
                                            $filas = $objProducto->Listar_Colores();
                                            if (is_array($filas) || is_object($filas)) {
                                                foreach ($filas as $row => $column) {
                                            ?>
                                            <option value="<?php print ($column["idcolor"]) ?>">
                                                     <?php print ($column["nombre_color"]) ?></option>
                                                     <?php
                                                 }
                                             }
                                            ?>
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <label>Precio Distribuidor(1) <span class="text-danger">*</span></label>
                                <input type="text" id="txtPVentaM" name="txtPVentaM" placeholder="0.00"
                                       class="touchspin-prefix" value="0" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>

                            <div class="col-sm-2">
                                <label>Precio Distribuidor(2) <span class="text-danger">*</span></label>
                                <input type="text" id="txtPSuperM" name="txtPSuperM" placeholder="0.00"
                                        class="touchspin-prefix" value="0" style="text-transform:uppercase;"
                                        onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>

                        </div>
                    </div>
                    <!-- hidden --> 


                </div>

                <div class="modal-footer">
                    <button id="btnGuardar" type="submit" class="btn btn-info">Guardar</button>
                    <button id="btnEditar" type="submit" class="btn btn-warning">Editar</button>
                    <button  type="reset" class="btn btn-default" id="reset"
                             class="btn btn-link" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Iconified modal -->
<div id="modal_iconified_barcode" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title"><i class="icon-printer"></i> &nbsp; <span class="title-form"></span></h5>
            </div>

            <form role="form" autocomplete="off" class="form-validate-jquery" id="frmPrint">
                <div class="modal-body" id="modal-container">

                    <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                        <span class="text-semibold">Estimado usuario</span>
                        los campos remarcados con <span class="text-danger"> * </span> son obligatorios.
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <input type="hidden" id="txtIDP" name="txtIDP" class="form-control" value="">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Nombre de Producto <span class="text-danger">*</span></label>
                                <input type="text" id="txtProductoP" name="txtProductoP" placeholder="EJEMPLO: POCO-X3 PRO 8-256GB "
                                       class="form-control" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-sm-6">
                                <label>Código de Barra</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon-barcode2"></i></span>
                                    <input type="text" id="txtCodigoBarraP" name="txtCodigoBarraP"
                                           placeholder="11320206505"
                                           class="form-control" style="text-transform:uppercase;"
                                           onkeyup="javascript:this.value = this.value.toUpperCase();">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Cantidad de etiquetas <span class="text-danger">*</span></label>
                                <input type="text" id="txtCant" name="txtCant" placeholder="0.00"
                                       class="touchspin-prefix" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-sm-6">
                                <label>Ancho de etiqueta (40-200mm) <span class="text-danger">*</span></label>
                                <input type="text" id="txtAncho" name="txtAncho"
                                       placeholder="0.00"
                                       class="touchspin-prefix" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>

                            <div class="col-sm-6">
                                <label>Alto de etiqueta (10-50mm) <span class="text-danger">*</span></label>
                                <input type="text" id="txtAlto" name="txtAlto"
                                       placeholder="0.00"
                                       class="touchspin-prefix" style="text-transform:uppercase;"
                                       onkeyup="javascript:this.value = this.value.toUpperCase();">
                            </div>

                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button id="btnPrint" type="submit" class="btn btn-info">Imprimir</button>
                    <button  type="reset" class="btn btn-default" id="reset"
                             class="btn btn-link" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>





<script type="text/javascript" src="web/custom-js/producto.js"></script>
