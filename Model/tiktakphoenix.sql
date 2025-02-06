-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2020 a las 18:24:26
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- -------------------------- --
-- Base de datos: `TikTakPhoenix` --
-- -------------------------- --
CREATE DATABASE IF NOT EXISTS `tiktakphoenix` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `tiktakphoenix`;


-- ------- --
-- USUARIO --
-- ------- --
GRANT ALL PRIVILEGES ON *.* TO 'tiktakphoenix'@'localhost' IDENTIFIED BY 'tsw_21' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `tiktakphoenix`.* TO 'tiktakphoenix'@'localhost';

--
-- Estructura de tabla para la tabla `seguidores`
--

CREATE TABLE `seguidores` (
  `id` int(11) NOT NULL,
  `login` int(11) NOT NULL,
  `login_seguidor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `seguidores`
--

INSERT INTO `seguidores` (`id`, `login`, `login_seguidor`) VALUES
(1, 6, 1),
(2, 6, 2),
(3, 6, 3),
(4, 6, 4),
(5, 6, 5),
(6, 6, 11),
(7, 6, 7),
(8, 6, 8),
(9, 6, 9),
(10, 6, 10),
(11, 7, 1),
(12, 7, 2),
(13, 7, 3),
(14, 7, 4),
(15, 7, 5),
(16, 7, 6),
(17, 7, 11),
(18, 7, 8),
(19, 7, 9),
(20, 8, 1),
(21, 8, 2),
(22, 8, 3),
(23, 8, 4),
(24, 8, 5),
(25, 8, 6),
(26, 8, 7),
(27, 8, 11),
(28, 9, 1),

(29, 9, 2),

(30, 9, 3),
(31, 9, 4),
(32, 9, 5),
(33, 9, 6),
(34, 9, 7),
(35, 10, 1),

(36, 10, 2),

(37, 10, 3),
(38, 10, 4),
(39, 10, 5),
(40, 10, 6),
(41, 1, 11),
(42, 1, 2),
(43, 1, 3),
(44, 1, 4),
(45, 1, 5),

(46, 2, 1),
(47, 2, 11),
(48, 2, 3),
(49, 2, 4),

(50, 3, 1),
(51, 3, 2),
(52, 3, 11),
(53, 4, 1),
(54, 4, 2),
(55, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `rol` enum('usuario_normal','administrador') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'usuario_normal',
  `alias` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nacimiento` date NOT NULL,
  `foto_perfil` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '../Files/Imagenes/-/-.png',
  `n_seguidores` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `contrasena`, `rol`, `alias`, `email`, `nacimiento`, `foto_perfil`, `n_seguidores`) VALUES
