<?php
    session_start();
    require_once("../conexao/conexao.php");

    $id = $_GET['id'] ?? null;
    $produto_data = null;

    if ($id) {
        $id = mysqli_real_escape_string($conn, $id);
        $sql = "SELECT * FROM cadastro_produto WHERE idcadastro_produto = '$id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $produto_data = mysqli_fetch_assoc($result);
        } else {
            echo "<script>alert('Produto não encontrado!'); window.location.href='index.php';</script>";
            exit;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $produto = $_POST['produto'];
        $peso = $_POST['peso'];
        $unidade = $_POST['unidade'];
        $preco = $_POST['preco'];

        $sql_update = "UPDATE cadastro_produto SET nome_produto='$produto', peso_produto='$peso', unidade_medida='$unidade', preco_unitario='$preco' WHERE idcadastro_produto='$id'";
        
        if (mysqli_query($conn, $sql_update)) {
            echo "<script>alert('Produto atualizado com sucesso!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar: " . mysqli_error($conn) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../paginainicial/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
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
                    <a href="../cadastroProduto/"><i class="bi bi-tools"></i> Cadastro de produtos</a>
                </li>
                <li class="menu-item">
                    <a href="../entradaSaida/"><i class="bi bi-boxes"></i> entrada e saída dos produtos</a>
                </li>
                <li class="menu-item">
                    <a href="../gestaoEstoque/"><i class="bi bi-cart-plus"></i> gestão de estoque</a>
                </li>
                <li class="menu-item">
                    <a href="../Tabelas/tabela.php"><i class="bi bi-table"></i> Acessar Tabelas</a>
                </li>
            </ul>
        </nav>

        <section class="content-area">
            <div class="container mt-5">
                <h2 style="color: white;">Editar Produto</h2>
                <form method="post" class="bg-dark p-4 rounded text-white">
                    <input type="hidden" name="id" value="<?php echo $produto_data['idcadastro_produto']; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Produto:</label>
                        <input type="text" name="produto" class="form-control" value="<?php echo $produto_data['nome_produto']; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Peso:</label>
                        <input type="text" name="peso" class="form-control" value="<?php echo $produto_data['peso_produto']; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Unidade Medida:</label>
                        <input type="text" name="unidade" class="form-control" value="<?php echo $produto_data['unidade_medida']; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Preço Unitário:</label>
                        <input type="text" name="preco" class="form-control" value="<?php echo $produto_data['preco_unitario']; ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </section>
    </main>

    <script>
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function() {
                window.location.href = '../pagina_login/index.php'; 
            });
        }
    </script>
</body>
</html>
