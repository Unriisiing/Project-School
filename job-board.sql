-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 22 oct. 2023 à 20:48
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `job-board`
--

-- --------------------------------------------------------

--
-- Structure de la table `advertisements`
--

CREATE TABLE `advertisements` (
  `ad_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `start_of_contract` date DEFAULT NULL,
  `content` text DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `job_type` enum('CDI','part_time','CDD','Alternance','Stage') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `advertisements`
--

INSERT INTO `advertisements` (`ad_id`, `title`, `description`, `publication_date`, `start_of_contract`, `content`, `company_id`, `salary`, `domain`, `job_type`) VALUES
(17, 'Dev Web', 'Dev web lets go', '2023-10-05', '2023-10-07', 'lets go', 16, NULL, NULL, NULL),
(19, 'Développeur Full Stack', 'Rejoignez notre équipe de développement pour travailler sur des projets passionnants.', '2023-10-21', '2023-11-15', 'Nous recherchons des développeurs Full Stack expérimentés pour contribuer à nos projets innovants.', 16, '7000', 'Informatique', ''),
(20, 'Responsable Marketing', 'Nous recherchons un responsable marketing dynamique pour promouvoir nos produits et services.', '2023-10-21', '2023-11-01', 'Le candidat idéal aura une solide expérience dans la gestion de campagnes de marketing et de publicité.', 17, '6000', 'Marketing', ''),
(21, 'Stagiaire RH', 'Rejoignez notre équipe RH en tant que stagiaire pour acquérir une expérience pratique dans la gestion des ressources humaines.', '2023-10-21', '2023-11-01', 'Le stagiaire travaillera en étroite collaboration avec notre équipe pour soutenir les activités de recrutement et de formation.', 13, 'Non rémunéré', 'Ressources humaines', ''),
(22, 'Test', 'Test', '2023-10-22', '2002-12-25', 'Test test test', 17, '200', 'clad', ''),
(24, 'test2', 'test22', '2023-10-22', '2111-12-25', 'teste222', 16, '300k', 'Big Data', 'CDI');

-- --------------------------------------------------------

--
-- Structure de la table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `companies`
--

INSERT INTO `companies` (`company_id`, `name`, `address`, `contact_email`, `image`, `user_id`) VALUES
(13, 'TotoCompany', '2 rue toto', 'tito@gmail.com', NULL, 16),
(16, 'Azer Sud', 'Aéroport International Marseille Provence, 13700 Marignane', 'azer@gmail.com', NULL, 39),
(17, 'miko company', '2 rue miko ', 'company@gmail.com', NULL, 47);

-- --------------------------------------------------------

--
-- Structure de la table `job_applications`
--

CREATE TABLE `job_applications` (
  `application_id` int(11) NOT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `non_logged_in_applicant_id` int(11) DEFAULT NULL,
  `application_date` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `job_applications`
--

INSERT INTO `job_applications` (`application_id`, `ad_id`, `user_id`, `non_logged_in_applicant_id`, `application_date`, `notes`) VALUES
(44, 19, 46, NULL, '2023-10-21 20:58:52', NULL),
(45, 19, NULL, 12, '2023-10-22 20:45:43', 'Notes for application');

-- --------------------------------------------------------

--
-- Structure de la table `non_logged_in_applicants`
--

CREATE TABLE `non_logged_in_applicants` (
  `applicant_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `application_date` datetime DEFAULT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `CV` longblob DEFAULT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `non_logged_in_applicants`
--

INSERT INTO `non_logged_in_applicants` (`applicant_id`, `first_name`, `last_name`, `email`, `application_date`, `ad_id`, `CV`, `message`) VALUES
(11, 'Ethan', 'Mss', 'mss@gmail.com', '2023-10-21 19:54:34', 17, NULL, ''),
(12, 'Ethan', 'Moussaoui', 'emss@gmail.com', '2023-10-22 20:45:43', 19, NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` enum('applicant','advertiser','administrator') DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `CV` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `role`, `profile_img`, `password`, `CV`) VALUES
(16, 'michael', 'picard', 'toto@gmail.com', 'administrator', 'http://localhost/LetsGo/backend/uploads/testblackbox.png', 'ab4f63f9ac65152575886860dde480a1', NULL),
(39, 'Azer', 'RH', 'Azer@gmail.com', 'advertiser', '', 'ab4f63f9ac65152575886860dde480a1', NULL),
(46, 'mika', 'mika', 'mika@gmail.com', 'applicant', '', 'ab4f63f9ac65152575886860dde480a1', ''),
(47, 'miko', 'miko', 'miko@gmail.com', 'advertiser', '', 'ab4f63f9ac65152575886860dde480a1', NULL),
(48, '', '', '', '', '', '', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`ad_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Index pour la table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Index pour la table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `ad_id` (`ad_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `non_logged_in_applicant_id` (`non_logged_in_applicant_id`);

--
-- Index pour la table `non_logged_in_applicants`
--
ALTER TABLE `non_logged_in_applicants`
  ADD PRIMARY KEY (`applicant_id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `non_logged_in_applicants`
--
ALTER TABLE `non_logged_in_applicants`
  MODIFY `applicant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `advertisements`
--
ALTER TABLE `advertisements`
  ADD CONSTRAINT `advertisements_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`);

--
-- Contraintes pour la table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Contraintes pour la table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `advertisements` (`ad_id`),
  ADD CONSTRAINT `job_applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `job_applications_ibfk_3` FOREIGN KEY (`non_logged_in_applicant_id`) REFERENCES `non_logged_in_applicants` (`applicant_id`);

--
-- Contraintes pour la table `non_logged_in_applicants`
--
ALTER TABLE `non_logged_in_applicants`
  ADD CONSTRAINT `non_logged_in_applicants_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `advertisements` (`ad_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
