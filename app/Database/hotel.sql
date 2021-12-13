-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 28-Nov-2021 às 00:36
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

create database hotel;

use hotel;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hotel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserves`
--

CREATE TABLE `reserves` (
  `id` int(11) NOT NULL,
  `user_id` int(200) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `room_id` int(11) NOT NULL
);

--
-- Extraindo dados da tabela `reserves`
--

INSERT INTO `reserves` (`id`, `user_id`, `check_in`, `check_out`, `room_id`) VALUES
(8, 6, '2022-01-06', '2022-01-27', 5),
(2, 4, '2021-11-21', '2021-11-25', 2),
(3, 4, '2021-12-01', '2021-12-04', 1),
(6, 5, '2021-11-26', '2021-11-30', 1),
(9, 4, '2022-02-01', '2022-02-05', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `people` int(11) NOT NULL,
  `local` varchar(200) NOT NULL,
  `price` varchar(255) NOT NULL,
  `status` varchar(200) NOT NULL
);

--
-- Extraindo dados da tabela `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `people`, `local`, `price`, `status`) VALUES
(1, 'A01', 3, 'hotel Jenius', '100', 'Livre'),
(2, 'A02', 3, 'Hotel Jenius', '100', 'Livre'),
(5, 'A03', 2, 'Hotel Jenius', '100', 'Livre');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `cpf_cnpj` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `birthday` date NOT NULL,
  `rg` varchar(200) NOT NULL,
  `cep` varchar(200) NOT NULL,
  `street_number` varchar(200) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `whatsapp_number` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password_hash` varchar(200) NOT NULL,
  `role` enum('ADM','USER') NOT NULL DEFAULT 'USER'
);

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `cpf_cnpj`, `name`, `birthday`, `rg`, `cep`, `street_number`, `phone_number`, `whatsapp_number`, `email`, `password_hash`, `role`) VALUES
(5, '11111111111', 'outra conta', '2021-10-12', '531561515', '231531531', '53153151', '53151531', '531531531', '5315315@11531035135', '$2y$10$MjOL3Q/ol.0KitfSpUS2Qe6kH7Vk9zL4vjRycxSu05o9lvqezZzXu', 'USER'),
(4, '1234567898', 'User', '2021-10-19', '524524', '51515', '1515', '515', '15615156', '51651@15615', '$2y$10$bwK4QBNi6u9pdKmkAtWd2.c47IQluqLkUztIj6Grs4IQ33.uK6Cp2', 'ADM'),
(6, '22222222222', 'Jeferson', '1999-06-16', '54242424', '65678678', '3515', '12555844896', '12555844896', 'emailsla@gmail.com', '$2y$10$1EIoHfytYGKBBytdPK2QNe5JFz/3dSjRR3WTUcX3D1PpOUcmox4HO', 'USER');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `reserves`
--
ALTER TABLE `reserves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
