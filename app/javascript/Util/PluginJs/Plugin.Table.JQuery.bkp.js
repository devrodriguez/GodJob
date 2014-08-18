(function($){
	var expImg = /imagen/gi;
	
    function _getData(source, ini, len){
        return Ajax_DatQuery(source.path, source.param + '&ini='+ini+'&len='+len, source.met);
    }

    function _createRows(data){
    	var $tbody = $('<tbody></tbody>');
        $.each(data, function(id, item){
        		var $tr = $('<tr></tr>');
                //BOTON IZQUIERDA//
                $.each(opt.btn_detail, function(name, props){
                    var $td = $('<td class="btn_table_detail"></td>');
                    //Validar si es una funcion o son atributos
                    var props = $.isFunction( props ) ? { click: props, text: name } : props;
                    //Extiende el objeto props con el tipo de objeto (button)
                    //props = $.extend( { type: "button" }, props );
                    //Se extrae la funcion
                    var click = props.click;
                    //Se crea el evento asociando la funcion pasada como parametro al evento del boton
                    props.click = function(){
                        click.apply(this, arguments );
                    };
                    //Se agrega el boton creado                    
                    $('<a></a>', props).appendTo($td);
                    $tr.append($td)
                });

                //CELDAS (td)//
                $.each(item, function(id, item){
                    if ($.inArray(id, opt.fields) >= 0) {
                        if (expImg.test(id.toLowerCase())) {
                            if(item == '')
                                $tr.append("<td><img src=\"../../ArchivosGuardados/ImagenUtil/no_disponible_grande.gif\" class=\"img_mini\" /></td>");
                            else
                                $tr.append("<td><img src=\"" +item + "\" class=\"img_mini\" /></td>");
                        } else {
                            $tr.append("<td>" +item + "</td>");
                        };
                        $tbody.append($tr)
                    };
                });

                //BOTON DERECHA//
                $.each(opt.btn_addToCar, function(name, props){
                    var $td = $('<td class="add_car"></td>');
                    //Validar si es una funcion o son atributos
                    var props = $.isFunction( props ) ? { click: props, text: name } : props;
                    //Extiende el objeto props con el tipo de objeto (button)
                    //props = $.extend( { type: "button" }, props );
                    //Se extrae la funcion
                    var click = props.click;
                    //Se crea el evento asociando la funcion pasada como parametro al evento del boton
                    props.click = function(){
                        click.apply(this, arguments );
                    };

                    //Se agrega el boton creado                    
                    $('<a></a>', props).appendTo($td);
                    $tr.append($td)
                });
        });
		return $tbody;
    }

    $.fn.extend({
        createTable: function(options){
            opt = $.extend({
		        data: [],
		        styleCss: 'table_info',
		        caption: '',
		        btn_addRow: '',
		        btn_addToCar: '',//Derecha
		        btn_detail: '',//Izquierda
		        fields: [],
		        sourceData : {}
		    }, options);
            var that = this;
            //Extender data//
            var _data = _getData(opt.sourceData, 0, opt.sourceData.dataLenght);
            opt.data = $.extend(opt.data, _data);


            return this.each(function(){
                if(opt.data){
                    that = this;
                    var thead = "<thead>";
                    var $tbody = "";
                    var hdfId = "";
                    var capt = "";

                    //CREAR CAPTION//
                    if(opt.caption)
                        capt = "<caption>"+opt.caption+"</caption>";
                    
                    //CREAR ENCABEZADO DE LA TABLA//
                    thead += "<tr>";
                    if(opt.btn_detail)
                        thead += '<th class="invisible"></th>'
                    $.each(Object.keys(opt.data[0]), function(id, item){
                        //console.log('item: ' + item + ' field: ' + opt.fields + ' esta: ' + $.inArray(item, opt.fields))
                        if ($.inArray(item, opt.fields) >= 0) {
                            thead += "<th>" + item + "</th>"; 
                        }
                    });
                    if(opt.btn_addToCar)
                        thead += '<th class="invisible"></th>'
                    thead += "</tr>";
                    thead += "</thead>";

                    //CREAR EL CUERPO DE LA TABLA//
                    $tbody = _createRows(opt.data);
                    //***************************//

                    //AGREGAR DATOS A LA TABLA//
                    $(this).empty();
                    $('<table></table>').addClass(opt.styleCss).append(capt + thead).append($tbody).appendTo(this);

                }
                //BOTON AGREGAR PRODUCTO//
                $.each(opt.btn_addRow, function(name, props){    
                    //Validar si es una funcion o son atributos
                    var props = $.isFunction( props ) ? { click: props, text: name } : props;
                    //Extiende el objeto props con el tipo de objeto (button)
                    var props = $.extend( { type: "button" }, props );
                    //Se extrae la funcion
                    var click = props.click;
                    //Se crea el evento asociando la funcion pasada como parametro al evento del boton
                    props.click = function(){
                        click.apply( that, arguments );
                    };
                    //Se agrega el boton creado                    
                    $('<button></button>', props).button().appendTo(that);
                });

                //MAXIFICAR IMAGEN//
                $($(this).find('tr')).on('click', '.img_mini', function(event){
                    var that = this;
                    var $dv = $('<div><img /></div>').appendTo('body');
                    $dv.find('img').attr('src', this.src);
                    $dv.dialog({
                        autoOpen: true,
                        modal: true,
                        resizable: false,
                        maxWidth: 600,
                        width: 'auto',
                        close: function(){ $dv.dialog('destroy').remove() }
                    });
                });

                //Accion SCROLL//
                $(this).scroll(function(){
                	//alert();
                })
            });
        },
        appendRow: function(options){
            var opt = $.extend({
                data: []
            }, options);
            
            return this.each(function(){
                var $table = $(this).find('table:first');
                var tr = '';
                
                tr += "<tr>";
                $.each(opt.data, function(id, item){
                    tr += "<td>" + item + "</td>";
                });
                tr += "</tr>";    
                $table.append(tr);
            });
        }
    });
})(jQuery);


