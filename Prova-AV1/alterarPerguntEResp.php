<?php
$mensagemAlteracao = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPergunta = $_POST["idPergunta"];
    $novaPergunta = $_POST["novaPergunta"];
    $novaEscolhaA = $_POST["novaEscolhaA"];
    $novaEscolhaB = $_POST["novaEscolhaB"];
    $novaEscolhaC = $_POST["novaEscolhaC"];
    $novaEscolhaD = $_POST["novaEscolhaD"];
    $novaOpcaoCorreta = $_POST["novaOpcaoCorreta"];
    
    $mensagemAlteracao = alterarPerguntaEMultiplasEscolhas($idPergunta, $novaPergunta, $novaEscolhaA, $novaEscolhaB, $novaEscolhaC, $novaEscolhaD, $novaOpcaoCorreta);
}

function alterarPerguntaEMultiplasEscolhas($idPergunta, $novaPergunta, $novaEscolhaA, $novaEscolhaB, $novaEscolhaC, $novaEscolhaD, $novaOpcaoCorreta) {
    $nomeArquivoPerguntas = 'perguntas_multiplas_escolhas.txt';
    $arquivoAberto = fopen($nomeArquivoPerguntas, 'r');
    
    if (!$arquivoAberto) {
        return "Erro ao abrir o arquivo.";
    }

    $conteudoArquivo = "";
    while (!feof($arquivoAberto)) {
        $conteudoArquivo .= fgetc($arquivoAberto);
    }
    fclose($arquivoAberto);

    $linhasArquivo = [];
    $linhaAtual = "";
    for ($i = 0; $i < strlen($conteudoArquivo); $i++) {
        $caracterAtual = $conteudoArquivo[$i];
        if ($caracterAtual === "\n") {
            $linhasArquivo[] = $linhaAtual;
            $linhaAtual = "";
        } else {
            $linhaAtual .= $caracterAtual;
        }
    }
    $linhasArquivo[] = $linhaAtual; 


    $perguntaAlterada = false;
    for ($i = 0; $i < count($linhasArquivo); $i++) {
        $linha = $linhasArquivo[$i];

        $idExtraido = "";
        $inicioId = -1;
        for ($j = 0; $j < strlen($linha) - 4; $j++) {
            if ($linha[$j] == 'I' && $linha[$j + 1] == 'D' && $linha[$j + 2] == ':' && $linha[$j + 3] == ' ') {
                $inicioId = $j + 4;
                break;
            }
        }
        if ($inicioId != -1) {
            for ($j = $inicioId; $j < strlen($linha) && $linha[$j] != ' '; $j++) {
                $idExtraido .= $linha[$j];
            }
        }

        if ($idExtraido == $idPergunta) {
            $linhasArquivo[$i] = "ID: " . $idPergunta . " | Pergunta: " . $novaPergunta . " | a) " . $novaEscolhaA . " | b) " . $novaEscolhaB . " | c) " . $novaEscolhaC . " | d) " . $novaEscolhaD . " | Correta: " . $novaOpcaoCorreta;
            $perguntaAlterada = true;
            break;
        }
    }

    if (!$perguntaAlterada) {
        return "Pergunta com o ID especificado não encontrada.";
    }

    $arquivoAbertoParaEscrita = fopen($nomeArquivoPerguntas, 'w');
    if ($arquivoAbertoParaEscrita) {
        foreach ($linhasArquivo as $linhaAlterada) {
            for ($i = 0; $i < strlen($linhaAlterada); $i++) {
                fwrite($arquivoAbertoParaEscrita, $linhaAlterada[$i]);
            }
            fwrite($arquivoAbertoParaEscrita, "\n");
        }
        fclose($arquivoAbertoParaEscrita);
        return "Pergunta alterada com sucesso!";
    } else {
        return "Erro ao salvar a alteração.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Pergunta de Múltipla Escolha</title>
</head>
<body>
    <h1>Alterar Pergunta de Múltipla Escolha</h1>
    <form action="" method="POST">
        ID da Pergunta: <input type="text" name="idPergunta" required>
        <br><br>
        Nova Pergunta: <input type="text" name="novaPergunta" required>
        <br><br>
        A: <input type="text" name="novaEscolhaA" required>
        <br><br>
        B: <input type="text" name="novaEscolhaB" required>
        <br><br>
        C: <input type="text" name="novaEscolhaC" required>
        <br><br>
        D: <input type="text" name="novaEscolhaD" required>
        <br><br>
        Nova Resposta Correta:
        <select name="novaOpcaoCorreta" required>
            <option value="a">A</option>
            <option value="b">B</option>
            <option value="c">C</option>
            <option value="d">D</option>
        </select>
        <br><br>
        <input type="submit" value="Alterar Pergunta">
    </form>
    <p><?php echo $mensagemAlteracao; ?></p>
</body>
</html>
