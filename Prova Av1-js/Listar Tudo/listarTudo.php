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
                $listagem .= "<tr><td>" . htmlspecialchars(trim($linha)) . "</td></tr>";
            }
        }
     
        fclose($arquivoAberto);
        
        if ($listagem == "") {
            $mensagemListagem = "Nenhuma pergunta cadastrada.";
        } else {
            $mensagemListagem = "<table border='1'><tr><th>Perguntas e Respostas</th></tr>" . $listagem . "</table>";
        }
    }

    echo $mensagemListagem;
}
?>
