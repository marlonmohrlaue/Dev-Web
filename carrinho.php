<?php
session_start();
require_once("classes/Livro.class.php");
require_once("classes/Database.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'adicionar') {
    // Recuperar dados do formulário
    $idLivro = $_POST['idLivro'];
    $preco = $_POST['preco'];
    $quantidade = 1;  // Começamos com quantidade 1. Você pode permitir que o usuário escolha a quantidade.

    // Verificar se o carrinho já existe na sessão
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Verificar se o livro já está no carrinho
    $livroEncontrado = false;
    foreach ($_SESSION['carrinho'] as &$item) {
        if ($item['idLivro'] == $idLivro) {
            // Se já estiver no carrinho, aumente a quantidade
            $item['quantidade'] += $quantidade;
            $livroEncontrado = true;
            break;
        }
    }

    // Se não encontrar o livro no carrinho, adicioná-lo
    if (!$livroEncontrado) {
        $_SESSION['carrinho'][] = [
            'idLivro' => $idLivro,
            'quantidade' => $quantidade,
            'preco' => $preco
        ];
    }

    // Redirecionar para a página do carrinho
    header('Location: carrinho.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Carrinho de Compras</h2>

    <?php if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Livro</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalCarrinho = 0;
                foreach ($_SESSION['carrinho'] as $item) {
                    $livro = Livro::listar(1, $item['idLivro']); // Obtém dados do livro
                    $livro = $livro[0]; // Só existe um livro, então pegamos o primeiro
                    $totalItem = $item['quantidade'] * $item['preco'];
                    $totalCarrinho += $totalItem;
                    echo "<tr>";
                    echo "<td>" . $livro['titulo'] . "</td>";
                    echo "<td>" . $item['quantidade'] . "</td>";
                    echo "<td>R$ " . number_format($item['preco'], 2, ',', '.') . "</td>";
                    echo "<td>R$ " . number_format($totalItem, 2, ',', '.') . "</td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>R$ <?= number_format($totalCarrinho, 2, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>

    <a href="livro/index.php" class="btn btn-secondary">Voltar à Loja</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
