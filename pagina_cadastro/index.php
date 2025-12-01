<?php
    session_start();
    require_once('../conexao/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constru Casa - Cadastro</title>
    
    <link rel="stylesheet" href="css/style.css">

    <style>
        #mensagem-feedback {
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
            display: none; /* Começa invisível */
            padding: 10px;
            border-radius: 5px;
        }
        .sucesso {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    
    <div id="cadastro-screen">
        <div class="login-container"> 
            
            <span class="botao-fechar" onclick="history.back()">&times;</span> 
            
            <div class="login-logo">
                <img src="../imagens/logo_casa.png" alt="Logo" onerror="this.style.display='none'">
            </div>
            
            <div class="login-box">
                    <form id="cadastroForm" action="" method="POST"> 
                    
                    <input type="text" placeholder="Nome Completo:" name="nome_completo" required>
                    <input type="email" placeholder="Email/Usuário:" name="usuario" required>

                    <input type="password" placeholder="Crie uma Senha:" name="senha" required>
                    <input type="password" name="confirmar_senha" placeholder="Confirme a Senha:" required>
                    
                    <button type="submit" class="submit-btn">Finalizar Cadastro</button>
                    
                    <div id="mensagem-feedback"></div>
    
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 1. RECEBIMENTO DOS DADOS
    $nome_usuario = $_POST['nome_completo']; 
    $usuario = $_POST['usuario'];             
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // **AVISO DE SEGURANÇA:** O campo 'senha' no banco DEVE ser salvo como HASH (ex: password_hash).
    // O código abaixo usa texto puro apenas para manter a consistência com seu código de Login.

    // 2. LÓGICA DE VERIFICAÇÃO DE SENHA
    if ($senha !== $confirmar_senha) {
        echo "<script>alert('As senhas não coincidem. Por favor, tente novamente.');</script>";
        exit;
    }

    // AVISO: VULNERÁVEL A SQL INJECTION
    $sql = "INSERT INTO usuarios (nome_usuario, usuario, senha) 
             VALUES ('$nome_usuario', '$usuario', '$senha')"; 

    // Supondo que a sua variável de conexão se chama $conn
    if (mysqli_query($conn, $sql)) {
        
        // ===================================
        // 🚨 CORREÇÃO: AUTO-LOGIN AQUI 🚨
        // ===================================
        // 1. Salva o nome do usuário na sessão, exatamente como o login faz
        // A função mysqli_insert_id pega o ID do registro que acabou de ser inserido
        $_SESSION['id_usuario'] = mysqli_insert_id($conn); 
        $_SESSION['nome_usuario'] = $nome_usuario; 

        echo "<script>
                  alert('✅ Usuário cadastrado com sucesso!');
                  // Redireciona para o Dashboard (que agora encontra a sessão)
                  window.location.href = '../paginaInicial/index.php';
              </script>";
        exit; 
    } else {
        echo "<script>alert('❌ Falha ao cadastrar: " . mysqli_error($conn) . "');</script>";
    }
}
?>