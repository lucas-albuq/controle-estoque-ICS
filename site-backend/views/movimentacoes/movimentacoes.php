<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto_id = intval($_POST['produto_id']);
    $tipo = $_POST['tipo'];
    $quantidade = intval($_POST['quantidade']);

    $estoque_sql = "SELECT quantidade_em_estoque FROM produtos WHERE id = ?";
    $estoque_stmt = $connect->prepare($estoque_sql);
    $estoque_stmt->bind_param("i", $produto_id);
    $estoque_stmt->execute();
    $result = $estoque_stmt->get_result();
    $estoque_stmt->close();

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
        $quantidade_em_estoque = intval($produto['quantidade_em_estoque']);

        if ($tipo == 'saida' && $quantidade > $quantidade_em_estoque) {
            echo "<script>alert('Erro: A quantidade de saída excede o estoque disponível!'); window.location.href = '".$_SERVER["PHP_SELF"]."';</script>";
            exit();
        }

        $sql = "INSERT INTO movimentacoes (produto_id, tipo, quantidade) VALUES (?, ?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("isi", $produto_id, $tipo, $quantidade);
        $stmt->execute();
        $stmt->close();

        if ($tipo == 'entrada') {
            $update_sql = "UPDATE produtos SET quantidade_em_estoque = quantidade_em_estoque + ? WHERE id = ?";
        } else {
            $update_sql = "UPDATE produtos SET quantidade_em_estoque = quantidade_em_estoque - ? WHERE id = ?";
        }

        $update_stmt = $connect->prepare($update_sql);
        $update_stmt->bind_param("ii", $quantidade, $produto_id);
        $update_stmt->execute();
        $update_stmt->close();

        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    } else {
        echo "<script>alert('Erro: Produto não encontrado.'); window.location.href = '".$_SERVER["PHP_SELF"]."';</script>";
        exit();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Movimentações</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 mb-5">
        <a href="../../index.php" class="btn btn-secondary mb-4">Voltar para o início</a>
        <h1 class="mb-4">Gerenciar Movimentações</h1>
        <h2 class="mb-4">Adicionar Movimentação</h2>
        <form method="post" class="mb-4">
            <div class="mb-3">
                <label for="produto_id" class="form-label">Produto:</label>
                <select name="produto_id" id="produto_id" class="form-control" required>
                    <?php
                    $produtos = mysqli_query($connect, "SELECT id, nome FROM produtos");
                    while ($produto = mysqli_fetch_assoc($produtos)) {
                        echo "<option value='" . htmlspecialchars($produto['id']) . "'>" . htmlspecialchars($produto['nome']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo:</label>
                <select name="tipo" id="tipo" class="form-control" required>
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantidade" class="form-label">Quantidade:</label>
                <input type="number" name="quantidade" id="quantidade" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Movimentação</button>
        </form>

        <h2 class="mb-4">Lista de Movimentações</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produto</th>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $mov_list = "SELECT movimentacoes.*, produtos.nome FROM movimentacoes JOIN produtos ON movimentacoes.produto_id = produtos.id ORDER BY movimentacoes.data DESC";
                $result = mysqli_query($connect, $mov_list);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quantidade']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['data']) . "</td>";
                        echo "<td>";
                        echo "<a href='excluir-movimentacao.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm m-2 mt-0 mb-0' onclick='return confirm(\"Tem certeza que deseja excluir esta movimentação?\");'>Excluir</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhuma movimentação encontrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
