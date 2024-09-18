<?php
// esse codigo é a união de todo o crud. fiz para deixar mais prático a visualização em uma só página 
$msg = "";
$listaDisciplinas = [];
$totalDisciplinas = 0;

carregarDisciplinas();
processarFormulario();

function carregarDisciplinas() {
    global $listaDisciplinas, $totalDisciplinas;
    if (file_exists("disciplinas.txt")) {
        $arquivo = fopen("disciplinas.txt", "r") or die("Erro ao abrir arquivo");
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

function salvarDisciplinas() {
    global $listaDisciplinas, $totalDisciplinas;
    $arquivo = fopen("disciplinas.txt", "w") or die("Erro ao abrir arquivo");
    fwrite($arquivo, "nome;sigla;carga\n");
    for ($i = 0; $i < $totalDisciplinas; $i++) {
        fwrite($arquivo, implode(";", $listaDisciplinas[$i]) . "\n");
    }
    fclose($arquivo);
}

function adicionarDisciplina($nomeDisciplina, $siglaDisciplina, $cargaHoraria) {
    global $listaDisciplinas, $totalDisciplinas;
    $listaDisciplinas[$totalDisciplinas] = [$nomeDisciplina, $siglaDisciplina, $cargaHoraria];
    $totalDisciplinas++;
    salvarDisciplinas();
}

function atualizarDisciplina($indiceDisciplina, $nomeDisciplina, $siglaDisciplina, $cargaHoraria) {
    global $listaDisciplinas;
    if ($indiceDisciplina != "") {
        $listaDisciplinas[$indiceDisciplina] = [$nomeDisciplina, $siglaDisciplina, $cargaHoraria];
        salvarDisciplinas();
    }
}

function excluirDisciplina($indiceDisciplina) {
    global $listaDisciplinas, $totalDisciplinas;
    if ($indiceDisciplina != "") {
        $temp = [];
        $novoTamanho = 0;
        for ($i = 0; $i < $totalDisciplinas; $i++) {
            if ($i != $indiceDisciplina) {
                $temp[$novoTamanho] = $listaDisciplinas[$i];
                $novoTamanho++;
            }
        }
        $listaDisciplinas = $temp;
        $totalDisciplinas = $novoTamanho;
        salvarDisciplinas();
    }
}

function processarFormulario() {
    global $msg;
    $nomeDisciplina = $_POST["nome"] ?? "";
    $siglaDisciplina = $_POST["sigla"] ?? "";
    $cargaHoraria = $_POST["carga"] ?? "";
    $indiceDisciplina = $_POST["indice"] ?? "";
    $opcao = $_POST["opcao"] ?? "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($opcao == "adicionar") {
            adicionarDisciplina($nomeDisciplina, $siglaDisciplina, $cargaHoraria);
            $msg = "Disciplina cadastrada com sucesso!";
        }

        if ($opcao == "atualizar") {
            atualizarDisciplina($indiceDisciplina, $nomeDisciplina, $siglaDisciplina, $cargaHoraria);
            $msg = "Disciplina atualizada com sucesso!";
        }

        if ($opcao == "excluir") {
            excluirDisciplina($indiceDisciplina);
            $msg = "Disciplina excluída com sucesso!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Listagem de Disciplinas</title>
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
        h1, h2 {
            color: #444;
            margin-top: 0;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="submit"], select {
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: calc(100% - 24px);
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border: none;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
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
        .actions form {
            display: inline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Criar Nova Disciplina</h1>
    <form action="" method="POST">
        <input type="hidden" name="opcao" value="adicionar">
        Nome: <input type="text" name="nome"><br><br>
        Sigla: <input type="text" name="sigla"><br><br>
        Carga Horária: <input type="text" name="carga"><br><br>
        <input type="submit" value="Criar Nova Disciplina">
    </form>
    <p><?php echo $msg; ?></p>
</div>

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
        if ($totalDisciplinas == 0) {
            echo "<tr><td colspan='4'>Nenhuma disciplina cadastrada.</td></tr>";
        } else {
            for ($i = 0; $i < $totalDisciplinas; $i++) {
                echo "<tr>
                        <td>{$listaDisciplinas[$i][0]}</td>
                        <td>{$listaDisciplinas[$i][1]}</td>
                        <td>{$listaDisciplinas[$i][2]}</td>
                        <td>
                            <form action='' method='POST'>
                                <input type='hidden' name='opcao' value='editar'>
                                <input type='hidden' name='indice' value='$i'>
                                <input type='submit' value='Editar'>
                            </form>
                            <form action='' method='POST' onsubmit='return confirm(\"Tem certeza que deseja excluir esta disciplina?\");'>
                                <input type='hidden' name='opcao' value='excluir'>
                                <input type='hidden' name='indice' value='$i'>
                                <input type='submit' value='Excluir'>
                            </form>
                        </td>
                      </tr>";
            }
        }
        ?>
    </table>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["opcao"] == 'editar') {
    $indiceDisciplina = $_POST["indice"];
    if ($indiceDisciplina != "" && $indiceDisciplina < $totalDisciplinas) {
        $disciplina = $listaDisciplinas[$indiceDisciplina];
        echo "<div class='container'>
                <h1>Editar Disciplina</h1>
                <form action='' method='POST'>
                    <input type='hidden' name='opcao' value='atualizar'>
                    <input type='hidden' name='indice' value='$indiceDisciplina'>
                    Nome: <input type='text' name='nome' value='{$disciplina[0]}'><br><br>
                    Sigla: <input type='text' name='sigla' value='{$disciplina[1]}'><br><br>
                    Carga Horária: <input type='text' name='carga' value='{$disciplina[2]}'><br><br>
                    <input type='submit' value='Atualizar Disciplina'>
                </form>
                <p>$msg</p>
              </div>";
    }
}
?>

</body>
</html>
