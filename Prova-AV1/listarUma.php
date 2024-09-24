<?php
$mensagemListagem = "";
$numeroPergunta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numeroPergunta = trim($_POST["numeroPergunta"]);
    $nomeArquivoPerguntas = 'perguntas_multiplas_escolhas.txt';
    $arquivoAberto = fopen($nomeArquivoPerguntas, 'r');

    if (!$arquivoAberto) {
        $mensagemListagem = "Erro ao abrir o arquivo.";
    } else {
        $linhaAtual = 1; 
        $encontrou = false;
        while (!feof($arquivoAberto)) {
            $linha = fgets($arquivoAberto);
            if (trim($linha) !== "") {
                if ($linhaAtual == $numeroPergunta) {
                    $mensagemListagem = "<table border='1'><tr><th>Pergunta e Respostas</th></tr><tr><td>" . trim($linha) . "</td></tr></table>";
                    $encontrou = true;
                    break;
                }
                $linhaAtual++;
            }
        }
        fclose($arquivoAberto);

        if (!$encontrou) {
            $mensagemListagem = "Pergunta não encontrada.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Pergunta</title>
</head>
<body>
    <h1>Listar Pergunta</h1>
    <form action="" method="POST">
        Número da Pergunta: <input type="text" name="numeroPergunta" required>
        <input type="submit" value="Buscar Pergunta">
    </form>
    <p><?php echo $mensagemListagem; ?></p>
</body>
</html>
