-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Out-2026 às 01:12
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
-- Banco de dados: `governo`
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
(1, 'Carlos Eduardo', 18000.00, 'Ministro', 'Ministério da Fazenda'),
(2, 'Ana Maria Silva', 12500.00, 'Secretária Executiva', 'Ministério da Saúde'),
(3, 'Roberto Santos', 9800.00, 'Diretor de Projetos', 'Ministério da Educação'),
(4, 'Fernanda Lima', 7500.00, 'Analista de Políticas Públicas', 'Ministério do Meio Ambiente'),
(5, 'Lucas Andrade', 6200.00, 'Assessor Técnico', 'Secretaria de Planejamento');

-- --------------------------------------------------------

--
-- Estrutura da tabela `poder_judiciario`
--

CREATE TABLE `poder_judiciario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `vara_tribunal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `poder_judiciario`
--

INSERT INTO `poder_judiciario` (`id`, `nome`, `salario`, `cargo`, `vara_tribunal`) VALUES
(1, 'Ricardo Almeida', 22000.00, 'Juiz de Direito', '1ª Vara Cível'),
(2, 'Patrícia Souza', 25000.00, 'Desembargadora', 'Tribunal de Justiça'),
(3, 'Thiago Ferreira', 11000.00, 'Analista Judiciário', '2ª Vara Criminal'),
(4, 'Camila Farias', 8200.00, 'Técnica Judiciária', 'Tribunal Regional do Trabalho'),
(5, 'Marcelo Nogueira', 22000.00, 'Juiz Federal', '3ª Vara Federal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `poder_legislativo`
--

CREATE TABLE `poder_legislativo` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `partido_politico` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `poder_legislativo`
--

INSERT INTO `poder_legislativo` (`id`, `nome`, `salario`, `cargo`, `partido_politico`) VALUES
(1, 'Mariana Costa', 15000.00, 'Deputada', 'PARTIDO-A'),
(2, 'João Paulo Ribeiro', 15000.00, 'Senador', 'PARTIDO-B'),
(3, 'Beatriz Mendes', 8500.00, 'Consultora Legislativa', 'Sem Partido (Concurs'),
(4, 'Gabriel Oliveira', 6000.00, 'Assessor Parlamentar', 'PARTIDO-A'),
(5, 'Juliana Rocha', 15000.00, 'Deputada', 'PARTIDO-C');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `poder_judiciario`
--
ALTER TABLE `poder_judiciario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `poder_legislativo`
--
ALTER TABLE `poder_legislativo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
