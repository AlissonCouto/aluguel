<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$id = $_GET['id'] ? (int) $_GET['id'] : null;

	$modelDao = new ModelDao();
	$model = $modelDao->getById($id);

	if(count($model) > 0){

		$model = $model[0];

		try{

			$sql = new Sql();
			$sql->startTransaction();

			$modelDao->delete($model);

			$sql->commit();

			header('Location: /aluguel/models.php');
		}catch(PDOException $e){

			$sql->rollback();

			$msg['error'] = "Houve um erro!";

			$e->getTrace();
		}

	}else{
		header('location: /aluguel/models.php');
	}

