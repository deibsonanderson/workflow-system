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

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_acao_usuario`
--

CREATE TABLE `tb_workflow_acao_usuario` (
  `id` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `perfil` varchar(1) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_agenda`
--

CREATE TABLE `tb_workflow_agenda` (
  `id` int(11) NOT NULL,
  `descricao` text,
  `arquivo` varchar(100) DEFAULT NULL,
  `link` varchar(1024) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_atividade`
--

CREATE TABLE `tb_workflow_atividade` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descricao` text,
  `link` varchar(1024) DEFAULT NULL,
  `imagem` varchar(500) DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `valor` double(9,2) DEFAULT '0.00',
  `propriedade` int(11) DEFAULT '1',
  `id_categoria` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `vencimento` int(11) DEFAULT NULL,
  `fixa` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_categoria_atividade`
--

CREATE TABLE `tb_workflow_categoria_atividade` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_classe`
--

CREATE TABLE `tb_workflow_classe` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `id_perfil` int(11) DEFAULT NULL,
  `controlador` varchar(255) DEFAULT NULL,
  `funcao` varchar(255) DEFAULT NULL,
  `secao` varchar(20) DEFAULT NULL,
  `id_modulo` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_comentario`
--

CREATE TABLE `tb_workflow_comentario` (
  `id` int(11) NOT NULL,
  `id_processo_fluxo` int(11) NOT NULL,
  `descricao` text,
  `arquivo` varchar(100) DEFAULT NULL,
  `categoria` varchar(10) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_fluxo`
--

CREATE TABLE `tb_workflow_fluxo` (
  `id` int(11) NOT NULL,
  `id_atividade` int(11) NOT NULL,
  `id_titulo_fluxo` int(11) NOT NULL,
  `ordenacao` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_login`
--

CREATE TABLE `tb_workflow_login` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_modulo`
--

CREATE TABLE `tb_workflow_modulo` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_processo`
--

CREATE TABLE `tb_workflow_processo` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_titulo_fluxo` int(11) NOT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `descricao` text,
  `data` datetime DEFAULT NULL,
  `provisao` double(9,2) DEFAULT '0.00',
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_processo_fluxo`
--

CREATE TABLE `tb_workflow_processo_fluxo` (
  `id` int(11) NOT NULL,
  `id_processo` int(11) NOT NULL,
  `id_fluxo` int(11) NOT NULL,
  `ativo` int(11) DEFAULT NULL,
  `fixa_atividade` int(11) DEFAULT NULL,
  `atuante` int(11) DEFAULT '0',
  `propriedade_atividade` int(11) NOT NULL DEFAULT '1',
  `titulo_atividade` varchar(50) DEFAULT NULL,
  `valor_atividade` double(9,2) DEFAULT '0.00',
  `vencimento_atividade` int(11) DEFAULT NULL,
  `descricao_atividade` text,
  `out_flow` int(11) NOT NULL DEFAULT '0',
  `status` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_workflow_titulo_fluxo`
--

CREATE TABLE `tb_workflow_titulo_fluxo` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descricao` text,
  `status` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Estrutura da tabela `tb_workflow_usuario`
--

CREATE TABLE `tb_workflow_usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `login` varchar(30) NOT NULL,
  `id_perfil` int(11) NOT NULL COMMENT '1-Administrador e 2-usuario',
  `senha` varchar(256) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_workflow_acao_usuario`
--
ALTER TABLE `tb_workflow_acao_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_acao` (`id_classe`),
  ADD KEY `id_usuario_empresa` (`id_usuario`);

--
-- Indexes for table `tb_workflow_agenda`
--
ALTER TABLE `tb_workflow_agenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `tb_workflow_atividade`
--
ALTER TABLE `tb_workflow_atividade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_workflow_categoria_atividade`
--
ALTER TABLE `tb_workflow_categoria_atividade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_workflow_classe`
--
ALTER TABLE `tb_workflow_classe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nome` (`nome`),
  ADD KEY `id_classe` (`id_modulo`);

--
-- Indexes for table `tb_workflow_comentario`
--
ALTER TABLE `tb_workflow_comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_processo_fluxo` (`id_processo_fluxo`);

--
-- Indexes for table `tb_workflow_fluxo`
--
ALTER TABLE `tb_workflow_fluxo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_titulo_fluxo`),
  ADD KEY `id_atividade` (`id_atividade`),
  ADD KEY `id_atividade_2` (`id_atividade`),
  ADD KEY `id_titulo_fluxo` (`id_titulo_fluxo`);

--
-- Indexes for table `tb_workflow_login`
--
ALTER TABLE `tb_workflow_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `tb_workflow_modulo`
--
ALTER TABLE `tb_workflow_modulo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_workflow_processo`
--
ALTER TABLE `tb_workflow_processo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`,`id_titulo_fluxo`),
  ADD KEY `id_titulo_fluxo` (`id_titulo_fluxo`);

--
-- Indexes for table `tb_workflow_processo_fluxo`
--
ALTER TABLE `tb_workflow_processo_fluxo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_processo` (`id_processo`,`id_fluxo`,`status`),
  ADD KEY `id_fluxo` (`id_fluxo`);

--
-- Indexes for table `tb_workflow_titulo_fluxo`
--
ALTER TABLE `tb_workflow_titulo_fluxo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_workflow_usuario`
--
ALTER TABLE `tb_workflow_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perfil` (`id_perfil`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_workflow_usuario`
--
ALTER TABLE `tb_workflow_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_acao_usuario`
--
ALTER TABLE `tb_workflow_acao_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_agenda`
--
ALTER TABLE `tb_workflow_agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_atividade`
--
ALTER TABLE `tb_workflow_atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_categoria_atividade`
--
ALTER TABLE `tb_workflow_categoria_atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_classe`
--
ALTER TABLE `tb_workflow_classe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_comentario`
--
ALTER TABLE `tb_workflow_comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_fluxo`
--
ALTER TABLE `tb_workflow_fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_login`
--
ALTER TABLE `tb_workflow_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_modulo`
--
ALTER TABLE `tb_workflow_modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_workflow_processo`
--
ALTER TABLE `tb_workflow_processo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_processo_fluxo`
--
ALTER TABLE `tb_workflow_processo_fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_workflow_titulo_fluxo`
--
ALTER TABLE `tb_workflow_titulo_fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;  
