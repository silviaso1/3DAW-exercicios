<?php
include 'funcoesAlunos.php';

$aluno = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $indice = $_POST["indice"];
    $alunos = carregarAlunos();
    if (isset($alunos[$indice])) {
        $aluno = $alunos[$indice];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Aluno</title>
</head>
<body>
    <h1>Detalhes do Aluno</h1>
    <?php if (!empty($aluno)) { ?>
    <p><strong>Nome:</strong> <?php echo $aluno[0]; ?></p>
    <p><strong>CPF:</strong> <?php echo $aluno[1]; ?></p>
    <p><strong>Matrícula:</strong> <?php echo $aluno[2]; ?></p>
    <p><strong>Data de Nascimento:</strong> <?php echo $aluno[3]; ?></p>
    <?php } else { ?>
    <p>Aluno não encontrado.</p>
    <?php } ?>
    <a href="listar_alunos.php">Voltar para a lista de alunos</a>
</body>
</html>
