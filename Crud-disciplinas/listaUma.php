<?php
$msg = "";
$listaDisciplinas = [];
$totalDisciplinas = 0;

carregarDisciplinas();

function carregarDisciplinas() {
    global $listaDisciplinas, $totalDisciplinas;
    if (file_exists("disciplinas.txt")) {
        $arquivo = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");
        while (($linha = fgets($arquivo)) !== false) {
            $linha = trim($linha);
            if ($linha != "" && $linha != "nome;sigla;carga") {
                $listaDisciplinas[] = explode(";", $linha);
                $totalDisciplinas++;
            }
        }
        fclose($arquivo);
    }
}

$disciplinaSelecionada = null;
$siglaPesquisada = $_POST["sigla"] ?? "";

if ($siglaPesquisada !== "") {
    for ($i = 0; $i < $totalDisciplinas; $i++) {
        if ($listaDisciplinas[$i][1] === $siglaPesquisada) {
            $disciplinaSelecionada = $listaDisciplinas[$i];
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Disciplina</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            margin: 10px;
        }
        h1 {
            color: #444;
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f9f9f9;
            color: #555;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e6e6e6;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Pesquisar Disciplina por Sigla</h1>
    <form action="" method="POST">
        Sigla: <input type="text" name="sigla" placeholder="Digite a sigla da disciplina"><br><br>
        <input type="submit" value="Pesquisar">
    </form>

    <?php if ($siglaPesquisada === "") { ?>
        <p>Digite uma sigla para pesquisar.</p>
    <?php } elseif ($disciplinaSelecionada === null) { ?>
        <p>Nenhuma disciplina encontrada com a sigla "<?php echo $siglaPesquisada; ?>".</p>
    <?php } else { ?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Sigla</th>
                <th>Carga Horária</th>
            </tr>
            <tr>
                <td><?php echo $disciplinaSelecionada[0]; ?></td>
                <td><?php echo $disciplinaSelecionada[1]; ?></td>
                <td><?php echo $disciplinaSelecionada[2]; ?></td>
            </tr>
        </table>
    <?php } ?>
</div>

</body>
</html>
