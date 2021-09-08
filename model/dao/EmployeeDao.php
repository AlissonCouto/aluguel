<?php

	include_once 'Sql.php';

	class EmployeeDao
	{

		public function __construct()
		{
			if ( session_status() !== PHP_SESSION_ACTIVE )
			{
				session_start();
			}
		}

		public function logged()
		{
			if(!isset($_SESSION['login'])){
				return false;
			}

			return true;
		} // logged()

		public function logout()
		{
			$logged = $this->logged();

			if($logged){
				session_destroy();
			}


			header('location: /aluguel/login.php');
		} // logout()

		public function login(Employee $employee)
		{
			$sql = new Sql();

			// Checking if the user already exists
			$user = $this->getByEmail($employee);

			if($user && password_verify($employee->getPassword(), $user[0]->getPassword())){

				$_SESSION['login'] = $user[0]->getId();

				return true;
			}else{
				return false;
			}
		}

		public function insert(Employee $employee){

			$sql = new Sql();

			// Checking if the user already exists
			$user = $this->getByEmail($employee);

			if(!$user){

				$password = password_hash($employee->getPassword(), PASSWORD_DEFAULT);

				$sql->query("INSERT INTO tbEmployees( name, email, password) VALUES (:name, :email, :password)",
					              [
					              	':name' => $employee->getName(),
									':email' => $employee->getEmail(),
									':password' => $password
								  ]);

				$_SESSION['login'] = true;

				return true;
			}else{
				return false;
			}

		} // insert()

		public function getLastId(){

			$sql = new Sql();

			$busca = $sql->query("SELECT max(id) as id FROM tbEmployees")->fetch();

			return (int) $busca->id;

		} // getLastId()

		public function getAll(){

			$sql = new Sql();
			$brandDao = new BrandDao();

			$models = $sql->select("SELECT * FROM tbEmployees", 'Employee');

			foreach($models as $model){

				$brand = $brandDao->getById($model->brandId);

				$model->setBrand($brand[0]);
			}

			return $models;
		} // getAll()

		public function getById($id){

			$id = (int) $id;
			$sql = new Sql();

			$model = $sql->select("SELECT * FROM tbEmployees 
                       WHERE id = :id", 'Employee',array(":id" => $id));

			return $model;
		} // getById()

		public function getByEmail(Employee $employee){

			$sql = new Sql();

			$employee = $sql->select("SELECT * FROM tbEmployees 
                       WHERE email = :email", 'Employee',array(":email" => $employee->getEmail()));

			return $employee;
		} // getById()

	}