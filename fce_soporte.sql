CREATE DATABASE IF NOT EXISTS fce_soporte;
USE fce_soporte;

CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    asunto VARCHAR(150) NOT NULL,
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO tickets (asunto, descripcion) VALUES
('Fallo proyector Sala 101', 'El videobeam parpadea y se apaga.'),
('Teclado dañado Sala Mac', 'La barra espaciadora no responde.');