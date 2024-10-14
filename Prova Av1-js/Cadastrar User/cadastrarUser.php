<?php
function cadastrarUsuario($nomeUser, $emailUser, $senhaUser) {
    $nomeArquivoUsuarios = 'usuarios.txt';
    
    // Verifica se o arquivo pode ser aberto para escrita
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
    
    if ($nomeUser && $emailUser && $senhaUser) {
        $mensagemCadastro = cadastrarUsuario($nomeUser, $emailUser, $senhaUser);
        echo $mensagemCadastro;
    } else {
        echo "Erro: Todos os campos são obrigatórios.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>
