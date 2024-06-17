<?php
session_start();

// Inclui o arquivo de configuração do banco de dados
include_once('config.php');

// Verifica se o formulário foi enviado
if (isset($_POST['submit'])) {
    // Obtém os dados do formulário e sanitiza
    $name = mysqli_real_escape_string($conexao, $_POST['name']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nasc']);

    // Prepara a consulta SQL para inserir os dados no banco de dados
    $sql = "INSERT INTO usuario (name, senha, email, telefone, data_nasc) 
            VALUES ('$name', '$senha', '$email', '$telefone', '$data_nascimento')";

    // Executa a consulta
    if (mysqli_query($conexao, $sql)) {
        // Redireciona para a página de login após o cadastro bem-sucedido
        header('Location: index.php');
        exit; // Termina a execução do script após o redirecionamento
    } else {
        // Se houver algum erro na execução da consulta, exibe uma mensagem de erro
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="formulario.css">
</head>
<body>
    <div class="box">
        <form action="cadastro.php" method="POST">
            <label for="name">Nome Completo</label>
            <input type="text" name="name" id="name" required>
            <label for="telefone">Telefone</label>
            <input type="tel" name="telefone" id="telefone" required>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" required>
            <label for="data_nasc">Data de Nascimento</label>
            <input type="date" name="data_nasc" id="data_nasc" required>
            <input type="submit" name="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>
