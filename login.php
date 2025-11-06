<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constru Casa - Login</title>
    <style>
        /* =================================================== */
        /* === ESTILOS GLOBAIS / RESET === */
        /* =================================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            height: 100vh;
        }

        /* =================================================== */
        /* === TELA DE LOGIN === */
        /* =================================================== */
        #login-screen {
            background-color: #e6e6e6; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }
        
        .login-container {
            width: 450px; 
            background-color: white;
            border: 1px solid #c9c9c9;
            border-radius: 45px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px; 
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .login-logo {
            background-color: white; 
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin-bottom: 20px; 
            margin-top: -20px; 
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); 
            overflow: hidden; 
        }
        .login-logo img {
            max-width: 150%;
            max-height: 150%;
            object-fit: contain; 
            border-radius: 50%; 
            background-color: white; 
            padding: 1px; 
        }

        .login-box {
            width: 100%;
            padding: 0;
            border: none;
            background-color: transparent;
            box-shadow: none;
        }
        
        #loginForm {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 15px 10px;
            border: none;
            background-color: #ededed; 
            border-radius: 3px;
            font-size: 16px;
            color: #333;
        }
        .submit-btn {
            width: 50%; 
            margin: 20px auto 0;
            padding: 10px 20px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            background-color: #e0e0e0; 
            color: #666;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #cccccc;
        }
    </style>
</head>
<body>
        
    
    <div id="login-screen">
        <div class="login-container"> 
            <div class="login-logo">
                <img src="imagens/logo_casa.png" alt="Logo Constru Casa">
            </div>
            <div class="login-box">
                <form id="loginForm">
                    <input type="text" id="username" placeholder="Nome:" required>
                    <input type="email" id="email" placeholder="Email:" required>
                    <input type="password" id="password" placeholder="Senha:" required>
                 <button  type="submit" class="submit-btn">Concluido</button>
                        
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

            // Validação simples: senha é "123"
            if (password === '123' && userName.length > 0) {
                
                // *** MUDANÇA CRUCIAL AQUI: REDIRECIONAMENTO! ***
                // Armazena o nome do usuário no armazenamento local para uso na próxima página
                localStorage.setItem('userName', userName);

                // Redireciona para a página principal (dashboard)
                window.location.href = 'dashboard.php'; 
            } else {
                alert('Credenciais inválidas. Certifique-se de preencher o nome e usar a senha "123".');
            }
        });
    </script>
</body>
</html>