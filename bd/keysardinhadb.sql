-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 06-Jan-2025 às 19:01
-- Versão do servidor: 8.3.0
-- versão do PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `keysardinhadb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '12', 1735924070),
('admin', '2', 1733413428),
('client', '11', 1733757148),
('client', '3', 1733413428),
('collaborator', '1', 1733413428);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('acessBackend', 2, 'Access to backend', NULL, NULL, 1733413428, 1733413428),
('addToCart', 2, 'Add games to cart', NULL, NULL, 1733413428, 1733413428),
('addToFavorites', 2, 'Add games to favorites', NULL, NULL, 1733413428, 1733413428),
('admin', 1, NULL, NULL, NULL, 1733413428, 1733413428),
('applyDiscount', 2, 'Apply discount coupons', NULL, NULL, 1733413428, 1733413428),
('checkout', 2, 'Checkout', NULL, NULL, 1733413428, 1733413428),
('client', 1, NULL, NULL, NULL, 1733413428, 1733413428),
('collaborator', 1, NULL, NULL, NULL, 1733413428, 1733413428),
('createCategory', 2, 'Create a category', NULL, NULL, 1733413428, 1733413428),
('createGame', 2, 'Create a game', NULL, NULL, 1733413428, 1733413428),
('createGameKey', 2, 'Create a game key', NULL, NULL, 1733413428, 1733413428),
('createPaymentMethod', 2, 'Create a payment method', NULL, NULL, 1733413428, 1733413428),
('createUser', 2, 'Create a user', NULL, NULL, 1733413428, 1733413428),
('deleteCategory', 2, 'Delete a category', NULL, NULL, 1733413428, 1733413428),
('deleteGame', 2, 'Delete a game', NULL, NULL, 1733413428, 1733413428),
('deleteGameKey', 2, 'Delete a game key', NULL, NULL, 1733413428, 1733413428),
('deletePaymentMethod', 2, 'Delete a payment method', NULL, NULL, 1733413428, 1733413428),
('deleteUser', 2, 'Delete a user', NULL, NULL, 1733413428, 1733413428),
('generateReports', 2, 'Generate sales reports', NULL, NULL, 1733413428, 1733413428),
('readCategory', 2, 'Read category details', NULL, NULL, 1733413428, 1733413428),
('readGame', 2, 'Read game details', NULL, NULL, 1733413428, 1733413428),
('readGameKey', 2, 'Read game key details', NULL, NULL, 1733413428, 1733413428),
('readPaymentMethod', 2, 'Read payment method details', NULL, NULL, 1733413428, 1733413428),
('readUser', 2, 'Read user details', NULL, NULL, 1733413428, 1733413428),
('removeFromCart', 2, 'Remove games from cart', NULL, NULL, 1733413428, 1733413428),
('updateCategory', 2, 'Update a category', NULL, NULL, 1733413428, 1733413428),
('updateGame', 2, 'Update a game', NULL, NULL, 1733413428, 1733413428),
('updateGameKey', 2, 'Update a game key', NULL, NULL, 1733413428, 1733413428),
('updatePaymentMethod', 2, 'Update a payment method', NULL, NULL, 1733413428, 1733413428),
('updateUser', 2, 'Update a user', NULL, NULL, 1733413428, 1733413428),
('viewGame', 2, 'View game details', NULL, NULL, 1733413428, 1733413428),
('viewOrders', 2, 'View orders', NULL, NULL, 1733413428, 1733413428),
('viewSalesStatistics', 2, 'View sales statistics', NULL, NULL, 1733413428, 1733413428);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('collaborator', 'acessBackend'),
('client', 'addToCart'),
('client', 'addToFavorites'),
('client', 'applyDiscount'),
('client', 'checkout'),
('admin', 'collaborator'),
('collaborator', 'createCategory'),
('collaborator', 'createGame'),
('collaborator', 'createGameKey'),
('admin', 'createPaymentMethod'),
('admin', 'createUser'),
('collaborator', 'deleteCategory'),
('collaborator', 'deleteGame'),
('collaborator', 'deleteGameKey'),
('admin', 'deletePaymentMethod'),
('admin', 'deleteUser'),
('admin', 'generateReports'),
('collaborator', 'readCategory'),
('client', 'readGame'),
('collaborator', 'readGame'),
('collaborator', 'readGameKey'),
('admin', 'readPaymentMethod'),
('admin', 'readUser'),
('client', 'removeFromCart'),
('collaborator', 'updateCategory'),
('collaborator', 'updateGame'),
('collaborator', 'updateGameKey'),
('admin', 'updatePaymentMethod'),
('admin', 'updateUser'),
('admin', 'viewOrders'),
('collaborator', 'viewSalesStatistics');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

DROP TABLE IF EXISTS `carrinho`;
CREATE TABLE IF NOT EXISTS `carrinho` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_criacao` datetime DEFAULT NULL,
  `cupao_id` int DEFAULT NULL,
  `utilizadorperfil_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cupao_id` (`cupao_id`),
  KEY `utilizadorperfil_id` (`utilizadorperfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `carrinho`
--

INSERT INTO `carrinho` (`id`, `data_criacao`, `cupao_id`, `utilizadorperfil_id`) VALUES
(1, '2024-12-17 17:31:48', NULL, 11),
(3, NULL, NULL, 12),
(40, '2025-01-06 15:53:51', NULL, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`) VALUES
(1, 'Ação'),
(2, 'Terror'),
(4, 'Ficção'),
(5, 'FPS'),
(6, 'Aventura'),
(7, 'Estratégia'),
(8, 'Simulação'),
(9, 'RPG'),
(10, 'Luta'),
(11, 'Puzzle'),
(12, 'Multiplayer'),
(13, 'CO-OP');

