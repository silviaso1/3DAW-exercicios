<?php
$mensagemAlteracao = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPergunta = trim($_POST["idPergunta"]);
    $novaPergunta = trim($_POST["novaPergunta"]);
    $novaEscolhaA = trim($_POST["novaEscolhaA"]);
    $novaEscolhaB = trim($_POST["novaEscolhaB"]);
    $novaEscolhaC = trim($_POST["novaEscolhaC"]);
    $novaEscolhaD = trim($_POST["novaEscolhaD"]);
    $novaOpcaoCorreta = trim($_POST["novaOpcaoCorreta"]);
    $mensagemAlteracao = alterarPerguntaEMultiplasEscolhas($idPergunta, $novaPergunta, $novaEscolhaA, $novaEscolhaB, $novaEscolhaC, $novaEscolhaD, $novaOpcaoCorreta);
}


function alterarPerguntaEMultiplasEscolhas($idPergunta, $novaPergunta, $novaEscolhaA, $novaEscolhaB, $novaEscolhaC, $novaEscolhaD, $novaOpcaoCorreta) {
    $nomeArquivoPerguntas = 'perguntas_multiplas_escolhas.txt';
    if (!file_exists($nomeArquivoPerguntas)) {
        return "Erro: O arquivo de perguntas não foi encontrado.";
    }
    $linhasArquivo = file($nomeArquivoPerguntas, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $perguntaAlterada = false;

    for ($i = 0; $i < count($linhasArquivo); $i++) {
        if (strpos($linhasArquivo[$i], "ID: $idPergunta ") === 0) {
            $linhasArquivo[$i] = "ID: $idPergunta | Pergunta: $novaPergunta | a) $novaEscolhaA | b) $novaEscolhaB | c) $novaEscolhaC | d) $novaEscolhaD | Correta: $novaOpcaoCorreta";
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
            fwrite($arquivoAbertoParaEscrita, $linhaAlterada . PHP_EOL);
        }
        fclose($arquivoAbertoParaEscrita);
        return "Pergunta alterada com sucesso!";
    } else {
        return "Erro ao salvar a alteração.";
    }
}
