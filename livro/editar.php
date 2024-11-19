<?php
require_once("../classes/Livro.class.php");
require_once("../classes/Autor.class.php");
require_once("../classes/Categorias.class.php");

$categorias = Categorias::listar(); // Lista todas as categorias para o campo de seleção
$autores = Autor::listar(); // Lista todos os autores para o campo de seleção

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $livro = Livro::listar(1, $id); // Busca o livro pelo ID
    if (count($livro) > 0) {
        $livro = $livro[0]; // Obtém o primeiro livro (já que estamos buscando por ID)
    } else {
        echo "Livro não encontrado!";
        exit;
    }
} else {
    echo "ID do livro não fornecido.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $anoPublicacao = isset($_POST['anoPublicacao']) ? (int)$_POST['anoPublicacao'] : 0;
    $fotoCapa = isset($_FILES['fotoCapa']) ? $_FILES['fotoCapa']['name'] : $livro['fotoCapa']; // Foto da capa
    $idCategoria = isset($_POST['idCategoria']) ? (int)$_POST['idCategoria'] : $livro['idCategoria'];
    $preco = isset($_POST['preco']) ? (float)$_POST['preco'] : 0.0;
    $autor_id = isset($_POST['autor_id']) ? (int)$_POST['autor_id'] : $livro['autor_id']; // Captura o autor selecionado

    try {
        // Atualiza o livro com as novas informações, incluindo o autor
        $livroEditado = new Livro($id, $titulo, $anoPublicacao, $fotoCapa, new Categorias($idCategoria), $preco, $autor_id);
        $livroEditado->alterar();
        echo "Livro atualizado com sucesso!";
        header('Location: index.php'); // Redireciona para a listagem de livros
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
    <title>Editar Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Editar Livro</h2>
        <form action="editar.php?id=<?= $livro['id'] ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $livro['titulo'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="anoPublicacao" class="form-label">Ano de Publicação</label>
                <input type="number" class="form-control" id="anoPublicacao" name="anoPublicacao" value="<?= $livro['anoPublicacao'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="fotoCapa" class="form-label">Foto da Capa</label>
                <input type="file" class="form-control" id="fotoCapa" name="fotoCapa">
                <?php if ($livro['fotoCapa']) { ?>
                    <p>Foto atual: <?= $livro['fotoCapa'] ?></p>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="idCategoria" class="form-label">Categoria</label>
                <select class="form-select" id="idCategoria" name="idCategoria" required>
                    <?php
                    foreach ($categorias as $categoria) {
                        $selected = ($livro['idCategoria'] == $categoria['id']) ? "selected" : "";
                        echo "<option value='" . $categoria['id'] . "' $selected>" . $categoria['descricao'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="autor_id" class="form-label">Autor</label>
                <select name="autor_id" id="autor_id" class="form-select" required>
                    <?php
                    foreach ($autores as $autor) {
                        $selected = ($livro['autor_id'] == $autor['id']) ? "selected" : "";
                        echo "<option value='{$autor['id']}' $selected>{$autor['nome']} {$autor['sobrenome']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="text" class="form-control" id="preco" name="preco" value="<?= $livro['preco'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
