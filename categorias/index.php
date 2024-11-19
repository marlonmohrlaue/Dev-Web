<?php
require_once('../classes/Categorias.class.php');
require('../navbar.php');

$busca = isset($_GET['busca']) ? $_GET['busca'] : "";
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
$lista = Categorias::listar($tipo, $busca); // Busca as categorias conforme a busca

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Categorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<a href="categoria.php">Cadastro de Categoria</a>
    <div class="container mt-4">
        <h2>Cadastro de Categorias</h2>
        <form action="index.php" method="get" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="busca" id="busca" class="form-control" placeholder="Procurar categorias">
            </div>
            <div class="col-md-3">
                <select name="tipo" id="tipo" class="form-select">
                    <option value="1">ID</option>
                    <option value="2">Descrição</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-success">Buscar</button>
            </div>
        </form>

        <br>

        <h2>Categorias Cadastradas</h2>
        <div class="row">
            <?php
            foreach ($lista as $categoria) {
                $id = $categoria['id'];
                $descricao = $categoria['descricao'];

                echo "<div class='col-md-4'>";
                echo "<div style='border: 1px solid black; padding: 10px; margin-bottom: 10px;'>";
                echo "<strong>Informações da Categoria:</strong><br>";
                echo "ID: {$id}<br>";
                echo "Descrição: {$descricao}<br>";
                echo "</div>";
                echo "<div style='text-align: left;'>";
                echo "<a href='editar.php?id=" . $id . "' class='btn btn-warning btn-sm'>Editar</a> ";
                echo "<a href='delete.php?id=" . $id . "' class='btn btn-danger btn-sm'>Excluir</a>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
