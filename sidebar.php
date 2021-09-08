<?php

	// Capturing logged in user

	$id = (int) $_SESSION['login'];

	$employeeDao = new EmployeeDao();
	$employee = $employeeDao->getById($id)[0];

	$userName = $employee->getName();

?>

<div class="sidebar">
	<div class="header">
		<div class="username"><?= $userName; ?></div>
		<div class="logout"><a href="/aluguel/logout.php"><i class="fas fa-sign-out-alt"></i></a></div>
	</div>

	<nav class="menu">
		<ul>
			<li><a href="/aluguel/index.php">Aluguéis</a></li>
			<ul class="submenu">
				<li><a href="/aluguel/index.php">Ver todos</a></li>
				<li><a href="/aluguel/create-rent.php">Novo</a></li>
			</ul>

			<li>
				<a href="/aluguel/vehicles.php">Carros</a>
				<ul class="submenu">
					<li><a href="/aluguel/vehicles.php">Ver todos</a></li>
					<li><a href="/aluguel/create-vehicle.php">Novo</a></li>
					<li><a href="/aluguel/brands.php">Marcas</a></li>
					<li><a href="/aluguel/models.php">Modelos</a></li>
				</ul>
			</li>

			<li>
                <a href="/aluguel/clients.php">Clientes</a>
				<ul class="submenu">
					<li><a href="/aluguel/clients.php">Ver todos</a></li>
					<li><a href="/aluguel/create-client.php">Novo</a></li>
				</ul>
			</li>
		</ul>
	</nav>
</div>