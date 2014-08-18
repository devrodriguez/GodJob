<?php 

require '../datos/db/Conexion_DB.php';

	class Comun
	{
		function Get_Data_Array($query)
		{
			$con = new Conexion_DB();
			$stat = $con->Open();
			
			if ($resi = $stat->query($query) or die('Error: '.mysqli_error($stat))) {
				$rows = array();
				while ($row = $resi->fetch_assoc()) {
					$rows[] = $row;
				}
				$resi->free();
				$con->Close();				
				return $rows;
			}	
		}

		function ConsultarMeses()
		{
			$con = new Conexion_DB();
			$stat = $con->Open();
			$query = "CALL ConsultarMesesAno();";

			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}
	}