-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Jan-2020 às 22:59
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolaridade`
--

CREATE TABLE `escolaridade` (
  `ID_escolaridade` int(11) NOT NULL,
  `escolaridade` enum('Fundamental incompleto','Fundamental completo','Médio incompleto','Médio completo','Superior incompleto','Superior completo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado_civil`
--

CREATE TABLE `estado_civil` (
  `ID_estcivil` int(11) NOT NULL,
  `estadocivil` enum('Solteiro','Casado','Separado','Divorciado','Viúvo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_logradouro`
--

CREATE TABLE `tipo_logradouro` (
  `ID_logradouro` int(11) NOT NULL,
  `tipologradouro` enum('Rua','Avenida','Praça','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `ID_endereco` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `escolaridade`
--
ALTER TABLE `escolaridade`
  MODIFY `ID_escolaridade` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estado_civil`
--
ALTER TABLE `estado_civil`
  MODIFY `ID_estcivil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `ID_pessoa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipo_logradouro`
--
ALTER TABLE `tipo_logradouro`
  MODIFY `ID_logradouro` int(11) NOT NULL AUTO_INCREMENT;

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
