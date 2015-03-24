;
//Crear modelo de producto//
var Productos = function(){
    this.idProd = '';
    this.nombre = '';
    this.precio = 0;
    this.imagen = '';
    this.medida = '';
    this.cantidad = 1;
    this.obs = '';
    this.idOrd = '';
}

//Crear modelo de orden//
var Orden = function(){
    this.productos = new Array();
    this.addProducto = function(prod){  
        this.productos.push(prod);  
    }
}


$(document).on('ready', function(){
    //Menu//
    var data_menu = Ajax_DatQuery('../../modelo/Menu.php', {}, 'POST');
    $('#dvMenu').createMenuUI({
        data: data_menu
    });

    //Crear dialog de carrito//
    $('#dvCarrito').dialog({
        autoOpen : false,
        modal : true,
        maxHeight: 600,
        resizable : false,
        width: $(window).width() * 0.6,
        buttons:{
            'Generar' : function(){
                $('<div></div>').text('¿Esta seguro de generar la orden?').dialog({
                    autoOpen: true,
                    modal: true,
                    resizable: false,
                    buttons: {
                        'Si' : function(){
                            RealizarOrden();
                            $(this).dialog('close');
                            $(this).remove();
                        },
                        'No' : function(){
                            $(this).dialog('close');
                            $(this).remove();
                        }
                    },
                    close: function(){
                        $(this).dialog('close');
                        $(this).remove();
                    },
                    create: function(){
                        $(this).parents('div:first').find(".ui-dialog-titlebar").remove()
                    }
                });
            },
            'Eliminar' : EliminarPedido
        }
    });

    $('#dvCarrito').carrito();

    $('#btnCar').button({
        icons:{
            primary: 'ui-icon-cart'
        }
    }).click(function(){
        //Si el carrito no tiene productos no se muestra
        if($('#dvCarrito').find('table tr').length > 0){
            $('#dvCarrito').dialog('open');
        }
    }).css({
        position: 'absolute',
        right: '5px',
        top: '5px'
    });

    $('#dvCarrito table').on('click', '.elim_item_car', function(){
        $(this).parents('tr:first').remove();
    });
    //Fin carrito//
    //Crear tabla//
    CargarTabla();
    //Fin tabla//
    //## Filtros ##//
    dataLin = Ajax_DatQuery('../../control/ControlLineaProducto.php', '_accion=ver');
    $('#txtFilLinea').autocomplete({
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
                //objProd._linea = ui.item.value;
            };
            event.preventDefault();
        },
        autoFocus: true,
        minLength: 0
    });
});

function CargarTabla(){
    //## Crear Tabla ##//
    var dataProd = Ajax_DatQuery('../../control/ControlProducto.php', '_accion=verxlineasec', 'GET');
    $('#dvTab').empty();
    $('#dvTab').createTable({
        data : dataProd,
        caption : 'Productos',
        fields : {
            'Codigo': {},
            'Descripcion': {}, 
            'Precio': {miles:true}, 
            'IVA': {}, 
            'Imagen':{imagen: true}, 
            'Medida':{}, 
            'Linea':{}, 
            'Categoria':{}, 
            'Sucursal':{}
        },
        btn_addToCar: {
            'Add' : AgregarProductoCarro
        }
    });
}

function AgregarProductoCarro(){
    var producto = new Productos();
    var $tr = $(this).parents('tr:first');
    $tr.addClass('prod_in_car');
    
    producto.idProd = $tr.find('td:eq(0)').text();
    producto.nombre = $tr.find('td:eq(1)').text();
    producto.precio = $tr.find('td:eq(2)').text();
    producto.imagen = $tr.find('.img_mini').attr('src');
    producto.medida = $tr.find('td:eq(5)').text();
    producto.cantidad = 1;

    $('#dvCarrito').agregar({
        spinFun : ContarMisProductos,
        data : producto,
        btn_del : {
            'Sacar' : function(cont){
                var that = this;
                $('<div></div>').text('¿Desea eliminar este producto de su orden?').dialog({
                    autoOpen: true,
                    resizable: false,
                    modal: true,
                    buttons: {
                        'Si': function(){
                            //Cerrar y eliminar dialog//
                            $(this).dialog('close');
                            $(this).remove();
                            //Eliminar fila//
                            var $tr = $(that).parents('tr:first');
                            var idProdCar = $tr.find('[id*=hdfId]').val();
                            //Buscar fila con el codigo del producto//
                            $('#dvTab').find('tr:has(td:contains("' + idProdCar + '"))').removeClass('prod_in_car');
                            //Eliminar fila del carrito//
                            $tr.remove();
                            //Contar productos//
                            ContarMisProductos();
                            //Si no hay filas se cierra el cuadro de dialogo//
                            if($('#dvCarrito').find('table tr').length == 0){
                                $('#dvCarrito').dialog('close');
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
                })
            }
        }
    });

    ContarMisProductos();
}

function RealizarOrden(){
    var $trs;

    var dataProd = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=crear', 'GET');
    if(parseInt(dataProd[0].id) > 0)
    {
        var newOrd = new Orden();
        //Obtener filas//
        $trs = $('#dvCarrito table tr');
        //Crear orden//
        $.each($trs, function(key, item){
            var producto = new Productos();
            producto.idOrd = dataProd[0].id;
            producto.idProd = $(this).find('[id*=hdfId]').val();
            producto.cantidad = $(this).find('[id*=txtCant]').val();
            producto.obs = $(this).find('[id*=taObs]').val();
            newOrd.addProducto(producto);
        });

        //Enviar orden//
        var dataOrd = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=crearDetalle&data=' + JSON.stringify(newOrd), 'GET');

        if (dataOrd) {
            newOrd = new Orden();
            $('#dvCarrito').descargar();
            $('#dvCarrito').dialog('close');
            ContarMisProductos();
            $('<div></div>').text('Se creo la orden No. ' + dataProd[0].id).dialog({
                autoOpen: true,
                closeOnEscape: false,
                resizable: false,
                modal: true,
                buttons: {
                    'Ir a Lineas' : function(){
                        window.location.href='../../vista/InicioLinea.php';
                    },
                    'Ver Mis Ordenes' : function(){
                        window.location.href='../../vista/orden/VerOrden.php';  
                    }
                },
                close: function(){
                    $(this).remove();
                },
                create: function(){
                    $(this).parents('div:first').find(".ui-dialog-titlebar").remove();
                }
            });
            //Cambiar color de orden//
            $('#dvTab table tr.prod_in_car').removeClass('prod_in_car')
        };
    }    
}

function EliminarPedido(){
    $('#dvTab table tr.prod_in_car').removeClass('prod_in_car');
    $('#dvCarrito').descargar().dialog('close');
    ContarMisProductos();
}

function ContarMisProductos(){
    var miCuenta = 0;
    var precio = 0;
    var unidad = 0;
    var totUnidad = 0;
    //Mi cuenta es
    $('#dvCarrito table [id*=txtCant]').each(function(index, item){
        unidad = parseInt(item.value.replace(' ', ''));
        if ($.isNumeric(unidad)) {
            totUnidad += unidad;
        };
    });
    $('#btnCar #spCant').text(totUnidad);
    //Mis productos
    $('#dvCarrito table tr').each(function(index, item){
        unidad = parseInt($(item).find('[id*=txtCant]').val().replace(' ', ''));
        precio = parseInt($(item).find('[id*=hdfPreUn]').val().replace('.', '').replace('$', ''));
        precio = unidad * precio;
        if ($.isNumeric(precio)) {
            miCuenta += precio;
        };
    });
    $('#spCuenta').text(formatNumber.new(miCuenta));
}