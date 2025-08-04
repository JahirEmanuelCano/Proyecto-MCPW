-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 08-07-2025 a las 04:52:29
-- Versión del servidor: 5.7.24
-- Versión de PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_portafolio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
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
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `correo`, `asunto`, `mensaje`, `fecha`) VALUES
(1, 'Jahir Emanuel Cano Carrasco', 'yayo12@gmail.com', 'remodelacion de baño', 'me contacto con ustedes para la reparacion de tuberias de mi baño y cambio de ceramica de la regadera', '2025-07-04 19:26:20'),
(2, 'PRUEBA', 'PRUEBA@io.com', 'PRUEBA', 'PRUEBA', '2025-07-04 21:27:12'),
(3, 'PRUEBA', 'PRUEBA@io.com', 'PRUEBA', 'PRUEBA', '2025-07-07 05:28:32'),
(4, 'PRUEBA', 'PRUEBA@io.com', 'PRUEBA', 'PRUEBA', '2025-07-07 05:28:51'),
(5, 'cc', 'c@12.com', 'c', 'c', '2025-07-07 21:18:40'),
(6, 'cc', 'c@12.com', 'c', 'c', '2025-07-07 21:19:27'),
(7, 'cc', 'c@12.com', 'c', 'c', '2025-07-07 21:19:57'),
(8, 'cc', 'c@12.com', 'c', 'c', '2025-07-07 21:20:47'),
(9, 'emanuel', 'j@gmail.com', 'contruccion de casa', '....', '2025-07-08 04:15:57'),
(10, 'Jahir ', 'jahircano076@gmail.com', 'hola', 'hola', '2025-07-08 04:44:19'),
(11, 'Jahir ', 'jahircano076@gmail.com', 'hola', 'hola', '2025-07-08 04:44:26'),
(12, 'Jahir ', 'jahircano076@gmail.com', 'hola', 'hola', '2025-07-08 04:46:18'),
(13, 'Jahir ', 'jahircano076@gmail.com', 'hola', 'hola', '2025-07-08 04:48:51'),
(14, 'yayo', 'j...6@gmail.com', 'hola', 'aaa', '2025-07-08 04:49:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL,
  `trabajo_id` int(11) DEFAULT NULL,
  `ruta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `trabajo_id`, `ruta`) VALUES
(1, 2, 'uploads/1751790062_Captura de pantalla 2024-09-17 220055.png'),
(3, 4, 'uploads/1751949147_IMG-20250624-WA0018.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opiniones`
--

CREATE TABLE `opiniones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `comentario` text,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `opiniones`
--

INSERT INTO `opiniones` (`id`, `nombre`, `calificacion`, `comentario`, `fecha`) VALUES
(1, 'PRUEBA 1', 1, 'PRUEBA 1', '2025-07-06 02:21:41'),
(2, 'PRUEBA2', 2, 'PRUEBA2', '2025-07-06 05:22:16'),
(3, 'PRUEBA3', 3, 'PRUEBA3', '2025-07-07 05:22:25'),
(4, 'PRUEBA4', 4, 'PRUEBA', '2025-07-07 05:22:39'),
(5, 'PRUEBA5', 5, 'PRUEBA5', '2025-07-07 05:22:58'),
(6, 'Jahir Cano', 5, 'Comppletamente satisfecho con los trabajos realizados en mi hogar.\r\n', '2025-07-07 05:23:30'),
(7, 'Lewandoski', 4, 'sin comentarios', '2025-07-07 21:34:18'),
(8, 'Lewandoski', 4, 'sin comentarios', '2025-07-07 21:46:15'),
(9, 'Jose', 4, 'sin comentario', '2025-07-08 04:16:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos`
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
-- Volcado de datos para la tabla `trabajos`
--

INSERT INTO `trabajos` (`id`, `titulo`, `categoria`, `fecha`, `cliente`, `descripcion`, `overview`, `reto`, `solucion`) VALUES
(1, 'prueba', 'prueba', '2025-07-06', 'prueba', 'pruebapruebaprueba', 'prueba', 'prueba', 'prueba'),
(2, 'prueba', 'prueba', '2025-07-05', 'pruebaprueba', 'pruebaprueba', 'pruebaprueba', 'pruebaprueba', 'pruebaprueba'),
(4, 'Remodelacion de baño', 'Remodelaciones', '2024-01-19', 'Armando Casas', '.......', '.............', '............', '...............');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `es_admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `clave`, `es_admin`) VALUES
(1, 'Admin', 'admin@admin.com', '12345', 1),
(2, 'yayo', 'yayo12@gmail.com', '123', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trabajo_id` (`trabajo_id`);

--
-- Indices de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`trabajo_id`) REFERENCES `trabajos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
