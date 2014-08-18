;
$(document).on('ready', function(){
	//Menu//
	var data_menu = Ajax_DatQuery('../../modelo/Menu.php', {}, 'POST');
    $('#dvMenu').createMenuUI({
        data: data_menu
    });

	//Cargar lista de meses//
	CargarListaMeses();
	$('#slMes').on('change', function(){
		CargarTabla($(this).val());
	})
});

function CargarTabla(mes){
    $('<div id="dvLoad">Loading...</div>').loading('open')
    //## Crear Tabla ##//
    var dataOrd = Ajax_DatQuery('../../control/ControlInforme.php', '_accion=verxmes&_mes=' + mes, 'GET');
    if(dataOrd){
	    $('#dvTab').empty();
	    $('#dvTab').createTable({
	        data : dataOrd,
	        caption : 'Informe Mensual Por Secci&#243;n',
	        exportar : true,
	        fields : {
	        	"orden" : {},
	        	"fecha aprobacion" : {},
	        	"centro de costo" : {},
	        	"cod. producto" : {},
	        	"producto" : {},
	        	"und. medida" : {},
	        	"cantidad" : {},
	        	"val. unitario" : {miles:true},
	        	"val. total" : {miles:true},
	        	"iva" : {},
	        	"linea" : {},
	        	"estado" : {}
	        } 
	    });
	    $('#dvLoad').dialog('destroy').remove();
	}
	
	$('.btn_exp_excel').on('click', function(){
		var dataExp = Ajax_DatQuery('../../control/ControlInforme.php', '_accion=ordmens_ex&_mes=' + mes, 'GET');
		$(this).attr('href', '../../ArchivosGuardados/ExcelExport/' + dataExp.url);
	});
}

function CargarListaMeses(){
	var dataMeses = Ajax_DatQuery('../../control/ControlComun.php', '_accion=meses', 'GET');
	$.each(dataMeses, function(id, item){
		$('#slMes').append('<option value="' + item.ME_NumMes + '">' + item.ME_Desc + '</option>')
	})
}