-- --------------------------------------------------------

--
-- Estrutura da tabela `chavedigital`
--

DROP TABLE IF EXISTS `chavedigital`;
CREATE TABLE IF NOT EXISTS `chavedigital` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chaveativacao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` enum('usada','nao usada') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `datavenda` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `chavedigital`
--

INSERT INTO `chavedigital` (`id`, `chaveativacao`, `estado`, `produto_id`, `datavenda`) VALUES
(1, '7U9OM7RWLK', 'usada', 40, NULL),
(2, 'LO8F4LPTN9', 'usada', 3, '2025-01-03'),
(3, '09GMJU99BJ', 'usada', 2, '2025-01-06'),
(4, 'QW3BFL2RKC', 'usada', 40, '2024-12-28'),
(5, 'D10LB4C4A7', 'usada', 40, '2024-12-29'),
(6, 'ARNVRPRQNU', 'usada', 40, '2025-01-02'),
(7, 'ARNVRPRQNU', 'usada', 40, '2025-01-02'),
(8, 'UA7MPSVR53', 'usada', 40, '2025-01-02'),
(9, 'Z50D9YJZWN', 'usada', 40, '2025-01-02'),
(10, 'D4KNC7KI54', 'usada', 40, '2025-01-02'),
(11, 'IGN4OW3LAE', 'nao usada', 40, NULL),
(12, '1TLG2O6JUF', 'usada', 3, '2025-01-03'),
(13, 'ASTQDLU52F', 'usada', 3, '2025-01-03'),
(14, '6H1H95YJID', 'nao usada', 3, NULL),
(15, 'TJ6LM2FMTV', 'usada', 4, '2025-01-03'),
(16, '2C9M58FA7Z', 'usada', 4, '2025-01-03'),
(17, 'P43IO5AJUF', 'usada', 4, '2025-01-03'),
(18, 'FXIX46A38V', 'usada', 2, '2025-01-06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario`
--

