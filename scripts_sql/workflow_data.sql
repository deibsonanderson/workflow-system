-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 07-Maio-2019 às 18:33
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `workflow`
--

--
-- Extraindo dados da tabela `tb_workflow_acao_usuario`
--

INSERT INTO `tb_workflow_acao_usuario` (`id`, `id_classe`, `id_usuario`, `perfil`, `status`) VALUES
(595, 33, 12, '0', 0),
(596, 39, 12, 'A', 1),
(597, 40, 12, 'B', 1),
(598, 41, 12, 'A', 1),
(599, 42, 12, 'C', 1),
(600, 43, 12, 'A', 1),
(601, 33, 13, '0', 0),
(602, 39, 13, 'A', 1),
(603, 40, 13, 'A', 1),
(604, 41, 13, 'A', 1),
(605, 42, 13, 'A', 1),
(606, 43, 13, 'A', 1),
(613, 33, 15, '0', 0),
(614, 39, 15, 'A', 1),
(615, 40, 15, 'A', 1),
(616, 41, 15, 'A', 1),
(617, 42, 15, '0', 1),
(618, 43, 15, '0', 1),
(619, 39, 14, 'A', 1),
(620, 40, 14, 'A', 1),
(621, 41, 14, 'A', 1),
(622, 44, 14, 'A', 1),
(623, 42, 14, 'A', 1),
(624, 43, 14, 'A', 1),
(625, 41, 1, 'A', 1),
(626, 44, 1, 'A', 1),
(627, 40, 1, 'A', 1),
(628, 39, 1, 'A', 1),
(629, 43, 1, 'A', 1),
(630, 42, 1, 'A', 1),
(631, 41, 11, 'A', 1),
(632, 44, 11, '0', 1),
(633, 40, 11, 'A', 1),
(634, 39, 11, 'A', 1),
(635, 43, 11, '0', 1),
(636, 42, 11, '0', 1);

--
-- Extraindo dados da tabela `tb_workflow_atividade`
--

INSERT INTO `tb_workflow_atividade` (`id`, `titulo`, `descricao`, `link`, `imagem`, `arquivo`, `valor`, `propriedade`, `id_categoria`, `status`, `id_usuario`) VALUES
(1, 'Atividade 1', 'Atividade 1', 'https://www.google.com/', 'thumbnailbg.png', '', 1.00, 0, 1, 1, 1),
(2, 'Atividade 2', 'Atividade 2', '', '', 'anexo.txt', 0.00, 1, 1, 1, 1);

--
-- Extraindo dados da tabela `tb_workflow_categoria_atividade`
--

INSERT INTO `tb_workflow_categoria_atividade` (`id`, `nome`, `status`, `id_usuario`) VALUES
(1, 'CATEGORIA PADRÃO', 1, 1);

--
-- Extraindo dados da tabela `tb_workflow_classe`
--

INSERT INTO `tb_workflow_classe` (`id`, `nome`, `id_perfil`, `controlador`, `funcao`, `secao`, `id_modulo`, `status`) VALUES
(33, 'Template', 2, 'ControladorTemplate', 'telaListarTemplate', 'Template', 8, 0),
(39, 'Atividade', 2, 'ControladorAtividade', 'telaListarAtividade', 'Atividade', 12, 1),
(40, 'Fluxo', 2, 'ControladorFluxo', 'telaListarFluxo', 'Fluxo', 12, 1),
(41, 'Processo', 2, 'ControladorProcesso', 'telaListarProcesso', 'Processo', 12, 1),
(42, 'Agenda', 2, 'ControladorAgenda', 'telaCadastrarAgenda', 'Agenda', 13, 1),
(43, 'Listar Agendas', 2, 'ControladorAgenda', 'telaListarAgenda', 'Agenda', 13, 1),
(44, 'Categoria Atividade', 2, 'controladorCategoriaAtividade', 'telaListarCategoriaAtividade', 'Categoria Atividade', 12, 1);

--
-- Extraindo dados da tabela `tb_workflow_fluxo`
--

INSERT INTO `tb_workflow_fluxo` (`id`, `id_atividade`, `id_titulo_fluxo`, `ordenacao`, `status`, `id_usuario`) VALUES
(1, 2, 1, 1, 1, 1),
(2, 1, 1, 2, 1, 1);

--
-- Extraindo dados da tabela `tb_workflow_login`
--

INSERT INTO `tb_workflow_login` (`id`, `id_usuario`, `data`, `status`) VALUES
(1, 1, '2019-05-07 14:13:59', 1);

--
-- Extraindo dados da tabela `tb_workflow_modulo`
--

INSERT INTO `tb_workflow_modulo` (`id`, `nome`, `status`) VALUES
(8, 'SITE', 1),
(12, 'FLUXO', 1),
(13, 'AGENDA', 1);

--
-- Extraindo dados da tabela `tb_workflow_pais`
--

