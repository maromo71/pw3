--Script o banco de dados
--Criar um banco de dados chamado medicos_db se nao o existir
CREATE DATABASE IF NOT EXISTS  medicos_db;

--Selecionar o banco de dados medicos_db
USE medicos_db;

--Criar as tabelas necessárias
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    crm VARCHAR(20) UNIQUE NOT NULL
    -- Outros campos do médico, se necessário
);

CREATE TABLE especialidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE medico_especialidade (
    medico_id INT,
    especialidade_id INT,
    PRIMARY KEY (medico_id, especialidade_id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE,
    FOREIGN KEY (especialidade_id) REFERENCES especialidades(id) ON DELETE CASCADE
);

-- Inserir um usuário inicial (opcional, ajuste a senha!)
INSERT INTO usuarios (usuario, senha) VALUES ('admin', '$2y$10$abcdefghijklmnopqrstuv'); -- Senha: admin123 (criptografada com bcrypt)
