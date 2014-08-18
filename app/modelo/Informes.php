<?php
	session_start();
	require '../datos/db/Conexion_DB.php';
	require '../phputil/Util.php';

	class Informes
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

		function InfVentasMens($mes)
		{
			$seccion = intval($_SESSION['seccion_id']);
			$seccion = 3;
			$con = new Conexion_DB();
			$stat = $con->Open();
			$query = "CALL Inf_ConsultarOrdenMensual('$mes', '$seccion');";

			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}
		
		function OrdenMensualToExcel($mes){
			$url = array();
			$util = new Util();
			$seccion = intval($_SESSION['seccion_id']);
			$query = "CALL Inf_ConsultarOrdenMensual('$mes', '$seccion');";
			$rows = $this->Get_Data_Array($query);
			$urlFile = $util->ArrayAsocToExcel($rows, uniqid('Informe_'));
			$url['url'] = $urlFile;
			return json_encode($url);
		}
	}