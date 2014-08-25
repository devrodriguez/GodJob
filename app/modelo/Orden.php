<?php 
	require '../datos/GetDataComun.php';
	require '../phputil/Util.php';
	
	class Orden extends GetDataComun
	{
		protected $id;
		protected $producto;
		protected $unidad;
		protected $valTot;
		protected $estado;

		function __construct($id, $prod, $unds, $valTot, $estado)
		{
			$this->id = $id;
			$this->producto = $prod;
			$this->unidad = $unds;
			$this->valTot = $valTot;
			$this->estado = $estado;
		}

		public function Ver()
		{
			$query = "CALL ConsultarOrden('$this->id');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function VerPorLineaSeccion($linea, $seccion){
			$usuario = $_SESSION['userid'];
			$query = "CALL ConsultarOrdenLineaSecc('$linea', '$seccion', '$usuario');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function VerTodo()
		{
			$query = "CALL ConsultarTodoOrden('$this->id');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);	
		}

		public function Crear()
		{
			$usuario = $_SESSION['userid'];
			$query = "CALL CrearOrden(0, 1, '$usuario');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function CrearDescripcion($id, $producto, $unidad, $obs)
		{
			$query = "CALL CrearDescripcionOrden('$id', '$producto', '$unidad', '$obs');";
			$rows = $this->Get_Data_Array($query);
			return $rows;
		}

		public function CambiarEstado()
		{
			$usuario = $_SESSION['userid'];
			$query = "CALL CambiarEsadoOrden('$this->id', '$this->estado', '$usuario');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);			
		}		

		public function EliminarProducto($producto){
			$query = "CALL EliminarProductoOrden('$this->id', '$producto');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function EditarCantProductoOrden($producto, $cantidad){
			$query = "CALL EditarCantProductoOrden('$this->id', '$producto', '$cantidad');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function EnviarCorreoOrdenCreada($orden)
		{
			$headers = array();

			$query = "CALL ConsultarOrden('$orden');";
			$rows = $this->Get_Data_Array($query);

			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-type: text/html; charset=iso-8859-1";
			$headers[] = "FROM: informacion@godjob.com.co";
			$subject = "Nueva Orden - ".$_SESSION['seccion'];
			$bodyHTML = '
			<html>
			<body>
			<h1>Orden No. <strong>'.$orden.'</strong></h1>
			<h2>Generada por el usuario <strong>'.$rows[0]['Usuario Genera'].'</strong></h2>
			</body>
			</html>';

			mail("javier.riano@hotmail.com,john.rodriguez.25@hotmail.com", $subject, $bodyHTML, implode("\r\n", $headers));
		}

		public function ExportToExcel(){
			$usuario = $_SESSION['userid'];
			$url = array();
			$util = new Util();
			$linea = intval($_SESSION['linea_prod']);
			$seccion = intval($_SESSION['seccion_id']);
			$query = "CALL ConsultarOrdenLineaSecc('$linea', '$seccion', '$usuario');";
			$rows = $this->Get_Data_Array($query);
			$urlFile = $util->ArrayAsocToExcel($rows, uniqid('Informe_'));
			$url['url'] = $urlFile;
			return json_encode($url);
		}

		public function ExportToExcelEdit(){
			$url = array();
			$util = new Util();
			$query = "CALL ConsultarOrden('$this->id');";
			$rows = $this->Get_Data_Array($query);
			$urlFile = $util->ArrayAsocToExcel($rows, uniqid('Informe_'));
			$url['url'] = $urlFile;
			return json_encode($url);
		}
	}