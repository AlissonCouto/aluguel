<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	// Variables
	$place = '';
	$year = '';
	$dailyRate = '';
	$selectedModel = null;
	$msg = [];

	/* GET Brands */
	$vehicleDao = new VehicleDao();
	$modelDao = new ModelDao();
	$models = $modelDao->getAll();

	$id = $_GET['id'] ? (int) $_GET['id'] : null;

	$vehicle = $vehicleDao->getById($id);

	if(count($vehicle) > 0){

		$vehicle = $vehicle[0];

		$place = $vehicle->getLicensePlate();
		$year = $vehicle->getYear();
		$dailyRate = $vehicle->getDailyRate();
		$selectedModel = $modelDao->getById($vehicle->modelId)[0]->getId();

	}else{
		header('location: /aluguel/vehicles.php');
	}


	if($_POST){

		$place = $_POST['place'] ? $_POST['place'] : null;
		$year = $_POST['year'] ? $_POST['year'] : null;
		$dailyRate = $_POST['dailyRate'] ? $_POST['dailyRate'] : null;
		$selectedModel = $_POST['model'] ? $_POST['model'] : null;

		$regex = '/[A-Z]{3}[0-9][0-9A-Z][0-9]{2}/';

		if (!preg_match($regex, strtoupper($place))) {
			$msg['error'] = "A placa informada é inválida!";
		}

		if(!preg_match('/[0-9]{4}/', $year)){
			$msg['error'] = "O ano informado é inválido!";
		}

		if(!isset($dailyRate) || !preg_match('/^([1-9]{1}[\d]{0,2}(\.[\d]{3})*(\,[\d]{0,2})?|[1-9]{1}[\d]{0,}(\,[\d]{0,2})?|0(\,[\d]{0,2})?|(\,[\d]{1,2})?)$/', $dailyRate)){
			$msg['error'] = "Formato inválido no campo valor da diária!";
		}

		$model = $modelDao->getById($selectedModel);
		if(!isset($selectedModel) || count($model) == 0){
			$msg['error'] = "O campo modelo é inválido!";
		}

		if(!isset($msg['error'])){
			try{

				$sql = new Sql();
				$sql->startTransaction();

				$vehicleDao = new VehicleDao();

				$vehicle->setDailyRate($dailyRate);
				$vehicle->setLicensePlate($place);
				$vehicle->setYear($year);
				$vehicle->setModel($model[0]);

				$idVehicle = $vehicleDao->update($vehicle);

				$sql->commit();

				$msg['success'] = "Veículo editado com sucesso!";
			}catch(PDOException $e){

				$sql->rollback();

				if( $e->getCode() == '23000' ){
					$msg['error'] = "O veículo de placa " . strtoupper($place) . " já está cadastrado!";
				}

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
			<h1 class="title">Editar veículo</h1>

			<div class="small-fields">

				<?php

					if($msg){
						?>
						<span class="my-alert <?= (empty($msg['error'])) ? 'alert-success' : 'alert-danger'; ?>"><?= (empty($msg['error'])) ? $msg['success'] : $msg['error']; ?></span>
						<?php
					}
				?>

				<form action="" method="post" name="vehicle">
					<label for="model">Modelo <em>(Obrigatório)</em></label>
					<select id="model" name="model">
						<option>Selecione...</option>

						<?php
							foreach($models as $model){
								?>
								<option value="<?= $model->getId(); ?>" <?= $model->getId() == $selectedModel ? 'selected' : ''; ?>><?= $model->getBrand()->getDescription() . "  --  " . $model->getDescription(); ?></option>
								<?
							}
						?>

					</select>

					<label for="place">Placa <em>(Obrigatório)</em></label>
					<input id="place" type="text" name="place" value="<?= $place; ?>" placeholder="Placa do veículo">

					<label for="year">Ano <em>(Obrigatório)</em></label>
					<input id="year" type="number" name="year" min="1905" value="<?= $year; ?>" placeholder="Ano do veículo">

					<label for="dailyRate">Valor da diária <em>(Obrigatório)</em></label>
					<input id="dailyRate" type="text" name="dailyRate" value="<?= $dailyRate; ?>" placeholder="Valor da diária">

					<button type="submit">EDITAR</button>
				</form>
			</div>
		</div>
	</div>

<?php require_once './footer.php'; ?>