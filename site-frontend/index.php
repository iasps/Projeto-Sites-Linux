<?php
$servername = "127.0.0.1";
$username = "admin";
$password = "Senha123456789*";
$dbname = "sweethome";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recuperar as casas cadastradas
$sql = "SELECT * FROM Casa";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetHome</title>
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

    <main>
        <section class="destaque">
            <img src="/imagens/destaque.png" alt="Imagem destaque">
        </section>

        <section id="anuncios">
            <h2>ANÚNCIOS DAS RESIDÊNCIAS</h2>
            <?php if ($result->num_rows > 0): ?>
                <div class="anuncios-lista">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="anuncio">
                            <div class="pai">
                                <div>
                                    <h3 class="anuncio-titulo"><?php echo $row['titulo']; ?></h3>
                                    <p class="anuncio-localizacao"><img src="/imagens/icon_loc.png" alt="ícone de localização" width="15"><?php echo $row['localizacao']; ?></p>
                                </div>
                                <p class="anuncio-preco"><strong>R$ <?php echo number_format($row['preco_noite'], 2, ',', '.'); ?></strong>/Noite</p>
                            </div>
                            <p class="anuncio-descricao"><?php echo $row['descricao']; ?></p>
        
                            <!-- Botão Alugar -->
                            <div class="botoes-anuncio">
                                <a href="reservar.php?id=<?php echo $row['id']; ?>" class="btn-alugar">Alugar</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Ainda não há anúncios cadastrados.</p>
            <?php endif; ?>
        </section>       
    </main>

    <footer>
        <p>Design by Iasmim Souto, Júlia de Oliveira, Kauê Nogueira and Micael Dantas ©️</p>
    </footer>
</body>
</html>

<?php
// Fechar conexão
$conn->close();
?>
