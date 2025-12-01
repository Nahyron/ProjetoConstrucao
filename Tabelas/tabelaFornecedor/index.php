<?php
session_start();
require_once("../../conexao/conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constru Casa - Tabela de Fornecedores</title>

    <link rel="stylesheet" href="../tabelaCadastro/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Estilos específicos para a área de Gestão de Estoque (Replicado) */
        .search-area {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            align-items: center;
        }

        .search-area input {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #555;
            background-color: #4a4a4a;
            color: white;
            width: 300px;
        }

        .search-area button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            background-color: #d8c8c8;
            color: #333;
            font-weight: bold;
            cursor: pointer;
        }

        /* Tabela de Estoque */
        .stock-table th,
        .stock-table td {
            text-align: left;
            vertical-align: middle;
        }

        .stock-table th {
            background-color: #555;
            color: #d8c8c8;
        }

        .stock-table td {
            background-color: #3f3f3f;
            color: white;
        }

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
                    <a href="../../paginaInicial/index.php">
                        <img src="../../imagens/logo_casa.png" alt="Logo Constru Casa">
                    </a>
                </div>
                <span class="company-name">Constru Casa</span>
            </div>

            <div class="user-area">
                <a href="../../pagina_cadastro/" class="btn-cadastro-usuario">
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
                        <a href="../../paginaInicial/index.php"><i class="bi bi-house-door"></i> Voltar ao Início</a>
                    </li>
                    <li class="menu-item">
                        <a href="../../Tabelas/tabelaCadastro/"><i class="bi bi-tools"></i> Tabela de Cadastro</a>
                    </li>
                    <li class="menu-item">
                        <a href="../../Tabelas/tabelaFornecedor/"><i class="bi bi-truck"></i> Tabela de Fornecedores</a>
                    </li>

                    <li class="menu-item">
                        <a href="../../Tabelas/tabelaEntrada/"><i class="bi bi-boxes"></i> Tabela de Entrada</a>
                    </li>
                    <li class="menu-item">
                        <a href="../../Tabelas/tabelaSaidas/"><i class="bi bi-boxes"></i> Tabela de Saida</a>
                    </li>
                    <li class="menu-item">
                        <a href="../../gestaoEstoque/"><i class="bi bi-cart-plus"></i> Gestão de estoque</a>
                    </li>
                </ul>
            </nav>

            <section class="content-area">
                <h1 style="color: white; margin-bottom: 20px;">Relatório de Fornecedores</h1>

                <div class="search-area">
                    <input type="text" placeholder="Pesquisar fornecedor...">
                    <button><i class="bi bi-search"></i> Pesquisar</button>
                </div>

                <table class="table table-hover stock-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Destino</th>
                            <th>CNPJ</th>
                            <th>Local</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM fornecedor";
                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['idfornecedor'] . "</td>";
                                echo "<td>" . $row['nome_fornecedor'] . "</td>";
                                echo "<td>" . $row['destino'] . "</td>";
                                echo "<td>" . $row['cnpj_empresa'] . "</td>";
                                echo "<td>" . $row['local_empresa'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center text-muted'>Nenhum fornecedor encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

            </section>
        </main>
    </div>

    <script>
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function() {
                window.location.href = '../../pagina_login/index.php';
            });
        }
    </script>
</body>

</html>