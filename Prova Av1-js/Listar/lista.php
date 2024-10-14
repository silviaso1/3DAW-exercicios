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
                    $mensagemListagem = "<table border='1'><tr><th>Pergunta e Respostas</th></tr><tr><td>" . htmlspecialchars(trim($linha)) . "</td></tr></table>";
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
    
    echo $mensagemListagem;
}
?>
