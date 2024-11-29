-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/11/2024 às 15:04
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
-- Banco de dados: `dbavesso`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbcantadas`
--

CREATE TABLE `tbcantadas` (
  `idCantada` int(11) NOT NULL,
  `idRemetente` int(11) NOT NULL,
  `idDestinatario` int(11) NOT NULL,
  `conteudoCantada` text NOT NULL,
  `dataCantada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbcantadas`
--

INSERT INTO `tbcantadas` (`idCantada`, `idRemetente`, `idDestinatario`, `conteudoCantada`, `dataCantada`) VALUES
(17, 166, 164, 'Você é um chuchuzinho', '2024-11-28 03:33:01'),
(18, 171, 169, 'Gato', '2024-11-28 10:38:40'),
(19, 172, 171, 'Seu pai é padeiro? Porque você é um sonho!', '2024-11-28 10:43:24'),
(20, 182, 164, 'Seu pai e padeiro? Porque voce e muito legal', '2024-11-28 12:43:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbfotos_usuarios`
--

CREATE TABLE `tbfotos_usuarios` (
  `idFoto` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `nomeArquivoFoto` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbfotos_usuarios`
--

INSERT INTO `tbfotos_usuarios` (`idFoto`, `idUsuario`, `nomeArquivoFoto`) VALUES
(88, 165, '165ca91f08ec36106b787ca526b3657d929e1284ac4.jpg'),
(87, 169, '1698c585ef00fe5f5e2ef4863f0c6c791330f01058f.jpg'),
(72, 165, '165941f500aa3fd65d4455df2747af2be70331b83c3.jpg'),
(73, 165, '165e2763c3b4e2b38c5c4d7429f057b0c81b2f1e0e2.jpg'),
(74, 165, '165f143855acff44fc4db223228e5ec4c3ed4e29b82.jpg'),
(75, 165, '165e2763c3b4e2b38c5c4d7429f057b0c81b2f1e0e2.jpg'),
(76, 165, '165f143855acff44fc4db223228e5ec4c3ed4e29b82.jpg'),
(78, 164, '1648977e928e41acb64af5cec419c96793271de8960.jpg'),
(82, 166, '166adf33b92b37821e115363f095c7f69beab8fba86.jpg'),
(83, 166, '166d2be1314561928fc5758b5d7f4df6a8f6bcd2fa3.jpg'),
(84, 166, '16641460ae5f4a43823ae10d39d17cd5291a67156ea.jpg'),
(85, 167, '1673a8ec18417c82660a5b60404d04cb2a7d20fce83.jpg'),
(86, 168, '168a9fb3a7c2c644678fd1279f61e1a80c82d8ff7b7.jpg'),
(90, 171, '171ad84e15e446f01bbabc3f8067a719e3bf7b17ba6.jpeg'),
(91, 171, '171511b4229c1438d4a7a9a721b35ddf364a4be0b3f.webp'),
(92, 172, '172f51ac50898f4ea675e71ddaa712bbb1c6c0b9212.jpg'),
(93, 172, '172ad783db64d2c8f1d300e8ebc9038e0713fb24a6f.jpg'),
(94, 173, '1737a9d45a00de4e18bf3866ecb650c1f6562c36246.jpeg'),
(95, 175, '1759c3002f5e5de31c3882128e84ea3fb9be1af31b4.jpg'),
(96, 175, '1754e76750a05884823ed38c7db54b51d4459069d3c.jpg'),
(97, 178, '1783b9180a79d570bfbe13eac09ca7c27f23f640e4f.jpg'),
(98, 177, '177ad6e5ffcd6faa644fbff96aa8141eb7d7d10c74a.jpg'),
(99, 178, '178f2a0744e58a7090ed7990f7df958a93c1f540cc5.webp'),
(100, 177, '177c36013de5401d71aff6d3957ea74aafc2285de56.jpg'),
(101, 174, '1744c49ba55c5aeb4ba92631935418e560b68e6695b.png'),
(102, 174, '174126179c2cc26cedcc272544a4937f432c5557641.png'),
(103, 176, '17663c3f4ac5a3f59a9d408e64d248b44d1e7bc87a8.jpg'),
(104, 176, '176c9168a98ea1130bbc0c28160c53724516f55eadf.jpg'),
(105, 180, '180a073e81f990d2c81029da7f7babeefd5a30a266f.png'),
(106, 179, '179c83a2b7c1ca363b1d3b27c4ecea1c012383d6610.jpg'),
(107, 180, '180c34ca70e94e16b6fa3b464689f607d3efaf9eb9b.png'),
(108, 179, '179dacf702284fa6fe31063ddf4fba9265c95621538.jpg'),
(109, 182, '18237ebed73b6d2966490a3c9839fe9c4d30d0bdd04.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbhashtags`
--

CREATE TABLE `tbhashtags` (
  `idHashtag` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `tituloHashtag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbhashtags`
--

INSERT INTO `tbhashtags` (`idHashtag`, `idUsuario`, `tituloHashtag`) VALUES
(311, 164, 'Programação'),
(312, 164, 'Desenhar'),
(313, 164, 'Estar na natureza'),
(314, 165, 'Natureza'),
(315, 165, 'Carpintaria'),
(316, 165, 'Rancho'),
(318, 166, 'Caldo de jaca'),
(329, 168, 'Viajar'),
(330, 168, 'Jogar'),
(331, 168, 'Estudar'),
(332, 168, 'Programar'),
(333, 168, 'Fazer'),
(334, 168, 'Ler'),
(337, 167, 'Andar de moto'),
(338, 168, 'Avesso'),
(339, 168, 'Criador'),
(340, 168, 'Amigo'),
(341, 168, 'Eu não entendi '),
(342, 167, 'Cozinhar'),
(343, 167, 'Passear'),
(344, 167, 'Trabalhar'),
(345, 167, 'Dar aula'),
(346, 167, 'Estudar'),
(347, 167, 'Viajar'),
(348, 167, 'Botucatu'),
(349, 167, 'Experimentar coisas novas'),
(350, 168, 'Dançar'),
(360, 169, 'Jogar'),
(361, 170, 'Tatuagens '),
(362, 170, 'Xampoo'),
(363, 170, 'Desodorante'),
(364, 170, 'Escovar os dentes'),
(365, 171, 'Jogos'),
(366, 171, 'Informática'),
(367, 172, 'Leitura'),
(368, 172, 'Jogos'),
(369, 172, 'Filmes'),
(370, 172, 'Séries'),
(371, 172, 'Música'),
(372, 172, 'Artes'),
(373, 173, 'jogos'),
(374, 173, 'esportes'),
(375, 173, 'filmes/series'),
(376, 174, 'jogos'),
(377, 174, 'esportes'),
(378, 174, 'comida'),
(379, 174, 'musica'),
(380, 174, 'filmes/series'),
(381, 174, 'carros'),
(382, 175, 'Espotes'),
(383, 175, 'Filmes'),
(384, 175, 'Séries'),
(385, 175, 'Música'),
(386, 175, 'Artes'),
(387, 176, 'artes'),
(388, 176, 'carros'),
(389, 178, 'jogos'),
(390, 178, 'esportes'),
(391, 178, 'comida'),
(392, 178, 'musica'),
(393, 177, 'Carros'),
(394, 178, 'carros'),
(395, 177, 'Esportes'),
(396, 177, 'Jogos'),
(397, 177, 'Filmes'),
(398, 177, 'Séries'),
(399, 178, 'filmes/series'),
(400, 179, 'Jogos'),
(401, 179, 'Comida'),
(402, 179, 'Filmes'),
(403, 179, 'Séries'),
(404, 179, 'Carros'),
(405, 179, 'Viajar'),
(406, 180, 'jogos'),
(407, 180, 'esportes'),
(408, 180, 'comida'),
(409, 180, 'musica'),
(410, 180, 'carros'),
(411, 181, 'feiluta'),
(412, 181, 'leitura'),
(413, 181, 'filmes'),
(414, 181, 'comida'),
(415, 181, 'musica'),
(416, 182, 'Musica'),
(417, 182, 'passear'),
(418, 182, 'Viajar');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbmatches`
--

CREATE TABLE `tbmatches` (
  `idUsuario` int(11) NOT NULL,
  `idUsuarioMatch` int(11) NOT NULL,
  `dataMatche` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbmatches`
--

INSERT INTO `tbmatches` (`idUsuario`, `idUsuarioMatch`, `dataMatche`) VALUES
(164, 166, '2024-11-28 03:33:19'),
(164, 182, '2024-11-28 12:44:56'),
(166, 164, '2024-11-28 03:33:02'),
(171, 165, '2024-11-28 10:35:55'),
(171, 168, '2024-11-28 10:36:46'),
(171, 169, '2024-11-28 10:36:58'),
(171, 172, '2024-11-28 10:42:37'),
(172, 171, '2024-11-28 10:42:47'),
(173, 167, '2024-11-28 10:42:46'),
(173, 168, '2024-11-28 10:42:57'),
(175, 170, '2024-11-28 10:52:58'),
(177, 172, '2024-11-28 10:57:54'),
(182, 164, '2024-11-28 12:43:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbmensagens`
--

CREATE TABLE `tbmensagens` (
  `idMsg` int(11) NOT NULL,
  `idRemetente` int(11) NOT NULL,
  `idDestinatario` int(11) NOT NULL,
  `conteudoMsg` text NOT NULL,
  `msgVisualizada` tinyint(4) NOT NULL DEFAULT 0,
  `dataMsg` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbmensagens`
--

INSERT INTO `tbmensagens` (`idMsg`, `idRemetente`, `idDestinatario`, `conteudoMsg`, `msgVisualizada`, `dataMsg`) VALUES
(87, 164, 166, 'Ola', 1, '2024-11-28 03:36:35'),
(88, 171, 172, 'Oi', 1, '2024-11-28 10:45:49'),
(89, 171, 172, 'Adorei a cantada.', 1, '2024-11-28 10:45:49'),
(90, 171, 172, 'Mas não sou padeiro.', 1, '2024-11-28 10:46:27'),
(91, 172, 171, 'Mas eu perguntei se seu pai era padeiro, não você!!!!!!!!', 1, '2024-11-28 10:46:27'),
(92, 164, 182, 'iai jose, te achei um pichuco', 0, '2024-11-28 12:45:48'),
(93, 182, 164, 'kakakakaka', 0, '2024-11-28 12:45:54'),
(94, 164, 182, '', 0, '2024-11-28 13:06:57'),
(95, 164, 182, 'dsadasdas', 0, '2024-11-28 13:06:59'),
(96, 164, 182, '', 0, '2024-11-28 13:07:00'),
(97, 164, 182, '', 0, '2024-11-28 13:07:00'),
(98, 164, 182, '', 0, '2024-11-28 13:07:00'),
(99, 164, 182, '', 0, '2024-11-28 13:07:01'),
(100, 164, 182, '', 0, '2024-11-28 13:07:01'),
(101, 164, 182, '', 0, '2024-11-28 13:07:01'),
(102, 164, 182, '', 0, '2024-11-28 13:07:01'),
(103, 164, 182, '', 0, '2024-11-28 13:07:01'),
(104, 164, 182, '', 0, '2024-11-28 13:07:04'),
(105, 164, 182, '', 0, '2024-11-28 13:07:05'),
(106, 164, 182, '', 0, '2024-11-28 13:07:05'),
(107, 164, 182, '', 0, '2024-11-28 13:07:05'),
(108, 164, 182, '', 0, '2024-11-28 13:07:05'),
(109, 164, 182, '', 0, '2024-11-28 13:07:05'),
(110, 164, 182, '', 0, '2024-11-28 13:07:06'),
(111, 164, 182, '', 0, '2024-11-28 13:07:06'),
(112, 164, 182, '', 0, '2024-11-28 13:07:06'),
(113, 164, 182, '', 0, '2024-11-28 13:07:06');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpaises`
--

CREATE TABLE `tbpaises` (
  `idPais` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `nomePais` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpaises`
--

INSERT INTO `tbpaises` (`idPais`, `iso`, `nomePais`) VALUES
(1, 'BR', 'Brasil'),
(2, 'US', 'USA'),
(3, 'AF', 'Afeganistão');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbperguntas`
--

CREATE TABLE `tbperguntas` (
  `idPergunta` int(11) NOT NULL,
  `tituloPergunta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbperguntas`
--

INSERT INTO `tbperguntas` (`idPergunta`, `tituloPergunta`) VALUES
(38, 'Se você pudesse ter um superpoder por um dia, qual seria e por quê?'),
(39, 'O que estaria escrito na sua lapide?'),
(40, 'Qual comida você comeria pelo resto da vida?'),
(41, 'Qual foi o sonho mais estranho que você já teve?'),
(42, 'Qual é o emoji que você mais usa e por quê?'),
(43, 'Se pudesse trocar de vida com qualquer personagem, quem escolheria?'),
(44, 'Qual foi a coisa mais espontânea que você já fez?'),
(45, 'Qual é a música que sempre te faz dançar, não importa onde esteja?'),
(46, 'Se pudesse ter qualquer animal como bichinho de estimação, qual escolheria?'),
(47, 'Qual é o talento secreto que você gostaria de ter?'),
(48, 'Qual foi a comida mais exótica ou diferente que já experimentou?'),
(49, 'Qual personagem de desenho animado você mais se identifica?'),
(50, 'Qual é o filme ou série você que ama, mas raramente conta para alguém?'),
(51, 'Qual foi o melhor presente que você já recebeu?'),
(52, 'Se tivesse uma máquina do tempo, qual época ou evento histórico gostaria de visitar?');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbusuarios`
--

CREATE TABLE `tbusuarios` (
  `idUsuario` int(11) NOT NULL,
  `emailUsuario` varchar(100) NOT NULL,
  `senhaUsuario` varchar(64) NOT NULL,
  `nomeUsuario` varchar(100) NOT NULL,
  `dataNascUsuario` date DEFAULT NULL,
  `idPaisUsuario` int(11) DEFAULT NULL,
  `cidadeUsuario` varchar(100) NOT NULL DEFAULT 'Campinas',
  `bioUsuario` text DEFAULT NULL,
  `sexUsuario` enum('Héterossexual','Homossexual','Bissexual','Outro','Prefiro não informar') DEFAULT NULL,
  `genUsuario` enum('Masculino','Feminino','Outro','Prefiro não informar') DEFAULT NULL,
  `prefUsuario` enum('Homem','Mulher','Sem preferência') DEFAULT NULL,
  `fotoPerfilUsuario` varchar(255) DEFAULT NULL,
  `statusCadUsuario` tinyint(4) NOT NULL DEFAULT 0,
  `dataCadUsuario` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbusuarios`
--

INSERT INTO `tbusuarios` (`idUsuario`, `emailUsuario`, `senhaUsuario`, `nomeUsuario`, `dataNascUsuario`, `idPaisUsuario`, `cidadeUsuario`, `bioUsuario`, `sexUsuario`, `genUsuario`, `prefUsuario`, `fotoPerfilUsuario`, `statusCadUsuario`, `dataCadUsuario`) VALUES
(164, 'gabriel@email.com', 'dce5879d071b2fdbd48c416eeab8d522922bbcfc71cc9c5e865ead6bb7a4d8ee', 'Gabriel Lopes Françozo', '2005-12-28', 1, 'Campinas', 'Olá, meu nome é Gabriel e gosto de programar', 'Héterossexual', 'Masculino', 'Mulher', '164.jpg', 6, '2024-11-24 12:06:59'),
(165, 'gisele@email.com', 'dce5879d071b2fdbd48c416eeab8d522922bbcfc71cc9c5e865ead6bb7a4d8ee', 'Gisele Françozo', '1979-01-05', 2, 'New York', 'Eu gosto de fazer mesas e trabalhar com carpintaria ', 'Héterossexual', 'Feminino', 'Homem', '165.jpg', 6, '2024-11-24 11:47:40'),
(166, 'isabela@email.com', 'dce5879d071b2fdbd48c416eeab8d522922bbcfc71cc9c5e865ead6bb7a4d8ee', 'Isabella Françozo Pereira', '1999-05-13', 1, 'Campinas', 'Olá, eu sou a isabela, moro em portugal e gosto muito de viajar', 'Héterossexual', 'Feminino', 'Homem', '166.jpg', 6, '2024-11-24 12:47:13'),
(167, 'rodrigo@email.com', 'dce5879d071b2fdbd48c416eeab8d522922bbcfc71cc9c5e865ead6bb7a4d8ee', 'Rodrigo Ruiz de Goes', '1981-02-28', 2, 'New York', 'Eu gosto muito de andar de moto e cozinhar', 'Héterossexual', 'Masculino', 'Mulher', '167.jpg', 6, '2024-11-26 00:54:02'),
(168, 'gabriel.lopes@email.com', 'dce5879d071b2fdbd48c416eeab8d522922bbcfc71cc9c5e865ead6bb7a4d8ee', 'Gabriel Lopes Françozo', '2005-11-25', 1, 'Campinas', 'Olá, eu sou o Gabriel e gosto de programação e jogar futebol', 'Héterossexual', 'Masculino', 'Mulher', '168.jpg', 6, '2024-11-26 01:05:07'),
(169, 'gabriel123@email.com', 'dce5879d071b2fdbd48c416eeab8d522922bbcfc71cc9c5e865ead6bb7a4d8ee', 'Gabriel Lopes Françozo', '2000-11-25', 1, 'Campinas', 'Eu gosto de programação e de natureza, e também de estar com meus amigos', 'Héterossexual', 'Masculino', 'Mulher', '169.jpg', 6, '2024-11-26 02:11:55'),
(170, 'alice@email.com', 'dce5879d071b2fdbd48c416eeab8d522922bbcfc71cc9c5e865ead6bb7a4d8ee', 'Alice Maria Gomes', '1996-11-26', 1, 'Campinas', 'Eu sou a Alice, tenho 18 anos e gosto de tatuagens', 'Héterossexual', 'Feminino', 'Homem', '170.jpg', 6, '2024-11-27 02:32:40'),
(171, 'marcdmelo@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Marcos de Melo', '1976-10-25', 1, 'Campinas', 'Sou um professor empolgado', 'Héterossexual', 'Masculino', 'Mulher', '171.jpg', 6, '2024-11-28 10:32:23'),
(172, 'mamagoul123@gmail.com', 'b9650d275b449d347b324fda8a64b66788a64ee2f2e27f5e1b4d8957d6a94957', 'Marcella Moreira Goulart', '2006-10-09', 1, 'Campinas', '.', 'Prefiro não informar', 'Feminino', 'Sem preferência', '172.jpg', 6, '2024-11-28 10:40:05'),
(173, 'pedrorpiccolojudo@gmail.com', 'b9650d275b449d347b324fda8a64b66788a64ee2f2e27f5e1b4d8957d6a94957', 'Pedro Ricardo de Macedo Piccolo', '2006-01-19', 1, 'Campinas', 'Jogador de ff', 'Héterossexual', 'Masculino', 'Homem', '173.jpg', 6, '2024-11-28 10:39:59'),
(174, 'higorazevedomatias@gmail.com', 'f57fe6fd2b2bcd49215978ec823788edb0059a07db0b23bb505532fbcf2ccde1', 'Higor Matias de Azevedo ', '2005-12-05', 2, 'New York', 'Blessed ✨', 'Héterossexual', 'Masculino', 'Mulher', '174.jpg', 6, '2024-11-28 10:47:42'),
(175, 'liviamarcalsouza@gmail.com', '4e3b612c274d3cbb91f06d55f70e98b411a8d953f5130b0f1d105167bfd073b7', 'Lívia Marçal de Souza', '2006-07-04', 1, 'Campinas', '.', 'Héterossexual', 'Feminino', 'Homem', '175.jpg', 6, '2024-11-28 10:50:30'),
(176, 'gabrielbuzato05@gmail.com', '633962f7e3cd6e5aa026a149049cc6044d0cbe2b96585e06ec471158e868206e', 'Gabriel David de Godoy Buzato ', '2006-05-05', 3, 'Jalalabad', 'Gosto de viajar e de carros', 'Héterossexual', 'Masculino', 'Mulher', '176.jpg', 6, '2024-11-28 10:52:22'),
(177, 'vkaua8213@gmail.com', '44a6c898a276a0dbb943815ba0c2ac5c1e4a86df5d1290cc5cd3f90fe2ef7a2c', 'Kauã Victor De Oliveira Queiroz', '2006-09-06', 1, 'Campinas', 'Anaozim', 'Héterossexual', 'Masculino', 'Mulher', '177.jpg', 6, '2024-11-28 10:55:40'),
(178, 'gabrielcampanini1@gmail.com', 'c98a3cf8ba24b3c8786863c619964329f8e95af99f88a1f9a3ecca3579ce5dc1', 'Gabriel passinho dos romanos ', '2005-10-03', 3, 'Jalalabad', 'Vivendo e aprendendo 🙌🏼💪🏼🗣️🧠', 'Héterossexual', 'Masculino', 'Homem', '178.jpg', 6, '2024-11-28 10:55:37'),
(179, 'miguelglingani@gmail.com', 'c0f9dd70bc1e756102407db97d747451a7e19b3a836c5b24c733fa47d6e3c24e', 'Miguel Glingani', '2006-11-01', 1, 'Campinas', 'VRUMMMMMMMMMMMM VRUMMMM VRUMMMMMMMMMMMmmmmm', 'Bissexual', 'Masculino', 'Sem preferência', '179.jpg', 6, '2024-11-28 11:06:29'),
(180, 'mateusluis1860@gmail.com', '6238150a1175ccb6845df6a1f2394fcc1c179fc431f48edfa1b34c7b7f39e51e', 'Mateus Luís da Silva ', '2006-03-28', 1, 'Campinas', 'Mateus Luís ⚽ | Atacante do Corinthians ⚫⚪ | Campeão com o Timão 🏆 | Gols, raça e dedicação em cada partida | #VaiCorinthians\"', 'Homossexual', 'Prefiro não informar', 'Sem preferência', '180.jpg', 6, '2024-11-28 11:06:38'),
(181, 'gigicarvalho25@gmail.com', 'cc1076e2230e599ab80e32c8233d72b19a9ae80cd05c78d4b84c467ceaf2fb92', 'Giovanna Carvalho ', '2006-09-01', 2, 'New York', '...', 'Bissexual', 'Feminino', 'Sem preferência', '181.jpg', 6, '2024-11-28 11:10:15'),
(182, 'jose@email.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Jose Araujo', '2000-02-12', 1, 'Campinas', 'ola eu sou o Jose e adoro musica', 'Héterossexual', 'Masculino', 'Mulher', '182.jpg', 6, '2024-11-28 12:41:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbusuarios_bloqueados`
--

CREATE TABLE `tbusuarios_bloqueados` (
  `idUsuario` int(11) NOT NULL,
  `idUsuarioBloqueado` int(11) NOT NULL,
  `dataDoBloqueio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbusuario_responde_pergunta`
--

CREATE TABLE `tbusuario_responde_pergunta` (
  `idUsuario` int(11) NOT NULL,
  `idPergunta` int(11) NOT NULL,
  `respostaUsuario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbusuario_responde_pergunta`
--

INSERT INTO `tbusuario_responde_pergunta` (`idUsuario`, `idPergunta`, `respostaUsuario`) VALUES
(164, 38, 'Super velocidade'),
(164, 41, 'Sonhei que estava na lua'),
(164, 44, 'Criar uma aplicativo de relacionamento baseado na personalidade da pessoa, e não na aparência'),
(164, 45, 'Todas as musicas existentes na face da Terra'),
(164, 47, 'Jogar futebol'),
(165, 38, 'Super força '),
(165, 40, 'Carne de panela'),
(165, 46, 'Um cachorro, mas um cachorro sem frescuras'),
(165, 50, 'Irmãos a obra'),
(165, 51, 'Uma viajem para a Europa'),
(166, 40, 'Caldo de jaca'),
(166, 41, 'Que estava morando no Brasil de novo'),
(166, 47, 'weffr f'),
(166, 49, 'erwerwcewecrrece'),
(166, 51, 'wercwececr'),
(167, 38, 'Super motocicleta 3000'),
(167, 40, 'Motor ckrackers (bolachas de motocicleta)'),
(168, 47, 'Dublar pokemons'),
(168, 50, 'Como treina seu dragaun'),
(169, 39, 'Aqui jaz aquele que nunca usou tiktok'),
(169, 45, 'Just dance'),
(170, 41, 'Sonhei que estava namorando e acordei no desespero '),
(170, 47, 'Abanar com as orelhas'),
(171, 40, 'Frango'),
(171, 44, 'Falar em publico no fundamental'),
(172, 39, ' Vou voltar pra te buscar viu more!'),
(172, 42, '💋, emoji de diva'),
(172, 49, 'Gumball'),
(172, 50, 'Pearl\n'),
(172, 52, 'Era vitoriana'),
(173, 38, 'velocidade porque eu ia ser rapido memo \n'),
(173, 40, 'lasanha\n'),
(173, 43, 'Homem aranha\n'),
(173, 46, 'Macaco\n'),
(173, 52, 'quando Jesus tava vivo\n'),
(174, 38, 'Soltar teia \n'),
(174, 39, 'Novo contratado do Vasco 2024-eternidade 🤝\n'),
(174, 40, 'Batata frita \n'),
(174, 41, 'Sonhei que estava entrando dentro de uma sacola e meu irmão amarrava uma linha e eu voava igual pipa 😎🤟🏻'),
(174, 42, '😎🤟🏻 é goti\n'),
(175, 39, 'Offline'),
(175, 40, 'Filé a parmegiana'),
(175, 45, 'Acende o farol - Tim Maia'),
(175, 46, 'Furão'),
(175, 50, 'Viva, a vida é uma festa!'),
(176, 40, 'Lasanha\n\n'),
(176, 46, 'Suricato'),
(176, 49, 'Leoncio '),
(176, 52, 'Quando Jesus ressuscitou \n'),
(177, 38, 'Invisibilidade'),
(177, 39, 'A confiança é uma mulher ingrata '),
(177, 40, 'Arroz, feijão e carne'),
(177, 41, 'Não o lembro\n'),
(177, 42, '🖐😜🤚 o neymá'),
(178, 38, 'Invisible '),
(178, 39, '\"Acho que morri\"\n'),
(178, 40, 'Arroz e feijão\n'),
(178, 41, 'Dormi no sonho\n\n'),
(178, 44, 'Correr da polícia \n'),
(179, 38, 'Soltar cerveja pelas mãos'),
(179, 39, 'Morreu de: Acabou a cerveja'),
(179, 40, 'Cerveja'),
(179, 41, 'Que acabou a cerveja'),
(179, 42, '🍺 cerveja'),
(180, 38, 'Invisível a'),
(180, 39, 'A inveja é igual carvão aceso queima apagado suja…. não seja um carvão'),
(180, 40, 'Strogonoff '),
(180, 41, 'Caindo em um buraco sem fundo'),
(180, 43, 'Homem aranha 🕸️🕸️'),
(181, 38, 'Respirar embaixo da água e falar com os animais aquáticos, pra eu ser uma verdadeira sereia 😍🧜‍♀️\n'),
(181, 42, '😍 \nPq eh o ideal pra usar com ironia e usar pra ser meiga kkkkkk'),
(181, 46, 'Acho q uma coruja pq são mto fofas e inteligentes\n'),
(181, 49, 'A Bela de \"A Bela e a Fera\" pq ela é pobre e gosta de ler '),
(182, 38, 'Poder de te esquecer da minha mente'),
(182, 51, 'Um saxofone');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbcantadas`
--
ALTER TABLE `tbcantadas`
  ADD PRIMARY KEY (`idCantada`),
  ADD KEY `idRemetente` (`idRemetente`),
  ADD KEY `idDestinatario` (`idDestinatario`);

--
-- Índices de tabela `tbfotos_usuarios`
--
ALTER TABLE `tbfotos_usuarios`
  ADD PRIMARY KEY (`idFoto`),
  ADD KEY `idUsuario` (`idUsuario`) USING BTREE;

--
-- Índices de tabela `tbhashtags`
--
ALTER TABLE `tbhashtags`
  ADD PRIMARY KEY (`idHashtag`,`idUsuario`),
  ADD KEY `usuario_id_fk` (`idUsuario`);

--
-- Índices de tabela `tbmatches`
--
ALTER TABLE `tbmatches`
  ADD PRIMARY KEY (`idUsuario`,`idUsuarioMatch`),
  ADD KEY `usuario_id4_fk` (`idUsuario`),
  ADD KEY `usuario_id5_fk` (`idUsuarioMatch`);

--
-- Índices de tabela `tbmensagens`
--
ALTER TABLE `tbmensagens`
  ADD PRIMARY KEY (`idMsg`),
  ADD KEY `remetente_id_fk` (`idRemetente`),
  ADD KEY `destinatario_id_fk` (`idDestinatario`);

--
-- Índices de tabela `tbpaises`
--
ALTER TABLE `tbpaises`
  ADD PRIMARY KEY (`idPais`);

--
-- Índices de tabela `tbperguntas`
--
ALTER TABLE `tbperguntas`
  ADD PRIMARY KEY (`idPergunta`);

--
-- Índices de tabela `tbusuarios`
--
ALTER TABLE `tbusuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `pais_id_fk` (`idPaisUsuario`);

--
-- Índices de tabela `tbusuarios_bloqueados`
--
ALTER TABLE `tbusuarios_bloqueados`
  ADD PRIMARY KEY (`idUsuario`,`idUsuarioBloqueado`);

--
-- Índices de tabela `tbusuario_responde_pergunta`
--
ALTER TABLE `tbusuario_responde_pergunta`
  ADD PRIMARY KEY (`idUsuario`,`idPergunta`),
  ADD KEY `usuario2_id_fk` (`idUsuario`),
  ADD KEY `pergunta_id_fk` (`idPergunta`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbcantadas`
--
ALTER TABLE `tbcantadas`
  MODIFY `idCantada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `tbfotos_usuarios`
--
ALTER TABLE `tbfotos_usuarios`
  MODIFY `idFoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT de tabela `tbhashtags`
--
ALTER TABLE `tbhashtags`
  MODIFY `idHashtag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=419;

--
-- AUTO_INCREMENT de tabela `tbmensagens`
--
ALTER TABLE `tbmensagens`
  MODIFY `idMsg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de tabela `tbpaises`
--
ALTER TABLE `tbpaises`
  MODIFY `idPais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT de tabela `tbperguntas`
--
ALTER TABLE `tbperguntas`
  MODIFY `idPergunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `tbusuarios`
--
ALTER TABLE `tbusuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbcantadas`
--
ALTER TABLE `tbcantadas`
  ADD CONSTRAINT `tbcantadas_ibfk_1` FOREIGN KEY (`idRemetente`) REFERENCES `tbusuarios` (`idUsuario`),
  ADD CONSTRAINT `tbcantadas_ibfk_2` FOREIGN KEY (`idDestinatario`) REFERENCES `tbusuarios` (`idUsuario`);

--
-- Restrições para tabelas `tbhashtags`
--
ALTER TABLE `tbhashtags`
  ADD CONSTRAINT `usuario_id_fk` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuarios` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tbmatches`
--
ALTER TABLE `tbmatches`
  ADD CONSTRAINT `usuario_id4_fk` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuarios` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_id5_fk` FOREIGN KEY (`idUsuarioMatch`) REFERENCES `tbusuarios` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tbmensagens`
--
ALTER TABLE `tbmensagens`
  ADD CONSTRAINT `destinatario_id_fk` FOREIGN KEY (`idDestinatario`) REFERENCES `tbusuarios` (`idUsuario`),
  ADD CONSTRAINT `remetente_id_fk` FOREIGN KEY (`idRemetente`) REFERENCES `tbusuarios` (`idUsuario`);

--
-- Restrições para tabelas `tbusuarios`
--
ALTER TABLE `tbusuarios`
  ADD CONSTRAINT `pais_id_fk` FOREIGN KEY (`idPaisUsuario`) REFERENCES `tbpaises` (`idPais`);

--
-- Restrições para tabelas `tbusuario_responde_pergunta`
--
ALTER TABLE `tbusuario_responde_pergunta`
  ADD CONSTRAINT `pergunta_id_fk` FOREIGN KEY (`idPergunta`) REFERENCES `tbperguntas` (`idPergunta`),
  ADD CONSTRAINT `usuario2_id_fk` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuarios` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
