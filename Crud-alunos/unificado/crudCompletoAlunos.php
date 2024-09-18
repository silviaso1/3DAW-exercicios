<?php

// esse codigo é a união de todo o crud. fiz para deixar mais prático a visualização em uma só página 
$msg = "";
$listaAlunos = [];
$totalAlunos = 0;

carregarAlunos();
processarFormulario();

function carregarAlunos() {
    global $listaAlunos, $totalAlunos;
    if (file_exists("alunos.txt")) {
        $arquivo = fopen("alunos.txt", "r") or die("Erro ao abrir arquivo");
        while (($linha = fgets($arquivo)) !== false) {
            $linha = trim($linha);
            if ($linha != "" && $linha != "nome;cpf;matricula;nascimento") {
                $listaAlunos[] = explode(";", $linha);
                $totalAlunos++;
            }
        }
        fclose($arquivo);
    }
}

function salvarAlunos() {
    global $listaAlunos, $totalAlunos;
    $arquivo = fopen("alunos.txt", "w") or die("Erro ao abrir arquivo");
    fwrite($arquivo, "nome;cpf;matricula;nascimento\n");
    for ($i = 0; $i < $totalAlunos; $i++) {
        fwrite($arquivo, implode(";", $listaAlunos[$i]) . "\n");
    }
    fclose($arquivo);
}

function adicionarAluno($nome, $cpf, $matricula, $nascimento) {
    global $listaAlunos, $totalAlunos;
    $listaAlunos[$totalAlunos] = [$nome, $cpf, $matricula, $nascimento];
    $totalAlunos++;
    salvarAlunos();
}

function atualizarAluno($indice, $nome, $cpf, $matricula, $nascimento) {
    global $listaAlunos;
    if ($indice != "") {
        $listaAlunos[$indice] = [$nome, $cpf, $matricula, $nascimento];
        salvarAlunos();
    }
}

function excluirAluno($indice) {
    global $listaAlunos, $totalAlunos;
    if ($indice != "") {
        $temp = [];
        $novoTamanho = 0;
        for ($i = 0; $i < $totalAlunos; $i++) {
            if ($i != $indice) {
                $temp[$novoTamanho] = $listaAlunos[$i];
                $novoTamanho++;
            }
        }
        $listaAlunos = $temp;
        $totalAlunos = $novoTamanho;
        salvarAlunos();
    }
}

