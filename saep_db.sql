-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/11/2025 às 21:07
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `saep_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alerta_estoque`
--

CREATE TABLE `alerta_estoque` (
  `idalerta_estoque` int(11) NOT NULL,
  `fk_material` int(11) NOT NULL,
  `nome_produto` varchar(70) DEFAULT NULL,
  `quantidade_produto` int(11) DEFAULT NULL,
  `condicao_reposicao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_produto`
--

CREATE TABLE `cadastro_produto` (
  `idcadastro_produto` int(11) NOT NULL,
  `fk_fornecedor` int(11) NOT NULL,
  `nome_produto` varchar(70) DEFAULT NULL,
  `peso_produto` varchar(45) DEFAULT NULL,
  `unidade_medida` varchar(45) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `preco_unitario` varchar(45) DEFAULT NULL,
  `data_validade` date DEFAULT NULL,
  `nota_fiscal` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `entrada_produto`
--

CREATE TABLE `entrada_produto` (
  `identrada_produto` int(11) NOT NULL,
  `fk_material` int(11) NOT NULL,
  `fk_usuario` int(11) NOT NULL,
  `nome_produto` varchar(70) DEFAULT NULL,
  `nota_fiscal` varchar(45) DEFAULT NULL,
  `data_saida` date DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `idfornecedor` int(11) NOT NULL,
  `nome_fornecedor` varchar(70) DEFAULT NULL,
  `destino` varchar(45) DEFAULT NULL,
  `cnpj_empresa` varchar(45) DEFAULT NULL,
  `local_empresa` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `saida_produto`
--

CREATE TABLE `saida_produto` (
  `idsaida_produto` int(11) NOT NULL,
  `fk_usuario` int(11) NOT NULL,
  `nome_produto` varchar(70) DEFAULT NULL,
  `nota_fiscal` varchar(45) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `data_saida` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuarios` int(11) NOT NULL,
  `nome_usuario` varchar(70) DEFAULT NULL,
  `usuario` varchar(70) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idusuarios`, `nome_usuario`, `usuario`, `senha`) VALUES
(1, 'Ruan', 'ruanteste@gmail.com', 'ruanteste');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alerta_estoque`
--
ALTER TABLE `alerta_estoque`
  ADD PRIMARY KEY (`idalerta_estoque`),
  ADD KEY `fk_alerta_material_idx` (`fk_material`);

--
-- Índices de tabela `cadastro_produto`
--
ALTER TABLE `cadastro_produto`
  ADD PRIMARY KEY (`idcadastro_produto`),
  ADD KEY `fk_fornecedor_idx` (`fk_fornecedor`);

--
-- Índices de tabela `entrada_produto`
--
ALTER TABLE `entrada_produto`
  ADD PRIMARY KEY (`identrada_produto`),
  ADD KEY `fk_material_idx` (`fk_material`),
  ADD KEY `fk_usuario_idx` (`fk_usuario`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`idfornecedor`);

--
-- Índices de tabela `saida_produto`
--
ALTER TABLE `saida_produto`
  ADD PRIMARY KEY (`idsaida_produto`),
  ADD KEY `fk_saida_usuario_idx` (`fk_usuario`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuarios`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alerta_estoque`
--
ALTER TABLE `alerta_estoque`
  MODIFY `idalerta_estoque` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cadastro_produto`
--
ALTER TABLE `cadastro_produto`
  MODIFY `idcadastro_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `entrada_produto`
--
ALTER TABLE `entrada_produto`
  MODIFY `identrada_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `idfornecedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `saida_produto`
--
ALTER TABLE `saida_produto`
  MODIFY `idsaida_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alerta_estoque`
--
ALTER TABLE `alerta_estoque`
  ADD CONSTRAINT `fk_alerta_material` FOREIGN KEY (`fk_material`) REFERENCES `cadastro_produto` (`idcadastro_produto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cadastro_produto`
--
ALTER TABLE `cadastro_produto`
  ADD CONSTRAINT `fk_fornecedor` FOREIGN KEY (`fk_fornecedor`) REFERENCES `fornecedor` (`idfornecedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `entrada_produto`
--
ALTER TABLE `entrada_produto`
  ADD CONSTRAINT `fk_material` FOREIGN KEY (`fk_material`) REFERENCES `cadastro_produto` (`idcadastro_produto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `saida_produto`
--
ALTER TABLE `saida_produto`
  ADD CONSTRAINT `fk_saida_usuario` FOREIGN KEY (`fk_usuario`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
