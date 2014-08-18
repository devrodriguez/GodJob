;
var objUsu = {
    _accion : '',
    _codigo : '',
    _identi : '',
    _nombre : '',
    _usuario : '',
    _contr : '',
    _correo : '',
    _perfil : '',
    _seccion : ''
}

$(document).on('ready', function(){
	//Crear Dialog nuevo usuario//
	$('#newUsu').dialog({
        autoOpen: false,
        modal: true
    });

    CrearTablaUsuarios();

	//## Llenar perfil usuario ##//
    dataPerf = Ajax_DatQuery('../../control/ControlUsuario.php', '_accion=consperfil');
    $('#txtPerf').autocomplete({
    	source: function(request, response){
			response($.map(dataPerf, function(item){
				return{
					label: item.PE_Desc,
					value: item.PE_ID
				}
			}));
    	},
    	select: function(event, ui){
    		if (ui.item && ui.item.value) {
    			this.value = ui.item.label;
                objUsu._perfil = ui.item.value;
    		};
    		event.preventDefault();
    	},
    	autoFocus: true,
    	minLength: 0
    });

    //## Llenar perfil usuario ##//
    dataSecc = Ajax_DatQuery('../../control/ControlUsuario.php', '_accion=conssecc');
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
                objUsu._seccion = ui.item.value;
    		};
    		event.preventDefault();
    	},
    	autoFocus: true,
    	minLength: 0
    });

	//Asignar datos que no son listas//
	$('#txtIdent').on('blur', function(){
        objUsu._identi = this.value;
    });
    $('#txtNom').on('blur', function(){
        objUsu._nombre = this.value;
    });
    $('#txtUsu').on('blur', function(){
        objUsu._usuario = this.value;
    });
    $('#txtCont').on('blur', function(){
        objUsu._contr = this.value;
    });
    $('#txtCorr').on('blur', function(){
        objUsu._correo = this.value;
    });
});

function CrearTablaUsuarios(){
	var dataProd = Ajax_DatQuery('../../control/ControlUsuario.php', '_accion=ver', 'GET');
	$('#dvTab').empty();
	$('#dvTab').appendTo('body').createTable({
		data : dataProd,
		caption : 'Usuarios',
		exportar : false,
		fields : {
				"Id" : {},
				"Documento" : {},
				"Nombre" : {},
				"Perfil" : {},
				"Seccion" : {},
				"Usuario" : {},
				"Clave" : {},
				"Correo" : {}
		},
		btn_addRow : {
            '+ Crear Usuario' : function(){
                //## Dialogo de nuevo producto ##//
                $('#newUsu').dialog('option', 'buttons', null)
                $('#newUsu').dialog('option', 'title', 'Crear Usuario')
                $('#newUsu').dialog('option', 'buttons', [{text: 'Guardar', click: function() { GuardarUsuario('crear', 0) }}])
                $('#newUsu').dialog('open');         
            }       
        },
        btn_addToCar : {
            'Editar' : function(){
                var $tr = $(this).parents('tr:first');
                var cod = $tr.find('td:eq(0)').text();
                $('#newUsu').dialog('option', 'buttons', null)
                $('#newUsu').dialog('option', 'title', 'Usuario No.' + cod)
                $('#newUsu').dialog('option', 'buttons', [{text: 'Actualizar', click: function() { GuardarUsuario('actualizar', cod) }}])
                $('#newUsu').dialog('open');         
            }
        }
	});
}

function GuardarUsuario(accion, cod){
    var res = 0;
    objUsu._accion = accion;
    objUsu._codigo = cod;
    res = Ajax_DatQuery('../../control/ControlUsuario.php', $.param(objUsu));
    console.log(parseInt(res[0].id));
    if (parseInt(res[0].id) > 0) {
        CrearTablaUsuarios();
        ReiniciarDatos();
    };
}

function ReiniciarDatos(){
    $('#newUsu input[type="text"]').val('');
    $.each(objUsu, function(id, item){
        item = '';
    });
    $('#newUsu').dialog('close');
}