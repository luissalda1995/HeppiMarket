-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2015 a las 21:20:05
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tiendarigobertouran`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
`idcategorias` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estada` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idcategorias`, `nombre`, `estada`) VALUES
(1, 'Accesorios', 1),
(2, 'Hombres', 1),
(3, 'Mujeres', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriaxidioma`
--

CREATE TABLE IF NOT EXISTS `categoriaxidioma` (
`idcategoriaxidioma` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `categoria` int(11) NOT NULL,
  `idioma` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `categoriaxidioma`
--

INSERT INTO `categoriaxidioma` (`idcategoriaxidioma`, `nombre`, `categoria`, `idioma`) VALUES
(1, 'Accessories', 1, 'en'),
(2, 'Accessori', 1, 'it'),
(3, 'Accesorios', 1, 'es'),
(4, 'Hombres', 2, 'es'),
(5, 'Men', 2, 'en'),
(6, 'Maschi', 2, 'it'),
(7, 'Donne', 3, 'it'),
(8, 'Mujeres', 3, 'es'),
(9, 'Womans', 3, 'en');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriaxproducto`
--

CREATE TABLE IF NOT EXISTS `categoriaxproducto` (
`idcategoriaxproducto` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `categoriaxproducto`
--

INSERT INTO `categoriaxproducto` (`idcategoriaxproducto`, `idproducto`, `categoria`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientescompra`
--

CREATE TABLE IF NOT EXISTS `clientescompra` (
`idclientescompra` int(11) NOT NULL,
  `cedulacliente` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombrecliente` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mailcliente` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonocliente` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccionentrega` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `celular` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ciudad` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `departamento` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pais` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipodocumento` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `usuarologuin` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contrasena` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE IF NOT EXISTS `color` (
`idcolor` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`idcolor`, `nombre`) VALUES
(1, 'Azul'),
(2, 'Único');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colorexidioma`
--

CREATE TABLE IF NOT EXISTS `colorexidioma` (
`idcolorexidioma` int(11) NOT NULL,
  `nombreidioma` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `color` int(11) NOT NULL,
  `idioma` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `colorexidioma`
--

INSERT INTO `colorexidioma` (`idcolorexidioma`, `nombreidioma`, `color`, `idioma`) VALUES
(10, 'Azul', 1, 'es'),
(11, 'Blue', 1, 'en'),
(12, 'Blu', 1, 'it'),
(13, 'Único', 2, 'es'),
(14, 'Singolo', 2, 'it'),
(15, 'Single', 2, 'en');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracionslider`
--

CREATE TABLE IF NOT EXISTS `configuracionslider` (
`idconfiguracionslider` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `animacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `alto` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ancho` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `reproduccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `control` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `navegacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `configuracionslider`
--

INSERT INTO `configuracionslider` (`idconfiguracionslider`, `nombre`, `animacion`, `alto`, `ancho`, `reproduccion`, `control`, `navegacion`) VALUES
(1, 'main', 'fade', '0', '0', '5000', 'true', 'true');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallexproducto`
--

CREATE TABLE IF NOT EXISTS `detallexproducto` (
`iddetallexproducto` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci,
  `idioma` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `detallexproducto`
--

INSERT INTO `detallexproducto` (`iddetallexproducto`, `nombre`, `descripcion`, `idioma`, `idproducto`) VALUES
(1, 'Camiseta Manga Corta', 'Revolucionaria, nuestra nueva camiseta PRO es el fruto de varios años de investigación y testeo con los más importantes equipos profesionales de nuestro país, posee materiales más livianos que permiten mejorar el performance del ciclista, su peso es 30% menor a una camiseta estándar; todo esto sin dejar de lado la seguridad y el confort del ciclista. Fabricada con cintareflectiva 3M y elásticos siliconados que se adhieren a las prendas inferiores para mejorar el confort. Además del acabado UPF que protege del 50% de los rayos UV.', 'es', 1),
(2, 'Maniche Corte', 'Rivoluzionario, il nostro nuovo T PRO è il risultato di diversi anni di ricerca e sperimentazione con i principali squadre professionali del nostro paese, ha materiali più leggeri che consentono di migliorare le prestazioni del pilota, il suo peso è del 30% inferiore a una camicia di serie; tutto questo senza lasciare la sicurezza e il comfort del pilota. Realizzato con 3M cintareflectiva e silicone elastico che aderiscono ad abbassare indumenti per migliorare il comfort. Oltre finitura UPF che protegge il 50% dei raggi UV.', 'it', 1),
(3, 'Short-Sleeve', 'Revolutionary, our new T PRO is the result of several years of research and testing with major professional teams of our country, has lighter materials that improve the performance of the rider, his weight is 30% less than a standard shirt; all this without leaving the safety and comfort of the rider. Made with 3M cintareflectiva and elastic silicone that adhere to lower garments to improve comfort. Besides UPF finish that protects 50% of UV rays.', 'en', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `home-text`
--

CREATE TABLE IF NOT EXISTS `home-text` (
  `idhome-text` int(11) NOT NULL,
  `home-textcol` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idioma`
--

CREATE TABLE IF NOT EXISTS `idioma` (
  `ididioma` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `abrevitura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `orden` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `idioma`
--

INSERT INTO `idioma` (`ididioma`, `nombre`, `abrevitura`, `estado`, `orden`) VALUES
(2, 'English', 'en', '1', 'b'),
(1, 'Spanish', 'es', '1', 'a'),
(3, 'Italy', 'it', '1', 'c');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE IF NOT EXISTS `inventario` (
`idinventerio` int(11) NOT NULL,
  `cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idtalla` int(11) NOT NULL,
  `idcolor` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `sexo` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`idinventerio`, `cantidad`, `idtalla`, `idcolor`, `idproducto`, `sexo`) VALUES
(1, '0', 1, 2, 1, 3),
(2, '1', 2, 2, 1, 1),
(3, '2', 3, 1, 1, 3),
(4, '2', 3, 2, 1, 3),
(5, '3', 4, 1, 1, 3),
(6, '0', 17, 2, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemslider`
--

CREATE TABLE IF NOT EXISTS `itemslider` (
`idsliderMain` int(11) NOT NULL,
  `img` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `seo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `idioma` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `slider` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `itemslider`
--

INSERT INTO `itemslider` (`idsliderMain`, `img`, `seo`, `titulo`, `estado`, `idioma`, `slider`) VALUES
(1, 'rigobeto-uran-giro.jpg', 'gorigogo', 'rigobeto-uran-giro', 1, 'es', 1),
(5, 'rigobeto-uran-giro.jpg', 'vamoze', 'rigobeto-uran-giro', 1, 'it', 1),
(6, 'rigobeto-uran-giro.jpg', 'vamos', 'rigobeto-uran-giro', 1, 'en', 1),
(7, 'affinity.jpeg', 'affinity', 'affinity', 1, 'es', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `idmenu` int(11) NOT NULL,
  `nombreitem` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `idioma_abrevitura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `orden` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmenu`, `nombreitem`, `url`, `estado`, `idioma_abrevitura`, `orden`) VALUES
(0, 'Contact', 'contacto', 1, 'en', 'f'),
(0, 'Contáctame', 'contacto', 1, 'es', 'f'),
(0, 'Contatto', 'contacto', 1, 'it', 'f'),
(1, 'Home', 'home', 1, 'en', 'a'),
(2, 'Inicio', 'home', 1, 'es', 'a'),
(3, 'iniziazione', 'home', 1, 'it', 'a'),
(4, 'About me', 'profile', 1, 'en', 'e'),
(5, 'Acerca de mi', 'profile', 1, 'es', 'e'),
(6, 'Su di me', 'profile', 1, 'it', 'e'),
(7, 'News', 'news', 1, 'en', 'd'),
(8, 'Noticias', 'news', 1, 'es', 'd'),
(9, 'Notizie', 'news', 1, 'it', 'd'),
(10, 'Social work', 'social', 1, 'en', 'c'),
(11, 'Labor social', 'social', 1, 'es', 'c'),
(12, 'Lavoro sociale', 'social', 1, 'it', 'c'),
(13, 'Shop', 'shop', 1, 'en', 'b'),
(14, 'Tienda', 'shop', 1, 'es', 'b'),
(15, 'Negozio', 'shop', 1, 'it', 'c');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prensa`
--

CREATE TABLE IF NOT EXISTS `prensa` (
  `idprensa` int(11) NOT NULL,
  `imgprensa` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `titulprensa` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tagg` text COLLATE utf8_spanish_ci,
  `fecha` date DEFAULT NULL,
  `contenido` text COLLATE utf8_spanish_ci,
  `estado` int(11) DEFAULT NULL,
  `idioma` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `orden` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prensa`
--

INSERT INTO `prensa` (`idprensa`, `imgprensa`, `titulprensa`, `tagg`, `fecha`, `contenido`, `estado`, `idioma`, `orden`) VALUES
(1, 'Rigo201501-681x1024.jpg', '“Vamos por buen camino” Rigoberto Urán', ' 2013 , 2014 , catalunya , ciclismo , ciclismo colombiano , ciclista , ciclista colombiano , colombia , colombianos , europa , Giro , Giro de Italia , Italia , Papel , quick step , quintana , Rigoberto , Romandía , Tirreno , Tour , tour de francia , Tour de Romandía , Volta a Catalunya', '2015-04-02', 'El doble subcampeón del Giro de Italia regresa a Colombia, pensando en el Giro de Italia.\n\nRigoberto Urán (Etixx-Quick Step) ha finalizado quinto la Volta a Catalunya, a 18” del vencedor final Richie Porte (Team Sky), después de ser séptimo en la última etapa en Barcelona. El ciclista colombiano regresa ahora a su país para preparar el Giro de Italia y antes disputará el Tour de Romandía.\n\nUrán hacía un balance positivo, pese a quedarse con la miel en los labios, segundo, en Girona y Valls: “Yo creo que se ha trabajado bastante bien, aunque uno siempre quiere estar delante en estas carreras cuando está en forma. Al final quedamos fuera del podio, pero es un puesto muy importante respecto al año pasado –fue 30º-. Yo creo que vamos por el bueno camino. Hay que seguir trabajando.\n\nAhora seguirá esa preparación en Colombia: “Estas carreras te dan un nivel porque se va rápido y ahora hay que descansar. En Colombia trabajaré con la bici de contrarreloj y también en la montaña, como siempre”.\n\nEl corredor del Etixx fue el primer colombiano en la General, quinto, con Atapuma séptimo y Pantano undécimo: “Fue una gran representación. Todos los colombianos hicimos un gran papel y eso demuestra que sigue creciendo el ciclismo colombiano”.\n\nEste 2015, Urán ganó el Campeonato de Colombia contrarreloj y fue cuarto en la prueba en línea. En Europa debutó en las clásicas francesas Sud Ardèche (58º) y La Drome (55º) y ya mostró su buen estado de forma en la Strade Bianche (7º). Su primer podio lo alcanzó en la Tirreno-Adriático, tercero en la General, por detrás de Quintana y Mollema, después de ser segundo en Castelraimondo y cuarto en el Terminillo. En la Volta, ha sumado dos segundos puestos más y el quinto puesto final.\n\nEl Giro es su gran objetivo de la temporada, después de ser segundo en 2013 y 2014, y a continuación tiene previsto correr igualmente el Tour de Francia', 1, 'es', NULL),
(2, 'Rigo201501-681x1024.jpg', '"We are on track," Rigoberto Uran', ' 2013 , 2014 , catalunya , ciclismo , ciclismo colombiano , ciclista , ciclista colombiano , colombia , colombianos , europa , Giro , Giro de Italia , Italia , Papel , quick step , quintana , Rigoberto , Romandía , Tirreno , Tour , tour de francia , Tour de Romandía , Volta a Catalunya', '2015-04-02', 'Twice Giro d''Italia runner returns to Colombia, thinking of the Giro d''Italia. Rigoberto Uran (Etixx-Quick Step) finished fifth the Volta a Catalunya, 18 "the final winner Richie Porte (Team Sky), after being seventh in the last stage in Barcelona. The Colombian rider now returns home to prepare for the Giro d''Italia and held before the Tour de Romandie. Uran was a positive balance, despite staying with honey on the lips, second, in Girona and Valls: "I think it has worked pretty well, but you always want to be ahead in these races when in form. At the end we were off the podium, but it is a very important position compared to last year ''was 30º-. I think we are on the good way. Further work. Now continue this preparation in Colombia: "These races give you a level because it goes fast and now we must rest. In Colombia I will work with trial bike and also in the mountains, as usual. " Etixx racer was the first Colombian to the General, fifth, seventh and Pantano with Atapuma eleventh: "It was a great performance. All Colombians did a great role and it shows that the Colombian cycling continues to grow. " This 2015 Uran of Colombia won the Championship time trial and was fourth in the online test. Debuted in Europe in the French classic Sud Ardèche (58th) and La Drome (55) and already showed his good form in the Strade Bianche (7th). He reached his first podium in the Tirreno-Adriatico, third overall, behind Mollema Quintana and, after being second in Castelraimondo and fourth in the Terminillo. In the Volta, he has added two seconds and placed fifth place finish. The Giro is his big goal of the season after being second in 2013 and 2014, and also plans to ride the Tour de France', 1, 'en', NULL),
(3, 'Rigoberto-Uran.jpg', 'Rigoberto Urán: “Sigo con el mismo objetivo de ganar la Volta a Catalunya”', 'Tagged with: catalunya , ciclista , colombia , Colombiano Rigoberto Urán , equipo , Giro , Giro de Italia , Italia , lucha , quick step , Rigoberto , Volta a Catalunya', '2015-05-02', 'ventaja de 2 minutos y 50 segundos que los tres primeros de la general mantienen con el pelotón, el colombiano Rigoberto Urán (Ettix-Quick Step) mantiene sus esperanzas en la lucha por la Volta a Catalunya al señalar que el maillot de líder sigue siendo su objetivo.\n\nAntes de la disputa de la tercera etapa con inicio y final en Girona -“un día importante”, ha dicho-, Urán ha asegurado que llega con buenas sensaciones y ha apuntado que “hay que esperar” a la cuarta jornada de montaña con la ascensión a la estación de esquí de La Molina para conocer el máximo candidato para llevarse el triunfo.\n\n“Hoy puede ser un día importante, hay un puerto a pocos kilómetros de meta y puede ser importante, pero mañana va a ser un día más importante y se va a definir todo”, ha augurado.\n\nDespués de culminar una larga escapada en la jornada inaugural, la Volta a Catalunya está liderada por el polaco Maciej Paterski (CCC), seguido de cerca por el francés Pierre Rolland (Europcar) y el belga Bart De Clercq (Lotto Soudal), que mantienen una cómoda ventaja con los notables del pelotón.\n\n“No pensaba estar a tres minutos de los primeros, pero es así. Son corredores que están bien y cuando se agarran es muy duro soltarles”, ha opinado.\n\nEn este sentido, Urán señala que el ciclista galo de Europcar es el que lo tiene mejor para llevarse la ronda catalana, ya que se trata de un corredor completo.\n\n“Hay una desventaja de casi tres minutos con Pierre Rolland, que es un corredor que se defiende bastante bien, pero creo que hay que esperar hasta la etapa de La Molina”, ha puntualizado.\n\nSin embargo, el líder de filas del Ettix-Quick Step se ha mostrado optimista con vistas a luchar por la victoria final: “Se ha corrido bien, tenemos el equipo en buen estado y seguimos con el mismo objetivo de ganar la Volta”.\n\nPreguntado por el Giro de Italia, uno de los objetivos la temporada, prefiere Urán centrarse en la ronda catalana antes de pensar en una de las grandes carreras del circuito.\n\n“El Giro lo tengo apartado. El objetivo es estar adelante y la Volta no es una preparación para el Giro. Quiero hacerlo bien, tengo una buena condición y en Cataluña lo estamos ajustando todo para estar adelante”, ha concluido.', 1, 'es', NULL),
(4, 'Rigoberto-Uran.jpg', 'Rigoberto Uran: "I continue with the same goal of winning the Volta a Catalunya"', 'Tagged with: catalunya , ciclista , colombia , Colombiano Rigoberto Urán , equipo , Giro , Giro de Italia , Italia , lucha , quick step , Rigoberto , Volta a Catalunya', '2015-05-02', 'lead with 2 minutes 50 seconds to the first three overall remain with the pack, the Colombian Rigoberto Uran (Ettix-Quick Step) kept their hopes in the struggle for the Volta a Catalunya noting that the leader''s jersey is still his objective.\n\nBefore the dispute of the third stage with start and finish in Girona - "an important day," he said-, Uran has assured that comes with good feelings and pointed out that "we must wait" for the fourth day of mountain with ascent to the ski resort of La Molina to know the top candidate for the win.\n\n"Today could be an important day, there is a port a few kilometers from the finish and can be important, but tomorrow will be a most important day and it will define everything," he predicted.\n\nAfter completing a long break on the opening day, the Volta a Catalunya is led by the Polish Maciej Paterski (CCC), followed closely by Frenchman Pierre Rolland (Europcar) and Belgian Bart De Clercq (Lotto Soudal), which maintain a comfortable lead with notable squad.\n\n"No I thought to be three minutes of the first, but it is. Are riders who are good and when they turn them loose grip is very hard, "he opined.\n\nIn this sense, Uran said that the French cyclist Europcar is the one that is best to take the Catalan round because it is a complete rider.\n\n"There is a disadvantage of about three minutes with Pierre Rolland, a broker who defended pretty well, but I think we should wait until the stage of La Molina," he pointed out.\n\nHowever, the leading ranks of Ettix-Quick Step is optimistic in order to fight for the final victory: "He has run well, we have the equipment in good condition and still with the same goal of winning the Tour."\n\nAsked about the Giro d''Italia, one of the goals the season Uran prefer to focus on the Catalan round before considering a major racing circuit.\n\n"I got the Giro section. The goal is to be ahead and Volta is not a preparation for the Giro. I want to do well, I have a good condition and in Catalonia we are adjusting everything to be going, "he concluded.', 1, 'en', NULL),
(5, 'Rigoberto-Uran.jpg', 'Rigoberto Uran: "Continuo con lo stesso obiettivo di vincere la Volta a Catalunya"', 'Tagged with: catalunya , ciclista , colombia , Colombiano Rigoberto Urán , equipo , Giro , Giro de Italia , Italia , lucha , quick step , Rigoberto , Volta a Catalunya', '2015-05-02', 'portare con 2 minuti e 50 secondi per i primi tre nel complesso rimangono con lo zaino, il colombiano Rigoberto Uran (Step Ettix-Quick) mantenuto le loro speranze nella lotta per la Volta a Catalunya notando che la maglia di leader è ancora la sua Obiettivo.\n\nPrima della disputa della terza tappa con partenza e arrivo a Girona - "un giorno importante", ha detto-, Uran ha assicurato che viene fornito con buoni sentimenti e ha sottolineato che "dobbiamo aspettare" per il quarto giorno di montagna con salita alla stazione sciistica di La Molina per conoscere il primo candidato per la vittoria.\n\n"Oggi potrebbe essere un giorno importante, c''è un porto a pochi chilometri dal traguardo e può essere importante, ma domani sarà un giorno più importante e sarà definire tutto", ha predetto.\n\nDopo aver completato una lunga pausa nel giorno di apertura, la Volta a Catalunya è guidata dal polacco Maciej Paterski (CCC), seguito a ruota dal francese Pierre Rolland (Europcar) e il belga Bart De Clercq (Lotto Soudal), che mantengono un comodo vantaggio di squadra notevole.\n\n"No ho pensato di tre minuti del primo, ma è così. Sono i piloti che sono bravi e quando li trasformano presa sciolto è molto difficile ", ha opinato.\n\nIn questo senso, Uran ha detto che il ciclista francese Europcar è quella che è meglio prendere il turno catalana, perché è un pilota completo.\n\n"C''è uno svantaggio di circa tre minuti con Pierre Rolland, un broker che ha difeso abbastanza bene, ma penso che dovremmo aspettare fino a quando la fase di La Molina,", ha sottolineato.\n\nTuttavia, le fila principali del Passo Ettix-Quick è ottimista per lottare per la vittoria finale: "Ha gestito bene, abbiamo le attrezzature in buone condizioni e ancora con lo stesso obiettivo di vincere il Tour."\n\nAlla domanda circa il Giro d''Italia, uno degli obiettivi della stagione Uran preferiscono concentrarsi sul turno catalana prima di considerare un importante circuito di corsa.\n\n"Ho avuto la sezione Giro. L''obiettivo è quello di essere avanti e Volta non è una preparazione per il Giro. Io voglio fare bene, ho una buona condizione e in Catalogna stiamo regolando tutto per essere in corso ", ha concluso.\n\nFonte: plazadeportiva.com', 1, 'it', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
`idproductos` int(11) NOT NULL,
  `nombrem` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imguno` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imgdos` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imgtres` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imgcuatro` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valoruno` float DEFAULT NULL,
  `valordos` float DEFAULT NULL,
  `seo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ref` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproductos`, `nombrem`, `estado`, `imguno`, `imgdos`, `imgtres`, `imgcuatro`, `valoruno`, `valordos`, `seo`, `orden`, `ref`) VALUES
(1, 'Rigo Pro Bélgica', '1', 'Rigo-Pro-Belgica.jpg', 'URCEE004-11.jpg', 'URCEE004-31.jpg', NULL, 150000, 300000, 'Camisas, Rigoberto Urán', NULL, '2015rupb01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE IF NOT EXISTS `recursos` (
`idrecursos` int(11) NOT NULL,
  `file` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `claserecurso` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`idrecursos`, `file`, `tipo`, `estado`, `claserecurso`, `orden`) VALUES
(1, 'main', 'css', '1', 'main', 'b'),
(2, 'main', 'js', '1', 'main', 'b'),
(3, 'jquery.min', 'js', '1', 'main', 'a'),
(4, 'jquery.easing.1.3', 'js', '1', 'slider', 'c'),
(5, 'jquery.animate-enhanced.min', 'js', '1', 'slider', 'c'),
(6, 'jquery.superslides', 'js', '1', 'slider', 'c'),
(8, 'superslides', 'css', '1', 'main', 'b'),
(9, 'libreriaFunciones', 'js', '1', 'main', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redessociales`
--

CREATE TABLE IF NOT EXISTS `redessociales` (
  `idredessociales` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `redessociales`
--

INSERT INTO `redessociales` (`idredessociales`, `nombre`, `url`, `estado`, `orden`) VALUES
(1, 'facebook', 'https://www.facebook.com/FansRigobertoUran', 1, NULL),
(2, 'twitter', 'https://twitter.com/UranRigoberto', 1, NULL),
(3, 'plus', 'https://plus.google.com/u/0/+Rigobertouranoficial/posts', 1, NULL),
(4, 'instagram', '#', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE IF NOT EXISTS `sexo` (
`idSexo` int(11) NOT NULL,
  `sexo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`idSexo`, `sexo`, `estado`) VALUES
(1, 'Hombre', '1'),
(2, 'Mujer', '1'),
(3, 'Ambos', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
`idslider` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `configuracion` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `slider`
--

INSERT INTO `slider` (`idslider`, `nombre`, `configuracion`) VALUES
(1, 'main', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE IF NOT EXISTS `tallas` (
`idtallas` int(11) NOT NULL,
  `nombre` varchar(5) COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`idtallas`, `nombre`, `orden`) VALUES
(1, 'S', 'b'),
(2, 'M', 'c'),
(3, 'L', 'd'),
(4, 'XL', 'e'),
(5, '35', NULL),
(6, '36', NULL),
(7, '37', NULL),
(8, '38', NULL),
(9, '39', NULL),
(10, '40', NULL),
(11, '41', NULL),
(12, '42', NULL),
(13, '43', NULL),
(14, '44', NULL),
(15, '45', NULL),
(16, 'Única', NULL),
(17, 'XS', 'a'),
(18, '2XL', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE IF NOT EXISTS `tipodocumento` (
  `idtipodocumento` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
 ADD PRIMARY KEY (`idcategorias`);

--
-- Indices de la tabla `categoriaxidioma`
--
ALTER TABLE `categoriaxidioma`
 ADD PRIMARY KEY (`idcategoriaxidioma`), ADD KEY `fk_categoriaxidioma_categorias1_idx` (`categoria`), ADD KEY `fk_categoriaxidioma_idioma1_idx` (`idioma`);

--
-- Indices de la tabla `categoriaxproducto`
--
ALTER TABLE `categoriaxproducto`
 ADD PRIMARY KEY (`idcategoriaxproducto`), ADD KEY `fk_categoriaxproducto_productos1_idx` (`idproducto`), ADD KEY `fk_categoriaxproducto_categorias1_idx` (`categoria`);

--
-- Indices de la tabla `clientescompra`
--
ALTER TABLE `clientescompra`
 ADD PRIMARY KEY (`idclientescompra`), ADD KEY `fk_clientescompra_tipodocumento1_idx` (`tipodocumento`);

--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
 ADD PRIMARY KEY (`idcolor`);

--
-- Indices de la tabla `colorexidioma`
--
ALTER TABLE `colorexidioma`
 ADD PRIMARY KEY (`idcolorexidioma`), ADD KEY `fk_colorexidioma_color1_idx` (`color`), ADD KEY `fk_colorexidioma_idioma1_idx` (`idioma`);

--
-- Indices de la tabla `configuracionslider`
--
ALTER TABLE `configuracionslider`
 ADD PRIMARY KEY (`idconfiguracionslider`);

--
-- Indices de la tabla `detallexproducto`
--
ALTER TABLE `detallexproducto`
 ADD PRIMARY KEY (`iddetallexproducto`), ADD KEY `fk_detallexproducto_idioma1_idx` (`idioma`), ADD KEY `fk_detallexproducto_productos1_idx` (`idproducto`);

--
-- Indices de la tabla `home-text`
--
ALTER TABLE `home-text`
 ADD PRIMARY KEY (`idhome-text`);

--
-- Indices de la tabla `idioma`
--
ALTER TABLE `idioma`
 ADD PRIMARY KEY (`abrevitura`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
 ADD PRIMARY KEY (`idinventerio`), ADD KEY `fk_inventerio_tallas1_idx` (`idtalla`), ADD KEY `fk_inventerio_color1_idx` (`idcolor`), ADD KEY `fk_inventario_productos1_idx` (`idproducto`), ADD KEY `fk_inventario_Sexo1_idx` (`sexo`);

--
-- Indices de la tabla `itemslider`
--
ALTER TABLE `itemslider`
 ADD PRIMARY KEY (`idsliderMain`), ADD KEY `fk_itemslider_idioma1_idx` (`idioma`), ADD KEY `fk_itemslider_slider1_idx` (`slider`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`idmenu`,`idioma_abrevitura`), ADD KEY `fk_menu_idioma_idx` (`idioma_abrevitura`);

--
-- Indices de la tabla `prensa`
--
ALTER TABLE `prensa`
 ADD PRIMARY KEY (`idprensa`,`idioma`), ADD KEY `fk_prensa_idioma1_idx` (`idioma`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
 ADD PRIMARY KEY (`idproductos`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
 ADD PRIMARY KEY (`idrecursos`);

--
-- Indices de la tabla `redessociales`
--
ALTER TABLE `redessociales`
 ADD PRIMARY KEY (`idredessociales`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
 ADD PRIMARY KEY (`idSexo`);

--
-- Indices de la tabla `slider`
--
ALTER TABLE `slider`
 ADD PRIMARY KEY (`idslider`), ADD KEY `fk_slider_configuracionslider1_idx` (`configuracion`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
 ADD PRIMARY KEY (`idtallas`);

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
 ADD PRIMARY KEY (`idtipodocumento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
MODIFY `idcategorias` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `categoriaxidioma`
--
ALTER TABLE `categoriaxidioma`
MODIFY `idcategoriaxidioma` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `categoriaxproducto`
--
ALTER TABLE `categoriaxproducto`
MODIFY `idcategoriaxproducto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `clientescompra`
--
ALTER TABLE `clientescompra`
MODIFY `idclientescompra` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `color`
--
ALTER TABLE `color`
MODIFY `idcolor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `colorexidioma`
--
ALTER TABLE `colorexidioma`
MODIFY `idcolorexidioma` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `configuracionslider`
--
ALTER TABLE `configuracionslider`
MODIFY `idconfiguracionslider` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `detallexproducto`
--
ALTER TABLE `detallexproducto`
MODIFY `iddetallexproducto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
MODIFY `idinventerio` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `itemslider`
--
ALTER TABLE `itemslider`
MODIFY `idsliderMain` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
MODIFY `idproductos` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
MODIFY `idrecursos` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
MODIFY `idSexo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `slider`
--
ALTER TABLE `slider`
MODIFY `idslider` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
MODIFY `idtallas` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoriaxidioma`
--
ALTER TABLE `categoriaxidioma`
ADD CONSTRAINT `fk_categoriaxidioma_categorias1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`idcategorias`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_categoriaxidioma_idioma1` FOREIGN KEY (`idioma`) REFERENCES `idioma` (`abrevitura`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `categoriaxproducto`
--
ALTER TABLE `categoriaxproducto`
ADD CONSTRAINT `fk_categoriaxproducto_categorias1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`idcategorias`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_categoriaxproducto_productos1` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproductos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `clientescompra`
--
ALTER TABLE `clientescompra`
ADD CONSTRAINT `fk_clientescompra_tipodocumento1` FOREIGN KEY (`tipodocumento`) REFERENCES `tipodocumento` (`idtipodocumento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `colorexidioma`
--
ALTER TABLE `colorexidioma`
ADD CONSTRAINT `fk_colorexidioma_color1` FOREIGN KEY (`color`) REFERENCES `color` (`idcolor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_colorexidioma_idioma1` FOREIGN KEY (`idioma`) REFERENCES `idioma` (`abrevitura`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detallexproducto`
--
ALTER TABLE `detallexproducto`
ADD CONSTRAINT `fk_detallexproducto_idioma1` FOREIGN KEY (`idioma`) REFERENCES `idioma` (`abrevitura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_detallexproducto_productos1` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproductos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
ADD CONSTRAINT `fk_inventario_Sexo1` FOREIGN KEY (`sexo`) REFERENCES `sexo` (`idSexo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_inventario_productos1` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproductos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_inventerio_color1` FOREIGN KEY (`idcolor`) REFERENCES `color` (`idcolor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_inventerio_tallas1` FOREIGN KEY (`idtalla`) REFERENCES `tallas` (`idtallas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `itemslider`
--
ALTER TABLE `itemslider`
ADD CONSTRAINT `fk_itemslider_idioma1` FOREIGN KEY (`idioma`) REFERENCES `idioma` (`abrevitura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_itemslider_slider1` FOREIGN KEY (`slider`) REFERENCES `slider` (`idslider`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
ADD CONSTRAINT `fk_menu_idioma` FOREIGN KEY (`idioma_abrevitura`) REFERENCES `idioma` (`abrevitura`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `prensa`
--
ALTER TABLE `prensa`
ADD CONSTRAINT `fk_prensa_idioma1` FOREIGN KEY (`idioma`) REFERENCES `idioma` (`abrevitura`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `slider`
--
ALTER TABLE `slider`
ADD CONSTRAINT `fk_slider_configuracionslider1` FOREIGN KEY (`configuracion`) REFERENCES `configuracionslider` (`idconfiguracionslider`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
