<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	// Variables
	$initialDate = '';
	$finalDate = '';
	$status = '';
	$vehicleId = null;
	$clientId = null;
	$msg = [];

	$id = $_GET['id'] ? (int) $_GET['id'] : null;

	$rentDao = new RentDao();
	$rent = $rentDao->getById($id);

	if(count($rent) > 0){

		$rent = $rent[0];

		/* Get client and vehicle */
		$vehicleDao = new VehicleDao();
		$clientDao = new ClientDao();

		$clients = $clientDao->getAll();
		$vehicles = $vehicleDao->getAll();

		/* Set datas */
		$vehicleId = $rent->getVehicle()->getId();
		$clientId = $rent->getClient()->getId();

		$status = $rent->getStatus();

		$initialDate = $rent->getInitialDate();
		$finalDate = $rent->getFinalDate();


	}else{
		header('location: /aluguel/index.php');
	}

	if($_POST){

		$initialDate = $_POST['initialDate'] ? $_POST['initialDate'] : null;;
		$finalDate = $_POST['finalDate'] ? $_POST['finalDate'] : null;;
		$status = $_POST['status'] ? $_POST['status'] : null;;
		$vehicleId = $_POST['vehicle'] ? $_POST['vehicle'] : null;;
		$clientId = $_POST['client'] ? $_POST['client'] : null;;

		$vehicle = $vehicleDao->getById($vehicleId);
		$client = $clientDao->getById($clientId);

		if($status != 'concluded' && $status != 'progress'){
			$msg['error'] = "O campo status é inválido!";
		}

		if(!isset($vehicleId) || count($vehicle) == 0){
			$msg['error'] = "O campo veículo é inválido!";
		}

		if(!isset($clientId) || count($client) == 0){
			$msg['error'] = "O campo cliente é inválido!";
		}

		// Validating the date
		$currentDate = Date('Y-m-d');

		if(strtotime($currentDate) > strtotime($initialDate)){
			$msg['error'] = "A data inicial não pode ser menor que a atual!";
		}

		if(strtotime($initialDate) > strtotime($finalDate)){
			$msg['error'] = "A data inicial não pode ser maior que a final!";
		}

		// Validating date format
		if(!checkdate(Date('m', strtotime($initialDate)), Date('d', strtotime($initialDate)), Date('Y', strtotime($initialDate)))){
			$msg['error'] = "Verifique o formato da data inicial!";
		}

		if(!checkdate(Date('m', strtotime($finalDate)), Date('d', strtotime($finalDate)), Date('Y', strtotime($finalDate)))){
			$msg['error'] = "Verifique o formato da data final!";
		}

		if( $vehicle[0]->getStatus() == 'rented' && $rent->getVehicle()->getId() != $vehicle[0]->getid() ){
			$msg['error'] = "Esse carro não está disponível!";
		}

		if(!isset($msg['error'])){
			try{

				$sql = new Sql();
				$sql->startTransaction();

				$vehicle = $vehicle[0];
				$client = $client[0];

				$rentDao = new RentDao();

				$rent->setInitialDate($initialDate);
				$rent->setFinalDate($finalDate);
				$rent->setStatus($status);
				$rent->setVehicle($vehicle);
				$rent->setClient($client);

				$idRent = $rentDao->update($rent);

				// Changing Vehicle Status to Renting

				if($rent->getStatus() == 'concluded'){
					$vehicle->setStatus('available');
				}else{
					$vehicle->setStatus('rented');
				}

				$model = new Model();
				$model->setId($vehicle->modelId);
				$vehicle->setModel($model);

				$vehicleDao->update($vehicle);

				$sql->commit();

				$msg['success'] = "Aluguel editado com sucesso!";
			}catch(PDOException $e){

				$sql->rollback();

				$msg['error'] = "Houve um erro!";

				$e->getTrace();
			}
		} // If ok

	} // POST exists

	/* --------------------------------------- */
	require_once './header.php';
	require_once './sidebar.php';
?>

	<div class="workspace">
		<div class="container">
			<h1 class="title">Editar aluguel</h1>

			<div class="small-fields">

				<?php

					if($msg){
						?>
						<span class="my-alert <?= (empty($msg['error'])) ? 'alert-success' : 'alert-danger'; ?>"><?= (empty($msg['error'])) ? $msg['success'] : $msg['error']; ?></span>
						<?php
					}
				?>

				<form action="" method="post" name="rent">
					<label for="initialDate">Data inicial <em>(Obrigatório)</em></label>
					<input id="initialDate" type="date" name="initialDate" value="<?= $initialDate; ?>" placeholder="Início" required>

					<label for="finalDate">Data final <em>(Obrigatório)</em></label>
					<input id="finalDate" type="date" name="finalDate" value="<?= $finalDate; ?>" placeholder="Final" required>

					<label for="status">Status <em>(Obrigatório)</em></label>
					<select name="status" id="status">
						<option>Selecione...</option>
						<option value="progress" <?= ($status == 'progress') ? 'selected' : ''; ?>>Andamento</option>
						<option value="concluded" <?= ($status == 'concluded') ? 'selected' : ''; ?>>Concluído</option>
					</select>

					<label for="vehicle">Veículo <em>(Obrigatório)</em></label>
					<select name="vehicle" id="vehicle">
						<option>Selecione...</option>

						<?php
							foreach($vehicles as $vehicle){
								$modelDao = new ModelDao();
								$model = $modelDao->getById($vehicle->modelId)[0];

								?>
								<option value="<?= $vehicle->getId(); ?>" <?= ($vehicle->getId() == $vehicleId) ? 'selected' : ''; ?>><?= $model->getDescription(); ?></option>
								<?php
							}
						?>

					</select>

					<label for="client">Cliente <em>(Obrigatório)</em></label>
					<select name="client" id="client">
						<option>Selecione...</option>

						<?php
							foreach($clients as $client){
								?>
								<option value="<?= $client->getId(); ?>" <?= ($client->getId() == $clientId) ? 'selected' : ''; ?>><?= $client->getName(); ?></option>
								<?php
							}
						?>

					</select>

					<button type="submit">EDITAR</button>
				</form>
			</div>
		</div>
	</div>

<?php require_once './footer.php'; ?>