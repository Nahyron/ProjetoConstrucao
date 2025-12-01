<?php
session_start();
require_once("../conexao/conexao.php");

// --- LÓGICA PHP ---

// 1. Processar ENTRADA
if (isset($_POST['btn_entrada_submit'])) {
    $quantidade = $_POST['quantidade_entrada'];
    $data_informada = $_POST['data_entrada'];

    // Decide qual ID usar (Nota Fiscal é priorizada se preenchida)
    if (!empty($_POST['nota_fiscal'])) {
        $fk_material = $_POST['nota_fiscal'];
    } else {
        $fk_material = $_POST['nome_produto'];
    }

    if (empty($fk_material) || empty($quantidade) || empty($data_informada)) {
        echo "<script>alert('Preencha todos os campos da Entrada!'); window.location.href='index.php';</script>";
    } else {
        // Busca dados para histórico
        $sql_busca = "SELECT nome_produto, nota_fiscal FROM cadastro_produto WHERE idcadastro_produto = '$fk_material'";
        $res_busca = mysqli_query($conn, $sql_busca);
        $row_busca = mysqli_fetch_assoc($res_busca);

        $nome_produto_texto = $row_busca['nome_produto'];
        $nota_fiscal_texto = $row_busca['nota_fiscal'];

        // Insere na tabela entrada_produto
        $query = "INSERT INTO entrada_produto (fk_material, nome_produto, nota_fiscal, data_saida, quantidade) 
                  VALUES ('$fk_material', '$nome_produto_texto', '$nota_fiscal_texto', '$data_informada', '$quantidade')";

        if (mysqli_query($conn, $query)) {
            // Atualiza Estoque (+ soma)
            mysqli_query($conn, "UPDATE cadastro_produto SET quantidade = quantidade + $quantidade WHERE idcadastro_produto = '$fk_material'");
            echo "<script>alert('Entrada registrada com sucesso!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Erro na entrada: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// 2. Processar SAÍDA
if (isset($_POST['btn_saida_submit'])) {
    $quantidade = $_POST['quantidade_saida'];
    $data_informada = $_POST['data_saida_form'];
    // O campo 'fornecedor_saida' está aqui, mas a lógica do banco de dados não o utiliza

    // Decide qual ID usar
    if (!empty($_POST['nota_fiscal_saida'])) {
        $fk_material = $_POST['nota_fiscal_saida'];
    } else {
        $fk_material = $_POST['nome_produto'];
    }

    if (empty($fk_material) || empty($quantidade) || empty($data_informada)) {
        echo "<script>alert('Preencha todos os campos da Saída!'); window.location.href='index.php';</script>";
    } else {
        // 🚨 Verifica se há estoque suficiente
        $res_estoque = mysqli_query($conn, "SELECT quantidade FROM cadastro_produto WHERE idcadastro_produto = '$fk_material'");
        $estoque_atual = mysqli_fetch_assoc($res_estoque)['quantidade'];

        if ($estoque_atual < $quantidade) {
            echo "<script>alert('ERRO: Estoque insuficiente para realizar esta saída! Estoque atual: $estoque_atual'); window.location.href='index.php';</script>";
        } else {
            // Busca dados para histórico
            $sql_busca = "SELECT nome_produto, nota_fiscal FROM cadastro_produto WHERE idcadastro_produto = '$fk_material'";
            $res_busca = mysqli_query($conn, $sql_busca);
            $row_busca = mysqli_fetch_assoc($res_busca);

            $nome_produto_texto = $row_busca['nome_produto'];
            $nota_fiscal_texto = $row_busca['nota_fiscal'];

            // Insere na tabela saida_produto
            $query = "INSERT INTO saida_produto (fk_material, nome_produto, nota_fiscal, data_saida, quantidade) 
                      VALUES ('$fk_material', '$nome_produto_texto', '$nota_fiscal_texto', '$data_informada', '$quantidade')";

            if (mysqli_query($conn, $query)) {
                // Atualiza Estoque (- subtrai)
                mysqli_query($conn, "UPDATE cadastro_produto SET quantidade = quantidade - $quantidade WHERE idcadastro_produto = '$fk_material'");
                echo "<script>alert('Saída registrada com sucesso!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Erro na saída: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
}

// 3. Processar AJUSTE DE ESTOQUE (Sobrescrever/Setar o valor)
if (isset($_POST['btn_ajuste_submit'])) {
    $fk_material = $_POST['produto_ajuste'];
    $novo_estoque = $_POST['novo_estoque'];

    if (empty($fk_material) || $novo_estoque === "") {
        echo "<script>alert('Selecione um produto e informe o novo estoque!');</script>";
    } else {
        // Atualiza Estoque (Substitui o valor atual)
        $query = "UPDATE cadastro_produto SET quantidade = '$novo_estoque' WHERE idcadastro_produto = '$fk_material'";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Ajuste de estoque realizado com sucesso! Novo estoque: $novo_estoque'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Erro no ajuste: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Reusa a consulta de produtos para os selects
$query_produtos = "SELECT idcadastro_produto, nome_produto, nota_fiscal FROM cadastro_produto ORDER BY nome_produto";
$result_produtos_entrada_nome = mysqli_query($conn, $query_produtos);
$result_produtos_entrada_nota = mysqli_query($conn, $query_produtos);
$result_produtos_saida_nome = mysqli_query($conn, $query_produtos);
$result_produtos_saida_nota = mysqli_query($conn, $query_produtos);
$result_produtos_ajuste = mysqli_query($conn, $query_produtos);

// NOVO: Busca fornecedores para o select de Saída
$sql_fornecedores = "SELECT idfornecedor, nome_fornecedor FROM fornecedor ORDER BY nome_fornecedor";
$result_fornecedores_saida = mysqli_query($conn, $sql_fornecedores);
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
        .forms-container {
            display: flex;
            gap: 30px;
            justify-content: space-between;
            /* Melhor distribuição */
            margin-top: 30px;
            flex-wrap: wrap;
            /* Envelopa se a tela for pequena */
        }

        .form-box {
            background-color: #3f3f3f;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 30%;
            /* Ajustado para 3 colunas */
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
        .form-box input[type="number"],
        .form-box input[type="date"],
        .form-box select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #555;
            border-radius: 4px;
            background-color: #4a4a4a;
            color: white;
        }

        .form-box select option {
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
            background-color: #4CAF50;
            color: white;
        }

        #btn-entrada:hover {
            background-color: #45a049;
        }

        #btn-saida {
            background-color: #f44336;
            color: white;
        }

        #btn-saida:hover {
            background-color: #da190b;
        }

        /* NOVO: Estilo para o botão de Ajuste */
        #btn-ajuste {
            background-color: #ff9800;
            /* Laranja */
            color: white;
        }

        #btn-ajuste:hover {
            background-color: #e68900;
        }

        /* FIM NOVO ESTILO */

        .user-area {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-end;
            gap: 15px;
        }

        .user-top-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
        }

        .btn-cadastro-usuario {
            background-color: #e0e0e0;
            color: #333;
            text-decoration: none;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-cadastro-usuario:hover {
            background-color: #c0c0c0;
            color: #000;
        }

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
                    <span class="user-greeting" id="userGreeting">Olá, Usuário</span>
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
                <h1 style="color: white; margin-bottom: 20px;">Registro de Movimentação de Estoque</h1>

                <div class="forms-container">

                    <div class="form-box">
                        <h3>Entrada de Produto</h3>
                        <form method="POST" action="">

                            <div class="d-flex gap-2">
                                <div style="flex: 1;">
                                    <label>Selecione o Produto</label>
                                    <select name="nome_produto" class="form-control">
                                        <option value="">-- Produto --</option>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result_produtos_entrada_nome)) {
                                            echo "<option value='" . $row['idcadastro_produto'] . "'>" . $row['nome_produto'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <label>Nota Fiscal</label>
                                    <select name="nota_fiscal" class="form-control">
                                        <option value="">-- Selecione --</option>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result_produtos_entrada_nota)) {
                                            echo "<option value='" . $row['idcadastro_produto'] . "'>" . $row['nome_produto'] . " - " . $row['nota_fiscal'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <label>Quantidade</label>
                            <input type="number" name="quantidade_entrada" required min="1" placeholder="Ex: 10">

                            <label>Data da Entrada</label>
                            <input type="date" name="data_entrada" required>

                            <button type="submit" name="btn_entrada_submit" id="btn-entrada">Registrar Entrada</button>
                        </form>
                    </div>

                    <div class="form-box">
                        <h3>Saída de Produto</h3>
                        <form method="POST" action="">

                            <div class="d-flex gap-2">
                                <div style="flex: 1;">
                                    <label>Selecione o Produto</label>
                                    <select name="nome_produto" class="form-control">
                                        <option value="">-- Produto --</option>
                                        <?php
                                        // Reposiciona o ponteiro para o início
                                        mysqli_data_seek($result_produtos_saida_nome, 0);
                                        while ($row = mysqli_fetch_assoc($result_produtos_saida_nome)) {
                                            echo "<option value='" . $row['idcadastro_produto'] . "'>" . $row['nome_produto'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <label>Nota Fiscal</label>
                                    <select name="nota_fiscal_saida" class="form-control">
                                        <option value="">-- Selecione --</option>
                                        <?php
                                        // Reposiciona o ponteiro para o início
                                        mysqli_data_seek($result_produtos_saida_nota, 0);
                                        while ($row = mysqli_fetch_assoc($result_produtos_saida_nota)) {
                                            echo "<option value='" . $row['idcadastro_produto'] . "'>" . $row['nome_produto'] . " - " . $row['nota_fiscal'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <label>Fornecedor</label>
                            <select name="fornecedor_saida" class="form-control">
                                <option value="">-- Selecione o Fornecedor --</option>
                                <?php
                                if ($result_fornecedores_saida) {
                                    while ($f = mysqli_fetch_assoc($result_fornecedores_saida)) {
                                        echo "<option value='" . $f['idfornecedor'] . "'>" . $f['nome_fornecedor'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <label>Quantidade</label>
                            <input type="number" name="quantidade_saida" required min="1" placeholder="Ex: 5">

                            <label>Data da Saída</label>
                            <input type="date" name="data_saida_form" required>

                            <button type="submit" name="btn_saida_submit" id="btn-saida">Registrar Saída</button>
                        </form>
                    </div>

                    <div class="form-box">
                        <h3>Ajuste de Estoque</h3>
                        <form method="POST" action="">
                            <label>Selecione o Produto</label>
                            <select name="produto_ajuste" required class="form-control">
                                <option value="">-- Produto --</option>
                                <?php
                                // Reposiciona o ponteiro para o início
                                mysqli_data_seek($result_produtos_ajuste, 0);
                                while ($row_ajuste = mysqli_fetch_assoc($result_produtos_ajuste)) {
                                    echo "<option value='" . $row_ajuste['idcadastro_produto'] . "'>" . $row_ajuste['nome_produto'] . "</option>";
                                }
                                ?>
                            </select>

                            <label>Novo Estoque Total</label>
                            <input type="number" name="novo_estoque" required min="0" placeholder="Ex: 50 (Valor que o estoque DEVE ter)">

                            <p style="color: #ff9800; font-size: 0.9em; margin-top: -10px; margin-bottom: 20px;">
                                **Atenção:** Isso irá **SUBSTITUIR** o estoque atual pelo valor digitado. Use para inventário ou correções.
                            </p>

                            <button type="submit" name="btn_ajuste_submit" id="btn-ajuste">Ajustar Estoque</button>
                        </form>
                    </div>
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