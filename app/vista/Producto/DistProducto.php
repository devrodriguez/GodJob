<?php
    session_start();
    if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
        header("Location: /ordenesproductos/app/login/Logout.php");
    }
    if(isset($_POST['hdfLinea']) && isset($_POST['hdfNomLinea'])){
    	$_SESSION['linea_prod'] = $_POST['hdfLinea'];
    	$_SESSION['nom_linea_prod'] = $_POST['hdfNomLinea'];
    }
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>:: Distribuir Producto ::</title>
	<link href="../../javascript/jquery/frameworkui/css/start/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
	<link href="../../estilos/principal.css" rel="stylesheet" type="text/css"/>
	<script src="../../javascript/jquery/framework/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="../../javascript/jquery/frameworkui/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
	<script src="../../javascript/util/pluginjs/Plugin.Table.JQuery.js" type="text/javascript"></script>
	<script src="../../javascript/util/data/DataJQuery.js" type="text/javascript"></script>
	<script src="../../javascript/util/pluginjs/PluginjQuery.js" type="text/javascript"></script>
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
    	<div id="dvMenu"></div>
    </div>
    <br /><br /><br /><br />
    <table align="center" style="border-bottom:solid 1px #bbb;">
    	<tr>
    		<td><strong>Producto</strong></td>
    		<td>
    			<input id="txtProd" type="text" style="width:350px;"/>
    			<input id="hdfProd" type="hidden" />
    		</td>
    	</tr>
    	<tr>
    		<td><strong>Seccion</strong></td>
    		<td>
    			<input id="txtSecc" type="text" style="width:350px;"/>
    			<input id="hdfSecc" type="hidden" />
    		</td>
    	</tr>
    	<tr>
    		<td colspan="2" align="center"><button id="btnAsoc">Asociar</button></td>    		
    	</tr>
    </table>
    <div id="dvTab"></div>
    <script type="text/javascript" src="../../javascript/jspaginas/DistProducto.js"></script>
</body>
</html>