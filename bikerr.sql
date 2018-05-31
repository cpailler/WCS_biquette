-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 31 mai 2018 à 14:26
-- Version du serveur :  8.0.11
-- Version de PHP :  7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bikerr`
--

-- --------------------------------------------------------

--
-- Structure de la table `couleur`
--

CREATE TABLE `couleur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `code_hexa` varchar(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `disponibilite`
--

CREATE TABLE `disponibilite` (
  `id` int(11) NOT NULL,
  `velo_id` int(11) NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `equipement`
--

CREATE TABLE `equipement` (
  `id` int(11) NOT NULL,
  `equipement` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etat_velo`
--

CREATE TABLE `etat_velo` (
  `id` int(11) NOT NULL,
  `etat` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `genre` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `loc_tel`
--

CREATE TABLE `loc_tel` (
  `id` int(11) NOT NULL,
  `pays_id` int(11) NOT NULL,
  `indice` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `id_mangopay` int(11) DEFAULT NULL,
  `id_wallet` int(11) DEFAULT NULL,
  `id_facebook` int(11) DEFAULT NULL,
  `prenom` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_inscription` date NOT NULL,
  `nb_velo_emprunte` int(11) NOT NULL,
  `nb_velo_prete` int(11) NOT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code_postal` int(11) NOT NULL,
  `tel` int(11) NOT NULL,
  `tel_public` tinyint(1) NOT NULL,
  `date_naissance` date NOT NULL,
  `membre_verifie` tinyint(1) NOT NULL,
  `key_mdp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `indic_tel_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `pays_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `id` int(11) NOT NULL,
  `pays` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `alpha2` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `alpha3` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nom_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom_fr` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo_velo`
--

CREATE TABLE `photo_velo` (
  `id` int(11) NOT NULL,
  `velo_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `velo_id` int(11) NOT NULL,
  `locataire_id` int(11) NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `cout_pts` int(11) NOT NULL,
  `caution` int(11) NOT NULL,
  `assurance` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_velo`
--

CREATE TABLE `type_velo` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `velo`
--

CREATE TABLE `velo` (
  `id` int(11) NOT NULL,
  `proprio_id` int(11) NOT NULL,
  `marque` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modele` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_velo_id` int(11) DEFAULT NULL,
  `couleur_id` int(11) DEFAULT NULL,
  `titre` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `etat_velo_id` int(11) DEFAULT NULL,
  `neuf` tinyint(1) NOT NULL,
  `num_facture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `magasin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_achat` date DEFAULT NULL,
  `antivol_key` int(11) NOT NULL,
  `antivol_code` int(11) NOT NULL,
  `bicycode` int(11) DEFAULT NULL,
  `adresse_velo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caution` int(11) DEFAULT NULL,
  `assur_oblig` tinyint(1) NOT NULL,
  `cout_pts` int(11) NOT NULL,
  `dispo_totale` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `velo_equipement`
--

CREATE TABLE `velo_equipement` (
  `velo_id` int(11) NOT NULL,
  `equipement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `couleur`
--
ALTER TABLE `couleur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2CBACE2FEC6AC5BD` (`velo_id`);

--
-- Index pour la table `equipement`
--
ALTER TABLE `equipement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etat_velo`
--
ALTER TABLE `etat_velo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `loc_tel`
--
ALTER TABLE `loc_tel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6A522414A6E44244` (`pays_id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F6B4FB2946286348` (`indic_tel_id`),
  ADD KEY `IDX_F6B4FB294296D31F` (`genre_id`),
  ADD KEY `IDX_F6B4FB29A6E44244` (`pays_id`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photo_velo`
--
ALTER TABLE `photo_velo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B478C301EC6AC5BD` (`velo_id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_42C84955EC6AC5BD` (`velo_id`);

--
-- Index pour la table `type_velo`
--
ALTER TABLE `type_velo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `velo`
--
ALTER TABLE `velo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_354971F56B82600` (`proprio_id`),
  ADD KEY `IDX_354971F5C44BAA48` (`type_velo_id`),
  ADD KEY `IDX_354971F5C31BA576` (`couleur_id`),
  ADD KEY `IDX_354971F5EBB5FA38` (`etat_velo_id`);

--
-- Index pour la table `velo_equipement`
--
ALTER TABLE `velo_equipement`
  ADD PRIMARY KEY (`velo_id`,`equipement_id`),
  ADD KEY `IDX_85FCFB46EC6AC5BD` (`velo_id`),
  ADD KEY `IDX_85FCFB46806F0F5C` (`equipement_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `couleur`
--
ALTER TABLE `couleur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `equipement`
--
ALTER TABLE `equipement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `etat_velo`
--
ALTER TABLE `etat_velo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `loc_tel`
--
ALTER TABLE `loc_tel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `photo_velo`
--
ALTER TABLE `photo_velo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_velo`
--
ALTER TABLE `type_velo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `velo`
--
ALTER TABLE `velo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD CONSTRAINT `FK_2CBACE2FEC6AC5BD` FOREIGN KEY (`velo_id`) REFERENCES `velo` (`id`);

--
-- Contraintes pour la table `loc_tel`
--
ALTER TABLE `loc_tel`
  ADD CONSTRAINT `FK_6A522414A6E44244` FOREIGN KEY (`pays_id`) REFERENCES `pays` (`id`);

--
-- Contraintes pour la table `membre`
--
ALTER TABLE `membre`
  ADD CONSTRAINT `FK_F6B4FB294296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `FK_F6B4FB2946286348` FOREIGN KEY (`indic_tel_id`) REFERENCES `loc_tel` (`id`),
  ADD CONSTRAINT `FK_F6B4FB29A6E44244` FOREIGN KEY (`pays_id`) REFERENCES `pays` (`id`);

--
-- Contraintes pour la table `photo_velo`
--
ALTER TABLE `photo_velo`
  ADD CONSTRAINT `FK_B478C301EC6AC5BD` FOREIGN KEY (`velo_id`) REFERENCES `velo` (`id`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_42C84955EC6AC5BD` FOREIGN KEY (`velo_id`) REFERENCES `velo` (`id`);

--
-- Contraintes pour la table `velo`
--
ALTER TABLE `velo`
  ADD CONSTRAINT `FK_354971F56B82600` FOREIGN KEY (`proprio_id`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `FK_354971F5C31BA576` FOREIGN KEY (`couleur_id`) REFERENCES `couleur` (`id`),
  ADD CONSTRAINT `FK_354971F5C44BAA48` FOREIGN KEY (`type_velo_id`) REFERENCES `type_velo` (`id`),
  ADD CONSTRAINT `FK_354971F5EBB5FA38` FOREIGN KEY (`etat_velo_id`) REFERENCES `etat_velo` (`id`);

--
-- Contraintes pour la table `velo_equipement`
--
ALTER TABLE `velo_equipement`
  ADD CONSTRAINT `FK_85FCFB46806F0F5C` FOREIGN KEY (`equipement_id`) REFERENCES `equipement` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_85FCFB46EC6AC5BD` FOREIGN KEY (`velo_id`) REFERENCES `velo` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
