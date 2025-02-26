<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Controle de Estoque</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Controle de Estoque</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Quantidade em Estoque</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../site-backend/db.php';
                
                $sql = "SELECT * FROM produtos";
                $result = mysqli_query($connect, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['descricao']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quantidade_em_estoque']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['preco']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum produto encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
