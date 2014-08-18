<?php
	require '../modelo/Categoria.php';
	
	if($_GET['_accion'] == 'ver')
	{	
		$cat = new Categoria('','');
		echo $cat->Ver();
	}