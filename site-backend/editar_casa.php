<?php
$servername = "104.40.55.51";
$username = "admin";
$password = "sweethome";
$dbname = "sweethome";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID inválido.");
}

$id = $_GET['id'];

$sql = "SELECT * FROM Casa WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Anúncio não encontrado.");
}

$casa = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $localizacao = $_POST['localizacao'];
    $preco_noite = $_POST['preco_noite'];

    $sql = "UPDATE Casa SET titulo='$titulo', descricao='$descricao', localizacao='$localizacao', preco_noite='$preco_noite' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Anúncio atualizado com sucesso!'); window.location='index.php';</script>";
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}

$conn->close();
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Casa</title>
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

    <main class="main-edicao">
        <h2>EDITAR ANÚNCIO</h2>

        <form action="" class="cadastro-form" method="POST">
            <div>
                <label for="titulo">Título:</label><br>
                <input type="text" name="titulo" value="<?php echo $casa['titulo']; ?>" required>
            </div>
            <div>
                <label for="localizacao">Localização:</label><br>
                <input type="text" name="localizacao" value="<?php echo $casa['localizacao']; ?>" required>
            </div>
            <div>
                <label for="preco_noite">Preço por noite:</label><br>
                <input type="number" name="preco_noite" value="<?php echo $casa['preco_noite']; ?>" step="0.01" required>
            </div>
            <div>
                <label for="descricao">Descrição:</label><br>
                <textarea name="descricao" required><?php echo $casa['descricao']; ?></textarea>
            </div>
            <button type="submit" class="button-cadastro">Editar</button>
        </form>
    </main>

    <footer>
        <p>Design by Iasmim Souto, Júlia de Oliveira, Kauê Nogueira and Micael Dantas ©️</p>
    </footer>
</body>
</html>
