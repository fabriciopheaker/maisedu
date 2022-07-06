-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: dbservices
-- Tempo de geração: 31-Ago-2021 às 20:03
-- Versão do servidor: 10.1.48-MariaDB-1~bionic
-- versão do PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET foreign_key_checks = 0;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `maisedu`
--

--
-- Truncar tabela antes do insert `aluno`
--

TRUNCATE TABLE `aluno`;
--
-- Truncar tabela antes do insert `aula`
--

TRUNCATE TABLE `aula`;
--
-- Truncar tabela antes do insert `aula_tipo`
--

TRUNCATE TABLE `aula_tipo`;
--
-- Truncar tabela antes do insert `curso`
--

TRUNCATE TABLE `curso`;
--
-- Truncar tabela antes do insert `grupo`
--

TRUNCATE TABLE `grupo`;
--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`cod_grupo`, `descricao`) VALUES
(1, 'Administradores'),
(2, 'Alunos'),
(3, 'Desenvolvedores'),
(4, 'Professores'),
(5, 'Servidores');






TRUNCATE TABLE `modulo`;
--
-- Extraindo dados da tabela `modulo`
--
--
-- Truncar tabela antes do insert `modulo`
--

INSERT INTO `modulo` (`cod_modulo`, `cod_modulo_pai`, `menu`, `descricao`, `url`, `exclusivoadmin`, `ordem`, `manutencao`, `icone`, `controller`, `action`) VALUES
(2, NULL, 'Desenvolvimento', 'Desenvolvimento é um box que contém todos os módulos utilizados pelos programadores do sistema, tais como: Cadastro de Módulos, SqlManager e Logs do Sistema, por exemplo.', NULL, 0, 2, 0, 'fas fa-code', NULL, ''),
(3, NULL, 'Administração', 'Administração do sistema, criar grupos e usuário, alterar privilégios e retirar relatórios.', NULL, 0, 3, 0, 'fas fa-university', NULL, ''),
(1, NULL, 'Home', 'Tela destinada a apresentar uma tela inicial para todos os usuários.', NULL, 0, 1, 0, 'fas fa-home', 'Home', 'index'),
(4, 2, 'Módulos', 'Destinado à criação dos módulos do sistema.', NULL, 0, 1, 0, 'fas fa-cubes', 'Modulos', 'index'),
(5, 3, 'Grupos', 'Módulo destinado à gerenciamento de grupos e suas permissões no sistema.', NULL, 0, 1, 0, 'fas fa-users-cog', 'Grupos', 'index');


--
-- Truncar tabela antes do insert `grupo_privilegio`
--

TRUNCATE TABLE `grupo_privilegio`;
--
-- Extraindo dados da tabela `grupo_privilegio`
--

INSERT INTO `grupo_privilegio` (`cod_grupo_privilegio`, `cod_grupo`, `cod_modulo`) VALUES
(1,1,1),
(2,1,4),
(3,1,5),
(4,2,1),
(5,2,4),
(6,2,5),
(7,3,1),
(8,3,4),
(9,3,5),
(10,5,1),
(11,5,4),
(12,5,5);



--
-- Truncar tabela antes do insert `notificacao`
--

TRUNCATE TABLE `notificacao`;
--
-- Truncar tabela antes do insert `pessoa`
--

TRUNCATE TABLE `pessoa`;
--
-- Extraindo dados da tabela `pessoa`
--



--
-- Truncar tabela antes do insert `pessoa_email`
--

TRUNCATE TABLE `pessoa_email`;
--
-- Truncar tabela antes do insert `pessoa_telefone`
--

TRUNCATE TABLE `pessoa_telefone`;
--
-- Truncar tabela antes do insert `professor`
--

TRUNCATE TABLE `professor`;
--
-- Truncar tabela antes do insert `trilha_aula`
--

TRUNCATE TABLE `trilha_aula`;
--
-- Truncar tabela antes do insert `trilha_modulo`
--

TRUNCATE TABLE `trilha_modulo`;
--
-- Truncar tabela antes do insert `turma`
--

TRUNCATE TABLE `turma`;
--
-- Truncar tabela antes do insert `turma_professor`
--

TRUNCATE TABLE `turma_professor`;
--
-- Truncar tabela antes do insert `turma_trilha`
--

TRUNCATE TABLE `turma_trilha`;
--
-- Truncar tabela antes do insert `usuario`
--

TRUNCATE TABLE `usuario`;
--
-- Extraindo dados da tabela `usuario`
--



--
-- Truncar tabela antes do insert `usuario_grupo`
--

TRUNCATE TABLE `usuario_grupo`;
--
-- Extraindo dados da tabela `usuario_grupo`
--


--
-- Truncar tabela antes do insert `usuario_notificacao`
--

TRUNCATE TABLE `usuario_notificacao`;
--
-- Truncar tabela antes do insert `usuario_privilegio`
--

TRUNCATE TABLE `usuario_privilegio`;
SET foreign_key_checks = 1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
