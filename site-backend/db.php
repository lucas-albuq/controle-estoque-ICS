<?php

$host = '192.168.100.20';
$user = 'estoque';
$password = 'ifrn';
$dbname = 'controle_estoque';

$connect = mysqli_connect($host, $user, $password, $dbname);

if (!$connect) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

?>
