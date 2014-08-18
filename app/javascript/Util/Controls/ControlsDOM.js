;
$button = $('<button>');
$div = $('<div>');
$tr = $('<tr>');


$('.carrito').carrito({
    botones : {
        'Generar' : function(){
            alert("Mi alerta");
        },
        'Cancelar' : function(){
            alert('Otro mas')
        }
    },
    data : [{us: "1"}, {us : "2"}]
});