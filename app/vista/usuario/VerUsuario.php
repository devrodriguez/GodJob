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
	<title>:: Editar Usuario ::</title>
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
	        <a href="/ordenesproductos/app/login/Logout.php" style="text-decoration: none;font-weight: bold;">Cerrar Sesion</a>
	    </div>
    </div>
    <br /><br /><br />
    <div id="dvTab"></div>
	<div id="newUsu" title="Editar Usuario" style="font-size:12px;display:none;">
		<table>
			<tr>
				<td><strong>Identificacion&nbsp;</strong></td>
				<td><input id="txtIdent" name="nombre" type="text" /></td>
			</tr>
			<tr>
				<td><strong>Nombre&nbsp;</strong></td>
				<td><input id="txtNom" name="pre" type="text" /></td>
			</tr>
			<tr>
				<td><strong>Usuario&nbsp;</strong></td>
				<td><input id="txtUsu" name="iva" type="text" /></td>
			</tr>
			<tr>
				<td><strong>Contraseña&nbsp;</strong></td>
				<td><input id="txtCont" name="iva" type="text" /></td>
			</tr>
			<tr>
				<td><strong>Correo&nbsp;</strong></td>
				<td>
					<input type="text" id="txtCorr" />
				</td>
			</tr>
			<tr>
				<td><strong>Perfil&nbsp;</strong></td>
				<td>
					<input type="text" id="txtPerf" />
				</td>
			</tr>
			<tr>
				<td><strong>Seccion&nbsp;</strong></td>
				<td>
					<input type="text" id="txtSecc" />
				</td>
			</tr>
		</table>			
	</div>
	<!-- JS propietario de la pagina -->
    <script type="text/javascript" src="../../javascript/jspaginas/VerUsuario.js"></script>
</body>
</html>