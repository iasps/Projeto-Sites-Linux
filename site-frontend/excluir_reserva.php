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
    // Excluir a reserva do banco de dados
    $sql = "DELETE FROM Reserva WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reserva_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirecionar para 'minhas_reservas.php' após excluir
        header("Location: minhas_reservas.php");
        exit;
    } else {
        echo "Erro ao excluir a reserva.";
    }
} else {
    echo "ID da reserva não fornecido.";
}

// Fechar a conexão
$conn->close();
?>
