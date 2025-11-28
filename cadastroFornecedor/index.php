<?php
    session_start();
    require_once("../conexao/conexao.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $destino = $_POST['destino'];
        $cnpj = $_POST['cnpj'];
        $local = $_POST['local'];
        
        if(!empty($nome) && !empty($cnpj)) {
            $sql = "INSERT INTO fornecedor (nome_fornecedor, destino, cnpj_empresa, local_empresa) 
                    VALUES ('$nome', '$destino', '$cnpj', '$local')";
            
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Fornecedor cadastrado com sucesso!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Erro ao cadastrar: " . mysqli_error($conn) . "');</script>";
            }
        } else {
             echo "<script>alert('Preencha os campos obrigatórios!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Fornecedor</title>
    <link rel="stylesheet" href="../cadastroProduto/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Reusing styles from other pages for consistency */
        .user-area { display: flex; flex-direction: row; align-items: center; justify-content: flex-end; gap: 15px; }
        .user-top-row { display: flex; align-items: center; gap: 10px; font-size: 1.2rem; }
        .btn-cadastro-usuario { background-color: #e0e0e0; color: #333; text-decoration: none; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem; font-weight: bold; display: flex; align-items: center; gap: 8px; transition: background 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn-cadastro-usuario:hover { background-color: #c0c0c0; color: #000; }
        .btn-cadastro-usuario i { font-size: 1.2rem; }
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
                        <a href="../entradaSaida/"><i class="bi bi-arrow-left-right"></i> Entrada e Saída</a>
                    </li>
                </ul>
            </nav>

            <section class="content-area">
                <div class="form-container">
                    <form method="post" class="pergunta">
                        <h2 style="color: white; margin-bottom: 20px;">Cadastro de Fornecedor</h2>
                        
                        <div class="mb-3">
                            <label class="form-label" style="color: white;">Nome do Fornecedor:</label>
                            <input type="text" name="nome" required class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" style="color: white;">Destino:</label>
                            <input type="text" name="destino" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" style="color: white;">CNPJ:</label>
                            <input type="text" name="cnpj" required class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" style="color: white;">Local da Empresa:</label>
                            <input type="text" name="local" class="form-control">
                        </div>

                        <input type="submit" value="Cadastrar Fornecedor" class="btn btn-success w-100">
                    </form>
                </div>
            </section>
        </main>
    </div>

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
