<?php
// Conexão básica com o banco de dados
$conexao = new mysqli("localhost", "root", "", "usuarioseperguntas");

if ($conexao->connect_error) {
    die("Falha na conexão");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pergunta = $_POST["textoPergunta"];
    $escolhaA = $_POST["textoEscolhaA"];
    $escolhaB = $_POST["textoEscolhaB"];
    $escolhaC = $_POST["textoEscolhaC"];
    $escolhaD = $_POST["textoEscolhaD"];
    $correta = $_POST["opcaoCorreta"];

    // Inserindo dados na tabela
    $sql = "INSERT INTO perguntas_multiplas_escolhas (textoPergunta, textoEscolhaA, textoEscolhaB, textoEscolhaC, textoEscolhaD, opcaoCorreta)
            VALUES ('$pergunta', '$escolhaA', '$escolhaB', '$escolhaC', '$escolhaD', '$correta')";

    if ($conexao->query($sql) === TRUE) {
        echo "Pergunta cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar";
    }
}

$conexao->close();
?>
