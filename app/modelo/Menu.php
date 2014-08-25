<?php
	session_cache_expire(1);
	session_start();
	require '../datos/GetDataComun.php';
	
	$data = new GetDataComun();
	$userId = $_SESSION['userid'];
	$userName = $_SESSION['username'];
	$query = "CALL ConsultarMenuUsuario('$userId');";

	$rows = $data->Get_Data_Array($query);
	echo json_encode($rows);
	