<?php
require_once("Database.class.php");

class Usuario
{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __construct($id = 0, $nome = "", $email = "", $senha = "")
    {
        $this->setId($id);
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
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

    public function setEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("E-mail inválido.");
        }
        $this->email = $email;
    }

    public function setSenha($senha)
    {
        if (empty($senha)) {
            throw new Exception("Senha inválida.");
        }
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function incluir()
    {
        $sql = "INSERT INTO Usuario (nome, email, senha) VALUES (:nome, :email, :senha)";
        $params = [':nome' => $this->nome, ':email' => $this->email, ':senha' => $this->senha];
        return Database::executar($sql, $params);
    }

    public function alterar()
    {
        $sql = "UPDATE Usuario SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
        $params = [':nome' => $this->nome, ':email' => $this->email, ':senha' => $this->senha, ':id' => $this->id];
        return Database::executar($sql, $params);
    }

    public function excluir()
    {
        $sql = "DELETE FROM Usuario WHERE id = :id";
        $params = [':id' => $this->id];
        return Database::executar($sql, $params);
    }

    public static function listar($tipo = 0, $busca = "")
    {
        $sql = "SELECT * FROM Usuario";
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
