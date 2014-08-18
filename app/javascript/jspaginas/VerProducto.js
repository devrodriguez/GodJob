;
$(document).on('ready', function(){
	//Menu//
	var data_menu = Ajax_DatQuery('../../modelo/Menu.php', {});
    $('#dvMenu').createMenuUI({
        data: data_menu
    });
    
	var dataProd = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=verxlineasec&_linea=' + $('#hdfLinea').val(), 'GET');
	$('<div></div>').appendTo('body').createTable({
		data : dataProd,
		caption : 'Productos',
		exportar : true,
		fields : {
				"Descripcion" : {},
				"Codigo" : {},
				"Precio" : {miles: true},
				"IVA" : {},
				"Imagen" : {imagen: true},
				"Medida" : {}
		}		
	});

		//Eventos//
	$('.btn_exp_excel').on('click', function(){
		var dataExp = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=toexcel', 'GET');
		var pathFile = '../../ArchivosGuardados/ExcelExport/' + dataExp.url;
		$(this).attr('href', pathFile);
	});
});