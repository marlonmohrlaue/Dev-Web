<?php
require_once("../classes/Categorias.class.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$categoria = null;

// Se um ID válido foi passado, busca os dados da categoria no banco de dados
if ($id > 0) {
    $categoriaDados = Categorias::listar(1, $id);
    $categoria = $categoriaDados ? $categoriaDados[0] : null;
}

// Processa os dados do formulário (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : "";

    try {
        $categoria = new Categorias($id, $descricao);

        if ($id > 0) {
            $categoria->alterar(); // Se o ID existir, altera a categoria
        } else {
            $categoria->incluir(); // Se o ID não existir, insere uma nova categoria
        }

        header('Location: index.php'); // Redireciona para a lista de categorias após sucesso
        exit;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Categorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h2>Cadastro de Categorias</h2>
        <form action="categoria.php" method="post" class="row g-3">
            <div class="col-md-12">
                <label for="descricao" class="form-label">Descrição:</label>
                <input type="text" name="descricao" id="descricao" class="form-control" value="<?= $categoria ? $categoria['descricao'] : "" ?>" required>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

            <input type="hidden" name="id" value="<?= $categoria ? $categoria['id'] : "" ?>" />
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
