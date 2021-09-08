<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$id = $_GET['id'] ? (int) $_GET['id'] : null;

	$brandDao = new BrandDao();
	$brand = $brandDao->getById($id);

	if(count($brand) > 0){

		$brand = $brand[0];

		try{

			$sql = new Sql();
			$sql->startTransaction();

			$brandDao->delete($brand);

			$sql->commit();

			header('Location: /aluguel/brands.php');
		}catch(PDOException $e){

			$sql->rollback();

			$msg['error'] = "Houve um erro!";

			$e->getTrace();
		}

	}else{

		header('location: /aluguel/brands.php');
	}

