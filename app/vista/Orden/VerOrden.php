<?php
    session_start();
    if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
        header("Location: /ordenesproductos/app/login/Logout.php");
    }
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="x-ua-compatible" content="IE=7, IE=8, IE=9, IE=Edge" />
	<meta charset="utf-8" />
	<title>:: Ver Orden ::</title>
	<link href="../../estilos/principal.css" rel="stylesheet" type="text/css"/>
	<link href="../../javascript/jquery/frameworkui/css/start/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
	<script src="../../javascript/jquery/framework/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="../../javascript/jquery/frameworkui/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
	<script src="../../javascript/util/data/DataJQuery.js" type="text/javascript"></script>
	<script src="../../javascript/util/pluginjs/Plugin.Table.JQuery.js" type="text/javascript"></script>
	<script src="../../javascript/util/pluginjs/PluginjQuery.js" type="text/javascript"></script>
</head>
<body>
	<div style="position:fixed;width: 100%;z-index:100;background-color:#FFF;">
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
	<input type="hidden" id="hdfIdUsu" value="<?php echo $_SESSION['userid']; ?>" />
	<script src="../../javascript/jspaginas/VerOrden.js" type="text/javascript"></script>
</body>
</html>