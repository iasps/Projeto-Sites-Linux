<?php
$servername = "104.40.55.51";
$username = "admin";
$password = "sweethome";
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
                    <li><a href="#anuncios">Vizualizar anúncios</a></li>
                    <li><a href="cadastrar_casa.php">Cadastrar casa</a></li>
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
        
                            <!-- Botões de Editar e Excluir -->
                            <div class="botoes-anuncio">
                                <a href="editar_casa.php?id=<?php echo $row['id']; ?>" class="btn-editar">Editar</a>
                                <a href="excluir_casa.php?id=<?php echo $row['id']; ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este anúncio?')">Excluir</a>
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
