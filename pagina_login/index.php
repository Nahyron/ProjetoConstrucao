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
                    
                    <input type="text" name="nome_dummy" placeholder="Nome: (Não usado)" required>

                    <input type="email" name="email" id="email" placeholder="Email/Usuário:" required>
                    
                    <input type="password" name="senha" id="password" placeholder="Senha:" required>
                    
                    <button type="submit" class="submit-btn">Concluído</button>
                    
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php 
// O bloco PHP do Login continua aqui, fora do HTML
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // 1. Receber dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // 2. Buscar o usuário pelo EMAIL
    // AVISO: VULNERÁVEL A SQL INJECTION
    $sql = "SELECT * FROM usuarios WHERE usuario = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Pega o resultado
        $dados_usuario = mysqli_fetch_assoc($result);

        // 3. VERIFICAÇÃO DE SENHA (TEXTO PURO)
        if ($dados_usuario && $senha == $dados_usuario['senha']) {
            
            // ===================================
            // 🚨 CORREÇÃO: VERIFICANDO CHAVES DE SESSÃO 🚨
            // ===================================
            // Use 'idusuarios' ou 'id_usuario' de acordo com sua coluna de ID.
            // Eu padronizei para 'id_usuario' e 'nome_usuario'.
            $_SESSION['id_usuario'] = $dados_usuario['idusuarios'] ?? $dados_usuario['id']; // Use a chave correta da sua tabela!
            $_SESSION['nome_usuario'] = $dados_usuario['nome_usuario'];

            // Redirecionar via JS
            echo "<script>
                    alert('Bem-vindo, " . $dados_usuario['nome_usuario'] . "!');
                    window.location.href = '../paginaInicial/index.php';
                  </script>";
            exit;

        } else {
            // Login Falhou
            echo "<script>alert('❌ Email ou senha incorretos!');</script>";
        }
    } else {
        echo "<script>alert('Erro no sistema: " . mysqli_error($conn) . "');</script>";
    }
}
?>