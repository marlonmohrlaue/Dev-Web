<?php
require_once("Database.class.php");

class Cliente
{
    private $id;
    private $nome;

    public function __construct($id = 0, $nome = "")
    {
        $this->setId($id);
        $this->setNome($nome);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        if (empty($nome)) {
            throw new Exception("Nome inválido.");
        }
        $this->nome = $nome;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function incluir()
    {
        $sql = "INSERT INTO Cliente (nome) VALUES (:nome)";
        $params = [':nome' => $this->nome];
        return Database::executar($sql, $params);
    }

    public function alterar()
    {
        $sql = "UPDATE Cliente SET nome = :nome WHERE id = :id";
        $params = [':nome' => $this->nome, ':id' => $this->id];
        return Database::executar($sql, $params);
    }

    public function excluir()
    {
        $sql = "DELETE FROM Cliente WHERE id = :id";
        $params = [':id' => $this->id];
        return Database::executar($sql, $params);
    }

    public static function listar($tipo = 0, $busca = "")
    {
        $sql = "SELECT * FROM Cliente";
        if ($tipo == 1) {
            $sql .= " WHERE id = :busca";
        } elseif ($tipo == 2) {
            $sql .= " WHERE nome LIKE :busca";
            $busca = "%{$busca}%";
        }

        $params = $tipo > 0 ? [':busca' => $busca] : [];
        $result = Database::executar($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
