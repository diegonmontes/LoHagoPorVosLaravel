-- Tipo ofrecido o realizado --
CREATE TABLE `estado`(
    `idEstado` int NOT NULL AUTO_INCREMENT,
    `nombreEstado` VARCHAR(80),
    `descripcionEstado` VARCHAR(80),
    `eliminado` TINYINT(1) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idEstado`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `categoriaTrabajo`(
    `idCategoriaTrabajo` int NOT NULL AUTO_INCREMENT,
    `nombreCategoriaTrabajo` VARCHAR(80),
    `descripcionCategoriaTrabajo` VARCHAR(255),
    `imagenCategoriaTrabajo` VARCHAR(511),
    `eliminado` TINYINT(1) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idCategoriaTrabajo`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `provincia`(
    `idProvincia` int NOT NULL AUTO_INCREMENT,
    `nombreProvincia` VARCHAR(50),
    `codigoIso31662` char(4) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idProvincia`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `localidad`(
    `idLocalidad` int NOT NULL AUTO_INCREMENT,
    `idProvincia` int NOT NULL,
    `nombreLocalidad` VARCHAR(50),
    `codigoPostal` smallint(6) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idLocalidad`),
    FOREIGN KEY (`idProvincia`) REFERENCES `provincia`(`idProvincia`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `rol`(
    `idRol` int NOT NULL AUTO_INCREMENT,
    `nombreRol` VARCHAR(80) NOT NULL,
    `descripcionRol` VARCHAR(80) NOT NULL,
    `eliminado` TINYINT(1) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idRol`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `usuario`(
    `idUsuario` int NOT NULL AUTO_INCREMENT,
    `nombreUsuario` VARCHAR(80) NOT NULL,
    `mailUsuario` VARCHAR(80) NOT NULL,
    `auth_key` VARCHAR(255) DEFAULT NULL,
    `claveUsuario` VARCHAR(255) NOT NULL,
    `idRol` INT NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `eliminado` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`idUsuario`),
    FOREIGN KEY (`idRol`) REFERENCES `rol`(`idRol`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `persona`(
    `idPersona` int NOT NULL AUTO_INCREMENT,
    `nombrePersona` VARCHAR(80) NOT NULL,
    `apellidoPersona` VARCHAR(80) NOT NULL,
    `dniPersona` VARCHAR(10),
    `telefonoPersona` VARCHAR(32),
    `idLocalidad` INT NOT NULL,
    `imagenPersona` VARCHAR(511),
    `idUsuario` INT NOT NULL,
    `eliminado` TINYINT(1) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idPersona`),
    FOREIGN KEY (`idLocalidad`) REFERENCES `localidad`(`idLocalidad`),
    FOREIGN KEY (`idUsuario`) REFERENCES `usuario`(`idUsuario`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `habilidad`(
    `idHabilidad` int NOT NULL AUTO_INCREMENT,
    `nombreHabilidad` VARCHAR(80),
    `descripcionHabilidad` VARCHAR(255),
    `imagenHabilidad` VARCHAR(511),
    `eliminado` TINYINT(1) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idHabilidad`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `habilidadpersona`(
  `idHabilidadPersona` int NOT NULL AUTO_INCREMENT,
  `idHabilidad` INT NOT NULL,
  `idPersona` INT NOT NULL,
  `eliminado` TINYINT(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idHabilidadPersona`),
  FOREIGN KEY (`idHabilidad`) REFERENCES `habilidad`(`idHabilidad`),
  FOREIGN KEY (`idPersona`) REFERENCES `persona`(`idPersona`)

)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `preferenciapersona`(
  `idPreferenciaPersona` int NOT NULL AUTO_INCREMENT,
  `idCategoriaTrabajo` INT NOT NULL,
  `idPersona` INT NOT NULL,
  `eliminado` TINYINT(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idPreferenciaPersona`),
  FOREIGN KEY (`idCategoriaTrabajo`) REFERENCES `categoriaTrabajo`(`idCategoriaTrabajo`),
  FOREIGN KEY (`idPersona`) REFERENCES `persona`(`idPersona`)

)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `trabajo`(
    `idTrabajo` int NOT NULL AUTO_INCREMENT,
    `idEstado` int NOT NULL,
    `idCategoriaTrabajo` int NOT NULL,
    `idPersona` int NOT NULL,
    `idLocalidad` INT NOT NULL,
    `titulo` varchar(255),
    `descripcion` varchar(511),
    `monto` FLOAT(8,2),
    `imagenTrabajo` VARCHAR(511),
    `tiempoExpiracion` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `eliminado` TINYINT(1) DEFAULT 0,
    primary key (`idTrabajo`), 
    FOREIGN KEY (`idEstado`) REFERENCES `estado`(`idEstado`),
    FOREIGN KEY (`idLocalidad`) REFERENCES `localidad`(`idLocalidad`),
    FOREIGN KEY (`idCategoriaTrabajo`) REFERENCES `categoriaTrabajo`(`idCategoriaTrabajo`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `valoracion`(
    `idValoracion` int NOT NULL AUTO_INCREMENT,
    `valor` INT NOT NULL DEFAULT 0,
    `idTrabajo` INT NOT NULL,
    `idPersona` INT NOT NULL,
    `eliminado` TINYINT(1) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idValoracion`),
    FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo`(`idTrabajo`),
    FOREIGN KEY (`idPersona`) REFERENCES `persona`(`idPersona`)
  
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `trabajoaspirante`(
  `idTrabajoAspirante` int NOT NULL AUTO_INCREMENT,
  `idTrabajo` INT NOT NULL,
  `idPersona` INT NOT NULL,
  `eliminado` TINYINT(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idTrabajoAspirante`),
  FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo`(`idTrabajo`),
  FOREIGN KEY (`idPersona`) REFERENCES `persona`(`idPersona`)

)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `estadotrabajo`(
    `idEstadoTrabajo` int NOT NULL AUTO_INCREMENT,
    `idTrabajo` INT NOT NULL,
    `idEstado` INT NOT NULL,
    `eliminado` TINYINT(1) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
  	`updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idEstadoTrabajo`),
    FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo`(`idTrabajo`),
    FOREIGN KEY (`idEstado`) REFERENCES `estado`(`idEstado`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `trabajoasignado`(
  `idTrabajoAsignado` int NOT NULL AUTO_INCREMENT,
  `idTrabajo` INT NOT NULL,
  `idPersona` INT NOT NULL,
  `eliminado` TINYINT(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idTrabajoAsignado`),
  FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo`(`idTrabajo`),
  FOREIGN KEY (`idPersona`) REFERENCES `persona`(`idPersona`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pagorecibido`(
  `idPagoRecibido` int NOT NULL AUTO_INCREMENT,
  `idTrabajo` INT NOT NULL,
  `idPago` VARCHAR(255) NOT NULL,
  `monto` FLOAT(8,2) NOT NULL,
  `metodo` VARCHAR(255) NOT NULL,
  `tarjeta` VARCHAR(255) NOT NULL,
  `fechapago` timestamp NULL DEFAULT NULL,
  `fechaaprobado` timestamp NULL DEFAULT NULL,
  `eliminado` TINYINT(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idPagoRecibido`),
  FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo`(`idTrabajo`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `conversacionchat`(
  `idConversacionChat` int NOT NULL AUTO_INCREMENT,
  `idTrabajo` INT NOT NULL,
  `idPersona1` INT NOT NULL,
  `idPersona2` INT NOT NULL,
  `eliminado` TINYINT(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idConversacionChat`),
  FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo`(`idTrabajo`),
  FOREIGN KEY (`idPersona1`) REFERENCES `persona`(`idPersona`),
  FOREIGN KEY (`idPersona2`) REFERENCES `persona`(`idPersona`)

)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `mensajechat`(
  `idMensajeChat` int NOT NULL AUTO_INCREMENT,
  `idConversacionChat` INT NOT NULL,
  `idPersona` INT NOT NULL,
  `mensaje` varchar(511),
  `eliminado` TINYINT(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idMensajeChat`),
  FOREIGN KEY (`idConversacionChat`) REFERENCES `conversacionchat`(`idConversacionChat`),
  FOREIGN KEY (`idPersona`) REFERENCES `persona`(`idPersona`)

)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `comentario`(
    `idComentario` INT NOT NULL AUTO_INCREMENT,
    `contenido` VARCHAR(255) NOT NULL,
    `idComentarioPadre` INT DEFAULT NULL,
    `idTrabajo` INT NOT NULL,
    `idPersona` INT NOT NULL,
    `eliminado` TINYINT(1) DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idComentario`),
    FOREIGN KEY (`idTrabajo`) REFERENCES `trabajo`(`idTrabajo`),
    FOREIGN KEY (`idPersona`) REFERENCES `persona`(`idPersona`),
    FOREIGN KEY (`idComentarioPadre`) REFERENCES `comentario`(`idComentario`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Poblacional
--


INSERT INTO `provincia` (`idProvincia`, `nombreProvincia`, `codigoIso31662`) VALUES
(20, 'Neuquén', 'AR-Q'),
(22, 'Río Negro', 'AR-R');

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


INSERT INTO `rol`(`idRol`, `nombreRol`, `descripcionRol`) VALUES (1,'Administrador','Administrador');
INSERT INTO `rol`(`idRol`, `nombreRol`, `descripcionRol`) VALUES (2,'Usuario','Usuario');
INSERT INTO `rol`(`idRol`, `nombreRol`, `descripcionRol`) VALUES (3,'Gestor','Usuario');


INSERT INTO `estado`(`idEstado`, `nombreEstado`, `descripcionEstado`) VALUES (1,'Publicado','El anuncio esta publicado');
INSERT INTO `estado`(`idEstado`, `nombreEstado`, `descripcionEstado`) VALUES (2,'Esperando Postulaciones','El anuncio espera postulaciones');
INSERT INTO `estado`(`idEstado`, `nombreEstado`, `descripcionEstado`) VALUES (3,'Evaluando Postulaciones','El anunciante esta evaluando las postulaciones');
INSERT INTO `estado`(`idEstado`, `nombreEstado`, `descripcionEstado`) VALUES (4,'Asignado','El anunciante asigno un postulante');
INSERT INTO `estado`(`idEstado`, `nombreEstado`, `descripcionEstado`) VALUES (5,'Finalizado','Anuncio finalizado');

INSERT INTO `categoriaTrabajo`(`idCategoriaTrabajo`, `nombreCategoriaTrabajo`,`descripcionCategoriaTrabajo`,`imagenCategoriaTrabajo`) VALUES (1,'Mascotas','Mascotas',NULL);
INSERT INTO `categoriaTrabajo`(`idCategoriaTrabajo`, `nombreCategoriaTrabajo`,`descripcionCategoriaTrabajo`,`imagenCategoriaTrabajo`) VALUES (2,'Auto','Auto',NULL);
INSERT INTO `categoriaTrabajo`(`idCategoriaTrabajo`, `nombreCategoriaTrabajo`,`descripcionCategoriaTrabajo`,`imagenCategoriaTrabajo`) VALUES (3,'Pago de servicios','Pago de servicios',NULL);
INSERT INTO `categoriaTrabajo`(`idCategoriaTrabajo`, `nombreCategoriaTrabajo`,`descripcionCategoriaTrabajo`,`imagenCategoriaTrabajo`) VALUES (4,'Turnos','Turnos',NULL);
INSERT INTO `categoriaTrabajo`(`idCategoriaTrabajo`, `nombreCategoriaTrabajo`,`descripcionCategoriaTrabajo`,`imagenCategoriaTrabajo`) VALUES (5,'Tramites','Tramites',NULL);
INSERT INTO `categoriaTrabajo`(`idCategoriaTrabajo`, `nombreCategoriaTrabajo`,`descripcionCategoriaTrabajo`,`imagenCategoriaTrabajo`) VALUES (6,'Casa','Casa',NULL);
INSERT INTO `categoriaTrabajo`(`idCategoriaTrabajo`, `nombreCategoriaTrabajo`,`descripcionCategoriaTrabajo`,`imagenCategoriaTrabajo`) VALUES (7,'Jardin','Jardin',NULL);
INSERT INTO `categoriaTrabajo`(`idCategoriaTrabajo`, `nombreCategoriaTrabajo`,`descripcionCategoriaTrabajo`,`imagenCategoriaTrabajo`) VALUES (8,'Mantenimiento','Mantenimiento',NULL);
INSERT INTO `categoriaTrabajo`(`idCategoriaTrabajo`, `nombreCategoriaTrabajo`,`descripcionCategoriaTrabajo`,`imagenCategoriaTrabajo`) VALUES (9,'Tecnico','Tecnico',NULL);
INSERT INTO `categoriaTrabajo`(`idCategoriaTrabajo`, `nombreCategoriaTrabajo`,`descripcionCategoriaTrabajo`,`imagenCategoriaTrabajo`) VALUES (10,'Otro','Otro',NULL);




INSERT INTO `usuario` (`idUsuario`, `nombreUsuario`, `mailUsuario`, `email_verified_at`, `auth_key`, `claveUsuario`, `idRol`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'juan88', 'juan88@gmail.com', NULL, NULL, '$2y$10$/E8BV4bHWNJ5dRuiT.VzduKyk4b3wFmhqI9lCDSDyRQUwllpb6q1q', 2, NULL, '2019-09-23 00:36:43', '2019-09-23 00:36:43'),
(2, 'Maria', 'marianqn@hotmail.com', NULL, NULL, '$2y$10$.zzZfhyCD0fccwS3al9yge.N/RcMlVevmcxuEXFu285I0MeuREFdy', 2, NULL, '2019-09-23 00:39:18', '2019-09-23 00:39:18'),
(3, 'sofi89', 'sofia_love@yahoo.com', NULL, NULL, '$2y$10$wJYQxiIoDss0pMwOVGa9remm7eAthTg8dt6RkaduQLuTrK7jxH9US', 2, NULL, '2019-09-23 00:40:50', '2019-09-23 00:40:50'),
(4, 'MarceloQ', 'marceloqa@gmail.com', NULL, NULL, '$2y$10$QGmABaoc/uDVF310J2Xyiujfs60tZcWL3.suK0xgl0UtIX5w4yPdm', 2, NULL, '2019-09-23 00:41:52', '2019-09-23 00:41:52'),
(5, 'emiElMasCopado', 'emiliano896325@hotmail.com', NULL, NULL, '$2y$10$tLBIpow2heq/GtQzYpeH3.N8jmtJzEJwFt0peulIlwZ5eX5M.SKs2', 2, NULL, '2019-09-23 00:44:18', '2019-09-23 00:44:18'),
(6, 'elpana', 'elpana@gmail.com', NULL, NULL, '$2y$10$oWPaukdqz42rriPArLqYhuk4Hr.m.yuAEH55kniQtUo.vVb6hfNFu', 2, NULL, '2019-09-23 00:57:22', '2019-09-23 00:57:22');


INSERT INTO `persona` (`idPersona`, `nombrePersona`, `apellidoPersona`, `dniPersona`, `telefonoPersona`, `idUsuario`, `idLocalidad`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 'Juan', 'Sanchez', '89576214', '2995049638', 1, 4634, 0, '2019-09-23 00:37:12', '2019-09-23 00:37:12'),
(2, 'Maria Jose', 'Perez', '46325896', '02995698835', 2, 4634, 0, '2019-09-23 00:39:52', '2019-09-23 00:39:52'),
(3, 'Sofia', 'Galletas', '45698746', '2991365289', 3, 4634, 0, '2019-09-23 00:41:13', '2019-09-23 00:41:13'),
(4, 'Marcelo Antonio', 'Quintana', '43589633', '2994896324', 4, 4634, 0, '2019-09-23 00:42:34', '2019-09-23 00:42:34'),
(5, 'Emiliano', 'Gonzales', '46987456', '2991365852', 5, 2968, 0, '2019-09-23 00:45:11', '2019-09-23 00:45:11'),
(6, 'Federico', 'de Girasol', '46986325', '2998963258', 6, 4634, 0, '2019-09-23 00:58:03', '2019-09-23 00:58:03');

INSERT INTO `trabajo` (`idTrabajo`, `idPersona`, `idEstado`, `idCategoriaTrabajo`,`idLocalidad` ,`titulo`, `descripcion`, `monto`, `imagenTrabajo` ,`eliminado`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 4634,'Lavar a Flopy', 'Alguien que pueda llevar a mi perrita al petshop MiPerrito', 600.00, NULL ,0, '2019-09-23 00:47:02', '2019-09-23 00:47:02'),
(2, 5, 1, 2, 4634,'Quien me lava mi auto ????', 'Alguien que me lave el auto que no tengo ganas xD', 300.00, NULL,0, '2019-09-23 00:48:40', '2019-09-23 00:48:40'),
(3, 1, 1, 2, 4634,'Recital de pablo londra', 'quien puede hacer la fila por mi el dia del recital', 150.00, NULL,0, '2019-09-23 00:51:06', '2019-09-23 00:51:06'),
(4, 4, 1, 2, 4634,'cortar el cesped', 'tengo que cortar el cesped antes del finde. si queda bien lo llamo la proxima vez y recomiendo. pongo 5 estrellas', 560.00, NULL,0, '2019-09-23 00:55:10', '2019-09-23 00:55:10'),
(5, 4, 1, 2, 4634,'armar la pelopincho', 'alguien para armar la pile porfa. me operaron y no puedo hacer fuerza. gracias', 360.00, NULL,0, '2019-09-23 00:56:35', '2019-09-23 00:56:35'),
(6, 6, 1, 1, 4634,'pasear el perro', 'quien lo puede pasear a mi perro. es por el lunes a la tarde', 240.00, NULL, 0, '2019-09-23 01:01:51', '2019-09-23 01:01:51');

INSERT INTO `habilidad`(`idHabilidad`, `nombreHabilidad`,`descripcionHabilidad`,`imagenHabilidad`,`eliminado`) VALUES 
(1,'Habilidad 1','Descripcion habilidad 1',NULL,0),
(2,'Habilidad 2','Descripcion habilidad 1',NULL,0),
(3,'Habilidad 3','Descripcion habilidad 1',NULL,0);

INSERT INTO `preferenciapersona`(`idPreferenciaPersona`, `idCategoriaTrabajo`,`idPersona`,`eliminado`) VALUES 
(1,1,1,0),
(2,2,2,0),
(3,3,3,0);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_07_29_171118_create_chatter_categories_table', 1),
(4, '2016_07_29_171118_create_chatter_discussion_table', 1),
(5, '2016_07_29_171118_create_chatter_post_table', 1),
(6, '2016_07_29_171128_create_foreign_keys', 1),
(7, '2016_08_02_183143_add_slug_field_for_discussions', 1),
(8, '2016_08_03_121747_add_color_row_to_chatter_discussions', 1),
(9, '2017_01_16_121747_add_markdown_and_lock_to_chatter_posts', 1),
(10, '2017_01_16_121747_create_chatter_user_discussion_pivot_table', 1),
(11, '2017_08_07_165345_add_chatter_soft_deletes', 1),
(12, '2017_10_10_221227_add_chatter_last_reply_at_discussion', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Tony Lea', 'tony@hello.com', NULL, '$2y$10$9ED4Exe2raEeaeOzk.EW6uMBKn3Ib5Q.7kABWaf4QHagOgYHU8ca.', 'RvlORzs8dyG8IYqssJGcuOY2F0vnjBy2PnHHTX2MoV7Hh6udjJd6hcTox3un', '2016-07-29 18:13:02', '2016-08-18 17:33:50'),
(2, 'Prueba', 'prueba@prueba.com', NULL, '$2y$10$F71IvjID7.YsPkWiO0I0D.47EcArgL9xXszfVeF/n5fY7lV.VpXZW', NULL, '2019-09-09 19:58:27', '2019-09-09 19:58:27');

--
-- Índices para tablas volcadas
--


--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--
