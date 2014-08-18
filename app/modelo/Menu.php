<?php
	session_cache_expire(1);
	session_start();
	require '../datos/db/Conexion_DB.php';

	$userId = $_SESSION['userid'];
	$userName = $_SESSION['username'];

	$con = new Conexion_DB();
	$stat = $con->Open();
	$query = "CALL ConsultarMenuUsuario('$userId');";

	if ($resi = $stat->query($query)) {
		$rows = array();
		while ($row = $resi->fetch_assoc()) {
			$rows[] = $row;
		}
		$resi->free();
		$con->Close();
		echo json_encode($rows);
	}
	