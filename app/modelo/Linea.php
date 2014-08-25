<?php
	require '../datos/GetDataComun.php';

	class LineaProducto extends GetDataComun
	{
		protected $LP_ID;
		protected $LP_Desc;

		function __construct($id, $desc){
			$this->LP_ID = $id;
			$this->LP_Desc = $desc;
		}

		public function Ver()
		{
			$con = new Conexion_DB();
			$stat = $con->Open();
			$query = "CALL ConsultarLineaProducto();";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}
	}