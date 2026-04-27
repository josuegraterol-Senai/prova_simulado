<?php
require_once 'conection.php';
require_once 'includes.php';
checkAuth();

$alert = "";
$alertType = "";

// Lógica de Movimentação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movimentar'])) {
    $produtoId = (int)$_POST['produto_id'];
    $tipo = $_POST['tipo'];
    $quantidade = (int)$_POST['quantidade'];
    $data = $_POST['data_movimentacao'];
    $usuarioId = $_SESSION['user_id'];

    if ($quantidade <= 0) {
        $alert = "Quantidade deve ser maior que zero.";
        $alertType = "danger";
    } else {
        // Atualizar estoque atual
        $op = ($tipo === 'entrada') ? "+" : "-";
        $updateSql = "UPDATE produtos SET estoque_atual = estoque_atual $op $quantidade WHERE id = $produtoId";
        
        if (mysqli_query($con, $updateSql)) {
            // Registrar histórico
            $histSql = "INSERT INTO movimentacoes (produto_id, usuario_id, tipo, quantidade, data_movimentacao) 
                        VALUES ($produtoId, $usuarioId, '$tipo', $quantidade, '$data')";
            mysqli_query($con, $histSql);

            $alert = "Movimentação de $tipo realizada com sucesso!";
            $alertType = "success";

            // Verificar estoque mínimo se for saída
            if ($tipo === 'saída') {
                $pRes = mysqli_query($con, "SELECT nome, estoque_atual, estoque_minimo FROM produtos WHERE id = $produtoId");
                $pData = mysqli_fetch_assoc($pRes);
                if ($pData['estoque_atual'] < $pData['estoque_minimo']) {
                    $alert .= " <br><strong>ATENÇÃO:</strong> O produto '" . $pData['nome'] . "' está abaixo do estoque mínimo!";
                    $alertType = "warning";
                }
            }
        }
    }
}

// Buscar produtos
$result = mysqli_query($con, "SELECT * FROM produtos");
$produtosArray = [];
while ($row = mysqli_fetch_assoc($result)) {
    $produtosArray[] = $row;
}

// Algoritmo de Ordenação: Bubble Sort (Conforme requisito 7.1.1)
function bubbleSortByName(&$array) {
    $n = count($array);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if (strcasecmp($array[$j]['nome'], $array[$j+1]['nome']) > 0) {
                $temp = $array[$j];
                $array[$j] = $array[$j+1];
                $array[$j+1] = $temp;
            }
        }
    }
}

bubbleSortByName($produtosArray);

renderHeader("Gestão de Estoque");
?>

<h2>Gestão de Entrada e Saída</h2>
<p><a href="dashboard.php">Voltar ao Início</a></p>

<?php if ($alert): ?>
    <div style="padding: 10px; border: 2px solid <?php echo strpos($alertType, 'danger') !== false || strpos($alertType, 'warning') !== false ? 'red' : 'green'; ?>; margin-bottom: 10px;">
        <?php echo $alert; ?>
    </div>
<?php endif; ?>

<fieldset>
    <legend>Registrar Movimentação</legend>
    <form action="gestao.php" method="POST">
        <label>Produto:</label><br>
        <select name="produto_id" required>
            <option value="">-- Selecione um produto --</option>
            <?php foreach ($produtosArray as $p): ?>
                <option value="<?php echo $p['id']; ?>">
                    <?php echo htmlspecialchars($p['nome']); ?> (Estoque: <?php echo $p['estoque_atual']; ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        
        <label>Tipo de Operação:</label><br>
        <input type="radio" name="tipo" value="entrada" checked> Entrada
        <input type="radio" name="tipo" value="saída"> Saída
        <br><br>

        <label>Quantidade:</label><br>
        <input type="number" name="quantidade" min="1" required>
        <br><br>

        <label>Data da Movimentação:</label><br>
        <input type="datetime-local" name="data_movimentacao" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
        <br><br>

        <button type="submit" name="movimentar">Confirmar Movimentação</button>
    </form>
</fieldset>

<br><hr>

<h3>Estoque Atual (Ordenado por Nome - Bubble Sort)</h3>
<table border="1" cellpadding="5" width="100%">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Estoque Mínimo</th>
            <th>Estoque Atual</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produtosArray as $p): ?>
        <tr>
            <td><?php echo htmlspecialchars($p['nome']); ?></td>
            <td><?php echo $p['estoque_minimo']; ?></td>
            <td><?php echo $p['estoque_atual']; ?></td>
            <td style="<?php echo $p['estoque_atual'] < $p['estoque_minimo'] ? 'color: red; font-weight: bold;' : 'color: green;'; ?>">
                <?php echo $p['estoque_atual'] < $p['estoque_minimo'] ? 'CRÍTICO' : 'NORMAL'; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php renderFooter(); ?>
