<?php 
$servername = "127.0.0.1";
$username = "admin";
$password = "Senha123456789*";
$dbname = "sweethome";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recuperar as reservas cadastradas
$sql = "SELECT 
            r.id, 
            r.data_inicio, 
            r.data_fim, 
            c.titulo, 
            c.descricao, 
            c.localizacao, 
            c.preco_noite 
        FROM Reserva r
        JOIN Casa c ON r.casa_id = c.id";

$result = $conn->query($sql);

// Verifica se a consulta foi bem-sucedida
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas reservas</title>
    <link rel="stylesheet" href="/sweethome.css">
    <script>
        function confirmarExclusao(reservaId) {
            // Mostrar o modal de confirmação
            if (confirm("Você tem certeza que deseja excluir esta reserva?")) {
                // Redirecionar para a página de exclusão com o ID da reserva
                window.location.href = "excluir_reserva.php?id=" + reservaId;
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="header-container">
            <h1><a href="index.php"><img src="/imagens/logo.png" alt="Logotipo do site" width="40"> SWEETHOME</a></h1>
            <nav>
                <ul>
                    <li><a href="index.php#anuncios">Visualizar anúncios</a></li>
                    <li><a href="minhas_reservas.php">Minhas reservas</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section id="reservas">
            <h2>MEUS ALUGUÉIS</h2>
            <?php if ($result && $result->num_rows > 0): ?>
                <div class="reservas-lista">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="reserva-card">
                            <div class="reserva-header">
                                <div class="dia_inicio_fim">
                                    <span>Data de início: <b><?php echo date('d/m/Y', strtotime($row['data_inicio'])); ?></b></span>
                                    <span>Data de término: <b><?php echo date('d/m/Y', strtotime($row['data_fim'])); ?></b></span>
                                </div>
                                <div class="botoes_acoes">
                                    <a href="editar_reserva.php?id=<?php echo $row['id']; ?>" class="editar-link">
                                        <button class="editar">Editar</button>
                                    </a>
                                    <button class="excluir" onclick="confirmarExclusao(<?php echo $row['id']; ?>)">Excluir</button>
                                </div>
                            </div>
                            <div class="info_reserva">
                                <div class="titulo_loca_descri">
                                    <h3><?php echo $row['titulo']; ?></h3>
                                    <p><img src="/imagens/icon_loc.png" alt="ícone de localização" width="15"><i><?php echo $row['localizacao']; ?></i></p>
                                    <p><?php echo $row['descricao']; ?></p>
                                </div>
                                <div class="preco_noite">
                                    <p class="preco">R$ <?php echo number_format($row['preco_noite'], 2, ',', '.'); ?></p>
                                    <p class="noite">/Noite</p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Ainda não há reservas cadastradas.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>Design by Iasmim Souto, Júlia de Oliveira, Kauê Nogueira e Micael Dantas ©️</p>
    </footer>
</body>
</html>

<?php
// Fecha a conexão
$conn->close();
?>
