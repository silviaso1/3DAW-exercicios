<?php
function cadastrarUsuario($nomeUser, $emailUser, $senhaUser) {
    $conexao = new mysqli("localhost", "root", "", "usuarioseperguntas");

    if ($conexao->connect_error) {
        return "Erro ao conectar ao banco de dados.";
    }
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nomeUser', '$emailUser', '$senhaUser')";

    if ($conexao->query($sql) === TRUE) {
        $conexao->close();
        return "Usuário cadastrado com sucesso!";
    } else {
        $conexao->close();
        return "Erro ao cadastrar usuário.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeUser = $_POST["nome"];
    $emailUser = $_POST["email"];
    $senhaUser = $_POST["senha"];
    
    if ($nomeUser && $emailUser && $senhaUser) {
        echo cadastrarUsuario($nomeUser, $emailUser, $senhaUser);
    } else {
        echo "Erro: Todos os campos são obrigatórios.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>
