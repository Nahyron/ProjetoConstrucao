<?php
    session_start();
    require_once("../conexao/conexao.php");

    // Processar Entrada
    if (isset($_POST['btn_entrada_submit'])) {
        $id_produto = $_POST['codigo_entrada'];
        $qtd = $_POST['quantidade_entrada'];
        $nf = $_POST['nota_fiscal'];
        $data = date('Y-m-d');
        
        // Busca nome do produto para redundância
        $sql_prod = "SELECT nome_produto FROM cadastro_produto WHERE idcadastro_produto = '$id_produto'";
        $res_prod = mysqli_query($conn, $sql_prod);
        $nome_produto = ($res_prod && mysqli_num_rows($res_prod) > 0) ? mysqli_fetch_assoc($res_prod)['nome_produto'] : 'Desconhecido';

        $sql = "INSERT INTO entrada_produto (fk_material, quantidade, data_saida, nome_produto, nota_fiscal) 
                VALUES ('$id_produto', '$qtd', '$data', '$nome_produto', '$nf')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Entrada registrada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao registrar entrada: " . mysqli_error($conn) . "');</script>";
        }
    }

    // Processar Saída
    if (isset($_POST['btn_saida_submit'])) {
        $id_produto = $_POST['codigo_saida'];
        $qtd = $_POST['quantidade_saida'];
        $destino = $_POST['destino_saida'];
        $data = date('Y-m-d');
        $id_usuario = $_SESSION['id_usuario'] ?? 1; // Fallback para 1 se não houver sessão

        // Busca nome do produto
        $sql_prod = "SELECT nome_produto FROM cadastro_produto WHERE idcadastro_produto = '$id_produto'";
        $res_prod = mysqli_query($conn, $sql_prod);
        $nome_produto = ($res_prod && mysqli_num_rows($res_prod) > 0) ? mysqli_fetch_assoc($res_prod)['nome_produto'] : 'Desconhecido';

        $sql = "INSERT INTO saida_produto (fk_material, fk_usuario, quantidade_saida, data_saida, nome_produto, destino_saida) 
                VALUES ('$id_produto', '$id_usuario', '$qtd', '$data', '$nome_produto', '$destino')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Saída registrada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao registrar saída: " . mysqli_error($conn) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constru Casa - Entrada e Saída</title>
    
    <link rel="stylesheet" href="./css/style.css"> 
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* Estilos específicos para a área de Entrada e Saída */
        .forms-container {
            display: flex;
            gap: 40px;
            justify-content: space-around;
            margin-top: 30px;
        }
        .form-box {
            background-color: #3f3f3f; /* Fundo levemente mais claro */
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 45%;
        }
        .form-box h3 {
            color: #d8c8c8;
            margin-bottom: 20px;
            border-bottom: 2px solid #555;
            padding-bottom: 10px;
        }
        .form-box label {
             display: block;
             margin-bottom: 5px;
             color: #ccc;
             font-weight: bold;
         }
        .form-box input[type="text"],
        .form-box input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #555;
            border-radius: 4px;
            background-color: #4a4a4a;
            color: white;
        }
        .form-box button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        #btn-entrada {
            background-color: #4CAF50; /* Verde */
            color: white;
        }
        #btn-entrada:hover {
            background-color: #45a049;
        }
        #btn-saida {
            background-color: #f44336; /* Vermelho */
            color: white;
        }
        #btn-saida:hover {
            background-color: #da190b;
        }

        /* Garante que o header alinhe as coisas para a direita */
        .user-area {
            display: flex;
            flex-direction: row; /* Alinha lado a lado */
            align-items: center;  /* Centraliza verticalmente */
            justify-content: flex-end;
            gap: 15px; /* Espaço entre os elementos */
        }

        /* Linha superior (Olá usuário + Porta de sair) */
        .user-top-row {
            display: flex;
            align-items: center;
            gap: 10px; /* Espaço entre o nome e a porta */
            font-size: 1.2rem;
        }

        /* Estilo do novo botão Cinza */
        .btn-cadastro-usuario {
            background-color: #e0e0e0; /* Cinza claro */
            color: #333;
            text-decoration: none;
            padding: 5px 15px;
            border-radius: 20px; /* Borda redonda estilo "Pílula" */
            font-size: 0.9rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px; /* Espaço entre texto e ícone */
            transition: background 0.3s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-cadastro-usuario:hover {
            background-color: #c0c0c0; /* Cinza mais escuro ao passar mouse */
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
                        <a href="../cadastroProduto/"><i class="bi bi-tools"></i> Cadastro de produtos</a>
                    </li>
                    <li class="menu-item">
                        <a href="../cadastroFornecedor/"><i class="bi bi-truck"></i> Cadastro de fornecedores</a>
                    </li>
                    <li class="menu-item">
                        <a href="./index.php"><i class="bi bi-arrow-left-right"></i> Entrada e Saída</a>
                    </li>
                </ul>
            </nav>

            <section class="content-area">
                <h1 style="color: white; margin-bottom: 20px;">Registro de Entrada e Saída</h1>
                
                <div class="forms-container">
                    <!-- Formulário de Entrada -->
                    <div class="form-box">
                        <h3>Entrada de Produto</h3>
                        <form method="POST" action="">
                            <label>Código do Produto</label>
                            <input type="number" name="codigo_entrada" required>
                            
                            <label>Quantidade</label>
                            <input type="number" name="quantidade_entrada" required>
                            
                            <label>Nota Fiscal</label>
                            <input type="text" name="nota_fiscal" required>
                            
                            <button type="submit" name="btn_entrada_submit" id="btn-entrada">Registrar Entrada</button>
                        </form>
                    </div>

                    <!-- Formulário de Saída -->
                    <div class="form-box">
                        <h3>Saída de Produto</h3>
                        <form method="POST" action="">
                            <label>Código do Produto</label>
                            <input type="number" name="codigo_saida" required>
                            
                            <label>Quantidade</label>
                            <input type="number" name="quantidade_saida" required>
                            
                            <label>Destino</label>
                            <input type="text" name="destino_saida" required>
                            
                            <button type="submit" name="btn_saida_submit" id="btn-saida">Registrar Saída</button>
                        </form>
                    </div>
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