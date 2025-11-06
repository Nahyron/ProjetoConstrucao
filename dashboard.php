<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constru Casa - Sistema de Gestão de Estoque</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
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
            display: flex;
            flex-direction: column;
            background-color: #2e2e2e; /* Cor de fundo principal escura */
        }
        
        /* =================================================== */
        /* === TELA DE GESTÃO (DASHBOARD) === */
        /* =================================================== */
        
        /* CABEÇALHO */
        .header {
            background-color: #d8c8c8; 
            padding: 15px 20px;
            height: 80px; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .dashboard-logo { /* Logo menor do dashboard */
            background-color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden; 
        }
        .dashboard-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; 
            border-radius: 50%; 
            background-color: white; 
            padding: 3px; 
        }

        .company-name {
            font-size: 18px;
            color: #333; 
        }
        .user-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-greeting {
            font-size: 16px;
            color: #333;
            font-weight: bold;
        }
        .logout-icon {
            font-size: 20px;
            cursor: pointer;
            color: #333;
        }

        /* CONTEÚDO PRINCIPAL E SIDEBAR */
        .main-content {
            display: flex;
            flex: 1; 
        }
        .sidebar {
            width: 250px; 
            background-color: #555; 
            padding-top: 20px;
            min-height: calc(100vh - 80px); 
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .menu-item {
            margin-bottom: 2px;
        }
        .menu-item a {
            display: block;
            padding: 12px 15px;
            color: #fff;
            font-size: 15px;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .menu-item a:hover {
            background-color: #6a6a6a; 
        }
        /* Estilos do menu conforme imagem */
        .sidebar ul li:nth-child(1) { background-color: #999999; }
        .sidebar ul li:nth-child(2),
        .sidebar ul li:nth-child(3) { background-color: #a8a8a8; }
        
        .menu-icon {
            width: 30px; 
            text-align: center;
            margin-right: 10px;
            font-size: 16px;
            color: #333; 
        }

        .content-area {
            flex: 1; 
            padding: 20px;
            background-color: #333; 
            color: white; /* Cor do texto no dashboard */
        }
    </style>
</head>
<body>
    
    <div id="dashboard-screen" class="container" style="display: flex; flex-direction: column; flex: 1;">
        <header class="header">
            <div class="logo-area">
                <div class="dashboard-logo">
                    <img src="imagens/logo_casa.png" alt="Logo Constru Casa">
                </div>
                <span class="company-name">Constru Casa</span>
            </div>
            <div class="user-area">
                <span class="user-greeting" id="userGreeting">olá usuário</span>
                <i class="fas fa-bookmark logout-icon" id="logoutBtn"></i> 
            </div>
        </header>

        <main class="main-content">
            <nav class="sidebar">
                <ul>
                    <li class="menu-item">
                        <a href="cadastro_produtos.php"><i class="fas fa-home menu-icon"></i> cadastro de produtos</a>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i class="fas fa-box menu-icon"></i> entrada e saída dos produtos</a>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i class="fas fa-truck-ramp-box menu-icon"></i> gestão de estoque</a>
                    </li>
                </ul>
            </nav>

            <section class="content-area">
                <h1>Bem-vindo ao Sistema de Gestão da Constru Casa!</h1>
                <p>Use o menu lateral para navegar pelas funcionalidades do sistema.</p>
            </section>
        </main>
    </div>

    <script>
        const logoutBtn = document.getElementById('logoutBtn');
        const userGreetingElement = document.getElementById('userGreeting');

        // FUNÇÃO PARA CARREGAR O NOME DO USUÁRIO
        function loadUserName() {
            const userName = localStorage.getItem('userName');
            if (userName) {
                userGreetingElement.textContent = `olá ${userName}`;
            } else {
                // Se não houver nome de usuário, redireciona para o login (segurança básica)
                window.location.href = 'login.html';
            }
        }
        
        loadUserName(); 

        // 2. Função de Logout
        logoutBtn.addEventListener('click', function() {
            // Remove o nome do usuário armazenado
            localStorage.removeItem('userName');
            
            // Redireciona para a página de login
            window.location.href = 'login.html';
        });
    </script>
</body>
</html>