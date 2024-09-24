<?php

$mensagemCadastro = "";

function cadastrarUsuario($nomeUser, $emailUser, $senhaUser) {
    $nomeArquivoUsuarios = 'usuarios.txt';
    
    $arquivoAberto = fopen($nomeArquivoUsuarios, 'a');
    
    if ($arquivoAberto) {
        $conteudo = "Nome: $nomeUser | Email: $emailUser | Senha: $senhaUser\n";
        
        fwrite($arquivoAberto, $conteudo);
        
        fclose($arquivoAberto);
        
        return "Usuário cadastrado com sucesso!";
    } else {
        return "Erro ao abrir o arquivo para cadastro.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeUser = $_POST["nome"];
    $emailUser = $_POST["email"];
    $senhaUser = $_POST["senha"];
    
    $mensagemCadastro = cadastrarUsuario($nomeUser, $emailUser, $senhaUser);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <h1>Cadastrar Usuário</h1>
    <form action="" method="POST">
        Nome: <input type="text" name="nome" required>
        <br><br>
        Email: <input type="text" name="email" required>
        <br><br>
        Senha: <input type="text" name="senha" required>
        <br><br>
        <input type="submit" value="Cadastrar Usuário">
    </form>
    <p><?php echo $mensagemCadastro; ?></p>
</body>
</html>
