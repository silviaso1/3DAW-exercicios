<?php
$conn = new mysqli("localhost", "root", "", "3daw");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$resultado = $conn->query("SELECT id_perguntas, questao, opcaoA, opcaoB, opcaoC, opcaoD, opcaoCerta FROM Perguntas");

$perguntas = $resultado->num_rows > 0 ? $resultado->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();

header('Content-Type: application/json');
echo json_encode($perguntas);
?>
