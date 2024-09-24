<?php
$mensagemCadastro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $textoPergunta = $_POST["textoPergunta"];
    $textoEscolhaA = $_POST["textoEscolhaA"];
    $textoEscolhaB = $_POST["textoEscolhaB"];
    $textoEscolhaC = $_POST["textoEscolhaC"];
    $textoEscolhaD = $_POST["textoEscolhaD"];
    $opcaoCorreta = $_POST["opcaoCorreta"];
    
    $mensagemCadastro = cadastrarPerguntaEMultiplasEscolhas($textoPergunta, $textoEscolhaA, $textoEscolhaB, $textoEscolhaC, $textoEscolhaD, $opcaoCorreta);
}

function cadastrarPerguntaEMultiplasEscolhas($textoPergunta, $textoEscolhaA, $textoEscolhaB, $textoEscolhaC, $textoEscolhaD, $opcaoCorreta) {
    $nomeArquivoPerguntas = 'perguntas_multiplas_escolhas.txt';
    
    $proximoIdPergunta = 1;
    
    $arquivoAberto = fopen($nomeArquivoPerguntas, 'r');
    if ($arquivoAberto) {
        $conteudoArquivo = "";
        while (!feof($arquivoAberto)) {
            $conteudoArquivo .= fgetc($arquivoAberto);
        }

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

        foreach ($linhasArquivo as $linha) {
            $inicioId = -1;
            $fimId = -1;

            for ($i = 0; $i < strlen($linha) - 4; $i++) {
                if ($linha[$i] == 'I' && $linha[$i + 1] == 'D' && $linha[$i + 2] == ':' && $linha[$i + 3] == ' ') {
                    $inicioId = $i + 4;
                    break;
                }
            }

            if ($inicioId != -1) {
                for ($i = $inicioId; $i < strlen($linha); $i++) {
                    if ($linha[$i] == ' ') {
                        $fimId = $i;
                        break;
                    }
                }
            }

            if ($inicioId != -1 && $fimId != -1) {
                $idExtraido = "";
                for ($i = $inicioId; $i < $fimId; $i++) {
                    $idExtraido .= $linha[$i];
                }
                $idNumerico = (int) $idExtraido;
                if ($idNumerico >= $proximoIdPergunta) {
                    $proximoIdPergunta = $idNumerico + 1;
                }
            }
        }

        fclose($arquivoAberto);
    }

    $arquivoAbertoParaEscrita = fopen($nomeArquivoPerguntas, 'a');
    
    if ($arquivoAbertoParaEscrita) {
        $linhaTextoCadastro = "ID: " . $proximoIdPergunta . " | Pergunta: " . $textoPergunta . " | a) " . $textoEscolhaA . " | b) " . $textoEscolhaB . " | c) " . $textoEscolhaC . " | d) " . $textoEscolhaD . " | Correta: " . $opcaoCorreta . "\n";

        for ($i = 0; $i < strlen($linhaTextoCadastro); $i++) {
            fwrite($arquivoAbertoParaEscrita, $linhaTextoCadastro[$i]);
        }

        fclose($arquivoAbertoParaEscrita);

        return "Pergunta e respostas cadastradas com sucesso!";
    } else {
        return "Erro ao abrir o arquivo.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Múltipla Escolha</title>
</head>
<body>
    <h1>Perguntas de Múltipla Escolha</h1>
    <form action="" method="POST">
        Pergunta: <input type="text" name="textoPergunta" required>
        <br><br>
        A: <input type="text" name="textoEscolhaA" required>
        <br><br>
        B: <input type="text" name="textoEscolhaB" required>
        <br><br>
        C: <input type="text" name="textoEscolhaC" required>
        <br><br>
        D: <input type="text" name="textoEscolhaD" required>
        <br><br>
        Resposta correta:
        <select name="opcaoCorreta" required>
            <option value="a">A</option>
            <option value="b">B</option>
            <option value="c">C</option>
            <option value="d">D</option>
        </select>
        <br><br>
        <input type="submit" value="Cadastrar Pergunta">
    </form>
    <p><?php echo $mensagemCadastro; ?></p>
</body>
</html>
