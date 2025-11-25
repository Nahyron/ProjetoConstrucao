<?php
/* -------------------------------------------------------------------------- */
/* PARTE 1: BACKEND (PHP)                           */
/* -------------------------------------------------------------------------- */

// Verifica se o método é POST (ou seja, se o JavaScript enviou dados)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // 1. Configurações do Banco de Dados
    $host = 'localhost';
    $db   = 'nome_do_seu_banco'; // <--- ATENÇÃO: COLOQUE O NOME DO SEU BANCO
    $user = 'root';              // <--- SEU USUÁRIO
    $pass = '';                  // <--- SUA SENHA

    try {
        // Conexão
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 2. Recebe os dados do JSON enviado pelo JS
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? '';
        $senha = $data['password'] ?? '';

        // 3. Consulta segura no Banco
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // 4. Verifica a senha
        // Nota: Se usar senhas criptografadas no futuro, use password_verify($senha, $usuario['senha'])
        if ($usuario && $usuario['senha'] === $senha) {
            echo json_encode(['success' => true, 'nome' => $usuario['nome']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Email ou senha incorretos!']);
        }

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()]);
    }

    // O 'exit' é crucial aqui para não carregar o HTML abaixo quando for uma requisição de login
    exit;
}
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
                <form id="loginForm">
                    <input type="text" id="username" placeholder="Nome (Opcional):">
                    
                    <input type="email" id="email" placeholder="Email:" required>
                    <input type="password" id="password" placeholder="Senha:" required>
                    
                    <button type="submit" class="submit-btn">Concluído</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', (e) => {
            e.preventDefault(); 
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const submitBtn = document.querySelector('.submit-btn');

            // Feedback visual (desabilita botão enquanto carrega)
            submitBtn.disabled = true;
            submitBtn.textContent = 'Verificando...';

            fetch('login.php', { // Envia para este mesmo arquivo
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: email, password: password })
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Concluído';

                if (data.success) {
                    // Login com sucesso!
                    
                    // Salva o nome que veio DO BANCO no navegador
                    localStorage.setItem('userName', data.nome);
                    
                    // Redireciona
                    window.location.href = '../paginainicial/index.php'; 
                } else {
                    // Erro (Senha errada ou usuário não encontrado)
                    alert(data.message); 
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                submitBtn.disabled = false;
                submitBtn.textContent = 'Concluído';
                alert('Erro de conexão.');
            });
        });
    </script>
</body>
</html>