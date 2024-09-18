<?php
include 'funcoesAlunos.php';

$listaAlunos = carregarAlunos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Todos os Alunos</title>
</head>
<body>
    <h1>Listar Todos os Alunos</h1>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Matrícula</th>
            <th>Data de Nascimento</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($listaAlunos as $indice => $aluno) { ?>
        <tr>
            <td><?php echo $aluno[0]; ?></td>
            <td><?php echo $aluno[1]; ?></td>
            <td><?php echo $aluno[2]; ?></td>
            <td><?php echo $aluno[3]; ?></td>
            <td>
                <form action="alterar_aluno.php" method="POST">
                    <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                    <input type="submit" value="Editar">
                </form>
                <form action="excluir_aluno.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este aluno?');">
                    <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                    <input type="submit" value="Excluir">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
