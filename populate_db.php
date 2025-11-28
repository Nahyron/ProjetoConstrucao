<?php
require_once("conexao/conexao.php");

// Função para executar query e mostrar mensagem
function executarQuery($conn, $sql, $mensagemSucesso) {
    if (mysqli_query($conn, $sql)) {
        echo "<div style='color: green;'>✅ " . $mensagemSucesso . "</div><br>";
    } else {
        echo "<div style='color: red;'>❌ Erro: " . mysqli_error($conn) . "</div><br>";
    }
}

echo "<h2>Iniciando população do banco de dados...</h2>";

// 1. Inserir Usuário de Teste
$nome = "Administrador";
$usuario = "admin@construcasa.com";
$senha = "admin123"; // Senha simples para teste

// Verifica se já existe para não duplicar (opcional, mas bom para re-execução)
$checkUser = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
$resultUser = mysqli_query($conn, $checkUser);

if (mysqli_num_rows($resultUser) == 0) {
    $sqlUser = "INSERT INTO usuarios (nome_usuario, usuario, senha) VALUES ('$nome', '$usuario', '$senha')";
    executarQuery($conn, $sqlUser, "Usuário '$usuario' criado com sucesso.");
} else {
    echo "<div style='color: orange;'>⚠️ Usuário '$usuario' já existe.</div><br>";
}

// 2. Inserir Produtos de Teste
$produtos = [
    ['Cimento CP II', 'Cinza', 'Fina', '50kg'],
    ['Tinta Acrílica', 'Branco Neve', 'Fosco', '18L'],
    ['Tijolo Baiano', 'Vermelho', 'Cerâmica', '2kg'],
    ['Areia Média', 'Amarela', 'Granulada', '1m³'],
    ['Piso Porcelanato', 'Bege', 'Polido', '60x60cm'],
    ['Argamassa ACIII', 'Cinza', 'Colante', '20kg'],
    ['Telha Colonial', 'Vermelho', 'Barro', '3kg'],
    ['Porta de Madeira', 'Mogno', 'Lisa', '210x80cm'],
    ['Janela de Alumínio', 'Branco', 'Vidro', '100x120cm'],
    ['Lâmpada LED', 'Branco Frio', '9W', '100g']
];

foreach ($produtos as $prod) {
    $nomeProd = $prod[0];
    $cor = $prod[1];
    $textura = $prod[2];
    $peso = $prod[3];

    // Verifica duplicidade pelo nome do produto
    $checkProd = "SELECT * FROM produtos WHERE produto = '$nomeProd'";
    $resultProd = mysqli_query($conn, $checkProd);

    if (mysqli_num_rows($resultProd) == 0) {
        $sqlProd = "INSERT INTO produtos (produto, cor, textura, peso_litro) VALUES ('$nomeProd', '$cor', '$textura', '$peso')";
        executarQuery($conn, $sqlProd, "Produto '$nomeProd' inserido.");
    } else {
        echo "<div style='color: orange;'>⚠️ Produto '$nomeProd' já existe.</div><br>";
    }
}

echo "<h3>Processo finalizado!</h3>";
echo "<a href='pagina_login/index.php'>Ir para Login</a>";
?>
