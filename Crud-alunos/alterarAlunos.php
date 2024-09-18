<?php
include 'funcoesAlunos.php';

$mensagemAtualizacao = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $indice = $_POST["indice"];
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $matricula = $_POST["matricula"];
    $nascimento = $_POST["nascimento"];
    $mensagemAtualizacao = atualizarAluno($indice, $nome, $cpf, $matricula, $nascimento);
}

$alunos = carregarAlunos();
$aluno = $alunos[$_POST["indice"]];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Aluno</title>
</head>
<body>
    <h1>Atualizar Aluno</h1>
    <form action="" method="POST">
        <input type="hidden" name="indice" value="<?php echo $_POST["indice"]; ?>">
        Nome: <input type="text" name="nome" value="<?php echo $aluno[0]; ?>" required>
        <br><br>
        CPF: <input type="text" name="cpf" value="<?php echo $aluno[1]; ?>" required>
        <br><br>
        Matrícula: <input type="text" name="matricula" value="<?php echo $aluno[2]; ?>" required>
        <br><br>
        Data de Nascimento: <input type="date" name="nascimento" value="<?php echo $aluno[3]; ?>" required>
        <br><br>
        <input type="submit" value="Atualizar Aluno">
    </form>
    <p><?php echo $mensagemAtualizacao; ?></p>
</body>
</html>
