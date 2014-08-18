<?php
	class Conexion_DB
	{
		private $host;
		private $user;
		private $pass;
		private $port;
		private $dataBase;
		private $mys;

		function __construct()
		{
			$this->host = "127.0.0.1";
			$this->user = "root";
			$this->pass = "";
			$this->dataBase = "db_ordenes";			
		}

		function Open()
		{
			$this->mys = new mysqli($this->host, $this->user, $this->pass, $this->dataBase)
			or die ('Could not connect to the database server' . mysqli_connect_error());
			return $this->mys;
		}

		function Close()
		{
			mysqli_close($this->mys);
		} 
	}