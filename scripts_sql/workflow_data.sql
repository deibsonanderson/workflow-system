-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: fdb12.eohost.com
-- Generation Time: 15-Jan-2020 às 16:18
-- Versão do servidor: 5.7.20-log
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2181795_bd`
--

--
-- Extraindo dados da tabela `tb_workflow_acao_usuario`
--

INSERT INTO `tb_workflow_acao_usuario` (`id`, `id_classe`, `id_usuario`, `perfil`, `status`) VALUES
(1, 1, 1, 'A', 1),
(2, 2, 1, 'A', 1),
(3, 3, 1, 'A', 1),
(4, 4, 1, 'A', 1),
(5, 5, 1, 'A', 1),
(6, 6, 1, 'A', 1),
(7, 7, 1, 'A', 1),
(8, 8, 1, 'A', 1);

--
-- Extraindo dados da tabela `tb_workflow_classe`
--

INSERT INTO `tb_workflow_classe` (`id`, `nome`, `id_perfil`, `controlador`, `funcao`, `secao`, `id_modulo`, `status`) VALUES
(1, 'ATIVIDADE', 2, 'ControladorAtividade', 'telaListarAtividade', 'ATIVIDADE', 1, 1),
(2, 'FLUXO', 2, 'ControladorFluxo', 'telaListarFluxo', 'FLUXO', 1, 1),
(3, 'PROCESSO', 2, 'ControladorProcesso', 'telaListarProcesso', 'PROCESSO', 1, 1),
(4, 'AGENDA', 2, 'ControladorAgenda', 'telaCadastrarAgenda', 'Agenda', 2, 1),
(5, 'LISTAR AGENDAS', 2, 'ControladorAgenda', 'telaListarAgenda', 'Agenda', 2, 1),
(6, 'CATEGORIA ATIVIDADE', 2, 'ControladorCategoriaAtividade', 'telaListarCategoriaAtividade', 'CATEGORIA ATIVIDADE', 1, 1),
(7, 'GRÁFICO PROCESSOS', 2, 'ControladorProcesso', 'telaGraficoProcessos', 'GRÁFICO PROCESS', 1, 1),
(8, 'LISTAR COMENTÁRIOS', 2, 'ControladorAtividade', 'telaListarComentariosAtividadeProcesso', NULL, 1, 1);

--
-- Extraindo dados da tabela `tb_workflow_modulo`
--

INSERT INTO `tb_workflow_modulo` (`id`, `nome`, `status`) VALUES
(1, 'FLUXO', 1),
(2, 'AGENDA', 1);

--
-- Extraindo dados da tabela `tb_workflow_usuario`
--

INSERT INTO `tb_workflow_usuario` (`id`, `nome`, `imagem`, `login`, `id_perfil`, `senha`, `status`) VALUES
(1, 'Administrador', '1-a-system-user-clip-art.png', 'admin', 1, '0745c01786c9d5df519bde4a76c847a3', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
