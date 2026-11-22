-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Nov-2026 às 20:45
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `governo2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `poder_executivo`
--

CREATE TABLE `poder_executivo` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `secretaria_ministerio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `poder_executivo`
--

INSERT INTO `poder_executivo` (`id`, `nome`, `salario`, `cargo`, `secretaria_ministerio`) VALUES
(1, 'Marcos Vinicius', 19000.00, 'Ministro', 'Ministério da Economia'),
(2, 'Juliana Castro', 13000.00, 'Secretária Executiva', 'Ministério da Justiça'),
(3, 'Renato Aragão', 10500.00, 'Diretor', 'Ministério da Ciência e Tecnologia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `poder_judiciario`
--

CREATE TABLE `poder_judiciario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `vara_tribunal` varchar(100) NOT NULL,
  `executivo_responsavel_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `poder_judiciario`
--

INSERT INTO `poder_judiciario` (`id`, `nome`, `salario`, `cargo`, `vara_tribunal`, `executivo_responsavel_id`) VALUES
(1, 'Heloisa Helena', 24000.00, 'Juíza de Direito', '4ª Vara Cível', 1),
(2, 'Claudio Buarque', 26000.00, 'Desembargador', 'Tribunal de Justiça', 2),
(3, 'Vanessa Lopes', 12000.00, 'Analista', '1ª Vara Criminal', 99);

-- --------------------------------------------------------

--
-- Estrutura da tabela `poder_legislativo`
--

CREATE TABLE `poder_legislativo` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `partido_politico` varchar(20) NOT NULL,
  `judiciario_vinculado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `poder_legislativo`
--

INSERT INTO `poder_legislativo` (`id`, `nome`, `salario`, `cargo`, `partido_politico`, `judiciario_vinculado_id`) VALUES
(1, 'Bruno Mendes', 15000.00, 'Deputado', 'PARTIDO-X', 1),
(2, 'Tatiane Ramos', 15000.00, 'Senadora', 'PARTIDO-Y', 50),
(3, 'Diego Souza', 9000.00, 'Consultor', 'Sem Partido', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `poder_executivo`
--
ALTER TABLE `poder_executivo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `poder_judiciario`
--
ALTER TABLE `poder_judiciario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `poder_legislativo`
--
ALTER TABLE `poder_legislativo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `poder_executivo`
--
ALTER TABLE `poder_executivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `poder_judiciario`
--
ALTER TABLE `poder_judiciario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `poder_legislativo`
--
ALTER TABLE `poder_legislativo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
