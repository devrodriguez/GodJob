<?php
    session_start();
    if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
        header("Location: /ordenesproductos/app/login/Logout.php");
    }
 ?>
<!DOCTYPE html>
<meta http-equiv="x-ua-compatible" content="IE=7, IE=8, IE=9, IE=Edge">
<html>
<head>
	<title></title>
	<link href="../estilos/principal.css" rel="stylesheet" type="text/css"/>
	<style type="text/css">
	body,html{
		width: 100%;
		height: 100%;
		padding-top: 50px;
	}
	
	</style>
	<script src="../javascript/jquery/framework/jquery-1.10.2.min.js" type="text/javascript"></script>
</head>
<body style="text-align: center;">
<form method="POST" action="producto/VerProducto.php">
	<div class="cont_bot_linea">
		<div>
			<h1 style="color:#aaa;">Bienvenido al Portal Transaccional de <strong>GODJOB SOLUTION S.A.S</strong></h1>
			<h3 style="color:#bbb;">A continuaci&#243;n encontrara los cat&#225;logos disponibles para generaci&#243;n de ordenes,</h3>
			<h3 style="color:#bbb;">por favor seleccione uno de los cat&#225;logos para realizar su producto.</h3>
		</div>
		<select id="selClientes">
			<option>Marval S.A</option>
		</select>
		<table align="center">
			<tr>
				<td>
					<button id="btnPape" class="bot_linea_prod">Papeleria</button>
				</td>
			</tr>
			<tr>
				<td>
					<button id="btnCafe" class="bot_linea_prod" wrap>Cafeteria y Aseo</button>	
				</td>
			</tr>
		</table>
	</div>
	<input type="hidden" id="hdfLinea" name="hdfLinea" />
	<input type="hidden" id="hdfNomLinea" name="hdfNomLinea" />
</form>
<script type="text/javascript">
	$(document).on('ready', function(){
		$('#btnPape').on('click', function(){
			$('#hdfLinea').val(1);
			$('#hdfNomLinea').val('Papeleria');
			//window.location.href = 'Producto/VerProducto.php?linea=1';
		});

		$('#btnCafe').on('click', function(){
			$('#hdfLinea').val(2)
			$('#hdfNomLinea').val('Cafeteria y Aseo');
			//window.location.href = 'Producto/VerProducto.php?linea=2';
		})
	})
</script>
</body>
</html>