INSERT INTO `tb_workflow_pais` (`id`, `nome`) VALUES
(1, 'Afeganistão'),
(2, 'Albânia'),
(3, 'Alemanha'),
(4, 'Andorra'),
(5, 'Angola'),
(6, 'Anguilla'),
(7, 'Antigua e Barbuda'),
(8, 'Antilhas Holandesas'),
(9, 'Antártica'),
(10, 'Argentina'),
(11, 'Argélia'),
(12, 'Armênia'),
(13, 'Aruba'),
(14, 'Arábia Saudita'),
(15, 'Austrália'),
(16, 'Azerbaijão'),
(17, 'Brasil'),
(18, 'Bahamas'),
(19, 'Bahrein'),
(20, 'Bangladesh'),
(21, 'Barbados'),
(22, 'Belarus'),
(23, 'Belize'),
(24, 'Benin'),
(25, 'Bermuda'),
(26, 'Bolívia'),
(27, 'Botsuana'),
(28, 'Brunei'),
(29, 'Bulgária'),
(30, 'Burkina Faso'),
(31, 'Burundi'),
(32, 'Butão'),
(33, 'Bélgica'),
(34, 'Bósnia e Herzegovina'),
(35, 'Cabo Verde'),
(36, 'Camarões'),
(37, 'Camboja'),
(38, 'Canadá'),
(39, 'Cazaquistão'),
(40, 'Chade'),
(41, 'Chile'),
(42, 'China'),
(43, 'Chipre'),
(44, 'Cingapura'),
(45, 'Colômbia'),
(46, 'Congo'),
(47, 'Costa Rica'),
(48, 'Costa do Marfim'),
(49, 'Croácia'),
(50, 'Cuba'),
(51, 'Dinamarca'),
(52, 'Djibuti'),
(53, 'Dominica'),
(54, 'Egito'),
(55, 'El Salvador'),
(56, 'Emirados Árabes Unidos'),
(57, 'Equador'),
(58, 'Eritréia'),
(59, 'Eslováquia'),
(60, 'Eslovênia'),
(61, 'Espanha'),
(62, 'Estados Unidos'),
(63, 'Estônia'),
(64, 'Etiópia'),
(65, 'Fiji'),
(66, 'Filipinas'),
(67, 'Finlândia'),
(68, 'França'),
(69, 'Gabão'),
(70, 'Gana'),
(71, 'Geórgia'),
(72, 'Geórgia do Sul e Ilhas Sandwich do Sul'),
(73, 'Gibraltar'),
(74, 'Granada'),
(75, 'Groenlândia'),
(76, 'Grécia'),
(77, 'Guadalupe'),
(78, 'Guam'),
(79, 'Guatemala'),
(80, 'Guiana'),
(81, 'Guiana Francesa'),
(82, 'Guiné'),
(83, 'Guiné Equatorial'),
(84, 'Guiné-Bissau'),
(85, 'Gâmbia'),
(86, 'Haiti'),
(87, 'Holanda'),
(88, 'Honduras'),
(89, 'Hong Kong'),
(90, 'Hungria'),
(91, 'Ilha Bouvet'),
(92, 'Ilhas Cayman'),
(93, 'Ilhas Christmas'),
(94, 'Ilhas Cocos'),
(95, 'Ilhas Comores'),
(96, 'Ilhas Cook'),
(97, 'Ilhas Falkland (Malvinas)'),
(98, 'Ilhas Faroe'),
(99, 'Ilhas Heard e Mac Donalds'),
(100, 'Ilhas Marianas do Norte'),
(101, 'Ilhas Marshall'),
(102, 'Ilhas Norfolk'),
(103, 'Ilhas Pitcairn'),
(104, 'Ilhas Salomão'),
(105, 'Ilhas Turks e Caicos'),
(106, 'Ilhas Virgens (Britânicas)'),
(107, 'Ilhas Virgens Norte-Americanas'),
(108, 'Ilhas Wallis e Futuna'),
(109, 'Indonésia'),
(110, 'Iraque'),
(111, 'Irlanda'),
(112, 'Irã'),
(113, 'Islândia'),
(114, 'Israel'),
(115, 'Itália'),
(116, 'Iugoslávia'),
(117, 'Iêmen'),
(118, 'Jamaica'),
(119, 'Japão'),
(120, 'Jordânia'),
(121, 'Kiribati'),
(122, 'Kuait'),
(123, 'Laos'),
(124, 'Latvia'),
(125, 'Lesoto'),
(126, 'Libéria'),
(127, 'Liechtenstein'),
(128, 'Lituânia'),
(129, 'Luxemburgo'),
(130, 'Líbano'),
(131, 'Líbia'),
(132, 'Macau'),
(133, 'Macedônia'),
(134, 'Madagascar'),
(135, 'Maldivas'),
(136, 'Mali'),
(137, 'Malta'),
(138, 'Malásia'),
(139, 'Maláui'),
(140, 'Marrocos'),
(141, 'Martinica'),
(142, 'Mauritânia'),
(143, 'Maurício'),
(144, 'Mayotte'),
(145, 'Mianmar'),
(146, 'Micronésia'),
(147, 'Moldova'),
(148, 'Mongólia'),
(149, 'Montserrat'),
(150, 'Moçambique'),
(151, 'México'),
(152, 'Mônaco'),
(153, 'Namíbia'),
(154, 'Nauru'),
(155, 'Nepal'),
(156, 'Nicarágua'),
(157, 'Nigéria'),
(158, 'Niue'),
(159, 'Noruega'),
(160, 'Nova Caledônia'),
(161, 'Nova Zelândia'),
(162, 'Níger'),
(163, 'Omã'),
(164, 'Palau'),
(165, 'Panamá'),
(166, 'Papua Nova Guiné'),
(167, 'Paquistão'),
(168, 'Paraguai'),
(169, 'Peru'),
(170, 'Polinésia Francesa'),
(171, 'Polônia'),
(172, 'Porto Rico'),
(173, 'Portugal'),
(174, 'Qatar'),
(175, 'Quirguistão'),
(176, 'Quênia'),
(177, 'Reino Unido'),
(178, 'República Centro-Africana'),
(179, 'República Democrática da Coréia'),
(180, 'República Dominicana'),
(181, 'República Tcheca'),
(182, 'República da Coréia'),
(183, 'Reunião'),
(184, 'Romênia'),
(185, 'Ruanda'),
(186, 'Rússia'),
(187, 'Saara Ocidental'),
(188, 'Saint Kitts e Nevis'),
(189, 'Saint-Pierre e Miquelon'),
(190, 'Samoa'),
(191, 'Samoa Americana'),
(192, 'San Marino'),
(193, 'Santa Helena'),
(194, 'Santa Lúcia'),
(195, 'Senegal'),
(196, 'Serra Leoa'),
(197, 'Seychelles'),
(198, 'Somália'),
(199, 'Sri Lanka'),
(200, 'Suazilândia'),
(201, 'Sudão'),
(202, 'Suriname'),
(203, 'Suécia'),
(204, 'Suíça'),
(205, 'Svalbard'),
(206, 'São Tomé e Príncipe'),
(207, 'São Vicente e Grenadinas'),
(208, 'Síria'),
(209, 'Tadjiquistão'),
(210, 'Tailândia'),
(211, 'Taiwan'),
(212, 'Tanzânia'),
(213, 'Território Britânico do Oceano Índico'),
(214, 'Territórios Franceses do Sul'),
(215, 'Timor Leste'),
(216, 'Togo'),
(217, 'Tokelau'),
(218, 'Tonga'),
(219, 'Trinidad e Tobago'),
(220, 'Tunísia'),
(221, 'Turcomenistão'),
(222, 'Turquia'),
(223, 'Tuvalu'),
(224, 'Ucrânia'),
(225, 'Uganda'),
(226, 'Uruguai'),
(227, 'Usbequistão'),
(228, 'Vanuatu'),
(229, 'Vaticano'),
(230, 'Venezuela'),
(231, 'Vietnã'),
(232, 'Zaire'),
(233, 'Zimbábue'),
(234, 'Zâmbia'),
(235, 'África do Sul'),
(236, 'Áustria'),
(237, 'Índia');

