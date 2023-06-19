-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2023 at 05:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyecto`
--
CREATE Database if not exists proyecto;
USE proyecto;
-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombreCategoria` text DEFAULT NULL,
  `fk_grupo` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nombreCategoria`, `fk_grupo`) VALUES
(1, 'IAW', 2),
(2, 'AXBD', 2),
(3, 'ASO', 2),
(4, 'EIE', 2),
(5, 'SRI', 2),
(6, 'SAD', 2),
(7, 'FOL', 2);

-- --------------------------------------------------------

--
-- Table structure for table `examenes`
--

CREATE TABLE `examenes` (
  `id` int(11) NOT NULL,
  `titulo` text DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL,
  `fk_categoria` int(11) DEFAULT NULL,
  `puntuacionTotal` int(11) DEFAULT NULL,
  `borrado` tinyint(1) DEFAULT NULL,
  `creador` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examenes`
--

INSERT INTO `examenes` (`id`, `titulo`, `grupo`, `fk_categoria`, `puntuacionTotal`, `borrado`, `creador`) VALUES
(1, 'IAW_Examen1', 1, 1, 10, 0, 'profesor1@example.com'),
(2, 'IAW_Examen2', 1, 1, 10, 0, 'profesor2@example.com'),
(3, 'AXDB_Examen1', 2, 2, 20, 1, 'profesor2@example.com'),
(4, 'AXDB_Examen2', 2, 2, 20, 0, 'profesor1@example.com'),
(5, 'ASO_Examen1', 2, 3, 10, 0, 'profesor2@example.com'),
(6, 'ASO_Examen2', 2, 3, 20, 0, 'profesor1@example.com'),
(7, 'SRI_Examen1', 2, 5, 10, 0, 'profesor1@example.com'),
(8, 'SRI_Examen2', 2, 5, 10, 0, 'profesor1@example.com'),
(9, 'EIE_Examen1', 2, 4, 100, 0, 'profesor2@example.com'),
(10, 'EIE_Examen2', 2, 4, 10, 0, 'profesor2@example.com'),
(11, 'SAD_Examen1', 2, 6, 12, 0, 'profesor1@example.com'),
(12, 'SAD_Examen2', 2, 6, 10, 1, 'profesor2@example.com'),
(13, 'FOL_Examen', 2, 7, 15, 0, 'profesor2@example.com'),
(14, 'FOL_Examen', 2, 7, 15, 0, 'profesor2@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `examenes_usuarios`
--

CREATE TABLE `examenes_usuarios` (
  `id` int(11) NOT NULL,
  `examen` int(11) DEFAULT NULL,
  `usuario` varchar(40) DEFAULT NULL,
  `nota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examenes_usuarios`
--

INSERT INTO `examenes_usuarios` (`id`, `examen`, `usuario`, `nota`) VALUES
(1, 1, 'usuario2@example.com', 6),
(2, 2, 'usuario2@example.com', 5),
(3, 3, 'usuario1@example.com', 4),
(4, 4, 'usuario1@example.com', 10),
(5, 5, 'usuario2@example.com', 10),
(6, 6, 'usuario2@example.com', 5),
(7, 7, 'usuario2@example.com', 1),
(8, 8, 'usuario1@example.com', 2),
(9, 9, 'usuario1@example.com', 4),
(10, 10, 'usuario2@example.com', 3),
(11, 11, 'usuario1@example.com', 10),
(12, 12, 'usuario2@example.com', 10),
(13, 13, 'usuario1@example.com', 15),
(14, 14, 'usuario1@example.com', 0),
(15, 14, 'usuario2@example.com', 15),
(16, 3, 'usuario2@example.com', 0),
(17, 4, 'usuario2@example.com', 0),
(18, 5, 'usuario2@example.com', 0),
(19, 1, 'usuario2@example.com', 2),
(20, 13, 'usuario2@example.com', 15),
(21, 13, 'usuario2@example.com', 15);

-- --------------------------------------------------------

--
-- Table structure for table `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `nombreGrupo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grupos`
--

INSERT INTO `grupos` (`id`, `nombreGrupo`) VALUES
(1, '1ºASIR'),
(2, '2ºASIR'),
(3, 'Profesorado'),
(4, 'Administración');

-- --------------------------------------------------------

--
-- Table structure for table `incidentes`
--

CREATE TABLE `incidentes` (
  `id` int(11) NOT NULL,
  `cuerpo` text DEFAULT NULL,
  `usuario` varchar(40) DEFAULT NULL,
  `resuelto` int(11) DEFAULT NULL,
  `respuesta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidentes`
--

INSERT INTO `incidentes` (`id`, `cuerpo`, `usuario`, `resuelto`, `respuesta`) VALUES
(1, 'Problema del usuario 1', 'usuario1@example.com', 1, 'Resuelto el problema del usuario 1'),
(2, 'Problema del usuario 2', 'usuario2@example.com', 0, ''),
(3, 'Problema del profesor 1', 'profesor2@example.com', 1, 'Resuelto el problema del usuario 2'),
(4, 'Problema del profesor 1', 'profesor1@example.com', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `pregunta`
--

CREATE TABLE `pregunta` (
  `id` int(11) NOT NULL,
  `enunciado` text DEFAULT NULL,
  `respuestaA` text DEFAULT NULL,
  `respuestaB` text DEFAULT NULL,
  `respuestaC` text DEFAULT NULL,
  `respuestaD` text DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `correcto` text DEFAULT 'Respuesta_A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pregunta`
--

INSERT INTO `pregunta` (`id`, `enunciado`, `respuestaA`, `respuestaB`, `respuestaC`, `respuestaD`, `categoria`, `correcto`) VALUES
(1, 'IAW_Examen1_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 1, 'Respuesta_A'),
(2, 'IAW_Examen1_enunciado2', 'Respuesta_A2', 'Respuesta_B2', 'Respuesta_C2', 'Respuesta_D2', 1, 'Respuesta_A'),
(3, 'IAW_Examen1_enunciado3', 'Respuesta_A3', 'Respuesta_B3', 'Respuesta_C3', 'Respuesta_D3', 1, 'Respuesta_A'),
(4, 'IAW_Examen1_enunciado4', 'Respuesta_A4', 'Respuesta_B4', 'Respuesta_C4', 'Respuesta_D4', 1, 'Respuesta_A'),
(5, 'IAW_Examen1_enunciado5', 'Respuesta_A5', 'Respuesta_B5', 'Respuesta_C5', 'Respuesta_D5', 1, 'Respuesta_A'),
(6, 'IAW_Examen2_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 1, 'Respuesta_A'),
(7, 'IAW_Examen2_enunciado2', 'Respuesta_A2', 'Respuesta_B2', 'Respuesta_C2', 'Respuesta_D2', 1, 'Respuesta_A'),
(8, 'IAW_Examen2_enunciado3', 'Respuesta_A3', 'Respuesta_B3', 'Respuesta_C3', 'Respuesta_D3', 1, 'Respuesta_A'),
(9, 'ASXBD_Examen1_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 2, 'Respuesta_A'),
(10, 'ASXBD_Examen2_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 2, 'Respuesta_A'),
(11, 'ASO_Examen1_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 3, 'Respuesta_A'),
(12, 'ASO_Examen2_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 3, 'Respuesta_A'),
(13, 'EIE_Examen1_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 4, 'Respuesta_A'),
(14, 'EIE_Examen2_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 4, 'Respuesta_A'),
(15, 'SRI_Examen1_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 5, 'Respuesta_A'),
(16, 'SRI_Examen2_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 5, 'Respuesta_A'),
(17, 'SAD_Examen1_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 6, 'Respuesta_A'),
(18, 'SAD_Examen2_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 6, 'Respuesta_A'),
(19, 'FOL_Examen1_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 7, 'Respuesta_A'),
(20, 'FOL_Examen2_enunciado', 'Respuesta_A', 'Respuesta_B', 'Respuesta_C', 'Respuesta_D', 7, 'Respuesta_A');

-- --------------------------------------------------------

--
-- Table structure for table `preguntas_examenes`
--

CREATE TABLE `preguntas_examenes` (
  `examen` int(11) NOT NULL,
  `pregunta` int(11) NOT NULL,
  `puntuacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preguntas_examenes`
--

INSERT INTO `preguntas_examenes` (`examen`, `pregunta`, `puntuacion`) VALUES
(1, 1, 2),
(1, 2, 2),
(1, 3, 2),
(1, 4, 2),
(1, 5, 2),
(2, 6, 3),
(2, 7, 3),
(2, 8, 3),
(3, 9, 20),
(4, 10, 20),
(5, 11, 10),
(6, 12, 20),
(7, 13, 10),
(8, 14, 10),
(9, 15, 100),
(10, 16, 10),
(11, 17, 12),
(12, 18, 10),
(13, 19, 15),
(14, 20, 15);

-- --------------------------------------------------------

--
-- Table structure for table `tiposuser`
--

CREATE TABLE `tiposuser` (
  `id` int(11) NOT NULL,
  `nombreTipo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tiposuser`
--

INSERT INTO `tiposuser` (`id`, `nombreTipo`) VALUES
(1, 'alumno'),
(2, 'profesor'),
(3, 'administrador');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `correo` varchar(40) NOT NULL,
  `password` text DEFAULT NULL,
  `nombre` text DEFAULT NULL,
  `apellidos` text DEFAULT NULL,
  `tipoUsuario` int(11) DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`correo`, `password`, `nombre`, `apellidos`, `tipoUsuario`, `grupo`) VALUES
('administrador1@example.com', 'abc123.', 'Administrador', 'Admin Admin', 3, 4),
('profesor1@example.com', 'cba1', 'Marta', 'Sanchez Alejandre', 2, 3),
('profesor2@example.com', 'cba2', 'Emilio', 'Cuesta Molina', 2, 3),
('usuario1@example.com', 'abc1', 'Ernesto', 'García Pazo', 1, 1),
('usuario2@example.com', 'abc2', 'Juan', 'Guerra Lordán', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_grupo` (`fk_grupo`);

--
-- Indexes for table `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creador` (`creador`),
  ADD KEY `grupo` (`grupo`);

--
-- Indexes for table `examenes_usuarios`
--
ALTER TABLE `examenes_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examen` (`examen`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `incidentes`
--
ALTER TABLE `incidentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria` (`categoria`);

--
-- Indexes for table `preguntas_examenes`
--
ALTER TABLE `preguntas_examenes`
  ADD PRIMARY KEY (`examen`,`pregunta`),
  ADD KEY `pregunta` (`pregunta`);

--
-- Indexes for table `tiposuser`
--
ALTER TABLE `tiposuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`correo`),
  ADD KEY `grupo` (`grupo`),
  ADD KEY `tipoUsuario` (`tipoUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `examenes`
--
ALTER TABLE `examenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `examenes_usuarios`
--
ALTER TABLE `examenes_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incidentes`
--
ALTER TABLE `incidentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tiposuser`
--
ALTER TABLE `tiposuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`fk_grupo`) REFERENCES `grupos` (`id`);

--
-- Constraints for table `examenes`
--
ALTER TABLE `examenes`
  ADD CONSTRAINT `examenes_ibfk_1` FOREIGN KEY (`creador`) REFERENCES `usuarios` (`correo`),
  ADD CONSTRAINT `examenes_ibfk_2` FOREIGN KEY (`grupo`) REFERENCES `grupos` (`id`);

--
-- Constraints for table `examenes_usuarios`
--
ALTER TABLE `examenes_usuarios`
  ADD CONSTRAINT `examenes_usuarios_ibfk_1` FOREIGN KEY (`examen`) REFERENCES `examenes` (`id`),
  ADD CONSTRAINT `examenes_usuarios_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`correo`);

--
-- Constraints for table `incidentes`
--
ALTER TABLE `incidentes`
  ADD CONSTRAINT `incidentes_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`correo`);

--
-- Constraints for table `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`);

--
-- Constraints for table `preguntas_examenes`
--
ALTER TABLE `preguntas_examenes`
  ADD CONSTRAINT `preguntas_examenes_ibfk_1` FOREIGN KEY (`examen`) REFERENCES `examenes` (`id`),
  ADD CONSTRAINT `preguntas_examenes_ibfk_2` FOREIGN KEY (`pregunta`) REFERENCES `pregunta` (`id`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`grupo`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`tipoUsuario`) REFERENCES `tiposuser` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
