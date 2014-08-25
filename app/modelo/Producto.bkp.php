<?php
	require '../datos/db/Conexion_DB.php';
	require '../phputil/Util.php';

	class Producto
	{
		var $orden;
		var $codigo;
		var $nombre;
		var $imagen;
		var $precio;
		var $iva;
		var $sucu;
		var $undMed;
		var $linea;
		var $cat;

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

		//function VerPorLinea($ini, $len)
		function VerPorLinea()
		{
			$query = "CALL ConsultarProductoPorLinea('$this->linea');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		//function VerPorLinea($ini, $len)
		function VerPorLineaSeccion($seccion)
		{
			$this->ExportToExcel();
			$query = "CALL ConsultarProductoPorLineaSecc('$this->linea', '$seccion');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		function ExportToExcel(){
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

		function ExportToExcelDet(){
			$url = array();
			$util = new Util();
			$query = "CALL ConsultarTodoOrden('$this->orden');";
			$rows = $this->Get_Data_Array($query);
			$urlFile = $util->ArrayAsocToExcel($rows, uniqid('Informe_'));
			$url['url'] = $urlFile;
			return json_encode($url);
		}

		function Ver()
		{
			$con = new Conexion_DB();
			$stat = $con->Open();
			$query = "CALL ConsultarProducto();";

			if ($resi = $stat->query($query) or die('Error: '.mysqli_error($stat))) {
				$rows = array();
				while ($row = $resi->fetch_assoc()) {
					$rows[] = $row;
				}
				$resi->free();
				$con->Close();
				return json_encode($rows);
			}
		}

		function VerOrdenDetalle()
		{
			$con = new Conexion_DB();
			$stat = $con->Open();
			$query = "CALL ConsultarOrdenDetalle('$this->orden');";

			if ($resi = $stat->query($query) or die('Error: '.mysqli_error($stat))) {
				$rows = array();
				while ($row = $resi->fetch_assoc()) {
					$rows[] = $row;
				}
				$resi->free();
				$con->Close();
				return json_encode($rows);
			}
		}

		function Crear()
		{
			$usuario = $_SESSION['userid'];
			$seccion = $_SESSION['seccion_id'];
			$con = new Conexion_DB();
			$stat = $con->Open();
			$query = "CALL CrearProducto('$this->nombre', '$this->imagen', '$this->precio', '$this->iva', '$this->sucu', '$this->unMed', '$this->linea', '$this->cat', '$seccion', '$usuario');";

			if ($resi = $stat->query($query) or die('Error: '.mysqli_error($stat))) {
				$rows = array();
				while ($row = $resi->fetch_assoc()) {
					$rows[] = $row;
				}
				$resi->free();
				$con->Close();
				return json_encode($rows);
			}	
		}

		function Actualizar()
		{
			$usuario = $_SESSION['userid'];
			$con = new Conexion_DB();
			$stat = $con->Open();
			$query = "CALL ActualizarProducto('$this->codigo', '$this->nombre', '$this->precio', '$this->iva', '$this->sucu', '$this->unMed', '$this->linea', '$this->cat', '$usuario');";

			if ($resi = $stat->query($query) or die('Error: '.mysqli_error($stat))) {
				$rows = array();
				while ($row = $resi->fetch_assoc()) {
					$rows[] = $row;
				}
				$resi->free();
				$con->Close();
				return json_encode($rows);
			} else {
				return 'codigo '.$this->codigo.'nombre '.$this->nombre.' Precio '.$this->precio.' Iva '.$this->iva.' sucu '.$this->sucu.' unidad '.$this->unMed.' linea '.$this->linea.' categoria '.$this->cat;
			}
		}

		function AsocProductoSeccion($seccion, $accion)
		{
			$this->ExportToExcel();
			$query = "CALL AsociarProductoSeccion('$this->codigo', '$seccion', '$accion');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		function VerProductoSeccion()
		{
			$this->ExportToExcel();
			$query = "CALL ConsultarProductoSeccion();";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		function EliminarProductoSeccion($seccion, $accion)
		{
			$this->ExportToExcel();
			$query = "CALL AsociarProductoSeccion('$this->codigo', '$seccion', '$accion');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

 		function GuardarImagen($img, $id)
		{
			$ext = pathinfo($img['name'], PATHINFO_EXTENSION);
			$ruta = '../ArchivosGuardados/ImagenProducto/'.$id.'.'.$ext;

			if (move_uploaded_file($img['tmp_name'], $ruta)) {
				$ruta = '../'.$ruta;
				$con = new Conexion_DB();
				$stat = $con->Open();
				$query = "CALL GuardarImagen('$ruta', '$id');";

				if ($resi = $stat->query($query) or die('Error: '.mysqli_error($stat))) {
					$rows = array();
					while ($row = $resi->fetch_assoc()) {
						$rows[] = $row;
					}
					$resi->free();
					$con->Close();
					return json_encode($rows);
				}
				//$rows = array(array('ruta'=>'../ArchivosGuardados/ImagenProducto/'.$_FILES['archivo']['name']));
				//return json_encode($rows);
			}
			else
			{
				$rows = array(array('respuesta'=>'ALGO FALLO'));
				return json_encode($rows);	
			}
		}
	}