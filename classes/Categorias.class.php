<?php
require_once("Database.class.php");

class Categorias
{
    private $id;
    private $descricao;

    public function __construct($id = 0, $descricao = "")
    {
        $this->setId($id);
        $this->setDescricao($descricao);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDescricao($descricao)
    {
        
        $this->descricao = $descricao;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function incluir()
    {
        $sql = "INSERT INTO Categorias (descricao) VALUES (:descricao)";
        $params = [':descricao' => $this->descricao];
        return Database::executar($sql, $params);
    }

    public function alterar()
    {
        $sql = "UPDATE Categorias SET descricao = :descricao WHERE id = :id";
        $params = [
            ':descricao' => $this->descricao,
            ':id' => $this->id
        ];
        return Database::executar($sql, $params);
    }

    public function excluir()
    {
        $sql = "DELETE FROM Categorias WHERE id = :id";
        $params = [':id' => $this->id];
        return Database::executar($sql, $params);
    }

    public static function listar($tipo = 0, $busca = "")
    {
        $sql = "SELECT * FROM Categorias";
        if ($tipo == 1) {
            $sql .= " WHERE id = :busca";
        } elseif ($tipo == 2) {
            $sql .= " WHERE descricao LIKE :busca";
            $busca = "%{$busca}%";
        }

        $params = $tipo > 0 ? [':busca' => $busca] : [];
        $result = Database::executar($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
