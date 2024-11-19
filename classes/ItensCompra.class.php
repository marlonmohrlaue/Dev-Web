<?php
require_once("Database.class.php");

class ItensCompra
{
    private $id;
    private $idCompra;
    private $idLivro;
    private $quantidade;

    public function __construct($id = 0, $idCompra = 0, $idLivro = 0, $quantidade = 1)
    {
        $this->setId($id);
        $this->setIdCompra($idCompra);
        $this->setIdLivro($idLivro);
        $this->setQuantidade($quantidade);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setIdCompra($idCompra)
    {
        $this->idCompra = $idCompra;
    }

    public function setIdLivro($idLivro)
    {
        $this->idLivro = $idLivro;
    }

    public function setQuantidade($quantidade)
    {
        if ($quantidade < 1) {
            throw new Exception("Quantidade inválida.");
        }
        $this->quantidade = $quantidade;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdCompra()
    {
        return $this->idCompra;
    }

    public function getIdLivro()
    {
        return $this->idLivro;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function incluir()
    {
        $sql = "INSERT INTO ItensCompra (idCompra, idLivro, quantidade) VALUES (:idCompra, :idLivro, :quantidade)";
        $params = [
            ':idCompra' => $this->idCompra,
            ':idLivro' => $this->idLivro,
            ':quantidade' => $this->quantidade
        ];
        return Database::executar($sql, $params);
    }
}
