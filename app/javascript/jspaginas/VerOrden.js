;
$(document).on('ready', function(){
	//Menu//
	var data_menu = Ajax_DatQuery('../../modelo/Menu.php', {}, 'POST');
    $('#dvMenu').createMenuUI({
        data: data_menu
    });
    
	var dataOrd = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=verxlineasec', 'GET');
	$('<div></div>').appendTo('body').createTable({
		data : dataOrd,
		caption : 'Ordenes',
		exportar : true,
		fields : {
			'Orden': {}, 
			'Valor': {miles:true}, 
			'Estado': {}, 
			'Usuario Genera' : {},
			'Fecha Generacion': {}			
		},
		btn_detail : {
			'Ver' : VerDetalle
		},
		btn_addToCar : {
			'X' : EliminarOrden
		}
	});

	//Eventos//
	$('.btn_exp_excel').on('click', function(){
		var dataExp = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=toexcel', 'GET');
		$(this).attr('href', '../../ArchivosGuardados/ExcelExport/' + dataExp.url);
	});
});

function VerDetalle(){
	var $tr = $(this).parents('tr:first')
	var no_orden = $tr.find('td:eq(1)').text();
	var dataProOrd = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=verXorden&_orden=' + no_orden, 'GET');
	if(dataProOrd){
		$('<div id="dvDetOrd"></div>').createTable({
			caption : 'Productos Orden',
			exportar : true,
	        data : dataProOrd,
	        fields : {
	        	'Codigo' : {},
	        	'Nombre': {}, 
	        	'Precio': {miles: true}, 
	        	'Cantidad': {}, 
	        	'IVA': {},
	        	'Medida': {}
	        }
	    }).dialog({
	    	autoOpen : true,
	    	modal: true,
	    	resizable : false,
	    	width : 'auto'
	    });

	    //Exportar//
	    $('body').on('click', '#dvDetOrd .btn_exp_excel', function(){
			var dataExp = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=toexceldet&_orden=' + no_orden, 'GET');
			$(this).attr('href', '../../ArchivosGuardados/ExcelExport/' + dataExp.url);
		});
	}
}

function EliminarOrden(){
	var that = this;
	$('<div></div>').text('La orden se eliminara de forma permanente').dialog({
        autoOpen: true,
        modal: true,
        buttons: {
            'Si' : function(){
            	var $tr = $(that).parents('tr:first');
				var no_orden = $tr.find('td:eq(1)').text();		
				var dataOrd = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=cambiaEst&_orden=' + no_orden + '&_estado=3', 'GET');

				if(parseInt(dataOrd[0].id) > 0){
					$tr.remove();
				} else {
					$('<div></div>').jalert({message: 'La orden debe estar en estado GENERADA.'});
				}
				//Cerrar
                $(this).dialog('close');
            },
            'No': function(){
            	//Cerrar
            	$(this).dialog('close');
            }
        },
        create: function(event, ui){
            $(this).parents('div:first').find(".ui-dialog-titlebar").remove();
        },
        close: function(){
        	//Eliminar
            $(this).remove();
        }
    });
}