<?php

include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$quantidade = $_POST['quantidade'];
	$preco = $_POST['preco'];

	$sql = "INSERT INTO produtos (nome, descricao, quantidade_em_estoque, preco) VALUES (?, ?, ?, ?)";
	$stmt = $connect->prepare($sql);
	$stmt->bind_param("ssis", $nome, $descricao, $quantidade, $preco);
	$stmt->execute();
	header("Location: " . $_SERVER["PHP_SELF"]);
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Gerenciar produtos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container mt-5 mb-5">
		<a href="../../index.php" class="btn btn-secondary mb-4">Voltar para o início</a> 
		<h1 class="mb-4">Gerenciar produtos</h1>
		<h2 class="mb-4">Adicionar produto</h2>
		<form method="post" class="mb-4">
			<div class="mb-3">
				<label for="nome" class="form-label">Nome:</label>
				<input type="text" name="nome" id="nome" class="form-control" required>
			</div>
			<div class="mb-3">
				<label for="descricao" class="form-label">Descrição:</label>
				<textarea name="descricao" id="descricao" class="form-control" required></textarea>
			</div>
			<div class="mb-3">
				<label for="quantidade" class="form-label">Quantidade:</label>
				<input type="number" name="quantidade" id="quantidade" class="form-control" required>
			</div>
			<div class="mb-3">
				<label for="preco" class="form-label">Preço:</label>
				<input type="text" name="preco" id="preco" class="form-control" required>
			</div>
			<button type="submit" class="btn btn-primary">Adicionar produto</button>
		</form>

		<h2 class="mb-4">Lista de produtos</h2>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Nome</th>
					<th>Descrição</th>
					<th>Quantidade</th>
					<th>Preço</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$list = "SELECT * FROM produtos";
					$result = mysqli_query($connect, $list);
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>" . htmlspecialchars($row['id']) . "</td>";
							echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
							echo "<td>" . htmlspecialchars($row['descricao']) . "</td>";
							echo "<td>" . htmlspecialchars($row['quantidade_em_estoque']) . "</td>";
							echo "<td>" . htmlspecialchars($row['preco']) . "</td>";
							echo "<td>";
							echo "<a href='editar-produtos.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-warning btn-sm m-2 mt-0 mb-0'>Editar</a>";
							echo "<a href='excluir-produtos.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\");'>Excluir</a>";
							echo "</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='6'>Nenhum produto encontrado.</td></tr>";
					}
				?>
	</tbody>
		</table>
	</div>
</body>
</html>
