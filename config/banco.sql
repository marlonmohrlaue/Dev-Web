CREATE DATABASE IF NOT EXISTS sistema_loja;
USE sistema_loja;

-- Tabela Usuario
CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivelPermissao INT NOT NULL
);

-- Tabela Cliente (herança de Usuario)
CREATE TABLE Cliente (
    id INT PRIMARY KEY,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    FOREIGN KEY (id) REFERENCES Usuario(id) ON DELETE CASCADE
);

-- Tabela Autor
CREATE TABLE Autor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL
);

-- Tabela Livro
CREATE TABLE Livro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    anoPublicacao INT NOT NULL,
    fotoCapa VARCHAR(255),
    idCategoria INT,
    preco DOUBLE NOT NULL,
    FOREIGN KEY (idCategoria) REFERENCES Categorias(id) ON DELETE SET NULL
);

-- Tabela Categorias
CREATE TABLE Categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(100) NOT NULL
);

-- Tabela AutorLivro (associação muitos-para-muitos)
CREATE TABLE AutorLivro (
    idAutor INT NOT NULL,
    idLivro INT NOT NULL,
    PRIMARY KEY (idAutor, idLivro),
    FOREIGN KEY (idAutor) REFERENCES Autor(id) ON DELETE CASCADE,
    FOREIGN KEY (idLivro) REFERENCES Livro(id) ON DELETE CASCADE
);

-- Tabela Compra
CREATE TABLE Compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dtCompra DATE NOT NULL,
    valorTotalCompra DOUBLE NOT NULL,
    idCliente INT NOT NULL,
    FOREIGN KEY (idCliente) REFERENCES Cliente(id) ON DELETE CASCADE
);

-- Tabela ItensCompra
CREATE TABLE ItensCompra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idCompra INT NOT NULL,
    idLivro INT NOT NULL,
    valorUnitario DOUBLE NOT NULL,
    quantidade INT NOT NULL,
    valorTotalItem DOUBLE NOT NULL,
    FOREIGN KEY (idCompra) REFERENCES Compra(id) ON DELETE CASCADE,
    FOREIGN KEY (idLivro) REFERENCES Livro(id) ON DELETE CASCADE
);
