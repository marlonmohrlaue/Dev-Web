<?php
require_once("Database.class.php");
require_once("Categorias.class.php");
require_once("Autor.class.php"); // Incluindo a classe Autor

class Livro
{
    private $id;
    private $titulo;
    private $anoPublicacao;
    private $fotoCapa;
    private $idCategoria;
    private $preco;
    private $autorId;  // Novo campo para associar o autor

    public function __construct($id, $titulo, $anoPublicacao, $fotoCapa, $idCategoria, $preco, $autorId)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->anoPublicacao = $anoPublicacao;
        $this->fotoCapa = $fotoCapa;
        $this->idCategoria = $idCategoria;
        $this->preco = $preco;
        $this->autorId = $autorId; // Atribui o ID do autor
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitulo($titulo)
    {
        if (empty($titulo)) {
            throw new Exception("Título inválido.");
        }
        $this->titulo = $titulo;
    }

    public function setAnoPublicacao($anoPublicacao)
    {
        if ($anoPublicacao < 0) {
            throw new Exception("Ano de publicação inválido.");
        }
        $this->anoPublicacao = $anoPublicacao;
    }

    public function setFotoCapa($fotoCapa)
    {
        $this->fotoCapa = $fotoCapa;
    }

    public function setCategoria(Categorias $idCategoria = null)
    {
        $this->idCategoria = $idCategoria ? $idCategoria->getId() : null;
    }

    public function setPreco($preco)
    {
        if ($preco < 0) {
            throw new Exception("Preço inválido.");
        }
        $this->preco = $preco;
    }

    // Novo setter para o autor
    public function setAutorId($autorId)
    {
        $this->autorId = $autorId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getAnoPublicacao()
    {
        return $this->anoPublicacao;
    }

    public function getFotoCapa()
    {
        return $this->fotoCapa;
    }

    public function getCategoria()
    {
        return $this->idCategoria;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    // Novo getter para o autor
    public function getAutorId()
    {
        return $this->autorId;
    }

    public function incluir()
    {
        // Criação da consulta SQL
        $sql = "INSERT INTO Livro (titulo, anoPublicacao, fotoCapa, idCategoria, preco, autor_id) 
                VALUES (:titulo, :anoPublicacao, :fotoCapa, :idCategoria, :preco, :autor_id)";

        // Parâmetros a serem passados para a consulta
        $parametros = [
            ':titulo' => $this->titulo,
            ':anoPublicacao' => $this->anoPublicacao,
            ':fotoCapa' => $this->fotoCapa,
            ':idCategoria' => $this->idCategoria->getId(),
            ':preco' => $this->preco,
            ':autor_id' => $this->autorId,
        ];

        // Preparar e executar a consulta com os parâmetros
        $stmt = Database::preparar($sql, $parametros);
        $stmt->execute();
    }

    public function alterar()
    {
        $sql = "UPDATE Livro SET titulo = :titulo, anoPublicacao = :anoPublicacao, fotoCapa = :fotoCapa, 
                idCategoria = :idCategoria, preco = :preco, autor_id = :autor_id WHERE id = :id";
        $params = [
            ':titulo' => $this->titulo,
            ':anoPublicacao' => $this->anoPublicacao,
            ':fotoCapa' => $this->fotoCapa,
            ':idCategoria' => $this->idCategoria,
            ':preco' => $this->preco,
            ':autor_id' => $this->autorId, // Atualizando o autor
            ':id' => $this->id
        ];
        return Database::executar($sql, $params);
    }

    public function excluir()
    {
        // Verifica se o ID do livro está definido
        if (empty($this->id)) {
            throw new Exception("ID do livro não foi definido.");
        }

        // Consulta SQL para excluir o livro
        $sql = "DELETE FROM livros WHERE id = :id";

        // Prepara a consulta usando o método da classe Database
        $stmt = Database::preparar($sql);

        // Faz o bind do ID do livro na consulta
        $stmt->bindValue(':id', $this->id);

        // Executa a consulta
        $stmt->execute();
    }


    public static function listar($tipo = 0, $busca = "")
    {
        $sql = "SELECT Livro.*, Categorias.descricao AS categoriaDescricao, Autor.nome AS autorNome, Autor.sobrenome AS autorSobrenome 
                FROM Livro 
                LEFT JOIN Categorias ON Livro.idCategoria = Categorias.id
                LEFT JOIN Autor ON Livro.autor_id = Autor.id";  // Join com a tabela Autor
        if ($tipo == 1) {
            $sql .= " WHERE Livro.id = :busca";
        } elseif ($tipo == 2) {
            $sql .= " WHERE Livro.titulo LIKE :busca";
            $busca = "%{$busca}%";
        }

        $params = $tipo > 0 ? [':busca' => $busca] : [];
        $result = Database::executar($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
