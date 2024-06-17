<?php
session_start();
include_once('config.php');

// Verifica se os dados do formulário foram recebidos corretamente
if (isset($_POST['email']) && isset($_POST['senha'])) {
    // Recupera os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Use uma consulta preparada para evitar SQL injection
    $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se a consulta retornou algum resultado
    if ($result->num_rows > 0) {
        // Login bem-sucedido
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        header('Location: sistema.php');
        exit();
    } else {
        // Falha no login
        session_unset();
        session_destroy();
        echo "<script>
        alert('Login ou senha incorretos.');
        window.location.href = 'index.php';
        </script>";
        exit();
    }

    $stmt->close();
} else {
    // Caso os dados do formulário não tenham sido enviados
    header('Location: index.php');
    exit();
}

$conexao->close();
?>


