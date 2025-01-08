-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 08-Jan-2025 às 23:08
-- Versão do servidor: 8.2.0
-- versão do PHP: 8.1.26

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
('admin', '13', 1736361110),
('admin', '14', 1736365120),
('admin', '15', 1736375087),
('admin', '2', 1733413428),
('client', '11', 1733757148),
('client', '17', 1736375723),
('client', '3', 1733413428),
('collaborator', '1', 1733413428),
('collaborator', '16', 1736375673);

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `chavedigital`
--

INSERT INTO `chavedigital` (`id`, `chaveativacao`, `estado`, `produto_id`, `datavenda`) VALUES
(5, 'D10LB4C4A7', 'nao usada', 2, '2024-12-29'),
(11, 'IGN4OW3LAE', 'nao usada', 5, NULL),
(19, '8TF43OV3HQ', 'nao usada', 2, NULL),
(20, 'AFSA9LWI3S', 'nao usada', 2, NULL),
(21, 'BFQQ1UOXVO', 'nao usada', 2, NULL),
(23, 'L0FAOE9NNG', 'nao usada', 3, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(26, '2025-01-06 18:53:30', 0.00, 0, 0.00, 'pago', 0, '2025-01-06 18:53:30', 12, 2, NULL, NULL),
(27, '2025-01-08 20:00:42', 20.70, 90, 90.00, 'pago', 0, '2025-01-08 20:00:42', 12, 1, NULL, NULL),
(28, '2025-01-08 20:04:05', 6.90, 30, 30.00, 'pago', 0, '2025-01-08 20:04:05', 12, 1, NULL, NULL),
(29, '2025-01-08 20:39:25', 6.90, 30, 30.00, 'pago', 0, '2025-01-08 20:39:25', 12, 2, NULL, NULL),
(30, '2025-01-08 20:39:46', 6.90, 30, 30.00, 'pago', 0, '2025-01-08 20:39:46', 12, 2, NULL, NULL),
(31, '2025-01-08 20:50:53', 6.90, 30, 30.00, 'pago', 0, '2025-01-08 20:50:53', 12, 2, NULL, NULL),
(32, '2025-01-08 20:52:19', 6.90, 30, 30.00, 'pago', 0, '2025-01-08 20:52:19', 12, 2, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `favoritos`
--

INSERT INTO `favoritos` (`id`, `utilizadorperfil_id`, `produto_id`) VALUES
(17, 11, 40),
(18, 13, 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `linhacarrinho`
--

INSERT INTO `linhacarrinho` (`id`, `quantidade`, `preco_unitario`, `carrinho_id`, `produto_id`) VALUES
(78, 1, 0.00, 3, 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(26, 1, 0.00, 0.00, 26, 1, 2, 1, 3),
(27, 1, 30.00, 30.00, 28, 2, 3, 1, 14),
(28, 1, 30.00, 30.00, 31, 2, 3, 1, 1),
(29, 1, 30.00, 30.00, 32, 2, 3, 1, 22);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `nome`, `descricao`, `preco`, `imagem`, `datalancamento`, `stockdisponivel`, `categoria_id`, `desconto_id`, `iva_id`) VALUES
(2, 'Counter-Strike 2', 'Jogo popular na Steam', 10.00, 'cs2.png', '2023-09-27', 4, 1, 1, 1),
(3, 'PUBG: BATTLEGROUNDS', 'Jogo popular na Steam', 30.00, 'pubg.png', '2013-04-03', 1, 5, 2, 1),
(4, 'Marvel Rivals', 'Jogo popular na Steam', 0.00, 'marvelrivals.jpg', '2013-04-03', 0, 5, 2, 1),
(5, 'Dota 2', 'Jogo popular na Steam', 10.00, 'dota2.jpg', '2013-07-09', 1, 1, 1, 1),
(6, 'Wallpaper Engine', 'Jogo popular na Steam', 0.00, 'imagemdefault.jpg', '2016-10-10', 0, 8, 1, 1),
(7, 'Path of Exile 2', 'Jogo popular na Steam', 0.00, 'pathexile2.jpg', '2024-12-06', 0, 6, 1, 1),
(16, 'FarCry 3', 'Jogo popular de 2013', 30.00, 'farcry3.jpg', '2012-11-28', 0, 7, 1, 1),
(17, 'The Witcher 3: Wild Hunt', 'Jogo de RPG de ação com um mundo aberto vasto e detalhado.', 59.99, 'witcher3.png', '2015-05-19', 0, 11, 2, 1),
(18, 'Minecraft', 'Jogo de construção e exploração em um mundo aberto com blocos.', 19.99, 'minecraft.jpg', '2011-11-18', 0, 6, 2, 1),
(19, 'Cyberpunk 2077', 'Jogo de RPG de ação no futuro distópico de Night City.', 69.99, 'cyberpunk77.jpg', '2020-12-10', 0, 1, 1, 1),
(20, 'Red Dead Redemption 2', 'Jogo de ação e aventura no Velho Oeste, com gráficos realistas.', 59.99, 'rdr2.jpg', '2018-10-26', 0, 6, 2, 1),
(21, 'FIFA 23', 'Jogo de futebol com realismo e modos de jogo diversificados.', 49.99, 'fifa23.jpg', '2022-09-30', 0, 4, 2, 1),
(22, 'Call of Duty: Modern Warfare 2', 'Jogo de tiro em primeira pessoa, com intensa ação e modos multiplayer.', 59.99, 'codmw2.jpg', '2022-10-28', 0, 5, 2, 1),
(23, 'Assassin\'s Creed Valhalla', 'Jogo de ação e aventura baseado na mitologia nórdica, com jogabilidade de mundo aberto.', 59.99, 'acvalhalla.jpg', '2020-11-10', 0, 1, 2, 1),
(24, 'Grand Theft Auto V', 'O famoso gta 5', 30.00, 'gtav.jpg', '2013-10-03', 0, 12, 1, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'exter', 'LppKrsgB_KrjbRPdtE2ntpX2gv4kfFfw', '$2y$13$MsyiN.B6707iikEOrYyMFu7w1hgpXggDksI2WU.LVbjS3s37OgHKm', NULL, 'exter@gmail.com', 10, 1730134030, 1730134030, 'BCytMqWfnWDvnIUGvd1DxoHcIhVDanuS_1730134030'),
(2, 'rodrigo', 'ha89F14s796FEI8TL6Qt_w7jtCzkIF3q', '$2y$13$uo0CEi2SSvoghcAsfQXe5.I1Wu7UA.NdVzUSTt0Zpg8B.dYiCH2EG', NULL, 'roncas61@gmail.com', 10, 1731336149, 1731336149, 'sSDw8gYdxTxVEVPLaCOfTmMHXR4WGL_1_1731336149'),
(5, 'Henrique', 'uHOM1LygvkzurOd--Zk_mQ8BclV4bi1G', '$2y$13$pGtH2pd.e44cjNs5D6czx.uAtkH8bSXNciGJA5p5QtoAGVsYy1FaC', NULL, 'henrique@gmail.com', 9, 1731342999, 1731342999, 'qd36kyR9_uJ7O5bKzpqWzV9UkmEnKvip_1731342999'),
(7, 'fabiocigano', 'wzeEg9gtRmlYAm7Z1DZnldnUGiuJjgsD', '$2y$13$oXr2f3eC0AB05WeRcih4oOY1RUwzZPM5fskH8c2QSqDsEvve9Hd/S', NULL, 'ciganao@gmail.com', 11, 1731346534, 1736376182, 'UwJTF99MTI0mtvPB8Z_BZ7pS-zka1A8G_1731346534'),
(8, 'admin', 'uETxhEOxShGzNuVjxPGDTovZ6sYYVj9A', '$2y$13$W3VoHTl7tfxLwpgSjvk.cO4ndOUiDLxezkP08DXGgvDSmMfj0xmJG', NULL, 'admin@gmail.com', 11, 1731347815, 1736376294, 'ZMJAr-aeaX3TyjUJWsGeXX6yDkb1jSWs_1731347815'),
(9, 'Henrique1', 'qXd2dAC_fD7QqGTZBj6JFiA4xDO1cjYX', '$2y$13$Si4CSdM93HHVbqBwQFr4ZOf60l1Ktt1h0AS/dU9Ga2qjhuHIq3no6', NULL, 'henriquecigano@gmail.com', 10, 1731412566, 1731412566, 'VJtb8lTN7_K1ttS4skCHWtS8oSUdQGNC_1731412566'),
(10, 'ricardo1', 'S2f6bt1cYvWXF-DOG9KGXEh1E5VIDqZJ', '$2y$13$KdHLihIcMo/IMy09W1.s5.4lgsWYRkkwYYkml.5OlEcCtpUB0IB/e', NULL, 'roberto@gmail.com', 10, 1731671125, 1731671125, 'Bf9lbheA-nEPost1sHANE-vuaE3A6J0d_1731671125'),
(11, 'roberto1', 'P-sXUKQLnMoYMyd41i8DC87KZxPHuSog', '$2y$13$4.swPvAAskOKujYehdixh.ZBmsX7ApHOrDmP6kXPFu9t3ABzIFZ/y', NULL, 'roberto1@gmail.com', 10, 1733757148, 1733757148, 'tdRW4zHnic8aECaUyz2XvHCooY-5s8kH_1733757148'),
(12, 'UtilizadorTesteFuncional', 'iBLY4qs9CkyH-6zF1RnLzbKT0CkC0mxU', '$2y$13$PQe9cT0MgsFhBpQc9nAfbeBE/.X7Qjr.rKu2/YeNpurF/MZjB2KDK', NULL, 'UtilizadorTesteFuncional@gmail.com', 10, 1735924070, 1735924070, 'q2O499wZ2hbnYRjinKTEBLYB1DQvxqxW_1735924070'),
(13, 'igreja', '_rRBb0ldAXD4llOeMxCt7CaLnZswliHJ', '$2y$13$awgjmtJLs3kuQ29ByfpysOa0dpcoq8Kra/sGiUFbR7udsBU2RGLb2', NULL, 'igreja@gmail.com', 10, 1736361671, 1736361671, 'hiWPqn3Xl-CuvaGQhBlajFabCm3KKCYh_1736361671'),
(14, 'testeFuncionalSemAcesso', 'FP91T8eWY09ov-1-wSmSrLWRLCh5SrTV', '$2y$13$hzu9E../tSPSFw72zMA1IuLD4qksUHhN3hDp4LTh5wRgHPBS.lEOC', NULL, 'random@gmail.com', 10, 1736365120, 1736365120, 'K2cBqTKxJhEUrmi_Y_EvOSrrMMagAUzN_1736365120'),
(15, 'defesaAdmin', 'ZTVRP3y9egM5faWCUkD-bAz0ietGdis6', '$2y$13$WT8urkp/5YjLdy6nEo1kpOQqIuk7fZaeK2wM74eT0TDah6jpLgrcS', NULL, 'defesaadmin@gmail.com', 10, 1736375087, 1736375087, '7oo6j35dPxMpyOQGPJH0gJHWHUY9Cd6F_1736375087'),
(16, 'defesaColaborador', '2g8zcn6_jjRrjMonQIm6DwElvxn5dTlK', '$2y$13$i4xMxi3VWcEe13lnn6g2hOWSL9xn9A8bwgjljc21JPTyNoJvaXetq', NULL, 'defesacolaborador@gmail.com', 10, 1736375673, 1736375673, 'z8KWtwPYUPNTsXPLAHfTIQmY80xBGkGU_1736375673'),
(17, 'defesaClient', 'XrNB6adhHQLcNsEhrfMXnByIyXhjudKU', '$2y$13$OFGJMU9Eigwpf5w.gKkJL.TtbUTdTJ.8kxNdvthOXbFbdFg.6FlWu', NULL, 'defesaclient@gmail.com', 10, 1736375723, 1736375723, 'dtogaH-fMkxdGTVuevfcrOodf0MaNO81_1736375723');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(12, 'Ricardo', '2025-01-03 17:07:50', 6, NULL),
(13, NULL, '2025-01-08 18:31:50', 0, NULL),
(14, NULL, '2025-01-08 19:38:40', 0, NULL),
(15, NULL, '2025-01-08 22:24:47', 0, NULL),
(16, NULL, '2025-01-08 22:34:33', 0, NULL),
(17, NULL, '2025-01-08 22:35:23', 0, NULL);

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
-- Limitadores para a tabela `fatura`
--
ALTER TABLE `fatura`
  ADD CONSTRAINT `fatura_ibfk_2` FOREIGN KEY (`desconto_id`) REFERENCES `desconto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fatura_ibfk_3` FOREIGN KEY (`metodopagamento_id`) REFERENCES `metodopagamento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fatura_ibfk_4` FOREIGN KEY (`utilizadorperfil_id`) REFERENCES `utilizadorperfil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fatura_ibfk_5` FOREIGN KEY (`cupao_id`) REFERENCES `cupao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
