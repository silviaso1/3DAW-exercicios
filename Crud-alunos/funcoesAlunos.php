<?php
function carregarAlunos() {
    $listaAlunos = [];
    if (file_exists("alunos.txt")) {
        $arquivo = fopen("alunos.txt", "r") or die("Erro ao abrir arquivo");
        while (($linha = fgets($arquivo)) !== false) {
            $linha = trim($linha);
            if ($linha != "" && $linha != "nome;cpf;matricula;nascimento") {
                $listaAlunos[] = explode(";", $linha);
            }
        }
        fclose($arquivo);
    }
    return $listaAlunos;
}

function salvarAlunos($listaAlunos) {
    $arquivo = fopen("alunos.txt", "w") or die("Erro ao abrir arquivo");
    fwrite($arquivo, "nome;cpf;matricula;nascimento\n");
    foreach ($listaAlunos as $aluno) {
        fwrite($arquivo, implode(";", $aluno) . "\n");
    }
    fclose($arquivo);
}

function adicionarAluno($nome, $cpf, $matricula, $nascimento) {
    $listaAlunos = carregarAlunos();
    $listaAlunos[] = [$nome, $cpf, $matricula, $nascimento];
    salvarAlunos($listaAlunos);
    return "Aluno cadastrado com sucesso!";
}

function atualizarAluno($indice, $nome, $cpf, $matricula, $nascimento) {
    $listaAlunos = carregarAlunos();
    $listaAlunos[$indice] = [$nome, $cpf, $matricula, $nascimento];
    salvarAlunos($listaAlunos);
    return "Aluno atualizado com sucesso!";
}

function excluirAluno($indice) {
    $listaAlunos = carregarAlunos();
    $novaLista = [];
    $i = 0;
    
    foreach ($listaAlunos as $index => $aluno) {
        if ($index != $indice) {
            $novaLista[$i] = $aluno;
            $i++;
        }
    }
    salvarAlunos($novaLista);
    return "Aluno excluído com sucesso!";
}
?>
