<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$clientDao = new ClientDao();
	$clients = $clientDao->getAll();

	/* --------------------------------------- */
	require_once './header.php';
	require_once './sidebar.php';
?>

	<div class="workspace">
		<div class="container">

            <div class="header-title">
                <h1 class="title">Clientes</h1> <a href="/aluguel/create-client.php">Novo</a>
            </div>

            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Nome</th>
                        <th>CNH</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>

                <tbody>
                <?php

                    foreach($clients as $client){

                        $phone = $client->getPhone() ? $client->getPhone() : '(vazio)';
                        $email = $client->getEmail() ? $client->getEmail() : '(vazio)';

                        ?>
                        <tr>
                            <td><?= $client->getName(); ?></td>
                            <td><?= $client->getCnh(); ?></td>
                            <td><?= $phone; ?></td>
                            <td><?= $email; ?></td>
                            <td><a href="/aluguel/update-client.php?id=<?= $client->getId(); ?>"><i class="fas fa-edit"></i></a></td>
                            <td><a href="/aluguel/delete-client.php?id=<?= $client->getId(); ?>"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                    }

                ?>
                </tbody>
            </table>
		</div>
	</div>

<?php require_once './footer.php'; ?>