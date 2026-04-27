<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function renderHeader($title) {
    $userName = isset($_SESSION['user_nome']) ? $_SESSION['user_nome'] : 'Usuário';
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?> - SAEP Inventory</title>
    </head>
    <body>
        <header>
            <h1>SAEP System</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a> | 
                <a href="produtos.php">Produtos</a> | 
                <a href="gestao.php">Gestão de Estoque</a> | 
                <span>Olá, <?php echo htmlspecialchars($userName); ?></span> | 
                <a href="logout.php">Sair</a>
            </nav>
        </header>
        <hr>
        <main>
    <?php
}

function renderFooter() {
    ?>
        </main>
        <hr>
        <footer>
            <p>&copy; <?php echo date('Y'); ?> - Sistema de Gestão de Estoque SAEP</p>
        </footer>
    </body>
    </html>
    <?php
}

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}
?>
