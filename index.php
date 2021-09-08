<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$rentDao = new RentDao();
	$rents = $rentDao->getAll();

	/* --------------------------------------- */
	require_once './header.php';
	require_once './sidebar.php';
?>

	<div class="workspace">
		<div class="container">

			<div class="header-title">
				<h1 class="title">Aluguéis</h1> <a href="/aluguel/create-rent.php">Novo</a>
			</div>

			<table class="table table-hover table-striped">
				<thead class="thead-dark">
				<tr>
					<th>#</th>
					<th>Início</th>
					<th>Final</th>
					<th>Status</th>
					<th>Veículo</th>
					<th>Cliente</th>
					<th>Editar</th>
					<th>Excluir</th>
				</tr>
				</thead>

				<tbody>
				<?php

					foreach($rents as $rent){

						$status = $rent->getStatus();
						$statusBr = $status === 'progress' ? 'Andamento' : 'Concluído';

						$vehicleDao = new VehicleDao();
						$clientDao = new ClientDao();
						$modelDao = new ModelDao();

						$vehicle = $vehicleDao->getById($rent->getVehicle()->getId())[0];
						$client = $clientDao->getById($rent->getClient()->getId())[0];

						$model = $modelDao->getById($vehicle->modelId)[0];

						$vehicle->setModel($model);

						?>
						<tr>
							<td><?= $rent->getId(); ?></td>
							<td><?= Date('d/m/Y', strtotime($rent->getInitialDate())); ?></td>
							<td><?= Date('d/m/Y', strtotime($rent->getFinalDate())); ?></td>
							<td> <span class="tag-status <?= $status == 'progress' ? 'bg-success' : 'bg-warning'; ?>"><?= $statusBr; ?></span></td>
							<td><?= $vehicle->getModel()->getDescription(); ?></td>
							<td><?= $client->getName(); ?></td>
							<td><a href="/aluguel/update-rent.php?id=<?= $rent->getId(); ?>"><i class="fas fa-edit"></i></a></td>
							<td><a href="/aluguel/delete-rent.php?id=<?= $rent->getId(); ?>"><i class="fas fa-trash-alt"></i></a></td>
						</tr>
						<?php
					}

				?>
				</tbody>
			</table>
		</div>
	</div>

<?php require_once './footer.php'; ?>