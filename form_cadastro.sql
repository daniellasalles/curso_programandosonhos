-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Jan-2020 às 21:56
-- Versão do servidor: 10.4.8-MariaDB
-- versão do PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `form_cadastro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `ID_endereco` int(11) NOT NULL,
  `cep` int(11) NOT NULL,
  `logradouro` text DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` text DEFAULT NULL,
  `ID_logradouro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`ID_endereco`, `cep`, `logradouro`, `numero`, `complemento`, `ID_logradouro`) VALUES
(34, 30775570, 'Barão de Ibituruna', 602, '', 1),
(35, 31630190, 'Eduardo Antônio da Fonseca', 973, '', 1),
(36, 31720210, 'Mário Batista da Costa', 146, '', 1),
(37, 30451451, 'Saul', 154, '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolaridade`
--

CREATE TABLE `escolaridade` (
  `ID_escolaridade` int(11) NOT NULL,
  `escolaridade` enum('Fundamental incompleto','Fundamental completo','Médio incompleto','Médio completo','Superior incompleto','Superior completo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `escolaridade`
--

INSERT INTO `escolaridade` (`ID_escolaridade`, `escolaridade`) VALUES
(1, 'Fundamental incompleto'),
(2, 'Fundamental completo'),
(3, 'Médio incompleto'),
(4, 'Médio completo'),
(5, 'Superior incompleto'),
(6, 'Superior completo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado_civil`
--

CREATE TABLE `estado_civil` (
  `ID_estcivil` int(11) NOT NULL,
  `estadocivil` enum('Solteiro','Casado','Separado','Divorciado','Viúvo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `estado_civil`
--

INSERT INTO `estado_civil` (`ID_estcivil`, `estadocivil`) VALUES
(1, 'Solteiro'),
(2, 'Casado'),
(3, 'Separado'),
(4, 'Divorciado'),
(5, 'Viúvo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `ID_pessoa` int(11) NOT NULL,
  `nome` text DEFAULT NULL,
  `datanasc` varchar(10) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `ID_estcivil` int(11) DEFAULT NULL,
  `ID_escolaridade` int(11) DEFAULT NULL,
  `ID_endereco` int(11) DEFAULT NULL,
  `informacoes` text DEFAULT NULL,
  `ingles` text DEFAULT NULL,
  `informatica` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`ID_pessoa`, `nome`, `datanasc`, `cpf`, `ID_estcivil`, `ID_escolaridade`, `ID_endereco`, `informacoes`, `ingles`, `informatica`) VALUES
(253, 'Natália Alícia Bruna Caldeira', '1960-10-03', '80445745657', 3, 4, 34, '', 'Sim', NULL),
(254, 'Joana Fernanda da Mata', '1972-05-17', '43508413691', 1, 6, 35, '', 'Sim', 'Sim'),
(255, 'Juliana Camila Assis', '1988-07-19', '85491421669', 1, 5, 36, '', NULL, 'Sim'),
(256, 'Mirella Vanessa Peixoto', '1990-03-09', '36184671685', 1, 4, 37, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_logradouro`
--

CREATE TABLE `tipo_logradouro` (
  `ID_logradouro` int(11) NOT NULL,
  `tipologradouro` enum('Rua','Avenida','Praça','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipo_logradouro`
--

INSERT INTO `tipo_logradouro` (`ID_logradouro`, `tipologradouro`) VALUES
(1, 'Rua'),
(2, 'Avenida'),
(3, 'Praça');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`ID_endereco`),
  ADD KEY `ID_logradouro` (`ID_logradouro`);

--
-- Índices para tabela `escolaridade`
--
ALTER TABLE `escolaridade`
  ADD PRIMARY KEY (`ID_escolaridade`);

--
-- Índices para tabela `estado_civil`
--
ALTER TABLE `estado_civil`
  ADD PRIMARY KEY (`ID_estcivil`);

--
-- Índices para tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`ID_pessoa`),
  ADD KEY `fk_estadocivil` (`ID_estcivil`),
  ADD KEY `fk_endereco` (`ID_endereco`) USING BTREE,
  ADD KEY `ID_escolaridade` (`ID_escolaridade`);

--
-- Índices para tabela `tipo_logradouro`
--
ALTER TABLE `tipo_logradouro`
  ADD PRIMARY KEY (`ID_logradouro`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `ID_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `escolaridade`
--
ALTER TABLE `escolaridade`
  MODIFY `ID_escolaridade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `estado_civil`
--
ALTER TABLE `estado_civil`
  MODIFY `ID_estcivil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `ID_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT de tabela `tipo_logradouro`
--
ALTER TABLE `tipo_logradouro`
  MODIFY `ID_logradouro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`ID_logradouro`) REFERENCES `tipo_logradouro` (`ID_logradouro`);

--
-- Limitadores para a tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD CONSTRAINT `fk_estadocivil` FOREIGN KEY (`ID_estcivil`) REFERENCES `estado_civil` (`ID_estcivil`),
  ADD CONSTRAINT `pessoa_ibfk_1` FOREIGN KEY (`ID_endereco`) REFERENCES `endereco` (`ID_endereco`),
  ADD CONSTRAINT `pessoa_ibfk_2` FOREIGN KEY (`ID_escolaridade`) REFERENCES `escolaridade` (`ID_escolaridade`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
