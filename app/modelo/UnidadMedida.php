<?php
	require '../datos/db/Conexion_DB.php';

	class UnidadMedida
	{
		var $UM_ID;
		var $UM_Desc;

		function __construct($id, $desc){
			$this->UM_ID = $id;
			$this->UM_Desc = $desc;
		}

		function Ver()
		{
			$con = new Conexion_DB();
			$stat = $con->Open();
			$query = "CALL ConsultarUnidadMedida();";

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