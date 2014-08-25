<?php
	session_start();
	require '../phputil/Util.php';
	require '../datos/GetDataComun.php';

	class Informes extends GetDataComun
	{
		function InfVentasMens($mes)
		{
			$seccion = intval($_SESSION['seccion_id']);
			$seccion = 3;
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