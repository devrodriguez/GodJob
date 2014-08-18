<?php
	require '../modelo/UnidadMedida.php';
	
	if($_GET['_accion'] == 'ver')
	{	
		$unidad = new UnidadMedida('','');
		echo $unidad->Ver();
	}
