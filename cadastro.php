<?php
require_once 'conection.php';

$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $senha = $_POST['senha']; // Em sistemas reais usaríamos password_hash

    if (empty($nome) || empty($email) || empty($senha)) {
        $message = "Por favor, preencha todos os campos.";
        $messageType = "red";
    } else {
        // Verificar se o e-mail já existe
        $checkEmail = mysqli_query($con, "SELECT id FROM usuarios WHERE email = '$email'");
        if (mysqli_num_rows($checkEmail) > 0) {
            $message = "Este e-mail já está cadastrado.";
            $messageType = "red";
        } else {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
            if (mysqli_query($con, $sql)) {
                $message = "Usuário cadastrado com sucesso! Redirecionando para o login...";
                $messageType = "green";
                header("Refresh: 2; url=login.php");
            } else {
                $message = "Erro ao cadastrar: " . mysqli_error($con);
                $messageType = "red";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - SAEP System</title>
</head>
<body>
    <h1>Criar Nova Conta</h1>
    <p>Preencha os dados abaixo para se cadastrar como operador do almoxarifado.</p>

    <?php if ($message): ?>
        <p style="color: <?php echo $messageType; ?>; font-weight: bold;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="cadastro.php" method="POST">
        <div>
            <label>Nome Completo:</label><br>
            <input type="text" name="nome" required>
        </div>
        <br>
        <div>
            <label>E-mail:</label><br>
            <input type="email" name="email" required>
        </div>
        <br>
        <div>
            <label>Senha:</label><br>
            <input type="password" name="senha" required>
        </div>
        <br>
        <button type="submit">Cadastrar</button>
    </form>

    <p>Já tem uma conta? <a href="login.php">Voltar para o Login</a></p>
</body>
</html>
