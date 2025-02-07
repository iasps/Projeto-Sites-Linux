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
    die("Erro: Nenhuma casa selecionada.");
}

$casa_id = intval($_GET['id']);

$sql = "SELECT * FROM Casa WHERE id = $casa_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Erro: Casa não encontrada.");
}

$casa = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    if (empty($data_inicio) || empty($data_fim)) {
        echo "<script>alert('Por favor, preencha todas as datas!');</script>";
    } elseif ($data_inicio > $data_fim) {
        echo "<script>alert('A data de início não pode ser maior que a data de fim!');</script>";
    } else {
        $sql_insert = "INSERT INTO Reserva (casa_id, data_inicio, data_fim) 
                       VALUES ('$casa_id', '$data_inicio', '$data_fim')";

        if ($conn->query($sql_insert) === TRUE) {
            echo "<script>alert('Reserva realizada com sucesso!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Erro ao reservar: " . $conn->error . "');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar casas</title>
    <link rel="stylesheet" href="/sweethome.css">
</head>
<body>
    <header>
        <div>
            <h1><a href="index.php"><img src="/imagens/logo.png" alt="Logo do site" width="40">SWEETHOME</a></h1>
            <nav>
                <ul>
                    <li><a href="index.php#anuncios">Vizualizar anúncios</a></li>
                    <li><a href="minhas_reservas.php">Minhas reservas</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-reserva">
        <h2>RESERVAR CASA</h2>
        <p class="reserva">Preencha os dados abaixo e, após isso, poderá visualizar o aluguel em “Minhas reservas”.</p>

        <section class="detalhes-casa">
            <p class="p">Anúncio da casa selecionada:</p>
            <div class="anuncio">
                <div class="pai">
                    <div>
                        <h3 class="anuncio-titulo"><?php echo $casa['titulo']; ?></h3>
                        <p class="anuncio-localizacao"><img src="/imagens/icon_loc.png" alt="ícone de localização" width="15"><?php echo $casa['localizacao']; ?></p>
                    </div>
                    <p class="anuncio-preco">R$ <?php echo number_format($casa['preco_noite'], 2, ',', '.'); ?>/Noite</p>
                </div>
                <p class="anuncio-descricao"><?php echo $casa['descricao']; ?></p>
            </div>
            <form method="POST" class="reserva-form">
                <div>
                    <label for="data_inicio">Data de Início:</label>
                    <input type="date" id="data_inicio" placeholder="Insira a data que deseja iniciar o aluguel..." name="data_inicio" required>
                </div>
                <div>
                    <label for="data_fim">Data de Fim:</label>
                    <input type="date" id="data_fim" placeholder="Insira a data que deseja finalizar o aluguel..." name="data_fim" required>
                </div>
                <button type="submit" class="btn-confirm-aluguel">Confirmar reserva</button>
            </form>
        </section>
    </main>

    <footer>
        <p>Design by Iasmim Souto, Júlia de Oliveira, Kauê Nogueira e Micael Dantas ©️</p>
    </footer>
</body>
</html>
