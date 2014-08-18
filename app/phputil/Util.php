<?php 
	require 'PHPExcel/PHPExcel.php';

	class Util
	{
		
		function __construct()
		{
			
		}

		function ArrayAsocToExcel($arrData, $nameFile)
		{
			$filePath = $nameFile.'.xlsx';
			// Crea un nuevo objeto PHPExcel
			$objPHPExcel = new PHPExcel();
			$cell = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

			// Establecer propiedades
			$objPHPExcel->getProperties()
			->setCreator("Cattivo")
			->setLastModifiedBy("Cattivo")
			->setTitle("Documento Excel de Prueba")
			->setSubject("Documento Excel de Prueba")
			->setDescription("Demostracion sobre como crear archivos de Excel desde PHP.")
			->setKeywords("Excel Office 2007 openxml php")
			->setCategory("Pruebas de Excel");

			# Agregar Informacion #

			$k=0;// Columna
			$x=0;// Fila

			// Recorrer Filas //
			foreach ($arrData as $key => $value) {
				$x++;
				// Recorrer Columnas //
				foreach ($value as $key => $value) {
					// Agregar Encabezado //
					if ($x == 1) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell[$k].$x, $key);
					}
					// Llenar Celdas //
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell[$k].($x+1), $value);
					$k++;
				}
				$k=0;// Volver a columna inicial //
			}
						
			// Renombrar Hoja
			$objPHPExcel->getActiveSheet()->setTitle('Tecnologia Simple');

			// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
			$objPHPExcel->setActiveSheetIndex(0);

			// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			//header('Content-Disposition: attachment;filename="pruebaReal.xlsx"');
			//header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('../ArchivosGuardados/ExcelExport/'.$filePath);
			
			return $filePath; 
		}
	}
 ?>