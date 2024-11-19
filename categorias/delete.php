<?php
require_once("../classes/Categorias.class.php");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $categoria = new Categorias($id);
        $categoria->excluir();
        echo "Categoria excluída com sucesso!";
        header('Location:index.php'); // Redireciona para a listagem de categorias
        exit;
    } catch (Exception $e) {
        echo "Erro ao excluir a categoria: " . $e->getMessage();
    }
} else {
    echo "ID da categoria não fornecido.";
}
?>
