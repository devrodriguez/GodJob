;
function Ajax_DatQuery(_urlCl, _data, _metodo){
	var dataJQ;
	$.ajax({
		async: false,
		cache: false,
		contentType: 'application/json',
		data: _data,
		dataType: 'json',
		type: _metodo,
		url: _urlCl,		
		success: function(data){
			dataJQ = data;
		},
		error: function(jqXHR, exception){
			if (jqXHR.status === 0) {
                 alert('Not connect.\n Verify Network.');
             } else if (jqXHR.status == 404) {
                 alert('Requested page not found. [404]');
             } else if (jqXHR.status == 500) {
                 alert('Internal Server Error [500].');
             } else if (exception === 'parsererror') {
                 alert('Requested JSON parse failed.');
             } else if (exception === 'timeout') {
                 alert('Time out error.');
             } else if (exception === 'abort') {
                 alert('Ajax request aborted.');
             } else {
                 alert('Uncaught Error.\n' + jqXHR.responseText);
             }
		}
	});
	return dataJQ;
}

if (!Object.keys) {
  Object.keys = (function () {
    'use strict';
    var hasOwnProperty = Object.prototype.hasOwnProperty,
        hasDontEnumBug = !({toString: null}).propertyIsEnumerable('toString'),
        dontEnums = [
          'toString',
          'toLocaleString',
          'valueOf',
          'hasOwnProperty',
          'isPrototypeOf',
          'propertyIsEnumerable',
          'constructor'
        ],
        dontEnumsLength = dontEnums.length;

    return function (obj) {
      if (typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
        throw new TypeError('Object.keys called on non-object');
      }

      var result = [], prop, i;

      for (prop in obj) {
        if (hasOwnProperty.call(obj, prop)) {
          result.push(prop);
        }
      }

      if (hasDontEnumBug) {
        for (i = 0; i < dontEnumsLength; i++) {
          if (hasOwnProperty.call(obj, dontEnums[i])) {
            result.push(dontEnums[i]);
          }
        }
      }
      return result;
    };
  }());
}

//Cambiar contraseña para todas las paginas//
$(document).on('ready', function(){
    var $div = $('<div title="Cambiar Contrase&#241;a"></div>');
    var table = '<table><tr><td>Contrase&#241;a Anterior</td><td><input id="txtAnt" type="text" /></td></tr><tr><td>Contrase&#241;a Nueva</td><td><input id="txtNue" type="text" /></td></tr></table>';

    $div.append(table);

    $('#canCon').on('click', function(event){
      $($div).dialog({
        autoOpen: true,
        modal: true,
        resizable: false,
        buttons: {
          'Actualizar' : function(){
            var ant = $('#txtAnt').val();
            var nue = $('#txtNue').val();
            var usu = $('#hdfIdUsu').val();

            var dataCamb = Ajax_DatQuery('../../control/ControlUsuario.php', '_accion=cambcont&_usuario='+usu+'&_anterior='+ant+'&_nueva='+nue);
            if(parseInt(dataCamb[0].id) > 0){
              $(this).remove();
              alert('Contrase\u00f1a actualizada.');
            } else {
              alert('No es posible cambiar la contrase\u00f1a.');
            }
          }
        }
      });
    });
});

//formato de miles//
var formatNumber = {
    separador: ".", // separador para los miles
    sepDecimal: ',', // separador para los decimales
    formatear:function (num){
       num +='';
       var splitStr = num.split('.');
       var splitLeft = splitStr[0];
       var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
       var regx = /(\d+)(\d{3})/;
       while (regx.test(splitLeft)) {
        splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
       }
       return this.simbol + splitLeft  +splitRight;
    },
    new:function(num, simbol){
       this.simbol = simbol ||'';
       return this.formatear(num);
    }
}