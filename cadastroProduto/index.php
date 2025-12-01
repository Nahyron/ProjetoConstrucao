<?php
session_start();
require_once("../conexao/conexao.php");

// Busca fornecedores para o select
$sql_fornecedores = "SELECT idfornecedor, nome_fornecedor FROM fornecedor";
$result_fornecedores = mysqli_query($conn, $sql_fornecedores);

// Lógica de cadastro (se houver POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto = $_POST['produto'];
    $peso = $_POST['peso'];
    $unidade = $_POST['unidade'];
    $preco = $_POST['preco'];
    $fornecedor = $_POST['fornecedor'];

    // NOVO: Captura o valor do estoque mínimo enviado pelo formulário (padrão 5)
    $estoque_minimo = $_POST['estoque_minimo'];

    // Validação básica
    if (!empty($produto) && !empty($peso) && !empty($unidade) && !empty($preco) && !empty($fornecedor) && !empty($estoque_minimo)) {
        $data = date('Y-m-d');
        $validade = date('Y-m-d', strtotime('+1 year')); // Exemplo
        $nota = 'NF-' . rand(1000, 9999); // Exemplo

        // Definição do Estoque Inicial. O novo produto começa com 0 unidades
        $quantidade_inicial = 0;

        // Consulta INSERT com os novos campos (quantidade e estoque_minimo)
        $sql = "INSERT INTO cadastro_produto (
                    fk_fornecedor, 
                    nome_produto, 
                    peso_produto, 
                    unidade_medida, 
                    data_cadastro, 
                    preco_unitario, 
                    data_validade, 
                    nota_fiscal,
                    quantidade,          /* Campo de estoque atual, inicia com 0 */
                    estoque_minimo       /* Novo campo para o alerta */
                ) 
                VALUES (
                    '$fornecedor', 
                    '$produto', 
                    '$peso', 
                    '$unidade', 
                    '$data', 
                    '$preco', 
                    '$validade', 
                    '$nota', 
                    '$quantidade_inicial', 
                    '$estoque_minimo'      
                )";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Produto cadastrado com sucesso!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Preencha todos os campos!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Garante que o header alinhe as coisas para a direita */
        .user-area {
            display: flex;
            flex-direction: row;
            /* Alinha lado a lado */
            align-items: center;
            /* Centraliza verticalmente */
            justify-content: flex-end;
            gap: 15px;
            /* Espaço entre os elementos */
        }

        /* Linha superior (Olá usuário + Porta de sair) */
        .user-top-row {
            display: flex;
            align-items: center;
            gap: 10px;
            /* Espaço entre o nome e a porta */
            font-size: 1.2rem;
        }

        /* Estilo do novo botão Cinza */
        .btn-cadastro-usuario {
            background-color: #e0e0e0;
            /* Cinza claro */
            color: #333;
            text-decoration: none;
            padding: 5px 15px;
            border-radius: 20px;
            /* Borda redonda estilo "Pílula" */
            font-size: 0.9rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            /* Espaço entre texto e ícone */
            transition: background 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-cadastro-usuario:hover {
            background-color: #c0c0c0;
            /* Cinza mais escuro ao passar mouse */
            color: #000;
        }

        /* Ajuste do ícone dentro do botão */
        .btn-cadastro-usuario i {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <div>
        <header class="header">
            <div class="logo-area">
                <div class="dashboard-logo">
                    <a href="../paginaInicial/index.php">
                        <img src="../imagens/logo_casa.png" alt="Logo Constru Casa">
                    </a>
                </div>
                <span class="company-name">Constru Casa</span>
            </div>

            <div class="user-area">

                <a href="../pagina_cadastro/" class="btn-cadastro-usuario">
                    Cadastro usuário
                    <i class="bi bi-person-circle"></i>
                </a>

                <div class="user-top-row">
                    <span class="user-greeting" id="userGreeting">Olá, <?php echo $_SESSION['nome_usuario']; ?></span>
                    <i class="bi bi-door-open-fill" id="logoutBtn" style="cursor:pointer;" title="Sair do sistema"></i>
                </div>
            </div>
        </header>

        <main class="main-content">
            <nav class="sidebar">
                <ul>
                    <li class="menu-item">
                        <a href="../paginaInicial/index.php"><i class="bi bi-house-door"></i> Voltar ao Início</a>
                    </li>
                    <li class="menu-item">
                        <a href="./index.php"><i class="bi bi-tools"></i> Cadastro de produtos</a>
                    </li>
                    <li class="menu-item">
                        <a href="../cadastroFornecedor/"><i class="bi bi-truck"></i> Cadastro de fornecedores</a>
                    </li>
                    <li class="menu-item">
                        <a href="../entradaSaida/"><i class="bi bi-arrow-left-right"></i> Entrada e Saída</a>
                    </li>
                </ul>
            </nav>

            <section class="content-area">
                <div class="form-container">
                    <form method="post" class="pergunta">
                        <h2 style="color: white; margin-bottom: 20px;">Cadastro de Produto</h2>

                        <div class="mb-3">
                            <label for="fornecedor-input" class="form-label" style="color: white;">Fornecedor:</label>
                            <select name="fornecedor" id="fornecedor-input" class="form-control" required>
                                <option value="">Selecione um fornecedor</option>
                                <?php
                                if ($result_fornecedores) {
                                    while ($f = mysqli_fetch_assoc($result_fornecedores)) {
                                        echo "<option value='" . $f['idfornecedor'] . "'>" . $f['nome_fornecedor'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="produto-input" class="form-label" style="color: white;">Nome do Produto:</label>
                            <input type="text" name="produto" required placeholder="Ex: Cimento CP II" id="produto-input" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="peso-input" class="form-label" style="color: white;">Peso:</label>
                            <input type="text" name="peso" required placeholder="Ex: 50kg" id="peso-input" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="unidade-input" class="form-label" style="color: white;">Unidade de Medida:</label>
                            <select name="unidade" id="unidade-input" class="form-control" required>
                                <option value="">Selecione a unidade</option>
                                <option value="Unidade">Unidade</option>
                                <option value="Kg">Kg</option>
                                <option value="Gramas">Gramas</option>
                                <option value="Litro">Litro</option>
                                <option value="Metro">Metro</option>
                                <option value="Caixa">Caixa</option>
                                <option value="Saco">Saco</option>
                                <option value="Fardo">Fardo</option>
                                <option value="Lata">Lata</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="preco-input" class="form-label" style="color: white;">Preço Unitário:</label>
                            <input type="text" name="preco" required placeholder="Ex: 25.90" id="preco-input" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="estoque_minimo_input" class="form-label" style="color: white;">Estoque Mínimo (Padrão: 5):</label>
                            <input type="number"
                                name="estoque_minimo"
                                id="estoque_minimo_input"
                                class="form-control"
                                value="5"
                                min="0"
                                required>
                        </div>
                        <input type="submit" name="cadastrar conta" value="Cadastrar Produto" id="enviar" class="btn btn-success w-100">
                    </form>
                </div>
            </section>
        </main>
    </div>

    <script>
        // 1. Seleciona os elementos do HTML
        const logoutBtn = document.getElementById('logoutBtn');

        // 2. Configura o botão de "Sair/Voltar"
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function() {
                window.location.href = '../pagina_login/index.php';
            });
        }
    </script>
</body>

</html>