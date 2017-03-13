-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Mer 08 Mars 2017 à 23:07
-- Version du serveur :  5.6.35
-- Version de PHP :  7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `inventory`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`, `created_at`) VALUES
(1, 'Grass pokemons', 'Grass is one of the three basic elemental types along with Fire and Water, which constitute the three starter Pokémon. This creates a simple triangle to explain the type concept easily to new players. Grass is one of the weakest types statistically, with 5 defensive weaknesses and 7 types that are resistant to Grass moves. Furthermore, many Grass Pokémon have Poison as their secondary type, adding a Psychic vulnerability. The type combination with the most weaknesses is Grass/Psychic.', '2017-03-08 22:15:15'),
(2, 'Fire pokemons', 'Fire is one of the three basic elemental types along with Water and Grass, which constitute the three starter Pokémon. This creates a simple triangle to explain the type concept easily to new players. Fire types are notoriously rare in the early stages of the games so choosing the Fire variation starter is often a plus.', '2017-03-08 22:20:04'),
(3, 'Water pokemons', 'Water is one of the three basic elemental types along with Fire and Grass, which constitute the three starter Pokémon. This creates a simple triangle to explain the type concept easily to new players. Water is the most common type with over 100 Pokémon, which are based on a wide variety of fish and other sea-dwelling creatures. As of Generation 6, Water has been paired with every other type.', '2017-03-08 22:24:27'),
(4, 'Bug pokemons', 'Most Bug Pokémon grow quickly and evolve sooner than other types. As a result, they are often very weak. In Generation I, bugs were almost useless since the few Bug type moves available were very weak. The situation improved in later games with better moves and an advantage against the Dark type.', '2017-03-08 22:28:30'),
(5, 'Normal pokemons', 'The Normal type is the most basic type of Pokémon. They are very common and appear from the very first route you visit. Most Normal Pokémon are single type, but there is a large contingent having a second type of Flying. Pokémon X/Y add several Normal dual-type Pokémon.', '2017-03-08 22:35:14'),
(6, 'Electric pokemons', 'There are relatively few Electric Pokémon; in fact only four were added in the third generation. Most are based on rodents or inanimate objects. Electric Pokémon are very good defensively, being weak only to Ground moves. Eelektross is the only Pokémon to have no type disadvantages due to its ability, Levitate.', '2017-03-08 22:40:32');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `media` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `created_at`, `category`, `price`, `quantity`, `media`) VALUES
(1, 'Bulbasaur', 'Bulbasaur is a Grass/Poison type Pokémon introduced in Generation 1. It is known as the Seed Pokémon.\r\n', '2017-03-08 22:17:21', 1, 89, 26, '1489007841.jpg'),
(2, 'Ivysaur', 'Ivysaur is a Grass/Poison type Pokémon introduced in Generation 1. It is known as the Seed Pokémon.', '2017-03-08 22:18:16', 1, 87, 18, '1489007897.jpg'),
(3, 'Venusaur', 'Venusaur is a Grass/Poison type Pokémon introduced in Generation 1. It is known as the Seed Pokémon. Venusaur has a Mega Evolution, available from X & Y onwards.', '2017-03-08 22:19:11', 1, 1200, 12, '1489007951.jpg'),
(4, 'Charmander', 'Charmander is a Fire type Pokémon introduced in Generation 1. It is known as the Lizard Pokémon.', '2017-03-08 22:20:54', 2, 27, 165, '1489008054.jpg'),
(5, 'Charmeleon', 'Charmeleon is a Fire type Pokémon introduced in Generation 1. It is known as the Flame Pokémon.', '2017-03-08 22:21:43', 2, 125, 13, '1489008103.jpg'),
(6, 'Charizard', 'Charizard is a Fire/Flying type Pokémon introduced in Generation 1. It is known as the Flame Pokémon. Charizard has two Mega Evolutions, available from X & Y onwards.', '2017-03-08 22:22:29', 2, 1321, 27, '1489008149.jpg'),
(7, 'Squirtle', 'Squirtle is a Water type Pokémon introduced in Generation 1. It is known as the Tiny Turtle Pokémon.', '2017-03-08 22:25:12', 3, 34, 142, '1489008312.jpg'),
(8, 'Wartortle', 'Wartortle is a Water type Pokémon introduced in Generation 1. It is known as the Turtle Pokémon.', '2017-03-08 22:25:45', 3, 162, 10, '1489008346.jpg'),
(9, 'Blastoise', 'Blastoise is a Water type Pokémon introduced in Generation 1. It is known as the Shellfish Pokémon. Blastoise has a Mega Evolution, available from X & Y onwards.', '2017-03-08 22:27:31', 3, 1254, 19, '1489008452.jpg'),
(10, 'Caterpie', 'Caterpie is a Bug type Pokémon introduced in Generation 1. It is known as the Worm Pokémon.', '2017-03-08 22:29:07', 4, 12, 128, '1489008548.jpg'),
(11, 'Metapod', 'Metapod is a Bug type Pokémon introduced in Generation 1. It is known as the Cocoon Pokémon.', '2017-03-08 22:30:40', 4, 26, 14, '1489008640.jpg'),
(12, 'Butterfree', 'Butterfree is a Bug/Flying type Pokémon introduced in Generation 1. It is known as the Butterfly Pokémon.', '2017-03-08 22:32:32', 4, 27, 12, '1489008752.jpg'),
(13, 'Weedle', 'Weedle is a Bug/Poison type Pokémon introduced in Generation 1. It is known as the Hairy Bug Pokémon.', '2017-03-08 22:33:04', 1, 78, 129, '1489008784.jpg'),
(14, 'Kakuna', 'Kakuna is a Bug/Poison type Pokémon introduced in Generation 1. It is known as the Cocoon Pokémon.', '2017-03-08 22:33:40', 4, 182, 10, '1489008821.jpg'),
(15, 'Beedrill', 'Beedrill is a Bug/Poison type Pokémon introduced in Generation 1. It is known as the Poison Bee Pokémon. Beedrill has a Mega Evolution, available from Omega Ruby & Alpha Sapphire onwards.', '2017-03-08 22:34:12', 1, 29, 10, '1489008853.jpg'),
(16, 'Pidgey', 'Pidgey is a Normal/Flying type Pokémon introduced in Generation 1. It is known as the Tiny Bird Pokémon.', '2017-03-08 22:35:53', 5, 298, 14, '1489008953.jpg'),
(17, 'Pidgeotto', 'Pidgeotto is a Normal/Flying type Pokémon introduced in Generation 1. It is known as the Bird Pokémon.', '2017-03-08 22:36:35', 5, 192, 12, '1489008995.jpg'),
(18, 'Pidgeot', 'Pidgeot is a Normal/Flying type Pokémon introduced in Generation 1. It is known as the Bird Pokémon. Pidgeot has a Mega Evolution, available from Omega Ruby & Alpha Sapphire onwards.', '2017-03-08 22:37:21', 5, 298, 27, '1489009042.jpg'),
(19, 'Rattata', 'Rattata is a Normal type Pokémon introduced in Generation 1. It is known as the Mouse Pokémon. Rattata has a new Alolan form introduced in Pokémon Sun/Moon.', '2017-03-08 22:38:02', 5, 91, 29, '1489009082.jpg'),
(20, 'Raticate', 'Raticate is a Normal type Pokémon introduced in Generation 1. It is known as the Mouse Pokémon.', '2017-03-08 22:38:49', 5, 871, 29, '1489009129.jpg'),
(21, 'Spearow', 'Spearow is a Normal/Flying type Pokémon introduced in Generation 1. It is known as the Tiny Bird Pokémon.', '2017-03-08 22:39:20', 5, 221, 29, '1489009161.jpg'),
(22, 'Fearow', 'Fearow is a Normal/Flying type Pokémon introduced in Generation 1. It is known as the Beak Pokémon.', '2017-03-08 22:39:54', 5, 287, 121, '1489009195.jpg'),
(23, 'Pikachu', 'Pikachu is an Electric type Pokémon introduced in Generation 1. It is known as the Mouse Pokémon.', '2017-03-08 22:41:12', 6, 245, 14, '1489009272.jpg'),
(24, 'Raichu', 'Raichu is an Electric type Pokémon introduced in Generation 1. It is known as the Mouse Pokémon. Raichu has a new Alolan form introduced in Pokémon Sun/Moon.', '2017-03-08 22:41:44', 6, 1287, 10, '1489009304.jpg'),
(25, 'Sandshrew', 'Sandshrew is a Ground type Pokémon introduced in Generation 1. It is known as the Mouse Pokémon. Sandshrew has a new Alolan form introduced in Pokémon Sun/Moon.', '2017-03-08 22:42:22', 6, 1099, 75, '1489009343.jpg'),
(26, 'Sandslash', 'Sandslash is a Ground type Pokémon introduced in Generation 1. It is known as the Mouse Pokémon. Sandslash has a new Alolan form introduced in Pokémon Sun/Moon.', '2017-03-08 22:42:49', 6, 198, 30, '1489009369.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `reports`
--

INSERT INTO `reports` (`id`, `title`, `file`, `user`, `created_at`) VALUES
(1, 'Daily Report - March 8th', '1489009892.csv', 'root', '2017-03-08 22:51:32');

-- --------------------------------------------------------

--
-- Structure de la table `revisions`
--

CREATE TABLE `revisions` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `revisions`
--

INSERT INTO `revisions` (`id`, `type`, `type_id`, `date`, `user`) VALUES
(1, 'products', 1, '2017-03-08 22:53:23', 'root'),
(2, 'products', 2, '2017-03-08 22:53:40', 'root'),
(3, 'products', 1, '2017-03-08 22:53:50', 'root'),
(4, 'products', 4, '2017-03-08 22:53:55', 'root'),
(5, 'products', 11, '2017-03-08 22:54:01', 'root'),
(6, 'categories', 1, '2017-03-08 22:54:14', 'root'),
(7, 'categories', 1, '2017-03-08 22:54:17', 'root'),
(8, 'categories', 3, '2017-03-08 22:54:20', 'root'),
(9, 'categories', 2, '2017-03-08 22:54:23', 'root'),
(10, 'categories', 4, '2017-03-08 22:54:25', 'root'),
(11, 'categories', 2, '2017-03-08 22:54:28', 'root'),
(12, 'products', 18, '2017-03-08 22:54:37', 'root'),
(13, 'products', 1, '2017-03-08 22:54:41', 'root');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'root', 'a295455722f9898d957cd604cb2c073cf5ab7ecbe4eda11b9ce427b214e010e6', 'root@root.com', '2017-03-08 22:07:32');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `revisions`
--
ALTER TABLE `revisions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `revisions`
--
ALTER TABLE `revisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