(1, 'tkphoenix', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'administrador', 'TKPhoenix', 'tkphoenix@gmail.com', '1992-09-03', '../Files/Imagenes/tkphoenix/-.png', 5),
(2, 'surt', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'usuario_normal', 'Vinland', 'surt@gmail.com', '1992-09-03', '../Files/Imagenes/surt/-.png', 4),
(3, 'uhozo', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'usuario_normal', 'HashtagInverso', 'uhozo@gmail.com', '1992-09-03', '../Files/Imagenes/uhozo/-.png', 3),
(4, 'joao', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'usuario_normal', 'SalsaSalsa', 'joao@gmail.com', '1992-09-03', '../Files/Imagenes/joao/-.png', 2),
(5, 'midnightoil', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'usuario_normal', 'Truganini', 'midnightoil@gmail.com', '1992-09-03', '../Files/Imagenes/midnightoil/-.png', 1),
(6, 'mr7', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'usuario_normal', 'D.Vladivostok', 'mr7@gmail.com', '1992-09-03', '../Files/Imagenes/mr7/-.png', 10),
(7, 'trivium', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'usuario_normal', 'Shogun', 'trivium@gmail.com', '1992-09-03', '../Files/Imagenes/trivium/-.png', 9),
(8, 'fdt', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'usuario_normal', 'Troncoso', 'fdt@gmail.com', '1992-09-03', '../Files/Imagenes/fdt/-.png', 8),
(9, 'pantera', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'usuario_normal', 'Walk', 'pantera@gmail.com', '1992-09-03', '../Files/Imagenes/pantera/-.png', 7),
(10, 'barral', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'usuario_normal', 'MorritosBarral', 'barral@gmail.com', '1992-09-03', '../Files/Imagenes/barral/-.png', 6),
(11, 'lume', 'YU5VZFFHNDJ6WXVMQmQ1eDh1NEY5Zz09', 'usuario_normal', 'Voltaremos', 'lume@gmail.com', '1992-09-03', '../Files/Imagenes/lume/-.png', 0);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `autor` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `texto` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ubicacion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_subida` datetime NOT NULL,
  `n_likes` int(11) NOT NULL DEFAULT 0,
  `visible` enum('es_visible','no_visible') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'es_visible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`id`, `autor`, `nombre`, `texto`, `ubicacion`, `fecha_subida`, `n_likes`, `visible`) VALUES
(1, 5, 'Cat - 35693.webm', 'Y al fin la última prueba y como no otro video de la promo. #SeguimosReciclando #TikTokPhoenix', '../Files/Videos/midnightoil/Cat - 35693.webm', '2020-11-09 13:37:12', 6,'es_visible'),


(2, 4, 'Alone - 46637.webm', 'Volvemos a rellenar texto y video con material del la promo. #SeguimosReciclando #TikTokPhoenix ', '../Files/Videos/joao/Alone - 46637.webm', '2020-11-09 23:37:12', 4,'es_visible'),


(3, 3, 'Sea - 42481.webm', 'Aquí otra secuencia del video promocional y otro texto sin ningún interés. #SeguimosReciclando #TikTokPhoenix', '../Files/Videos/uhozo/Sea - 42481.webm', '2020-11-10 09:37:12', 5,'es_visible'),


(4, 2, 'Puppy - 4740.webm', 'En nuestro afán de no tirar el material, aquí una de las secuencias del banco gratuito usado para crear el video promocional. #SeguimosReciclando #TikTokPhoenix', '../Files/Videos/surt/Puppy - 4740.webm', '2020-11-10 10:37:12', 9,'es_visible'),


(5, 1, 'TSW_Video_promo.webm', 'Vídeo promocional que hicimos para el hover desplegable creado en el \"home estándar\" y ahora aprovechamos aquí. #Confusion #AprovecharMateral #TikTokPhoenix', '../Files/Videos/tkphoenix/TSW_Video_promo.webm', '2020-11-10 13:37:12', 7,'es_visible'),

(6, 6, 'Tromso - 36084.webm', 'Vídeo de prueba para ocultar o no dependiendo de si es visible', '../Files/Videos/mr7/Tromso - 36084.webm', '2020-11-10 13:37:12', 0,'es_visible'),

(7, 7, 'Wolf - 27367.webm', 'Vídeo de prueba para ocultar o no dependiendo de si es visible', '../Files/Videos/trivium/Wolf - 27367.webm', '2020-11-10 13:37:12', 0,'es_visible'),

(8, 8, 'production ID_4623570.webm', 'Vídeo de prueba para ocultar o no dependiendo de si es visible', '../Files/Videos/fdt/production ID_4623570.webm', '2020-11-10 13:37:12', 0,'es_visible'),

(9, 9, 'Ink - 35506.webm', 'Vídeo de prueba para ocultar o no dependiendo de si es visible', '../Files/Videos/pantera/Ink - 35506.webm', '2020-11-10 13:37:12', 0,'es_visible'),

(10, 10, 'Mountain - 49515.webm', 'Vídeo de prueba para ocultar o no dependiendo de si es visible', '../Files/Videos/barral/Mountain - 49515.webm', '2020-11-10 13:37:12', 0,'es_visible'),

(11, 2, 'production ID_4623570.webm', 'Vídeo de prueba para ocultar o no dependiendo de si es visible', '../Files/Videos/surt/production ID_4623570.webm', '2020-11-10 13:37:12', 0,'es_visible');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos_favoritos`
--

CREATE TABLE `videos_favoritos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_video` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `videos_favoritos`
--

INSERT INTO `videos_favoritos` (`id`, `id_usuario`, `id_video`) VALUES
(1, 1, 1),
(2, 7, 1),
(3, 8, 1),
(4, 9, 1),
(5, 10, 1),

(6, 2, 2),
(7, 6, 2),
(8, 7, 2),
(9, 8, 2),
(10, 9, 2),
(11, 10, 2),

(12, 6, 3),
(13, 7, 3),
(14, 8, 3),

(15, 4, 4),
(16, 6, 4),

