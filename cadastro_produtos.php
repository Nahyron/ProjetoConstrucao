<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
 <style>
#tabela {
        font-family: Georgia, 'Times New Roman', Times, serif;
        font-weight: bolder;
        position: absolute;
        top: 50%;
        left: 50%;
        translate: -50% -50%;
        text-align: center;
        background-color: #ffffffff;
        border: 3px solid #2a091c;
        border-radius: 9px;
        width: 800px;
        height: 500px;
        overflow: auto;
                box-shadow: 5px 8px 15px #808080;


    }

    input {
        width: 700px;
        height: 35px;
        border: 2px solid black;
        border-radius: 5px;
        background-color: #dbdbdbff;
    }

    #enviar {
        background-color: #a3c3b8;
        width: 450px;
        height: 25px;
        box-shadow: 5px 8px 15px #808080;
    }

    #enviar:hover {
        background-color: #e3edd2;
        width: 480px;
        height: 28px;

    }

    h5 {
        text-align: left;
        margin: 15px;
    }
   </style>
<body>
    
    <h2>Intituições</h2>
    <div id="tabela">

        <form method="post" class="pergunta" enctype="multipart/form-data"><br><br>
            <h5>Qual o produto:</h5>
            <input type="text" name="produto" required placeholder="Qual produto deseja cadastrar:" id="item1"><br><br>
            <h5>Cor:</h5>
            <input type="text" name="cor" required placeholder="Variação de cor:" id="item2"><br><br>
            <h5>Textura:</h5>
            <input type="text" name="textura" required placeholder="Textura:" id="item2"><br><br>
            <h5>Peso ou Litros:</h5>
            <input type="text" name="pesoLitro" required placeholder="Peso ou Litros:" id="item2"><br><br>

            <h5>aperte para finalizar o cadastros:</h5>
            <input type="submit" name="cadastrar conta" value="Gerar conta" id="enviar"><br><br>
    
        </form>
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
    </div>
</body>
</html>