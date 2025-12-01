<?php
session_start();
require_once("../conexao/conexao.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Previne SQL Injection básico
    $id = mysqli_real_escape_string($conn, $id);

    // 1. Primeiro exclui os registros de ENTRADA desse produto
    $sql_entrada = "DELETE FROM entrada_produto WHERE fk_material = '$id'";
    mysqli_query($conn, $sql_entrada);

    // 2. Depois exclui os registros de SAÍDA desse produto
    $sql_saida = "DELETE FROM saida_produto WHERE fk_material = '$id'";
    mysqli_query($conn, $sql_saida);

    // 3. Depois exclui os registros de ALERTA desse produto
    $sql_alerta = "DELETE FROM alerta_estoque WHERE fk_material = '$id'";
    mysqli_query($conn, $sql_alerta);

    // 4. AGORA SIM, exclui o PRODUTO principal
    $sql_produto = "DELETE FROM cadastro_produto WHERE idcadastro_produto = '$id'";

    if (mysqli_query($conn, $sql_produto)) {
        echo "<script>alert('Produto e todo seu histórico excluídos com sucesso!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir produto: " . mysqli_error($conn) . "'); window.location.href='index.php';</script>";
    }
} else {
    header("Location: index.php");
    exit();
}
