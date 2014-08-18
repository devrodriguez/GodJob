(function($){
    $.fn.extend({
        createTable: function(options){
            var opt = $.extend({
                data: [],
                styleCss: 'table_info',
                caption : '',
                btn_addRow : '',
                btn_addToCar : '',//Derecha
                btn_detail : '',//Izquierda
                exportar : false,
                fields: []
            }, options);

            var that = this;

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

            //Element Edit//
            var elemEdit = {
                inpText : '<input type="text" />',
                check : '<input type="checkbox" />'
            }

            return this.each(function(){
                if(opt.data.length > 0){
                    that = this;
                    var thead = "<thead>";
                    var $tbody = $('<tbody></tbody>');                    
                    var expImg = /imagen/gi;
                    var hdfId = "";
                    var capt = "";

                    //Caption//
                    if(opt.caption){
                        if (opt.exportar)
                            capt = "<caption><a href=\"#\" class=\"btn_exp_excel\"><img alt=\"Exportar\" title=\"Exportar a Excel\" src=\"../../imagenes/icono/excel.jpg\" /></a>"+opt.caption+"</caption>";
                        else
                            capt = "<caption>"+opt.caption+"</caption>";
                    }
                    
                    //Encabezado//
                    thead += "<tr>";
                    if(opt.btn_detail)
                        thead += '<th class="invisible"></th>'
                    //Se recorreo la primera fila de los datos obteniendo el nombre de las llaves//
                    $.each(Object.keys(opt.data[0]), function(id, item){
                        //se evalua si el nombre de la llave es igual a alguno de los objetos enviados como campos//
                        var titem = opt.fields[item] === undefined ? null : opt.fields[item];
                        if (titem) {
                            item = titem.titulo == undefined ? item : titem.titulo;
                            thead += "<th>" + item + "</th>"; 
                        }
                    });
                    if(opt.btn_addToCar){
                        thead += '<th class="invisible"></th>'
                    }
                    thead += "</tr>";
                    thead += "</thead>";
                    // Cuerpo
                    $.each(opt.data, function(id, item){
                        var $tr = $('<tr></tr>');
                            //Boton izquierda//
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

                            //Celdas//
                            $.each(item, function(id, item){                                
                                var titem = opt.fields[id] === undefined ? null : opt.fields[id];
                                if (titem) {
                                    if (titem.imagen) {
                                        if(item == ''){
                                            $tr.append("<td><img src=\"../../ArchivosGuardados/ImagenUtil/no_disponible_grande.gif\" class=\"img_mini\" /></td>");
                                        }else{
                                            $tr.append("<td><img src=\"" +item + "\" class=\"img_mini\" /></td>");
                                        }
                                    } else {
                                        //Si recibe el parametro de miles y si el dato es numerico//
                                        if(titem.miles && !isNaN(item)){
                                            $tr.append("<td>" + formatNumber.new(item, "$") + "</td>");
                                        }else{
                                            if(titem.edita & item != ''){
                                                $tr.append('<td><input type="text" value="' + item + '" /></td>');                                                
                                            }else{
                                                $tr.append('<td>' + item + '</td>');
                                            }
                                        }
                                    };
                                };
                            });

                            if(item.Codigo != ''){
                                //boton derecha//
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
                            }
                        $tr.appendTo($tbody);
                    });
                    
                    //Agregar datos a la tabla//
                    $(this).empty();
                    $('<table></table>').addClass(opt.styleCss).append(capt + thead).append($tbody).appendTo(this);
                    
                    //Crear spinner para modificar cantidad//
                    if(opt.fields.Cantidad != undefined){
                        $(this).find('input[type="text"]').css('width', '50px').spinner({
                            min: 1,
                            change: opt.fields.Cantidad.fun
                        });
                    }
                }
                //Boton de agregar producto//
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
                    $('<button></button>', props).button().appendTo('<div style="margin:auto;text-align:center;"></div>').parent().prependTo(that);
                });

                //Maxificar imagen//
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
            });
        },
        appendRow: function(options){
            var opt = $.extend({
                data: [{}]
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


