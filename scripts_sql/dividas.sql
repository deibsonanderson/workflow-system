CREATE TABLE `tb_workflow_dividas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `valor` varchar(50) DEFAULT '0.00',
  `dataInicial` varchar(20) DEFAULT NULL,
  `dataFinal` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
