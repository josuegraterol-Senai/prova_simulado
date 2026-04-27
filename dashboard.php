<?php
require_once 'conection.php';
require_once 'includes.php';
checkAuth();

// Pegar algumas estatísticas básicas
$totalProdutos = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM produtos"))['count'];
$baixoEstoque = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM produtos WHERE estoque_atual < estoque_minimo"))['count'];
$movimentacoesRecent = mysqli_query($con, "SELECT m.*, p.nome as p_nome FROM movimentacoes m JOIN produtos p ON m.produto_id = p.id ORDER BY m.data_movimentacao DESC LIMIT 5");

renderHeader("Dashboard");
?>

<h2>Resumo do Sistema</h2>

<ul>
    <li><strong>Total de Produtos:</strong> <?php echo $totalProdutos; ?></li>
    <li><strong>Alerta de Estoque Baixo:</strong> <span style="color: red;"><?php echo $baixoEstoque; ?></span></li>
    <li><strong>Movimentações no Mês:</strong> 
        <?php 
        $movMes = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM movimentacoes WHERE MONTH(data_movimentacao) = MONTH(CURRENT_DATE())"))['count'];
        echo $movMes;
        ?>
    </li>
</ul>

<h3>Ações Rápidas</h3>
<p>
    <a href="produtos.php">Ir para Cadastro de Produtos</a> | 
    <a href="gestao.php">Ir para Gestão de Estoque</a>
</p>

<h3>Últimas 5 Movimentações</h3>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Tipo</th>
            <th>Quantidade</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($mov = mysqli_fetch_assoc($movimentacoesRecent)): ?>
        <tr>
            <td><?php echo htmlspecialchars($mov['p_nome']); ?></td>
            <td><?php echo ucfirst($mov['tipo']); ?></td>
            <td><?php echo $mov['quantidade']; ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($mov['data_movimentacao'])); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php renderFooter(); ?>
