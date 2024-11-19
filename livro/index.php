<?php
require_once('../classes/Livro.class.php');
require_once('../classes/Autor.class.php'); // Inclusão da classe Autor
require_once('../classes/Categorias.class.php');
require('../navbar.php');

$busca = isset($_GET['busca']) ? $_GET['busca'] : "";
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
$livros = Livro::listar($tipo, $busca); // Busca os livros conforme a busca

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <a href="livro.php">Cadastro de Livro</a>
    <div class="container mt-4">
        <h2>Cadastro de Livros</h2>
        <form action="index.php" method="get" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="busca" id="busca" class="form-control" placeholder="Procurar livros">
            </div>
            <div class="col-md-3">
                <select name="tipo" id="tipo" class="form-select">
                    <option value="1">ID</option>
                    <option value="2">Título</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-success">Buscar</button>
            </div>
        </form>

        <br>

        <h2>Livros Cadastrados</h2>
        <div class="row">
            <?php
            foreach ($livros as $livro) {
                // Busca o autor completo (nome e sobrenome)
                $autor = Autor::listar(1, $livro['idAutor']); // A busca do autor usa o idAutor do livro
                $autorNome = $autor[0]['nome'] . " " . $autor[0]['sobrenome']; // Concatena nome e sobrenome

                echo "<div class='livro col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $livro['titulo'] . "</h5>";
                echo "<p class='card-text'>Autor: " . $autorNome . "</p>"; // Exibe o autor completo
                echo "<p class='card-text'>Preço: R$ " . number_format($livro['preco'], 2, ',', '.') . "</p>";

                // Botão para adicionar ao carrinho
                echo "<form method='POST' action='../carrinho.php'>";
                echo "<input type='hidden' name='idLivro' value='" . $livro['id'] . "'>";
                echo "<input type='hidden' name='preco' value='" . $livro['preco'] . "'>";
                echo "<button type='submit' name='acao' value='adicionar' class='btn btn-primary'>Adicionar ao Carrinho</button>";
                echo "<a href='editar.php?id=" . $livro['id'] . "' class='btn btn-warning btn-sm'>Editar</a> ";
                echo "<a href='delete.php?id=" . $livro['id'] . "' class='btn btn-danger btn-sm'>Excluir</a>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>