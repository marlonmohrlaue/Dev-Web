<?php
require_once("../classes/Categorias.class.php");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $categoria = Categorias::listar(1, $id); // Busca a categoria pelo ID
    if (count($categoria) > 0) {
        $categoria = $categoria[0]; // Obtém a primeira categoria (já que estamos buscando por ID)
    } else {
        echo "Categoria não encontrada!";
        exit;
    }
} else {
    echo "ID da categoria não fornecido.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : "";
    try {
        $categoriaEditada = new Categorias($id, $descricao);
        $categoriaEditada->alterar();
        echo "Categoria atualizada com sucesso!";
        header('Location: index.php'); // Redireciona para a listagem de categorias
        exit;
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Editar Categoria</h2>
        <form action="editar_categoria.php?id=<?= $categoria['id'] ?>" method="post">
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" value="<?= $categoria['descricao'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
