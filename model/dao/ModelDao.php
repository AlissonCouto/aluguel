<?php

	include_once 'Sql.php';

	class ModelDao
	{

		public function delete(Model $model){

			$sql = new Sql();
			$vehicleDao = new VehicleDao();

			$vehicles = $sql->select('SELECT * FROM tbVehicles WHERE modelId = :modelId', 'Vehicle', ['modelId' => $model->getId()]);

			foreach($vehicles as $vehicle){
				$vehicleDao->delete($vehicle);
			}

			$delete = $sql->query("DELETE FROM tbModels WHERE id = :id",
				[':id' => $model->getId()]);

			if($delete){
				return true;
			}else{
				return false;
			}

		} // delete()

		public function insert(Model $model){

			$sql = new Sql();

			$insert = $sql->query("INSERT INTO tbModels( description, brandId) VALUES (:description, :brandId)", [":description" => $model->getDescription(), ':brandId' => $model->getBrand()->getId()]);

			if($insert){
				return $this->getLastId();
			}else{
				return false;
			}

		} // insert()

		public function update(Model $model){

			$sql = new Sql();

			$update = $sql->query("UPDATE tbModels SET description =  :description, brandId = :brandId WHERE id = :id", [
				":description" => $model->getDescription(),
				":brandId" => $model->getBrand()->getId(),
				":id" => $model->getId()
			]);

			if($update){
				return $model->getId();
			}else{
				return false;
			}

		} // insert()

		public function getLastId(){

			$sql = new Sql();

			$busca = $sql->query("SELECT max(id) as id FROM tbModels")->fetch();

			return (int) $busca->id;

		} // getLastId()

		public function getAll(){

			$sql = new Sql();
			$brandDao = new BrandDao();

			$models = $sql->select("SELECT * FROM tbModels", 'Model');

			foreach($models as $model){

				$brand = $brandDao->getById($model->brandId);

				$model->setBrand($brand[0]);
			}

			return $models;
		} // getAll()

		public function getById($id){

			$id = (int) $id;
			$sql = new Sql();

			$model = $sql->select("SELECT * FROM tbModels 
                       WHERE id = :id", 'Model',array(":id" => $id));

			return $model;
		} // getById()

	}