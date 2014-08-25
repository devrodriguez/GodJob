<?php 
	session_start();
	require '../datos/GetDataComun.php';
	
	if (isset($_GET['_accion']) && $_GET['_accion'] == 'meses') {
		$util = new GetDataComun();
		echo $util->ConsultarMeses();
	}