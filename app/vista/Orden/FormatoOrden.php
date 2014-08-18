<!DOCTYPE html>
<meta http-equiv="x-ua-compatible" content="IE=7, IE=8, IE=9, IE=Edge">
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../../estilos/FormatoOrden/formato.css">
</head>
<body>
	<div id="dvFormOrden" class="contenedor">
		<div style="text-align: right;">
			<div class="basic no_orden">
				<div class="tit_orden">PEDIDO</div>
				<div class="cant_orden">No.<span id="ordNo"></span></div>
			</div>
		</div>
		<div class="basic seccion">
			<div class="basic seccion_int">
				<div class="celda" >Ciudad y fecha<span id="ordCiuFe">01/01/2014</span></div>
				<div class="celda" >Comprador<span id="ordCompra"></span></div>
				<div class="celda" >Despachado a <span id="ordDesp"></span></div>
				<div class="celda sin_borde">Forma de pago <span id="ordFPago"></span></div>
			</div>
			<div class="basic seccion_int">
				<div class="celda">Proveedor <span id="ordProv"></span></div>
				<div class="celda">Nit <span id="ordNit"></span></div>
				<div class="celda">Telefono <span id="ordTel"></span></div>
				<div class="celda sin_borde">Direccion <span id="ordDir"></span></div>
			</div>
		</div>
		<br/>
		<div class="basic seccion">
			<div id="dvProdDesc"></div>
		</div>
		<br/>
		<div class="basic seccion">
			<table class="tb_basic tb_foot">
				<tr>
					<td colspan="100%" style="height: 50px;"><span>Observaciones</span></td>
				</tr>
				<tr>
					<td><span>Fecha de despacho</span></td>
					<td rowspan="2"><span>Aprobado por</span></td>
					<td rowspan="2"><span>Aceptado proveedor</span></td>
				</tr>
				<tr>
					<td>Elaborado por</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>