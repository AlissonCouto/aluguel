<?php

	include_once 'Sql.php';

	class BrandDao
	{

		public function delete(Brand $brand){

			$sql = new Sql();
			$modelDao = new ModelDao();

			$models = $sql->select('SELECT * FROM tbModels WHERE brandId = :brandId', 'Model', ['brandId' => $brand->getId()]);

			foreach($models as $model){
				$modelDao->delete($model);
			}

			$delete = $sql->query("DELETE FROM tbBrands WHERE id = :id",
				[':id' => $brand->getId()]);

			if($delete){
				return true;
			}else{
				return false;
			}

		} // delete()

		public function insert(Brand $brand){

			$sql = new Sql();

			$insert = $sql->query("INSERT INTO tbBrands( description) VALUES (:description)", [":description" => $brand->getDescription()]);


			if($insert){
				return $this->getLastId();
			}else{
				return false;
			}

		} // insert()

		public function update(Brand $brand){

			$sql = new Sql();

			$update = $sql->query("UPDATE tbBrands SET description =  :description WHERE id = :id", [
				":description" => $brand->getDescription(),
				":id" => $brand->getId()
				]);

			if($update){
				return $brand->getId();
			}else{
				return false;
			}

		} // insert()

		public function getLastId(){

			$sql = new Sql();

			$busca = $sql->query("SELECT max(id) as id FROM tbBrands")->fetch();

			return (int) $busca->id;

		} // getLastId()

		public function getAll(){

			$sql = new Sql();

			$brands = $sql->select("SELECT * FROM tbBrands", 'Brand');

			return $brands;
		} // getAll()

		public function getById($id){

			$id = (int) $id;
			$sql = new Sql();

			$brand = $sql->select("SELECT * FROM tbBrands 
                       WHERE id = :id", 'Brand',array(":id" => $id));

			return $brand;
		} // getById()

	}