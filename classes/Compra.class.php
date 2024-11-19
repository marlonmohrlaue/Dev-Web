<?php
require_once("Database.class.php");

class Compra
{
    private $id;
    private $dataCompra;
    private $idCliente;

    public function __construct($id = 0, $dataCompra = "", $idCliente = 0)
    {
        $this->setId($id);
        $this->setDataCompra($dataCompra);
        $this->setIdCliente($idCliente);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDataCompra($dataCompra)
    {
        if (empty($dataCompra)) {
            throw new Exception("Data de compra inválida.");
        }
        $this->dataCompra = $dataCompra;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDataCompra()
    {
        return $this->dataCompra;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function incluir()
    {
        $sql = "INSERT INTO Compra (dataCompra, idCliente) VALUES (:dataCompra, :idCliente)";
        $params = [':dataCompra' => $this->dataCompra, ':idCliente' => $this->idCliente];
        return Database::executar($sql, $params);
    }
}
