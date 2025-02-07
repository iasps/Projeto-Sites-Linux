<?php
$servername = "104.40.55.51";
$username = "admin";
$password = "sweethome";
$dbname = "sweethome";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recuperar o ID da reserva passado pela URL
$reserva_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($reserva_id) {
    // Recuperar dados da reserva a partir do banco de dados
    $sql = "SELECT r.id, r.data_inicio, r.data_fim, c.titulo, c.descricao, c.localizacao, c.preco_noite
            FROM Reserva r
            JOIN Casa c ON r.casa_id = c.id
            WHERE r.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reserva_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reserva = $result->fetch_assoc();
    
    if (!$reserva) {
        die("Reserva não encontrada.");
    }

    // Processar o envio do formulário e atualizar os dados
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data_inicio = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'];

        // Atualizar as datas de início e término da reserva
        $update_sql = "UPDATE Reserva
                       SET data_inicio = ?, data_fim = ?
                       WHERE id = ?";
        
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $data_inicio, $data_fim, $reserva_id);
        $update_stmt->execute();

        // Verificar se a atualização foi bem-sucedida
        if ($update_stmt->affected_rows > 0) {
            // Redirecionar para 'minhas_reservas.php' após salvar a edição
            header("Location: minhas_reservas.php");
            exit;
        } else {
            echo "Erro ao atualizar a reserva.";
        }
    }
} else {
    die("ID da reserva não fornecido.");
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva</title>
    <link rel="stylesheet" href="/sweethome.css">
</head>
<body>
<header>
    <div class="header-container">
        <h1><a href="index.php"><img src="/imagens/logo.png" alt="Logotipo do site" width="40"> SWEETHOME</a></h1>
        <nav>
            <ul>
                <li><a href="index.php#anuncios">Visualizar anúncios</a></li>
                <li><a href="minhas_reservas.php">Meus aluguéis</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <section id="editar_reserva">
        <h2>Editar Reserva</h2>
        <p class="p">Anúncio da casa selecionada:</p>        
        <!-- Exibir o anúncio da casa -->
        <div class="anuncio">
            <div class="pai">
                <div>
                    <h3 class="anuncio-titulo"><?php echo $reserva['titulo']; ?></h3>
                    <p class="anuncio-localizacao"><img src="/imagens/icon_loc.png" alt="ícone de localização" width="15"><?php echo $reserva['localizacao']; ?></p>
                </div>
                <p class="anuncio-preco"><strong>R$ <?php echo number_format($reserva['preco_noite'], 2, ',', '.'); ?></strong>/Noite</p>
            </div>
            <p class="anuncio-descricao"><?php echo $reserva['descricao']; ?></p>
        </div>

        <!-- Formulário de edição -->
        <form class="editar_reserva" action="editar_reserva.php?id=<?php echo $reserva['id']; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $reserva['id']; ?>">
            <div>
                <label for="data_inicio">Data de Início:</label>
                <input type="date" name="data_inicio" id="data_inicio" value="<?php echo date('Y-m-d', strtotime($reserva['data_inicio'])); ?>" required>
            </div>
            <div>
                <label for="data_fim">Data de Término:</label>
                <input type="date" name="data_fim" id="data_fim" value="<?php echo date('Y-m-d', strtotime($reserva['data_fim'])); ?>" required>
            </div>
            <button class="button-salvar" type="submit">Salvar Alterações</button>
        </form>
    </section>
</main>

<footer>
    <p>Design by Iasmim Souto, Júlia de Oliveira, Kauê Nogueira e Micael Dantas ©️</p>
</footer>
</body>
</html>
