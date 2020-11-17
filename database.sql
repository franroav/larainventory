-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-11-2020 a las 15:32:51
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `larainventory`
--
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `surname`, `email`, `password`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'ROLE_USER', 'Francisco', 'Lopez', 'francisco@gmail.com', 'd2caa82cdb5a0a33f42b812083c4a4c5195805f5be2058cd9e8aec9ab6589bba', '2019-10-30 21:46:58', '2019-10-30 21:46:58', NULL),
(17, 'ROLE_USER', 'Francisco Roa', 'Valenzuela', 'franroav@webkonce.cl', 'd2caa82cdb5a0a33f42b812083c4a4c5195805f5be2058cd9e8aec9ab6589bba', '2020-06-02 15:04:08', '2020-06-02 15:04:08', NULL);

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `cars`
--

CREATE TABLE `cars` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `price` varchar(30) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cars`
--

INSERT INTO `cars` (`id`, `user_id`, `title`, `description`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ferrari Benz', 'Coche Rojo', '65000', 'false', '2019-11-02 14:34:12', '2019-11-03 15:46:16'),
(3, 17, 'Mercedes', 'un auto bonito', '45000', 'true', '2020-06-02 20:52:19', '2020-06-02 20:52:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`) VALUES
(19, 'Servicios', '2019-02-25 15:19:46'),
(20, 'Productos', '2019-02-25 15:19:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `documento` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras` int(11) NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `documento`, `email`, `telefono`, `direccion`, `fecha_nacimiento`, `compras`, `ultima_compra`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 'KOMATSU CHILE S A', '96.843.130-7', 'komatsu@komatsu.cl', '(+562) 2655-777_', 'Avda. Americo Vespucio 0631, Quilicura, 13 ', '0000-00-00', 113, '2019-05-24 17:08:07', '2020-11-17 15:19:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `referencia` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_fact` int(11) NOT NULL,
  `nro_cc` int(11) NOT NULL,
  `nro_cotizacion` int(11) NOT NULL,
  `id_cliente` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `alcance` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `exclusiones` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` float NOT NULL,
  `ruta_cotizacion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_cubicacion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_factura` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_dia` datetime NOT NULL,
  `ultima_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`id`, `nombre`, `referencia`, `estado`, `nro_fact`, `nro_cc`, `nro_cotizacion`, `id_cliente`, `descripcion`, `alcance`, `exclusiones`, `valor`, `ruta_cotizacion`, `ruta_cubicacion`, `ruta_factura`, `fecha_dia`, `ultima_fecha`, `created_at`, `updated_at`) VALUES
