<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$id = $_GET['id'] ? (int) $_GET['id'] : null;

	$vehicleDao = new VehicleDao();
	$vehicle = $vehicleDao->getById($id);

	if(count($vehicle) > 0){

		$vehicle = $vehicle[0];

		try{

			$sql = new Sql();
			$sql->startTransaction();

			$vehicleDao->delete($vehicle);

			$sql->commit();

			header('Location: /aluguel/vehicles.php');
		}catch(PDOException $e){

			$sql->rollback();

			$msg['error'] = "Houve um erro!";

			$e->getTrace();
		}

	}else{
		header('location: /aluguel/vehicles.php');
	}

