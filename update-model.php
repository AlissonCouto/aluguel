<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	// Variables
	$modelName = '';
	$selectedBrand = null;
	$msg = [];

	$modelDao = new ModelDao();
	$brandDao = new BrandDao();

		$id = $_GET['id'] ? (int) $_GET['id'] : null;

		$model = $modelDao->getById($id);

		if(count($model) > 0){
			$model = $model[0];


			$brands = $brandDao->getAll();

			$brand = $brandDao->getById($model->brandId)[0];

			$selectedBrand = $brand->getId();
			$modelName = $model->getDescription();
		}else{
			header('location: /aluguel/models.php');
		}


	if( $_POST ){

		$modelName = $_POST['model'] ? trim($_POST['model']) : null;
		$selectedBrand = $_POST['brand'] ? $_POST['brand'] : null;

		if(strlen($modelName) <= 1){
			$msg['error'] = "O campo modelo é obrigatório e deve conter mais de 2 caracteres!";
		}

		$brand = $brandDao->getById($selectedBrand);

		if(!isset($selectedBrand) || count($brand) == 0){
			$msg['error'] = "O campo marca é inválido!";
		}

		if(!isset($msg['error'])){

			try{

				$sql = new Sql();
				$sql->startTransaction();

				$model->setdescription($modelName);
				$model->setBrand($brand[0]);

				$idModel = $modelDao->update($model);

				$sql->commit();

				$msg['success'] = "Marca editada com sucesso!";
			}catch(PDOException $e){

				$sql->rollback();

				if( $e->getCode() == '23000' ){
					$msg['error'] = "A marca {$brandName} já está cadastrada!";
				}

				$e->getTrace();
			}

		}

	} // POST exists

	/* --------------------------------------- */
	require_once './header.php';
	require_once './sidebar.php';
?>

	<div class="workspace">
		<div class="container">
			<h1 class="title">Editar modelo de veículo</h1>

			<div class="small-fields">

				<?php

					if($msg){
						?>
						<span class="my-alert <?= (empty($msg['error'])) ? 'alert-success' : 'alert-danger'; ?>"><?= (empty($msg['error'])) ? $msg['success'] : $msg['error']; ?></span>
						<?php
					}
				?>

				<form action="" method="post" name="form">
					<label for="model">Modelo <em>(Obrigatório)</em></label>
					<input id="model" type="text" name="model" value="<?= $modelName; ?>" placeholder="Digite o nome do modelo">

					<label for="brand">Marca <em>(Obrigatório)</em></label>
					<select id="brand" name="brand">
						<option>Selecione...</option>
						<?php
							foreach ($brands as  $b){
								?>
								<option value="<?= $b->getId(); ?>" <?= ($selectedBrand === $b->getId()) ? 'selected' : ''; ?>><?= $b->getDescription(); ?></option>
								<?
							}
						?>
					</select>

					<button type="submit">EDITAR</button>
				</form>
			</div>
		</div>
	</div>

<?php require_once './footer.php'; ?>