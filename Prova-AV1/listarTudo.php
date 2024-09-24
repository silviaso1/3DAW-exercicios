<?php
$mensagemListagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeArquivoPerguntas = 'perguntas_multiplas_escolhas.txt';
    $arquivoAberto = fopen($nomeArquivoPerguntas, 'r');
    
    if (!$arquivoAberto) {
        $mensagemListagem = "Erro ao abrir o arquivo.";
    } else {
        $listagem = "";
        while (!feof($arquivoAberto)) {
            $linha = fgets($arquivoAberto);
            if (trim($linha) !== "") {
                $listagem .= "<tr><td>" . trim($linha) . "</td></tr>";
            }
        }
        fclose($arquivoAberto);
        
        if ($listagem == "") {
            $mensagemListagem = "Nenhuma pergunta cadastrada.";
        } else {
            $mensagemListagem = "<table border='1'><tr><th>Perguntas e Respostas</th></tr>" . $listagem . "</table>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Perguntas e Respostas</title>
</head>
<body>
    <h1>Listar Perguntas e Respostas</h1>
    <form action="" method="POST">
        <input type="submit" value="Listar Perguntas e Respostas">
    </form>
    <p><?php echo $mensagemListagem; ?></p>
</body>
</html>
