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
                <img src="../imagens/logo_casa.png" alt="Logo Constru Casa">
            </div>
            <div class="login-box">
                <form id="loginForm">
                    <input type="text" id="username" placeholder="Nome:" required>
                    <input type="email" id="email" placeholder="Email:" required>
                    <input type="password" id="password" placeholder="Senha:" required>
                    <button type="submit" class="submit-btn">Concluído</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');

        loginForm.addEventListener('submit', function(event) {
            event.preventDefault(); 
            
            const usernameInput = document.getElementById('username');
            const password = document.getElementById('password').value;
            const userName = usernameInput.value; 

            if (password === '123' && userName.length > 0) {
                
                localStorage.setItem('userName', userName);
                // ✅ CAMINHO DE REDIRECIONAMENTO CORRIGIDO: sobe um nível e acessa paginainicial
                window.location.href = '../paginainicial/index.php'; 
            } else {
                alert('Credenciais inválidas. Certifique-se de preencher o nome e usar a senha "123".');
            }
        });
    </script>
</body>
</html>