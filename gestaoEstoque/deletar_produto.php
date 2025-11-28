<?php
session_start();
require_once("../conexao/conexao.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Previne SQL Injection básico
    $id = mysqli_real_escape_string($conn, $id);

    $sql = "DELETE FROM cadastro_produto WHERE idcadastro_produto = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Produto excluído com sucesso!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir produto: " . mysqli_error($conn) . "'); window.location.href='index.php';</script>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
