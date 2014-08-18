;
$(document).on('ready', function(){
	//Menu//
	var data_menu = Ajax_DatQuery('../../modelo/Menu.php', {});
    $('#dvMenu').createMenuUI({
        data: data_menu
    });

    CargarTablaAsociacion();

    //Button//
    $('#btnAsoc').button();
    $('#btnAsoc').on('click', function(){
    	var producto = $('#hdfProd').val();
    	var seccion = $('#hdfSecc').val();
    	var data_asoc = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=asocprod&_accioncrud=insertar&_producto='+producto+'&_seccion='+seccion);
    	if(parseInt(data_asoc[0].id) > 0){
    		CargarTablaAsociacion();
    	} else {
    		alert('Fallo');
    	}
    });

    //Autocompletar//
    //## Llenar lista producto ##//
    var dataProd = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=ver');
    $('#txtProd').autocomplete({
    	source: function(request, response){
			response($.map(dataProd, function(item){
				return{
					label: item.Descripcion,
					value: item.Codigo
				}
			}));
    	},
    	select: function(event, ui){

    		if (ui.item && ui.item.value) {
    			this.value = ui.item.label;
    			$('#hdfProd').val(ui.item.value)
    		};
    		event.preventDefault();
    	},
    	autoFocus: true,
    	minLength: 0
    });

    //Llenar lista Seccion
    var dataSecc = Ajax_DatQuery('../../control/ControlUsuario.php', '_accion=conssecc');
    $('#txtSecc').autocomplete({
    	source: function(request, response){
			response($.map(dataSecc, function(item){
				return{
					label: item.SE_Desc,
					value: item.SE_ID
				}
			}));
    	},
    	select: function(event, ui){
    		if (ui.item && ui.item.value) {
    			this.value = ui.item.label;
    			$('#hdfSecc').val(ui.item.value);
    		};
    		event.preventDefault();
    	},
    	autoFocus: true,
    	minLength: 0
    });
});

//Tabla de Asociacion//
function CargarTablaAsociacion(){
    //## Crear Tabla ##//
    var dataProd = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=verasoc', 'GET');
    $('#dvTab').empty();
    $('#dvTab').createTable({
        data : dataProd,
        caption : 'Distribuci&#243;n Producto',
        fields : {
            'Codigo': {},
            'Producto': {},
            'Id' : {}, 
            'Seccion': {}
        },
        btn_addToCar : {
            'Eliminar' : function(){
            	var $tr = $(this).parents('tr:first');
            	var producto = $tr.find('td:eq(0)').text();
            	var seccion = $tr.find('td:eq(2)').text();
                var dataElimAsoc = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=elimasoc&_accioncrud=eliminar&_producto='+producto+'&_seccion='+seccion, 'GET');
                if(parseInt(dataElimAsoc[0].id) > 0){
	    			$tr.remove();
	    		} else {
	    			alert('Fallo');
	    		}
            }
        }
    });
}