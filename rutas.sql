--
-- Base de datos: `rutas`
--
CREATE DATABASE IF NOT EXISTS `rutas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rutas`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugares_destacados`
--

CREATE TABLE `lugares_destacados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `distancia_desde_inicio` decimal(10,2) NOT NULL,
  `ruta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `id` int(11) NOT NULL,
  `lugar_inicio` varchar(100) NOT NULL,
  `distancia_total` decimal(10,2) NOT NULL,
  `lugar_termino` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lugares_destacados`
--
ALTER TABLE `lugares_destacados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruta_id` (`ruta_id`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lugares_destacados`
--
ALTER TABLE `lugares_destacados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lugares_destacados`
--
ALTER TABLE `lugares_destacados`
  ADD CONSTRAINT `lugares_destacados_ibfk_1` FOREIGN KEY (`ruta_id`) REFERENCES `rutas` (`id`);