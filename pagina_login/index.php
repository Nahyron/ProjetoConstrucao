<?php
session_start();
require_once('../conexao/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constru Casa - Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div id="login-screen">
        <div class="login-container">

            <div class="login-logo">
                <img src="../imagens/logo_casa.png" alt="Logo Constru Casa" onerror="this.style.display='none'">
            </div>

            <div class="login-box">
                <form id="loginForm" method="POST" action="">

                    <input type="text" name="nome_usuario" placeholder="Nome:" required>

                    <input type="email" name="email" id="email" placeholder="Email:" required>

                    <input type="password" name="senha" id="password" placeholder="Senha:" required>

                    <button type="submit" class="submit-btn">Concluído</button>

                    <button type="button" class="register-btn" onclick="window.location.href='../pagina_cadastro/index.php'">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php
// ⚠️ CÓDIGO DE LOGIN COM password_verify()

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta (ainda vulnerável a SQL Injection, conforme solicitado)
    $sql = "SELECT * FROM usuarios WHERE usuario = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        $dados_usuario = mysqli_fetch_assoc($result);

        if ($dados_usuario) {

            // ✔ Verifica senha com HASH
            if (password_verify($senha, $dados_usuario['senha'])) {

                $_SESSION['id_usuario'] = $dados_usuario['id'];
                $_SESSION['nome_usuario'] = $dados_usuario['nome_usuario'];

                echo "<script>
                        alert('Bem-vindo, " . $dados_usuario['nome_usuario'] . "!');
                        window.location.href = '../paginaInicial/index.php';
                      </script>";
                exit;
            } else {
                echo "<script>alert('❌ Email ou senha incorretos!');</script>";
            }
        } else {
            echo "<script>alert('❌ Usuário não encontrado!');</script>";
        }
    } else {
        echo "<script>alert('Erro no sistema: " . mysqli_error($conn) . "');</script>";
    }
}
?>

