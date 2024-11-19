<?php
require_once("../classes/Livro.class.php");
require_once("../classes/Database.class.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Converte para inteiro

    try {
        // Obtenha a conexão com o banco de dados
        $conexao = Database::getInstance();
        
        // Consulta SQL para excluir o livro com o ID fornecido
        $sql = "DELETE FROM Livro WHERE id = :id"; 

        // Prepara a consulta
        $stmt = $conexao->prepare($sql);
        
        // Vincula o parâmetro ID
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Executa a consulta
        if ($stmt->execute()) {
            // Se a execução for bem-sucedida, redireciona para a página de listagem
            header("Location: index.php");
            exit(); // Adiciona exit para evitar que o script continue
        } else {
            // Caso ocorra algum erro, exibe a mensagem de erro
            echo "Erro ao excluir o registro.";
            // Adiciona linha para depurar o erro
            echo "Erro: " . implode(", ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        // Se ocorrer erro na conexão ou execução, exibe a mensagem de erro
        echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    }
} else {
    // Caso o ID fornecido não seja válido ou não tenha sido fornecido
    echo "ID inválido.";
}
?>
