<?php
$conn = new mysqli("localhost", "root", "", "3daw");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $idAlterar = $data['id'] ?? null;
    $novaPergunta = $data['novaPergunta'] ?? null;
    $novaOpcaoA = $data['novaOpcaoA'] ?? null;
    $novaOpcaoB = $data['novaOpcaoB'] ?? null;
    $novaOpcaoC = $data['novaOpcaoC'] ?? null;
    $novaOpcaoD = $data['novaOpcaoD'] ?? null;
    $opcaoCerta = $data['novaOpcaoCerta'] ?? null;

    if ($idAlterar && $novaPergunta && $novaOpcaoA && $novaOpcaoB && $novaOpcaoC && $novaOpcaoD && $opcaoCerta) {
        $stmt = $conn->prepare("UPDATE Perguntas SET questao = ?, opcaoA = ?, opcaoB = ?, opcaoC = ?, opcaoD = ?, opcaoCerta = ? WHERE id_perguntas = ?");
        $stmt->bind_param("ssssssi", $novaPergunta, $novaOpcaoA, $novaOpcaoB, $novaOpcaoC, $novaOpcaoD, $opcaoCerta, $idAlterar);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['message' => 'Pergunta atualizada com sucesso.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao atualizar a pergunta.']);
        }

        $stmt->close();
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Dados incompletos para atualização.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}

$conn->close();
?>
