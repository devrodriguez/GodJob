<?php
	require '../datos/GetDataComun.php';

	class Categoria extends GetDataComun
	{
		protected $CA_ID;
		protected $CA_Desc;

		function __construct($id, $desc){
			$this->CA_ID = $id;
			$this->CA_Desc = $desc;
		}

		function Ver()
		{
			$query = "CALL ConsultarCategorias();";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}
	}