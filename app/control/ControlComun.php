<?php 
	session_start();
	require '../modelo/Comun.php';
	
	if (isset($_GET['_accion']) && $_GET['_accion'] == 'meses') {
		$comun = new Comun();
		echo $comun->ConsultarMeses();
	}