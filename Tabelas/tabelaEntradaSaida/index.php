<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constru Casa - Gestão de Estoque</title>
    
    <link rel="stylesheet" href="./css/style.css"> 
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    
</head> 
 
<body>
    
    <div id="dashboard-screen" class="container" style="display: flex; flex-direction: column; flex: 1;">
        <header class="header">
            <div class="logo-area">
                <div class="dashboard-logo">
                    <img src="../../imagens/logo_casa.png" alt="Logo Constru Casa">
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
                        <a href="../cadastroProduto/index.php"><i class="bi bi-person-fill"></i> Cadastro de Produtos</a>
                    </li>
                    <li class="menu-item">
                        <a href="../entradaSaida/index.php"><i class="bi bi-boxes"></i> entrada e saída dos produtos</a>
                    </li>
                   
                </ul>
            </nav>

            <section class="content-area">
                <h1 style="color: white; margin-bottom: 20px;">Relatório de Estoque Atual</h1>
                
                <div class="search-area">
                    <input type="text" placeholder="Pesquisar por Código, Produto ou Cor...">
                    <button><i class="bi bi-search"></i> Pesquisar</button>
                </div>
                
                <table class="table table-hover stock-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Cor / Textura</th>
                            <th>Peso/Litro</th>
                            <th>Estoque Atual</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Tinta Acrílica Premium</td>
                            <td>Branco Neve / Liso</td>
                            <td>18 Litros</td>
                            <td class="stock-status-cell">45</td>
                            <td><span class="badge bg-success">Em Estoque</span></td>
                            <td><button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i> Editar</button></td>
                        </tr>
                        <tr class="low-stock-row">
                            <td>2</td>
                            <td>Argamassa AC-III</td>
                            <td>Cinza / Granulada</td>
                            <td>20 Kg</td>
                            <td class="stock-status-cell low-stock">8</td>
                            <td><span class="badge bg-danger">Baixo Estoque</span></td>
                            <td><button class="btn btn-sm btn-info"><i class="bi bi-pencil"></i> Editar</button></td>
                        </tr>
                        
                        </tbody>
                </table>
                
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
                window.location.href = '../pagina_login/index.php';
            }
        }
        
        loadUserName(); 

        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('userName');
            window.location.href = '../pagina_login/index.php';
        });
    </script>
</body>
</html>