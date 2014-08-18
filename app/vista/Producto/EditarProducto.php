<?php
    session_start();
    if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
        header("Location: /ordenesproductos/app/login/Logout.php");
    }
 ?>
<!DOCTYPE html>
<!-- Use Internet Explorer 9 Standards mode -->
<meta http-equiv="x-ua-compatible" content="IE=7, IE=8, IE=9, IE=Edge">
<html>
<head>
	<title>:: Editar Producto ::</title>
	<style type="text/css">
	.ui-autocomplete {
	    max-height: 70px;
	    overflow-y: auto;
	    /* prevent horizontal scrollbar */
	    overflow-x: hidden;
	 }
	 * html .ui-autocomplete {
	    height: 70px;
	 }
	</style>
	<link href="../../javascript/jquery/frameworkui/css/start/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../estilos/principal.css" rel="stylesheet" type="text/css"/>
	<script src="../../javascript/jquery/framework/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="../../javascript/jquery/frameworkui/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
    <script src="../../javascript/util/pluginjs/Plugin.Table.JQuery.js" type="text/javascript"></script>
    <script src="../../javascript/util/pluginjs/Plugin.Carrito.jQuery.js" type="text/javascript"></script>
    <script src="../../javascript/util/pluginjs/PluginjQuery.js" type="text/javascript"></script>
    <script src="../../javascript/util/data/DataJQuery.js" type="text/javascript"></script>	
</head>
<body>
	<div style="position:fixed;width: 100%;z-index:100;">
		<div class="usuario_log">
	        <span><strong>Usuario:&nbsp;</strong><?php echo $_SESSION['name']; ?></span>&nbsp;|&nbsp;
	        <span><strong>Seccion:&nbsp;</strong><?php echo $_SESSION['seccion']; ?></span>&nbsp;|&nbsp;
	        <span><strong>Linea:&nbsp;</strong><?php echo $_SESSION['nom_linea_prod']; ?></span>&nbsp;|&nbsp;
	        <a href="/ordenesproductos/app/vista/InicioLinea.php" style="text-decoration: none;font-weight: bold;">Cambiar Linea</a>&nbsp;|&nbsp;
	        <a href="/ordenesproductos/app/login/Logout.php" style="text-decoration: none;font-weight: bold;">Cerrar Sesion</a>&nbsp;|&nbsp;
	        <a href="#" id="canCon" style="text-decoration: none;font-weight: bold;">Cambiar Contrase&#241;a</a>
	    </div>
		<div id="dvMenu"></div>
	</div>
	<br /><br /><br /><br />
    <div id="dvTab"></div>
	<div id="newProd" title="Crear Producto" style="font-size:12px;display:none;">
		<table>
			<tr>
				<td><strong>Nombre&nbsp;</strong></td>
				<td><input id="txtNom" name="nombre" type="text" /></td>
			</tr>
			<tr>
				<td><strong>Precio&nbsp;</strong></td>
				<td><input id="txtPre" name="pre" type="text" /></td>
			</tr>
			<tr>
				<td><strong>IVA&nbsp;</strong></td>
				<td><input id="txtIva" name="iva" type="text" /></td>
			</tr>
			<tr>
				<td><strong>Imagen&nbsp;</strong></td>
				<td>
					<form id="frmEnvArc" action="../../control/ControlProducto.php" method="post" enctype="multipart/form-data" target="sube_archivo" >
						<input id="fuImg" type="file" name="archivo" />						
						<input id="hdfIdProd" name="hdfIdProd" type="hidden" />
						<iframe style="display:none;" id="ifmSubArc" name="sube_archivo"></iframe>
					</form>
				</td>
			</tr>
			<tr>
				<td><strong>Medida&nbsp;</strong></td>
				<td>
					<input type="text" id="txtUnid" />
				</td>
			</tr>
			<tr>
				<td><strong>Linea&nbsp;</strong></td>
				<td>
					<input type="text" id="txtLinea" />
				</td>
			</tr>
			<!--<tr>
				<td><strong>Categoria&nbsp;</strong></td>
				<td>
					<input type="text" id="txtCat" />
				</td>
			</tr>-->
		</table>			
	</div>
	<input type="hidden" id="hdfLinea" value="<?php echo $_SESSION['linea_prod']; ?>" />
	<input type="hidden" id="hdfIdUsu" value="<?php echo $_SESSION['userid']; ?>" />
	<!-- JS propietario de la pagina -->
    <script type="text/javascript" src="../../javascript/jspaginas/EditarProducto.js"></script>
</body>
</html>