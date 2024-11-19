<?php
require_once("../classes/Autor.class.php");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Busca o autor pelo ID
    $autor = Autor::listar(1, $id); // Lista o autor com o ID fornecido
    if (count($autor) > 0) {
        $autor = $autor[0]; // Obtém o primeiro autor
    } else {
        echo "Autor não encontrado!";
        exit;
    }
} else {
    echo "ID do autor não fornecido.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : "";

    try {
        // Cria um objeto Autor com os dados fornecidos
        $autorEditado = new Autor($id, $nome, $sobrenome);
        $autorEditado->alterar(); // Chama o método para atualizar as informações no banco de dados

        echo "Autor atualizado com sucesso!";
        header('Location: index.php'); // Redireciona para a listagem de autores
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
    <title>Editar Autor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Editar Autor</h2>
        <form action="editar.php?id=<?= $autor['id'] ?>" method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= $autor['nome'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="sobrenome" class="form-label">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?= $autor['sobrenome'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
