-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 03-10-2020 a las 11:30:40
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `h2olmos_h2soft`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accion` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tabla` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registro_id` bigint(20) UNSIGNED DEFAULT NULL,
  `valor_anterior` json DEFAULT NULL,
  `valor_posterior` json DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



--
-- Estructura de tabla para la tabla `abastecimiento`
--

CREATE TABLE `abastecimiento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `abastecimiento`
--

INSERT INTO `abastecimiento` (`id`, `descripcion`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'OLMOS', NULL, '2020-09-29 00:11:30', '2020-09-29 00:11:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abastecimiento_combustible`
--

CREATE TABLE `abastecimiento_combustible` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha_abastecimiento` date NOT NULL,
  `grifo_id` bigint(20) UNSIGNED NOT NULL,
  `conductor_id` bigint(20) UNSIGNED NOT NULL,
  `conductor_fake` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ua_id` bigint(20) UNSIGNED NOT NULL,
  `equipo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehiculo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qtdgl` double(8,2) NOT NULL,
  `qtdl` double(8,2) NOT NULL,
  `km` double(8,2) NOT NULL,
  `abastecimiento_dia` double(8,2) NOT NULL,
  `motivo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comprobante` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_comprobante` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `abastecimiento_id` int(11) NOT NULL,
  `tipocombustible_id` int(11) NOT NULL,
  `especial` tinyint NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `abastecimiento_combustible`
--

-- INSERT INTO `abastecimiento_combustible` (`id`, `fecha_abastecimiento`, `grifo_id`, `conductor_id`, `conductor_fake`, `ua_id`, `equipo_id`, `vehiculo_id`, `qtdgl`, `qtdl`, `km`, `abastecimiento_dia`, `motivo`, `comprobante`, `numero_comprobante`, `hora_inicio`, `hora_fin`, `abastecimiento_id`, `tipocombustible_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
-- (1, '2020-09-29', 1, 2, NULL, 25, 1, NULL, 100.00, 378.54, 1000.00, 20.00, 'TRABAJO PV', 'BOLETA', 'B01-051601', '15:00:00', '15:30:00', 1, 4, '2020-09-29 09:12:56', '2020-09-29 09:12:56', NULL),
-- (2, '2020-09-29', 1, 7, NULL, 25, 1, NULL, 50.00, 189.27, 3500.00, 20.00, 'POR TRABAJO', 'FACTURA', 'F12-3212', '12:00:00', '12:50:00', 1, 4, '2020-09-29 09:40:54', '2020-09-29 09:40:54', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE `acceso` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipouser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `opcionmenu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`id`, `tipouser_id`, `opcionmenu_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(2, 1, 2, '2020-09-09 07:35:34', '2020-09-10 00:35:50', '2020-09-10 00:35:50'),
(3, 1, 3, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(4, 1, 4, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(5, 1, 5, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(6, 1, 6, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(7, 1, 7, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(8, 1, 8, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(9, 1, 9, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(10, 1, 10, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(11, 1, 11, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(12, 1, 12, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(13, 1, 13, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(14, 1, 14, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(15, 1, 15, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(16, 1, 16, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(17, 1, 17, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(18, 1, 18, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(19, 1, 19, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(20, 1, 20, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(21, 1, 21, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(22, 1, 22, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(23, 2, 1, '2020-09-09 07:35:34', '2020-09-15 09:25:47', '2020-09-15 09:25:47'),
(24, 2, 2, '2020-09-09 07:35:34', '2020-09-10 00:35:59', '2020-09-10 00:35:59'),
(25, 2, 5, '2020-09-09 07:48:23', '2020-09-09 07:48:23', NULL),
(26, 2, 8, '2020-09-09 07:48:23', '2020-09-09 07:48:23', NULL),
(27, 2, 9, '2020-09-09 07:48:23', '2020-09-09 07:48:23', NULL),
(28, 2, 14, '2020-09-09 07:48:24', '2020-09-09 07:48:24', NULL),
(29, 2, 18, '2020-09-09 07:48:24', '2020-09-09 07:48:24', NULL),
(30, 2, 16, '2020-09-09 07:48:24', '2020-09-09 07:48:24', NULL),
(31, 3, 1, '2020-09-09 07:49:20', '2020-09-15 09:26:22', '2020-09-15 09:26:22'),
(32, 3, 2, '2020-09-09 07:49:20', '2020-09-10 00:35:54', '2020-09-10 00:35:54'),
(33, 3, 3, '2020-09-09 07:49:20', '2020-09-09 07:49:20', NULL),
(34, 3, 5, '2020-09-09 07:49:20', '2020-09-09 07:49:20', NULL),
(35, 3, 6, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(36, 3, 7, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(37, 3, 8, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(38, 3, 9, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(39, 3, 10, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(40, 3, 11, '2020-09-09 07:49:21', '2020-09-15 09:10:12', '2020-09-15 09:10:12'),
(41, 3, 14, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(42, 3, 15, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(43, 3, 17, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(44, 3, 19, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(45, 3, 20, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(46, 3, 22, '2020-09-09 07:49:21', '2020-09-09 07:49:21', NULL),
(47, 4, 1, '2020-09-09 07:50:17', '2020-09-09 07:50:17', NULL),
(48, 4, 2, '2020-09-09 07:50:17', '2020-09-10 00:36:03', '2020-09-10 00:36:03'),
(49, 4, 3, '2020-09-09 07:50:17', '2020-09-22 05:49:24', '2020-09-22 05:49:24'),
(50, 4, 5, '2020-09-09 07:50:17', '2020-09-15 09:08:33', '2020-09-15 09:08:33'),
(51, 4, 8, '2020-09-09 07:50:17', '2020-09-15 09:08:33', '2020-09-15 09:08:33'),
(52, 4, 11, '2020-09-09 07:50:17', '2020-09-15 09:08:33', '2020-09-15 09:08:33'),
(55, 6, 18, '2020-09-09 08:23:48', '2020-09-09 08:23:48', NULL),
(56, 5, 18, '2020-09-09 08:23:53', '2020-09-09 08:23:53', NULL),
(57, 4, 15, '2020-09-10 02:19:05', '2020-09-15 09:08:33', '2020-09-15 09:08:33'),
(58, 4, 18, '2020-09-10 02:19:05', '2020-09-15 09:08:33', '2020-09-15 09:08:33'),
(59, 4, 9, '2020-09-10 02:20:14', '2020-09-10 02:20:14', NULL),
(60, 1, 23, '2020-09-15 00:40:06', '2020-09-15 00:40:06', NULL),
(61, 2, 23, '2020-09-15 00:40:32', '2020-09-15 00:40:32', NULL),
(62, 2, 3, '2020-09-15 09:11:37', '2020-09-15 09:26:05', '2020-09-15 09:26:05'),
(63, 1, 24, '2020-09-21 22:57:10', '2020-09-21 22:57:10', NULL),
(64, 3, 24, '2020-09-21 22:57:20', '2020-09-21 22:57:20', NULL),
(65, 4, 11, '2020-09-22 05:49:24', '2020-09-22 05:49:24', NULL),
(66, 1, 25, '2020-09-29 04:50:30', '2020-09-29 04:50:30', NULL),
(67, 1, 26, '2020-09-29 05:16:36', '2020-09-29 05:16:36', NULL),
(68, 1, 27, '2020-09-29 05:25:08', '2020-09-29 05:25:08', NULL),
(69, 7, 20, '2020-09-29 09:30:39', '2020-09-29 09:30:39', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel` int(11) NOT NULL,
  `areapadre_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id`, `descripcion`, `nivel`, `areapadre_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'O&M', 1, NULL, '2020-09-09 07:35:34', '2020-09-29 05:19:58', NULL),
(2, 'GERENCIA O&M', 1, NULL, '2020-09-09 08:52:38', '2020-09-29 05:20:01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carroceria`
--

CREATE TABLE `carroceria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carroceria`
--

INSERT INTO `carroceria` (`id`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'SUV', '2020-09-15 00:43:43', '2020-09-15 00:43:43', NULL),
(5, 'PICK UP', '2020-09-15 00:43:49', '2020-09-15 00:43:49', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `checklistvehicular`
--

CREATE TABLE `checklistvehicular` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha_registro` date NOT NULL,
  `equipo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehiculo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `k_inicial` decimal(11,2) NOT NULL,
  `k_final` decimal(11,2) NOT NULL,
  `lider_area` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conductor_id` bigint(20) UNSIGNED NOT NULL,
  `concesionaria_id` bigint(20) UNSIGNED NOT NULL,
  `sistema_electrico` longtext COLLATE utf8mb4_unicode_ci,
  `sistema_mecanico` longtext COLLATE utf8mb4_unicode_ci,
  `accesorios` longtext COLLATE utf8mb4_unicode_ci,
  `documentos` longtext COLLATE utf8mb4_unicode_ci,
  `observaciones` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `incidentes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `especial` tinyint NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `checklistvehicular`
--

-- INSERT INTO `checklistvehicular` (`id`, `fecha_registro`, `equipo_id`, `vehiculo_id`, `k_inicial`, `k_final`, `lider_area`, `conductor_id`, `concesionaria_id`, `sistema_electrico`, `sistema_mecanico`, `accesorios`, `documentos`, `observaciones`, `created_at`, `updated_at`, `deleted_at`) VALUES
-- (1, '2020-09-29', NULL, 1, 3200.00, 7000.00, 'PEPITO', 7, 1, '[{\"orden\":\"1\",\"id\":\"freno_emergencia\",\"titulo\":\"Freno de emergencia\",\"estado\":true},{\"orden\":\"2\",\"id\":\"funcionamiento_tablero\",\"titulo\":\"Funcionamiento de tablero\",\"estado\":false},{\"orden\":\"3\",\"id\":\"estado_bateria_funcionamiento\",\"titulo\":\"Estado de bater\\u00eda y funcionamiento\",\"estado\":true},{\"orden\":\"4\",\"id\":\"funcionamiento_claxon\",\"titulo\":\"Funcionamiento de claxon\",\"estado\":false},{\"orden\":\"5\",\"id\":\"luces_retroceso_pirata\",\"titulo\":\"Luces de retroceso pirata\",\"estado\":true},{\"orden\":\"6\",\"id\":\"luces_direccional\",\"titulo\":\"Luces direccional\",\"estado\":true},{\"orden\":\"7\",\"id\":\"faros_neblineros\",\"titulo\":\"Faros neblineros\",\"estado\":true},{\"orden\":\"8\",\"id\":\"faros_delanteros\",\"titulo\":\"Faros delanteros\",\"estado\":false},{\"orden\":\"9\",\"id\":\"faros_posteriores\",\"titulo\":\"Faros posteriores\",\"estado\":false},{\"orden\":\"10\",\"id\":\"alarma_retroceso\",\"titulo\":\"Alarma de retroceso\",\"estado\":false}]', '[{\"orden\":\"1\",\"id\":\"nivel_liquido_freno\",\"titulo\":\"Nivel liquido de freno\",\"estado\":true},{\"orden\":\"2\",\"id\":\"sistema_direccion\",\"titulo\":\"Sistema de direcci\\u00f3n\",\"estado\":false},{\"orden\":\"3\",\"id\":\"palancas_cambios\",\"titulo\":\"Palancas de cambios\",\"estado\":true},{\"orden\":\"4\",\"id\":\"estado_neumaticos\",\"titulo\":\"Estado de neum\\u00e1ticos\",\"estado\":true},{\"orden\":\"5\",\"id\":\"llantas_repuesto\",\"titulo\":\"Llantas de repuesto\",\"estado\":false},{\"orden\":\"6\",\"id\":\"ajustes_tuercas\",\"titulo\":\"Ajustes de tuercas\",\"estado\":true},{\"orden\":\"7\",\"id\":\"presion_llantas_libras\",\"titulo\":\"Presion de llantas en libras\",\"estado\":false},{\"orden\":\"8\",\"id\":\"cinturon_seguridad_conductor\",\"titulo\":\"Cinturon de seguridad conductor\",\"estado\":true},{\"orden\":\"9\",\"id\":\"cinturon_seguridad_pasajeros\",\"titulo\":\"Cinturon de seguridad pasajeros\",\"estado\":true},{\"orden\":\"10\",\"id\":\"suspension\",\"titulo\":\"Suspensi\\u00f3n\",\"estado\":false},{\"orden\":\"11\",\"id\":\"sistema_freno\",\"titulo\":\"Sistema de freno\",\"estado\":false},{\"orden\":\"12\",\"id\":\"pernos_neumaticos\",\"titulo\":\"Pernos de neum\\u00e1ticos\",\"estado\":true},{\"orden\":\"13\",\"id\":\"nivel_aceite\",\"titulo\":\"Nivel de aceite\",\"estado\":false},{\"orden\":\"14\",\"id\":\"espejos_int_ext\",\"titulo\":\"Espejos int y ext\",\"estado\":true},{\"orden\":\"15\",\"id\":\"parachoques\",\"titulo\":\"Parachoques\",\"estado\":true},{\"orden\":\"16\",\"id\":\"parabrisas_ventanas\",\"titulo\":\"Parabrisas y ventanas\",\"estado\":false},{\"orden\":\"17\",\"id\":\"puertas_cabina\",\"titulo\":\"Puertas de cabina\",\"estado\":false},{\"orden\":\"18\",\"id\":\"puertas_tolva\",\"titulo\":\"Puertas de tolva\",\"estado\":false},{\"orden\":\"19\",\"id\":\"plumillas\",\"titulo\":\"Plumillas\",\"estado\":true},{\"orden\":\"20\",\"id\":\"estado_carroceria\",\"titulo\":\"Estado de carrocer\\u00eda\",\"estado\":true}]', '[{\"orden\":\"1\",\"id\":\"estuche_herramientas\",\"titulo\":\"Estuche de herramientas\",\"estado\":true},{\"orden\":\"2\",\"id\":\"estado_carga_extintor\",\"titulo\":\"Estado y carga de extintor\",\"estado\":true},{\"orden\":\"3\",\"id\":\"botiquin\",\"titulo\":\"Botiqu\\u00edn\",\"estado\":true},{\"orden\":\"4\",\"id\":\"cable_remolque\",\"titulo\":\"Cable de remolque\",\"estado\":true},{\"orden\":\"5\",\"id\":\"tacos_seguridad_cu\\u00f1a_2\",\"titulo\":\"Tacos de seguridad cu\\u00f1a(2)\",\"estado\":false},{\"orden\":\"6\",\"id\":\"llave_ruedas\",\"titulo\":\"Llave de ruedas\",\"estado\":true},{\"orden\":\"7\",\"id\":\"kit_antiderrames\",\"titulo\":\"Kit antiderrames\",\"estado\":true},{\"orden\":\"8\",\"id\":\"limpieza_unidad\",\"titulo\":\"Limpieza de la unidad\",\"estado\":false}]', '[{\"orden\":\"1\",\"id\":\"tarjeta_propiedad\",\"titulo\":\"Tarjeta de propiedad\",\"estado\":true},{\"orden\":\"2\",\"id\":\"soat\",\"titulo\":\"SOAT\",\"estado\":true},{\"orden\":\"3\",\"id\":\"licencia_conducir\",\"titulo\":\"Licencia de conducir\",\"estado\":true},{\"orden\":\"4\",\"id\":\"revision_tecnica\",\"titulo\":\"Revisi\\u00f3n t\\u00e9cnica\",\"estado\":true}]', 'TODO OK', '2020-09-29 10:14:33', '2020-09-29 10:14:33', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concesionaria`
--

CREATE TABLE `concesionaria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ruc` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razonsocial` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `concesionaria`
--

INSERT INTO `concesionaria` (`id`, `ruc`, `razonsocial`, `abreviatura`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '20523611250', 'H2OLMOS S.A.', 'H2OLMOS', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(2, '20509093521', 'CONCESIONARIA TRASVASE OLMOS S.A.', 'C.T.O.', '2020-09-09 07:35:34', '2020-09-29 08:45:29', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conductor`
--

CREATE TABLE `conductor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombres` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `licencia` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechavencimiento` date NOT NULL,
  `contratista_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `conductor`
--

INSERT INTO `conductor` (`id`, `nombres`, `apellidos`, `dni`, `categoria`, `licencia`, `fechavencimiento`, `contratista_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ELISEO AURELIO', 'RIOS OBANDO', '17811439', 'A-IIb', 'D-17811439', '2021-02-15', 1, NULL, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(2, 'EDMUNDO', 'VILLENA FIESTAS', '17974640', 'A-IIb', 'D-17974640', '2021-10-09', 1, NULL, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(3, 'JORGE LUIS', 'GAMARRA AYALA', '16691239', 'A-IIIc', 'C-16691239', '2021-08-09', 2, NULL, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(4, 'BERNARDO RAMIRO', 'PEREZ DIAZ', '16732333', 'A-IIIc', 'B-16732333', '2025-01-24', 3, NULL, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(7, 'JAVIER ARTURO', 'GONZALES AMPUERO', '44239436', 'A-I', 'A-44239436', '2020-12-31', 2, 18, '2020-09-29 09:35:18', '2020-09-29 09:35:18', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conductorconcesionaria`
--

CREATE TABLE `conductorconcesionaria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conductor_id` bigint(20) UNSIGNED NOT NULL,
  `concesionaria_id` bigint(20) UNSIGNED NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `conductorconcesionaria`
--

INSERT INTO `conductorconcesionaria` (`id`, `conductor_id`, `concesionaria_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, NULL),
(2, 1, 2, 1, NULL, NULL),
(3, 2, 1, 1, NULL, NULL),
(4, 3, 1, 1, NULL, NULL),
(5, 4, 2, 1, NULL, NULL),
(8, 7, 1, 1, '2020-09-29 09:35:18', '2020-09-29 09:35:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conductordocument`
--

CREATE TABLE `conductordocument` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conductor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `conductordocument`
--

INSERT INTO `conductordocument` (`id`, `tipo`, `archivo`, `conductor_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'imagen-firma', 'dni_44239436_fondo2.jpg', 7, '2020-09-29 09:35:18', '2020-09-29 09:35:18', NULL),
(2, 'conformidad-firma', 'dni_44239436_Combustible_con_errores.pdf', 7, '2020-09-29 09:35:18', '2020-09-29 09:35:18', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratista`
--

CREATE TABLE `contratista` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ruc` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razonsocial` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `propietario` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contratista`
--

INSERT INTO `contratista` (`id`, `ruc`, `razonsocial`, `propietario`, `email`, `telefono`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '12345678901', 'EMPRESA LAGARITA SAC', 'PEPITO', 'PEPITO@HOTMAIL.COM', '97864653212', '2020-09-09 07:35:34', '2020-09-29 08:56:41', NULL),
(2, '74679823478', 'GRUPO MIMASCOT SRL', '', '', '', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(3, '92347859878', 'CONVENCIONES POLVOS ROSADOS SAA', 'JOSE PEREZ', 'JOSEPEREZ@HOTMAIL.COM', '987654321', '2020-09-09 07:35:34', '2020-09-10 00:40:05', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controldiario`
--

CREATE TABLE `controldiario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ua_id` bigint(20) UNSIGNED DEFAULT NULL,
  `turno` tinyint(1) NOT NULL,
  `horometro_inicial` double(6,2) NOT NULL,
  `horometro_final` double(6,2) NOT NULL,
--  `hora_inicio` time DEFAULT NULL,
--  `hora_fin` time DEFAULT NULL,
  `hora_total` decimal(18,2) NOT NULL,
  `hora_parada` decimal(10,2) DEFAULT NULL,
  `tipohora_id` bigint(20) UNSIGNED DEFAULT NULL,
  `viajes` int(11) DEFAULT NULL,
  `km_inicial` int(11) DEFAULT NULL,
  `acceso_origen` int(11) DEFAULT NULL,
  `km_destino` int(11) DEFAULT NULL,
  `acceso_destino` int(11) DEFAULT NULL,
  `tipo_material` text COLLATE utf8mb4_unicode_ci,
  `fecha` date NOT NULL,
  `observaciones` longtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `controldiario`
--

INSERT INTO `controldiario` (`id`, `equipo_id`, `ua_id`, `turno`, `horometro_inicial`, `horometro_final`, `hora_total`, `hora_parada`, `tipohora_id`, `viajes`, `km_inicial`, `acceso_origen`, `km_destino`, `acceso_destino`, `tipo_material`, `fecha`, `observaciones`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 31, 1, 123.50, 140.00,  3.50, NULL, 13, NULL, NULL, 0, 0, 0, NULL, '2020-09-29', 'todo ok', NULL, '2020-09-29 09:00:26', '2020-09-29 09:00:26'),
(2, 1, 25, 1, 10.00, 20.00, 3.50, 0.50, 8, NULL, NULL, 0, 0, 0, NULL, '2020-10-01', 'ok', NULL, '2020-10-01 08:55:27', '2020-10-01 09:19:26'),
(3, 1, 25, 1, 20.00, 30.00,  5.00, 0.50, 1, NULL, NULL, 0, 0, 0, NULL, '2020-10-01', 'ok1', NULL, '2020-10-01 09:29:11', '2020-10-01 09:29:11'),
(4, 1, 25, 1, 20.00, 30.00,  3.00, 1.00, 17, 2, 100, 1900, 2000, 2100, 'BASE', '2020-10-01', 'ok2', NULL, '2020-10-01 09:29:11', '2020-10-01 09:45:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descripcionregmanveh`
--

CREATE TABLE `descripcionregmanveh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `regmanveh_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` decimal(18,2) NOT NULL,
  `trabajo_id` bigint(20) UNSIGNED NOT NULL,
  `monto` decimal(18,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descripcionregrepveh`
--

CREATE TABLE `descripcionregrepveh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `regrepveh_id` int(11) NOT NULL,
  `cantidad` decimal(18,2) NOT NULL,
  `repuesto_id` int(11) DEFAULT NULL,
  `monto` decimal(18,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `placa` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca_id` bigint(20) UNSIGNED NOT NULL,
  `contratista_id` bigint(20) UNSIGNED NOT NULL,
  `anio` year(4) DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `concesionaria_id` bigint(20) UNSIGNED NOT NULL,
  `ua_id` int(11) NOT NULL,
  `capacidad_carga` decimal(10,2) DEFAULT NULL,
  `horas_min` double(5,2) NOT NULL,
  `precio` double(8,2) NOT NULL,
  `moneda` tinyint(1) NOT NULL,
  `unidad_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id`, `descripcion`, `modelo`, `placa`, `marca_id`, `contratista_id`, `anio`, `area_id`, `concesionaria_id`, `ua_id`, `capacidad_carga`,`horas_min`, `precio`, `moneda`, `unidad_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'MOTONIVELADRA NEW HOLD', 'NEW HOLDEN', 'RG170B', 2, 3, 2020, 2, 1, 25, NULL,152.00, 4550.00, 1, 6, '2020-09-29 08:50:10', '2020-10-01 08:48:36', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grifo`
--

CREATE TABLE `grifo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ubicacion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `abastecimiento_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grifo`
--

INSERT INTO `grifo` (`id`, `descripcion`, `ubicacion`, `contacto`, `telefono`, `correo`, `abastecimiento_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'LEON DE ORO', 'OLMOS', 'PEPITO', '65342341', 'PEPITO@HOTMAIL.COM', 1, '2020-09-09 07:35:34', '2020-09-29 09:11:07', NULL),
(2, 'PECSA', '', '', '', '', 1, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(3, 'PRIMAX', '', '', '', '', 1, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupomenu`
--

CREATE TABLE `grupomenu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icono` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grupomenu`
--

INSERT INTO `grupomenu` (`id`, `descripcion`, `icono`, `orden`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'INFORMACION BASE', 'content_paste', 1, NULL, '2020-09-09 07:54:25', NULL),
(2, 'SISTEMA', 'settings_power', 2, NULL, NULL, NULL),
(3, 'PROCESOS', 'dashboard', 3, NULL, NULL, NULL),
(4, 'REPROTES', 'insert_drive_file', 4, '2020-10-01 09:51:11', '2020-10-01 09:51:11', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kilometraje`
--

CREATE TABLE `kilometraje` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limite_inf` decimal(10,2) NOT NULL,
  `limite_sup` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `kilometraje`
--

INSERT INTO `kilometraje` (`id`, `descripcion`, `limite_inf`, `limite_sup`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'TIPO 1', 1000.00, 3000.00, '2020-09-29 05:18:07', '2020-09-29 05:18:07', NULL),
(4, 'TIPO 2', 4000.00, 6000.00, '2020-09-29 05:18:15', '2020-09-29 05:18:15', NULL),
(5, '500KM', 4500.00, 5000.00, '2020-09-29 09:51:22', '2020-09-29 10:21:36', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'MITSUBISHI', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(2, 'TOYOTA', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(3, 'HITACHI', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(4, 'VOLVO', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(5, 'SANY', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(6, 'JHON', '2020-09-23 18:33:19', '2020-09-23 18:33:27', '2020-09-23 18:33:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_10_170508_create_concesionaria_table', 1),
(2, '2014_10_11_000000_create_tipouser_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2020_06_23_050528_create_grupomenu', 1),
(7, '2020_06_23_050619_create_opcionmenu_table', 1),
(8, '2020_06_23_050755_create_acceso_table', 1),
(9, '2020_06_23_093425_create_marca_table', 1),
(10, '2020_06_23_234823_create_propietarios_table', 1),
(11, '2020_06_24_004558_create_repuestos_table', 1),
(12, '2020_06_24_005941_create_ua_table', 1),
(13, '2020_06_24_011622_create_unidades_table', 1),
(14, '2020_06_24_052844_create_tipohora_table', 1),
(15, '2020_06_24_053409_create_grifo_table', 1),
(16, '2020_06_24_172958_update_addfk_ua_propietarios', 1),
(17, '2020_06_24_173728_update_addfk_unidad_ua', 1),
(18, '2020_06_24_201109_create_contratistas_table', 1),
(19, '2020_06_24_201230_create_conductors_table', 1),
(20, '2020_06_25_011805_create_equipo_table', 1),
(21, '2020_06_26_000010_create_area_table', 1),
(22, '2020_06_26_000112_create_trabajo_table', 1),
(23, '2020_06_27_002323_edit_equipo_foreing', 1),
(24, '2020_06_29_040921_addfk_repuestos_unidad', 1),
(25, '2020_08_12_044331_create_controldiario_table', 1),
(26, '2020_08_12_152355_create_vehiculo_table', 1),
(27, '2020_08_17_225103_create_abastecimiento_combustibles_table', 1),
(28, '2020_08_19_013022_addfk_grifo_abastcombustible', 1),
(29, '2020_08_19_013129_addfk_conductor_abastcombustible', 1),
(30, '2020_08_19_013158_addfk_ua_abastcombustible', 1),
(31, '2020_08_19_013211_addfk_equipo_abastcombustible', 1),
(32, '2020_08_19_165302_create_permiso_table', 1),
(33, '2020_08_30_175048_create_tipovehiculodocument_table', 1),
(34, '2020_08_30_195705_create_vehiculodocument_table', 1),
(35, '2020_08_31_164544_create_checklistvehicular_table', 1),
(36, '2020_08_31_181821_create_userconcesionaria_table', 1),
(37, '2020_08_31_181845_create_table_regrepveh', 1),
(38, '2020_09_04_000817_create_table_descripcion_regrepveh', 1),
(39, '2020_09_06_195453_create_conductorconcesionaria_table', 1),
(40, '2020_09_07_225331_addfk_concesionaria_equipo', 1),
(41, '2020_09_07_230316_addfk_concesionaria_vehiculo', 1),
(42, '2020_09_07_230356_addfk_vehiculo_abastecimientocombustible', 1),
(43, '2020_09_07_234004_create_view_equipo_vehiculo', 1),
(44, '2020_09_09_012200_addfk_ua_concesionaria', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcionmenu`
--

CREATE TABLE `opcionmenu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icono` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` int(11) NOT NULL,
  `grupomenu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `opcionmenu`
--

INSERT INTO `opcionmenu` (`id`, `descripcion`, `link`, `icono`, `orden`, `grupomenu_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'UA', 'ua', 'api', 1, 1, NULL, '2020-09-09 07:55:22', NULL),
(2, 'Propietarios', 'propietario', 'accessibility', 1, 1, NULL, '2020-09-10 00:36:10', '2020-09-10 00:36:10'),
(3, 'Unidades', 'unidad', 'ac_unit', 1, 1, NULL, NULL, NULL),
(4, 'Tipo de users', 'tipouser', 'contacts', 4, 2, NULL, NULL, NULL),
(5, 'Marcas', 'marcas', 'model_training', 1, 1, NULL, NULL, NULL),
(6, 'Repuestos', 'repuestos', 'settings', 2, 1, NULL, NULL, NULL),
(7, 'Conductores', 'conductores', 'face', 3, 1, NULL, NULL, NULL),
(8, 'Areas', 'areas', 'info', 4, 1, NULL, NULL, NULL),
(9, 'Subcontratistas', 'contratistas', 'perm_identity', 5, 1, NULL, NULL, NULL),
(10, 'Trabajos', 'trabajos', 'play_for_work', 6, 1, NULL, NULL, NULL),
(11, 'CONCESIONARIAS', 'concesionarias', 'card_giftcard', 7, 1, NULL, '2020-09-09 08:06:43', NULL),
(12, 'Grupo Menu', 'grupomenu', 'vertical_split', 3, 2, NULL, NULL, NULL),
(13, 'Opcion Menu', 'opcionmenu', 'language', 4, 2, NULL, NULL, NULL),
(14, 'Tipo de Horas Paradas', 'tipohora', 'hourglass_empty', 4, 1, NULL, NULL, NULL),
(15, 'Vehículos', 'vehiculo', 'directions_car', 4, 1, NULL, NULL, NULL),
(16, 'CTRL DE EQUIPOS', 'controldiario', 'agriculture', 4, 3, NULL, '2020-09-09 08:08:40', NULL),
(17, 'Grifos', 'grifo', 'toc', 5, 1, NULL, NULL, NULL),
(18, 'Equipos', 'equipo', 'directions_car', 6, 1, NULL, NULL, NULL),
(19, 'CHECK LIST', 'mantcorrprev', 'plumbing', 1, 3, NULL, '2020-09-21 23:34:29', NULL),
(20, 'ABAST. COMBUSTIBLE', 'abastecimiento', 'ev_station', 1, 3, NULL, '2020-09-09 08:10:13', NULL),
(21, 'Usuario', 'user', 'person', 1, 2, NULL, NULL, NULL),
(22, 'REG.REP.VEHICULAR', 'regrepveh', 'handyman', 1, 3, NULL, '2020-09-09 08:10:33', NULL),
(23, 'Carroceria', 'carroceria', 'home_repair_service', 9, 1, '2020-09-15 00:39:58', '2020-09-15 00:39:58', NULL),
(24, 'REG.MAN.VEHICULAR', 'regmanveh', 'group_work', 5, 3, '2020-09-21 22:57:00', '2020-09-21 23:03:57', NULL),
(25, 'Lugar Abastecimiento', 'abastecimientolugar', 'place', 8, 1, '2020-09-29 04:50:23', '2020-09-29 04:50:23', NULL),
(26, 'Regla Kilometraje', 'kilometrajes', 'apps', 12, 1, '2020-09-29 05:16:31', '2020-09-29 05:16:31', NULL),
(27, 'Tipo Combustible', 'tipocombustible', 'speed', 13, 1, '2020-09-29 05:24:48', '2020-09-29 05:24:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `opcionmenu_id` bigint(20) UNSIGNED NOT NULL,
  `tipouser_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regmanveh`
--

CREATE TABLE `regmanveh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `concesionaria_id` int(11) NOT NULL,
  `cliente` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordencompra` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ua_id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kmman` int(11) NOT NULL,
  `kminicial` int(11) NOT NULL,
  `kmfinal` int(11) NOT NULL,
  `fechaentrada` date DEFAULT NULL,
  `fechasalida` date DEFAULT NULL,
  `tipomantenimiento` int(11) NOT NULL,
  `telefono` int(11) NOT NULL,
  `especial` tinyint NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regrepveh`
--

CREATE TABLE `regrepveh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `concesionaria_id` int(11) NOT NULL,
  `cliente` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordencompra` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ua_id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kmman` int(11) NOT NULL,
  `kminicial` int(11) NOT NULL,
  `kmfinal` int(11) NOT NULL,
  `fechaentrada` date DEFAULT NULL,
  `fechasalida` date DEFAULT NULL,
  `tipomantenimiento` int(11) NOT NULL,
  `telefono` int(11) NOT NULL,
  `especial` tinyint NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repuesto`
--

CREATE TABLE `repuesto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unidad_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `repuesto`
--

INSERT INTO `repuesto` (`id`, `codigo`, `descripcion`, `unidad_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1000001', 'FRENO DE MANO', 1, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(2, '1000002', 'FAROS DELANTEROS', 2, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(3, '1000003', 'ALARMA DE RETROCESO', 2, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(4, '100004', 'PARACHOQUES', 2, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(5, '100005', 'PLUMILLAS', 2, '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(6, '1000000', 'FRENO DE MANI', 1, '2020-09-24 02:36:41', '2020-09-24 02:36:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocombustible`
--

CREATE TABLE `tipocombustible` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipocombustible`
--

INSERT INTO `tipocombustible` (`id`, `descripcion`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 'DIESEL', NULL, '2020-09-29 05:25:35', '2020-09-29 05:25:35'),
(5, 'PETROLEO', NULL, '2020-09-29 05:25:39', '2020-09-29 05:25:39'),
(6, 'GAS', NULL, '2020-09-29 05:25:44', '2020-09-29 09:11:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipohora`
--

CREATE TABLE `tipohora` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipohora`
--

INSERT INTO `tipohora` (`id`, `codigo`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '01', 'ABASTECIMIENTO/LUBRICACIóN/LAVADO', '2020-09-09 07:35:34', '2020-09-09 08:48:01', NULL),
(2, '02', 'REPARACION DE LLANTAS', '2020-09-09 07:35:34', '2020-09-09 08:48:08', NULL),
(3, '03', 'MANTENIMIENTO MECANICO', '2020-09-09 07:35:34', '2020-09-09 08:48:13', NULL),
(4, '04', 'PARADO OPERATIVO (STAND BY)', '2020-09-09 07:35:34', '2020-09-09 08:48:18', NULL),
(5, '05', 'PARADO INOPERATIVO', '2020-09-09 08:43:39', '2020-09-09 08:48:23', NULL),
(6, '06', 'ALMUERZO/CENA/REFRIGERIO', '2020-09-09 08:43:52', '2020-09-09 08:48:28', NULL),
(7, '07', 'PARADO POR LLUVIA', '2020-09-09 08:44:03', '2020-09-09 08:48:32', NULL),
(8, '08', 'FALTA DE OPERADOR', '2020-09-09 08:44:12', '2020-09-09 08:48:37', NULL),
(9, '09', 'PARADO POR AREA DE SEGURIDAD / CHARLA', '2020-09-09 08:44:29', '2020-09-09 08:48:44', NULL),
(10, '10', 'PARADO POR FALTA DE COMBUSTIBLE', '2020-09-09 08:44:43', '2020-09-09 08:44:43', NULL),
(11, '11', 'FALTA FRENTE DE SERVICIO', '2020-09-09 08:44:52', '2020-09-09 08:44:52', NULL),
(12, '12', 'FUERA DE OBRA', '2020-09-09 08:45:37', '2020-09-09 08:45:37', NULL),
(13, '13', 'FALTA EQUIPO AUXILIAR', '2020-09-09 08:45:51', '2020-09-09 08:45:57', NULL),
(14, '14', 'FALTA EQUIPO AUXILIAR (D)', '2020-09-09 08:46:06', '2020-09-09 08:46:06', NULL),
(15, '15', 'INTERFERENCIAS', '2020-09-09 08:46:16', '2020-09-09 08:46:16', NULL),
(16, '16', 'DESMOVILIZADO', '2020-09-09 08:46:33', '2020-09-09 08:46:33', NULL),
(17, 'SB', 'STAND BY', '2020-09-09 08:47:18', '2020-09-09 08:47:18', NULL),
(18, 'FM', 'FALLA MECANICA', '2020-09-09 08:47:55', '2020-09-09 08:47:55', NULL),
(19, 'MP', 'MANTENIMIENTO PREVENTIVO', '2020-09-09 08:48:57', '2020-09-09 08:48:57', NULL),
(20, 'FO', 'FUERA DE OBRA', '2020-09-09 08:49:06', '2020-09-09 08:49:06', NULL),
(21, 'SO', 'SIN OPERADOR', '2020-09-09 08:49:14', '2020-09-09 08:49:14', NULL),
(22, '22', 'VACACIONES', '2020-09-16 02:49:07', '2020-09-16 02:49:13', '2020-09-16 02:49:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipouser`
--

CREATE TABLE `tipouser` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipouser`
--

INSERT INTO `tipouser` (`id`, `descripcion`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', NULL, '2020-09-09 07:35:34', '2020-09-09 07:35:34'),
(2, 'EQUIPOS', NULL, '2020-09-09 07:35:34', '2020-09-15 09:12:45'),
(3, 'VEHICULOS/COMBUSTIBLE', NULL, '2020-09-09 07:49:20', '2020-09-15 09:10:24'),
(4, 'COSTOS', NULL, '2020-09-09 07:50:17', '2020-09-15 09:08:33'),
(5, 'USUARIO H2O', NULL, '2020-09-09 08:21:48', '2020-09-09 08:21:48'),
(6, 'USUARIO CTO', NULL, '2020-09-09 08:22:01', '2020-09-09 08:22:01'),
(7, 'CONDUCTOR', NULL, '2020-09-29 09:30:39', '2020-09-29 09:30:39'),
(8, 'RESPONSABLE', NULL, '2020-09-29 09:30:39', '2020-09-29 09:30:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipovehiculodocument`
--

CREATE TABLE `tipovehiculodocument` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajo`
--

CREATE TABLE `trabajo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `trabajo`
--

INSERT INTO `trabajo` (`id`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'trabajo de prueba 1', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(2, 'segundo trabajo de prueba', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ua`
--

CREATE TABLE `ua` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ua_padre_id` bigint(20) UNSIGNED DEFAULT NULL,
  `concesionaria_id` bigint(20) UNSIGNED NOT NULL,
  `habilitada` tinyint(4) NOT NULL DEFAULT '1',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ua`
--

INSERT INTO `ua` (`id`, `codigo`, `descripcion`, `ua_padre_id`, `concesionaria_id`, `habilitada`, `fecha_inicio`, `fecha_fin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ABCD1230', 'UA TEST', NULL, 1, 1, '2020-09-29', NULL, '2020-09-29 07:36:11', '2020-09-29 08:41:37', '2020-09-29 08:41:37'),
(2, 'ABCD1235', 'UA TEST2', NULL, 1, 1, '2020-09-01', NULL, '2020-09-29 07:38:18', '2020-09-29 08:41:10', '2020-09-29 08:41:10'),
(3, 'ABCD1231', 'UA HIJO1', 1, 1, 1, '2020-09-29', NULL, '2020-09-29 07:44:29', '2020-09-29 08:41:10', '2020-09-29 08:41:10'),
(24, '00014104', 'MOTONIVELADORA', NULL, 1, 1, '2016-07-04', NULL, '2020-09-29 08:32:32', '2020-09-29 08:32:32', NULL),
(25, '01190103', 'MOTONIVELADORA NEW HOLLAND RG170B - MULTISERVICIOS PUNRE', 24, 1, 1, '2016-07-04', NULL, '2020-09-29 08:32:32', '2020-09-29 08:32:32', NULL),
(26, '01190105', 'MOTONIVELADORA CAT 140H - MULTISERVICIOS PUNRE XZH02295', 24, 1, 1, '2018-02-07', NULL, '2020-09-29 08:32:32', '2020-10-01 06:08:48', '2020-10-01 06:08:48'),
(27, '00080715', 'TRACTOR D8', NULL, 1, 1, '2016-06-06', NULL, '2020-09-29 08:32:32', '2020-09-29 08:32:32', NULL),
(28, '08017102', 'TRACTOR ORUGAS CAT D8T PUNRE', 27, 1, 1, '2016-06-06', NULL, '2020-09-29 08:32:32', '2020-09-29 08:32:32', NULL),
(29, '00012000', 'COSTO DIRECTO IRRIGACIONES', NULL, 1, 1, '2016-01-01', NULL, '2020-09-29 08:32:32', '2020-09-29 08:32:32', NULL),
(30, '00012050', 'ESTUDIOS Y CONSULTORIAS OPERACIONES TRASVASE', 29, 1, 1, '2016-10-12', NULL, '2020-09-29 08:32:32', '2020-10-01 06:08:48', '2020-10-01 06:08:48'),
(31, '00012100', 'OPERACIÓN TRASVASE', 29, 1, 1, '2016-01-01', NULL, '2020-09-29 08:32:32', '2020-09-29 08:32:32', NULL),
(32, '00013000', 'COSTO INDIRECTO IRRIGACIONES', NULL, 1, 1, '2016-01-01', NULL, '2020-09-29 08:32:32', '2020-10-01 06:05:08', '2020-10-01 06:05:08'),
(33, '12345678', 'FFFFFGGGGHHHHHHHJJJJJ', 34, 1, 1, '2020-10-01', NULL, '2020-10-01 05:21:58', '2020-10-01 05:53:37', '2020-10-01 05:53:37'),
(34, '12345555', 'HHHHHHHHHHHHHH', NULL, 1, 1, '2020-10-01', NULL, '2020-10-01 05:37:45', '2020-10-01 06:06:43', '2020-10-01 06:06:43'),
(35, '11111111', 'KKKKKKKKKKKKKKKK', 34, 1, 1, '2020-10-01', NULL, '2020-10-01 05:43:41', '2020-10-01 06:06:43', '2020-10-01 06:06:43'),
(36, '22222222', 'DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD', NULL, 1, 1, '2020-10-01', NULL, '2020-10-01 06:06:14', '2020-10-01 06:06:43', '2020-10-01 06:06:43'),
(37, '123456', 'PRUEBA', NULL, 1, 1, '2020-10-01', NULL, '2020-10-01 07:23:21', '2020-10-01 07:24:51', '2020-10-01 07:24:51'),
(38, '00012101', 'HIJO OPERACION TRASVASE', 31, 1, 1, '2020-10-01', NULL, '2020-10-01 07:29:53', '2020-10-01 07:29:53', NULL),
(39, '1000', 'UA PADRE', NULL, 1, 1, '2020-10-01', NULL, '2020-10-01 07:31:02', '2020-10-01 07:45:21', NULL),
(40, '1100', 'UA HIJO', 39, 1, 1, '2020-10-01', NULL, '2020-10-01 07:31:34', '2020-10-01 07:46:37', NULL),
(41, '1110', 'UA NIETA', 40, 1, 0, '2020-10-01', NULL, '2020-10-01 07:32:02', '2020-10-01 08:17:53', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`id`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'MES', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(2, 'VB', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(3, 'METRO CÚBICO', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(4, 'KILOMETRO', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(5, 'GLB', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(6, 'HORAS', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL),
(7, 'DIAS', '2020-09-09 07:35:34', '2020-09-09 07:35:34', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userconcesionaria`
--

CREATE TABLE `userconcesionaria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `concesionaria_id` bigint(20) UNSIGNED NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `userconcesionaria`
--

INSERT INTO `userconcesionaria` (`id`, `user_id`, `concesionaria_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2020-09-09 07:35:34', '2020-09-15 04:47:31'),
(2, 1, 2, 0, '2020-09-09 07:35:34', '2020-09-15 04:47:31'),
(3, 2, 1, 1, '2020-09-09 07:35:34', NULL),
(4, 2, 2, 1, '2020-09-09 07:35:34', NULL),
(5, 3, 1, 1, '2020-09-09 07:35:34', '2020-09-15 09:10:44'),
(6, 3, 2, 1, '2020-09-09 07:35:34', '2020-09-15 09:10:44'),
(7, 4, 1, 1, '2020-09-09 07:35:34', '2020-09-15 09:11:54'),
(8, 4, 2, 1, '2020-09-09 07:35:34', '2020-09-15 09:11:54'),
(9, 5, 1, 0, '2020-09-09 07:52:49', '2020-09-15 09:07:41'),
(10, 5, 2, 1, '2020-09-09 07:52:49', '2020-09-15 09:07:41'),
(11, 6, 2, 1, '2020-09-09 08:22:43', '2020-09-09 08:22:43'),
(12, 7, 1, 1, '2020-09-09 08:23:40', '2020-09-09 08:23:40'),
(13, 8, 1, 1, '2020-09-15 09:08:53', '2020-09-15 09:08:53'),
(14, 8, 2, 1, '2020-09-15 09:08:53', '2020-09-15 09:08:53'),
(15, 9, 1, 1, '2020-09-15 09:09:12', '2020-09-15 09:09:12'),
(16, 9, 2, 1, '2020-09-15 09:09:12', '2020-09-15 09:09:12'),
(17, 10, 1, 1, '2020-09-15 09:09:29', '2020-09-15 09:09:29'),
(18, 10, 2, 1, '2020-09-15 09:09:29', '2020-09-15 09:09:29'),
(19, 11, 1, 1, '2020-09-15 09:11:03', '2020-09-15 09:11:03'),
(20, 11, 2, 1, '2020-09-15 09:11:03', '2020-09-15 09:11:03'),
(21, 12, 1, 1, '2020-09-15 09:11:19', '2020-09-15 09:11:19'),
(22, 12, 2, 1, '2020-09-15 09:11:20', '2020-09-15 09:11:20'),
(23, 13, 1, 1, '2020-09-15 09:12:14', '2020-09-15 09:12:14'),
(24, 13, 2, 0, '2020-09-15 09:12:14', '2020-09-15 09:12:14'),
(25, 14, 1, 1, '2020-09-15 09:12:35', '2020-09-15 09:12:35'),
(26, 14, 2, 1, '2020-09-15 09:12:35', '2020-09-15 09:12:35'),
(30, 18, 1, 1, '2020-09-29 09:35:18', '2020-09-29 09:35:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipouser_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email_verified_at`, `password`, `tipouser_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'JAVIER GONZALES', 'admin', '2020-09-09 07:35:34', '$2y$10$Y3YjoB39PG3bueW0SeM1mO2XbGX7Yq2xGIJ/QpyAhsRKUlmKc.PkC', 1, NULL, '2020-09-09 07:35:34', '2020-09-15 04:47:31', NULL),
(2, 'Gonzalo Perseo Miranda Altos', 'gonzalo', '2020-09-09 07:35:34', '$2y$10$H.AzVdE7G.daWtT/G2ZWVuoiRsB.PWpFdc0/CZLbxlULL6vZyBfWO', 1, NULL, '2020-09-09 07:35:34', '2020-09-09 07:35:34', '2020-09-09 07:35:34'),
(3, 'SIXTO CHAVEZ', 'schavez', '2020-09-09 07:35:34', '$2y$10$58zskbMvUAe6ioP33yS9q.HivnrX3iqiBbnbs0ZAL1P7mWCdQRDi6', 3, 'FsvIxlRVU8P5GOkhCh5Dztp3ejMRI6R43ZEAp3NFrFddBpi1ukJXa2Y94eoY', '2020-09-09 07:35:34', '2020-09-15 09:10:44', NULL),
(4, 'GUILLERMO CIPAGAUTA', 'gcipagauta', '2020-09-09 07:35:34', '$2y$10$p9AjBnHatmgZWnU24bovZ.i07dvS3bOoJP7.RdaLwrti6dagv3xXa', 2, NULL, '2020-09-09 07:35:34', '2020-09-15 09:11:54', NULL),
(5, 'SAYRA MONJA', 'smonja', NULL, '$2y$10$dniP45zz3q4R1kTA21zNn.tRkzIYQM5.wrN1fodISiEPIEHX7/RaW', 4, 'PEJ2mkHmaadQL3KwGOxj4KAWYDcGzSeyJATf2YcArlvuglUkjJNf5eRkZw9y', '2020-09-09 07:52:49', '2020-09-15 09:07:41', NULL),
(6, 'USER CTO', 'usercto', NULL, '$2y$10$sa6YuZdOsudNjyEBXRAMM.yc79sg5ieRisRQYoDCotbX6JBvl5Qy2', 6, NULL, '2020-09-09 08:22:43', '2020-09-09 08:22:43', NULL),
(7, 'USER H2O', 'userh2o', NULL, '$2y$10$4U1URHrA6BtU5HB3aMzBuu2f0stYi/SXhReJNFtL86wqwrc2rYN72', 5, NULL, '2020-09-09 08:23:40', '2020-09-09 08:23:40', NULL),
(8, 'PATRICIA RAZA', 'patriciaraza', NULL, '$2y$10$88nxaooo5xXkIVthEAEA7u52Ma0RlxRMCYzxWaT6dnaYEW37p3SHO', 4, NULL, '2020-09-15 09:08:53', '2020-09-15 09:08:53', NULL),
(9, 'JESSICA CALMET', 'jcalmet', NULL, '$2y$10$mcHpKj1ZJI0p1DLJpjkeg.RQVwxgmvdG/16VdEwetN1JMJZO/9D8K', 4, 'zHheOGSHUhXbAPwLQMkhPE0CczlRykgliqzk0ELmkQuHJOpBYuQa0G0wENWO', '2020-09-15 09:09:12', '2020-09-15 09:09:12', NULL),
(10, 'HUBER MELENDREZ', 'hmelendrez', NULL, '$2y$10$vhhSeesyb8Z2HRPjTk445OYMsb4/IG4lxMYI3e8LWNodDdPDDLTZ6', 4, NULL, '2020-09-15 09:09:29', '2020-09-15 09:09:29', NULL),
(11, 'INGRID ROJAS', 'irojas', NULL, '$2y$10$etZtzLU9Wr9DYu6u4S277O4z365we5S.oIHJVOYb/83p3sWHGB0ha', 3, 'o0LupBia3qUxIgWiqi9oEY0lcrPIhNOw9IXBVH0SvBrpZvvF0mgFz0q1nW2r', '2020-09-15 09:11:03', '2020-09-15 09:11:03', NULL),
(12, 'VICTOR CACERES', 'vcaceres', NULL, '$2y$10$K9EoMARn0tFADgtCYEQmR.BXCf7XV9Y9E/FucngVhuQxcW/dLRzbS', 3, 't9SdoxmlBWbAfzGer31e1jaPvHFhuYgfsXvivDZSHzlLXe5j55vdKphlAYIB', '2020-09-15 09:11:19', '2020-09-15 09:11:19', NULL),
(13, 'JINNET SALAZAR', 'jsalazar', NULL, '$2y$10$MCARqbz0GnTgWalo08FyEeOxvnh4bdr18QL9PbRkXKvi.N.8uHH0e', 2, NULL, '2020-09-15 09:12:14', '2020-09-23 18:21:47', NULL),
(14, 'LUIS AGUILAR', 'laguilar', NULL, '$2y$10$A4hXnEqtjphws1/uVdc4OuiRXf.ABdLDpNgAdNKYv1qQWItjk/IDy', 2, NULL, '2020-09-15 09:12:35', '2020-09-22 02:26:05', NULL),
(18, 'JAVIER ARTURO GONZALES AMPUERO', 'conductor1', NULL, '$2y$10$GA3425dzWaZBSGu1wfGsn./HiiwVNZLSI01oBZNJbetiUMEFqUIKu', 7, NULL, '2020-09-29 09:35:18', '2020-09-29 09:35:18', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `placa` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motor` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asientos` int(11) NOT NULL,
  `anio` year(4) NOT NULL,
  `marca_id` bigint(20) UNSIGNED NOT NULL,
  `ua_id` int(11) NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `contratista_id` bigint(20) UNSIGNED NOT NULL,
  `chasis` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concesionaria_id` bigint(20) UNSIGNED NOT NULL,
  `carroceria_id` int(11) NOT NULL,
  `kilometraje_id` bigint(20) UNSIGNED NOT NULL,
  `kilometraje_ini` decimal(18,2) NOT NULL,
  `kilometraje_act` decimal(18,2) NOT NULL,
  `kilometraje_rec` decimal(18,2) NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`id`, `placa`, `motor`, `modelo`, `asientos`, `anio`, `marca_id`, `ua_id`, `area_id`, `contratista_id`, `chasis`, `color`, `concesionaria_id`, `carroceria_id`, `kilometraje_id`, `kilometraje_ini`, `kilometraje_act`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AXF-554', 'DIESEL', 'AX-SDAS', 4, 2019, 1, 28, 2, 3, 'JASKFJA', 'ROJO', 1, 4, 1 ,500.00, 500.00, '2020-09-29 10:06:29', '2020-09-29 10:06:29', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculodocument`
--

CREATE TABLE `vehiculodocument` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehiculo_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notificacion` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_equipo_vehiculo`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_equipo_vehiculo` (
`id` bigint(20) unsigned
,`descripcion` varchar(22)
,`modelo` varchar(20)
,`placa` varchar(15)
,`marca_id` bigint(20) unsigned
,`area_id` bigint(20) unsigned
,`contratista_id` bigint(20) unsigned
,`anio` year(4)
,`tipo` varchar(1)
,`concesionaria_id` bigint(20) unsigned
,`ua` varchar(191)
,`ua_desc` mediumtext
,`deleted_at` timestamp
);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_equipo_vehiculo`
--
DROP TABLE IF EXISTS `view_equipo_vehiculo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`h2olmos`@`localhost` SQL SECURITY DEFINER VIEW `view_equipo_vehiculo`  AS  select `eq`.`id` AS `id`,`eq`.`descripcion` AS `descripcion`,`eq`.`modelo` AS `modelo`,`eq`.`placa` AS `placa`,`eq`.`marca_id` AS `marca_id`,`eq`.`area_id` AS `area_id`,`eq`.`contratista_id` AS `contratista_id`,`eq`.`anio` AS `anio`,'e' AS `tipo`,`eq`.`concesionaria_id` AS `concesionaria_id`,`ua`.`codigo` AS `ua`,`ua`.`descripcion` AS `ua_desc`,`eq`.`deleted_at` AS `deleted_at` from (`equipo` `eq` join `ua` on((`ua`.`id` = `eq`.`ua_id`))) union all select `ve`.`id` AS `id`,`ve`.`modelo` AS `descripcion`,`ve`.`modelo` AS `modelo`,`ve`.`placa` AS `placa`,`ve`.`marca_id` AS `marca_id`,`ve`.`area_id` AS `area_id`,`ve`.`contratista_id` AS `contratista_id`,`ve`.`anio` AS `anio`,'v' AS `tipo`,`ve`.`concesionaria_id` AS `concesionaria_id`,`ua`.`codigo` AS `ua`,`ua`.`descripcion` AS `ua_desc`,`ve`.`deleted_at` AS `deleted_at` from (`vehiculo` `ve` join `ua` on((`ua`.`id` = `ve`.`ua_id`))) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abastecimiento`
--
ALTER TABLE `abastecimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `abastecimiento_combustible`
--
ALTER TABLE `abastecimiento_combustible`
  ADD PRIMARY KEY (`id`),
  ADD KEY `abastecimiento_combustible_grifo_id_foreign` (`grifo_id`),
  ADD KEY `abastecimiento_combustible_conductor_id_foreign` (`conductor_id`),
  ADD KEY `abastecimiento_combustible_ua_id_foreign` (`ua_id`),
  ADD KEY `abastecimiento_combustible_equipo_id_foreign` (`equipo_id`),
  ADD KEY `abastecimiento_combustible_vehiculo_id_foreign` (`vehiculo_id`);

--
-- Indices de la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acceso_tipouser_id_foreign` (`tipouser_id`),
  ADD KEY `acceso_opcionmenu_id_foreign` (`opcionmenu_id`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carroceria`
--
ALTER TABLE `carroceria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `checklistvehicular`
--
ALTER TABLE `checklistvehicular`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checklistvehicular_equipo_id_foreign` (`equipo_id`),
  ADD KEY `checklistvehicular_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `checklistvehicular_conductor_id_foreign` (`conductor_id`),
  ADD KEY `checklistvehicular_concesionaria_id_foreign` (`concesionaria_id`);

--
-- Indices de la tabla `concesionaria`
--
ALTER TABLE `concesionaria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `concesionaria_ruc_unique` (`ruc`);

--
-- Indices de la tabla `conductor`
--
ALTER TABLE `conductor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conductor_dni_unique` (`dni`),
  ADD UNIQUE KEY `conductor_licencia_unique` (`licencia`),
  ADD KEY `conductor_contratista_id_foreign` (`contratista_id`);

--
-- Indices de la tabla `conductorconcesionaria`
--
ALTER TABLE `conductorconcesionaria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conductorconcesionaria_conductor_id_concesionaria_id_unique` (`conductor_id`,`concesionaria_id`),
  ADD KEY `conductorconcesionaria_concesionaria_id_foreign` (`concesionaria_id`);

--
-- Indices de la tabla `conductordocument`
--
ALTER TABLE `conductordocument`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conductordocument_conductor_id_foreign` (`conductor_id`);

--
-- Indices de la tabla `contratista`
--
ALTER TABLE `contratista`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contratista_ruc_unique` (`ruc`);

--
-- Indices de la tabla `controldiario`
--
ALTER TABLE `controldiario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `controldiario_equipo_id_foreign` (`equipo_id`),
  ADD KEY `controldiario_tipohora_id_foreign` (`tipohora_id`);

--
-- Indices de la tabla `descripcionregmanveh`
--
ALTER TABLE `descripcionregmanveh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `descripcionregmanveh_trabajo_id_foreign` (`trabajo_id`),
  ADD KEY `descripcionregmanveh_regmanveh_id_foreign` (`regmanveh_id`);

--
-- Indices de la tabla `descripcionregrepveh`
--
ALTER TABLE `descripcionregrepveh`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipo_marca_id_foreign` (`marca_id`),
  ADD KEY `equipo_contratista_id_foreign` (`contratista_id`),
  ADD KEY `equipo_area_id_foreign` (`area_id`),
  ADD KEY `equipo_concesionaria_id_foreign` (`concesionaria_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grifo`
--
ALTER TABLE `grifo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupomenu`
--
ALTER TABLE `grupomenu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `kilometraje`
--
ALTER TABLE `kilometraje`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kilometraje_descripcion_unique` (`descripcion`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marca_descripcion_unique` (`descripcion`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opcionmenu`
--
ALTER TABLE `opcionmenu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opcionmenu_grupomenu_id_foreign` (`grupomenu_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permiso_opcionmenu_id_foreign` (`opcionmenu_id`),
  ADD KEY `permiso_tipouser_id_foreign` (`tipouser_id`);

--
-- Indices de la tabla `regmanveh`
--
ALTER TABLE `regmanveh`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `regrepveh`
--
ALTER TABLE `regrepveh`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `repuesto`
--
ALTER TABLE `repuesto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `repuesto_codigo_unique` (`codigo`),
  ADD UNIQUE KEY `repuesto_descripcion_unique` (`descripcion`),
  ADD KEY `repuesto_unidad_id_foreign` (`unidad_id`);

--
-- Indices de la tabla `tipocombustible`
--
ALTER TABLE `tipocombustible`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipohora`
--
ALTER TABLE `tipohora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipouser`
--
ALTER TABLE `tipouser`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipovehiculodocument`
--
ALTER TABLE `tipovehiculodocument`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajo`
--
ALTER TABLE `trabajo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ua`
--
ALTER TABLE `ua`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ua_codigo_unique` (`codigo`),
  ADD KEY `ua_concesionaria_id_foreign` (`concesionaria_id`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `userconcesionaria`
--
ALTER TABLE `userconcesionaria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userconcesionaria_user_id_foreign` (`user_id`),
  ADD KEY `userconcesionaria_concesionaria_id_foreign` (`concesionaria_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_tipouser_id_foreign` (`tipouser_id`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculo_marca_id_foreign` (`marca_id`),
  ADD KEY `vehiculo_area_id_foreign` (`area_id`),
  ADD KEY `vehiculo_contratista_id_foreign` (`contratista_id`),
  ADD KEY `vehiculo_concesionaria_id_foreign` (`concesionaria_id`);

--
-- Indices de la tabla `vehiculodocument`
--
ALTER TABLE `vehiculodocument`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculodocument_vehiculo_id_foreign` (`vehiculo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abastecimiento`
--
ALTER TABLE `abastecimiento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `abastecimiento_combustible`
--
ALTER TABLE `abastecimiento_combustible`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `acceso`
--
ALTER TABLE `acceso`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `carroceria`
--
ALTER TABLE `carroceria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `checklistvehicular`
--
ALTER TABLE `checklistvehicular`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `concesionaria`
--
ALTER TABLE `concesionaria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `conductor`
--
ALTER TABLE `conductor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `conductorconcesionaria`
--
ALTER TABLE `conductorconcesionaria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `conductordocument`
--
ALTER TABLE `conductordocument`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `contratista`
--
ALTER TABLE `contratista`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `controldiario`
--
ALTER TABLE `controldiario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


--
-- AUTO_INCREMENT de la tabla `descripcionregrepveh`
--
ALTER TABLE `descripcionregrepveh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `descripcionregrepveh`
--
ALTER TABLE `descripcionregmanveh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grifo`
--
ALTER TABLE `grifo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `grupomenu`
--
ALTER TABLE `grupomenu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `kilometraje`
--
ALTER TABLE `kilometraje`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `opcionmenu`
--
ALTER TABLE `opcionmenu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `regmanveh`
--
ALTER TABLE `regmanveh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `regrepveh`
--
ALTER TABLE `regrepveh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `repuesto`
--
ALTER TABLE `repuesto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipocombustible`
--
ALTER TABLE `tipocombustible`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipohora`
--
ALTER TABLE `tipohora`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tipouser`
--
ALTER TABLE `tipouser`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipovehiculodocument`
--
ALTER TABLE `tipovehiculodocument`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajo`
--
ALTER TABLE `trabajo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ua`
--
ALTER TABLE `ua`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `userconcesionaria`
--
ALTER TABLE `userconcesionaria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `vehiculodocument`
--
ALTER TABLE `vehiculodocument`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `abastecimiento_combustible`
--
ALTER TABLE `abastecimiento_combustible`
  ADD CONSTRAINT `abastecimiento_combustible_conductor_id_foreign` FOREIGN KEY (`conductor_id`) REFERENCES `conductor` (`id`),
  ADD CONSTRAINT `abastecimiento_combustible_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`),
  ADD CONSTRAINT `abastecimiento_combustible_grifo_id_foreign` FOREIGN KEY (`grifo_id`) REFERENCES `grifo` (`id`),
  ADD CONSTRAINT `abastecimiento_combustible_ua_id_foreign` FOREIGN KEY (`ua_id`) REFERENCES `ua` (`id`),
  ADD CONSTRAINT `abastecimiento_combustible_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculo` (`id`);

--
-- Filtros para la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD CONSTRAINT `acceso_opcionmenu_id_foreign` FOREIGN KEY (`opcionmenu_id`) REFERENCES `opcionmenu` (`id`),
  ADD CONSTRAINT `acceso_tipouser_id_foreign` FOREIGN KEY (`tipouser_id`) REFERENCES `tipouser` (`id`);

--
-- Filtros para la tabla `checklistvehicular`
--
ALTER TABLE `checklistvehicular`
  ADD CONSTRAINT `checklistvehicular_concesionaria_id_foreign` FOREIGN KEY (`concesionaria_id`) REFERENCES `concesionaria` (`id`),
  ADD CONSTRAINT `checklistvehicular_conductor_id_foreign` FOREIGN KEY (`conductor_id`) REFERENCES `conductor` (`id`),
  ADD CONSTRAINT `checklistvehicular_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`),
  ADD CONSTRAINT `checklistvehicular_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculo` (`id`);

--
-- Filtros para la tabla `conductor`
--
ALTER TABLE `conductor`
  ADD CONSTRAINT `conductor_contratista_id_foreign` FOREIGN KEY (`contratista_id`) REFERENCES `contratista` (`id`);

--
-- Filtros para la tabla `conductorconcesionaria`
--
ALTER TABLE `conductorconcesionaria`
  ADD CONSTRAINT `conductorconcesionaria_concesionaria_id_foreign` FOREIGN KEY (`concesionaria_id`) REFERENCES `concesionaria` (`id`),
  ADD CONSTRAINT `conductorconcesionaria_conductor_id_foreign` FOREIGN KEY (`conductor_id`) REFERENCES `conductor` (`id`);

--
-- Filtros para la tabla `controldiario`
--
ALTER TABLE `controldiario`
  ADD CONSTRAINT `controldiario_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`),
  ADD CONSTRAINT `controldiario_tipohora_id_foreign` FOREIGN KEY (`tipohora_id`) REFERENCES `tipohora` (`id`);

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `equipo_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`),
  ADD CONSTRAINT `equipo_concesionaria_id_foreign` FOREIGN KEY (`concesionaria_id`) REFERENCES `concesionaria` (`id`),
  ADD CONSTRAINT `equipo_contratista_id_foreign` FOREIGN KEY (`contratista_id`) REFERENCES `contratista` (`id`),
  ADD CONSTRAINT `equipo_marca_id_foreign` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`);

--
-- Filtros para la tabla `opcionmenu`
--
ALTER TABLE `opcionmenu`
  ADD CONSTRAINT `opcionmenu_grupomenu_id_foreign` FOREIGN KEY (`grupomenu_id`) REFERENCES `grupomenu` (`id`);

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `permiso_opcionmenu_id_foreign` FOREIGN KEY (`opcionmenu_id`) REFERENCES `opcionmenu` (`id`),
  ADD CONSTRAINT `permiso_tipouser_id_foreign` FOREIGN KEY (`tipouser_id`) REFERENCES `tipouser` (`id`);

--
-- Filtros para la tabla `repuesto`
--
ALTER TABLE `repuesto`
  ADD CONSTRAINT `repuesto_unidad_id_foreign` FOREIGN KEY (`unidad_id`) REFERENCES `unidad` (`id`);

--
-- Filtros para la tabla `ua`
--
ALTER TABLE `ua`
  ADD CONSTRAINT `ua_concesionaria_id_foreign` FOREIGN KEY (`concesionaria_id`) REFERENCES `concesionaria` (`id`);

--
-- Filtros para la tabla `userconcesionaria`
--
ALTER TABLE `userconcesionaria`
  ADD CONSTRAINT `userconcesionaria_concesionaria_id_foreign` FOREIGN KEY (`concesionaria_id`) REFERENCES `concesionaria` (`id`),
  ADD CONSTRAINT `userconcesionaria_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_tipouser_id_foreign` FOREIGN KEY (`tipouser_id`) REFERENCES `tipouser` (`id`);

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `vehiculo_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`),
  ADD CONSTRAINT `vehiculo_concesionaria_id_foreign` FOREIGN KEY (`concesionaria_id`) REFERENCES `concesionaria` (`id`),
  ADD CONSTRAINT `vehiculo_contratista_id_foreign` FOREIGN KEY (`contratista_id`) REFERENCES `contratista` (`id`),
  ADD CONSTRAINT `vehiculo_marca_id_foreign` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`);

--
-- Filtros para la tabla `vehiculodocument`
--
ALTER TABLE `vehiculodocument`
  ADD CONSTRAINT `vehiculodocument_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
