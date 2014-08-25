<?php
	require '../phputil/Util.php';
	require '../datos/GetDataComun.php';

	class Producto extends GetDataComun
	{
		protected $orden;
		protected $codigo;
		protected $nombre;
		protected $imagen;
		protected $precio;
		protected $iva;
		protected $sucu;
		protected $undMed;
		protected $linea;
		protected $cat;

		function __construct($orden, $codigo, $nombre, $imagen, $precio, $iva, $sucu, $unMed, $linea, $cat)
		{
			$this->orden = $orden;
			$this->codigo = $codigo;
			$this->nombre = $nombre;
			$this->imagen = $imagen;
			$this->precio = $precio;
			$this->iva = $iva;
			$this->sucu = $sucu;
			$this->unMed = $unMed;
			$this->linea = $linea;
			$this->cat = $cat;
		}

		public function Crear()
		{
			$usuario = $_SESSION['userid'];
			$seccion = $_SESSION['seccion_id'];
			$query = "CALL CrearProducto('$this->nombre', '$this->imagen', '$this->precio', '$this->iva', '$this->sucu', '$this->unMed', '$this->linea', '$this->cat', '$seccion', '$usuario');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function Actualizar()
		{
			$usuario = $_SESSION['userid'];
			//$con = new Conexion_DB();
			//$stat = $con->Open();
			$query = "CALL ActualizarProducto('$this->codigo', '$this->nombre', '$this->precio', '$this->iva', '$this->sucu', '$this->unMed', '$this->linea', '$this->cat', '$usuario');";
			$rows = $this->Get_Data_Array($query);
			//if ($resi = $stat->query($query) or die('Error: '.mysqli_error($stat))) {
			if(!empty($rows))
			{
				/*$rows = array();
				while ($row = $resi->fetch_assoc()) {
					$rows[] = $row;
				}
				$resi->free();
				$con->Close();*/
				return json_encode($rows);
			} else {
				return 'codigo '.$this->codigo.'nombre '.$this->nombre.' Precio '.$this->precio.' Iva '.$this->iva.' sucu '.$this->sucu.' unidad '.$this->unMed.' linea '.$this->linea.' categoria '.$this->cat;
			}
		}

		public function VerOrdenDetalle()
		{
			$query = "CALL ConsultarOrdenDetalle('$this->orden');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function Ver()
		{
			$query = "CALL ConsultarProducto();";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function VerPorLinea()
		{
			$query = "CALL ConsultarProductoPorLinea('$this->linea');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		//function VerPorLinea($ini, $len)
		public function VerPorLineaSeccion($seccion)
		{
			$this->ExportToExcel();
			$query = "CALL ConsultarProductoPorLineaSecc('$this->linea', '$seccion');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function ExportToExcel(){
			$url = array();
			$util = new Util();
			$linea = intval($_SESSION['linea_prod']);
			$seccion = intval($_SESSION['seccion_id']);
			$query = "CALL ConsultarProductoPorLineaSecc('$linea', '$seccion');";
			$rows = $this->Get_Data_Array($query);
			$urlFile = $util->ArrayAsocToExcel($rows, uniqid('Informe_'));
			$url['url'] = $urlFile;
			return json_encode($url);
		}

		public function ExportToExcelDet(){
			$url = array();
			$util = new Util();
			$query = "CALL ConsultarTodoOrden('$this->orden');";
			$rows = $this->Get_Data_Array($query);
			$urlFile = $util->ArrayAsocToExcel($rows, uniqid('Informe_'));
			$url['url'] = $urlFile;
			return json_encode($url);
		}

		public function AsocProductoSeccion($seccion, $accion)
		{
			$query = "CALL AsociarProductoSeccion('$this->codigo', '$seccion', '$accion');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function VerProductoSeccion()
		{
			$query = "CALL ConsultarProductoSeccion();";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		public function EliminarProductoSeccion($seccion, $accion)
		{
			$query = "CALL AsociarProductoSeccion('$this->codigo', '$seccion', '$accion');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

 		public function GuardarImagen($img, $id)
		{
			$ext = pathinfo($img['name'], PATHINFO_EXTENSION);
			$ruta = '../ArchivosGuardados/ImagenProducto/'.$id.'.'.$ext;

			if (move_uploaded_file($img['tmp_name'], $ruta)) {
				$ruta = '../'.$ruta;
				$con = new Conexion_DB();
				$stat = $con->Open();
				$query = "CALL GuardarImagen('$ruta', '$id');";
				$rows = $this->Get_Data_Array($query);
				return json_encode($rows);
			}
			else
			{
				$rows = array(array('respuesta'=>'ALGO FALLO'));
				return json_encode($rows);	
			}
		}
	}