<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constru Casa - Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <div id="dashboard-screen" class="container" style="display: flex; flex-direction: column; flex: 1;">
        <header class="header">
            <div class="logo-area">
                <div class="dashboard-logo">
                    <img src="../imagens/logo_casa.png" alt="Logo Constru Casa">
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
                        <a href="http://localhost/aula_PHP/ProjetoConstrucao/cadastroProduto/"><i class="fas fa-home menu-icon"></i> Cadastro de produtos</a>
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

        function loadUserName() {
            const userName = localStorage.getItem('userName');
            if (userName) {
                userGreetingElement.textContent = `olá ${userName}`;
            } else {
                // ✅ CAMINHO DE REDIRECIONAMENTO CORRIGIDO: sobe um nível e acessa pagina_login
                window.location.href = '../pagina_login/index.php';
            }
        }
        
        loadUserName(); 

        // Função de Logout
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('userName');
            // ✅ CAMINHO DE REDIRECIONAMENTO CORRIGIDO
            window.location.href = '../pagina_login/index.php';
        });
    </script>
</body>
</html>