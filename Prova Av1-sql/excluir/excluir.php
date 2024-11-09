<?php
$conn = new mysqli("localhost", "root", "", "3daw");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $idExcluir = $data['idExcluirConfirmada'] ?? null;

    if (!$idExcluir) {
        http_response_code(400);
        echo json_encode(['error' => 'ID de exclusão não fornecido.']);
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM Perguntas WHERE id_perguntas = ?");
    $stmt->bind_param("i", $idExcluir);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(['message' => 'Pergunta excluída com sucesso.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao excluir a pergunta.']);
    }

    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}

$conn->close();
?>
