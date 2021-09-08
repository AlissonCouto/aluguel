<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	// Variables
	$brandName = '';
    $msg = [];

	if( $_POST ){

	    $brandName = $_POST['brand'] ? trim($_POST['brand']) : null;

		if(strlen($brandName) < 3){
			$msg['error'] = "O campo marca é obrigatório e deve conter mais de 3 caracteres!";
		}else{

			try{

				$sql = new Sql();
				$sql->startTransaction();

				$brandDao = new BrandDao();
				$brand = new Brand();

				$brand->setdescription($brandName);

				$idBrand = $brandDao->insert($brand);

				$sql->commit();

				$msg['success'] = "Marca cadastrada com sucesso!";
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
            <h1 class="title">Cadastrar marca de veículo</h1>

			<div class="small-fields">

				<?php

					if($msg){
						?>
                        <span class="my-alert <?= (empty($msg['error'])) ? 'alert-success' : 'alert-danger'; ?>"><?= (empty($msg['error'])) ? $msg['success'] : $msg['error']; ?></span>
						<?php
					}
				?>

				<form action="" method="post" name="create-brand">
					<label for="brand">Marca <em>(Obrigatório)</em></label>
					<input id="brand" type="text" name="brand" value="<?= $brandName; ?>" placeholder="Digite o nome da marca" required>

					<button type="submit">SALVAR</button>
				</form>
			</div>
        </div>
    </div>

<?php require_once './footer.php'; ?>