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

// Excluir o anúncio
$sql = "DELETE FROM Casa WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Anúncio excluído com sucesso!'); window.location='index.php';</script>";
} else {
    echo "Erro ao excluir: " . $conn->error;
}

$conn->close();
?>
