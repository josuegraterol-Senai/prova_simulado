<?php
require_once 'conection.php';
require_once 'includes.php';
checkAuth();

$message = "";
$messageType = "";

// Lógica de Deletar
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if (mysqli_query($con, "DELETE FROM produtos WHERE id = $id")) {
        $message = "Produto excluído com sucesso!";
        $messageType = "success";
    }
}

// Lógica de Salvar (Create/Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $especs = mysqli_real_escape_string($con, $_POST['especificacoes']);
    $minimo = (int)$_POST['estoque_minimo'];
    
    if (empty($nome) || empty($especs)) {
        $message = "Por favor, preencha todos os campos obrigatórios.";
        $messageType = "danger";
    } else {
        if ($_POST['action'] === 'create') {
            $sql = "INSERT INTO produtos (nome, especificacoes, estoque_minimo, estoque_atual) VALUES ('$nome', '$especs', $minimo, 0)";
            if (mysqli_query($con, $sql)) {
                $message = "Produto cadastrado com sucesso!";
                $messageType = "success";
            }
        } else if ($_POST['action'] === 'update') {
            $id = (int)$_POST['id'];
            $sql = "UPDATE produtos SET nome='$nome', especificacoes='$especs', estoque_minimo=$minimo WHERE id=$id";
            if (mysqli_query($con, $sql)) {
                $message = "Produto atualizado com sucesso!";
                $messageType = "success";
            }
        }
    }
}

// Busca
$search = "";
$where = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $where = " WHERE nome LIKE '%$search%' OR especificacoes LIKE '%$search%'";
}

$produtos = mysqli_query($con, "SELECT * FROM produtos $where ORDER BY id DESC");

// Pegar dados para edição
$editData = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $editRes = mysqli_query($con, "SELECT * FROM produtos WHERE id = $editId");
    $editData = mysqli_fetch_assoc($editRes);
}

renderHeader("Produtos");
?>

<h2>Gerenciamento de Produtos</h2>
<p><a href="dashboard.php">Voltar ao Início</a></p>

<?php if ($message): ?>
    <p style="color: <?php echo $messageType === 'success' ? 'green' : 'red'; ?>; font-weight: bold;">
        <?php echo $message; ?>
    </p>
<?php endif; ?>

<fieldset>
    <legend><?php echo $editData ? 'Editar Produto' : 'Novo Produto'; ?></legend>
    <form action="produtos.php" method="POST">
        <input type="hidden" name="action" value="<?php echo $editData ? 'update' : 'create'; ?>">
        <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
        <?php endif; ?>
        
        <label>Nome do Produto:</label><br>
        <input type="text" name="nome" value="<?php echo $editData ? htmlspecialchars($editData['nome']) : ''; ?>" required><br><br>
        
        <label>Especificações:</label><br>
        <textarea name="especificacoes" rows="4" cols="50" required><?php echo $editData ? htmlspecialchars($editData['especificacoes']) : ''; ?></textarea><br><br>
        
        <label>Estoque Mínimo:</label><br>
        <input type="number" name="estoque_minimo" value="<?php echo $editData ? $editData['estoque_minimo'] : '0'; ?>" min="0"><br><br>
        
        <button type="submit"><?php echo $editData ? 'Salvar Alterações' : 'Cadastrar Produto'; ?></button>
        <?php if ($editData): ?>
            <a href="produtos.php">Cancelar</a>
        <?php endif; ?>
    </form>
</fieldset>

<hr>

<h3>Produtos Cadastrados</h3>
<form action="produtos.php" method="GET">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Buscar produto...">
    <button type="submit">Buscar</button>
    <?php if ($search): ?>
        <a href="produtos.php">Limpar</a>
    <?php endif; ?>
</form>

<br>

<table border="1" cellpadding="5" width="100%">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Especificações</th>
            <th>Mínimo</th>
            <th>Atual</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($p = mysqli_fetch_assoc($produtos)): ?>
        <tr>
            <td><strong><?php echo htmlspecialchars($p['nome']); ?></strong></td>
            <td><?php echo htmlspecialchars($p['especificacoes']); ?></td>
            <td><?php echo $p['estoque_minimo']; ?></td>
            <td style="<?php echo $p['estoque_atual'] < $p['estoque_minimo'] ? 'color: red; font-weight: bold;' : ''; ?>">
                <?php echo $p['estoque_atual']; ?>
            </td>
            <td>
                <a href="produtos.php?edit=<?php echo $p['id']; ?>">Editar</a> | 
                <a href="produtos.php?delete=<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php renderFooter(); ?>
