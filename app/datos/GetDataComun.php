<?php 

require 'db/Conexion_DB.php';

	class GetDataComun extends Conexion_DB
	{
		function Get_Data_Array($query)
		{
			$stat = $this->Open();
			if ($resi = $stat->query($query) or die('Error: '.mysqli_error($stat))) {
				$rows = array();
				while ($row = $resi->fetch_assoc()) {
					$rows[] = $row;
				}
				$resi->free();
				$this->Close();				
				return $rows;
			}	
		}

		function ConsultarMeses()
		{
			$query = "CALL ConsultarMesesAno();";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}
	}