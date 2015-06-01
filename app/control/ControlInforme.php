<?php
	require '../modelo/Informes.php';
	
	if($_GET['_accion'] == 'verxmes')
	{	
		$informe = new Informes();
		echo $informe->InfVentasMens($_GET['_mes'], $_GET['_ano']);
	}
	else if (isset($_GET['_accion']) && $_GET['_accion'] == 'ordmens_ex') {
		$informe = new Informes();
		echo $informe->OrdenMensualToExcel($_GET['_mes'], $_GET['_ano']);
	}