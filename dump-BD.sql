-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 
-- Versão do Servidor: 5.5.24-log
-- Versão do PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `helpdesk_comos`
--

DELIMITER $$
--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `totalChamados`(`id_categoria` INT, `is_finalizado` INT) RETURNS int(11)
    NO SQL
    DETERMINISTIC
begin
declare total int;
select count(id) into total from tb_chamado where categoria = id_categoria and finalizado = is_finalizado;
return total;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria`
--

CREATE TABLE IF NOT EXISTS `tb_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`id`, `descricao`) VALUES
(1, 'Comos'),
(2, 'PDMS'),
(3, 'Geral');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_chamado`
--

CREATE TABLE IF NOT EXISTS `tb_chamado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_atendente` int(11) NOT NULL,
  `os` varchar(50) NOT NULL,
  `categoria` int(11) NOT NULL,
  `titulo` varchar(140) NOT NULL,
  `finalizado` tinyint(1) NOT NULL,
  `tempo_total` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `tb_chamado`
--

INSERT INTO `tb_chamado` (`id`, `id_usuario`, `id_atendente`, `os`, `categoria`, `titulo`, `finalizado`, `tempo_total`) VALUES
(1, 1, 1, '5048', 1, 'Teste', 1, 529),
(2, 1, 1, '5048', 1, 'Teste', 1, 511),
(3, 1, 1, '5048', 2, 'Olá', 1, 653),
(4, 1, 1, '5048', 2, 'Olá', 1, 12),
(5, 1, 1, '5048', 3, 'Teste', 1, 0),
(6, 1, 1, '5048', 3, 'RWARW', 1, 0),
(7, 3, 1, '5048', 1, 'dasdasd', 1, 0),
(8, 4, 2, '5048', 1, 'Folha errada', 1, 3),
(9, 1, 1, '5000', 2, 'Fechar na Segunda', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_grupo`
--

CREATE TABLE IF NOT EXISTS `tb_grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tb_grupo`
--

INSERT INTO `tb_grupo` (`id`, `descricao`) VALUES
(1, 'ADMIN'),
(2, 'TI'),
(3, 'USUARIO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_resposta_chamado`
--

CREATE TABLE IF NOT EXISTS `tb_resposta_chamado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_chamado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `mensagem` varchar(9000) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_resposta` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=174 ;

--
-- Extraindo dados da tabela `tb_resposta_chamado`
--

INSERT INTO `tb_resposta_chamado` (`id`, `id_chamado`, `id_usuario`, `mensagem`, `data`) VALUES
(149, 0, 1, 'asdasdasd', '2012-08-15 14:19:12'),
(150, 103, 1, 'teste', '2012-08-15 14:21:14'),
(151, 104, 1, 'asdasd', '2012-08-15 14:23:01'),
(152, 105, 1, 'asdasd', '2012-08-15 14:23:35'),
(153, 1, 1, 'Teste', '2012-08-16 08:27:53'),
(154, 1, 1, 'Finalizado', '2012-08-17 07:16:53'),
(155, 2, 1, 'teste21', '2012-08-21 09:19:43'),
(156, 3, 1, 'Deu erro', '2012-08-21 10:10:11'),
(157, 2, 1, 'oi', '2012-08-21 16:39:58'),
(158, 2, 1, 'Teste', '2012-08-22 07:51:06'),
(159, 4, 1, 'teste', '2012-08-22 08:10:24'),
(160, 5, 1, 'teste', '2012-08-22 08:10:51'),
(161, 4, 1, 'Finalizado', '2012-08-22 08:22:24'),
(163, 3, 1, 'dfsdfsdf', '2012-08-22 11:03:41'),
(164, 6, 1, 'DASDASD', '2012-08-22 13:35:58'),
(165, 7, 3, 'asdasdasd', '2012-08-22 14:24:35'),
(166, 7, 1, 'Oi JoÃ£o', '2012-08-22 14:25:01'),
(167, 8, 4, 'A folha está toda errada!', '2012-08-22 14:26:08'),
(168, 8, 2, 'Teste', '2012-08-22 14:26:52'),
(169, 8, 4, 'Teste', '2012-08-22 14:29:59'),
(170, 9, 1, 'Fechar na Segunda.', '2012-08-24 09:01:55'),
(171, 9, 1, 'dfgdfg', '2012-08-24 10:47:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `senha` varchar(500) NOT NULL,
  `grupo` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ramal` varchar(5) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id`, `login`, `senha`, `grupo`, `nome`, `ramal`, `email`, `status`) VALUES
(1, 'adamo.nunes', '81dc9bdb52d04dc20036dbd8313ed055', 'ADMIN', 'Adamo Morone Nunes', '320', 'adamo.nunes@kty.com.br', 'ATIVO'),
(2, 'rodrigo.herrera', '81dc9bdb52d04dc20036dbd8313ed055', 'TI', 'Rodrigo Herrera', '275', 'rodrigo.herrera@kty.com.br', 'ATIVO'),
(3, 'joao.romio', '81dc9bdb52d04dc20036dbd8313ed055', 'TI', 'JoÃ£o Romio', '320', '@kty.com.br', 'INATIVO'),
(4, 'ana.silva', '81dc9bdb52d04dc20036dbd8313ed055', 'USUARIO', 'Ana Silva', '555', '@kty.com.br', 'ATIVO');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
