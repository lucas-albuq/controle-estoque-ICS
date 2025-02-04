<?php
include '../../db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID do produto não especificado ou inválido.");
}

$id = intval($_GET['id']); 

if (!$connect) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

$sql_mov = 'DELETE FROM movimentacoes WHERE produto_id = ?';
$stmt = $connect->prepare($sql_mov);
if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close(); 
} else {
    die("Erro ao preparar a consulta: " . $connect->error);
}

$sql = "DELETE FROM produtos WHERE id = ?";
$stmt = $connect->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close(); 
} else {
    die("Erro ao preparar a consulta: " . $connect->error);
}

$connect->close();

header("Location: produtos.php");
exit();
?>
