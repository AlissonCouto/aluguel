<?php

	require_once 'Connect.php';

	Class Sql extends PDO{

		private $conexao;

		public function __construct(){

			try{

				$opcoes = array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8MB4'
				);
				$this->conexao = Connect::getInstance();

			}catch(PDOException $e){

				require_once 'error.php';

			}

		}

		public function setParam($stm, $k, $v){

			$stm->bindValue($k, $v);

		}

		public function setParams($stm, $parameters = []){

			foreach($parameters as $k => $v){

				$this->setParam($stm, $k, $v);

			}

		}

		public function query($sql, $parameters = []){
			$stm = $this->conexao->prepare($sql);
			$this->setParams($stm, $parameters);
			$stm->execute();

			return $stm;
		}

		public function select($sql, $class, $parameters = []){

			$stm = $this->query($sql, $parameters);

			return $stm->fetchAll(PDO::FETCH_CLASS, $class);
		}

		public function startTransaction(){
			$this->conexao->beginTransaction();
		}

		public function commit(){
			$this->conexao->commit();
		}

		public function rollback(){
			$this->conexao->rollback();
		}
	}