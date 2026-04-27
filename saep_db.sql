-- Limpeza de banco anterior para evitar conflitos
DROP DATABASE IF EXISTS saep_db;

-- Criação do Banco de Dados
CREATE DATABASE saep_db;
USE saep_db;

-- Tabela de Usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Tabela de Produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    especificacoes TEXT,
    estoque_minimo INT DEFAULT 0,
    estoque_atual INT DEFAULT 0
) ENGINE=InnoDB;

-- Tabela de Movimentações (Histórico)
CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    usuario_id INT NOT NULL,
    tipo ENUM('entrada', 'saída') NOT NULL,
    quantidade INT NOT NULL,
    data_movimentacao DATETIME NOT NULL,
    INDEX (produto_id),
    INDEX (usuario_id),
    CONSTRAINT fk_produto FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,
    CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- População do Banco de Dados (Mínimo 3 registros por tabela conforme pedido)

-- Usuários
INSERT INTO usuarios (nome, email, senha) VALUES
('Almoxarife João', 'joao@loja.com', '123456'),
('Gerente Maria', 'maria@loja.com', 'admin123'),
('Tecnico Carlos', 'carlos@loja.com', 'senha789');

-- Produtos
INSERT INTO produtos (nome, especificacoes, estoque_minimo, estoque_atual) VALUES
('Smartphone Samsung S23', 'Resolução: 2340x1080, Armazenamento: 256GB, Conetividade: 5G', 5, 10),
('Notebook Dell Inspiron', 'Processador: i7, RAM: 16GB, Tensão: Bivolt', 3, 2),
('Smart TV LG 55"', 'Resolução: 4K, Conetividade: Wi-Fi/Bluetooth', 2, 8);

-- Movimentações
INSERT INTO movimentacoes (produto_id, usuario_id, tipo, quantidade, data_movimentacao) VALUES
(1, 1, 'entrada', 10, NOW()),
(2, 1, 'entrada', 2, NOW()),
(3, 2, 'entrada', 8, NOW()),
(1, 3, 'saída', 2, NOW());
