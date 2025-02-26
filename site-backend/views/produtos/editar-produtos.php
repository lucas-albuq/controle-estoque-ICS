<?php
include '../../db.php';

if (!isset($_GET['id'])) {
    die("ID do produto não especificado.");
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];

    $sql = "UPDATE produtos SET nome=?, descricao=?, quantidade_em_estoque=?, preco=? WHERE id=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssisi", $nome, $descricao, $quantidade, $preco, $id);
    $stmt->execute();

    header("Location: produtos.php");
    exit();
}

$sql = "SELECT * FROM produtos WHERE id=?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produto = $result->fetch_assoc();

if (!$produto) {
    die("Produto não encontrado.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <a href="produtos.php" class="btn btn-secondary mb-4">Voltar</a>
        <h1 class="mb-4">Editar Produto</h1>
        <form method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?= htmlspecialchars($produto['nome']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea name="descricao" id="descricao" class="form-control" required><?= htmlspecialchars($produto['descricao']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="quantidade" class="form-label">Quantidade:</label>
                <input type="number" name="quantidade" id="quantidade" class="form-control" value="<?= htmlspecialchars($produto['quantidade_em_estoque']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço:</label>
                <input type="text" name="preco" id="preco" class="form-control" value="<?= htmlspecialchars($produto['preco']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="produtos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
