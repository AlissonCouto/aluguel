<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$id = $_GET['id'] ? (int) $_GET['id'] : null;

	$rentDao = new RentDao();
	$rent = $rentDao->getById($id);

	if(count($rent) > 0){

		$rent = $rent[0];

		try{

			$sql = new Sql();
			$sql->startTransaction();

			$rentDao->delete($rent);

			/* Get client and vehicle */
			$vehicleDao = new VehicleDao();

			$sql->commit();

			header('Location: /aluguel/index.php');
		}catch(PDOException $e){

			$sql->rollback();

			$msg['error'] = "Houve um erro!";

			$e->getTrace();
		}

	}else{
		header('location: /aluguel/index.php');
	}

