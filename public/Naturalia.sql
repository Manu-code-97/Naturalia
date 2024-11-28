-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 28, 2024 at 02:58 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Naturalia`
--

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'Fruits et Légumes'),
(2, 'Épicerie Salée'),
(3, 'Épicerie Sucrée'),
(4, 'Produits Frais'),
(5, 'Boissons');

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id`, `image`, `nom`, `description`, `prix`, `quantite_stock`, `local`, `origine`, `marque`, `ingredient`, `poids`, `prix_promo`, `slug`, `sous_categorie_id`) VALUES
(1, '', 'Pommes Golden bio', 'DESC 1', 1.00, 10, 1, '', '', '', 1.00, 0.00, '0', 1),
(2, '', 'Oranges bio non traitées', 'DESC 2', 2.00, 10, 1, '', '', '', 1.00, 0.00, '0', 1),
(3, '', 'Kiwis bio de Nouvelle-Zélande', 'DESC 3', 3.00, 10, 1, '', '', '', 1.00, 0.00, '0', 1),
(4, '', 'Poires Conférence bio', 'DESC 4', 4.00, 10, 1, '', '', '', 1.00, 0.00, '0', 1),
(5, '', 'Raisins blancs bio', 'DESC 5', 5.00, 10, 1, '', '', '', 1.00, 0.00, '0', 1),
(6, '', 'Carottes bio', 'DESC 6', 6.00, 10, 1, '', '', '', 1.00, 0.00, '0', 2),
(7, '', 'Pommes de terre bio (variété Agata)', 'DESC 7', 7.00, 10, 1, '', '', '', 1.00, 0.00, '0', 2),
(8, '', 'Patates douces bio', 'DESC 8', 8.00, 10, 1, '', '', '', 1.00, 0.00, '0', 2),
(9, '', 'Betteraves crues bio', 'DESC 9', 9.00, 10, 1, '', '', '', 1.00, 0.00, '0', 2),
(10, '', 'Radis noir bio', 'DESC 10', 10.00, 10, 1, '', '', '', 1.00, 0.00, '0', 2),
(11, '', 'Persil frais bio', 'DESC 11', 11.00, 10, 1, '', '', '', 1.00, 0.00, '0', 3),
(12, '', 'Basilic en pot bio', 'DESC 12', 12.00, 10, 1, '', '', '', 1.00, 0.00, '0', 3),
(13, '', 'Coriandre bio', 'DESC 13', 13.00, 10, 1, '', '', '', 1.00, 0.00, '0', 3),
(14, '', 'Ciboulette bio', 'DESC 14', 14.00, 10, 1, '', '', '', 1.00, 0.00, '0', 3),
(15, '', 'Thym frais bio', 'DESC 15', 15.00, 10, 1, '', '', '', 1.00, 0.00, '0', 3),
(16, '', 'Riz complet bio', 'DESC 16', 16.00, 10, 1, '', '', '', 1.00, 0.00, '0', 4),
(17, '', 'Quinoa bio', 'DESC 17', 17.00, 10, 1, '', '', '', 1.00, 0.00, '0', 4),
(18, '', 'Pois cassés bio', 'DESC 18', 18.00, 10, 1, '', '', '', 1.00, 0.00, '0', 4),
(19, '', 'Lentilles corail bio', 'DESC 19', 19.00, 10, 1, '', '', '', 1.00, 0.00, '0', 4),
(20, '', 'Flocons d’avoine bio', 'DESC 20', 20.00, 10, 1, '', '', '', 1.00, 0.00, '0', 4),
(21, '', 'Sauce tomate nature bio', 'DESC 21', 21.00, 10, 1, '', '', '', 1.00, 0.00, '0', 5),
(22, '', 'Pois chiches en conserve bio', 'DESC 22', 22.00, 10, 1, '', '', '', 1.00, 0.00, '0', 5),
(23, '', 'Ratatouille bio en bocal', 'DESC 23', 23.00, 10, 1, '', '', '', 1.00, 0.00, '0', 5),
(24, '', 'Olives vertes bio en saumure', 'DESC 24', 24.00, 10, 1, '', '', '', 1.00, 0.00, '0', 5),
(25, '', 'Soupe de légumes bio prête à consommer', 'DESC 25', 25.00, 10, 1, '', '', '', 1.00, 0.00, '0', 5),
(26, '', 'Pâtes complètes bio (farine d’épeautre)', 'DESC 26', 26.00, 10, 1, '', '', '', 1.00, 0.00, '0', 6),
(27, '', 'Semoule de blé bio', 'DESC 27', 27.00, 10, 1, '', '', '', 1.00, 0.00, '0', 6),
(28, '', 'Farine de sarrasin bio', 'DESC 28', 28.00, 10, 1, '', '', '', 1.00, 0.00, '0', 6),
(29, '', 'Noix de cajou bio (sans sel)', 'DESC 29', 29.00, 10, 1, '', '', '', 1.00, 0.00, '0', 6),
(30, '', 'Riz basmati bio', 'DESC 30', 30.00, 10, 1, '', '', '', 1.00, 0.00, '0', 6),
(31, '', 'Miel d’acacia bio', 'DESC 31', 31.00, 10, 1, '', '', '', 1.00, 0.00, '0', 7),
(32, '', 'Miel de fleurs sauvages bio', 'DESC 32', 32.00, 10, 1, '', '', '', 1.00, 0.00, '0', 7),
(33, '', 'Confiture de fraises bio (sans sucres ajoutés)', 'DESC 33', 33.00, 10, 1, '', '', '', 1.00, 0.00, '0', 7),
(34, '', 'Confiture d’abricots bio', 'DESC 34', 34.00, 10, 1, '', '', '', 1.00, 0.00, '0', 7),
(35, '', 'Gelée de coing bio', 'DESC 35', 35.00, 10, 1, '', '', '', 1.00, 0.00, '0', 7),
(36, '', 'Cookies aux pépites de chocolat bio', 'DESC 36', 36.00, 10, 1, '', '', '', 1.00, 0.00, '0', 8),
(37, '', 'Barres céréalières aux fruits rouges bio', 'DESC 37', 37.00, 10, 1, '', '', '', 1.00, 0.00, '0', 8),
(38, '', 'Crackers au sésame bio (sucré-salé)', 'DESC 38', 38.00, 10, 1, '', '', '', 1.00, 0.00, '0', 8),
(39, '', 'Madeleines au miel bio', 'DESC 39', 39.00, 10, 1, '', '', '', 1.00, 0.00, '0', 8),
(40, '', 'Biscuits sablés à la vanille bio', 'DESC 40', 40.00, 10, 1, '', '', '', 1.00, 0.00, '0', 8),
(41, '', 'Tablette de chocolat noir 70% bio', 'DESC 41', 41.00, 10, 1, '', '', '', 1.00, 0.00, '0', 9),
(42, '', 'Éclats de fèves de cacao bio', 'DESC 42', 42.00, 10, 1, '', '', '', 1.00, 0.00, '0', 9),
(43, '', 'Pâte à tartiner chocolat-noisette bio (sans huile de palme)', 'DESC 43', 43.00, 10, 1, '', '', '', 1.00, 0.00, '0', 9),
(44, '', 'Tablette chocolat au lait bio avec amandes', 'DESC 44', 44.00, 10, 1, '', '', '', 1.00, 0.00, '0', 9),
(45, '', 'Chocolat blanc bio à la vanille', 'DESC 45', 45.00, 10, 1, '', '', '', 1.00, 0.00, '0', 9),
(46, '', 'Yaourts nature bio (au lait de vache)', 'DESC 46', 46.00, 10, 1, '', '', '', 1.00, 0.00, '0', 10),
(47, '', 'Fromage de chèvre bio', 'DESC 47', 47.00, 10, 1, '', '', '', 1.00, 0.00, '0', 10),
(48, '', 'Lait d’amande bio (sans sucres ajoutés)', 'DESC 48', 48.00, 10, 1, '', '', '', 1.00, 0.00, '0', 10),
(49, '', 'Crème fraîche bio', 'DESC 49', 49.00, 10, 1, '', '', '', 1.00, 0.00, '0', 10),
(50, '', 'Beurre demi-sel bio', 'DESC 50', 50.00, 10, 1, '', '', '', 1.00, 0.00, '0', 10),
(51, '', 'Tofu nature bio', 'DESC 51', 51.00, 10, 1, '', '', '', 1.00, 0.00, '0', 11),
(52, '', 'Tofu fumé bio', 'DESC 52', 52.00, 10, 1, '', '', '', 1.00, 0.00, '0', 11),
(53, '', 'Tempeh bio mariné', 'DESC 53', 53.00, 10, 1, '', '', '', 1.00, 0.00, '0', 11),
(54, '', 'Fromage râpé végétal bio', 'DESC 54', 54.00, 10, 1, '', '', '', 1.00, 0.00, '0', 11),
(55, '', 'Tartinade végétale à l’ail et fines herbes bio', 'DESC 55', 55.00, 10, 1, '', '', '', 1.00, 0.00, '0', 11),
(56, '', 'Jambon blanc bio (sans nitrites)', 'DESC 56', 56.00, 10, 1, '', '', '', 1.00, 0.00, '0', 12),
(57, '', 'Chorizo bio doux', 'DESC 57', 57.00, 10, 1, '', '', '', 1.00, 0.00, '0', 12),
(58, '', 'Saucisses végétariennes bio', 'DESC 58', 58.00, 10, 1, '', '', '', 1.00, 0.00, '0', 12),
(59, '', 'Rillettes de poulet bio', 'DESC 59', 59.00, 10, 1, '', '', '', 1.00, 0.00, '0', 12),
(60, '', 'Terrine de légumes bio', 'DESC 60', 60.00, 10, 1, '', '', '', 1.00, 0.00, '0', 12),
(61, '', 'Jus d’orange bio (pur jus)', 'DESC 61', 61.00, 10, 1, '', '', '', 1.00, 0.00, '0', 13),
(62, '', 'Jus de carotte bio pressé à froid', 'DESC 62', 62.00, 10, 1, '', '', '', 1.00, 0.00, '0', 13),
(63, '', 'Smoothie pomme-gingembre bio', 'DESC 63', 63.00, 10, 1, '', '', '', 1.00, 0.00, '0', 13),
(64, '', 'Jus de grenade bio', 'DESC 64', 64.00, 10, 1, '', '', '', 1.00, 0.00, '0', 13),
(65, '', 'Jus pomme-céleri bio', 'DESC 65', 65.00, 10, 1, '', '', '', 1.00, 0.00, '0', 13),
(66, '', 'Lait d’avoine bio (sans sucres ajoutés)', 'DESC 66', 66.00, 10, 1, '', '', '', 1.00, 0.00, '0', 14),
(67, '', 'Lait de coco bio', 'DESC 67', 67.00, 10, 1, '', '', '', 1.00, 0.00, '0', 14),
(68, '', 'Lait de riz bio', 'DESC 68', 68.00, 10, 1, '', '', '', 1.00, 0.00, '0', 14),
(69, '', 'Lait de noisette bio', 'DESC 69', 69.00, 10, 1, '', '', '', 1.00, 0.00, '0', 14),
(70, '', 'Lait de soja vanille bio', 'DESC 70', 70.00, 10, 1, '', '', '', 1.00, 0.00, '0', 14),
(71, '', 'Thé vert bio au citron', 'DESC 71', 71.00, 10, 1, '', '', '', 1.00, 0.00, '0', 15),
(72, '', 'Infusion bio relaxante (camomille, tilleul)', 'DESC 72', 72.00, 10, 1, '', '', '', 1.00, 0.00, '0', 15),
(73, '', 'Thé noir bio Earl Grey', 'DESC 73', 73.00, 10, 1, '', '', '', 1.00, 0.00, '0', 15),
(74, '', 'Rooibos bio nature', 'DESC 74', 74.00, 10, 1, '', '', '', 1.00, 0.00, '0', 15),
(75, '', 'Infusion bio détox (gingembre, citronnelle)', 'DESC 75', 75.00, 10, 1, '', '', '', 1.00, 0.00, '0', 15);

--
-- Dumping data for table `sous_categorie`
--

INSERT INTO `sous_categorie` (`id`, `categorie_id`, `nom`) VALUES
(1, 1, 'Fruits de saison'),
(2, 1, 'Légumes racines'),
(3, 1, 'Aromates et herbes fraîches'),
(4, 2, 'Céréales et légumineuses'),
(5, 2, 'Conserves bio'),
(6, 2, 'Produits secs'),
(7, 3, 'Miels et confitures'),
(8, 3, 'Biscuits et snacks'),
(9, 3, 'Chocolats bio'),
(10, 4, 'Produits laitiers'),
(11, 4, 'Produits végétaux frais'),
(12, 4, 'Charcuterie bio'),
(13, 5, 'Jus de fruits et légumes'),
(14, 5, 'Boissons végétales'),
(15, 5, 'Thés et infusions');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
