;
$(document).on('ready', function(){
	//Menu//
	var data_menu = Ajax_DatQuery('../../modelo/Menu.php', {});
    $('#dvMenu').createMenuUI({
        data: data_menu
    });
    
	//var dataProd = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=verxlinea&_linea=' + $('#hdfLinea').val(), 'GET');
	$('<div></div>').css({
		'overflow-y': 'auto',
		 'height' : 150//($(window).height() * 0.8)
	}).appendTo('body').createTable({
		caption : 'Productos',
		fields : ['Descripcion', 'Codigo', 'Precio', 'IVA', 'Imagen', 'Und. Medida'],
		sourceData : {
			path : '../../control/ControlProducto.php',
			param : '_accion=verxlineasec&_linea=' + $('#hdfLinea').val(),
			met : 'GET',
			dataLenght : 3
		}
	});
});