<?php 
	session_start();
	require '../modelo/Usuario.php';

	if(isset($_GET['_accion']) && $_GET['_accion'] == 'ver')
	{
		$usuario = new Usuario('','','','','','','','');
		echo $usuario->Ver();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'crear')
	{
		$usuario = new Usuario('', $_GET['_identi'], $_GET['_nombre'], $_GET['_usuario'], $_GET['_contr'], $_GET['_correo'], $_GET['_perfil'], $_GET['_seccion']);
		echo $usuario->Crear();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'actualizar')
	{
		$usuario = new Usuario($_GET['_codigo'], $_GET['_identi'], $_GET['_nombre'], $_GET['_usuario'], $_GET['_contr'], $_GET['_correo'], $_GET['_perfil'], $_GET['_seccion']);
		echo $usuario->Actualizar();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'consperfil')
	{
		$usuario = new Usuario('', '', '', '', '', '', '', '');
		echo $usuario->ConsultarPerfil();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'conssecc')
	{
		$usuario = new Usuario('', '', '', '', '', '', '', '');
		echo $usuario->ConsultarSeccion();
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'cambcont')
	{
		$usuario = new Usuario('', '', '', '', '', '', '', '');
		echo $usuario->CambiarContrasena($_GET['_usuario'], $_GET['_anterior'], $_GET['_nueva']);
	}
	else if(isset($_GET['_accion']) && $_GET['_accion'] == 'olvidocon')
	{
		$usuario = new Usuario('', '', '', '', '', '', '', '');
		echo $usuario->OlvidoContrasena($_GET['_usuario']);
	}
 ?>