<?php

	include_once 'Sql.php';

	class VehicleDao
	{

		public function delete(Vehicle $vehicle){

			$sql = new Sql();
			$rentDao = new RentDao();

			$rents = $sql->select('SELECT * FROM tbRents WHERE vehicleId = :vehicleId', 'Rent', ['vehicleId' => $vehicle->getId()]);

			foreach($rents as $rent){

				$rent->setVehicle($vehicle);

				$rentDao->delete($rent);
			}

			$delete = $sql->query("DELETE FROM tbVehicles WHERE id = :id",
				[':id' => $vehicle->getId()]);

			if($delete){
				return true;
			}else{
				return false;
			}

		} // delete()

		public function insert(Vehicle $vehicle){

			$sql = new Sql();

			$insert = $sql->query("INSERT INTO tbVehicles(licensePlate, year, dailyRate, status, modelId) VALUES (:licensePlate, :year, :dailyRate, :status, :modelId)",
				[':licensePlate' => $vehicle->getLicensePlate(),
					':year' => $vehicle->getYear(),
					':dailyRate' => $vehicle->getDailyRate(),
					':status' => $vehicle->getStatus(),
					':modelId' => $vehicle->getModel()->getId()]);

			if($insert){
				return $this->getLastId();
			}else{
				return false;
			}

		} // insert()

		public function update(Vehicle $vehicle){

			$sql = new Sql();

			$update = $sql->query("UPDATE tbVehicles SET 
										licensePlate = :licensePlate,
										year = :year,
										status = :status,
										dailyRate = :dailyRate, 
										modelId = :modelId WHERE id = :id",
										[':licensePlate' => $vehicle->getLicensePlate(),
										':year' => $vehicle->getYear(),
										':status' => $vehicle->getStatus(),
										':dailyRate' => $vehicle->getDailyRate(),
										':modelId' => $vehicle->getModel()->getId(),
										':id' => $vehicle->getId()
										]
				);

			if($update){
				return $vehicle->getId();
			}else{
				return false;
			}

		} // insert()

		public function getLastId(){

			$sql = new Sql();

			$busca = $sql->query("SELECT max(id) as id FROM tbVehicles")->fetch();

			return (int) $busca->id;

		} // getLastId()

		public function getAll(){

			$sql = new Sql();

			$vehicles = $sql->select("SELECT * FROM tbVehicles", 'Vehicle');

			$modelDao = new ModelDao();

			foreach($vehicles as $vehicle){
				$model = $modelDao->getById($vehicle->modelId);
				$vehicle->setModel($model[0]);
			}

			return $vehicles;
		} // getAll()

		public function getById($id){

			$id = (int) $id;
			$sql = new Sql();

			$vehicle = $sql->select("SELECT * FROM tbVehicles 
                       WHERE id = :id", 'Vehicle',array(":id" => $id));

			return $vehicle;
		} // getById()

	}