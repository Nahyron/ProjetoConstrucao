<?php
    session_start();
    require_once("../conexao/conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constru Casa - Dashboard</title>
    <link rel="stylesheet" href="_css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <div> <header class="header">
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
                        <a href="./tabelaCadastro/index.php"><i class="bi bi-tools"></i> Tabela de Cadastro</a>
                    </li>
                    <li class="menu-item">
                        <a href="./tabelaFornecedor/"><i class="bi bi-truck"></i> Tabela de Fornecedores</a>
                    </li>
                    <li class="menu-item">
                        <a href="./tabelaEntradaSaida/"><i class="bi bi-boxes"></i> Tabela de Entrada e Saida</a>
                    </li>
                    <li class="menu-item">
                        <a href="../gestaoEstoque/"><i class="bi bi-cart-plus"></i> Gestão de estoque</a>
                    </li>
                </ul>
            </nav>

            <section class="content-area">
                <h1>Bem-vindo à gestão de Tabelas!</h1>
                <p>Use o menu lateral para navegar pelas funcionalidades do sistema.</p>
                
                <div style="margin-top: 20px;">
                    <a href="../paginaInicial/index.php" class="btn btn-light btn-lg" style="background-color: white; border: 1px solid #ccc; color: #333;">
                        <i class="bi bi-house-door"></i> Voltar para o Sistema
                    </a>
                </div>
            </section>
        </main>
    </div>

    <script>
        const logoutBtn = document.getElementById('logoutBtn');

        // === Botão de saída (logout) ===
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function() {
                window.location.href = '../paginainicial/index.php';
            });
        }
    </script>
</body>
</html>