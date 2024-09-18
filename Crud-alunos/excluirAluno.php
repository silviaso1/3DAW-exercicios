<?php
include 'funcoesAlunos.php';

$mensagemExclusao = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $indice = $_POST["indice"];
    $alunos = carregarAlunos();
    if (isset($alunos[$indice])) {
        unset($alunos[$indice]);
        $alunos = array_values($alunos); 
        salvarAlunos($alunos);
        $mensagemExclusao = "Aluno excluído com sucesso!";
    } else {
        $mensagemExclusao = "Aluno não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Aluno</title>
</head>
<body>
    <h1>Excluir Aluno</h1>
    <p><?php echo $mensagemExclusao; ?></p>
    <a href="listar_alunos.php">Voltar para a lista de alunos</a>
</body>
</html>
