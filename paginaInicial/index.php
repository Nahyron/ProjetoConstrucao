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
    <link rel="stylesheet" href="css/style.css">
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
                    <a href="index.php">
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
                    <span class="user-greeting" id="userGreeting">Olá, 
                        <?php 
                            // Verifica se a chave existe na sessão para evitar o Warning
                            echo isset($_SESSION["nome_usuario"]) ? $_SESSION["nome_usuario"] : 'Visitante';
                        ?>
                    </span>
                    <i class="bi bi-door-open-fill" id="logoutBtn" style="cursor: pointer;" title="Sair"></i>
                    <a href="../Tabelas/tabela.php" style="text-decoration: none; color: inherit; margin-left: 10px; display: flex; align-items: center; gap: 5px;">
                        <i class="bi bi-table"></i> Ir para Área de Tabelas
                    </a>
                </div>
            </div>
        </header>

        <main class="main-content">
            <nav class="sidebar">
                <ul>
                    <li class="menu-item">
                        <a href="./index.php"><i class="bi bi-house-door"></i> Início</a>
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
                <h1>Bem-vindo ao Sistema Constru Casa</h1>
                <p>Selecione uma opção no menu lateral para começar.</p>

                <div style="display: flex; gap: 20px; margin-top: 30px;">
                    <div class="card text-bg-dark mb-3" style="max-width: 18rem;">
                        <div class="card-header">Produtos</div>
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Produtos</h5>
                            <p class="card-text">Cadastre novos produtos no sistema.</p>
                            <a href="../cadastroProduto/" class="btn btn-light">Acessar</a>
                        </div>
                    </div>
                    <div class="card text-bg-dark mb-3" style="max-width: 18rem;">
                        <div class="card-header">Fornecedores</div>
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Fornecedores</h5>
                            <p class="card-text">Cadastre fornecedores.</p>
                            <a href="../cadastroFornecedor/" class="btn btn-light">Acessar</a>
                        </div>
                    </div>
                    <div class="card text-bg-dark mb-3" style="max-width: 18rem;">
                        <div class="card-header">Movimentação</div>
                        <div class="card-body">
                            <h5 class="card-title">Entrada e Saída</h5>
                            <p class="card-text">Registre entradas e saídas de estoque.</p>
                            <a href="../entradaSaida/" class="btn btn-light">Acessar</a>
                        </div>
                    </div>

                    <div class="card text-bg-dark mb-3" style="max-width: 18rem;">
                        <div class="card-header">Estoque</div>
                        <div class="card-body">
                            <h5 class="card-title">Alerta de Estoque</h5>
                            <p class="card-text">Visualize produtos com estoque baixo.</p>
                            <a href="../alertaEstoque/" class="btn btn-light">Acessar</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        // 1. Seleciona os elementos do HTML
        const logoutBtn = document.getElementById('logoutBtn');

        // 4. Configura o botão de "Sair/Voltar"
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function() {
                window.location.href = '../pagina_login/index.php';
            });
        }
    </script>
</body>

</html>