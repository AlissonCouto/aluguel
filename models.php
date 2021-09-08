<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$modelDao = new ModelDao();
	$models = $modelDao->getAll();

	/* --------------------------------------- */
	require_once './header.php';
	require_once './sidebar.php';
?>

	<div class="workspace">
		<div class="container">

			<div class="header-title">
				<h1 class="title">Modelos de veículos</h1> <a href="/aluguel/create-model.php">Novo</a>
			</div>

			<div class="small-fields">
				<table class="table table-hover table-striped">
					<thead class="thead-dark">
					<tr>
						<th>#</th>
						<th>Modelo</th>
						<th>Marca</th>
						<th>Editar</th>
						<th>Excluir</th>
					</tr>
					</thead>

					<tbody>
					<?php

						foreach($models as $model){

							?>
							<tr>
								<td><?= $model->getId(); ?></td>
								<td><?= $model->getDescription(); ?></td>
								<td><?= $model->getBrand()->getDescription(); ?></td>
								<td><a href="/aluguel/update-model.php?id=<?= $model->getId(); ?>"><i class="fas fa-edit"></i></a></td>
								<td><a href="/aluguel/delete-model.php?id=<?= $model->getId(); ?>"><i class="fas fa-trash-alt"></i></a></td>
							</tr>
							<?php
						}

					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<?php require_once './footer.php'; ?>