<?php

	class Producto {

		public static function Print_Barcode($idproducto){

			$filas = ProductoModel::Print_Barcode($idproducto);
			return $filas;

		}

		public static function Listar_Colores(){

			$filas = ProductoModel::Listar_Colores();
			return $filas;
		
		}


		public static function Listar_Productos($idsucursal){

			$filas = ProductoModel::Listar_Productos($idsucursal);
			return $filas;

		}

		public static function Listar_Productos_Filtros($idsucursal, $idcategoria){

			$filas = ProductoModel::Listar_Productos_Filtros($idsucursal, $idcategoria);
			return $filas;

		}


		public static function Autocomplete_Producto($search, $idsucursalcompra){

			$filas = ProductoModel::Autocomplete_Producto($search, $idsucursalcompra);
			return $filas;

		}

		public static function Listar_Productos_Activos($idsucursal, $idcategoria){

			$filas = ProductoModel::Listar_Productos_Activos($idsucursal, $idcategoria);
			return $filas;

		}

		public static function Listar_Productos_Inactivos($idsucursal, $idcategoria){

			$filas = ProductoModel::Listar_Productos_Inactivos($idsucursal, $idcategoria);
			return $filas;

		}

		public static function Listar_Productos_Agotados($idsucursal, $idcategoria){

			$filas = ProductoModel::Listar_Productos_Agotados($idsucursal, $idcategoria);
			return $filas;

		}

		public static function Listar_Productos_Vigentes($idsucursal, $idcategoria){

			$filas = ProductoModel::Listar_Productos_Vigentes($idsucursal, $idcategoria);
			return $filas;

		}


		public static function Listar_Perecederos(){

			$filas = ProductoModel::Listar_Perecederos();
			return $filas;

		}

		public static function Listar_No_Perecederos(){

			$filas = ProductoModel::Listar_No_Perecederos();
			return $filas;

		}


		public static function Listar_Categorias(){

			$filas = ProductoModel::Listar_Categorias();
			return $filas;

		}

		public static function Listar_Marcas(){

			$filas = ProductoModel::Listar_Marcas();
			return $filas;

		}

		public static function Listar_Presentaciones(){

			$filas = ProductoModel::Listar_Presentaciones();
			return $filas;

		}

		public static function Listar_Proveedores(){

			$filas = ProductoModel::Listar_Proveedores();
			return $filas;

		}

		public static function Elimimar_Producto($idproducto){

			$cmd = ProductoModel::Eliminar_Producto($idproducto);

		}

		public static function Insertar_Producto($codigo_barra, $nombre_producto, $precio_compra, $precio_venta, $precio_venta_mayoreo, $precio_super_mayoreo,
		$stock,$stock_min, $idcategoria, $idmarca, $idpresentacion, $exento, $inventariable, $perecedero, $idsucursal,$idcolor,$precio_venta_minimo){

			$cmd = ProductoModel::Insertar_Producto($codigo_barra, $nombre_producto, $precio_compra, $precio_venta, $precio_venta_mayoreo, $precio_super_mayoreo,
			$stock,$stock_min, $idcategoria, $idmarca, $idpresentacion, $exento, $inventariable, $perecedero, $idsucursal,$idcolor,$precio_venta_minimo);

		}

		public static function Editar_Producto($idproducto, $codigo_barra, $nombre_producto, $precio_compra, $precio_venta, $precio_venta_mayoreo, $precio_super_mayoreo,
		$stock, $stock_min, $idcategoria, $idmarca, $idpresentacion, $estado, $exento, $inventariable, $perecedero, $idsucursal,$idcolor,$precio_venta_minimo){

			$cmd = ProductoModel::Editar_Producto($idproducto, $codigo_barra, $nombre_producto, $precio_compra, $precio_venta, $precio_venta_mayoreo, $precio_super_mayoreo,
			$stock, $stock_min, $idcategoria,$idmarca, $idpresentacion, $estado, $exento, $inventariable, $perecedero, $idsucursal,$idcolor,$precio_venta_minimo);

		}

		public static function Listar_CodigoProducto(){

			$filas = ProductoModel::Listar_CodigoProducto();
			return $filas;

		}

		public static function Listar_Productos_Categoria($idsucursal, $categoria){

			$filas = ProductoModel::Listar_Productos_Categoria($idsucursal, $categoria);
			return $filas;

		}

		public static function Insertar_CodigoProducto($codigo_uno,$codigo_dos,$idproducto){

			$cmd = ProductoModel::Insertar_CodigoProducto($codigo_uno,$codigo_dos,$idproducto);

		}

		public static function Editar_CodigoProducto($idcodigo,$codigo_uno,$codigo_dos,$idproducto){

			$cmd = ProductoModel::Editar_CodigoProducto($idcodigo,$codigo_uno,$codigo_dos,$idproducto);

		}





	}


 ?>
