<?php
session_start();
require_once("../conexao/conexao.php"); // Inclui a conexão

// 1. Consulta SQL para buscar produtos críticos
$sql_critico = "
    SELECT
        nome_produto,
        quantidade, /* Seu campo de estoque atual */
        estoque_minimo
    FROM
        cadastro_produto 
    WHERE
        quantidade <= estoque_minimo
    ORDER BY
        quantidade ASC
";

$resultado_critico = mysqli_query($conn, $sql_critico);
$contagem_critica = mysqli_num_rows($resultado_critico);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alerta de Estoque Mínimo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .table-alerta .bg-danger-light {
            background-color: #f8d7da;
            /* Cor de fundo suave para linhas críticas */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1><i class="bi bi-exclamation-triangle-fill text-danger"></i> Alerta de Estoque Mínimo</h1>
        <p class="lead">Produtos que atingiram ou caíram abaixo do limite de estoque mínimo definido.</p>

        <?php if ($contagem_critica > 0): ?>
            <div class="alert alert-danger" role="alert">
                Atenção! Existem **<?php echo $contagem_critica; ?>** produtos em nível crítico.
            </div>

            <table class="table table-striped table-hover table-bordered table-alerta">
                <thead class="table-dark">
                    <tr>
                        <th>Nome do Produto</th>
                        <th>Estoque Atual</th>
                        <th>Estoque Mínimo</th>
                        <th>Diferença (Faltam)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($linha = mysqli_fetch_assoc($resultado_critico)):
                        $diferenca = $linha['estoque_minimo'] - $linha['quantidade'];
                        $row_class = ($linha['quantidade'] <= $linha['estoque_minimo']) ? 'bg-danger-light' : '';
                    ?>
                        <tr class="<?php echo $row_class; ?>">
                            <td><?php echo htmlspecialchars($linha['nome_produto']); ?></td>
                            <td>
                                <strong><?php echo $linha['quantidade']; ?></strong>
                            </td>
                            <td><?php echo $linha['estoque_minimo']; ?></td>
                            <td><?php echo $diferenca; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        <?php else: ?>
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill"></i> Excelente! Nenhum produto está abaixo do estoque mínimo.
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="../paginaInicial/index.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar ao Dashboard
            </a>
        </div>
    </div>
</body>

</html>