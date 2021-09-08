<?php

	include_once 'Sql.php';

	class RentDao
	{

		public function delete(Rent $rent){

			$sql = new Sql();

			$delete = $sql->query("DELETE FROM tbRents WHERE id = :id",
				[':id' => $rent->getId()]);

			$vehicleDao = new VehicleDao();

			$vehicle = $rent->getVehicle();
			$vehicle->setStatus('available');

			$model = new Model();
			$model->setId($vehicle->modelId);
			$vehicle->setModel($model);

			$vehicleDao->update($vehicle);

			if($delete){
				return true;
			}else{
				return false;
			}

		} // delete()

		public function insert(Rent $rent){

			$sql = new Sql();

			$insert = $sql->query("INSERT INTO tbRents(initialDate, finalDate, status, vehicleId, clientId) VALUES (:initialDate, :finalDate, :status, :vehicleId, :clientId)",
				[':initialDate' => $rent->getInitialDate(),
				 ':finalDate' => $rent->getFinalDate(),
				 ':status' => $rent->getStatus(),
				 ':vehicleId' => $rent->getVehicle()->getId(),
				 ':clientId' => $rent->getClient()->getId()]);

			if($insert){
				return $this->getLastId();
			}else{
				return false;
			}

		} // insert()

		public function update(Rent $rent){

			$sql = new Sql();

			$update = $sql->query("UPDATE tbRents SET
			    initialDate = :initialDate,
				finalDate = :finalDate,
				status = :status,
				vehicleId = :vehicleId,
				clientId = :clientId 
				WHERE id = :id", [
				':initialDate' => $rent->getInitialDate(),
				':finalDate' => $rent->getFinalDate(),
				':status' => $rent->getStatus(),
				':vehicleId' => $rent->getVehicle()->getId(),
			    ':clientId' => $rent->getClient()->getId(),
				':id' => $rent->getId()
			]);

			if($update){
				return $rent->getId();
			}else{
				return false;
			}

		} // insert()

		public function getLastId(){

			$sql = new Sql();

			$busca = $sql->query("SELECT max(id) as id FROM tbRents")->fetch();

			return (int) $busca->id;

		} // getLastId()

		public function getAll(){

			$sql = new Sql();

			$rents = $sql->select("SELECT * FROM tbRents", 'Rent');

			$vehicleDao = new VehicleDao();
			$clientDao = new ClientDao();

			foreach($rents as $rent){
				$vehicle = $vehicleDao->getById($rent->vehicleId);
				$rent->setVehicle($vehicle[0]);

				$client = $clientDao->getById($rent->clientId);
				$rent->setClient($client[0]);
			}

			return $rents;
		} // getAll()

		public function getById($id){

			$id = (int) $id;
			$sql = new Sql();

			$rents = $sql->select("SELECT * FROM tbRents 
                       WHERE id = :id", 'Rent',array(":id" => $id));

			$vehicleDao = new VehicleDao();
			$clientDao = new ClientDao();

			foreach($rents as $rent){

				$vehicle = $vehicleDao->getById($rent->vehicleId);
				$rent->setVehicle($vehicle[0]);

				$client = $clientDao->getById($rent->clientId);
				$rent->setClient($client[0]);

			}

			return $rents;
		} // getById()

	}