-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 09, 2019 at 11:11 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lohagoporvos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoriaTrabajo`
--

CREATE TABLE `categoriaTrabajo` (
  `idCategoriaTrabajo` int(11) NOT NULL,
  `nombreCategoriaTrabajo` varchar(80) DEFAULT NULL,
  `descripcionCategoriaTrabajo` varchar(255) DEFAULT NULL,
  `imagenCategoriaTrabajo` varchar(511) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categoriaTrabajo`
--

INSERT INTO `categoriaTrabajo` (`idCategoriaTrabajo`, `nombreCategoriaTrabajo`, `descripcionCategoriaTrabajo`, `imagenCategoriaTrabajo`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 'Mascotas', 'Mascotas', 'categoriaMascota.jpg', 0, NULL, NULL),
(2, 'Auto', 'Auto', 'categoriaAuto.jpg', 0, NULL, NULL),
(3, 'Pago de servicios', 'Pago de servicios', 'categoriaServicios.jpg', 0, NULL, NULL),
(4, 'Turnos', 'Turnos', 'categoriaTurnos.png', 0, NULL, NULL),
(5, 'Tramites', 'Tramites', 'categoriaTramite.png', 0, NULL, NULL),
(6, 'Casa', 'Casa', 'categoriaCasa.jpg', 0, NULL, NULL),
(7, 'Jardin', 'Jardin', 'categoriaJardin.jpg', 0, NULL, NULL),
(8, 'Mantenimiento', 'Mantenimiento', 'categoriaMantenimiento.jpg', 0, NULL, NULL),
(9, 'Tecnico', 'Tecnico', 'categoriaTecnico.jpg', 0, NULL, NULL),
(10, 'Otro', 'Otro', 'categoriaOtro.png', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comentario`
--

CREATE TABLE `comentario` (
  `idComentario` int(11) NOT NULL,
  `contenido` varchar(255) NOT NULL,
  `idComentarioPadre` int(11) DEFAULT NULL,
  `idTrabajo` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conversacionchat`
--

CREATE TABLE `conversacionchat` (
  `idConversacionChat` int(11) NOT NULL,
  `idTrabajo` int(11) NOT NULL,
  `idPersona1` int(11) NOT NULL,
  `idPersona2` int(11) NOT NULL,
  `deshabilitado` tinyint(1) DEFAULT 0,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `conversacionchat`
--

INSERT INTO `conversacionchat` (`idConversacionChat`, `idTrabajo`, `idPersona1`, `idPersona2`, `deshabilitado`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 3, 6, 1, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE `estado` (
  `idEstado` int(11) NOT NULL,
  `nombreEstado` varchar(80) DEFAULT NULL,
  `descripcionEstado` varchar(160) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `estado`
--

INSERT INTO `estado` (`idEstado`, `nombreEstado`, `descripcionEstado`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 'Esperando Postulaciones', 'El anuncio espera postulaciones', 0, NULL, NULL),
(2, 'Evaluando Postulaciones', 'El anunciante esta evaluando las postulaciones', 0, NULL, NULL),
(3, 'Asignado', 'El anunciante asigno un postulante', 0, NULL, NULL),
(4, 'Esperando Confirmacion', 'Asignado ya realizo el trabajo. El anunciante debe confirmar el trabajo realizado', 0, NULL, NULL),
(5, 'Finalizado', 'Anuncio finalizado', 0, NULL, NULL),
(6, 'Cancelado', 'Anuncio cancelado', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `estadotrabajo`
--

CREATE TABLE `estadotrabajo` (
  `idEstadoTrabajo` int(11) NOT NULL,
  `idTrabajo` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `estadotrabajo`
--

INSERT INTO `estadotrabajo` (`idEstadoTrabajo`, `idTrabajo`, `idEstado`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, NULL, NULL),
(2, 2, 1, 0, NULL, NULL),
(3, 3, 1, 0, NULL, NULL),
(4, 4, 1, 0, NULL, NULL),
(5, 5, 1, 0, NULL, NULL),
(6, 6, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `habilidad`
--

CREATE TABLE `habilidad` (
  `idHabilidad` int(11) NOT NULL,
  `nombreHabilidad` varchar(80) DEFAULT NULL,
  `descripcionHabilidad` varchar(255) DEFAULT NULL,
  `imagenHabilidad` varchar(511) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `habilidad`
--

INSERT INTO `habilidad` (`idHabilidad`, `nombreHabilidad`, `descripcionHabilidad`, `imagenHabilidad`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 'Creativo', 'Descripcion habilidad 1', NULL, 0, NULL, NULL),
(2, 'Veloz', 'Descripcion habilidad 2', NULL, 0, NULL, NULL),
(3, 'Agil', 'Descripcion habilidad 3', NULL, 0, NULL, NULL),
(4, 'Social', 'Descripcion habilidad 4', NULL, 0, NULL, NULL),
(5, 'Positivo', 'Descripcion habilidad 5', NULL, 0, NULL, NULL),
(6, 'Confianza', 'Descripcion habilidad 6', NULL, 0, NULL, NULL),
(7, 'Pintor', 'Descripcion habilidad 7', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `habilidadpersona`
--

CREATE TABLE `habilidadpersona` (
  `idHabilidadPersona` int(11) NOT NULL,
  `idHabilidad` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `habilidadpersona`
--

INSERT INTO `habilidadpersona` (`idHabilidadPersona`, `idHabilidad`, `idPersona`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, NULL, NULL),
(2, 3, 1, 0, NULL, NULL),
(3, 5, 1, 0, NULL, NULL),
(4, 2, 2, 0, NULL, NULL),
(5, 4, 2, 0, NULL, NULL),
(6, 6, 2, 0, NULL, NULL),
(7, 1, 3, 0, NULL, NULL),
(8, 2, 3, 0, NULL, NULL),
(9, 5, 3, 0, NULL, NULL),
(10, 1, 4, 0, NULL, NULL),
(11, 6, 4, 0, NULL, NULL),
(12, 5, 4, 0, NULL, NULL),
(13, 7, 5, 0, NULL, NULL),
(14, 3, 5, 0, NULL, NULL),
(15, 2, 5, 0, NULL, NULL),
(16, 3, 6, 0, NULL, NULL),
(17, 4, 6, 0, NULL, NULL),
(18, 6, 6, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `localidad`
--

CREATE TABLE `localidad` (
  `idLocalidad` int(11) NOT NULL,
  `idProvincia` int(11) NOT NULL,
  `nombreLocalidad` varchar(50) DEFAULT NULL,
  `codigoPostal` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `localidad`
--

INSERT INTO `localidad` (`idLocalidad`, `idProvincia`, `nombreLocalidad`, `codigoPostal`, `created_at`, `updated_at`) VALUES
(2961, 22, 'ALLEN', 8328, NULL, NULL),
(2962, 22, 'BARDA DEL MEDIO', 8305, NULL, NULL),
(2967, 22, 'CINCO SALTOS', 8303, NULL, NULL),
(2968, 22, 'CIPOLLETTI', 8324, NULL, NULL),
(2973, 22, 'CONTRALMIRANTE CORDERO', 8301, NULL, NULL),
(2978, 22, 'CUATRO ESQUINAS', 8324, NULL, NULL),
(2984, 22, 'GENERAL FERNANDEZ ORO', 8324, NULL, NULL),
(2985, 22, 'GENERAL ROCA', 8332, NULL, NULL),
(2994, 22, 'LAGO PELLEGRINI', 8305, NULL, NULL),
(3001, 22, 'SARGENTO VIDAL', 8305, NULL, NULL),
(3005, 22, 'VILLA REGINA', 8336, NULL, NULL),
(3095, 22, 'VILLA MANZANO', 8308, NULL, NULL),
(4623, 20, 'ARROYITO', 8313, NULL, NULL),
(4627, 20, 'CENTENARIO', 8309, NULL, NULL),
(4629, 20, 'CHINA MUERTA', 8316, NULL, NULL),
(4631, 20, 'LAS PERLAS', 8300, NULL, NULL),
(4634, 20, 'NEUQUEN', 8300, NULL, NULL),
(4637, 20, 'PLOTTIER', 8316, NULL, NULL),
(4642, 20, 'SENILLOSA', 8316, NULL, NULL),
(4643, 20, 'VILLA EL CHOCON', 8311, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mensajechat`
--

CREATE TABLE `mensajechat` (
  `idMensajeChat` int(11) NOT NULL,
  `idConversacionChat` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `mensaje` varchar(511) DEFAULT NULL,
  `visto` tinyint(1) DEFAULT 0,
  `fechaVisto` timestamp NULL DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mensajechat`
--

INSERT INTO `mensajechat` (`idMensajeChat`, `idConversacionChat`, `idPersona`, `mensaje`, `visto`, `fechaVisto`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'euuuuuu', 0, NULL, 0, '2019-12-09 23:13:52', '2019-12-09 23:13:52'),
(2, 1, 6, 'holis', 0, NULL, 0, '2019-12-09 23:23:14', '2019-12-09 23:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `multa`
--

CREATE TABLE `multa` (
  `idMulta` int(11) NOT NULL,
  `idTrabajo` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `motivo` varchar(511) DEFAULT NULL,
  `valor` varchar(16) DEFAULT NULL,
  `fechaPagado` timestamp NULL DEFAULT NULL,
  `pagado` tinyint(1) DEFAULT 0,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pagorecibido`
--

CREATE TABLE `pagorecibido` (
  `idPagoRecibido` int(11) NOT NULL,
  `idTrabajo` int(11) NOT NULL,
  `idPago` varchar(255) NOT NULL,
  `monto` float(8,2) NOT NULL,
  `metodo` varchar(255) NOT NULL,
  `tarjeta` varchar(255) NOT NULL,
  `fechapago` timestamp NULL DEFAULT NULL,
  `fechaaprobado` timestamp NULL DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE `persona` (
  `idPersona` int(11) NOT NULL,
  `nombrePersona` varchar(80) NOT NULL,
  `apellidoPersona` varchar(80) NOT NULL,
  `dniPersona` varchar(10) DEFAULT NULL,
  `telefonoPersona` varchar(32) DEFAULT NULL,
  `idLocalidad` int(11) NOT NULL,
  `imagenPersona` varchar(511) DEFAULT NULL,
  `numeroCBU` varchar(22) DEFAULT NULL,
  `idUsuario` int(11) NOT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`idPersona`, `nombrePersona`, `apellidoPersona`, `dniPersona`, `telefonoPersona`, `idLocalidad`, `imagenPersona`, `numeroCBU`, `idUsuario`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 'Juan', 'Sanchez', '89576214', '2995049638', 4634, 'diegoImplorando.jpg', '1234123412341234123412', 1, 0, '2019-09-23 03:37:12', '2019-09-23 03:37:12'),
(2, 'Maria Jose', 'Perez', '46325896', '02995698835', 4634, 'nickiAdolorida.jpg', '1234156785678234123412', 2, 0, '2019-09-23 03:39:52', '2019-09-23 03:39:52'),
(3, 'Sofia', 'Galletas', '45698746', '2991365289', 4634, 'ofeliaPensando.jpg', '1234123412341234125678', 3, 0, '2019-09-23 03:41:13', '2019-09-23 03:41:13'),
(4, 'Marcelo Antonio', 'Quintana', '43589633', '2994896324', 4634, 'diegoContento.jpg', '1234123412341234123412', 4, 0, '2019-09-23 03:42:34', '2019-09-23 03:42:34'),
(5, 'Emiliano', 'Gonzales', '46987456', '2991365852', 2968, 'juanRomanContento.jpg', '1234123456781234123412', 5, 0, '2019-09-23 03:45:11', '2019-09-23 03:45:11'),
(6, 'Federico', 'de Girasol', '46986325', '2998963258', 4634, 'juanRomanLegendario.jpg', '1234123412341234123412', 6, 0, '2019-09-23 03:58:03', '2019-09-23 03:58:03'),
(7, 'Lo Hago', 'Por Vos', '12312312', '2994122312', 4634, 'sistema.jpg', '5678123412341234123412', 7, 0, '2019-09-23 03:58:03', '2019-09-23 03:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `preferenciapersona`
--

CREATE TABLE `preferenciapersona` (
  `idPreferenciaPersona` int(11) NOT NULL,
  `idCategoriaTrabajo` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `preferenciapersona`
--

INSERT INTO `preferenciapersona` (`idPreferenciaPersona`, `idCategoriaTrabajo`, `idPersona`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, NULL, NULL),
(2, 2, 2, 0, NULL, NULL),
(3, 3, 3, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `provincia`
--

CREATE TABLE `provincia` (
  `idProvincia` int(11) NOT NULL,
  `nombreProvincia` varchar(50) DEFAULT NULL,
  `codigoIso31662` char(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `provincia`
--

INSERT INTO `provincia` (`idProvincia`, `nombreProvincia`, `codigoIso31662`, `created_at`, `updated_at`) VALUES
(20, 'Neuquén', 'AR-Q', NULL, NULL),
(22, 'Río Negro', 'AR-R', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `nombreRol` varchar(80) NOT NULL,
  `descripcionRol` varchar(80) NOT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`idRol`, `nombreRol`, `descripcionRol`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Administrador', 0, NULL, NULL),
(2, 'Usuario', 'Usuario', 0, NULL, NULL),
(3, 'Gestor', 'Usuario', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trabajo`
--

CREATE TABLE `trabajo` (
  `idTrabajo` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  `idCategoriaTrabajo` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `idLocalidad` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` varchar(511) DEFAULT NULL,
  `monto` float(8,2) DEFAULT NULL,
  `imagenTrabajo` varchar(511) DEFAULT NULL,
  `tiempoExpiracion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trabajo`
--

INSERT INTO `trabajo` (`idTrabajo`, `idEstado`, `idCategoriaTrabajo`, `idPersona`, `idLocalidad`, `titulo`, `descripcion`, `monto`, `imagenTrabajo`, `tiempoExpiracion`, `created_at`, `updated_at`, `eliminado`) VALUES
(1, 1, 1, 3, 4634, 'Lavar a Flopy', 'Alguien que pueda llevar a mi perrita al petshop MiPerrito', 600.00, 'categoriaMascota.jpg', '2019-12-12 03:00:00', '2019-09-23 03:47:02', '2019-09-23 03:47:02', 0),
(2, 1, 2, 5, 4634, 'Quien me lava mi auto ????', 'Alguien que me lave el auto que no tengo ganas xD', 300.00, 'categoriaAuto.jpg', '2019-12-12 03:00:00', '2019-09-23 03:48:40', '2019-09-23 03:48:40', 0),
(3, 1, 3, 1, 4634, 'Recital de pablo londra', 'quien puede hacer la fila por mi el dia del recital', 150.00, 'categoriaServicios.jpg', '2019-12-12 03:00:00', '2019-09-23 03:51:06', '2019-09-23 03:51:06', 0),
(4, 1, 4, 4, 4634, 'cortar el cesped', 'tengo que cortar el cesped antes del finde. si queda bien lo llamo la proxima vez y recomiendo. pongo 5 estrellas', 560.00, 'categoriaTurnos.png', '2019-12-12 03:00:00', '2019-09-23 03:55:10', '2019-09-23 03:55:10', 0),
(5, 1, 5, 4, 4634, 'armar la pelopincho', 'alguien para armar la pile porfa. me operaron y no puedo hacer fuerza. gracias', 360.00, 'categoriaTramite.png', '2019-12-12 03:00:00', '2019-09-23 03:56:35', '2019-09-23 03:56:35', 0),
(6, 1, 6, 6, 4634, 'pasear el perro', 'quien lo puede pasear a mi perro. es por el lunes a la tarde', 240.00, 'categoriaCasa.jpg', '2019-12-12 03:00:00', '2019-09-23 04:01:51', '2019-09-23 04:01:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `trabajoasignado`
--

CREATE TABLE `trabajoasignado` (
  `idTrabajoAsignado` int(11) NOT NULL,
  `idTrabajo` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trabajoaspirante`
--

CREATE TABLE `trabajoaspirante` (
  `idTrabajoAspirante` int(11) NOT NULL,
  `idTrabajo` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trabajoaspirante`
--

INSERT INTO `trabajoaspirante` (`idTrabajoAspirante`, `idTrabajo`, `idPersona`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 0, NULL, NULL),
(2, 6, 2, 0, NULL, NULL),
(3, 6, 3, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombreUsuario` varchar(80) NOT NULL,
  `mailUsuario` varchar(80) NOT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `claveUsuario` varchar(255) NOT NULL,
  `idRol` int(11) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombreUsuario`, `mailUsuario`, `auth_key`, `claveUsuario`, `idRol`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `eliminado`) VALUES
(1, 'juan88', 'juan88@gmail.com', 'authkey', '$2y$10$/E8BV4bHWNJ5dRuiT.VzduKyk4b3wFmhqI9lCDSDyRQUwllpb6q1q', 2, '2019-11-07 23:06:06', NULL, '2019-09-23 03:36:43', '2019-09-23 03:36:43', 0),
(2, 'Maria', 'marianqn@hotmail.com', 'authkey', '$2y$10$.zzZfhyCD0fccwS3al9yge.N/RcMlVevmcxuEXFu285I0MeuREFdy', 2, '2019-11-07 23:06:06', NULL, '2019-09-23 03:39:18', '2019-09-23 03:39:18', 0),
(3, 'sofi89', 'sofia_love@yahoo.com', 'authkey', '$2y$10$wJYQxiIoDss0pMwOVGa9remm7eAthTg8dt6RkaduQLuTrK7jxH9US', 2, '2019-11-07 23:06:06', NULL, '2019-09-23 03:40:50', '2019-09-23 03:40:50', 0),
(4, 'MarceloQ', 'marceloqa@gmail.com', 'authkey', '$2y$10$QGmABaoc/uDVF310J2Xyiujfs60tZcWL3.suK0xgl0UtIX5w4yPdm', 2, '2019-11-07 23:06:06', NULL, '2019-09-23 03:41:52', '2019-09-23 03:41:52', 0),
(5, 'emiElMasCopado', 'emiliano896325@hotmail.com', 'authkey', '$2y$10$tLBIpow2heq/GtQzYpeH3.N8jmtJzEJwFt0peulIlwZ5eX5M.SKs2', 2, '2019-11-07 23:06:06', NULL, '2019-09-23 03:44:18', '2019-09-23 03:44:18', 0),
(6, 'elpana', 'elpana@gmail.com', 'authkey', '$2y$10$oWPaukdqz42rriPArLqYhuk4Hr.m.yuAEH55kniQtUo.vVb6hfNFu', 1, '2019-11-07 23:06:06', NULL, '2019-09-23 03:57:22', '2019-09-23 03:57:22', 0),
(7, 'lohagoporvos', 'lohagoporvosservicios@gmail.com', 'authkey', '$2y$10$oWPaukdqz42rriPArLqYhuk4Hr.m.yuAEH55kniQtUo.vVb6hfNFu', 1, '2019-11-07 23:06:06', NULL, '2019-09-23 03:57:22', '2019-09-23 03:57:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `valoracion`
--

CREATE TABLE `valoracion` (
  `idValoracion` int(11) NOT NULL,
  `valor` int(11) NOT NULL DEFAULT 0,
  `idTrabajo` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `comentarioValoracion` varchar(511) DEFAULT NULL,
  `imagenValoracion` varchar(511) DEFAULT NULL,
  `eliminado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoriaTrabajo`
--
ALTER TABLE `categoriaTrabajo`
  ADD PRIMARY KEY (`idCategoriaTrabajo`);

--
-- Indexes for table `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`idComentario`),
  ADD KEY `idTrabajo` (`idTrabajo`),
  ADD KEY `idPersona` (`idPersona`),
  ADD KEY `idComentarioPadre` (`idComentarioPadre`);

--
-- Indexes for table `conversacionchat`
--
ALTER TABLE `conversacionchat`
  ADD PRIMARY KEY (`idConversacionChat`),
  ADD KEY `idTrabajo` (`idTrabajo`),
  ADD KEY `idPersona1` (`idPersona1`),
  ADD KEY `idPersona2` (`idPersona2`);

--
-- Indexes for table `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indexes for table `estadotrabajo`
--
ALTER TABLE `estadotrabajo`
  ADD PRIMARY KEY (`idEstadoTrabajo`),
  ADD KEY `idTrabajo` (`idTrabajo`),
  ADD KEY `idEstado` (`idEstado`);

--
-- Indexes for table `habilidad`
--
ALTER TABLE `habilidad`
  ADD PRIMARY KEY (`idHabilidad`);

--
-- Indexes for table `habilidadpersona`
--
ALTER TABLE `habilidadpersona`
  ADD PRIMARY KEY (`idHabilidadPersona`),
  ADD KEY `idHabilidad` (`idHabilidad`),
  ADD KEY `idPersona` (`idPersona`);

--
-- Indexes for table `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`idLocalidad`),
  ADD KEY `idProvincia` (`idProvincia`);

--
-- Indexes for table `mensajechat`
--
ALTER TABLE `mensajechat`
  ADD PRIMARY KEY (`idMensajeChat`),
  ADD KEY `idConversacionChat` (`idConversacionChat`),
  ADD KEY `idPersona` (`idPersona`);

--
-- Indexes for table `multa`
--
ALTER TABLE `multa`
  ADD PRIMARY KEY (`idMulta`),
  ADD KEY `idTrabajo` (`idTrabajo`),
  ADD KEY `idPersona` (`idPersona`);

--
-- Indexes for table `pagorecibido`
--
ALTER TABLE `pagorecibido`
  ADD PRIMARY KEY (`idPagoRecibido`),
  ADD KEY `idTrabajo` (`idTrabajo`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idPersona`),
  ADD KEY `idLocalidad` (`idLocalidad`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indexes for table `preferenciapersona`
--
ALTER TABLE `preferenciapersona`
  ADD PRIMARY KEY (`idPreferenciaPersona`),
  ADD KEY `idCategoriaTrabajo` (`idCategoriaTrabajo`),
  ADD KEY `idPersona` (`idPersona`);

--
-- Indexes for table `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`idProvincia`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indexes for table `trabajo`
--
ALTER TABLE `trabajo`
  ADD PRIMARY KEY (`idTrabajo`),
  ADD KEY `idEstado` (`idEstado`),
  ADD KEY `idLocalidad` (`idLocalidad`),
  ADD KEY `idPersona` (`idPersona`),
  ADD KEY `idCategoriaTrabajo` (`idCategoriaTrabajo`);

--
-- Indexes for table `trabajoasignado`
--
ALTER TABLE `trabajoasignado`
  ADD PRIMARY KEY (`idTrabajoAsignado`),
  ADD KEY `idTrabajo` (`idTrabajo`),
  ADD KEY `idPersona` (`idPersona`);

--
-- Indexes for table `trabajoaspirante`
--
ALTER TABLE `trabajoaspirante`
  ADD PRIMARY KEY (`idTrabajoAspirante`),
  ADD KEY `idTrabajo` (`idTrabajo`),
  ADD KEY `idPersona` (`idPersona`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idRol` (`idRol`);

--
-- Indexes for table `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`idValoracion`),
  ADD KEY `idTrabajo` (`idTrabajo`),
  ADD KEY `idPersona` (`idPersona`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoriaTrabajo`
--
ALTER TABLE `categoriaTrabajo`
  MODIFY `idCategoriaTrabajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comentario`
--
ALTER TABLE `comentario`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversacionchat`
--
ALTER TABLE `conversacionchat`
  MODIFY `idConversacionChat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `estado`
--
ALTER TABLE `estado`
  MODIFY `idEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `estadotrabajo`
--
ALTER TABLE `estadotrabajo`
  MODIFY `idEstadoTrabajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `habilidad`
--
ALTER TABLE `habilidad`
  MODIFY `idHabilidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `habilidadpersona`
--
ALTER TABLE `habilidadpersona`
  MODIFY `idHabilidadPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `localidad`
--
ALTER TABLE `localidad`
  MODIFY `idLocalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4644;

--
-- AUTO_INCREMENT for table `mensajechat`
--
ALTER TABLE `mensajechat`
  MODIFY `idMensajeChat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `multa`
--
ALTER TABLE `multa`
  MODIFY `idMulta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagorecibido`
--
ALTER TABLE `pagorecibido`
  MODIFY `idPagoRecibido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `idPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `preferenciapersona`
--
ALTER TABLE `preferenciapersona`
  MODIFY `idPreferenciaPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `provincia`
--
ALTER TABLE `provincia`
  MODIFY `idProvincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trabajo`
--
ALTER TABLE `trabajo`
  MODIFY `idTrabajo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trabajoasignado`
--
ALTER TABLE `trabajoasignado`
  MODIFY `idTrabajoAsignado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trabajoaspirante`
--
ALTER TABLE `trabajoaspirante`
  MODIFY `idTrabajoAspirante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `idValoracion` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo` (`idTrabajo`),
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`),
  ADD CONSTRAINT `comentario_ibfk_3` FOREIGN KEY (`idComentarioPadre`) REFERENCES `comentario` (`idComentario`);

--
-- Constraints for table `conversacionchat`
--
ALTER TABLE `conversacionchat`
  ADD CONSTRAINT `conversacionchat_ibfk_1` FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo` (`idTrabajo`),
  ADD CONSTRAINT `conversacionchat_ibfk_2` FOREIGN KEY (`idPersona1`) REFERENCES `persona` (`idPersona`),
  ADD CONSTRAINT `conversacionchat_ibfk_3` FOREIGN KEY (`idPersona2`) REFERENCES `persona` (`idPersona`);

--
-- Constraints for table `estadotrabajo`
--
ALTER TABLE `estadotrabajo`
  ADD CONSTRAINT `estadotrabajo_ibfk_1` FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo` (`idTrabajo`),
  ADD CONSTRAINT `estadotrabajo_ibfk_2` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`);

--
-- Constraints for table `habilidadpersona`
--
ALTER TABLE `habilidadpersona`
  ADD CONSTRAINT `habilidadpersona_ibfk_1` FOREIGN KEY (`idHabilidad`) REFERENCES `habilidad` (`idHabilidad`),
  ADD CONSTRAINT `habilidadpersona_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);

--
-- Constraints for table `localidad`
--
ALTER TABLE `localidad`
  ADD CONSTRAINT `localidad_ibfk_1` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`idProvincia`);

--
-- Constraints for table `mensajechat`
--
ALTER TABLE `mensajechat`
  ADD CONSTRAINT `mensajechat_ibfk_1` FOREIGN KEY (`idConversacionChat`) REFERENCES `conversacionchat` (`idConversacionChat`),
  ADD CONSTRAINT `mensajechat_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);

--
-- Constraints for table `multa`
--
ALTER TABLE `multa`
  ADD CONSTRAINT `multa_ibfk_1` FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo` (`idTrabajo`),
  ADD CONSTRAINT `multa_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);

--
-- Constraints for table `pagorecibido`
--
ALTER TABLE `pagorecibido`
  ADD CONSTRAINT `pagorecibido_ibfk_1` FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo` (`idTrabajo`);

--
-- Constraints for table `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`idLocalidad`) REFERENCES `localidad` (`idLocalidad`),
  ADD CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Constraints for table `preferenciapersona`
--
ALTER TABLE `preferenciapersona`
  ADD CONSTRAINT `preferenciapersona_ibfk_1` FOREIGN KEY (`idCategoriaTrabajo`) REFERENCES `categoriaTrabajo` (`idCategoriaTrabajo`),
  ADD CONSTRAINT `preferenciapersona_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);

--
-- Constraints for table `trabajo`
--
ALTER TABLE `trabajo`
  ADD CONSTRAINT `trabajo_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`),
  ADD CONSTRAINT `trabajo_ibfk_2` FOREIGN KEY (`idLocalidad`) REFERENCES `localidad` (`idLocalidad`),
  ADD CONSTRAINT `trabajo_ibfk_3` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`),
  ADD CONSTRAINT `trabajo_ibfk_4` FOREIGN KEY (`idCategoriaTrabajo`) REFERENCES `categoriaTrabajo` (`idCategoriaTrabajo`);

--
-- Constraints for table `trabajoasignado`
--
ALTER TABLE `trabajoasignado`
  ADD CONSTRAINT `trabajoasignado_ibfk_1` FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo` (`idTrabajo`),
  ADD CONSTRAINT `trabajoasignado_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);

--
-- Constraints for table `trabajoaspirante`
--
ALTER TABLE `trabajoaspirante`
  ADD CONSTRAINT `trabajoaspirante_ibfk_1` FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo` (`idTrabajo`),
  ADD CONSTRAINT `trabajoaspirante_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`);

--
-- Constraints for table `valoracion`
--
ALTER TABLE `valoracion`
  ADD CONSTRAINT `valoracion_ibfk_1` FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo` (`idTrabajo`),
  ADD CONSTRAINT `valoracion_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
