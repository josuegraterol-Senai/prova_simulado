<?php
session_start();
require_once 'conection.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Em um sistema real usaríamos password_verify, mas conforme o script de população, a senha está em texto puro
        if ($senha === $user['senha']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nome'] = $user['nome'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Senha incorreta.";
        }
    } else {
        $error = "Usuário não encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAEP System</title>
</head>
<body>
    <h1>Acesso ao Sistema</h1>
    <p>Por favor, identifique-se para continuar.</p>
    
    <?php if ($error): ?>
        <p style="color: red; font-weight: bold;">ERRO: <?php echo $error; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div>
            <label for="email">E-mail:</label><br>
            <input type="email" id="email" name="email" required>
        </div>
        <br>
        <div>
            <label for="senha">Senha:</label><br>
            <input type="password" id="senha" name="senha" required>
        </div>
        <br>
        <button type="submit">Entrar</button>
    </form>
    <br>
    <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
</body>
</html>
