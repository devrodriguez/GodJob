var objProd = {
    _accion : '',
    _codigo : '',
    _nombre : '',
    _imagen : '',
    _precio : '',
    _iva : '',
    _sucu : '',
    _undMed : '',
    _linea : '',
    _catego : ''
}


$(document).on('ready', function(){
    //Menu//
    var data_menu = Ajax_DatQuery('../../modelo/Menu.php', {}, 'POST');
    $('#dvMenu').createMenuUI({
        data: data_menu
    });
    //-----//
    
	var dataProd;
	var dataUnd;
	var dataLin;
	var dataCat;
	var dataSelUnd;
	var newTab;
	var opt;

    $('#newProd').dialog({
        autoOpen: false,
        modal: true
    })

    //Menu//
    $('#dvMenu').createMenuUI({
        data: data_menu
    });
    
    //Traer datos y crear tabla//
    CargarTabla();

    //## Llenar lista unidad ##//
    dataUnd = Ajax_DatQuery('../../control/ControlUnidadMedida.php', '_accion=ver');
    $('#txtUnid').autocomplete({
    	source: function(request, response){
			response($.map(dataUnd, function(item){
				return{
					label: item.UM_Desc,
					value: item.UM_ID
				}
			}));
    	},
    	select: function(event, ui){
    		if (ui.item && ui.item.value) {
    			this.value = ui.item.label;
                objProd._undMed = ui.item.value;
    		};
    		event.preventDefault();
    	},
        change: function(event, ui){
            alert(ui.item.value)
        },
    	autoFocus: true,
    	minLength: 0
    });
    
    //## Llenar linea producto ##//
    dataLin = Ajax_DatQuery('../../control/ControlLineaProducto.php', '_accion=ver');
    $('#txtLinea').autocomplete({
    	source: function(request, response){
			response($.map(dataLin, function(item){
				return{
					label: item.LP_Desc,
					value: item.LP_ID
				}
			}));
    	},
    	select: function(event, ui){
    		if (ui.item && ui.item.value) {
    			this.value = ui.item.label;
                objProd._linea = ui.item.value;
    		};
    		event.preventDefault();
    	},
    	autoFocus: true,
    	minLength: 0
    });

    //## Llenar categoria ##//
    /*dataCat = Ajax_DatQuery('../../control/ControlCategoria.php', '_accion=ver');
    $('#txtCat').autocomplete({
    	source: function(request, response){
			response($.map(dataCat, function(item){
				return{
					label: item.CA_Desc,
					value: item.CA_ID
				}
			}));
    	},
    	select: function(event, ui){
    		if (ui.item && ui.item.value) {
    			this.value = ui.item.label;
                objProd._catego = ui.item.value;
    		};
    		event.preventDefault();
    	},
    	autoFocus: true,
    	minLength: 0
    });*/

    //## Eventos #//
    $('#txtNom').on('blur', function(){
        objProd._nombre = this.value;
    });
    $('#txtPre').on('blur', function(){
        objProd._precio = this.value;
    });
    $('#txtIva').on('blur', function(){
        objProd._iva = this.value;
    });
});

function GuardarProducto(accion, cod){
    var res = 0;
    objProd._codigo = cod;
    objProd._accion = accion;
    objProd._sucu = 1;
    res = Ajax_DatQuery('../../control/ControlProducto.php', $.param(objProd));
    if (parseInt(res[0].id) > 0) {
        $('#hdfIdProd').val(res[0].id);
        $('#frmEnvArc').submit();
    };
}

function CargarTabla(){
    //## Crear Tabla ##//
    var dataProd = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=verxlineasec&_linea=' + $('#hdfLinea').val(), 'GET');
    $('#dvTab').empty();
    $('#dvTab').createTable({
        data : dataProd,
        caption : 'Productos',
        fields : {
            'Descripcion': {},
            'Codigo': {}, 
            'Precio': {miles: true}, 
            'IVA': {}, 
            'Imagen': {imagen: true}, 
            'Medida': {}, 
            'Linea': {}, 
            'Categoria': {}
        },
        btn_addRow : {
            '+ Crear Producto' : function(){
                //## Dialogo de nuevo producto ##//
                $('#newProd').dialog('option', 'buttons', null)
                $('#newProd').dialog('option', 'title', 'Crear Producto')
                $('#newProd').dialog('option', 'buttons', [{text: 'Guardar', click: function() { GuardarProducto('crear', 0) }}])
                $('#newProd').dialog('open');         
            }       
        },
        btn_addToCar : {
            'Editar' : function(){
                var $tr = $(this).parents('tr:first');
                var cod = $tr.find('td:eq(0)').text();
                $('#newProd').dialog('option', 'buttons', null)
                $('#newProd').dialog('option', 'title', 'Producto No.' +cod)
                $('#newProd').dialog('option', 'buttons', [{text: 'Actualizar', click: function() { GuardarProducto('actualizar', cod) }}])
                $('#newProd').dialog('open');         
            }
        }
    });
}

function ReiniciarDatos(){
    $('#newProd input[type="text"]').val('');
    $.each(objProd, function(id, item){
        item = '';
    });
}

function ObtenerUrl(url){
    ReiniciarDatos();
    CargarTabla();
    $('#newProd').dialog('close');
}

