<?php
require_once("../classes/Livro.class.php");
require_once("../classes/Autor.class.php");
require_once("../classes/Categorias.class.php");

$categorias = Categorias::listar(); // Lista todas as categorias para o campo de seleção

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $anoPublicacao = isset($_POST['anoPublicacao']) ? (int)$_POST['anoPublicacao'] : 0;
    $fotoCapa = isset($_FILES['fotoCapa']) ? $_FILES['fotoCapa']['name'] : ""; // Foto da capa
    $idCategoria = isset($_POST['idCategoria']) ? (int)$_POST['idCategoria'] : 0;
    $preco = isset($_POST['preco']) ? (float)$_POST['preco'] : 0.0;
    $autor_id = isset($_POST['autor_id']) ? (int)$_POST['autor_id'] : 0; // Captura o ID do autor

    try {
        // Cria um objeto Livro e tenta inserir no banco
        $livro = new Livro(0, $titulo, $anoPublicacao, $fotoCapa, new Categorias($idCategoria), $preco, $autor_id); // Passando o autor_id
        $livro->incluir(); // Tenta incluir o livro no banco de dados
        echo "Livro cadastrado com sucesso!";
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
    <title>Cadastrar Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Cadastrar Livro</h2>
        <form action="livro.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="anoPublicacao" class="form-label">Ano de Publicação</label>
                <input type="number" class="form-control" id="anoPublicacao" name="anoPublicacao" required>
            </div>
            <div class="mb-3">
                <label for="fotoCapa" class="form-label">Foto da Capa</label>
                <input type="file" class="form-control" id="fotoCapa" name="fotoCapa">
            </div>
            <div class="mb-3">
                <label for="idCategoria" class="form-label">Categoria</label>
                <select class="form-select" id="idCategoria" name="idCategoria" required>
                    <?php
                    foreach ($categorias as $categoria) {
                        echo "<option value='" . $categoria['id'] . "'>" . $categoria['descricao'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="autor_id" class="form-label">Autor</label>
                <select name="autor_id" id="autor_id" class="form-select" required>
                    <?php
                    // Lista os autores cadastrados para selecionar no cadastro do livro
                    $autores = Autor::listar();
                    foreach ($autores as $autor) {
                        echo "<option value='{$autor['id']}'>{$autor['nome']} {$autor['sobrenome']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="text" class="form-control" id="preco" name="preco" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>

</html>
