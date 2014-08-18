;
(function($){
	$.fn.extend({
		carrito: function(options){
			var items = '';
			var opt = $.extend({
				data : [],
				botones : []
			}, options);
			
			return this.each(function(){
				var click, contain;
				that = this;
								
				$.each(opt.data, function(id, item){
					items += '<tr><td>' + item[0].nombre + '</td><td>' + item[0].precio + '</td><td>'+ item[0].medida +'</td><td><img class=\"img_mini\" src=\"../../imagenes/Logo.png\"/></td><td><buttom class="elim_item_car">x</buttom></td></tr>';
				});
				$('<table></table>', {width : '100%'}).html(items).appendTo(this);				
			});
		},
		agregar : function(options){
			var items = '';
			var opt = $.extend({
				spinFun : '',
				data : [],
				btn_del : {
					'Eliminar' : function(){
						//Eliminar fila//
						$(this).parents('tr:first').remove();
						//Cotar productos//
						$('#btnCar #spCant').text('(' + $(that).find('table tr').length + ')');
						//Si no hay filas se cierra el cuadro de dialogo//
						if($(that).find('table tr').length == 0){
							$(that).dialog('close');
						}
					}
				}
			}, options);

			return this.each(function(){
				var that = this;
				var $tr = $('<tr></tr>');
				var $td = $('<td></td>');
				var $ids = $(this).find('table tr [id*=hdfId]');//Todos los id que existen//
				var ins = true;
				$.each($ids, function(key, val){
					//Evalua por id si el producto existe, de existir incrementa en 1 la cantidad//
					if (val.value == opt.data.idProd) {
						$txt = $(this).parents('tr:first').find('[id*=txtCant]');
						$txt.val(parseInt($txt.val()) + 1);
						ins = false;
					}					
				});
				//Si el producto no existe (Validacion anterior) se agrega//
				if(ins){
					$tr.append('<td><input type="hidden" id="hdfId' + opt.data.idProd + '" value="'+ opt.data.idProd +'" />'
						+ '<input type="hidden" id="hdfPreUn' + opt.data.idProd + '" value="' + opt.data.precio + '" />'
						+ opt.data.nombre + '</td><td>' + opt.data.precio + '</td><td>'+opt.data.medida
						+ '</td><td><img class="img_mini" src="'+opt.data.imagen+'"/></td><td><input id="txtCant' 
						+ opt.data.idProd + '" type="text" value="'+ opt.data.cantidad 
						+'" style="width: 50px;" /></td><td><textarea id="taObs" cols="15"></textarea></td>');				
					
					//Eliminar producto//                    
	                $.each(opt.btn_del, function(name, props){    
	                    //Validar si es una funcion o son atributos
	                    var props = $.isFunction( props ) ? { click: props, text: name } : props;
	                    //Extiende el objeto props con el tipo de objeto (button)
	                    var props = $.extend( { type: "button" }, props );
	                    //Se extrae la funcion
	                    var click = props.click;
	                    //Se crea el evento asociando la funcion pasada como parametro al evento del boton
	                    props.click = function(){
	                        click.apply(this, [that]);
	                    };
	                    //Se agrega el boton creado                    
	                    $('<button></button>', props).button({
							text: false,
							icons: {
								primary: 'ui-icon-trash'
							}
						}).appendTo($td);
	                });

					//Agregar celda a fila//
					$tr.append($td);
					//Agregar fila a tabla//
					$(this).find('table:first').prepend($tr);
					//Crear spinner//
					$(this).find('input[type="text"]').spinner({
						min: 1,
						stop: opt.spinFun
					});
				}
			});			
		},
		descargar: function(){
			return this.each(function(){
				$(this).find('table:first').empty();
			});
		}
	});
})(jQuery);