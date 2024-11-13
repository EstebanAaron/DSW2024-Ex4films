SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `projectdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `projectdb`;

CREATE USER IF NOT EXISTS 'projectuser'@'localhost' IDENTIFIED BY 'dsw_mola'; 
GRANT SELECT, INSERT, UPDATE, DELETE ON projectdb.* TO 'projectuser'@'localhost';
FLUSH PRIVILEGES;

DROP TABLE IF EXISTS `assignments`;
DROP TABLE IF EXISTS `employees`;
DROP TABLE IF EXISTS `projects`;

CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` INT AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `max_hours` INT NOT NULL,
  PRIMARY KEY (`project_id`)
);

CREATE TABLE IF NOT EXISTS `employees` (
  `employee_id` INT AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `role` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`employee_id`)
);

CREATE TABLE IF NOT EXISTS `assignments` (
  `assignment_id` INT AUTO_INCREMENT,
  `project_id` INT,
  `employee_id` INT,
  `assigned_hours` INT NOT NULL,
  PRIMARY KEY (`assignment_id`),
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`project_id`)  ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`)  ON DELETE RESTRICT ON UPDATE CASCADE
);

INSERT INTO `projects` (`name`, `max_hours`) VALUES
('Desarrollo de Portal E-commerce', 120),
('Sistema de Gestión de Inventarios', 90),
('Aplicación Móvil para Recetas', 150),
('Rediseño del Blog de la Empresa', 70),
('Plataforma de Reservas', 100),
('Chatbot de Atención al Cliente', 60),
('Sistema de Facturación en Línea', 110),
('Sitio Web para Veterinaria', 80),
('Aplicación Web de Deportes Extremos', 95),
('Desarrollo de AI que Dice Chistes', 60);

INSERT INTO `employees` (`name`, `role`) VALUES
('Carlos García', 'Desarrollador Backend'),
('Ana López', 'Desarrolladora Frontend'),
('Laura Pérez', 'Diseñadora UX/UI'),
('Jorge Díaz', 'Ingeniero de Datos'),
('Lucía Fernández', 'Analista de Sistemas'),
('Pablo Ruiz', 'Gestor de Proyectos'),
('María Gómez', 'Especialista en QA'),
('Juan Martínez', 'Consultor SEO'),
('Marta Ramírez', 'Desarrolladora Full Stack'),
('Raúl Silva', 'DevOps'),
('Carmen Alonso', 'Especialista en Ciberseguridad'),
('Luis Hernández', 'Desarrollador Junior'),
('Beatriz López', 'Desarrolladora Web'),
('Sofía Torres', 'Desarrolladora Web'),
('Ignacio Gómez', 'Administrador de Base de Datos');

INSERT INTO `assignments` (`project_id`, `employee_id`, `assigned_hours`) VALUES
(1, 1, 20), -- Carlos en E-commerce
(6, 1, 20), -- Carlos en Chatbot
(1, 3, 40), -- Laura en E-commerce
(2, 6, 45), -- Pablo en Inventarios
(5, 11, 30), -- Carmen en Reservas
(3, 9, 50), -- Marta en Recetas
(4, 5, 35), -- Lucía en Blog
(5, 15, 40), -- Ignacio en Reservas
(4, 10, 35), -- Raúl en Blog
(9, 14, 45), -- Sofía en Deportes Extremos
(6, 3, 20), -- Laura en Chatbot
(7, 2, 30), -- Ana en Facturación
(9, 3, 20), -- Laura en Deportes Extremos 
(6, 13, 20), -- Beatriz en Chatbot
(2, 4, 45), -- Jorge en Inventarios
(3, 8, 10), -- Juan en Recetas
(1, 2, 30), -- Ana en E-commerce
(7, 6, 40), -- Pablo en Facturación
(7, 9, 40), -- Marta en Facturación
(8, 4, 40), -- Jorge en Veterinaria
(8, 11, 40), -- Carmen en Veterinaria
(3, 7, 15), -- María en Recetas
(9, 12, 30), -- Luis en Deportes Extremos
(3, 6, 18), -- Pablo en Recetas
(3, 14, 45), -- Sofía en Recetas
(5, 14, 30); -- Sofía en Reservas


COMMIT;