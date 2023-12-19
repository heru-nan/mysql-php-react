CREATE DATABASE IF NOT EXISTS myDatabase;
USE myDatabase;

CREATE TABLE IF NOT EXISTS votos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alias VARCHAR(255) NOT NULL,
    candidato VARCHAR(255) NOT NULL,
    comoSeEntero TEXT NOT NULL,
    email VARCHAR(255) NOT NULL,
    fullName VARCHAR(255) NOT NULL,
    rut VARCHAR(255) NOT NULL,
    region VARCHAR(255) NOT NULL,
    comuna VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS candidatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

INSERT INTO candidatos (nombre) VALUES ('Candidato 1');
INSERT INTO candidatos (nombre) VALUES ('Candidato 2');
INSERT INTO candidatos (nombre) VALUES ('Candidato 3');
