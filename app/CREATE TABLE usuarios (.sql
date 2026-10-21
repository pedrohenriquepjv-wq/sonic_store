CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    email VARCHAR(150) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    tamanho VARCHAR(10) NOT NULL,
    preco NUMERIC(10, 2) NOT NULL,
    em_estoque BOOLEAN DEFAULT true,
    email_fornecedor VARCHAR(150)
);