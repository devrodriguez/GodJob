<?php
	require '../datos/GetDataComun.php';

	class UnidadMedida extends GetDataComun
	{
		protected $UM_ID;
		protected $UM_Desc;

		function __construct($id, $desc){
			$this->UM_ID = $id;
			$this->UM_Desc = $desc;
		}

		function Ver()
		{
			$query = "CALL ConsultarUnidadMedida();";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}
	}