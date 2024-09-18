<?php
function carregarDisciplinas() {
    $listaDisciplinas = [];
    if (file_exists("disciplinas.txt")) {
        $arquivo = fopen("disciplinas.txt", "r") or die("Erro ao abrir arquivo");
        while (($linha = fgets($arquivo)) !== false) {
            $linha = trim($linha);
            if ($linha != "" && $linha != "nome;sigla;carga") {
                $listaDisciplinas[] = explode(";", $linha);
            }
        }
        fclose($arquivo);
    }
    return $listaDisciplinas;
}

function salvarDisciplinas($listaDisciplinas) {
    $arquivo = fopen("disciplinas.txt", "w") or die("Erro ao abrir arquivo");
    fwrite($arquivo, "nome;sigla;carga\n");
    foreach ($listaDisciplinas as $disciplina) {
        fwrite($arquivo, implode(";", $disciplina) . "\n");
    }
    fclose($arquivo);
}

function atualizarDisciplina($indice, $nome, $sigla, $carga) {
    $listaDisciplinas = carregarDisciplinas();
    $listaDisciplinas[$indice] = [$nome, $sigla, $carga];
    salvarDisciplinas($listaDisciplinas);
    return "Disciplina atualizada com sucesso!";
}

$mensagemAtualizacao = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $indice = $_POST["indice"];
    $nome = $_POST["nome"];
    $sigla = $_POST["sigla"];
    $carga = $_POST["carga"];
    $mensagemAtualizacao = atualizarDisciplina($indice, $nome, $sigla, $carga);
}

$disciplinas = carregarDisciplinas();
$disciplina = $disciplinas[$_POST["indice"]];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Disciplina</title>
</head>
<body>

<div class="container">
    <h1>Editar Disciplina</h1>
    <form action="" method="POST">
        <input type="hidden" name="indice" value="<?php echo $_POST["indice"]; ?>">
        Nome: <input type="text" name="nome" value="<?php echo $disciplina[0]; ?>">
        <br><br>
        Sigla: <input type="text" name="sigla" value="<?php echo $disciplina[1]; ?>">
        <br><br>
        Carga Horária: <input type="text" name="carga" value="<?php echo $disciplina[2]; ?>">
        <br><br>
        <input type="submit" value="Atualizar Disciplina">
    </form>
    <p><?php echo $mensagemAtualizacao; ?></p>
</div>

</body>
</html>
