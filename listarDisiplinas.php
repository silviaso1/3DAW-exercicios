<?php
$msg = "";
$disciplinas = [];

function carregarDisciplinas() {
    global $disciplinas;
    if (file_exists("disciplinas.txt")) {
        $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao abrir arquivo");
        while (($linha = fgets($arqDisc)) !== false) {
            $linha = trim($linha);
            if (!empty($linha)) {
                $disciplinas[] = explode(";", $linha);
            }
        }
        fclose($arqDisc);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'adicionar') {
    $nome = $_POST["nome"] ?? '';
    $sigla = $_POST["sigla"] ?? '';
    $carga = $_POST["carga"] ?? '';

    if (!empty($nome) && !empty($sigla) && !empty($carga)) {
        $arqDisc = fopen("disciplinas.txt", "a") or die("Erro ao criar arquivo");
        $linha = $nome . ";" . $sigla . ";" . $carga . "\n";
        fwrite($arqDisc, $linha);
        fclose($arqDisc);
        $msg = "Disciplina cadastrada com sucesso!";
    } else {
        $msg = "Todos os campos devem ser preenchidos!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'atualizar') {
    $nome = $_POST["nome"] ?? '';
    $sigla = $_POST["sigla"] ?? '';
    $carga = $_POST["carga"] ?? '';
    $index = $_POST["index"] ?? '';

    if (!empty($nome) && !empty($sigla) && !empty($carga) && $index !== '') {
        carregarDisciplinas();
        if (isset($disciplinas[$index])) {
            $disciplinas[$index] = [$nome, $sigla, $carga];
            $arqDisc = fopen("disciplinas.txt", "w") or die("Erro ao abrir arquivo");
            foreach ($disciplinas as $disciplina) {
                fwrite($arqDisc, implode(";", $disciplina) . "\n");
            }
            fclose($arqDisc);
            $msg = "Disciplina atualizada com sucesso!";
        } else {
            $msg = "Disciplina não encontrada!";
        }
    } else {
        $msg = "Todos os campos devem ser preenchidos!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'excluir') {
    $index = $_POST["index"] ?? '';

    if ($index !== '') {
        carregarDisciplinas();
        if (isset($disciplinas[$index])) {
            unset($disciplinas[$index]);
            $arqDisc = fopen("disciplinas.txt", "w") or die("Erro ao abrir arquivo");
            foreach ($disciplinas as $disciplina) {
                fwrite($arqDisc, implode(";", $disciplina) . "\n");
            }
            fclose($arqDisc);
            $msg = "Disciplina excluída com sucesso!";
        } else {
            $msg = "Disciplina não encontrada!";
        }
    } else {
        $msg = "Índice da disciplina não fornecido!";
    }
}

carregarDisciplinas();
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
    <h1>Cadastro de Disciplina</h1>
    <form action="" method="POST">
        <input type="hidden" name="acao" value="adicionar">
        Nome: <input type="text" name="nome" required>
        <br>
        Sigla: <input type="text" name="sigla" required>
        <br>
        Carga Horária: <input type="text" name="carga" required>
        <br>
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
        if (empty($disciplinas)) {
            echo "<tr><td colspan='4'>Nenhuma disciplina cadastrada.</td></tr>";
        } else {
            foreach ($disciplinas as $index => $disciplina) {
                echo "<tr>
                        <td>" . $disciplina[0] . "</td>
                        <td>" . $disciplina[1] . "</td>
                        <td>" . $disciplina[2] . "</td>
                        <td class='actions'>
                            <form action='' method='POST'>
                                <input type='hidden' name='acao' value='editar'>
                                <input type='hidden' name='index' value='" . $index . "'>
                                <input type='submit' value='Editar'>
                            </form>
                            <form action='' method='POST' onsubmit='return confirm(\"Tem certeza que deseja excluir esta disciplina?\");'>
                                <input type='hidden' name='acao' value='excluir'>
                                <input type='hidden' name='index' value='" . $index . "'>
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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    $index = $_POST["index"] ?? '';

    if ($index !== '' && isset($disciplinas[$index])) {
        $disciplina = $disciplinas[$index];
        echo "<div class='container'>
                <h1>Editar Disciplina</h1>
                <form action='' method='POST'>
                    <input type='hidden' name='acao' value='atualizar'>
                    <input type='hidden' name='index' value='" . $index . "'>
                    Nome: <input type='text' name='nome' value='" . $disciplina[0] . "' required>
                    <br>
                    Sigla: <input type='text' name='sigla' value='" . $disciplina[1] . "' required>
                    <br>
                    Carga Horária: <input type='text' name='carga' value='" . $disciplina[2] . "' required>
                    <br>
                    <input type='submit' value='Atualizar Disciplina'>
                </form>
                <p>" . $msg . "</p>
              </div>";
    }
}
?>

</body>
</html>
