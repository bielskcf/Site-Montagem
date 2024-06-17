<?php

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se todos os campos necessários foram enviados
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['telefone']) && isset($_POST['data_nascimento'])) {

        // Dados de conexão com o banco de dados
        $servidor = "localhost";
        $usuario = "root";
        $senhaBD = "";
        $dbname = "bdmontagem";

        // Cria uma conexão com o banco de dados
        $conecta = new mysqli($servidor, $usuario, $senhaBD, $dbname);

        // Verifica se a conexão foi estabelecida com sucesso
        if($conecta->connect_error) {
            die('Erro de conexão: ' . $conecta->connect_error);
        }

        // Prepara a consulta SQL usando instrução preparada
        $sql = "INSERT INTO usuario (name, email, senha, telefone, data_nascimento) VALUES (?, ?, ?, ?, ?)";
        
        // Prepara a instrução SQL para execução
        $stmt = $conecta->prepare($sql);

        // Verifica se a preparação foi bem-sucedida
        if($stmt) {
            // Liga os parâmetros aos marcadores de posição na consulta SQL
            $stmt->bind_param("sssss", $nome, $email, $telefone, $data_nascimento);

            // Obtém os valores dos campos do formulário
            $nome = $_POST['name'];
            $email = $_POST['email'];
            $senhaUsuario = $_POST['senha']; 
            $telefone = $_POST['telefone'];
            $data_nascimento = $_POST['data_nasc'];

        

            // Executa a instrução preparada para inserir os dados
            if($stmt->execute()) {
                echo "<script>alert('Usuário cadastrado com sucesso');</script>";
                header('Location:SiteMontador/sistema.php');
                exit;
            } else {
                echo "<script>alert('Erro ao cadastrar usuário');</script>";
                echo "Erro: " . $stmt->error;
            }

            // Fecha a instrução preparada
            $stmt->close();
        } else {
            echo "<script>alert('Erro na preparação da consulta');</script>";
        }

        // Fecha a conexão com o banco de dados
        $conecta->close();    
    } else {
        echo "<script>alert('Todos os campos são obrigatórios');</script>";
    }
}

?>