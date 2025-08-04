-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 24, 2025 at 10:49 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyecto_portafolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `asunto` varchar(150) DEFAULT NULL,
  `mensaje` text,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `correo`, `asunto`, `mensaje`, `fecha`) VALUES
(1, 'Jahir Emanuel Cano Carrasco', 'yayo12@gmail.com', 'remodelacion de baño', 'me contacto con ustedes para la reparacion de tuberias de mi baño y cambio de ceramica de la regadera', '2025-07-04 19:26:20'),
(27, 'Jahir Emanuel Cano', 'emanuelcarrasco202@gmail.com', 'Remodelacion', 'Necesito remodelar el bano de mi casa, porfavor si me pudieran hacer una cotizacion de acuerdo o apartarme una reunion', '2025-07-21 05:20:35'),
(34, 'Luis Torres', 'luis.torres@mail.com', 'Cotización de vivienda', 'Hola, estoy interesado en construir una casa de dos plantas. ¿Podrían enviarme una cotización aproximada?', '2023-02-10 06:00:00'),
(35, 'María López', 'm.lopez@gmail.com', 'Remodelación de cocina', 'Deseo remodelar mi cocina completa. Me gustaría agendar una visita para revisar detalles.', '2024-05-17 06:00:00'),
(36, 'Carlos Ayala', 'cayala@hotmail.com', 'Presupuesto para muro perimetral', '¿Podrían enviarme un presupuesto para construir un muro alrededor de mi propiedad?', '2022-11-03 06:00:00'),
(37, 'Daniela Flores', 'daniflores23@yahoo.com', 'Ampliación de vivienda', 'Quisiera ampliar una habitación y el área del comedor. ¿Tienen disponibilidad este mes?', '2025-01-25 06:00:00'),
(38, 'José Ramírez', 'jramirez@mail.com', 'Construcción desde cero', 'Tengo un terreno y quiero construir una casa completa. ¿Cómo trabajan ustedes?', '2023-06-29 06:00:00'),
(39, 'Carolina Méndez', 'caromendez@gmail.com', 'Consulta de planos', '¿Ofrecen servicio de diseño de planos arquitectonicos?', '2024-08-14 06:00:00'),
(40, 'Pedro Martínez', 'pedro.mtz@outlook.com', 'Techo para cochera', 'Necesito construir un techo para dos vehiculos. ¿Que opciones ofrecen?', '2023-04-05 06:00:00'),
(41, 'Andrea Cálix', 'andreacalix@mail.com', 'Problemas con humedad', 'Mi casa tiene humedad en las paredes. ¿Ustedes pueden ayudar con este problema?', '2022-09-22 06:00:00'),
(42, 'Mario Hernández', 'm.hernandez@gmail.com', 'Materiales utilizados', '¿Qué tipo de materiales utilizan en las construcciones?', '2024-01-09 06:00:00'),
(43, 'Lucía Reyes', 'luciareyes@hotmail.com', 'Construcción de oficina', 'Necesito construir una oficina pequeña en mi propiedad. ¿Me pueden contactar?', '2023-12-12 06:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL,
  `trabajo_id` int(11) DEFAULT NULL,
  `ruta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `imagenes`
--

INSERT INTO `imagenes` (`id`, `trabajo_id`, `ruta`) VALUES
(3, 4, 'uploads/1751949147_IMG-20250624-WA0018.jpg'),
(4, 5, 'uploads/1753129894_Imagen de WhatsApp 2025-06-24 a las 16.04.14_74d1bc41.jpg'),
(5, 5, '\"C:\\MAMP\\htdocs\\MCPW\\assets\\img\\Trabajos\\Trabajo1\\Imagen de WhatsApp 2025-06-24 a las 16.04.12_a1d5f517.jpg\"'),
(6, 5, '\"C:\\MAMP\\htdocs\\MCPW\\assets\\img\\Trabajos\\Trabajo1\\Imagen de WhatsApp 2025-06-24 a las 16.04.13_2ac3362c.jpg\"'),
(7, 5, '\"C:\\MAMP\\htdocs\\MCPW\\assets\\img\\Trabajos\\Trabajo1\\Imagen de WhatsApp 2025-06-24 a las 16.04.13_62036f91.jpg\"'),
(8, 5, '\"C:\\MAMP\\htdocs\\MCPW\\assets\\img\\Trabajos\\Trabajo1\\Imagen de WhatsApp 2025-06-24 a las 16.04.14_3adc05d9.jpg\"'),
(9, 6, 'uploads/1753341843_Imagen de WhatsApp 2025-06-24 a las 16.13.42_88c83b16.jpg'),
(10, 7, 'uploads/1753342141_Imagen de WhatsApp 2025-06-24 a las 16.14.08_66af2119.jpg'),
(11, 8, 'uploads/1753342537_Imagen de WhatsApp 2025-06-24 a las 16.08.21_c94c0e13.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `opiniones`
--

CREATE TABLE `opiniones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `comentario` text,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `opiniones`
--

INSERT INTO `opiniones` (`id`, `nombre`, `calificacion`, `comentario`, `fecha`) VALUES
(6, 'Jahir Cano', 5, 'Comppletamente satisfecho con los trabajos realizados en mi hogar.\r\n', '2025-07-07 05:23:30'),
(8, 'Lewandoski', 4, 'sin comentarios', '2025-07-07 21:46:15'),
(9, 'Jose', 4, 'sin comentario', '2025-07-08 04:16:31'),
(11, 'Ana Rodríguez', 5, 'Muy profesionales en la remodelación de mi cocina. Los recomiendo totalmente.', '2023-03-15 06:00:00'),
(12, 'Carlos Méndez', 4, 'Buen trabajo en la construcción de mi bodega. Solo tardaron un poco más de lo previsto.', '2022-11-10 06:00:00'),
(13, 'Luisa Gómez', 3, 'Cumplieron con el contrato, pero hubo detalles menores que debí señalar.', '2024-01-22 06:00:00'),
(14, 'Marcos Herrera', 4, 'Ampliaron mi casa de forma eficiente y con materiales de calidad.', '2023-07-30 06:00:00'),
(15, 'Patricia López', 5, 'Excelente equipo, transformaron mi terreno en una hermosa vivienda.', '2025-05-02 06:00:00'),
(16, 'José Martínez', 4, 'Construcción de muros perimetrales muy bien hecha. Buena atención al cliente.', '2022-08-19 06:00:00'),
(17, 'Sofía Torres', 3, 'Todo bien, pero el acabado de pintura pudo ser mejor.', '2023-02-05 06:00:00'),
(18, 'Andrés Castro', 5, 'Muy detallistas y ordenados. Mi local comercial quedó perfecto.', '2024-09-14 06:00:00'),
(19, 'Valeria Ruiz', 4, 'Buen trato, responsables con los tiempos y el presupuesto.', '2025-03-10 06:00:00'),
(20, 'Diego Sánchez', 3, 'Hubo algunos retrasos, pero el resultado final fue aceptable.', '2022-12-01 06:00:00'),
(21, 'Laura Fernández', 5, 'Diseño y construcción impecable. Muy agradecida con el servicio.', '2023-10-18 06:00:00'),
(22, 'Fernando Morales', 4, 'Trabajo limpio y bien estructurado. Los volveré a contratar.', '2024-04-25 06:00:00'),
(23, 'Isabela Cálix', 3, 'La obra cumplió su propósito, aunque esperaba más comunicación del personal.', '2023-06-08 06:00:00'),
(24, 'Roberto Ayala', 4, 'Remodelaron mi oficina y quedó muy funcional. Buen servicio.', '2024-02-17 06:00:00'),
(25, 'Natalia Pérez', 5, 'Superaron mis expectativas. Proyecto terminado antes del tiempo estimado.', '2025-06-29 06:00:00'),
(26, 'David Núñez', 4, 'Muy buenos en estructura y diseño. La obra quedó sólida y estética.', '2023-09-03 06:00:00'),
(27, 'Camila Méndez', 3, 'Bien en general, aunque algunos detalles se corrigieron en la entrega.', '2022-10-12 06:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `trabajos`
--

CREATE TABLE `trabajos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cliente` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `overview` text,
  `reto` text,
  `solucion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trabajos`
--

INSERT INTO `trabajos` (`id`, `titulo`, `categoria`, `fecha`, `cliente`, `descripcion`, `overview`, `reto`, `solucion`) VALUES
(4, 'Remodelacion de baño', 'Remodelaciones', '2024-01-19', 'Contrucciones Cano', '.......', '.............', '............', '...............'),
(5, 'Instalación de lámparas luz blanca', 'Instalaciones Eléctricas', '2024-07-20', 'Construcciones Cano', 'instalación de cuatro lámparas led', 'previsualizacion', 'problema', 'solucion'),
(6, 'Remodelacion de baño', 'Remodelaciones', '2024-09-20', 'Contrucciones Cano', 'Remodelacion de baño en el interior de un casa de habitacion, se reinstalo inodoro y se cambio la ceramica y diseño de la bañera, al igual que se coloco su respectiva puerta al area de la bañera', 'Planteamiento', 'Reto', 'Solucion'),
(7, 'Reconstruccion de baño', 'Reconstrucciones', '2025-03-05', 'Contrucciones Cano', 'Se reconstruyo por el completo el baño de una cuarto de una casa de habitacion, cambiando por completo su recubrimiento con laminas de porcelana, al igual que sus elementos principales como ser el inodoro y su bañera, al igual que se reconstruyo por completo el piso de este y por ultimo se agregaron elementos extra.', 'Planteamiento', 'Reto', 'Solucion'),
(8, 'Remodelacion de baño', 'Remodelaciones', '2024-05-18', 'Contrucciones Cano', 'Se hizo la remodelacion de un baño al interior de una casa de habitacion, cambiando el recubrimiento de su bañera al igual que se cambio el inodoro de este mismo', 'Planteamiento', 'Reto', 'Solucion');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `es_admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `clave`, `es_admin`) VALUES
(1, 'Admin', 'admin@admin.com', '12345', 1),
(2, 'yayo', 'yayo12@gmail.com', '123', 0),
(3, 'Aaron Isai Cano', 'aaronC@gmail.com', '1234567', 0),
(4, 'Jahir Emanuel Cano Carrasco', 'jahircano076@gmail.com', '7654321', 0),
(5, 'Zoe Nazareth', 'zoeN2@gmail.com', 'zoecano', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trabajo_id` (`trabajo_id`);

--
-- Indexes for table `opiniones`
--
ALTER TABLE `opiniones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trabajos`
--
ALTER TABLE `trabajos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `opiniones`
--
ALTER TABLE `opiniones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `trabajos`
--
ALTER TABLE `trabajos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`trabajo_id`) REFERENCES `trabajos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
