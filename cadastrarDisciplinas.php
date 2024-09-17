<?php
function inserirDisciplina($nomeDisciplina, $siglaDisciplina, $cargaHoraria) {
    $mensagem = "";

    if (!file_exists("disciplinas.txt")) {
        $arquivoDisciplinas = fopen("disciplinas.txt", "w") or die("Erro ao criar arquivo");
        $cabecalho = "nome;sigla;carga\n";
        fwrite($arquivoDisciplinas, $cabecalho);
        fclose($arquivoDisciplinas);
    }

    $arquivoDisciplinas = fopen("disciplinas.txt", "a") or die("Erro ao abrir arquivo");
    $novaLinha = $nomeDisciplina . ";" . $siglaDisciplina . ";" . $cargaHoraria . "\n";
    fwrite($arquivoDisciplinas, $novaLinha);
    fclose($arquivoDisciplinas);

    $mensagem = "Disciplina cadastrada com sucesso!";
    return $mensagem;
}

$mensagemCadastro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["opcao"] == "adicionar") {
    $nomeDisciplina = $_POST["nomeDisciplina"];
    $siglaDisciplina = $_POST["siglaDisciplina"];
    $cargaHoraria = $_POST["cargaHoraria"];
    $mensagemCadastro = inserirDisciplina($nomeDisciplina, $siglaDisciplina, $cargaHoraria);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Disciplina</title>
</head>
<body>

<div class="container">
    <h1>Criar Nova Disciplina</h1>
    <form action="" method="POST">
        <input type="hidden" name="opcao" value="adicionar">
        Nome: <input type="text" name="nomeDisciplina">
        <br><br>
        Sigla: <input type="text" name="siglaDisciplina">
        <br><br>
        Carga Horária: <input type="text" name="cargaHoraria">
        <br><br>
        <input type="submit" value="Criar Nova Disciplina">
    </form>
    <p><?php echo $mensagemCadastro; ?></p>
</div>

</body>
</html>
