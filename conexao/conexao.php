<?php
$host = 'localhost';
$dbname = 'saep_db3'; // Nome correto do banco
$username = 'root';
$password = ''; // ou sua senha

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
