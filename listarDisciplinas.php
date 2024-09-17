<?php
function obterDisciplinas() {
    $listaDisciplinas = [];

    if (file_exists("disciplinas.txt")) {
        $arquivo = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");
        while (($linhaArquivo = fgets($arquivo)) !== false) {
            $linhaArquivo = trim($linhaArquivo);
            if (!empty($linhaArquivo) && $linhaArquivo != "nome;sigla;carga") {
                $listaDisciplinas[] = explode(";", $linhaArquivo);
            }
        }
        fclose($arquivo);
    }

    return $listaDisciplinas;
}

$disciplinasCadastradas = obterDisciplinas();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Disciplinas</title>
</head>
<body>

<div class="container">
    <h2>Disciplinas Cadastradas</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>Sigla</th>
            <th>Carga Horária</th>
            <th>Ações</th>
        </tr>
        <?php
        if (empty($disciplinasCadastradas)) {
            echo "<tr><td colspan='4'>Nenhuma disciplina cadastrada.</td></tr>";
        } else {
            for ($i = 0; $i < count($disciplinasCadastradas); $i++) {
                echo "<tr>
                        <td>" . $disciplinasCadastradas[$i][0] . "</td>
                        <td>" . $disciplinasCadastradas[$i][1] . "</td>
                        <td>" . $disciplinasCadastradas[$i][2] . "</td>
                        <td class='actions'>
                            <form action='' method='POST'>
                                <input type='hidden' name='opcao' value='editar'>
                                <input type='hidden' name='indice' value='" . $i . "'>
                                <input type='submit' value='Editar'>
                            </form>
                            <form action='' method='POST' onsubmit='return confirm(\"Tem certeza que deseja excluir esta disciplina?\");'>
                                <input type='hidden' name='opcao' value='excluir'>
                                <input type='hidden' name='indice' value='" . $i . "'>
                                <input type='submit' value='Excluir'>
                            </form>
                        </td>
                      </tr>";
            }
        }
        ?>
    </table>
</div>

</body>
</html>
