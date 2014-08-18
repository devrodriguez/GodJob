<?php
	require '../modelo/Linea.php';
	
	if($_GET['_accion'] == 'ver')
	{	
		$line = new LineaProducto('','');
		echo $line->Ver();
	}