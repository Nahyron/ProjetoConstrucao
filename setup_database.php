<?php
require_once("conexao/conexao.php");

function executarQuery($conn, $sql, $msgSucesso) {
    if (mysqli_query($conn, $sql)) {
        echo "<div style='color: green;'>✅ " . $msgSucesso . "</div><br>";
        return true;
    } else {
        echo "<div style='color: red;'>❌ Erro: " . mysqli_error($conn) . "</div><br>";
        return false;
    }
}

echo "<h2>Configurando Banco de Dados...</h2>";

// 1. Ler e Executar o SQL do arquivo saep_db.sql
$sqlFile = 'saep_db.sql';
if (file_exists($sqlFile)) {
    $sqlContent = file_get_contents($sqlFile);
    
    // O mysqli_multi_query é chato com comentários e delimitadores, vamos tentar limpar ou rodar em partes
    // Uma abordagem simples para dumps do phpMyAdmin é separar por ;
    // Mas dumps podem ter ; dentro de strings. Vamos tentar rodar como multi_query direto primeiro.
    
    if (mysqli_multi_query($conn, $sqlContent)) {
        echo "<div style='color: green;'>✅ Schema importado com sucesso (multi_query).</div><br>";
        // Limpar resultados para permitir próximas queries
        while (mysqli_next_result($conn)) {;} 
    } else {
        echo "<div style='color: red;'>❌ Erro ao importar schema: " . mysqli_error($conn) . "</div><br>";
        // Se falhar, pode ser que as tabelas já existam ou erro de sintaxe. Vamos continuar tentando popular.
    }
} else {
    echo "<div style='color: red;'>❌ Arquivo $sqlFile não encontrado.</div><br>";
}

// 2. Popular Fornecedores (Necessário para cadastro_produto)
echo "<h3>Populando Fornecedores...</h3>";
$fornecedores = [
    ['ConstruTudo Ltda', 'São Paulo', '12.345.678/0001-90', 'Zona Sul'],
    ['Materiais Silva', 'Rio de Janeiro', '98.765.432/0001-10', 'Centro'],
    ['Depósito Central', 'Belo Horizonte', '11.222.333/0001-55', 'Zona Norte']
];

foreach ($fornecedores as $f) {
    $nome = $f[0];
    $destino = $f[1];
    $cnpj = $f[2];
    $local = $f[3];
    
    // Verifica duplicidade
    $check = mysqli_query($conn, "SELECT * FROM fornecedor WHERE nome_fornecedor = '$nome'");
    if (mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO fornecedor (nome_fornecedor, destino, cnpj_empresa, local_empresa) VALUES ('$nome', '$destino', '$cnpj', '$local')";
        executarQuery($conn, $sql, "Fornecedor '$nome' inserido.");
    }
}

// 3. Popular Produtos (Tabela cadastro_produto)
echo "<h3>Populando Produtos...</h3>";
// Precisamos de IDs de fornecedores válidos
$resFornecedores = mysqli_query($conn, "SELECT idfornecedor FROM fornecedor");
$idsFornecedores = [];
while ($row = mysqli_fetch_assoc($resFornecedores)) {
    $idsFornecedores[] = $row['idfornecedor'];
}

if (count($idsFornecedores) > 0) {
    $produtos = [
        ['Cimento CP II', '50kg', 'Saco', '25.90'],
        ['Tinta Acrílica Branco', '18L', 'Lata', '280.00'],
        ['Tijolo Baiano', '2kg', 'Unidade', '1.50'],
        ['Areia Média', '1000kg', 'Metro Cúbico', '120.00'],
        ['Piso Porcelanato Bege', '20kg', 'Caixa', '89.90'],
        ['Argamassa ACIII', '20kg', 'Saco', '35.00'],
        ['Telha Colonial', '3kg', 'Unidade', '2.20'],
        ['Porta de Madeira', '30kg', 'Unidade', '450.00'],
        ['Janela Alumínio', '15kg', 'Unidade', '300.00'],
        ['Lâmpada LED 9W', '0.1kg', 'Unidade', '12.00']
    ];

    foreach ($produtos as $i => $p) {
        $nome = $p[0];
        $peso = $p[1];
        $unidade = $p[2];
        $preco = $p[3];
        $fk_fornecedor = $idsFornecedores[$i % count($idsFornecedores)]; // Distribui entre fornecedores
        $data = date('Y-m-d');
        $validade = date('Y-m-d', strtotime('+1 year'));
        $nota = 'NF-' . rand(1000, 9999);

        $check = mysqli_query($conn, "SELECT * FROM cadastro_produto WHERE nome_produto = '$nome'");
        if (mysqli_num_rows($check) == 0) {
            $sql = "INSERT INTO cadastro_produto (fk_fornecedor, nome_produto, peso_produto, unidade_medida, data_cadastro, preco_unitario, data_validade, nota_fiscal) 
                    VALUES ('$fk_fornecedor', '$nome', '$peso', '$unidade', '$data', '$preco', '$validade', '$nota')";
            executarQuery($conn, $sql, "Produto '$nome' inserido.");
        }
    }
} else {
    echo "<div style='color: red;'>❌ Nenhum fornecedor encontrado. Não é possível cadastrar produtos.</div>";
}

// 4. Usuários (Adicionar Admin se não existir)
echo "<h3>Verificando Usuários...</h3>";
$usuario = "admin@construcasa.com";
$checkUser = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuario = '$usuario'");
if (mysqli_num_rows($checkUser) == 0) {
    $sql = "INSERT INTO usuarios (nome_usuario, usuario, senha) VALUES ('Administrador', '$usuario', 'admin123')";
    executarQuery($conn, $sql, "Usuário Admin criado.");
}

echo "<h3>Processo Finalizado!</h3>";
echo "<a href='pagina_login/index.php'>Ir para Login</a>";
?>
