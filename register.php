<?php

	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	// Variables
	$msg = [];
	$name = '';
	$email = '';
	$password = '';

	if($_POST){

		try{

			$name = $_POST['name'] ? $_POST['name'] :null;
			$email = $_POST['email'] ? $_POST['email'] : null;
			$password = $_POST['password'] ? $_POST['password'] : null;

			if(!preg_match('/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+.([a-zA-Z]{2,4})$/', $email) || !isset($email)){
				$msg['error'] = "Email inválido!";
			}

			if(!isset($password) || strlen($password) < 6){
				$msg['error'] = "A senha deve conter ao menos 6 caracteres!";
			}

			if(!isset($name)){
				$msg['error'] = "O campo nome é obrigatório!";
			}

			if(!isset($msg['error'])){

				$sql = new Sql();
				$sql->startTransaction();

				$employee = new Employee();
				$employee->setName($name);
				$employee->setEmail($email);
				$employee->setPassword($password);

				$employeeDao = new EmployeeDao();
				$insert = $employeeDao->insert($employee);

				if($insert){
					header('location: /aluguel');
				}else{
					$msg['error'] = 'Email já cadastrado.';
				}

				$sql->commit();

            }

		}catch(PDOException $e){

			$sql->rollback();

			$msg['error'] = "Houve um erro inesperado, contate o desenvolvedor!";

			$e->getTrace();
		}
	}

?>

<!doctype html>
<html lang="pt-br">
<head>

	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>BW7 - Aluguel de carros</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">

	<!-- STYLES -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="./css/style.css">
<body>

<div class="login system-wrapper">

	<div class="workspace">
		<div class="container">
			<h1 class="title">Cadastro</h1>

			<div class="m-auto small-fields">

				<?php

					if($msg){
						?>
						<span class="my-alert <?= (empty($msg['error'])) ? 'alert-success' : 'alert-danger'; ?>"><?= (empty($msg['error'])) ? $msg['success'] : $msg['error']; ?></span>
						<?php
					}
				?>

				<form action="" method="post" name="register">
					<label for="name">Email <em>(Obrigatório)</em></label>
					<input id="name" type="text" name="name" value="<?= $name; ?>" placeholder="Nome" required>

					<label for="email">Email <em>(Obrigatório)</em></label>
					<input id="email" type="email" name="email" value="<?= $email; ?>" placeholder="Email" required>

					<label for="password">Senha <em>(Obrigatório)</em></label>
					<input id="password" type="password" name="password" value="<?= $password; ?>" placeholder="Senha" required>

					<button type="submit">CADASTRAR</button>

					<a href="/aluguel/login.php">Faça login</a>
				</form>
			</div>
		</div>
	</div>

	<?php require_once './footer.php'; ?>
