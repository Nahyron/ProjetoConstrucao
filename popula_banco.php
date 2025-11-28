<?php
require_once("conexao/conexao.php");

$produtos_teste = [
    ['Tinta Acrílica', 'Branco Neve', 'Fosca', '18L'],
    ['Cimento CP-II', 'Cinza', 'Pó', '50kg'],
    ['Argamassa AC-III', 'Cinza', 'Pó', '20kg'],
    ['Tinta Esmalte', 'Preto', 'Brilhante', '3.6L'],
    ['Rejunte', 'Bege', 'Liso', '1kg'],
    ['Massa Corrida', 'Branca', 'Lisa', '25kg'],
    ['Verniz Marítimo', 'Incolor', 'Brilhante', '900ml'],
    ['Selador Acrílico', 'Branco', 'Fosco', '18L']
];

echo "<h2>Iniciando população do banco...</h2>";

foreach ($produtos_teste as $prod) {
    $produto = $prod[0];
    $cor = $prod[1];
    $textura = $prod[2];
    $peso = $prod[3];

    $sql = "INSERT INTO produtos (produto, cor, textura, peso_litro) VALUES ('$produto', '$cor', '$textura', '$peso')";

    if (mysqli_query($conn, $sql)) {
        echo "Produto '$produto' inserido com sucesso.<br>";
    } else {
        echo "Erro ao inserir '$produto': " . mysqli_error($conn) . "<br>";
    }
}

echo "<h3>Processo finalizado! <a href='gestaoEstoque/index.php'>Ir para Gestão de Estoque</a></h3>";
?>
