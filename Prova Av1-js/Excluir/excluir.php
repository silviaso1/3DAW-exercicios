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
            echo "Pergunta excluída com sucesso!";
        } else {
            echo "Pergunta não encontrada.";
        }
    } else {
        echo "Erro: O arquivo de perguntas não existe.";
    }
}
