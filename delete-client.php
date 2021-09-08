<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$id = $_GET['id'] ? (int) $_GET['id'] : null;

	$clientDao = new ClientDao();
	$client = $clientDao->getById($id);

	if(count($client) > 0){

		$client = $client[0];

		try{

			$sql = new Sql();
			$sql->startTransaction();

			$clientDao->delete($client);

			$sql->commit();

			header('Location: /aluguel/clients.php');
		}catch(PDOException $e){

			$sql->rollback();

			$msg['error'] = "Houve um erro!";

			$e->getTrace();
		}

	}else{
		header('location: /aluguel/clients.php');
	}

