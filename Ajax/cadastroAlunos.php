<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['nome'])) {
    $nomeAluno = $_GET["nome"];
    $cpfAluno = $_GET["cpf"];
    $matriculaAluno = $_GET["matricula"];
    $dataNascimento = $_GET["nascimento"];

    $resultadoCadastro = adicionarAluno($nomeAluno, $cpfAluno, $matriculaAluno, $dataNascimento);
    echo $resultadoCadastro;
}

function adicionarAluno($nomeAluno, $cpfAluno, $matriculaAluno, $dataNascimento) {
    if (!file_exists("alunos.txt")) {
        $arquivo = fopen("alunos.txt", "w") or die("Erro ao criar arquivo");
        $cabecalho = "nome;cpf;matricula;nascimento\n";
        fwrite($arquivo, $cabecalho);
        fclose($arquivo);
    }
    $arquivo = fopen("alunos.txt", "a") or die("Erro ao abrir arquivo");
    $linha = $nomeAluno . ";" . $cpfAluno . ";" . $matriculaAluno . ";" . $dataNascimento . "\n";
    fwrite($arquivo, $linha);
    fclose($arquivo);
    return "Aluno cadastrado com sucesso!";
}
?>
