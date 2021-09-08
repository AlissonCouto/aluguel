<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$vehicleDao = new VehicleDao();
	$vehicles = $vehicleDao->getAll();

	/* --------------------------------------- */
	require_once './header.php';
	require_once './sidebar.php';
?>

	<div class="workspace">
		<div class="container">
            <div class="header-title">
                <h1 class="title">Veículos</h1> <a href="/aluguel/create-vehicle.php">Novo</a>
            </div>

			<table class="table table-hover table-striped">
				<thead class="thead-dark">
				<tr>
					<th>Modelo</th>
					<th>Placa</th>
					<th>Ano</th>
					<th>Valor da diária</th>
					<th>Status</th>
					<th>Editar</th>
					<th>Excluir</th>
				</tr>
				</thead>

				<tbody>
				<?php

					foreach($vehicles as $vehicle){

						$status = $vehicle->getStatus();
						$statusBr = $status === 'available' ? 'Disponível' : 'Alugado';

						?>
						<tr>
							<td><?= $vehicle->getModel()->getDescription(); ?></td>
							<td><?= $vehicle->getLicensePlate(); ?></td>
							<td><?= $vehicle->getYear(); ?></td>
							<td><?= $vehicle->getDailyRate(); ?></td>
							<td> <span class="tag-status <?= $status == 'available' ? 'bg-success' : 'bg-warning'; ?>"><?= $statusBr; ?></span></td>
							<td><a href="/aluguel/update-vehicle.php?id=<?= $vehicle->getId(); ?>"><i class="fas fa-edit"></i></a></td>
							<td><a href="/aluguel/delete-vehicle.php?id=<?= $vehicle->getId(); ?>"><i class="fas fa-trash-alt"></i></a></td>
						</tr>
						<?php
					}

				?>
				</tbody>
			</table>
		</div>
	</div>

<?php require_once './footer.php'; ?>