<?php

	include_once 'Sql.php';

	class ClientDao
	{
		public function insert(Client $client){

			$sql = new Sql();

			$insert = $sql->query("INSERT INTO tbClients( name, cnh, phone, email) VALUES (:name, :cnh, :phone, :email)",
				[':name' => $client->getName(), ':cnh' => $client->getCnh(), ':phone' => $client->getPhone(), ':email' => $client->getEmail()]);

			if($insert){
				return $this->getLastId();
			}else{
				return false;
			}

		} // insert()

		public function delete(Client $client){

			$sql = new Sql();
			$rentDao = new RentDao();
			$vehicleDao = new VehicleDao();

			$rents = $sql->select('SELECT * FROM tbRents WHERE clientId = :clientId', 'Rent', ['clientId' => $client->getId()]);

			foreach($rents as $rent){

				$vehicle = $vehicleDao->getById($rent->vehicleId)[0];
				$rent->setVehicle($vehicle);

				$rentDao->delete($rent);
			}

			$delete = $sql->query("DELETE FROM tbClients WHERE id = :id",
				[':id' => $client->getId()]);

			if($delete){
				return true;
			}else{
				return false;
			}

		} // delete()

		public function update(Client $client){

			$sql = new Sql();

			$update = $sql->query("UPDATE tbClients SET 
										name = :name,
										cnh = :cnh,
										phone = :phone,
										email = :email WHERE id = :id",
				[':name' => $client->getName(),
					':cnh' => $client->getCnh(),
					':phone' => $client->getPhone(),
					':email' => $client->getEmail(),
					':id' => $client->getId()
				]
			);

			if($update){
				return $client->getId();
			}else{
				return false;
			}

		} // insert()

		public function getLastId(){

			$sql = new Sql();

			$busca = $sql->query("SELECT max(id) as id FROM tbClients")->fetch();

			return (int) $busca->id;

		} // getLastId()

		public function getAll(){

			$sql = new Sql();

			$clients = $sql->select("SELECT * FROM tbClients", 'Client');

			return $clients;
		} // getAll()

		public function getById($id){

			$id = (int) $id;
			$sql = new Sql();

			$client = $sql->select("SELECT * FROM tbClients 
                       WHERE id = :id", 'Client',array(":id" => $id));

			return $client;
		} // getById()

	}