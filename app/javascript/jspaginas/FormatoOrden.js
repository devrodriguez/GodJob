;

function LlenarFormato(orden, form){
    var date = new Date();
    $(form).find('#ordNo').text(orden);
    $(form).find('#ordCiuFe').text(date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear());//Fecha
	var dataOrd = Ajax_DatQuery('../../control/ControlOrden.php', '_accion=vertodo&_id=' + orden, 'GET');
    $(form).find('#dvProdDesc').createTable({
        data : dataOrd,
        fields: {
            'CODIGO': {}, 
            'DESCRIPCION': {}, 
            'CANTIDAD': {}, 
            'VAL. UNITARIO': {}, 
            'VAL. TOTAL': {miles: true}
        }
    });
}


function getVarsUrl(){
    var url= location.search.replace("?", "");
    var arrUrl = url.split("&");
    var urlObj={};   
    for(var i=0; i<arrUrl.length; i++){
        var x= arrUrl[i].split("=");
        urlObj[x[0]]=x[1]
    }
    return urlObj;
}