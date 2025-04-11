-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS if0_38729248_agenda_contactos;
USE if0_38729248_agenda_contactos;

-- Crear la tabla de contactos
CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(50) NOT NULL,
    apaterno VARCHAR(50) NOT NULL,
    amaterno VARCHAR(50),
    genero ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    linkedin VARCHAR(150),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar algunos datos de ejemplo
INSERT INTO contactos (nombres, apaterno, amaterno, genero, fecha_nacimiento, telefono, email, linkedin) VALUES
('Juan', 'Pérez', 'Gómez', 'Masculino', '1990-05-15', '5551234567', 'juan.perez@example.com', 'linkedin.com/in/juanperez'),
('María', 'López', 'Hernández', 'Femenino', '1985-08-22', '5559876543', 'maria.lopez@example.com', 'linkedin.com/in/marialopez'),
('Carlos', 'Martínez', NULL, 'Masculino', '1995-03-10', '5554567890', 'carlos.martinez@example.com', NULL);