DROP TABLE IF EXISTS `comentario`;
CREATE TABLE IF NOT EXISTS `comentario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avaliacao` int DEFAULT NULL,
  `datacriacao` date DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `utilizadorperfil_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`),
  KEY `utilizadorperfil_id` (`utilizadorperfil_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cupao`
--

DROP TABLE IF EXISTS `cupao`;
CREATE TABLE IF NOT EXISTS `cupao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `datavalidade` datetime DEFAULT NULL,
  `valor` int DEFAULT NULL,
  `ativo` tinyint DEFAULT NULL,
  `codigo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cupao`
--

INSERT INTO `cupao` (`id`, `datavalidade`, `valor`, `ativo`, `codigo`) VALUES
(1, '2025-12-31 00:00:00', 30, 0, 'bolas2024'),
(2, '2025-07-30 00:00:00', 54, 0, 'balas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cupaousado`
--

DROP TABLE IF EXISTS `cupaousado`;
CREATE TABLE IF NOT EXISTS `cupaousado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cupao_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cupao_id` (`cupao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `desconto`
--

DROP TABLE IF EXISTS `desconto`;
CREATE TABLE IF NOT EXISTS `desconto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `percentagem` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `desconto`
--

INSERT INTO `desconto` (`id`, `percentagem`) VALUES
(1, 50.00),
(2, 0.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `descontofatura`
--

DROP TABLE IF EXISTS `descontofatura`;
CREATE TABLE IF NOT EXISTS `descontofatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `desconto_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `desconto_id` (`desconto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fatura`
--

DROP TABLE IF EXISTS `fatura`;
CREATE TABLE IF NOT EXISTS `fatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `datafatura` datetime DEFAULT NULL,
  `totalciva` decimal(10,2) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `estado` enum('pago','pendente','cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descontovalor` float DEFAULT NULL,
  `datapagamento` datetime NOT NULL,
  `utilizadorperfil_id` int DEFAULT NULL,
  `metodopagamento_id` int DEFAULT NULL,
  `desconto_id` int DEFAULT NULL,
  `cupao_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilizadorperfil_id` (`utilizadorperfil_id`),
  KEY `metodopagamento_id` (`metodopagamento_id`),
  KEY `desconto_id` (`desconto_id`),
  KEY `cupao_id` (`cupao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fatura`
--

INSERT INTO `fatura` (`id`, `datafatura`, `totalciva`, `subtotal`, `valor_total`, `estado`, `descontovalor`, `datapagamento`, `utilizadorperfil_id`, `metodopagamento_id`, `desconto_id`, `cupao_id`) VALUES
(14, '2024-12-28 22:17:51', 6.90, 30, 30.00, 'pago', 0, '2024-12-28 22:17:51', 11, 2, NULL, NULL),
(15, '2024-12-28 22:23:43', 6.90, 30, 30.00, 'pago', 0, '2024-12-28 22:23:43', 11, 2, NULL, NULL),
(16, '2024-12-29 18:18:09', 6.90, 30, 30.00, 'pago', 0, '2024-12-29 18:18:09', 11, 2, NULL, NULL),
(17, '2025-01-02 20:38:26', 13.80, 60, 60.00, 'pago', 0, '2025-01-02 20:38:26', 11, 2, NULL, NULL),
(18, '2025-01-02 21:37:06', 13.80, 60, 60.00, 'pago', 0, '2025-01-02 21:37:06', 11, 2, NULL, NULL),
(19, '2025-01-02 21:52:40', 13.80, 60, 60.00, 'pago', 0, '2025-01-02 21:52:40', 11, 2, NULL, NULL),
(20, '2025-01-03 18:00:37', 0.00, 0, 0.00, 'pago', 0, '2025-01-03 18:00:37', 12, 2, NULL, NULL),
(21, '2025-01-03 18:03:16', 6.90, 30, 30.00, 'pago', 0, '2025-01-03 18:03:17', 12, 2, NULL, NULL),
(22, '2025-01-03 18:13:11', 0.00, 0, 0.00, 'pago', 0, '2025-01-03 18:13:11', 12, 2, NULL, NULL),
(23, '2025-01-03 18:13:58', 0.00, 0, 0.00, 'pago', 0, '2025-01-03 18:13:58', 12, 2, NULL, NULL),
(24, '2025-01-03 18:17:09', 6.90, 30, 30.00, 'pago', 0, '2025-01-03 18:17:09', 12, 2, NULL, NULL),
(25, '2025-01-06 18:50:10', 0.00, 0, 0.00, 'pago', 0, '2025-01-06 18:50:10', 12, 2, NULL, NULL),
(26, '2025-01-06 18:53:30', 0.00, 0, 0.00, 'pago', 0, '2025-01-06 18:53:30', 12, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizadorperfil_id` int NOT NULL,
  `produto_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utilizadorperfil_id` (`utilizadorperfil_id`),
  KEY `produto_id` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `favoritos`
--

INSERT INTO `favoritos` (`id`, `utilizadorperfil_id`, `produto_id`) VALUES
(17, 11, 40);

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagem`
--

DROP TABLE IF EXISTS `imagem`;
CREATE TABLE IF NOT EXISTS `imagem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `caminhoimagem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomeimagem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `iva`
--

DROP TABLE IF EXISTS `iva`;
CREATE TABLE IF NOT EXISTS `iva` (
  `id` int NOT NULL AUTO_INCREMENT,
  `taxa` decimal(5,2) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `iva`
--

INSERT INTO `iva` (`id`, `taxa`, `descricao`, `ativo`) VALUES
(1, 23.00, 'Imposto Portugal', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `linhacarrinho`
--

DROP TABLE IF EXISTS `linhacarrinho`;
CREATE TABLE IF NOT EXISTS `linhacarrinho` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int DEFAULT NULL,
  `preco_unitario` decimal(10,2) DEFAULT NULL,
  `carrinho_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carrinho_id` (`carrinho_id`),
  KEY `produto_id` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `linhafatura`
--

DROP TABLE IF EXISTS `linhafatura`;
CREATE TABLE IF NOT EXISTS `linhafatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int DEFAULT NULL,
  `precounitario` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `fatura_id` int DEFAULT NULL,
  `desconto_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `iva_id` int DEFAULT NULL,
  `chavedigital_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fatura_id` (`fatura_id`),
  KEY `cupao_id` (`desconto_id`),
  KEY `produto_id` (`produto_id`),
  KEY `iva_id` (`iva_id`),
  KEY `chavedigital_id` (`chavedigital_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `linhafatura`
--

INSERT INTO `linhafatura` (`id`, `quantidade`, `precounitario`, `subtotal`, `fatura_id`, `desconto_id`, `produto_id`, `iva_id`, `chavedigital_id`) VALUES
(15, 1, 30.00, 30.00, 14, 1, 40, 1, NULL),
(16, 1, 30.00, 30.00, 15, 1, 40, 1, 4),
(17, 1, 30.00, 30.00, 16, 1, 40, 1, 5),
(18, 2, 30.00, 60.00, 17, 1, 40, 1, 6),
(19, 2, 30.00, 60.00, 18, 1, 40, 1, 8),
(20, 1, 30.00, 30.00, 19, 1, 40, 1, 9),
(21, 1, 30.00, 30.00, 19, 1, 40, 1, 10),
(22, 1, 0.00, 0.00, 23, 2, 4, 1, 16),
(23, 1, 0.00, 0.00, 23, 2, 4, 1, 17),
(24, 1, 30.00, 30.00, 24, 2, 3, 1, 2),
(25, 1, 0.00, 0.00, 25, 1, 2, 1, 18),
(26, 1, 0.00, 0.00, 26, 1, 2, 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `metodopagamento`
--

DROP TABLE IF EXISTS `metodopagamento`;
CREATE TABLE IF NOT EXISTS `metodopagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomemetodopagamento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `metodopagamento`
--

INSERT INTO `metodopagamento` (`id`, `nomemetodopagamento`, `descricao`) VALUES
(1, 'Paypal', 'Utilize o paypal para pagar de forma segura e simples!'),
(2, 'MBway', 'Pagamento com o mbway'),
(3, 'Cartão Crédito/Débito', 'Pagamento com cartão');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1730133425),
('m130524_201442_init', 1730133427),
('m140506_102106_rbac_init', 1730133782),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1730133782),
('m180523_151638_rbac_updates_indexes_without_prefix', 1730133782),
('m190124_110200_add_verification_token_column_to_user_table', 1730133427),
('m200409_110543_rbac_update_mssql_trigger', 1730133782);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pontosfidelidade`
--

DROP TABLE IF EXISTS `pontosfidelidade`;
CREATE TABLE IF NOT EXISTS `pontosfidelidade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int NOT NULL,
  `dataquisicao` datetime DEFAULT NULL,
  `utilizadorperfil_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilizadorperfil_id` (`utilizadorperfil_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `preco` decimal(10,2) DEFAULT NULL,
  `imagem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'imagemdefault.jpg',
  `datalancamento` date DEFAULT NULL,
  `stockdisponivel` int DEFAULT NULL,
  `categoria_id` int DEFAULT NULL,
  `desconto_id` int DEFAULT NULL,
  `iva_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `desconto_id` (`desconto_id`),
  KEY `iva_id` (`iva_id`)
) ;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `nome`, `descricao`, `preco`, `imagem`, `datalancamento`, `stockdisponivel`, `categoria_id`, `desconto_id`, `iva_id`) VALUES
(1, 'Pai natal teste', 'dsadsa', 20.00, 'imagem_2025-01-02_173714123-removebg-preview.png', '2013-04-03', 10, 12, 1, 1),
(2, 'Counter-Strike 2', 'Jogo popular na Steam', 0.00, 'cs2.png', NULL, 0, 1, 1, 1),
(3, 'PUBG: BATTLEGROUNDS', 'Jogo popular na Steam', 30.00, 'imagemdefault.jpg', '2013-04-03', 10, 5, 2, 1),
(4, 'Marvel Rivals', 'Jogo popular na Steam', 0.00, 'imagemdefault.jpg', '2013-04-03', 0, 10, 2, 1),
(5, 'Dota 2', 'Jogo popular na Steam', 0.00, 'imagemdefault.jpg', NULL, 0, 1, 1, 1),
(6, 'Wallpaper Engine', 'Jogo popular na Steam', 0.00, 'imagemdefault.jpg', NULL, 0, 1, 1, 1),
(7, 'Path of Exile 2', 'Jogo popular na Steam', 0.00, 'imagemdefault.jpg', NULL, 0, 1, 1, 1),
(12, 'Pai natal teste2321', '321321', 312312.00, 'codbo6.png', '2013-04-03', 10, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'exter', 'LppKrsgB_KrjbRPdtE2ntpX2gv4kfFfw', '$2y$13$MsyiN.B6707iikEOrYyMFu7w1hgpXggDksI2WU.LVbjS3s37OgHKm', NULL, 'exter@gmail.com', 10, 1730134030, 1730134030, 'BCytMqWfnWDvnIUGvd1DxoHcIhVDanuS_1730134030'),
(2, 'rodrigo', 'ha89F14s796FEI8TL6Qt_w7jtCzkIF3q', '$2y$13$uo0CEi2SSvoghcAsfQXe5.I1Wu7UA.NdVzUSTt0Zpg8B.dYiCH2EG', NULL, 'roncas61@gmail.com', 10, 1731336149, 1731336149, 'sSDw8gYdxTxVEVPLaCOfTmMHXR4WGL_1_1731336149'),
(5, 'Henrique', 'uHOM1LygvkzurOd--Zk_mQ8BclV4bi1G', '$2y$13$pGtH2pd.e44cjNs5D6czx.uAtkH8bSXNciGJA5p5QtoAGVsYy1FaC', NULL, 'henrique@gmail.com', 9, 1731342999, 1731342999, 'qd36kyR9_uJ7O5bKzpqWzV9UkmEnKvip_1731342999'),
(7, 'fabiocigano', 'wzeEg9gtRmlYAm7Z1DZnldnUGiuJjgsD', '$2y$13$oXr2f3eC0AB05WeRcih4oOY1RUwzZPM5fskH8c2QSqDsEvve9Hd/S', NULL, 'ciganao@gmail.com', 10, 1731346534, 1731346534, 'UwJTF99MTI0mtvPB8Z_BZ7pS-zka1A8G_1731346534'),
(8, 'admin', 'uETxhEOxShGzNuVjxPGDTovZ6sYYVj9A', '$2y$13$W3VoHTl7tfxLwpgSjvk.cO4ndOUiDLxezkP08DXGgvDSmMfj0xmJG', NULL, 'admin@gmail.com', 10, 1731347815, 1731347815, 'ZMJAr-aeaX3TyjUJWsGeXX6yDkb1jSWs_1731347815'),
(9, 'Henrique1', 'qXd2dAC_fD7QqGTZBj6JFiA4xDO1cjYX', '$2y$13$Si4CSdM93HHVbqBwQFr4ZOf60l1Ktt1h0AS/dU9Ga2qjhuHIq3no6', NULL, 'henriquecigano@gmail.com', 10, 1731412566, 1731412566, 'VJtb8lTN7_K1ttS4skCHWtS8oSUdQGNC_1731412566'),
(10, 'ricardo1', 'S2f6bt1cYvWXF-DOG9KGXEh1E5VIDqZJ', '$2y$13$KdHLihIcMo/IMy09W1.s5.4lgsWYRkkwYYkml.5OlEcCtpUB0IB/e', NULL, 'roberto@gmail.com', 10, 1731671125, 1731671125, 'Bf9lbheA-nEPost1sHANE-vuaE3A6J0d_1731671125'),
(11, 'roberto1', 'P-sXUKQLnMoYMyd41i8DC87KZxPHuSog', '$2y$13$4.swPvAAskOKujYehdixh.ZBmsX7ApHOrDmP6kXPFu9t3ABzIFZ/y', NULL, 'roberto1@gmail.com', 10, 1733757148, 1733757148, 'tdRW4zHnic8aECaUyz2XvHCooY-5s8kH_1733757148'),
(12, 'UtilizadorTesteFuncional', 'iBLY4qs9CkyH-6zF1RnLzbKT0CkC0mxU', '$2y$13$PQe9cT0MgsFhBpQc9nAfbeBE/.X7Qjr.rKu2/YeNpurF/MZjB2KDK', NULL, 'UtilizadorTesteFuncional@gmail.com', 10, 1735924070, 1735924070, 'q2O499wZ2hbnYRjinKTEBLYB1DQvxqxW_1735924070');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadorperfil`
--

DROP TABLE IF EXISTS `utilizadorperfil`;
CREATE TABLE IF NOT EXISTS `utilizadorperfil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dataregisto` datetime DEFAULT NULL,
  `pontosacumulados` int DEFAULT NULL,
  `carrinho_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carrinho_id` (`carrinho_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizadorperfil`
--

INSERT INTO `utilizadorperfil` (`id`, `nome`, `dataregisto`, `pontosacumulados`, `carrinho_id`) VALUES
(4, NULL, '2024-11-11 15:28:32', 0, NULL),
(5, 'Ricardo', '2024-11-11 16:36:39', 0, NULL),
(7, NULL, '2024-11-11 17:35:34', 0, NULL),
(8, NULL, '2024-11-11 17:56:55', 0, NULL),
(9, NULL, '2024-11-12 11:56:06', 0, NULL),
(10, NULL, '2024-11-15 11:45:25', 0, NULL),
(11, NULL, '2024-12-09 15:12:28', 0, NULL),
(12, NULL, '2025-01-03 17:07:50', 0, NULL);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`cupao_id`) REFERENCES `cupao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carrinho_ibfk_2` FOREIGN KEY (`utilizadorperfil_id`) REFERENCES `utilizadorperfil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `chavedigital`
--
ALTER TABLE `chavedigital`
  ADD CONSTRAINT `chavedigital_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `fatura`
--
ALTER TABLE `fatura`
  ADD CONSTRAINT `fatura_ibfk_2` FOREIGN KEY (`desconto_id`) REFERENCES `desconto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fatura_ibfk_3` FOREIGN KEY (`metodopagamento_id`) REFERENCES `metodopagamento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fatura_ibfk_4` FOREIGN KEY (`utilizadorperfil_id`) REFERENCES `utilizadorperfil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fatura_ibfk_5` FOREIGN KEY (`cupao_id`) REFERENCES `cupao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`utilizadorperfil_id`) REFERENCES `utilizadorperfil` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Limitadores para a tabela `linhacarrinho`
--
ALTER TABLE `linhacarrinho`
  ADD CONSTRAINT `linhacarrinho_ibfk_1` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinho` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `linhacarrinho_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `linhafatura`
--
ALTER TABLE `linhafatura`
  ADD CONSTRAINT `linhafatura_ibfk_2` FOREIGN KEY (`fatura_id`) REFERENCES `fatura` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `linhafatura_ibfk_3` FOREIGN KEY (`iva_id`) REFERENCES `iva` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `linhafatura_ibfk_4` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `linhafatura_ibfk_5` FOREIGN KEY (`desconto_id`) REFERENCES `desconto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `linhafatura_ibfk_6` FOREIGN KEY (`chavedigital_id`) REFERENCES `chavedigital` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`desconto_id`) REFERENCES `desconto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produto_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produto_ibfk_3` FOREIGN KEY (`iva_id`) REFERENCES `iva` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
