<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto_id = $_POST['produto_id'];
    $tipo = $_POST['tipo'];
    $quantidade = $_POST['quantidade'];

    $sql = "INSERT INTO movimentacoes (produto_id, tipo, quantidade) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$produto_id, $tipo, $quantidade]);
}

$movimentacoes = $pdo->query("SELECT * FROM movimentacoes")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Movimentações</title>
</head>
<body>
    <h1>Movimentações</h1>
    <form method="post">
        Produto ID: <input type="number" name="produto_id"><br>
        Tipo: <select name="tipo">
            <option value="entrada">Entrada</option>
            <option value="saida">Saída</option>
        </select><br>
        Quantidade: <input type="number" name="quantidade"><br>
        <button type="submit">Registrar</button>
    </form>
    <h2>Lista de Movimentações</h2>
    <ul>
        <?php foreach ($movimentacoes as $mov): ?>
            <li><?= $mov['tipo'] ?> - <?= $mov['quantidade'] ?> unidades</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
