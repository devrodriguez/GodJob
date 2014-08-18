<?php
	session_start();
	require '../modelo/Producto.php';

	if (isset($_FILES['archivo'])) {
		$url;
		$producto = new Producto(0, '', '', '', '', '', '', '', '', '');
		$url = $producto->GuardarImagen($_FILES['archivo'], $_POST['hdfIdProd']);
		echo "<script type='text/javascript'>parent.ObtenerUrl('$url');</script>";
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'ver')
	{
		$producto = new Producto(0, '', '', '', '', '', '', '', '', '');
		echo $producto->Ver();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'verxlinea')
	{
		$producto = new Producto(0, '', '', '', '', '', '', '', intval($_SESSION['linea_prod']), '');
		echo $producto->VerPorLinea();
		//echo $producto->VerPorLinea($_GET['ini'], $_GET['len']);
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'verxlineasec')
	{
		$producto = new Producto(0, '', '', '', '', '', '', '', intval($_SESSION['linea_prod']), '');
		echo $producto->VerPorLineaSeccion(intval($_SESSION['seccion_id']));
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'crear')
	{
		$producto = new Producto('', '', $_GET['_nombre'], '', $_GET['_precio'], $_GET['_iva'], $_GET['_sucu'], $_GET['_undMed'], intval($_SESSION['linea_prod']), $_GET['_catego']);
		echo $producto->Crear();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'actualizar')
	{
		$producto = new Producto('', $_GET['_codigo'], $_GET['_nombre'], '', $_GET['_precio'], $_GET['_iva'], $_GET['_sucu'], $_GET['_undMed'], $_GET['_linea'], $_GET['_catego']);
		echo $producto->Actualizar();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'verXorden'){
		$producto = new Producto($_GET['_orden'],'', '', '', '', '', '', '', '', '');
		echo $producto->VerOrdenDetalle();
	}
	else if (isset($_GET['_accion']) && $_GET['_accion'] == 'toexcel') {
		$producto = new Producto(0, '', '', '', '', '', '', '', '', '');
		echo $producto->ExportToExcel();
	}
	else if (isset($_GET['_accion']) && $_GET['_accion'] == 'toexceldet') {
		$producto = new Producto($_GET['_orden'], '', '', '', '', '', '', '', '', '');
		echo $producto->ExportToExcelDet();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'asocprod')
	{
		$producto = new Producto('', $_GET['_producto'], '', '', '', '', '', '', '', '');
		echo $producto->AsocProductoSeccion($_GET['_seccion'], $_GET['_accioncrud']);
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'verasoc')
	{
		$producto = new Producto('', '', '', '', '', '', '', '', '', '');
		echo $producto->VerProductoSeccion();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'elimasoc')
	{
		$producto = new Producto('', $_GET['_producto'], '', '', '', '', '', '', '', '');
		echo $producto->EliminarProductoSeccion($_GET['_seccion'], $_GET['_accioncrud']);
	}