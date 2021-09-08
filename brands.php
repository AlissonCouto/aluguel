<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$brandDao = new BrandDao();
	$brands = $brandDao->getAll();

	/* --------------------------------------- */
	require_once './header.php';
	require_once './sidebar.php';
?>

	<div class="workspace">
		<div class="container">

			<div class="header-title">
				<h1 class="title">Marcas de veículos</h1> <a href="/aluguel/create-brand.php">Nova</a>
			</div>

			<div class="small-fields">
				<table class="table table-hover table-striped">
					<thead class="thead-dark">
					<tr>
						<th>#</th>
						<th>Marca</th>
						<th>Editar</th>
						<th>Excluir</th>
					</tr>
					</thead>

					<tbody>
					<?php

						foreach($brands as $brand){

							?>
							<tr>
								<td><?= $brand->getId(); ?></td>
								<td><?= $brand->getDescription(); ?></td>
								<td><a href="/aluguel/update-brand.php?id=<?= $brand->getId(); ?>"><i class="fas fa-edit"></i></a></td>
								<td><a href="/aluguel/delete-brand.php?id=<?= $brand->getId(); ?>"><i class="fas fa-trash-alt"></i></a></td>
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