--
-- Extraindo dados da tabela `tb_workflow_processo`
--

INSERT INTO `tb_workflow_processo` (`id`, `id_usuario`, `id_titulo_fluxo`, `titulo`, `descricao`, `data`, `provisao`, `status`) VALUES
(1, 1, 1, 'PROCESSO EXEMPLO TESTE', 'apenas um processo criado para teste', '2019-05-07 16:31:20', 20.00, 1);

--
-- Extraindo dados da tabela `tb_workflow_processo_fluxo`
--

INSERT INTO `tb_workflow_processo_fluxo` (`id`, `id_processo`, `id_fluxo`, `ativo`, `atuante`, `propriedade_atividade`, `titulo_atividade`, `valor_atividade`, `status`) VALUES
(1, 1, 1, 1, 1, 1, 'Atividade 2', 0.00, '1'),
(2, 1, 2, 1, 0, 0, 'Atividade 1', 1.00, '1');

--
-- Extraindo dados da tabela `tb_workflow_titulo_fluxo`
--

INSERT INTO `tb_workflow_titulo_fluxo` (`id`, `titulo`, `descricao`, `status`, `id_usuario`) VALUES
(1, 'FLUXO PADRÃO', '', 1, 1);

--
-- Extraindo dados da tabela `tb_workflow_usuario`
--

INSERT INTO `tb_workflow_usuario` (`id`, `nome`, `imagem`, `login`, `id_perfil`, `senha`, `status`) VALUES
(1, 'Administrador', 'a-system-user-clip-art.png', 'admin', 1, '73acd9a5972130b75066c82595a1fae3', 1),
(11, 'USUÁRIO', 'a-system-user-clip-art.png', 'user', 2, '2e40ad879e955201df4dedbf8d479a12', 1);
