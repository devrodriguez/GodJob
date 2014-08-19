;
$(document).on('ready', function(){
	//Menu//
	var data_menu = Ajax_DatQuery('../../modelo/Menu.php', {}, 'POST');
    $('#dvMenu').createMenuUI({
        data: data_menu
    });
    
	$.ajaxSetup({ cache: false });

	$('<div></div>', {id: 'dvOrdDet', title: ':: Cambiar Estado de Orden ::'}).dialog({
		autoOpen: false,
		modal: true,
		rezisable: false,
		maxHeight: $(window).height() * 0.9,
		maxWidth: $(window).width() * 0.9,
		width: 'auto',
		buttons: {
			'Aprobar' : AprobarOrden,
			'Rechazar' : RechazarOrden
		},
		close: function(){
			$(this).dialog('close');
		}
	});
	CargarTabla();
});

function CargarTabla(){
    //## Crear Tabla ##//
    var dataOrd = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=ver&_id=-1', 'GET');
    if(dataOrd){
	    $('#dvTab').empty();
	    $('#dvTab').createTable({
	        data : dataOrd,
	        caption : 'Ordenes Realizadas',
	        exportar : true,
	        fields : {
	        	"Orden" : {},
	        	"Valor" : {miles: true},
	        	"Estado" : {},
	        	'Usuario Genera' : {},
	        	"Fecha Generacion" : {},
	        	"Fecha Despacho" : {},
	        	"Fecha Aprobacion" : {}
	        },
	        btn_detail : {
	        	'Editar' : VerDetalleOrden
	        } 
	    });
	}

	//Eventos//
	$('.btn_exp_excel').on('click', function(){
		var dataExp = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=toexceledit', 'GET');
		$(this).attr('href', '../../ArchivosGuardados/ExcelExport/' + dataExp.url);
	});
}

function VerDetalleOrden(){
	var $tr = $(this).parents('tr:first')
	no_orden = $tr.find('td:eq(1)').text();
	
	//Obtener productos por orden//
	var dataProOrd = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=verXorden&_orden=' + no_orden, 'GET');
	if(dataProOrd){
		$('#dvOrdDet').createTable({
	        data : dataProOrd,
	        caption : 'Productos Orden',
	        exportar : true,
	        fields : {
	        	'Codigo' : {},
	        	'Nombre' : {},
	        	'Precio' : {miles: true},
	        	'IVA': {},
	        	'Medida': {},
	        	'Cantidad': {edita:true, fun: EditarCantidad},
	        	'Observacion' : {}
	        },
	        btn_addToCar : {
	        	'X' : EliminarProductoOrden
	        }
	    });
	    $('#dvOrdDet').dialog('option', 'title', 'Orden No. ' + no_orden).dialog('open');

	    //Exportar//
	    $('body').on('click', '#dvOrdDet .btn_exp_excel', function(){
			var dataExp = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=toexceldet&_orden=' + no_orden, 'GET');
			$(this).attr('href', '../../ArchivosGuardados/ExcelExport/' + dataExp.url);
		});
	}
}

function AprobarOrden(){
	$('<div></div>').text('¿Desea aprobar esta orden?').dialog({
		autoOpen: true,
		closeOnEscape: false,
		modal: true,
		resizable: false,
		buttons: {
			'Si' : function(){
				//Cerrar dialog actual//
				$(this).dialog('close');
				$(this).remove();
				var dataAprOrd = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=cambiaEst&_orden=' + no_orden + '&_estado=2', 'GET');
				if(parseInt(dataAprOrd[0].id) > 0){
					$('#dvOrdDet').dialog('close');
					CargarTabla();
					CargarFormato(no_orden);
				}
			},
			'No' : function(){
				$(this).dialog('close');
				$(this).remove();
			}
		},
		create: function(event, ui){
			$(this).parents('div:first').find(".ui-dialog-titlebar").remove();
		},
		close: function(){
			$(this).dialog('close');
			$(this).remove();
		}
	});
}

function RechazarOrden(){
	$('<div></div>').text('¿Desea rechazar esta orden?').dialog({
		autoOpen: true,
		closeOnEscape: false,
		modal: true,
		resizable: false,
		buttons: {
			'Si': function(){
				$(this).dialog('close');
				$(this).remove();
				var dataAprOrd = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=cambiaEst&_orden=' + no_orden + '&_estado=4', 'GET');
				if(parseInt(dataAprOrd[0].id) > 0){
					$('#dvOrdDet').dialog('close');
					CargarTabla();
				}
			},
			'No': function(){
				$(this).dialog('close');
				$(this).remove();
			}
		},
		create: function(event, ui){
			$(this).parents('div:first').find(".ui-dialog-titlebar").remove()
		},
		close: function(){
			$(this).dialog('close');
			$(this).remove();
		}
	});
}

function CargarFormato(orden){
	$('<div></div>').load('FormatoOrden.php #dvFormOrden', function(){
		LlenarFormato(orden, this)
		$(this).dialog({
			autoOpen: true,
			modal: true,
			resizable : false,
			width: 'auto',
			maxHeight: $(window).height() * 0.9
		});
	});
}

function EliminarProductoOrden(){
	var $tr = $(this).parents('tr:first'); 
	var cod_prod = $tr.find('td:eq(0)').text();
	$('<div><p>¿Desea eliminar este producto de la orden actual?</p></div>').dialog({
		autoOpen: true,
		modal: true,
		resizable: false,
		buttons: {
			'Si' : function(){
				var data = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=elimprod&_orden=' + no_orden + '&_producto=' + cod_prod, 'GET');
				if (parseInt(data[0].id) >= 0) {
					$tr.remove();
					CargarTabla();
					$(this).dialog('close');
					$(this).remove();
				} else {
					$(this).dialog('close');
					$(this).remove();

					$('<div><p>No se pudo eliminar el producto porque la orden debe estar en estado <strong>GENERADA</strong></p></div>').dialog({
						autoOpen: true,
						resizable: false,
						modal: true,
						buttons: {
							'Aceptar' : function(){
								$(this).dialog('close');
								$(this).remove();
							}
						},
						create: function(event, ui){
							$(this).parents('div:first').find(".ui-dialog-titlebar").remove()
						},
					})
				};
			},
			'No' : function(){
				$(this).dialog('close');
				$(this).remove();
			}
		},
		close: function(){
			$(this).dialog('destroy');
			$(this).remove();
		}
	});
}

function EditarCantidad(){
	var $tr = $(this).parents('tr:first');
	var prod = $tr.find('td:eq(0)').text();
	var dataOrd = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=editcant&_orden=' + no_orden + '&_producto=' + prod + '&_cantidad=' + this.value, 'GET');
	console.log(parseInt(dataOrd[0].id))
	if (parseInt(dataOrd[0].id) > 0) {
		CargarTabla();
	}
}
