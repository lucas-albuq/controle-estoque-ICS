<?php
include '../../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT produto_id, tipo, quantidade FROM movimentacoes WHERE id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movimentacao = $result->fetch_assoc();

    if ($movimentacao) {
        $produto_id = $movimentacao['produto_id'];
        $tipo = $movimentacao['tipo'];
        $quantidade = $movimentacao['quantidade'];

        if ($tipo == 'entrada') {
            $update_sql = "UPDATE produtos SET quantidade_em_estoque = quantidade_em_estoque - ? WHERE id = ?";
        } else {
            $update_sql = "UPDATE produtos SET quantidade_em_estoque = quantidade_em_estoque + ? WHERE id = ?";
        }

        $update_stmt = $connect->prepare($update_sql);
        $update_stmt->bind_param("ii", $quantidade, $produto_id);
        $update_stmt->execute();

        $delete_sql = "DELETE FROM movimentacoes WHERE id = ?";
        $delete_stmt = $connect->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);
        $delete_stmt->execute();
    }
}

header("Location: movimentacoes.php");
exit();
?>