function processarFormulario() {
    global $msg, $listaAlunos, $totalAlunos;
    $nome = $_POST["nome"] ?? "";
    $cpf = $_POST["cpf"] ?? "";
    $matricula = $_POST["matricula"] ?? "";
    $nascimento = $_POST["nascimento"] ?? "";
    $indice = $_POST["indice"] ?? "";
    $opcao = $_POST["opcao"] ?? "";
    $buscarNome = $_POST["buscar_nome"] ?? "";
    $listarTodos = $_POST["listar_todos"] ?? "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($opcao == "adicionar") {
            adicionarAluno($nome, $cpf, $matricula, $nascimento);
            $msg = "Aluno cadastrado com sucesso!";
        }

        if ($opcao == "atualizar") {
            atualizarAluno($indice, $nome, $cpf, $matricula, $nascimento);
            $msg = "Aluno atualizado com sucesso!";
        }

        if ($opcao == "excluir") {
            excluirAluno($indice);
            $msg = "Aluno excluído com sucesso!";
        }

        if ($opcao == "buscar") {
            $listaAlunos = [];
            $totalAlunos = 0;
            if ($listarTodos == "sim") {
                carregarAlunos();
            } else {
                if (file_exists("alunos.txt")) {
                    $arquivo = fopen("alunos.txt", "r") or die("Erro ao abrir arquivo");
                    while (($linha = fgets($arquivo)) !== false) {
                        $linha = trim($linha);
                        if ($linha != "" && $linha != "nome;cpf;matricula;nascimento") {
                            $dados = explode(";", $linha);
                            if ($dados[0] == $buscarNome) {
                                $listaAlunos[] = $dados;
                                $totalAlunos++;
                                break; 
                            }
                        }
                    }
                    fclose($arquivo);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Listagem de Alunos</title>
    <style>
            body {
        font-family: 'Roboto', sans-serif;
        background-color: #f5f7f9;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .container {
        max-width: 900px;
        margin: 20px auto;
        padding: 30px;
        border-radius: 8px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1, h2 {
        color: #444;
        margin-bottom: 20px;
        font-size: 28px;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        font-weight: 600;
    }

    form {
        margin-bottom: 20px;
    }

    input[type="text"], input[type="submit"], button {
        padding: 14px;
        margin: 5px 0;
        border-radius: 6px;
        border: 1px solid #ddd;
        font-size: 16px;
        width: calc(100% - 28px); 
    }

    input[type="text"]:focus {
        border-color: #007bff;
        outline: none;
    }

    input[type="submit"], button {
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover, button:hover {
        background-color: #0056b3;
    }

    button.delete {
        background-color: #dc3545;
    }

    button.delete:hover {
        background-color: #c82333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 14px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    p {
        color: #666;
        font-size: 16px;
    }

    .hidden {
        display: none;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group input[type="text"] {
        width: calc(100% - 28px);
    }

    .form-actions {
        display: flex;
        justify-content: flex-start;
        gap: 10px;
    }

    h1::before {
        content: "";
        display: block;
        width: 50px;
        height: 5px;
        background-color: #007bff;
        margin-bottom: 15px;
    }

    .container {
        border: 1px solid #ddd;
        border-radius: 8px;
        background: linear-gradient(to right, #ffffff, #f5f7f9);
    }

    .container h1, .container h2 {
        color: #222;
    }

    input[type="text"], input[type="submit"], button {
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    input[type="text"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    }

    input[type="submit"], button {
        background-color: #007bff;
        color: #fff;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover, button:hover {
        background-color: #0056b3;
    }

    button.delete {
        background-color: #dc3545;
    }

    button.delete:hover {
        background-color: #c82333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 14px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .hidden {
        display: none;
    }

    .container {
        max-width: 900px;
        margin: 20px auto;
        padding: 20px;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    }

    </style>
    <script>
        function mostrarFormulario(tipo) {
            document.getElementById('formBuscarTodos').classList.add('hidden');
            document.getElementById('formBuscarNome').classList.add('hidden');
            if (tipo === 'todos') {
                document.getElementById('formBuscarTodos').classList.remove('hidden');
            } else if (tipo === 'nome') {
                document.getElementById('formBuscarNome').classList.remove('hidden');
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Criar Aluno</h1>
    <form action="" method="POST">
        <input type="hidden" name="opcao" value="adicionar">
        Nome: <input type="text" name="nome"><br><br>
        CPF: <input type="text" name="cpf"><br><br>
        Matrícula: <input type="text" name="matricula"><br><br>
        Data de Nascimento: <input type="text" name="nascimento"><br><br>
        <input type="submit" value="Criar Novo Aluno">
    </form>
    <p><?php echo $msg; ?></p>
</div>

<div class="container">
    <h2>Buscar Aluno</h2>
    <form action="" method="POST">
        <input type="hidden" name="opcao" value="buscar">
        <label>
            <input type="radio" name="tipo_busca" value="todos" onclick="mostrarFormulario('todos')"> Listar todos os alunos
        </label><br>
        <label>
            <input type="radio" name="tipo_busca" value="nome" onclick="mostrarFormulario('nome')"> Buscar por nome
        </label><br><br>
        <div id="formBuscarTodos" class="hidden">
            <input type="hidden" name="listar_todos" value="sim">
            <input type="submit" value="Buscar Todos">
        </div>
        <div id="formBuscarNome" class="hidden">
            Nome: <input type="text" name="buscar_nome"><br><br>
            <input type="submit" value="Buscar Aluno">
        </div>
    </form>
</div>

<div class="container">
    <h2>Alunos Cadastrados</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Matrícula</th>
            <th>Data de Nascimento</th>
            <th>Ações</th>
        </tr>
        <?php
        if ($totalAlunos == 0) {
            echo "<tr><td colspan='5'>Nenhum aluno encontrado.</td></tr>";
        } else {
            for ($i = 0; $i < $totalAlunos; $i++) {
                echo "<tr>
                        <td>{$listaAlunos[$i][0]}</td>
                        <td>{$listaAlunos[$i][1]}</td>
                        <td>{$listaAlunos[$i][2]}</td>
                        <td>{$listaAlunos[$i][3]}</td>
                        <td>
                            <form action='' method='POST'>
                                <input type='hidden' name='opcao' value='editar'>
                                <input type='hidden' name='indice' value='$i'>
                                <input type='submit' value='Editar'>
                            </form>
                            <form action='' method='POST' onsubmit='return confirm(\"Tem certeza que deseja excluir este aluno?\");'>
                                <input type='hidden' name='opcao' value='excluir'>
                                <input type='hidden' name='indice' value='$i'>
                                <input type='submit' value='Excluir'>
                            </form>
                        </td>
                      </tr>";
            }
        }
        ?>
    </table>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["opcao"] == 'editar') {
    $indice = $_POST["indice"];
    if ($indice != "" && $indice < $totalAlunos) {
        $aluno = $listaAlunos[$indice];
        echo "<div class='container'>
                <h1>Editar Aluno</h1>
                <form action='' method='POST'>
                    <input type='hidden' name='opcao' value='atualizar'>
                    <input type='hidden' name='indice' value='$indice'>
                    Nome: <input type='text' name='nome' value='{$aluno[0]}'><br><br>
                    CPF: <input type='text' name='cpf' value='{$aluno[1]}'><br><br>
                    Matrícula: <input type='text' name='matricula' value='{$aluno[2]}'><br><br>
                    Data de Nascimento: <input type='text' name='nascimento' value='{$aluno[3]}'><br><br>
                    <input type='submit' value='Atualizar Aluno'>
                </form>
                <p>$msg</p>
              </div>";
    }
}
?>

</body>
</html>
