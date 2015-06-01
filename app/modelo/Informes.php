<?php
	session_start();
	require '../phputil/Util.php';
	require '../datos/GetDataComun.php';

	class Informes extends GetDataComun
	{
		function InfVentasMens($mes, $ano)
		{
			$seccion = intval($_SESSION['seccion_id']);
			$seccion = 3;
			$query = "CALL Inf_ConsultarOrdenMensual('$mes', '$ano', '$seccion');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}
		
		function OrdenMensualToExcel($mes, $ano){
			$url = array();
			$util = new Util();
			$seccion = intval($_SESSION['seccion_id']);
			$query = "CALL Inf_ConsultarOrdenMensual('$mes', '$ano', '$seccion');";
			$rows = $this->Get_Data_Array($query);
			$urlFile = $util->ArrayAsocToExcel($rows, uniqid('Informe_'));
			$url['url'] = $urlFile;
			return json_encode($url);
		}
	}