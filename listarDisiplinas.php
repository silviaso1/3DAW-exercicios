<?php
$msg = "";
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"] ?? '';
    $sigla = $_POST["sigla"] ?? '';
    $carga = $_POST["carga"] ?? '';

    // Verifica se todos os campos foram preenchidos
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Listagem de Disciplinas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .content {
            display: flex;
            justify-content: space-between;
            width: 80%;
            max-width: 1200px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 45%;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: calc(100% - 22px);
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        p {
            margin-top: 20px;
            font-size: 1.2em;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<div class="content">
    <div class="container">
        <h1>Cadastro de Disciplina</h1>
        <form action="" method="POST">
            Nome: <input type="text" name="nome" required>
            <br><br>
            Sigla: <input type="text" name="sigla" required>
            <br><br>
            Carga Horária: <input type="text" name="carga" required>
            <br><br>
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
            </tr>
            <?php
            // Verifica se o arquivo de disciplinas existe
            if (file_exists("disciplinas.txt")) {
                $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao abrir arquivo");

                // Lê linha por linha do arquivo
                while (!feof($arqDisc)) {
                    $linha = fgets($arqDisc);
                    if (!empty(trim($linha))) {  // Verifica se a linha não está vazia
                        $colunaDados = explode(";", $linha);
                        
                        // Exibe os dados em uma linha da tabela
                        echo "<tr>
                                <td>" . $colunaDados[0] . "</td>
                                <td>" . $colunaDados[1] . "</td>
                                <td>" . $colunaDados[2] . "</td>
                              </tr>";
                    }
                }

                fclose($arqDisc);
            } else {
                echo "<tr><td colspan='3'>Nenhuma disciplina cadastrada.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>