(1, '', 'CV', 'Terminado', 0, 0, 101, 'Esbbio', 'venta de equipos A.Ac', '', '', 0, '', '', '', '2019-02-26 00:00:00', '2020-11-17 15:21:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instaladores`
--

CREATE TABLE `instaladores` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `especialidad` varchar(255) DEFAULT NULL,
  `curriculum` varchar(255) DEFAULT NULL,
  `entregable` varchar(255) DEFAULT NULL,
  `precio` varchar(30) DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  CONSTRAINT fk_instaladores_users FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `instaladores`
--

INSERT INTO `instaladores` (`id`, `user_id`, `especialidad`, `curriculum`, `entregable`, `precio`, `estado`, `created_at`, `updated_at`) VALUES
(1, 17, 'Ingenieria Civl', 'vistas/assets/logo.png', 'Informe tecnico Caminos y plataformas, sector Lovino.', '15000', 'activo', '2020-06-02 20:56:57', '2020-06-02 21:52:41'),
(2, 17, 'Ingenieria Mecanica', 'vistas/assets/logo.png', 'Informe Técnico bombas sumidero sector Lovino', '22000', 'activo', '2020-06-02 21:35:01', '2020-06-02 21:35:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `tipo_pedido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_pedido` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `tipo_pedido`, `numero_pedido`, `created_at`, `updated_at`) VALUES
(1, 'Por Correo', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Terreno', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Pagina Web', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'WhatsApp', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Redes Sociales', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `descuento` int(11) NOT NULL,
  `unidad_medida` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `id_proveedor`, `codigo`, `descripcion`, `imagen`, `stock`, `precio_compra`, `precio_venta`, `ventas`, `descuento`, `unidad_medida`, `fecha`, `created_at`, `updated_at`) VALUES
(2, 19, 0, '1902', 'Instalación de Aire acondicionado Residencial', 'vistas/img/productos/default/anonymous.png', 10000, 250000, 250000, 0, 0, 'c/u', '2019-04-29 15:46:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 19, 0, '1903', 'Mantenimiento Preventivo para Equipo Resdiencial', 'vistas/img/productos/default/anonymous.png', 10000, 25000, 25000, 0, 0, 'c/u', '2019-04-29 15:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 19, 0, '1904', 'INGENIERIA EETT', 'vistas/img/productos/default/anonymous.png', 10000, 500000, 500000, 1, 0, 'c/u', '2019-04-29 15:48:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 19, 0, '1907', 'Jefe de Operaciones y Proyectos.', 'vistas/img/productos/default/anonymous.png', 10000, 10000, 10000, 0, 0, '', '2019-04-29 15:31:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 19, 0, '1908', 'Jefe de Servicios', 'vistas/img/productos/default/anonymous.png', 10000, 10000, 10000, 0, 0, 'hrs.', '2019-04-29 15:31:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 19, 0, '1909', 'Jefe de Terreno', 'vistas/img/productos/default/anonymous.png', 10000, 5000, 5000, 0, 0, 'hrs.', '2019-04-29 15:34:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 19, 0, '1910', 'Ingeniero Civil Mecánico', 'vistas/img/productos/default/anonymous.png', 10000, 5000, 5000, 0, 0, 'hrs.', '2019-05-24 21:03:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 19, 0, '1911', 'Técnico Profesional', 'vistas/img/productos/default/anonymous.png', 9990, 3500, 3500, 10, 0, 'hrs.', '2019-05-24 21:08:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 19, 0, '1912', 'Ayudante Técnico', 'vistas/img/productos/default/anonymous.png', 9990, 2000, 2000, 10, 0, 'hrs.', '2019-05-24 21:08:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 19, 0, '1913', 'Prevencionista de Riesgos', 'vistas/img/productos/default/anonymous.png', 10000, 4000, 4000, 0, 0, 'hrs.', '2019-04-29 15:39:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 19, 0, '1914', 'Analista Contable', 'vistas/img/productos/default/anonymous.png', 10000, 4000, 4000, 0, 0, '', '2019-04-29 15:41:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 20, 0, '2001', 'Aire acondicionado Blanc de Midea + C.M-Smart wifi-12.000 BTU', 'vistas/img/productos/default/anonymous.png', 10, 279990, 279990, 0, 0, 'c/u', '2019-04-29 15:52:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 20, 0, '2002', 'Aire acondicionado Blanc de Midea -12.000 BTU.', 'vistas/img/productos/default/anonymous.png', 9, 249990, 249990, 1, 0, 'c/u', '2019-06-28 16:16:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 20, 0, '2003', 'Aire acondicionado Blanc de Midea + C.M-Smart wifi-9.000 BTU', 'vistas/img/productos/default/anonymous.png', 9, 249990, 249990, 1, 0, 'c/u', '2019-06-28 16:16:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 19, 0, '1915', 'Aire acondicionado Anwo + Control-9.000 BTU', 'vistas/img/productos/default/anonymous.png', 10, 199000, 199000, 0, 0, 'c/u', '2019-05-24 21:21:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 19, 0, '1916', 'Reparacion Filtracion', 'vistas/img/productos/default/anonymous.png', 0, 120000, 108000, 1, 10, 'c/u', '2019-05-24 21:08:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 19, 4, '1917', 'Servicios  generales', 'vistas/img/productos/1917/478.png', 1, 100000, 100000, 0, 0, 'Unidades', '2020-03-11 16:09:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 19, 0, '1904', 'INGENIERIA EETT Modificada', 'vistas/img/productos/default/anonymous.png', 10000, 500000, 500000, 1, 0, 'c/u', '2019-04-29 15:48:53', '2020-11-16 21:44:27', '2020-11-16 21:56:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `documento` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_cuenta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuenta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_banco` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_dia` datetime NOT NULL,
  `ultima_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `nombre`, `documento`, `email`, `telefono`, `direccion`, `tipo_cuenta`, `nro_cuenta`, `tipo_banco`, `fecha_dia`, `ultima_fecha`, `created_at`, `updated_at`) VALUES
(4, 'COMERCIAL ANWO S.A.', '99.574.860-6', 'anwo@anwo.cl', '(+562) 2989-0000', 'Calle Presidente Eduardo Frei Montalva 17001 Parque Industrial La Reina Colina', 'Cuenta Corriente', '1231654651', 'BANCO DE CHILE', '2019-02-28 20:30:00', '2019-02-25 02:18:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_mesas` text COLLATE utf8_spanish_ci NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text COLLATE utf8_spanish_ci NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ruta_facturacion` text COLLATE utf8_spanish_ci NOT NULL,
  `ruta_guiadespacho` text COLLATE utf8_spanish_ci NOT NULL,
  `nro_cotizacion` int(11) NOT NULL,
  `alcance` text COLLATE utf8_spanish_ci NOT NULL,
  `exclusiones` text COLLATE utf8_spanish_ci NOT NULL,
  `nro_cc` int(11) NOT NULL,
  `nro_ot` int(11) NOT NULL,
  `estado` text COLLATE utf8_spanish_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `codigo`, `id_cliente`, `id_pedido`, `id_mesas`, `id_vendedor`, `productos`, `impuesto`, `neto`, `total`, `metodo_pago`, `fecha`, `ruta_facturacion`, `ruta_guiadespacho`, `nro_cotizacion`, `alcance`, `exclusiones`, `nro_cc`, `nro_ot`, `estado`, `created_at`, `updated_at`) VALUES
(2, 10001, 1, 4, '', 1, '[{\"id\":\"24\",\"descripcion\":\"Reparacion Filtracion\",\"cantidad\":\"1\",\"stock\":\"0\",\"precio\":\"108000\",\"descuento\":\"10\",\"total\":\"108000\"},{\"id\":\"17\",\"descripcion\":\"Ayudante Técnico\",\"cantidad\":\"10\",\"stock\":\"9990\",\"precio\":\"2000\",\"descuento\":\"0\",\"total\":\"20000\"},{\"id\":\"16\",\"descripcion\":\"Técnico Profesional\",\"cantidad\":\"10\",\"stock\":\"9990\",\"precio\":\"3500\",\"descuento\":\"0\",\"total\":\"35000\"}]', 0, 163000, 163000, 'TD-45226', '2019-05-24 21:08:07', 'vistas/ventafactura/1603/Array1603.pdf', 'vistas/guiadespacho/1603/Array1603.pdf', 1603, '', '', 0, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 10002, 118, 1, '', 1, '[{\"id\":\"22\",\"descripcion\":\"Aire acondicionado Blanc de Midea + C.M-Smart wifi-9.000 BTU\",\"cantidad\":\"1\",\"stock\":\"9\",\"precio\":\"249990\",\"descuento\":\"0\",\"total\":\"249990\"},{\"id\":\"21\",\"descripcion\":\"Aire acondicionado Blanc de Midea -12.000 BTU.\",\"cantidad\":\"1\",\"stock\":\"9\",\"precio\":\"249990\",\"descuento\":\"0\",\"total\":\"249990\"}]', 0, 499980, 499980, 'Efectivo', '2019-06-28 16:16:37', 'vistas/ventafactura/1622/Array1622.pdf', 'vistas/guiadespacho/1622/Array1622.pdf', 1622, '', '', 0, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cars_users` (`user_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `instaladores`
--
ALTER TABLE `instaladores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_instaladores_users` (`user_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1767;

--
-- AUTO_INCREMENT de la tabla `instaladores`
--
ALTER TABLE `instaladores`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `fk_cars_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `instaladores`
--
ALTER TABLE `instaladores`
  ADD CONSTRAINT `fk_instaladores_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
