<?php 
	session_start();
	require '../modelo/Orden.php';
	
	if (isset($_GET['_accion']) && $_GET['_accion'] == 'ver') {
		$orden = new Orden(intval($_GET['_id']), '','', '', '');
		echo $orden->Ver();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'verxlineasec')
	{
		$orden = new Orden('', '', '', '', '');
		echo $orden->VerPorLineaSeccion(intval($_SESSION['linea_prod']), intval($_SESSION['seccion_id']));
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'vertodo'){
		$orden = new Orden(intval($_GET['_id']), '','', '', '');
		echo $orden->VerTodo();		
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'crear')
	{	
		$orden = new Orden('','','', 0, 1);
		echo $orden->Crear();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'crearDetalle')
	{
		$ins = array();
		$ordenDes = new Orden('','','','','');
		$obj = json_decode($_GET['data'], true);
		foreach ($obj["productos"] as $value) {
			$ins[] = $ordenDes->CrearDescripcion(intval($value["idOrd"]), intval($value["idPr"]), intval($value["und"]), $value["obs"]);
		}
		//Enviar correo//
		//var_dump($obj["productos"][0]["idOrd"]);
		$ordenDes->EnviarCorreoOrdenCreada(intval($obj["productos"][0]["idOrd"]));
		echo json_encode($ins);
	} 
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'cambiaEst')
	{
		$ordenAprob = new Orden(intval($_GET['_orden']),'','','',intval($_GET['_estado']));
		echo $ordenAprob->CambiarEstado();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'elimprod')
	{
		$ordenElim = new Orden(intval($_GET['_orden']),'','','','');
		echo $ordenElim->EliminarProducto(intval($_GET['_producto']));	
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'editcant')
	{
		$ordenEditProd = new Orden(intval($_GET['_orden']),'','','','');
		echo $ordenEditProd->EditarCantProductoOrden(intval($_GET['_producto']), intval($_GET['_cantidad']));	
	}
	else if (isset($_GET['_accion']) && $_GET['_accion'] == 'toexcel') {
		$ordenExp = new Orden('', '', '', '', '');
		echo $ordenExp->ExportToExcel(intval($_SESSION['linea_prod']), intval($_SESSION['seccion_id']));
	}
	else if (isset($_GET['_accion']) && $_GET['_accion'] == 'toexceledit') {
		$ordenExp = new Orden(-1, '', '', '', '');
		echo $ordenExp->ExportToExcelEdit();
	}