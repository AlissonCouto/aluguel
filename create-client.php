<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	// Variables
	$name = '';
	$cnh = '';
	$phone = '';
	$email = null;
	$msg = [];


	/* GET Brands */
	$modelDao = new ModelDao();
	$models = $modelDao->getAll();

	if($_POST){

		$name = $_POST['name'] ? $_POST['name'] : null;
		$cnh = $_POST['cnh'] ? $_POST['cnh'] : null;
		$phone = $_POST['phone'] ? $_POST['phone'] : null;
		$email = $_POST['email'] ? $_POST['email'] : null;

		if (!preg_match('/[a-zA-Zà-úÀ-Ú\s]{3,}/', $name)) {
			$msg['error'] = "O nome deve conter apenas letras e pelo menos 3 caracteres!";
		}

		if(strlen($cnh) != 11){
			$msg['error'] = "A CNH informada é inválida!";
		}

		$number = preg_replace("/\([0-9]{2}\)/", "", $phone);
		$number = str_replace(["-", " "], "", $number);
		if(!preg_match('/[0-9]{8,9}/', $number) && isset($number)){
			$msg['error'] = "Telefone inválido!";
		}

		if(!preg_match('/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+.([a-zA-Z]{2,4})$/', $email) && isset($email)){
			$msg['error'] = "Email inválido!";
		}

		if(!isset($msg['error'])){
			try{

				$sql = new Sql();
				$sql->startTransaction();

				$clientDao = new ClientDao();
				$client = new Client();

                $client->setName($name);
                $client->setCnh($cnh);
                $client->setPhone($phone);
                $client->setEmail($email);

				$idClient = $clientDao->insert($client);

				$sql->commit();

				$msg['success'] = "Cliente cadastrado com sucesso!";
			}catch(PDOException $e){

				$sql->rollback();

				if( $e->getCode() == '23000' ){
					$msg['error'] = "O cliente de CNH {$cnh} já está cadastrado!";
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
			<h1 class="title">Cadastrar cliente</h1>

			<div class="small-fields">

				<?php

					if($msg){
						?>
                        <span class="my-alert <?= (empty($msg['error'])) ? 'alert-success' : 'alert-danger'; ?>"><?= (empty($msg['error'])) ? $msg['success'] : $msg['error']; ?></span>
						<?php
					}
				?>

				<form action="" method="post" name="client">
					<label for="name">Nome <em>(Obrigatório)</em></label>
					<input id="name" type="text" name="name" value="<?= $name; ?>" placeholder="Nome" required>

					<label for="cnh">CNH <em>(Obrigatório)</em></label>
					<input id="cnh" type="text" name="cnh" value="<?= $cnh; ?>" placeholder="CNH" required>

					<label for="phone">Telefone</label>
					<input id="phone" type="text" name="phone" value="<?= $phone; ?>" placeholder="Telefone">

					<label for="email">Email</label>
					<input id="email" type="email" name="email" value="<?= $email; ?>" placeholder="Email">

					<button type="submit">SALVAR</button>
				</form>
			</div>
		</div>
	</div>

<?php require_once './footer.php'; ?>