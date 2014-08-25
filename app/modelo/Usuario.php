<?php 
	require '../datos/GetDataComun.php';

	class Usuario extends GetDataComun
	{
		protected $codigo;
		protected $identi;
		protected $nombre;
		protected $usuario;
		protected $contra;
		protected $correo;
		protected $perfil;
		protected $seccion;

		function __construct($codigo, $identi, $nombre, $usuario, $contra, $correo, $perfil, $seccion)
		{
			$this->codigo = $codigo;
			$this->identi = $identi;
			$this->nombre = $nombre;
			$this->usuario = $usuario;
			$this->contra = $contra;
			$this->correo = $correo;
			$this->perfil = $perfil;
			$this->seccion = $seccion;
		}

		function Ver()
		{
			$query = "CALL ConsultarUsuario();";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		function Crear()
		{
			$usuario = $_SESSION['userid'];
			$query = "CALL CrearUsuario('$this->identi', '$this->nombre', '$this->usuario', '$this->contra', '$this->correo', '$this->perfil', '$this->seccion', '$usuario');";

			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);	
		}

		function Actualizar()
		{
			$usuario = $_SESSION['userid'];
			$query = "CALL ActualizarUsuario('$this->codigo', '$this->identi', '$this->nombre', '$this->usuario', '$this->contra', '$this->correo', '$this->perfil', '$this->seccion', '$usuario');";

			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		function ConsultarPerfil()
		{
			$query = "CALL ConsultarPerfilUsuario();";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		function ConsultarSeccion()
		{
			$query = "CALL ConsultarSeccionUsuario();";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		function CambiarContrasena($usuario, $anterior, $nueva)
		{
			$query = "CALL CambiarContrasena('$usuario', '$anterior', '$nueva');";
			$rows = $this->Get_Data_Array($query);
			return json_encode($rows);
		}

		function OlvidoContrasena($usuario)
		{
			$headers = array();
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-type: text/html; charset=iso-8859-1";
			$headers[] = "FROM: informacion@godjob.com.co";

			$nueva = uniqid();
			$subject = "Cambio de contrase&ntilde;a";
			$body = "Su nueva contrase&#241;a es: ".$nueva;
			$query = "CALL OlvidoContrasena('$usuario', '$nueva');";
			$rows = $this->Get_Data_Array($query);
			//Enviar mail nueva contraseña//
			mail($rows[0]["correo"], $subject, $body, implode("\r\n", $headers));
			return json_encode($rows);
		}
	}

 ?>