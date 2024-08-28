<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Disciplina</title>
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
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
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
    </style>
</head>
<body>
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
</body>
</html>
