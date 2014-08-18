<?php
	session_start();
	require '../datos/db/Conexion_DB.php';
	
		if (isset($_POST['txtUser']) && isset($_POST['txtPass'])) {
			$con = new Conexion_DB();
			$stat = $con->Open();
			$usuario = $_POST['txtUser'];
			$pass = $_POST['txtPass'];

			$query = "CALL ValidarLogin('$usuario', '$pass');";

			if ($resi = $stat->query($query)) {
				$rows = array();
				while ($row = $resi->fetch_assoc()) {
					$rows[] = $row;
				}
				$resi->free();
				$con->Close();

				//Asignar valores de sesion//
				$_SESSION['userid'] = $rows[0]["id"];
				$_SESSION['username'] = $rows[0]["us"];
				$_SESSION['name'] = $rows[0]["nombre"];
				$_SESSION['seccion_id'] = $rows[0]["secid"];
				$_SESSION['seccion'] = $rows[0]["seccion"];
			}

			if (intval($rows[0]["cant"]) > 0) {
				header('location: ../vista/InicioLinea.php');
			} else {
				header('location: Inicio.html?men=1');
			}
		}
		else
		{
			header('location: Inicio.html');
		}
