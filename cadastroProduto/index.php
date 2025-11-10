<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
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
               <i class="bi bi-door-open-fill" id="logoutBtn"></i> 
            </div>
        </header>

        <main class="main-content">
            <nav class="sidebar">
                <ul>
                  
                    <li class="menu-item">
                        <a href="../paginainicial/index.php"><i class=" bi bi-house-door"></i> Pagina Inicial</a>
                    </li>
                    <li class="menu-item">
                        <a href="http://localhost/aula_PHP/ProjetoConstrucao/entradaSaida/"><i class="bi bi-boxes"></i> entrada e saída dos produtos</a>
                    </li>
                    <li class="menu-item">
                        <a href="http://localhost/aula_PHP/ProjetoConstrucao/gestaoEstoque/"><i class="bi bi-cart-plus"></i> gestão de estoque</a>
                    </li>
                </ul>
            </nav>

            <section class="content-area">
                
                <h2>Cadastro de Produtos</h2>
                <div id="tabela">
                    <form method="post" class="pergunta" enctype="multipart/form-data"><br><br>
                        <h5>Qual o produto:</h5>
                        <input type="text" name="produto" required placeholder="Qual produto deseja cadastrar:" id="produto-input"><br><br> 
                        <h5>Cor:</h5>
                        <input type="text" name="cor" required placeholder="Variação de cor:" id="cor-input"><br><br>
                        <h5>Textura:</h5>
                        <input type="text" name="textura" required placeholder="Textura:" id="textura-input"><br><br>
                        <h5>Peso ou Litros:</h5>
                        <input type="text" name="pesoLitro" required placeholder="Peso ou Litros:" id="peso-litro-input"><br><br>

                        <h5>aperte para finalizar o cadastros:</h5>
                        <input type="submit" name="cadastrar conta" value="Gerar conta" id="enviar"><br><br>
                    </form>
                </div>
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
                // Caminho corrigido para a página de login
                window.location.href = '../pagina_login/index.php';
            }
        }
        
        loadUserName(); 

        // Função de Logout 
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('userName');
            // Redirecionamento correto
            window.location.href = '../pagina_login/index.php';
        });
    </script>
    </body>
</html>