<?php

	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	// Variables
	$modelName = '';
	$selectedBrand = null;
	$msg = [];

	/* GET Brands */
	$brandDao = new BrandDao();
	$brands = $brandDao->getAll();

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

				$modelDao = new ModelDao();
				$model = new Model();

				$model->setdescription($modelName);
				$model->setBrand($brand[0]);

				$idModel = $modelDao->insert($model);

				$sql->commit();

				$msg['success'] = "Modelo cadastrado com sucesso!";
			}catch(PDOException $e){

				$sql->rollback();

				if( $e->getCode() == '23000' ){
					$msg['error'] = "O modelo {$modelName} já está cadastrado!";
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
            <h1 class="title">Cadastrar modelo de veículo</h1>

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

                    <button type="submit">SALVAR</button>
                </form>
            </div>
        </div>
    </div>

<?php require_once './footer.php'; ?>