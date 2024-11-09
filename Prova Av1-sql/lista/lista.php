<?php
$conn = new mysqli("localhost", "root", "", "3daw");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $idBuscado = $data['idPergunta'] ?? null;

    if (!$idBuscado) {
        http_response_code(400);
        echo json_encode(['error' => 'ID não fornecido']);
        exit();
    }

    $stmt = $conn->prepare("SELECT id_perguntas, questao, opcaoA, opcaoB, opcaoC, opcaoD, opcaoCerta FROM Perguntas WHERE id_perguntas = ?");
    $stmt->bind_param("i", $idBuscado);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pergunta = $resultado->num_rows > 0 ? $resultado->fetch_assoc() : null;

    $stmt->close();
    $conn->close();
    
    header('Content-Type: application/json');
    if ($pergunta) {
        echo json_encode([
            'id' => $pergunta['id_perguntas'],
            'questao' => $pergunta['questao'],
            'A' => $pergunta['opcaoA'],
            'B' => $pergunta['opcaoB'],
            'C' => $pergunta['opcaoC'],
            'D' => $pergunta['opcaoD'],
            'resposta' => $pergunta['opcaoCerta']
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Pergunta não encontrada']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
}
?>