(17, 5, 5),
(18, 6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos_likes`
--

CREATE TABLE `videos_likes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_video` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `videos_likes`
--

INSERT INTO `videos_likes` (`id`, `id_usuario`, `id_video`) VALUES
(1, 6, 1),
(2, 7, 1),
(3, 8, 1),
(4, 9, 1),
(5, 10, 1),
(6, 11, 1),
(7, 2, 1),

(8, 6, 2),
(9, 7, 2),
(10, 8, 2),
(11, 9, 2),
(12, 10, 2),
(13, 11, 2),
(14, 1, 2),
(15, 2, 2),
(16, 3, 2),

(17, 6, 3),
(18, 7, 3),
(19, 9, 3),
(20, 10, 3),
(21, 5, 3),

(22, 6, 4),
(23, 7, 4),
(24, 8, 4),
(25, 4, 4),

(26, 6, 5),
(27, 7, 5),
(28, 8, 5),
(29, 9, 5),
(30, 10, 5),
(31, 3, 5);

--
-- Índices para tablas volcadas
--



CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `n_veces` int(11) NOT NULL,
  `imagen` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '../Files/Hashtags/-/-.png',
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `hashtags`
--

INSERT INTO `hashtags` (`id`, `nombre`, `n_veces`,`imagen`,`fecha`) VALUES
(1, '#NTMEP', 0,'../Files/Hashtags/NTMEP/-.png', '2020-11-01'),
(2, '#CuantoSufrimosMartin', 0,'../Files/Hashtags/CuantoSufrimosMartin/-.png', '2020-11-01'),
(3, '#DimitriVladivostok', 0,'../Files/Hashtags/DimitriVladivostok/-.png', '2020-11-01'),
(4, '#Aurelios', 0,'../Files/Hashtags/Aurelios/-.png', '2020-11-01'),
(5, '#Enekinha', 0,'../Files/Hashtags/Enekinha/-.png', '2020-11-01'),

(6, '#Confusion', 1,'../Files/Hashtags/-/-_3.png', '2020-11-01'),
(7, '#AprovecharMateral', 1,'../Files/Hashtags/-/-.png', '2020-11-01'),
(8, '#SeguimosReciclando', 4,'../Files/Hashtags/-/-_3.png', '2020-11-01'),
(9, '#TikTokPhoenix', 5,'../Files/Hashtags/-/-_2.png', '2020-11-01');




CREATE TABLE `videos_hashtags` (
  `id` int(11) NOT NULL,
  `id_hashtag` int(11) NOT NULL,
  `id_video` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `videos_hashtags`
--

INSERT INTO `videos_hashtags` (`id`, `id_hashtag`, `id_video`) VALUES
(1, 9, 1),
(2, 9, 2),
(3, 9, 3),
(4, 9, 4),
(5, 9, 5),

(6, 8, 1),
(7, 8, 2),
(8, 8, 3),
(9, 8, 4),

(10, 7, 5),

(11, 6, 5);





--
-- Indices de la tabla `seguidores`
--
ALTER TABLE `seguidores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seguidores_ibfk_1` (`login`),
  ADD KEY `seguidores_ibfk_2` (`login_seguidor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_ibfk_1` (`autor`);

--
-- Indices de la tabla `videos_favoritos`
--
ALTER TABLE `videos_favoritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_favoritos_ibfk_1` (`id_usuario`),
  ADD KEY `videos_favoritos_ibfk_2` (`id_video`);

--
-- Indices de la tabla `videos_likes`
--
ALTER TABLE `videos_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_likes_ibfk_1` (`id_usuario`),
  ADD KEY `videos_likes_ibfk_2` (`id_video`);


--
-- Indices de la tabla `hashtags`
--
ALTER TABLE `hashtags`
  ADD PRIMARY KEY (`id`);


--
-- Indices de la tabla `videos_hashtags`
--
ALTER TABLE `videos_hashtags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_hashtags_ibfk_1` (`id_hashtag`),
  ADD KEY `videos_hashtags_ibfk_2` (`id_video`);






--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `seguidores`
--
ALTER TABLE `seguidores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `videos_favoritos`
--
ALTER TABLE `videos_favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `videos_likes`
--
ALTER TABLE `videos_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `videos_hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `seguidores`
--
ALTER TABLE `seguidores`
  ADD CONSTRAINT `seguidor_ibfk_1` FOREIGN KEY (`login`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seguidor_ibfk_2` FOREIGN KEY (`login_seguidor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `videos_favoritos`
--
ALTER TABLE `videos_favoritos`
  ADD CONSTRAINT `videos_favoritos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `videos_favoritos_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `videos_likes`
--
ALTER TABLE `videos_likes`
  ADD CONSTRAINT `videos_likes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `videos_likes_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id`);
COMMIT;

--
-- Filtros para la tabla `videos_likes`
--
ALTER TABLE `videos_hashtags`
  ADD CONSTRAINT `videos_hashtags_ibfk_1` FOREIGN KEY (`id_hashtag`) REFERENCES `hashtags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `videos_hashtags_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `videos` (`id`);
COMMIT;

















/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
