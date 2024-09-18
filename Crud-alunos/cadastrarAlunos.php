<?php
include 'funcoesAlunos.php';

$mensagemCadastro = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $matricula = $_POST["matricula"];
    $nascimento = $_POST["nascimento"];
    $mensagemCadastro = adicionarAluno($nome, $cpf, $matricula, $nascimento);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>
</head>
<body>
    <h1>Cadastrar Aluno</h1>
    <form action="" method="POST">
        Nome: <input type="text" name="nome" required>
        <br><br>
        CPF: <input type="text" name="cpf" required>
        <br><br>
        Matrícula: <input type="text" name="matricula" required>
        <br><br>
        Data de Nascimento: <input type="date" name="nascimento" required>
        <br><br>
        <input type="submit" value="Cadastrar Aluno">
    </form>
    <p><?php echo $mensagemCadastro; ?></p>
</body>
</html>
