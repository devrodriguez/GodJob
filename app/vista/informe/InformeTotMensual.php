<?php 
	session_start();
    if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
        header("Location: /ordenesproductos/app/login/Logout.php");
    }
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>:: Informe Totales - Mensual ::</title>
 	<link href="../../javascript/jquery/frameworkui/css/start/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../estilos/principal.css" rel="stylesheet" type="text/css"/>
    <script src="../../javascript/jquery/framework/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="../../javascript/jquery/frameworkui/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
    <script src="../../javascript/util/pluginjs/Plugin.Table.JQuery.js" type="text/javascript"></script>
    <script src="../../javascript/util/data/DataJQuery.js" type="text/javascript"></script>
    <script src="../../javascript/util/pluginjs/PluginjQuery.js" type="text/javascript"></script>
 </head>
 <body>
	<div class="usuario_log">
		<span><strong>Usuario:&nbsp;</strong><?php echo $_SESSION['name']; ?></span>&nbsp;|&nbsp;
	    <span><strong>Seccion:&nbsp;</strong><?php echo $_SESSION['seccion']; ?></span>&nbsp;|&nbsp;
	    <span><strong>Linea:&nbsp;</strong><?php echo $_SESSION['nom_linea_prod']; ?></span>&nbsp;|&nbsp;
	</div>
	<div id="dvMenu"></div>
	<div class="ui-state-active ui-corner-all ui-accordion-header panel_filtro">
		<span>Mes&nbsp;</span>
		<select id="slMes">
			<option value="-1">------</option>
		</select>
	</div>
	
	<div id="dvTab"></div>
	<script src="../../javascript/jspaginas/InformeTotMensual.js" type="text/javascript"></script>
 </body>
 </html>