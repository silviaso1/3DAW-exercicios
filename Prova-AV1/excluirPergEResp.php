<?php
$mensagemDelete = "";
$numeroPergunta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numeroPergunta = trim($_POST["numeroPergunta"]);
    $nomeArquivoPerguntas = 'perguntas_multiplas_escolhas.txt';
    
    if (file_exists($nomeArquivoPerguntas)) {
        $arquivoAberto = fopen($nomeArquivoPerguntas, 'r');
        $linhas = [];
        $linhaAtual = 1;
        $encontrou = false;

        while (!feof($arquivoAberto)) {
            $linha = fgets($arquivoAberto);
            if (trim($linha) !== "") {
                if ($linhaAtual == $numeroPergunta) {
                    $encontrou = true;
                } else {
                    $linhas[] = $linha;
                }
                $linhaAtual++;
            }
        }
        fclose($arquivoAberto);

        if ($encontrou) {
            $arquivoAberto = fopen($nomeArquivoPerguntas, 'w');
            foreach ($linhas as $linha) {
                fwrite($arquivoAberto, $linha); 
            }
            fclose($arquivoAberto);
            $mensagemDelete = "Pergunta excluída com sucesso!";
        } else {
            $mensagemDelete = "Pergunta não encontrada.";
        }
    } else {
        $mensagemDelete = "Erro: O arquivo de perguntas não existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Pergunta</title>
</head>
<body>
    <h1>Excluir Pergunta</h1>
    <form action="" method="POST">
        Número da Pergunta: <input type="text" name="numeroPergunta" required>
        <input type="submit" value="Excluir Pergunta">
    </form>
    <p><?php echo $mensagemDelete; ?></p>
</body>
</html>
