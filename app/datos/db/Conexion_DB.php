<?php
	class Conexion_DB
	{
		private $host = "127.0.0.1";
		private $user = "root";
		private $pass = "";
		private $port = "";
		private $dataBase = "db_ordenes";
		private $mys;

		function __construct(){}

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