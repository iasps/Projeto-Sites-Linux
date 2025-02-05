<?php
$servername = "127.0.0.1";
$username = "admin";
$password = "Senha123456789*";
$dbname = "sweethome";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $localizacao = $_POST['localizacao'];
    $preco_noite = $_POST['preco_noite'];

    $sql = "INSERT INTO Casa (titulo, descricao, localizacao, preco_noite)
            VALUES ('$titulo', '$descricao', '$localizacao', '$preco_noite')";

    if ($conn->query($sql) === TRUE) {
        $msg = "Casa cadastrada com sucesso!";
    } else {
        $msg = "Erro ao cadastrar a casa: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Casa</title>
    <link rel="stylesheet" href="/sweethome.css">
</head>
<body>
    <header>
        <div>
            <h1><a href="index.php"><img src="/imagens/logo.png" alt="Logo do site" width="40">SWEETHOME</a></h1>
            <nav>
                <ul>
                    <li><a href="index.php#anuncios">Vizualizar anúncios</a></li>
                    <li><a href="cadastrar_casa.php">Cadastrar casa</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="cadastro">
        <h2>CADASTRAR CASA</h2>
        <p class="cadastro">Preencha os dados abaixo e, após isso, poderá visualizar o anúncio.</p>
        <?php if (isset($msg)) { echo "<p>$msg</p>"; } ?>

        <form action="cadastrar_casa.php" class="cadastro-form" method="POST">
            <div>
                <label for="titulo">Título:</label><br>
                <input type="text" name="titulo" id="titulo" placeholder="Insira um título para o anúncio..." required>
            </div>
            <div>
                <label for="localizacao">Localização:</label><br>
                <input type="text" name="localizacao" placeholder="Insira o endereço completo da residência..." id="localizacao" required>
            </div>
            <div>
                <label for="preco_noite">Preço por noite:</label><br>
                <input type="number" name="preco_noite" placeholder="R$..." id="preco_noite" step="0.01" required>
            </div>
            <div>
                <label for="descricao">Descrição:</label><br>
                <textarea name="descricao" id="descricao" placeholder="Ex: Casa semi-nova, com 2 quartos, 1 sala, 1 cozinha e 1 banheiro..." required></textarea>
            </div>
            <button type="submit" class="button-cadastro">Cadastrar</button>
        </form>
    </main>

    <footer>
        <p>Design by Iasmim Souto, Júlia de Oliveira, Kauê Nogueira and Micael Dantas ©️</p>
    </footer>
</body>
</html>
