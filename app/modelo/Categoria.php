<?php
	require '../datos/db/Conexion_DB.php';

	class Categoria
	{
		var $CA_ID;
		var $CA_Desc;

		function __construct($id, $desc){
			$this->CA_ID = $id;
			$this->CA_Desc = $desc;
		}

		function Ver()
		{
			$con = new Conexion_DB();
			$stat = $con->Open();
			$query = "CALL ConsultarCategorias();";

			if ($resi = $stat->query($query)) {
				$rows = array();
				while ($row = $resi->fetch_assoc()) {
					$rows[] = $row;
				}
				$resi->free();
				$con->Close();
				return json_encode($rows);
			}
		}
	}