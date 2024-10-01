<?php
include 'funcoesAlunos.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $nome = $_GET["nome"];
    $cpf = $_GET["cpf"];
    $matricula = $_GET["matricula"];
    $nascimento = $_GET["nascimento"];

    $mensagemCadastro = adicionarAluno($nome, $cpf, $matricula, $nascimento);
    echo $mensagemCadastro;
}
?>
