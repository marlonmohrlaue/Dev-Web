<?php
require_once("Database.class.php");
class Autor
{
    private $id;
    private $nome;
    private $sobrenome;

    public function __construct($id = 0, $nome = "", $sobrenome = "")
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    public function incluir()
    {
        $sql = "INSERT INTO Autor (nome, sobrenome) VALUES (:nome, :sobrenome)";
        $params = [':nome' => $this->nome, ':sobrenome' => $this->sobrenome];
        return Database::executar($sql, $params);
    }

    public function alterar()
    {
        
        $sql = "UPDATE Autor SET nome = :nome, sobrenome = :sobrenome WHERE id = :id";
        $params = [
            ':nome' => $this->nome,
            ':sobrenome' => $this->sobrenome,
            ':id' => $this->id
        ];
        return Database::executar($sql, $params);
    }


    public static function listar()
    {
        $sql = "SELECT * FROM Autor";
        $result = Database::executar($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
