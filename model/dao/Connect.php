<?php

	class Connect
	{

		private static $instance;

		private function __construct() {}

		private function __clone() {}

		public static function getInstance()
		{
			$usuario = 'root';
			$senha = '';
			if(!isset(self::$instance)){

				try{

					$opcoes = array(
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
					);
					self::$instance = new PDO('mysql:host=localhost;dbname=vehicleRent', $usuario, $senha, $opcoes);
					self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
					self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				}catch(PDOException $e){

					require_once 'error.php';

				}

			}

			return self::$instance;
		}

	}