<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];

    $sql = "INSERT INTO produtos (nome, descricao, quantidade_em_estoque, preco) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $descricao, $quantidade, $preco]);
}

$produtos = $pdo->query("SELECT * FROM produtos")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Produtos</title>
</head>
<body>
    <h1>Produtos</h1>
    <form method="post">
        Nome: <input type="text" name="nome"><br>
        Descrição: <textarea name="descricao"></textarea><br>
        Quantidade: <input type="number" name="quantidade"><br>
        Preço: <input type="text" name="preco"><br>
        <button type="submit">Adicionar</button>
    </form>
    <h2>Lista de Produtos</h2>
    <ul>
        <?php foreach ($produtos as $produto): ?>
            <li><?= $produto['nome'] ?> (<?= $produto['quantidade_em_estoque'] ?> unidades)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
