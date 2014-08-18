<?php
	require '../datos/db/Conexion_DB.php';

	class LineaProducto
	{
		var $LP_ID;
		var $LP_Desc;

		function __construct($id, $desc){
			$this->LP_ID = $id;
			$this->LP_Desc = $desc;
		}

		function Ver()
		{
			$con = new Conexion_DB();
			$stat = $con->Open();
			$query = "CALL ConsultarLineaProducto();";

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