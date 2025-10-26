-- Adminer 4.8.0 MySQL 5.5.5-10.5.9-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `accord_tarifaire`;
CREATE TABLE `accord_tarifaire` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `activations`;
CREATE TABLE `activations` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `activations_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `admin_activations`;
CREATE TABLE `admin_activations` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `admin_activations_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `admin_password_resets`;
CREATE TABLE `admin_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `admin_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 0,
  `forbidden` tinyint(1) NOT NULL DEFAULT 0,
  `language` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_email_deleted_at_unique` (`email`,`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin_users` (`id`, `first_name`, `last_name`, `email`, `password`, `remember_token`, `activated`, `forbidden`, `language`, `deleted_at`, `created_at`, `updated_at`, `last_login_at`) VALUES
(1,	'Administrator',	'Administrator',	'administrator@brackets.sk',	'$2y$10$GDWQvz2h/q.UFgzFA0D3DuFScVb1IEE1u83/8t0909u2946zVO4VC',	'8BeDzSIjK23M9YHi0ISmiEeYhRwkPDpE4ZckWHEeROieycOaG4jDfNeCCvMb',	1,	0,	'fr',	NULL,	'2021-04-20 16:50:33',	'2021-07-30 16:05:50',	'2021-07-30 16:05:50');

DROP TABLE IF EXISTS `agence_location`;
CREATE TABLE `agence_location` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_agence` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `heure_ouverture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '00:00',
  `heure_fermeture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '00:00',
  `ville_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agence_location_ville_id_foreign` (`ville_id`),
  CONSTRAINT `agence_location_ville_id_foreign` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `allotements`;
CREATE TABLE `allotements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 0,
  `date_depart` date NOT NULL,
  `date_arrive` date NOT NULL,
  `date_acquisition` date NOT NULL,
  `date_limite` date DEFAULT NULL,
  `heure_depart` time DEFAULT NULL,
  `heure_arrive` time DEFAULT NULL,
  `compagnie_transport_id` bigint(20) unsigned NOT NULL,
  `lieu_depart_id` bigint(20) unsigned NOT NULL,
  `lieu_arrive_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `allotements_compagnie_transport_id_foreign` (`compagnie_transport_id`),
  KEY `allotements_lieu_depart_id_foreign` (`lieu_depart_id`),
  KEY `allotements_lieu_arrive_id_foreign` (`lieu_arrive_id`),
  CONSTRAINT `allotements_compagnie_transport_id_foreign` FOREIGN KEY (`compagnie_transport_id`) REFERENCES `compagnie_transport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `allotements_lieu_arrive_id_foreign` FOREIGN KEY (`lieu_arrive_id`) REFERENCES `service_aeroport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `allotements_lieu_depart_id_foreign` FOREIGN KEY (`lieu_depart_id`) REFERENCES `service_aeroport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `allotements` (`id`, `titre`, `quantite`, `date_depart`, `date_arrive`, `date_acquisition`, `date_limite`, `heure_depart`, `heure_arrive`, `compagnie_transport_id`, `lieu_depart_id`, `lieu_arrive_id`, `created_at`, `updated_at`) VALUES
(1,	'Allotement 1',	2,	'2021-08-01',	'2021-08-03',	'2021-07-29',	'2021-08-03',	'12:00:00',	'12:00:00',	1,	1,	2,	'2021-07-30 14:20:45',	'2021-07-30 14:20:45');

DROP TABLE IF EXISTS `base_type`;
CREATE TABLE `base_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `base_type_titre_unique` (`titre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `base_type` (`id`, `titre`, `nombre`, `description`, `created_at`, `updated_at`) VALUES
(1,	'Base Simple',	1,	NULL,	'2021-07-30 12:08:55',	'2021-07-30 12:08:55'),
(2,	'Base Double',	2,	NULL,	'2021-07-30 12:09:48',	'2021-07-30 12:09:48'),
(3,	'Base Triple',	3,	NULL,	'2021-07-30 12:13:48',	'2021-07-30 12:13:48');

DROP TABLE IF EXISTS `billeterie_maritime`;
CREATE TABLE `billeterie_maritime` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_depart` date NOT NULL,
  `date_arrive` date DEFAULT NULL,
  `availability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_acquisition` date NOT NULL,
  `date_limite` date DEFAULT NULL,
  `image` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantite` int(11) NOT NULL DEFAULT 0,
  `compagnie_transport_id` bigint(20) unsigned NOT NULL,
  `lieu_depart_id` bigint(20) unsigned NOT NULL,
  `lieu_arrive_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `billeterie_maritime_compagnie_transport_id_foreign` (`compagnie_transport_id`),
  KEY `billeterie_maritime_lieu_depart_id_foreign` (`lieu_depart_id`),
  KEY `billeterie_maritime_lieu_arrive_id_foreign` (`lieu_arrive_id`),
  CONSTRAINT `billeterie_maritime_compagnie_transport_id_foreign` FOREIGN KEY (`compagnie_transport_id`) REFERENCES `compagnie_transport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `billeterie_maritime_lieu_arrive_id_foreign` FOREIGN KEY (`lieu_arrive_id`) REFERENCES `service_port` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `billeterie_maritime_lieu_depart_id_foreign` FOREIGN KEY (`lieu_depart_id`) REFERENCES `service_port` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `categorie_vehicule`;
CREATE TABLE `categorie_vehicule` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `famille_vehicule_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categorie_vehicule_famille_vehicule_id_foreign` (`famille_vehicule_id`),
  CONSTRAINT `categorie_vehicule_famille_vehicule_id_foreign` FOREIGN KEY (`famille_vehicule_id`) REFERENCES `famille_vehicule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `compagnie_liaison_excursion`;
CREATE TABLE `compagnie_liaison_excursion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `excursion_id` bigint(20) unsigned NOT NULL,
  `compagnie_transport_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `compagnie_liaison_excursion_excursion_id_foreign` (`excursion_id`),
  KEY `compagnie_liaison_excursion_compagnie_transport_id_foreign` (`compagnie_transport_id`),
  CONSTRAINT `compagnie_liaison_excursion_compagnie_transport_id_foreign` FOREIGN KEY (`compagnie_transport_id`) REFERENCES `compagnie_transport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compagnie_liaison_excursion_excursion_id_foreign` FOREIGN KEY (`excursion_id`) REFERENCES `excursions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `compagnie_liaison_excursion` (`id`, `excursion_id`, `compagnie_transport_id`, `created_at`, `updated_at`) VALUES
(1,	1,	2,	NULL,	NULL),
(2,	1,	3,	NULL,	NULL);

DROP TABLE IF EXISTS `compagnie_transport`;
CREATE TABLE `compagnie_transport` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_transport` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure_ouverture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '00:00',
  `heure_fermeture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '00:00',
  `ville_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `compagnie_transport_nom_unique` (`nom`),
  KEY `compagnie_transport_ville_id_foreign` (`ville_id`),
  CONSTRAINT `compagnie_transport_ville_id_foreign` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `compagnie_transport` (`id`, `nom`, `email`, `phone`, `adresse`, `logo`, `type_transport`, `heure_ouverture`, `heure_fermeture`, `ville_id`, `created_at`, `updated_at`) VALUES
(1,	'Madagascar',	'Administrator@brackets.sk',	'0328565583',	'Antananarivo',	NULL,	'Aérien',	NULL,	NULL,	1,	'2021-07-30 14:20:42',	'2021-07-30 14:20:42'),
(2,	'Compagnie 1',	'Administrator@brackets.sk',	'0328565583',	'Antananarivo',	NULL,	'Maritime',	NULL,	NULL,	1,	'2021-07-30 17:47:13',	'2021-07-30 17:47:13'),
(3,	'Compagnie 2',	'Administrator@brackets.sk',	'0328565583',	'Antananarivo',	NULL,	'Maritime',	NULL,	NULL,	2,	'2021-07-30 17:47:30',	'2021-07-30 17:47:30');

DROP TABLE IF EXISTS `devises`;
CREATE TABLE `devises` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbole` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devises_titre_unique` (`titre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `event_date_heure`;
CREATE TABLE `event_date_heure` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `time_start` time NOT NULL DEFAULT '00:00:00',
  `time_end` time NOT NULL DEFAULT '23:59:00',
  `model_event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `ui_event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `excursions`;
CREATE TABLE `excursions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure_depart` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `participant_min` int(11) NOT NULL DEFAULT 1,
  `card` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lunch` int(11) NOT NULL DEFAULT 0,
  `ticket` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville_id` bigint(20) unsigned NOT NULL,
  `prestataire_id` bigint(20) unsigned NOT NULL,
  `lieu_depart_id` bigint(20) unsigned NOT NULL,
  `lieu_arrive_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `excursions_ville_id_foreign` (`ville_id`),
  KEY `excursions_prestataire_id_foreign` (`prestataire_id`),
  KEY `excursions_lieu_depart_id_foreign` (`lieu_depart_id`),
  KEY `excursions_lieu_arrive_id_foreign` (`lieu_arrive_id`),
  CONSTRAINT `excursions_lieu_arrive_id_foreign` FOREIGN KEY (`lieu_arrive_id`) REFERENCES `service_port` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `excursions_lieu_depart_id_foreign` FOREIGN KEY (`lieu_depart_id`) REFERENCES `service_port` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `excursions_prestataire_id_foreign` FOREIGN KEY (`prestataire_id`) REFERENCES `prestataire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `excursions_ville_id_foreign` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `excursions` (`id`, `title`, `duration`, `heure_depart`, `availability`, `participant_min`, `card`, `lunch`, `ticket`, `status`, `description`, `ville_id`, `prestataire_id`, `lieu_depart_id`, `lieu_arrive_id`, `created_at`, `updated_at`) VALUES
(1,	'Excursion 1',	'Journée',	'12:00',	NULL,	12,	NULL,	0,	0,	'1',	NULL,	1,	1,	1,	2,	'2021-07-30 17:44:57',	'2021-07-30 17:44:57');

DROP TABLE IF EXISTS `excursion_taxe`;
CREATE TABLE `excursion_taxe` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `excursion_id` bigint(20) unsigned NOT NULL,
  `taxe_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `excursion_taxe_excursion_id_foreign` (`excursion_id`),
  KEY `excursion_taxe_taxe_id_foreign` (`taxe_id`),
  CONSTRAINT `excursion_taxe_excursion_id_foreign` FOREIGN KEY (`excursion_id`) REFERENCES `excursions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `excursion_taxe_taxe_id_foreign` FOREIGN KEY (`taxe_id`) REFERENCES `taxe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `famille_vehicule`;
CREATE TABLE `famille_vehicule` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `hebergements`;
CREATE TABLE `hebergements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration_min` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `caution` double(8,2) NOT NULL DEFAULT 0.00,
  `heure_ouverture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00:00',
  `heure_fermeture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00:00',
  `type_hebergement_id` bigint(20) unsigned NOT NULL,
  `ville_id` bigint(20) unsigned NOT NULL,
  `prestataire_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hebergements_name_unique` (`name`),
  KEY `hebergements_type_hebergement_id_foreign` (`type_hebergement_id`),
  KEY `hebergements_ville_id_foreign` (`ville_id`),
  KEY `hebergements_prestataire_id_foreign` (`prestataire_id`),
  CONSTRAINT `hebergements_prestataire_id_foreign` FOREIGN KEY (`prestataire_id`) REFERENCES `prestataire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hebergements_type_hebergement_id_foreign` FOREIGN KEY (`type_hebergement_id`) REFERENCES `type_hebergement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hebergements_ville_id_foreign` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `hebergements` (`id`, `name`, `image`, `description`, `adresse`, `duration_min`, `status`, `caution`, `heure_ouverture`, `heure_fermeture`, `type_hebergement_id`, `ville_id`, `prestataire_id`, `created_at`, `updated_at`) VALUES
(1,	'Hebergement 1',	NULL,	NULL,	'Antananarivo',	NULL,	'1',	0.00,	'00:00',	'00:00',	1,	1,	1,	'2021-07-30 12:08:22',	'2021-07-30 12:08:22'),
(2,	'Hebergement 2',	NULL,	NULL,	'Antananarivo',	NULL,	'1',	0.00,	'00:00',	'00:00',	1,	1,	1,	'2021-07-30 17:03:53',	'2021-07-30 17:03:53');

DROP TABLE IF EXISTS `hebergement_marque_blanche`;
CREATE TABLE `hebergement_marque_blanche` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `liens` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_hebergement_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hebergement_marque_blanche_type_hebergement_id_foreign` (`type_hebergement_id`),
  CONSTRAINT `hebergement_marque_blanche_type_hebergement_id_foreign` FOREIGN KEY (`type_hebergement_id`) REFERENCES `type_hebergement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `hebergement_taxe`;
CREATE TABLE `hebergement_taxe` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hebergement_id` bigint(20) unsigned NOT NULL,
  `taxe_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hebergement_taxe_hebergement_id_foreign` (`hebergement_id`),
  KEY `hebergement_taxe_taxe_id_foreign` (`taxe_id`),
  CONSTRAINT `hebergement_taxe_hebergement_id_foreign` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hebergement_taxe_taxe_id_foreign` FOREIGN KEY (`taxe_id`) REFERENCES `taxe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `hebergement_vol`;
CREATE TABLE `hebergement_vol` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `depart` date NOT NULL,
  `arrive` date NOT NULL,
  `nombre_jour` double(8,2) NOT NULL,
  `nombre_nuit` int(11) NOT NULL,
  `heure_depart` time NOT NULL,
  `heure_arrive` time NOT NULL,
  `tarif_id` bigint(20) unsigned NOT NULL,
  `allotement_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hebergement_vol_tarif_id_foreign` (`tarif_id`),
  KEY `hebergement_vol_allotement_id_foreign` (`allotement_id`),
  CONSTRAINT `hebergement_vol_allotement_id_foreign` FOREIGN KEY (`allotement_id`) REFERENCES `allotements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hebergement_vol_tarif_id_foreign` FOREIGN KEY (`tarif_id`) REFERENCES `tarifs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `hebergement_vol` (`id`, `depart`, `arrive`, `nombre_jour`, `nombre_nuit`, `heure_depart`, `heure_arrive`, `tarif_id`, `allotement_id`, `created_at`, `updated_at`) VALUES
(1,	'2021-08-01',	'2021-08-03',	3.00,	3,	'12:00:00',	'12:00:00',	1,	1,	'2021-07-30 14:21:09',	'2021-07-30 14:21:09');

DROP TABLE IF EXISTS `inclus_supplement_excursion`;
CREATE TABLE `inclus_supplement_excursion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `supplement_excursion_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inclus_supplement_excursion_supplement_excursion_id_foreign` (`supplement_excursion_id`),
  CONSTRAINT `inclus_supplement_excursion_supplement_excursion_id_foreign` FOREIGN KEY (`supplement_excursion_id`) REFERENCES `supplement_excursion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `islands`;
CREATE TABLE `islands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `lieu_transfert`;
CREATE TABLE `lieu_transfert` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lieu_transfert_ville_id_foreign` (`ville_id`),
  CONSTRAINT `lieu_transfert_ville_id_foreign` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `lieu_transfert` (`id`, `titre`, `adresse`, `ville_id`, `created_at`, `updated_at`) VALUES
(1,	'Aéroport Pôle Caraïbes',	'Adresse',	2,	'2021-07-30 15:38:15',	'2021-07-30 15:38:15'),
(2,	'Saint-françois',	'Adresse',	2,	'2021-07-30 15:38:39',	'2021-07-30 15:38:39');

DROP TABLE IF EXISTS `marque_vehicule`;
CREATE TABLE `marque_vehicule` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(2,	'Brackets\\AdminAuth\\Models\\AdminUser',	1,	'aa212646-e5cc-42cd-99fe-44b79978b129',	'avatar',	'qnrqz3t8UbOYoKrkOxacUJE4ikcDzNAM69cCdVig',	'qnrqz3t8UbOYoKrkOxacUJE4ikcDzNAM69cCdVig.png',	'image/png',	'media',	'media',	8262,	'[]',	'{\"name\":\"avatar2.png\",\"file_name\":\"avatar2.png\",\"width\":215,\"height\":215}',	'{\"thumb_200\":true,\"thumb_75\":true,\"thumb_150\":true}',	'[]',	1,	'2021-04-21 14:14:50',	'2021-04-21 14:14:51');

DROP TABLE IF EXISTS `media_image_upload`;
CREATE TABLE `media_image_upload` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8832 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4937,	'2021_04_03_094931_create_service_transport_table',	1),
(8280,	'2021_07_01_100756_fill_permissions_for_tarif-transfert-voyage',	2),
(8463,	'2021_04_22_152458_create_chambres_table',	3),
(8644,	'2021_05_20_183855_create_tarif_chambre_table',	4),
(8716,	'2021_01_05_135201_create_modele_vehicule_table',	5),
(8717,	'2021_01_05_135428_create_marque_vehicule_table',	5),
(8718,	'2021_04_03_091933_create_devises_table',	5),
(8719,	'2021_04_03_092317_create_pays_table',	5),
(8720,	'2021_04_03_092317_create_villes_table',	5),
(8721,	'2021_04_03_092318_create_agence_location_table',	5),
(8722,	'2021_04_03_092318_create_lieu_transfert_table',	5),
(8723,	'2021_04_03_094933_create_service_aeroport_table',	5),
(8724,	'2021_04_03_094933_create_service_port_table',	5),
(8725,	'2021_04_03_153749_create_prestataire_table',	5),
(8726,	'2021_04_21_162446_create_type_hebergement_table',	5),
(8727,	'2021_04_21_162707_fill_permissions_for_type-hebergement',	5),
(8728,	'2021_04_21_163039_fill_permissions_for_type-chambre',	5),
(8729,	'2021_04_21_163933_create_islands_table',	5),
(8730,	'2021_04_21_164102_fill_permissions_for_island',	5),
(8731,	'2021_04_21_165615_fill_permissions_for_ville',	5),
(8732,	'2021_04_21_171042_fill_permissions_for_chambre',	5),
(8733,	'2021_04_21_172637_create_hebergements_table',	5),
(8734,	'2021_04_21_172640_create_base_type_table',	5),
(8735,	'2021_04_21_172647_create_type_chambre_table',	5),
(8736,	'2021_04_21_172858_fill_permissions_for_hebergement',	5),
(8737,	'2021_04_21_173344_create_saisons_table',	5),
(8738,	'2021_04_21_174220_fill_permissions_for_saison',	5),
(8739,	'2021_04_21_174706_fill_permissions_for_tarif',	5),
(8740,	'2021_04_22_180023_create_type_personne_table',	5),
(8741,	'2021_04_22_180653_fill_permissions_for_type-personne',	5),
(8742,	'2021_04_30_204029_fill_permissions_for_base-type',	5),
(8743,	'2021_05_03_092236_fill_permissions_for_devise',	5),
(8744,	'2021_05_03_093927_fill_permissions_for_pay',	5),
(8745,	'2021_05_03_160556_fill_permissions_for_prestataire',	5),
(8746,	'2021_05_04_143156_create_supplement_pension_table',	5),
(8747,	'2021_05_04_144736_fill_permissions_for_supplement-pension',	5),
(8748,	'2021_05_04_144821_create_supplement_activite_table',	5),
(8749,	'2021_05_04_144942_fill_permissions_for_supplement-activite',	5),
(8750,	'2021_05_04_145019_create_supplement_vue_table',	5),
(8751,	'2021_05_04_145127_fill_permissions_for_supplement-vue',	5),
(8752,	'2021_05_11_135448_fill_permissions_for_hebergement-vol',	5),
(8753,	'2021_05_12_154606_create_hebergement_marque_blanche_table',	5),
(8754,	'2021_05_17_102633_create_media_image_upload_table',	5),
(8755,	'2021_05_17_142517_fill_permissions_for_media-image-upload',	5),
(8756,	'2021_05_19_183732_create_compagnie_transport_table',	5),
(8757,	'2021_05_19_183807_create_allotements_table',	5),
(8758,	'2021_05_19_190338_fill_permissions_for_compagnie-transport',	5),
(8759,	'2021_05_19_190420_fill_permissions_for_allotement',	5),
(8760,	'2021_05_20_180417_create_tarifs_table',	5),
(8761,	'2021_05_21_134413_create_hebergement_vol_table',	5),
(8762,	'2021_05_26_171717_create_event_date_heure_table',	5),
(8763,	'2021_05_26_173641_fill_permissions_for_event-date-heure',	5),
(8764,	'2021_05_31_203011_create_excursions_table',	5),
(8765,	'2021_06_01_114932_fill_permissions_for_excursion',	5),
(8766,	'2021_06_03_012840_create_supplement_excursion_table',	5),
(8767,	'2021_06_03_015519_fill_permissions_for_supplement-excursion',	5),
(8768,	'2021_06_03_090757_create_tarif_supplement_excursion_table',	5),
(8769,	'2021_06_03_183456_create_billeterie_maritime_table',	5),
(8770,	'2021_06_03_184826_create_tarif_billeterie_maritime_table',	5),
(8771,	'2021_06_03_184826_create_taxe_table',	5),
(8772,	'2021_06_03_185200_fill_permissions_for_billeterie-maritime',	5),
(8773,	'2021_06_04_074945_create_tarif_excursion_table',	5),
(8774,	'2021_06_04_080457_create_taxe_excursion_table',	5),
(8775,	'2021_06_04_080924_fill_permissions_for_taxe',	5),
(8776,	'2021_06_04_081151_fill_permissions_for_tarif-excursion',	5),
(8777,	'2021_06_04_082251_create_inclus_supplement_excursion_table',	5),
(8778,	'2021_06_07_123212_create_hebergement_taxe_table',	5),
(8779,	'2021_06_07_133655_create_excursion_taxe_table',	5),
(8780,	'2021_06_07_134137_fill_permissions_for_excursion-taxe',	5),
(8781,	'2021_06_07_134227_fill_permissions_for_hebergement-taxe',	5),
(8782,	'2021_06_08_131328_create_compagnie_liaison_excursion_table',	5),
(8783,	'2021_06_08_131729_fill_permissions_for_compagnie-liaison-excursion',	5),
(8784,	'2021_06_09_002733_create_planing_time_table',	5),
(8785,	'2021_06_09_084258_fill_permissions_for_planing-time',	5),
(8786,	'2021_06_10_143349_fill_permissions_for_tarif-billeterie-maritime',	5),
(8787,	'2021_06_15_132112_fill_permissions_for_tarif-supplement-excursion',	5),
(8788,	'2021_06_16_102312_create_famille_vehicule_table',	5),
(8789,	'2021_06_16_102445_create_categorie_vehicule_table',	5),
(8790,	'2021_06_16_102713_create_accord_tarifaire_table',	5),
(8791,	'2021_06_16_102902_create_vehicule_location_table',	5),
(8792,	'2021_06_16_144336_create_tranche_saison_table',	5),
(8793,	'2021_06_16_144706_create_tarif_tranche_saison_table',	5),
(8794,	'2021_06_16_145232_fill_permissions_for_famille-vehicule',	5),
(8795,	'2021_06_16_172142_fill_permissions_for_categorie-vehicule',	5),
(8796,	'2021_06_17_072630_fill_permissions_for_vehicule-location',	5),
(8797,	'2021_06_17_193656_fill_permissions_for_location-vehicule-saison',	5),
(8798,	'2021_06_18_105337_fill_permissions_for_tranche-saison',	5),
(8799,	'2021_06_21_133805_fill_permissions_for_service-transport',	5),
(8800,	'2021_06_21_135835_fill_permissions_for_service-port',	5),
(8801,	'2021_06_21_135853_fill_permissions_for_service-aeroport',	5),
(8802,	'2021_06_23_211637_create_tarif_supplement_vue_table',	5),
(8803,	'2021_06_23_211745_create_tarif_supplement_pension_table',	5),
(8804,	'2021_06_23_211814_create_tarif_supplement_activite_table',	5),
(8805,	'2021_06_24_014334_fill_permissions_for_tarif-supplement-pension',	5),
(8806,	'2021_06_24_014349_fill_permissions_for_tarif-supplement-activite',	5),
(8807,	'2021_06_24_121443_create_tarif_type_personne_hebergement_table',	5),
(8808,	'2021_06_24_121939_fill_permissions_for_tarif-type-personne-hebergement',	5),
(8809,	'2021_06_25_131019_create_tarif_tranche_saison_location_table',	5),
(8810,	'2021_06_25_131150_fill_permissions_for_tarif-tranche-saison-location',	5),
(8811,	'2021_07_01_085402_create_type_transfert_voyage_table',	5),
(8812,	'2021_07_01_085507_create_tranche_personne_transfert_voyage_table',	5),
(8813,	'2021_07_01_085532_create_trajet_transfert_voyage_table',	5),
(8814,	'2021_07_01_085548_create_tarif_transfert_voyage_table',	5),
(8815,	'2021_07_01_095559_create_vehicule_transfert_voyage_table',	5),
(8816,	'2021_07_01_100600_fill_permissions_for_type-transfert-voyage',	5),
(8817,	'2021_07_01_100634_fill_permissions_for_tranche-personne-transfert-voyage',	5),
(8818,	'2021_07_01_100700_fill_permissions_for_trajet-transfert-voyage',	5),
(8819,	'2021_07_01_101038_fill_permissions_for_vehicule-transfert-voyage',	5),
(8820,	'2021_07_05_135649_fill_permissions_for_marque-vehicule',	5),
(8821,	'2021_07_05_135726_fill_permissions_for_modele-vehicule',	5),
(8822,	'2021_07_06_143637_fill_permissions_for_agence-location',	5),
(8823,	'2021_07_06_143704_fill_permissions_for_lieu-transfert',	5),
(8824,	'2021_07_07_211020_create_transfert_voyage_prime_nuit_table',	5),
(8825,	'2021_07_13_183619_create_vehicule_info_tech_table',	5),
(8826,	'2021_07_14_101313_fill_permissions_for_vehicule-info-tech',	5),
(8827,	'2021_07_14_101314_create_restriction_trajet_vehicule_table',	5),
(8828,	'2021_07_15_134851_create_vehicule_categorie_supplement_table',	5),
(8829,	'2021_07_15_135318_fill_permissions_for_vehicule-categorie-supplement',	5),
(8830,	'2021_07_15_145927_fill_permissions_for_restriction-trajet-vehicule',	5),
(8831,	'2021_07_16_003316_fill_permissions_for_tarif-transfert-voyage',	5);

DROP TABLE IF EXISTS `modele_vehicule`;
CREATE TABLE `modele_vehicule` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1,	'Brackets\\AdminAuth\\Models\\AdminUser',	1);

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `pays`;
CREATE TABLE `pays` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pays_nom_unique` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pays` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1,	'Madagascar',	'2021-07-30 12:07:23',	'2021-07-30 12:07:23'),
(2,	'Pays 1',	'2021-07-30 15:38:05',	'2021-07-30 15:38:05');

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29646 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1,	'admin',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33'),
(2,	'admin.translation.index',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33'),
(3,	'admin.translation.edit',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33'),
(4,	'admin.translation.rescan',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33'),
(5,	'admin.admin-user.index',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33'),
(6,	'admin.admin-user.create',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33'),
(7,	'admin.admin-user.edit',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33'),
(8,	'admin.admin-user.delete',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33'),
(9,	'admin.upload',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33'),
(10,	'admin.admin-user.impersonal-login',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33'),
(6532,	'admin.hebergement-marque-blanche',	'admin',	'2021-05-14 16:16:39',	'2021-05-14 16:16:39'),
(6533,	'admin.hebergement-marque-blanche.index',	'admin',	'2021-05-14 16:16:39',	'2021-05-14 16:16:39'),
(6534,	'admin.hebergement-marque-blanche.create',	'admin',	'2021-05-14 16:16:39',	'2021-05-14 16:16:39'),
(6535,	'admin.hebergement-marque-blanche.show',	'admin',	'2021-05-14 16:16:39',	'2021-05-14 16:16:39'),
(6536,	'admin.hebergement-marque-blanche.edit',	'admin',	'2021-05-14 16:16:39',	'2021-05-14 16:16:39'),
(6537,	'admin.hebergement-marque-blanche.delete',	'admin',	'2021-05-14 16:16:39',	'2021-05-14 16:16:39'),
(6538,	'admin.hebergement-marque-blanche.bulk-delete',	'admin',	'2021-05-14 16:16:39',	'2021-05-14 16:16:39'),
(7045,	'admin.compagnie-vol',	'admin',	'2021-05-21 10:46:50',	'2021-05-21 10:46:50'),
(7046,	'admin.compagnie-vol.index',	'admin',	'2021-05-21 10:46:50',	'2021-05-21 10:46:50'),
(7047,	'admin.compagnie-vol.create',	'admin',	'2021-05-21 10:46:50',	'2021-05-21 10:46:50'),
(7048,	'admin.compagnie-vol.show',	'admin',	'2021-05-21 10:46:50',	'2021-05-21 10:46:50'),
(7049,	'admin.compagnie-vol.edit',	'admin',	'2021-05-21 10:46:50',	'2021-05-21 10:46:50'),
(7050,	'admin.compagnie-vol.delete',	'admin',	'2021-05-21 10:46:50',	'2021-05-21 10:46:50'),
(7051,	'admin.compagnie-vol.bulk-delete',	'admin',	'2021-05-21 10:46:50',	'2021-05-21 10:46:50'),
(8679,	'admin.eexcursion.create-prestataire',	'admin',	'2021-06-02 05:58:26',	'2021-06-02 05:58:26'),
(10471,	'admin.tarif-excursion.update-all',	'admin',	'2021-06-07 07:26:56',	'2021-06-07 07:26:56'),
(29238,	'admin.type-hebergement',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29239,	'admin.type-hebergement.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29240,	'admin.type-hebergement.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29241,	'admin.type-hebergement.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29242,	'admin.type-hebergement.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29243,	'admin.type-hebergement.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29244,	'admin.type-hebergement.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29245,	'admin.type-chambre',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29246,	'admin.type-chambre.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29247,	'admin.type-chambre.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29248,	'admin.type-chambre.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29249,	'admin.type-chambre.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29250,	'admin.type-chambre.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29251,	'admin.type-chambre.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29252,	'admin.island',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29253,	'admin.island.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29254,	'admin.island.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29255,	'admin.island.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29256,	'admin.island.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29257,	'admin.island.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29258,	'admin.island.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29259,	'admin.ville',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29260,	'admin.ville.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29261,	'admin.ville.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29262,	'admin.ville.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29263,	'admin.ville.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29264,	'admin.ville.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29265,	'admin.ville.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29266,	'admin.chambre',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29267,	'admin.chambre.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29268,	'admin.chambre.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29269,	'admin.chambre.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29270,	'admin.chambre.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29271,	'admin.chambre.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29272,	'admin.chambre.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29273,	'admin.hebergement',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29274,	'admin.hebergement.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29275,	'admin.hebergement.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29276,	'admin.hebergement.create-prestataire',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29277,	'admin.hebergement.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29278,	'admin.hebergement.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29279,	'admin.hebergement.edit-prestataire',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29280,	'admin.hebergement.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29281,	'admin.hebergement.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29282,	'admin.hebergememnts.update-prestataire',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29283,	'admin.saison',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29284,	'admin.saison.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29285,	'admin.saison.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29286,	'admin.saison.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29287,	'admin.saison.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29288,	'admin.saison.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29289,	'admin.saison.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29290,	'admin.tarif',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29291,	'admin.tarif.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29292,	'admin.tarif.detail',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29293,	'admin.tarif.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29294,	'admin.tarif.create-vol',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29295,	'admin.tarif.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29296,	'admin.tarif.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29297,	'admin.tarif.edit-vol',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29298,	'admin.tarif.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29299,	'admin.tarif.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29300,	'admin.type-personne',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29301,	'admin.type-personne.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29302,	'admin.type-personne.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29303,	'admin.type-personne.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29304,	'admin.type-personne.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29305,	'admin.type-personne.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29306,	'admin.type-personne.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29307,	'admin.base-type',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29308,	'admin.base-type.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29309,	'admin.base-type.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29310,	'admin.base-type.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29311,	'admin.base-type.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29312,	'admin.base-type.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29313,	'admin.base-type.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29314,	'admin.devise',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29315,	'admin.devise.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29316,	'admin.devise.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29317,	'admin.devise.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29318,	'admin.devise.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29319,	'admin.devise.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29320,	'admin.devise.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29321,	'admin.pay',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29322,	'admin.pay.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29323,	'admin.pay.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29324,	'admin.pay.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29325,	'admin.pay.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29326,	'admin.pay.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29327,	'admin.pay.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29328,	'admin.prestataire',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29329,	'admin.prestataire.index',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29330,	'admin.prestataire.create',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29331,	'admin.prestataire.show',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29332,	'admin.prestataire.edit',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29333,	'admin.prestataire.delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29334,	'admin.prestataire.bulk-delete',	'admin',	'2021-07-30 12:06:36',	'2021-07-30 12:06:36'),
(29335,	'admin.supplement-pension',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29336,	'admin.supplement-pension.index',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29337,	'admin.supplement-pension.create',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29338,	'admin.supplement-pension.show',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29339,	'admin.supplement-pension.edit',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29340,	'admin.supplement-pension.delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29341,	'admin.supplement-pension.bulk-delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29342,	'admin.supplement-activite',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29343,	'admin.supplement-activite.index',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29344,	'admin.supplement-activite.create',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29345,	'admin.supplement-activite.show',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29346,	'admin.supplement-activite.edit',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29347,	'admin.supplement-activite.delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29348,	'admin.supplement-activite.bulk-delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29349,	'admin.supplement-vue',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29350,	'admin.supplement-vue.index',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29351,	'admin.supplement-vue.create',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29352,	'admin.supplement-vue.show',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29353,	'admin.supplement-vue.edit',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29354,	'admin.supplement-vue.delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29355,	'admin.supplement-vue.bulk-delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29356,	'admin.hebergement-vol',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29357,	'admin.hebergement-vol.index',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29358,	'admin.hebergement-vol.create',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29359,	'admin.hebergement-vol.show',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29360,	'admin.hebergement-vol.edit',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29361,	'admin.hebergement-vol.delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29362,	'admin.hebergement-vol.bulk-delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29363,	'admin.media-image-upload',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29364,	'admin.media-image-upload.index',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29365,	'admin.media-image-upload.create',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29366,	'admin.media-image-upload.show',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29367,	'admin.media-image-upload.edit',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29368,	'admin.media-image-upload.delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29369,	'admin.media-image-upload.bulk-delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29370,	'admin.compagnie-transport',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29371,	'admin.compagnie-transport.index',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29372,	'admin.compagnie-transport.all',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29373,	'admin.compagnie-transport.maritime',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29374,	'admin.compagnie-transport.aerien',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29375,	'admin.compagnie-transport.create',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29376,	'admin.compagnie-transport.show',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29377,	'admin.compagnie-transport.edit',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29378,	'admin.compagnie-transport.delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29379,	'admin.compagnie-transport.bulk-delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29380,	'admin.allotement',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29381,	'admin.allotement.index',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29382,	'admin.allotement.create',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29383,	'admin.allotement.show',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29384,	'admin.allotement.edit',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29385,	'admin.allotement.delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29386,	'admin.allotement.bulk-delete',	'admin',	'2021-07-30 12:06:37',	'2021-07-30 12:06:37'),
(29387,	'admin.event-date-heure',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29388,	'admin.event-date-heure.index',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29389,	'admin.event-date-heure.create',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29390,	'admin.event-date-heure.show',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29391,	'admin.event-date-heure.edit',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29392,	'admin.event-date-heure.delete',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29393,	'admin.event-date-heure.bulk-delete',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29394,	'admin.excursion',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29395,	'admin.excursion.index',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29396,	'admin.excursion.create',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29397,	'admin.excursion.show',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29398,	'admin.excursion.edit',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29399,	'admin.excursion.delete',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29400,	'admin.excursion.bulk-delete',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29401,	'admin.excursion.create-prestataire',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29402,	'admin.excursion.update-prestataire',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29403,	'admin.excursion.strore-prestataire',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29404,	'admin.supplement-excursion',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29405,	'admin.supplement-excursion.index',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29406,	'admin.supplement-excursion.create',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29407,	'admin.supplement-excursion.show',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29408,	'admin.supplement-excursion.edit',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29409,	'admin.supplement-excursion.delete',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29410,	'admin.supplement-excursion.bulk-delete',	'admin',	'2021-07-30 12:06:38',	'2021-07-30 12:06:38'),
(29411,	'admin.billeterie-maritime',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29412,	'admin.billeterie-maritime.index',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29413,	'admin.billeterie-maritime.create',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29414,	'admin.billeterie-maritime.show',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29415,	'admin.billeterie-maritime.edit',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29416,	'admin.billeterie-maritime.delete',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29417,	'admin.billeterie-maritime.bulk-delete',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29418,	'admin.taxe',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29419,	'admin.taxe.index',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29420,	'admin.taxe.create',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29421,	'admin.taxe.show',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29422,	'admin.taxe.edit',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29423,	'admin.taxe.delete',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29424,	'admin.taxe.bulk-delete',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29425,	'admin.tarif-excursion',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29426,	'admin.tarif-excursion.index',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29427,	'admin.tarif-excursion.create',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29428,	'admin.tarif-excursion.show',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29429,	'admin.tarif-excursion.edit',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29430,	'admin.tarif-excursion.delete',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29431,	'admin.tarif-excursion.bulk-delete',	'admin',	'2021-07-30 12:06:39',	'2021-07-30 12:06:39'),
(29432,	'admin.excursion-taxe',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29433,	'admin.excursion-taxe.index',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29434,	'admin.excursion-taxe.create',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29435,	'admin.excursion-taxe.show',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29436,	'admin.excursion-taxe.edit',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29437,	'admin.excursion-taxe.delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29438,	'admin.excursion-taxe.bulk-delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29439,	'admin.hebergement-taxe',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29440,	'admin.hebergement-taxe.index',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29441,	'admin.hebergement-taxe.create',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29442,	'admin.hebergement-taxe.show',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29443,	'admin.hebergement-taxe.edit',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29444,	'admin.hebergement-taxe.delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29445,	'admin.hebergement-taxe.bulk-delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29446,	'admin.compagnie-liaison-excursion',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29447,	'admin.compagnie-liaison-excursion.index',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29448,	'admin.compagnie-liaison-excursion.create',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29449,	'admin.compagnie-liaison-excursion.show',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29450,	'admin.compagnie-liaison-excursion.edit',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29451,	'admin.compagnie-liaison-excursion.delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29452,	'admin.compagnie-liaison-excursion.bulk-delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29453,	'admin.planing-time',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29454,	'admin.planing-time.index',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29455,	'admin.planing-time.create',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29456,	'admin.planing-time.show',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29457,	'admin.planing-time.edit',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29458,	'admin.planing-time.delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29459,	'admin.planing-time.bulk-delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29460,	'admin.tarif-billeterie-maritime',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29461,	'admin.tarif-billeterie-maritime.index',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29462,	'admin.tarif-billeterie-maritime.create',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29463,	'admin.tarif-billeterie-maritime.show',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29464,	'admin.tarif-billeterie-maritime.edit',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29465,	'admin.tarif-billeterie-maritime.delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29466,	'admin.tarif-billeterie-maritime.bulk-delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29467,	'admin.tarif-supplement-excursion',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29468,	'admin.tarif-supplement-excursion.index',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29469,	'admin.tarif-supplement-excursion.create',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29470,	'admin.tarif-supplement-excursion.show',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29471,	'admin.tarif-supplement-excursion.edit',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29472,	'admin.tarif-supplement-excursion.delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29473,	'admin.tarif-supplement-excursion.bulk-delete',	'admin',	'2021-07-30 12:06:40',	'2021-07-30 12:06:40'),
(29474,	'admin.famille-vehicule',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29475,	'admin.famille-vehicule.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29476,	'admin.famille-vehicule.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29477,	'admin.famille-vehicule.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29478,	'admin.famille-vehicule.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29479,	'admin.famille-vehicule.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29480,	'admin.famille-vehicule.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29481,	'admin.categorie-vehicule',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29482,	'admin.categorie-vehicule.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29483,	'admin.categorie-vehicule.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29484,	'admin.categorie-vehicule.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29485,	'admin.categorie-vehicule.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29486,	'admin.categorie-vehicule.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29487,	'admin.categorie-vehicule.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29488,	'admin.vehicule-location',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29489,	'admin.vehicule-location.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29490,	'admin.vehicule-location.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29491,	'admin.vehicule-location.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29492,	'admin.vehicule-location.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29493,	'admin.vehicule-location.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29494,	'admin.vehicule-location.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29495,	'admin.vehicule-location.update-prestataire',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29496,	'admin.vehicule-location.store-prestataire',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29497,	'admin.location-vehicule-saison',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29498,	'admin.location-vehicule-saison.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29499,	'admin.location-vehicule-saison.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29500,	'admin.location-vehicule-saison.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29501,	'admin.location-vehicule-saison.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29502,	'admin.location-vehicule-saison.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29503,	'admin.location-vehicule-saison.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29504,	'admin.tranche-saison',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29505,	'admin.tranche-saison.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29506,	'admin.tranche-saison.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29507,	'admin.tranche-saison.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29508,	'admin.tranche-saison.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29509,	'admin.tranche-saison.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29510,	'admin.tranche-saison.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29511,	'admin.service-transport',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29512,	'admin.service-transport.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29513,	'admin.service-transport.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29514,	'admin.service-transport.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29515,	'admin.service-transport.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29516,	'admin.service-transport.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29517,	'admin.service-transport.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29518,	'admin.service-port',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29519,	'admin.service-port.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29520,	'admin.service-port.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29521,	'admin.service-port.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29522,	'admin.service-port.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29523,	'admin.service-port.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29524,	'admin.service-port.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29525,	'admin.service-aeroport',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29526,	'admin.service-aeroport.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29527,	'admin.service-aeroport.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29528,	'admin.service-aeroport.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29529,	'admin.service-aeroport.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29530,	'admin.service-aeroport.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29531,	'admin.service-aeroport.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29532,	'admin.tarif-supplement-pension',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29533,	'admin.tarif-supplement-pension.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29534,	'admin.tarif-supplement-pension.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29535,	'admin.tarif-supplement-pension.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29536,	'admin.tarif-supplement-pension.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29537,	'admin.tarif-supplement-pension.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29538,	'admin.tarif-supplement-pension.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29539,	'admin.tarif-supplement-activite',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29540,	'admin.tarif-supplement-activite.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29541,	'admin.tarif-supplement-activite.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29542,	'admin.tarif-supplement-activite.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29543,	'admin.tarif-supplement-activite.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29544,	'admin.tarif-supplement-activite.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29545,	'admin.tarif-supplement-activite.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29546,	'admin.tarif-type-personne-hebergement',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29547,	'admin.tarif-type-personne-hebergement.index',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29548,	'admin.tarif-type-personne-hebergement.create',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29549,	'admin.tarif-type-personne-hebergement.show',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29550,	'admin.tarif-type-personne-hebergement.edit',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29551,	'admin.tarif-type-personne-hebergement.delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29552,	'admin.tarif-type-personne-hebergement.bulk-delete',	'admin',	'2021-07-30 12:06:41',	'2021-07-30 12:06:41'),
(29553,	'admin.tarif-tranche-saison-location',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29554,	'admin.tarif-tranche-saison-location.index',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29555,	'admin.tarif-tranche-saison-location.create',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29556,	'admin.tarif-tranche-saison-location.show',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29557,	'admin.tarif-tranche-saison-location.edit',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29558,	'admin.tarif-tranche-saison-location.delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29559,	'admin.tarif-tranche-saison-location.bulk-delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29560,	'admin.type-transfert-voyage',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29561,	'admin.type-transfert-voyage.index',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29562,	'admin.type-transfert-voyage.create',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29563,	'admin.type-transfert-voyage.show',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29564,	'admin.type-transfert-voyage.edit',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29565,	'admin.type-transfert-voyage.delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29566,	'admin.type-transfert-voyage.bulk-delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29567,	'admin.tranche-personne-transfert-voyage',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29568,	'admin.tranche-personne-transfert-voyage.index',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29569,	'admin.tranche-personne-transfert-voyage.create',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29570,	'admin.tranche-personne-transfert-voyage.show',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29571,	'admin.tranche-personne-transfert-voyage.edit',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29572,	'admin.tranche-personne-transfert-voyage.delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29573,	'admin.tranche-personne-transfert-voyage.bulk-delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29574,	'admin.trajet-transfert-voyage',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29575,	'admin.trajet-transfert-voyage.index',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29576,	'admin.trajet-transfert-voyage.create',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29577,	'admin.trajet-transfert-voyage.show',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29578,	'admin.trajet-transfert-voyage.edit',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29579,	'admin.trajet-transfert-voyage.delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29580,	'admin.trajet-transfert-voyage.bulk-delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29581,	'admin.vehicule-transfert-voyage',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29582,	'admin.vehicule-transfert-voyage.index',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29583,	'admin.vehicule-transfert-voyage.create',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29584,	'admin.vehicule-transfert-voyage.show',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29585,	'admin.vehicule-transfert-voyage.edit',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29586,	'admin.vehicule-transfert-voyage.delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29587,	'admin.vehicule-transfert-voyage.bulk-delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29588,	'admin.vehicule-transfert-voyage.update-prestataire',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29589,	'admin.vehicule-transfert-voyage.store-prestataire',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29590,	'admin.marque-vehicule',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29591,	'admin.marque-vehicule.index',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29592,	'admin.marque-vehicule.create',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29593,	'admin.marque-vehicule.show',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29594,	'admin.marque-vehicule.edit',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29595,	'admin.marque-vehicule.delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29596,	'admin.marque-vehicule.bulk-delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29597,	'admin.modele-vehicule',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29598,	'admin.modele-vehicule.index',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29599,	'admin.modele-vehicule.create',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29600,	'admin.modele-vehicule.show',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29601,	'admin.modele-vehicule.edit',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29602,	'admin.modele-vehicule.delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29603,	'admin.modele-vehicule.bulk-delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29604,	'admin.agence-location',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29605,	'admin.agence-location.index',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29606,	'admin.agence-location.create',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29607,	'admin.agence-location.show',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29608,	'admin.agence-location.edit',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29609,	'admin.agence-location.delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29610,	'admin.agence-location.bulk-delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29611,	'admin.lieu-transfert',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29612,	'admin.lieu-transfert.index',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29613,	'admin.lieu-transfert.create',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29614,	'admin.lieu-transfert.show',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29615,	'admin.lieu-transfert.edit',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29616,	'admin.lieu-transfert.delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29617,	'admin.lieu-transfert.bulk-delete',	'admin',	'2021-07-30 12:06:42',	'2021-07-30 12:06:42'),
(29618,	'admin.vehicule-info-tech',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29619,	'admin.vehicule-info-tech.index',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29620,	'admin.vehicule-info-tech.create',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29621,	'admin.vehicule-info-tech.show',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29622,	'admin.vehicule-info-tech.edit',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29623,	'admin.vehicule-info-tech.delete',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29624,	'admin.vehicule-info-tech.bulk-delete',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29625,	'admin.vehicule-categorie-supplement',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29626,	'admin.vehicule-categorie-supplement.index',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29627,	'admin.vehicule-categorie-supplement.create',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29628,	'admin.vehicule-categorie-supplement.show',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29629,	'admin.vehicule-categorie-supplement.edit',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29630,	'admin.vehicule-categorie-supplement.delete',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29631,	'admin.vehicule-categorie-supplement.bulk-delete',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29632,	'admin.restriction-trajet-vehicule',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29633,	'admin.restriction-trajet-vehicule.index',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29634,	'admin.restriction-trajet-vehicule.create',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29635,	'admin.restriction-trajet-vehicule.show',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29636,	'admin.restriction-trajet-vehicule.edit',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29637,	'admin.restriction-trajet-vehicule.delete',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29638,	'admin.restriction-trajet-vehicule.bulk-delete',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29639,	'admin.tarif-transfert-voyage',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29640,	'admin.tarif-transfert-voyage.index',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29641,	'admin.tarif-transfert-voyage.create',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29642,	'admin.tarif-transfert-voyage.show',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29643,	'admin.tarif-transfert-voyage.edit',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29644,	'admin.tarif-transfert-voyage.delete',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43'),
(29645,	'admin.tarif-transfert-voyage.bulk-delete',	'admin',	'2021-07-30 12:06:43',	'2021-07-30 12:06:43');

DROP TABLE IF EXISTS `planing_time`;
CREATE TABLE `planing_time` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debut` time NOT NULL,
  `fin` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `prestataire`;
CREATE TABLE `prestataire` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `heure_ouverture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '00:00',
  `heure_fermeture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '00:00',
  `logo` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prestataire_name_unique` (`name`),
  KEY `prestataire_ville_id_foreign` (`ville_id`),
  CONSTRAINT `prestataire_ville_id_foreign` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `prestataire` (`id`, `name`, `adresse`, `phone`, `email`, `heure_ouverture`, `heure_fermeture`, `logo`, `ville_id`, `created_at`, `updated_at`) VALUES
(1,	'Prestataire 1',	'Antananarivo',	'0328565583',	'Administrator@brackets.sk',	NULL,	NULL,	NULL,	1,	'2021-07-30 12:07:31',	'2021-07-30 12:07:31');

DROP TABLE IF EXISTS `restriction_trajet_vehicule`;
CREATE TABLE `restriction_trajet_vehicule` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agence_location_depart` bigint(20) unsigned NOT NULL,
  `agence_location_arrive` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `restriction_trajet_vehicule_agence_location_depart_foreign` (`agence_location_depart`),
  KEY `restriction_trajet_vehicule_agence_location_arrive_foreign` (`agence_location_arrive`),
  CONSTRAINT `restriction_trajet_vehicule_agence_location_arrive_foreign` FOREIGN KEY (`agence_location_arrive`) REFERENCES `agence_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `restriction_trajet_vehicule_agence_location_depart_foreign` FOREIGN KEY (`agence_location_depart`) REFERENCES `agence_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1,	'Administrator',	'admin',	'2021-04-20 16:50:33',	'2021-04-20 16:50:33');

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1,	1),
(2,	1),
(3,	1),
(4,	1),
(5,	1),
(6,	1),
(7,	1),
(8,	1),
(9,	1),
(6532,	1),
(6533,	1),
(6534,	1),
(6535,	1),
(6536,	1),
(6537,	1),
(6538,	1),
(7045,	1),
(7046,	1),
(7047,	1),
(7048,	1),
(7049,	1),
(7050,	1),
(7051,	1),
(8679,	1),
(10471,	1),
(29238,	1),
(29239,	1),
(29240,	1),
(29241,	1),
(29242,	1),
(29243,	1),
(29244,	1),
(29245,	1),
(29246,	1),
(29247,	1),
(29248,	1),
(29249,	1),
(29250,	1),
(29251,	1),
(29252,	1),
(29253,	1),
(29254,	1),
(29255,	1),
(29256,	1),
(29257,	1),
(29258,	1),
(29259,	1),
(29260,	1),
(29261,	1),
(29262,	1),
(29263,	1),
(29264,	1),
(29265,	1),
(29266,	1),
(29267,	1),
(29268,	1),
(29269,	1),
(29270,	1),
(29271,	1),
(29272,	1),
(29273,	1),
(29274,	1),
(29275,	1),
(29276,	1),
(29277,	1),
(29278,	1),
(29279,	1),
(29280,	1),
(29281,	1),
(29282,	1),
(29283,	1),
(29284,	1),
(29285,	1),
(29286,	1),
(29287,	1),
(29288,	1),
(29289,	1),
(29290,	1),
(29291,	1),
(29292,	1),
(29293,	1),
(29294,	1),
(29295,	1),
(29296,	1),
(29297,	1),
(29298,	1),
(29299,	1),
(29300,	1),
(29301,	1),
(29302,	1),
(29303,	1),
(29304,	1),
(29305,	1),
(29306,	1),
(29307,	1),
(29308,	1),
(29309,	1),
(29310,	1),
(29311,	1),
(29312,	1),
(29313,	1),
(29314,	1),
(29315,	1),
(29316,	1),
(29317,	1),
(29318,	1),
(29319,	1),
(29320,	1),
(29321,	1),
(29322,	1),
(29323,	1),
(29324,	1),
(29325,	1),
(29326,	1),
(29327,	1),
(29328,	1),
(29329,	1),
(29330,	1),
(29331,	1),
(29332,	1),
(29333,	1),
(29334,	1),
(29335,	1),
(29336,	1),
(29337,	1),
(29338,	1),
(29339,	1),
(29340,	1),
(29341,	1),
(29342,	1),
(29343,	1),
(29344,	1),
(29345,	1),
(29346,	1),
(29347,	1),
(29348,	1),
(29349,	1),
(29350,	1),
(29351,	1),
(29352,	1),
(29353,	1),
(29354,	1),
(29355,	1),
(29356,	1),
(29357,	1),
(29358,	1),
(29359,	1),
(29360,	1),
(29361,	1),
(29362,	1),
(29363,	1),
(29364,	1),
(29365,	1),
(29366,	1),
(29367,	1),
(29368,	1),
(29369,	1),
(29370,	1),
(29371,	1),
(29372,	1),
(29373,	1),
(29374,	1),
(29375,	1),
(29376,	1),
(29377,	1),
(29378,	1),
(29379,	1),
(29380,	1),
(29381,	1),
(29382,	1),
(29383,	1),
(29384,	1),
(29385,	1),
(29386,	1),
(29387,	1),
(29388,	1),
(29389,	1),
(29390,	1),
(29391,	1),
(29392,	1),
(29393,	1),
(29394,	1),
(29395,	1),
(29396,	1),
(29397,	1),
(29398,	1),
(29399,	1),
(29400,	1),
(29401,	1),
(29402,	1),
(29403,	1),
(29404,	1),
(29405,	1),
(29406,	1),
(29407,	1),
(29408,	1),
(29409,	1),
(29410,	1),
(29411,	1),
(29412,	1),
(29413,	1),
(29414,	1),
(29415,	1),
(29416,	1),
(29417,	1),
(29418,	1),
(29419,	1),
(29420,	1),
(29421,	1),
(29422,	1),
(29423,	1),
(29424,	1),
(29425,	1),
(29426,	1),
(29427,	1),
(29428,	1),
(29429,	1),
(29430,	1),
(29431,	1),
(29432,	1),
(29433,	1),
(29434,	1),
(29435,	1),
(29436,	1),
(29437,	1),
(29438,	1),
(29439,	1),
(29440,	1),
(29441,	1),
(29442,	1),
(29443,	1),
(29444,	1),
(29445,	1),
(29446,	1),
(29447,	1),
(29448,	1),
(29449,	1),
(29450,	1),
(29451,	1),
(29452,	1),
(29453,	1),
(29454,	1),
(29455,	1),
(29456,	1),
(29457,	1),
(29458,	1),
(29459,	1),
(29460,	1),
(29461,	1),
(29462,	1),
(29463,	1),
(29464,	1),
(29465,	1),
(29466,	1),
(29467,	1),
(29468,	1),
(29469,	1),
(29470,	1),
(29471,	1),
(29472,	1),
(29473,	1),
(29474,	1),
(29475,	1),
(29476,	1),
(29477,	1),
(29478,	1),
(29479,	1),
(29480,	1),
(29481,	1),
(29482,	1),
(29483,	1),
(29484,	1),
(29485,	1),
(29486,	1),
(29487,	1),
(29488,	1),
(29489,	1),
(29490,	1),
(29491,	1),
(29492,	1),
(29493,	1),
(29494,	1),
(29495,	1),
(29496,	1),
(29497,	1),
(29498,	1),
(29499,	1),
(29500,	1),
(29501,	1),
(29502,	1),
(29503,	1),
(29504,	1),
(29505,	1),
(29506,	1),
(29507,	1),
(29508,	1),
(29509,	1),
(29510,	1),
(29511,	1),
(29512,	1),
(29513,	1),
(29514,	1),
(29515,	1),
(29516,	1),
(29517,	1),
(29518,	1),
(29519,	1),
(29520,	1),
(29521,	1),
(29522,	1),
(29523,	1),
(29524,	1),
(29525,	1),
(29526,	1),
(29527,	1),
(29528,	1),
(29529,	1),
(29530,	1),
(29531,	1),
(29532,	1),
(29533,	1),
(29534,	1),
(29535,	1),
(29536,	1),
(29537,	1),
(29538,	1),
(29539,	1),
(29540,	1),
(29541,	1),
(29542,	1),
(29543,	1),
(29544,	1),
(29545,	1),
(29546,	1),
(29547,	1),
(29548,	1),
(29549,	1),
(29550,	1),
(29551,	1),
(29552,	1),
(29553,	1),
(29554,	1),
(29555,	1),
(29556,	1),
(29557,	1),
(29558,	1),
(29559,	1),
(29560,	1),
(29561,	1),
(29562,	1),
(29563,	1),
(29564,	1),
(29565,	1),
(29566,	1),
(29567,	1),
(29568,	1),
(29569,	1),
(29570,	1),
(29571,	1),
(29572,	1),
(29573,	1),
(29574,	1),
(29575,	1),
(29576,	1),
(29577,	1),
(29578,	1),
(29579,	1),
(29580,	1),
(29581,	1),
(29582,	1),
(29583,	1),
(29584,	1),
(29585,	1),
(29586,	1),
(29587,	1),
(29588,	1),
(29589,	1),
(29590,	1),
(29591,	1),
(29592,	1),
(29593,	1),
(29594,	1),
(29595,	1),
(29596,	1),
(29597,	1),
(29598,	1),
(29599,	1),
(29600,	1),
(29601,	1),
(29602,	1),
(29603,	1),
(29604,	1),
(29605,	1),
(29606,	1),
(29607,	1),
(29608,	1),
(29609,	1),
(29610,	1),
(29611,	1),
(29612,	1),
(29613,	1),
(29614,	1),
(29615,	1),
(29616,	1),
(29617,	1),
(29618,	1),
(29619,	1),
(29620,	1),
(29621,	1),
(29622,	1),
(29623,	1),
(29624,	1),
(29625,	1),
(29626,	1),
(29627,	1),
(29628,	1),
(29629,	1),
(29630,	1),
(29631,	1),
(29632,	1),
(29633,	1),
(29634,	1),
(29635,	1),
(29636,	1),
(29637,	1),
(29638,	1),
(29639,	1),
(29640,	1),
(29641,	1),
(29642,	1),
(29643,	1),
(29644,	1),
(29645,	1);

DROP TABLE IF EXISTS `saisons`;
CREATE TABLE `saisons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_saison` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `saisons` (`id`, `titre`, `debut`, `fin`, `description`, `model_saison`, `created_at`, `updated_at`) VALUES
(1,	'Saison 1',	'2021-07-31',	'2021-08-08',	NULL,	'hebergement',	'2021-07-30 12:14:48',	'2021-07-30 12:14:48'),
(2,	'Saison 1',	'2021-08-01',	'2021-08-04',	NULL,	'excursion',	'2021-07-30 18:10:38',	'2021-07-30 18:10:38');

DROP TABLE IF EXISTS `service_aeroport`;
CREATE TABLE `service_aeroport` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_aeroport_ville_id_foreign` (`ville_id`),
  CONSTRAINT `service_aeroport_ville_id_foreign` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_aeroport` (`id`, `code_service`, `name`, `adresse`, `phone`, `email`, `logo`, `ville_id`, `created_at`, `updated_at`) VALUES
(1,	'12550',	'Aeroport 1',	'Antananarivo',	'0328565583',	'Administrator@brackets.sk',	NULL,	1,	'2021-07-30 14:19:11',	'2021-07-30 14:19:11'),
(2,	'789454',	'Aeroport 2',	'Antananarivo',	'0328565583',	'Administrator@brackets.sk',	NULL,	1,	'2021-07-30 14:19:31',	'2021-07-30 14:19:31');

DROP TABLE IF EXISTS `service_port`;
CREATE TABLE `service_port` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_service` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_port_ville_id_foreign` (`ville_id`),
  CONSTRAINT `service_port_ville_id_foreign` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_port` (`id`, `code_service`, `name`, `adresse`, `phone`, `email`, `logo`, `ville_id`, `created_at`, `updated_at`) VALUES
(1,	'12550',	'Port 1',	'Antananarivo',	'0328565583',	'Administrator@brackets.sk',	NULL,	1,	'2021-07-30 17:42:29',	'2021-07-30 17:44:12'),
(2,	'12555',	'Port 2',	'Antananarivo',	'0328565583',	'Administrator@brackets.sk',	NULL,	1,	'2021-07-30 17:44:04',	'2021-07-30 17:44:04');

DROP TABLE IF EXISTS `supplement_activite`;
CREATE TABLE `supplement_activite` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regle_tarif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hebergement_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supplement_activite_titre_unique` (`titre`),
  KEY `supplement_activite_hebergement_id_foreign` (`hebergement_id`),
  CONSTRAINT `supplement_activite_hebergement_id_foreign` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `supplement_excursion`;
CREATE TABLE `supplement_excursion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excursion_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supplement_excursion_titre_unique` (`titre`),
  KEY `supplement_excursion_excursion_id_foreign` (`excursion_id`),
  CONSTRAINT `supplement_excursion_excursion_id_foreign` FOREIGN KEY (`excursion_id`) REFERENCES `excursions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `supplement_excursion` (`id`, `titre`, `description`, `excursion_id`, `created_at`, `updated_at`) VALUES
(1,	'Supplement 1',	NULL,	1,	'2021-07-30 17:46:07',	'2021-07-30 17:46:07'),
(2,	'Supplement 2',	NULL,	1,	'2021-07-30 17:46:33',	'2021-07-30 17:46:33');

DROP TABLE IF EXISTS `supplement_pension`;
CREATE TABLE `supplement_pension` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regle_tarif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hebergement_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supplement_pension_titre_unique` (`titre`),
  KEY `supplement_pension_hebergement_id_foreign` (`hebergement_id`),
  CONSTRAINT `supplement_pension_hebergement_id_foreign` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `supplement_vue`;
CREATE TABLE `supplement_vue` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regle_tarif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hebergement_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supplement_vue_titre_unique` (`titre`),
  KEY `supplement_vue_hebergement_id_foreign` (`hebergement_id`),
  CONSTRAINT `supplement_vue_hebergement_id_foreign` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tarifs`;
CREATE TABLE `tarifs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marge` double(8,2) NOT NULL DEFAULT 0.00,
  `taxe_active` int(11) NOT NULL DEFAULT 0,
  `taxe` double(8,2) NOT NULL DEFAULT 0.00,
  `jour_min` int(11) DEFAULT NULL,
  `jour_max` int(11) DEFAULT NULL,
  `nuit_min` int(11) DEFAULT NULL,
  `nuit_max` int(11) DEFAULT NULL,
  `type_chambre_id` bigint(20) unsigned NOT NULL,
  `hebergement_id` bigint(20) unsigned NOT NULL,
  `saison_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarifs_type_chambre_id_foreign` (`type_chambre_id`),
  KEY `tarifs_hebergement_id_foreign` (`hebergement_id`),
  KEY `tarifs_saison_id_foreign` (`saison_id`),
  CONSTRAINT `tarifs_hebergement_id_foreign` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarifs_saison_id_foreign` FOREIGN KEY (`saison_id`) REFERENCES `saisons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarifs_type_chambre_id_foreign` FOREIGN KEY (`type_chambre_id`) REFERENCES `type_chambre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tarifs` (`id`, `titre`, `description`, `marge`, `taxe_active`, `taxe`, `jour_min`, `jour_max`, `nuit_min`, `nuit_max`, `type_chambre_id`, `hebergement_id`, `saison_id`, `created_at`, `updated_at`) VALUES
(1,	'Tarif 1',	NULL,	0.00,	0,	0.00,	NULL,	NULL,	NULL,	NULL,	1,	1,	1,	'2021-07-30 12:15:38',	'2021-07-30 12:15:38'),
(2,	'Tarif 2',	NULL,	0.00,	0,	0.00,	NULL,	NULL,	NULL,	NULL,	2,	1,	1,	'2021-07-30 13:53:06',	'2021-07-30 13:53:06'),
(3,	'Tarif 1 1',	NULL,	0.00,	0,	0.00,	NULL,	NULL,	NULL,	NULL,	4,	2,	1,	'2021-07-30 17:12:23',	'2021-07-30 17:12:23');

DROP TABLE IF EXISTS `tarif_billeterie_maritime`;
CREATE TABLE `tarif_billeterie_maritime` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `billeterie_maritime_id` bigint(20) unsigned NOT NULL,
  `type_personne_id` bigint(20) unsigned NOT NULL,
  `prix_achat_aller` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `prix_achat_aller_retour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `marge_aller` double(8,2) NOT NULL DEFAULT 0.00,
  `marge_aller_retour` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_vente_aller` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `prix_vente_aller_retour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarif_billeterie_maritime_billeterie_maritime_id_foreign` (`billeterie_maritime_id`),
  KEY `tarif_billeterie_maritime_type_personne_id_foreign` (`type_personne_id`),
  CONSTRAINT `tarif_billeterie_maritime_billeterie_maritime_id_foreign` FOREIGN KEY (`billeterie_maritime_id`) REFERENCES `billeterie_maritime` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_billeterie_maritime_type_personne_id_foreign` FOREIGN KEY (`type_personne_id`) REFERENCES `type_personne` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tarif_excursion`;
CREATE TABLE `tarif_excursion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prix_achat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `marge` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_vente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `excursion_id` bigint(20) unsigned NOT NULL,
  `saison_id` bigint(20) unsigned NOT NULL,
  `type_personne_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarif_excursion_excursion_id_foreign` (`excursion_id`),
  KEY `tarif_excursion_saison_id_foreign` (`saison_id`),
  KEY `tarif_excursion_type_personne_id_foreign` (`type_personne_id`),
  CONSTRAINT `tarif_excursion_excursion_id_foreign` FOREIGN KEY (`excursion_id`) REFERENCES `excursions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_excursion_saison_id_foreign` FOREIGN KEY (`saison_id`) REFERENCES `saisons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_excursion_type_personne_id_foreign` FOREIGN KEY (`type_personne_id`) REFERENCES `type_personne` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tarif_supplement_activite`;
CREATE TABLE `tarif_supplement_activite` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prix_achat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `marge` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_vente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `type_personne_id` bigint(20) unsigned NOT NULL,
  `supplement_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarif_supplement_activite_type_personne_id_foreign` (`type_personne_id`),
  KEY `tarif_supplement_activite_supplement_id_foreign` (`supplement_id`),
  CONSTRAINT `tarif_supplement_activite_supplement_id_foreign` FOREIGN KEY (`supplement_id`) REFERENCES `supplement_activite` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_supplement_activite_type_personne_id_foreign` FOREIGN KEY (`type_personne_id`) REFERENCES `type_personne` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tarif_supplement_excursion`;
CREATE TABLE `tarif_supplement_excursion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `supplement_excursion_id` bigint(20) unsigned NOT NULL,
  `type_personne_id` bigint(20) unsigned NOT NULL,
  `prix_achat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `marge` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_vente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarif_supplement_excursion_supplement_excursion_id_foreign` (`supplement_excursion_id`),
  KEY `tarif_supplement_excursion_type_personne_id_foreign` (`type_personne_id`),
  CONSTRAINT `tarif_supplement_excursion_supplement_excursion_id_foreign` FOREIGN KEY (`supplement_excursion_id`) REFERENCES `supplement_excursion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_supplement_excursion_type_personne_id_foreign` FOREIGN KEY (`type_personne_id`) REFERENCES `type_personne` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tarif_supplement_excursion` (`id`, `supplement_excursion_id`, `type_personne_id`, `prix_achat`, `marge`, `prix_vente`, `created_at`, `updated_at`) VALUES
(1,	1,	1,	'0',	0.00,	'120',	'2021-07-30 17:46:07',	'2021-07-30 17:46:07'),
(2,	1,	2,	'0',	0.00,	'250',	'2021-07-30 17:46:07',	'2021-07-30 17:46:07'),
(3,	1,	3,	'0',	0.00,	'230',	'2021-07-30 17:46:07',	'2021-07-30 17:46:07'),
(4,	2,	1,	'0',	0.00,	'100',	'2021-07-30 17:46:33',	'2021-07-30 17:46:33'),
(5,	2,	2,	'0',	0.00,	'300',	'2021-07-30 17:46:33',	'2021-07-30 17:46:33'),
(6,	2,	3,	'0',	0.00,	'200',	'2021-07-30 17:46:33',	'2021-07-30 17:46:33');

DROP TABLE IF EXISTS `tarif_supplement_pension`;
CREATE TABLE `tarif_supplement_pension` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prix_achat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `marge` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_vente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `type_personne_id` bigint(20) unsigned NOT NULL,
  `supplement_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarif_supplement_pension_type_personne_id_foreign` (`type_personne_id`),
  KEY `tarif_supplement_pension_supplement_id_foreign` (`supplement_id`),
  CONSTRAINT `tarif_supplement_pension_supplement_id_foreign` FOREIGN KEY (`supplement_id`) REFERENCES `supplement_pension` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_supplement_pension_type_personne_id_foreign` FOREIGN KEY (`type_personne_id`) REFERENCES `type_personne` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tarif_supplement_vue`;
CREATE TABLE `tarif_supplement_vue` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prix_achat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `marge` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_vente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `supplement_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarif_supplement_vue_supplement_id_foreign` (`supplement_id`),
  CONSTRAINT `tarif_supplement_vue_supplement_id_foreign` FOREIGN KEY (`supplement_id`) REFERENCES `supplement_vue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tarif_tranche_saison`;
CREATE TABLE `tarif_tranche_saison` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tarif_tranche_saison_location`;
CREATE TABLE `tarif_tranche_saison_location` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `marge` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_achat` double(8,2) NOT NULL,
  `prix_vente` double(8,2) NOT NULL,
  `tranche_saison_id` bigint(20) unsigned NOT NULL,
  `vehicule_location_id` bigint(20) unsigned NOT NULL,
  `saisons_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarif_tranche_saison_location_tranche_saison_id_foreign` (`tranche_saison_id`),
  KEY `tarif_tranche_saison_location_vehicule_location_id_foreign` (`vehicule_location_id`),
  KEY `tarif_tranche_saison_location_saisons_id_foreign` (`saisons_id`),
  CONSTRAINT `tarif_tranche_saison_location_saisons_id_foreign` FOREIGN KEY (`saisons_id`) REFERENCES `saisons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_tranche_saison_location_tranche_saison_id_foreign` FOREIGN KEY (`tranche_saison_id`) REFERENCES `tranche_saison` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_tranche_saison_location_vehicule_location_id_foreign` FOREIGN KEY (`vehicule_location_id`) REFERENCES `vehicule_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tarif_transfert_voyage`;
CREATE TABLE `tarif_transfert_voyage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `trajet_transfert_voyage_id` bigint(20) unsigned NOT NULL,
  `tranche_transfert_voyage_id` bigint(20) unsigned NOT NULL,
  `type_personne_id` bigint(20) unsigned NOT NULL,
  `prix_achat_aller` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_achat_aller_retour` double(8,2) NOT NULL DEFAULT 0.00,
  `marge_aller` double(8,2) NOT NULL DEFAULT 0.00,
  `marge_aller_retour` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_vente_aller` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_vente_aller_retour` double(8,2) NOT NULL DEFAULT 0.00,
  `prime_nuit` double(8,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarif_transfert_voyage_trajet_transfert_voyage_id_foreign` (`trajet_transfert_voyage_id`),
  KEY `tarif_transfert_voyage_tranche_transfert_voyage_id_foreign` (`tranche_transfert_voyage_id`),
  KEY `tarif_transfert_voyage_type_personne_id_foreign` (`type_personne_id`),
  CONSTRAINT `tarif_transfert_voyage_trajet_transfert_voyage_id_foreign` FOREIGN KEY (`trajet_transfert_voyage_id`) REFERENCES `trajet_transfert_voyage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_transfert_voyage_tranche_transfert_voyage_id_foreign` FOREIGN KEY (`tranche_transfert_voyage_id`) REFERENCES `tranche_personne_transfert_voyage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_transfert_voyage_type_personne_id_foreign` FOREIGN KEY (`type_personne_id`) REFERENCES `type_personne` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tarif_transfert_voyage` (`id`, `trajet_transfert_voyage_id`, `tranche_transfert_voyage_id`, `type_personne_id`, `prix_achat_aller`, `prix_achat_aller_retour`, `marge_aller`, `marge_aller_retour`, `prix_vente_aller`, `prix_vente_aller_retour`, `prime_nuit`, `created_at`, `updated_at`) VALUES
(4,	1,	1,	1,	5.00,	5.00,	5.00,	5.00,	10.00,	10.00,	0.00,	'2021-07-30 15:49:32',	'2021-07-30 15:49:32'),
(5,	1,	1,	2,	5.00,	5.00,	5.00,	5.00,	10.00,	10.00,	0.00,	'2021-07-30 15:49:32',	'2021-07-30 15:49:32'),
(6,	1,	1,	3,	5.00,	5.00,	5.00,	5.00,	10.00,	10.00,	0.00,	'2021-07-30 15:49:32',	'2021-07-30 15:49:32');

DROP TABLE IF EXISTS `tarif_type_personne_hebergement`;
CREATE TABLE `tarif_type_personne_hebergement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prix_achat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `marge` double(8,2) NOT NULL DEFAULT 0.00,
  `prix_vente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `type_personne_id` bigint(20) unsigned NOT NULL,
  `tarif_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tarif_type_personne_hebergement_type_personne_id_foreign` (`type_personne_id`),
  KEY `tarif_type_personne_hebergement_tarif_id_foreign` (`tarif_id`),
  CONSTRAINT `tarif_type_personne_hebergement_tarif_id_foreign` FOREIGN KEY (`tarif_id`) REFERENCES `tarifs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tarif_type_personne_hebergement_type_personne_id_foreign` FOREIGN KEY (`type_personne_id`) REFERENCES `type_personne` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tarif_type_personne_hebergement` (`id`, `prix_achat`, `marge`, `prix_vente`, `type_personne_id`, `tarif_id`, `created_at`, `updated_at`) VALUES
(1,	'5',	2.00,	'7',	1,	1,	'2021-07-30 12:15:38',	'2021-07-30 12:25:45'),
(2,	'123',	0.00,	'123',	2,	1,	'2021-07-30 12:15:38',	'2021-07-30 14:12:05'),
(3,	'12',	0.00,	'12',	1,	2,	'2021-07-30 13:53:06',	'2021-07-30 13:53:06'),
(4,	'123',	0.00,	'123',	2,	2,	'2021-07-30 13:53:06',	'2021-07-30 13:53:06'),
(5,	'12',	12.00,	'24',	1,	3,	'2021-07-30 17:12:23',	'2021-07-30 17:12:23'),
(6,	'20',	12.00,	'32',	2,	3,	'2021-07-30 17:12:23',	'2021-07-30 17:12:23'),
(7,	'30',	30.00,	'60',	3,	3,	'2021-07-30 17:12:23',	'2021-07-30 17:12:23');

DROP TABLE IF EXISTS `taxe`;
CREATE TABLE `taxe` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taxe_appliquer` int(11) NOT NULL DEFAULT 0,
  `valeur_pourcent` double(8,2) NOT NULL DEFAULT 0.00,
  `valeur_devises` double(8,2) NOT NULL DEFAULT 0.00,
  `descciption` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `taxe_excursion`;
CREATE TABLE `taxe_excursion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tarif_excursion_id` bigint(20) unsigned NOT NULL,
  `taxe_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `taxe_excursion_tarif_excursion_id_foreign` (`tarif_excursion_id`),
  KEY `taxe_excursion_taxe_id_foreign` (`taxe_id`),
  CONSTRAINT `taxe_excursion_tarif_excursion_id_foreign` FOREIGN KEY (`tarif_excursion_id`) REFERENCES `tarif_excursion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `taxe_excursion_taxe_id_foreign` FOREIGN KEY (`taxe_id`) REFERENCES `taxe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `trajet_transfert_voyage`;
CREATE TABLE `trajet_transfert_voyage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `point_depart` bigint(20) unsigned NOT NULL,
  `point_arrive` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trajet_transfert_voyage_point_depart_foreign` (`point_depart`),
  KEY `trajet_transfert_voyage_point_arrive_foreign` (`point_arrive`),
  CONSTRAINT `trajet_transfert_voyage_point_arrive_foreign` FOREIGN KEY (`point_arrive`) REFERENCES `lieu_transfert` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `trajet_transfert_voyage_point_depart_foreign` FOREIGN KEY (`point_depart`) REFERENCES `lieu_transfert` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `trajet_transfert_voyage` (`id`, `titre`, `description`, `card`, `point_depart`, `point_arrive`, `created_at`, `updated_at`) VALUES
(1,	'Aéroport Pôle Caraïbes - Saint-françois',	'<p>f<br></p>',	NULL,	1,	2,	'2021-07-30 15:41:22',	'2021-07-30 16:47:07');

DROP TABLE IF EXISTS `tranche_personne_transfert_voyage`;
CREATE TABLE `tranche_personne_transfert_voyage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_min` int(11) NOT NULL,
  `nombre_max` int(11) NOT NULL,
  `type_transfert_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tranche_personne_transfert_voyage_type_transfert_id_foreign` (`type_transfert_id`),
  CONSTRAINT `tranche_personne_transfert_voyage_type_transfert_id_foreign` FOREIGN KEY (`type_transfert_id`) REFERENCES `type_transfert_voyage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tranche_personne_transfert_voyage` (`id`, `titre`, `nombre_min`, `nombre_max`, `type_transfert_id`, `created_at`, `updated_at`) VALUES
(1,	'1 à 2 pers',	1,	2,	1,	'2021-07-30 15:45:12',	'2021-07-30 15:45:12'),
(2,	'3 à 4 pers',	3,	4,	1,	'2021-07-30 15:45:42',	'2021-07-30 15:45:42');

DROP TABLE IF EXISTS `tranche_saison`;
CREATE TABLE `tranche_saison` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_min` int(11) NOT NULL,
  `nombre_max` int(11) NOT NULL,
  `model_saison` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `transfert_voyage_prime_nuit`;
CREATE TABLE `transfert_voyage_prime_nuit` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `trajet_id` bigint(20) unsigned NOT NULL,
  `type_transfert_id` bigint(20) unsigned NOT NULL,
  `prime_nuit` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfert_voyage_prime_nuit_trajet_id_foreign` (`trajet_id`),
  KEY `transfert_voyage_prime_nuit_type_transfert_id_foreign` (`type_transfert_id`),
  CONSTRAINT `transfert_voyage_prime_nuit_trajet_id_foreign` FOREIGN KEY (`trajet_id`) REFERENCES `trajet_transfert_voyage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transfert_voyage_prime_nuit_type_transfert_id_foreign` FOREIGN KEY (`type_transfert_id`) REFERENCES `type_transfert_voyage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `transfert_voyage_prime_nuit` (`id`, `trajet_id`, `type_transfert_id`, `prime_nuit`, `created_at`, `updated_at`) VALUES
(1,	1,	1,	2.00,	NULL,	NULL);

DROP TABLE IF EXISTS `translations`;
CREATE TABLE `translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namespace` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '*',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`text`)),
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `translations_namespace_index` (`namespace`),
  KEY `translations_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=921 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `translations` (`id`, `namespace`, `group`, `key`, `text`, `metadata`, `created_at`, `updated_at`, `deleted_at`) VALUES
(595,	'brackets/admin-ui',	'admin',	'operation.succeeded',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(596,	'brackets/admin-ui',	'admin',	'operation.failed',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(597,	'brackets/admin-ui',	'admin',	'operation.not_allowed',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(598,	'*',	'auth',	'throttle',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(599,	'*',	'admin',	'admin-user.columns.first_name',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(600,	'*',	'admin',	'admin-user.columns.last_name',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(601,	'*',	'admin',	'admin-user.columns.email',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(602,	'*',	'admin',	'admin-user.columns.password',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(603,	'*',	'admin',	'admin-user.columns.password_repeat',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(604,	'*',	'admin',	'admin-user.columns.activated',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(605,	'*',	'admin',	'admin-user.columns.forbidden',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(606,	'*',	'admin',	'admin-user.columns.language',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(607,	'brackets/admin-ui',	'admin',	'forms.select_an_option',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(608,	'*',	'admin',	'admin-user.columns.roles',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(609,	'brackets/admin-ui',	'admin',	'forms.select_options',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(610,	'*',	'admin',	'admin-user.actions.create',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(611,	'*',	'admin-base',	'btn.save',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(612,	'*',	'admin',	'admin-user.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(613,	'*',	'admin',	'admin-user.actions.index',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(614,	'brackets/admin-ui',	'admin',	'placeholder.search',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(615,	'brackets/admin-ui',	'admin',	'btn.search',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(616,	'*',	'admin',	'admin-user.columns.id',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(617,	'*',	'admin',	'admin-user.columns.last_login_at',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(618,	'brackets/admin-ui',	'admin',	'btn.edit',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(619,	'brackets/admin-ui',	'admin',	'btn.delete',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(620,	'*',	'admin-base',	'pagination.overview',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(621,	'*',	'admin-base',	'index.no_items',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(622,	'*',	'admin-base',	'index.try_changing_items',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(623,	'brackets/admin-ui',	'admin',	'btn.new',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(624,	'*',	'admin',	'base-type.columns.titre',	'[]',	NULL,	'2021-05-07 17:51:46',	'2021-05-13 10:00:48',	NULL),
(625,	'*',	'admin',	'base-type.columns.description',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(626,	'*',	'admin',	'base-type.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(627,	'brackets/admin-ui',	'admin',	'btn.save',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(628,	'*',	'admin',	'base-type.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(629,	'*',	'admin',	'base-type.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(630,	'*',	'admin',	'base-type.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(631,	'brackets/admin-ui',	'admin',	'listing.selected_items',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(632,	'brackets/admin-ui',	'admin',	'listing.check_all_items',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(633,	'brackets/admin-ui',	'admin',	'listing.uncheck_all_items',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(634,	'brackets/admin-ui',	'admin',	'pagination.overview',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(635,	'brackets/admin-ui',	'admin',	'index.no_items',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(636,	'brackets/admin-ui',	'admin',	'index.try_changing_items',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(637,	'*',	'admin',	'chambre.columns.titre',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(638,	'*',	'admin',	'chambre.columns.base_type_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(639,	'*',	'admin',	'chambre.columns.type_chambre',	'{\"en\":\"Type chambre\",\"fr\":null}',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(640,	'*',	'admin',	'type-chambre.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(641,	'*',	'admin',	'chambre.columns.description',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(642,	'*',	'admin',	'chambre.columns.status',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(643,	'*',	'admin',	'chambre.columns.image',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(644,	'*',	'admin',	'chambre.actions.uploadImage',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(645,	'*',	'admin',	'chambre.columns.hebergement_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(646,	'*',	'admin',	'type-chambre.columns.name',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(647,	'*',	'admin',	'type-chambre.columns.description',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(648,	'*',	'admin',	'chambre.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(649,	'*',	'admin',	'chambre.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(650,	'*',	'admin',	'chambre.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(651,	'*',	'admin-base',	'placeholder.search',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(652,	'*',	'admin-base',	'btn.search',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(653,	'*',	'admin',	'chambre.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(654,	'*',	'admin',	'chambre.columns.type_chambre_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(655,	'*',	'admin-base',	'listing.selected_items',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(656,	'*',	'admin-base',	'listing.check_all_items',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(657,	'*',	'admin-base',	'listing.uncheck_all_items',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(658,	'*',	'admin-base',	'btn.delete',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(659,	'*',	'admin-base',	'btn.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(660,	'brackets/admin-ui',	'admin',	'media_uploader.max_number_of_files',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(661,	'brackets/admin-ui',	'admin',	'media_uploader.max_size_pre_file',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(662,	'brackets/admin-ui',	'admin',	'media_uploader.private_title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(663,	'*',	'admin',	'devise.columns.titre',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(664,	'*',	'admin',	'devise.columns.symbole',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(665,	'*',	'admin',	'devise.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(666,	'*',	'admin',	'devise.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(667,	'*',	'admin',	'devise.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(668,	'*',	'admin',	'devise.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(669,	'*',	'admin',	'devises.columns.titre',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(670,	'*',	'admin',	'devises.columns.symbole',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(671,	'*',	'admin',	'hebergement.columns.name',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(672,	'*',	'admin',	'hebergement.columns.type_hebergement',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(673,	'*',	'admin',	'type-hebergement.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(674,	'*',	'admin',	'hebergement.columns.devises_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(675,	'*',	'admin',	'devises.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(676,	'*',	'admin',	'hebergement.columns.adresse',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(677,	'*',	'admin',	'hebergement.columns.ville_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(678,	'*',	'admin',	'ville.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(679,	'*',	'admin',	'hebergement.columns.description',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(680,	'*',	'admin',	'hebergement.columns.heure_ouverture',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(681,	'*',	'admin',	'hebergement.columns.heure_fermeture',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(682,	'*',	'admin',	'hebergement.columns.status',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(683,	'*',	'admin',	'hebergement.columns.image',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(684,	'*',	'admin',	'hebergement.actions.uploadImage',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(685,	'*',	'admin',	'hebergement.columns.prestataire_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(686,	'*',	'admin',	'pays.columns.nom',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(687,	'*',	'admin',	'prestataire.columns.name',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(688,	'*',	'admin',	'prestataire.columns.adresse',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(689,	'*',	'admin',	'prestataire.columns.phone',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(690,	'*',	'admin',	'prestataire.columns.email',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(691,	'*',	'admin',	'type-hebergement.columns.name',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(692,	'*',	'admin',	'type-hebergement.columns.description',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(693,	'*',	'admin',	'ville.columns.name',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(694,	'*',	'admin',	'ville.columns.code_postal',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(695,	'*',	'admin',	'ville.columns.pays_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(696,	'*',	'admin',	'pays.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(697,	'*',	'admin',	'prestataire.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(698,	'*',	'admin-base',	'btn.next',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(699,	'*',	'admin',	'hebergement.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(700,	'*',	'admin',	'hebergement.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(701,	'*',	'admin',	'prestataire.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(702,	'*',	'admin',	'prestataire.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(703,	'*',	'admin',	'hebergement.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(704,	'*',	'admin',	'prestataire.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(705,	'*',	'admin-base',	'btn.close',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(706,	'*',	'admin',	'hebergement.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(707,	'*',	'admin',	'island.columns.name',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(708,	'*',	'admin',	'island.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(709,	'*',	'admin',	'island.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(710,	'*',	'admin',	'island.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(711,	'*',	'admin',	'island.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(712,	'*',	'admin-base',	'profile_dropdown.account',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(713,	'*',	'admin-base',	'profile_dropdown.profile',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(714,	'*',	'admin-base',	'profile_dropdown.password',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(715,	'*',	'admin-base',	'profile_dropdown.logout',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(716,	'*',	'admin-base',	'sidebar.content',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(717,	'*',	'admin',	'nav.hebergement.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(718,	'*',	'admin',	'nav.hebergement.childre.tous',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(719,	'*',	'admin',	'nav.hebergement.childre.type',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(720,	'*',	'admin-base',	'sidebar.settings',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(721,	'*',	'admin',	'type-hebergement.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(722,	'*',	'admin',	'type-chambre.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(723,	'*',	'admin',	'island.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(724,	'*',	'admin',	'ville.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(725,	'*',	'admin',	'chambre.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(726,	'*',	'admin',	'hebergement.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(727,	'*',	'admin',	'saison.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(728,	'*',	'admin',	'tarif.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(729,	'*',	'admin',	'type-personne.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(730,	'*',	'admin',	'base-type.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(731,	'*',	'admin',	'devise.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(732,	'*',	'admin',	'pay.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(733,	'*',	'admin',	'supplement-pension.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(734,	'*',	'admin',	'supplement-activite.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(735,	'*',	'admin',	'supplement-vue.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(736,	'*',	'admin',	'pay.columns.nom',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(737,	'*',	'admin',	'pays.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(738,	'*',	'admin',	'pay.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(739,	'*',	'admin',	'pay.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(740,	'*',	'admin',	'pay.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(741,	'*',	'admin',	'prestataire.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(742,	'*',	'admin',	'admin-user.actions.edit_password',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(743,	'*',	'admin',	'admin-user.actions.edit_profile',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(744,	'*',	'admin',	'saison.columns.titre',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(745,	'*',	'admin',	'saison.columns.debut',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(746,	'*',	'admin',	'saison.columns.fin',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(747,	'*',	'admin',	'saison.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(748,	'*',	'admin',	'saison.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(749,	'*',	'admin',	'saison.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(750,	'*',	'admin',	'saison.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(751,	'*',	'admin',	'supplement-activite.columns.titre',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(752,	'*',	'admin',	'supplement-activite.columns.tarif',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(753,	'*',	'admin',	'supplement-activite.columns.regle_tarif',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(754,	'*',	'admin',	'supplement-activite.columns.description',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(755,	'*',	'admin',	'supplement-activite.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(756,	'*',	'admin',	'supplement-activite.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(757,	'*',	'admin',	'supplement-activite.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(758,	'*',	'admin',	'supplement-activite.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(759,	'*',	'admin',	'supplement-pension.columns.titre',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(760,	'*',	'admin',	'supplement-pension.columns.tarif',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(761,	'*',	'admin',	'supplement-pension.columns.regle_tarif',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(762,	'*',	'admin',	'supplement-pension.columns.description',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(763,	'*',	'admin',	'supplement-pension.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(764,	'*',	'admin',	'supplement-pension.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(765,	'*',	'admin',	'supplement-pension.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(766,	'*',	'admin',	'supplement-pension.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(767,	'*',	'admin',	'supplement-vue.columns.titre',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(768,	'*',	'admin',	'supplement-vue.columns.tarif',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(769,	'*',	'admin',	'supplement-vue.columns.regle_tarif',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(770,	'*',	'admin',	'supplement-vue.columns.description',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(771,	'*',	'admin',	'supplement-vue.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(772,	'*',	'admin',	'supplement-vue.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(773,	'*',	'admin',	'supplement-vue.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(774,	'*',	'admin',	'supplement-vue.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(775,	'*',	'admin',	'tarif.columns.montant',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(776,	'*',	'admin',	'tarif.columns.marge',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(777,	'*',	'admin',	'tarif.columns.prix_vente',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(778,	'*',	'admin',	'tarif.columns.chambre_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(779,	'*',	'admin',	'tarif.columns.saison_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(780,	'*',	'admin',	'tarif.columns.type_personne_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(781,	'*',	'admin',	'tarif.columns.description',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(782,	'*',	'admin',	'tarif.columns.taxe_active',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(783,	'*',	'admin',	'tarif.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(784,	'*',	'admin',	'tarif.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(785,	'*',	'admin',	'tarif.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(786,	'*',	'admin',	'tarif.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(787,	'*',	'admin',	'tarif.columns.devise',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(788,	'*',	'admin',	'type-chambre.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(789,	'*',	'admin',	'type-chambre.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(790,	'*',	'admin',	'type-chambre.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(791,	'*',	'admin',	'type-hebergement.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(792,	'*',	'admin',	'type-hebergement.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(793,	'*',	'admin',	'type-hebergement.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(794,	'*',	'admin',	'type-personne.columns.type',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(795,	'*',	'admin',	'type-personne.columns.age',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(796,	'*',	'admin',	'type-personne.columns.description',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(797,	'*',	'admin',	'type-personne.actions.create',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(798,	'*',	'admin',	'type-personne.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(799,	'*',	'admin',	'type-personne.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(800,	'*',	'admin',	'type-personne.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(801,	'*',	'admin',	'nav.info.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(802,	'*',	'admin',	'nav.chambre.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(803,	'*',	'admin',	'nav.chambre.childre.tous',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(804,	'*',	'admin',	'nav.chambre.childre.type',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(805,	'*',	'admin',	'nav.chambre.childre.base_type',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(806,	'*',	'admin',	'nav.saison.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(807,	'*',	'admin',	'nav.personne.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(808,	'*',	'admin',	'nav.tarif.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(809,	'*',	'admin',	'nav.supplement.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(810,	'*',	'admin',	'nav.supplement.childre.pension',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(811,	'*',	'admin',	'nav.supplement.childre.activite',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(812,	'*',	'admin',	'nav.supplement.childre.vue',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(813,	'*',	'admin',	'ville.actions.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(814,	'*',	'admin',	'ville.actions.index',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(815,	'*',	'admin',	'ville.columns.id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(816,	'*',	'admin',	'ville.columns.island_id',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(817,	'brackets/admin-auth',	'admin',	'activation_form.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(818,	'brackets/admin-auth',	'admin',	'activation_form.note',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(819,	'brackets/admin-auth',	'admin',	'auth_global.email',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(820,	'brackets/admin-auth',	'admin',	'activation_form.button',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(821,	'brackets/admin-auth',	'admin',	'login.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(822,	'brackets/admin-auth',	'admin',	'login.sign_in_text',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(823,	'brackets/admin-auth',	'admin',	'auth_global.password',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(824,	'brackets/admin-auth',	'admin',	'login.button',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(825,	'brackets/admin-auth',	'admin',	'login.forgot_password',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(826,	'brackets/admin-auth',	'admin',	'forgot_password.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(827,	'brackets/admin-auth',	'admin',	'forgot_password.note',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(828,	'brackets/admin-auth',	'admin',	'forgot_password.button',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(829,	'brackets/admin-auth',	'admin',	'password_reset.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(830,	'brackets/admin-auth',	'admin',	'password_reset.note',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(831,	'brackets/admin-auth',	'admin',	'auth_global.password_confirm',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(832,	'brackets/admin-auth',	'admin',	'password_reset.button',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(833,	'brackets/admin-auth',	'activations',	'email.line',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(834,	'brackets/admin-auth',	'activations',	'email.action',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(835,	'brackets/admin-auth',	'activations',	'email.notRequested',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(836,	'brackets/admin-auth',	'admin',	'activations.activated',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(837,	'brackets/admin-auth',	'admin',	'activations.invalid_request',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(838,	'brackets/admin-auth',	'admin',	'activations.disabled',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(839,	'brackets/admin-auth',	'admin',	'activations.sent',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(840,	'brackets/admin-auth',	'admin',	'passwords.sent',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(841,	'brackets/admin-auth',	'admin',	'passwords.reset',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(842,	'brackets/admin-auth',	'admin',	'passwords.invalid_token',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(843,	'brackets/admin-auth',	'admin',	'passwords.invalid_user',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(844,	'brackets/admin-auth',	'admin',	'passwords.invalid_password',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(845,	'brackets/admin-auth',	'resets',	'email.line',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(846,	'brackets/admin-auth',	'resets',	'email.action',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(847,	'brackets/admin-auth',	'resets',	'email.notRequested',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(848,	'*',	'auth',	'failed',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(849,	'brackets/admin-translations',	'admin',	'title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(850,	'brackets/admin-translations',	'admin',	'index.all_groups',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(851,	'brackets/admin-translations',	'admin',	'index.edit',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(852,	'brackets/admin-translations',	'admin',	'index.default_text',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(853,	'brackets/admin-translations',	'admin',	'index.translation',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(854,	'brackets/admin-translations',	'admin',	'index.translation_for_language',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(855,	'brackets/admin-translations',	'admin',	'import.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(856,	'brackets/admin-translations',	'admin',	'import.notice',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(857,	'brackets/admin-translations',	'admin',	'import.upload_file',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(858,	'brackets/admin-translations',	'admin',	'import.choose_file',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(859,	'brackets/admin-translations',	'admin',	'import.language_to_import',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(860,	'brackets/admin-translations',	'admin',	'fields.select_language',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(861,	'brackets/admin-translations',	'admin',	'import.do_not_override',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(862,	'brackets/admin-translations',	'admin',	'import.conflict_notice_we_have_found',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(863,	'brackets/admin-translations',	'admin',	'import.conflict_notice_translations_to_be_imported',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(864,	'brackets/admin-translations',	'admin',	'import.conflict_notice_differ',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(865,	'brackets/admin-translations',	'admin',	'fields.group',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(866,	'brackets/admin-translations',	'admin',	'fields.default',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(867,	'brackets/admin-translations',	'admin',	'fields.current_value',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(868,	'brackets/admin-translations',	'admin',	'fields.imported_value',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(869,	'brackets/admin-translations',	'admin',	'import.sucesfully_notice',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(870,	'brackets/admin-translations',	'admin',	'import.sucesfully_notice_update',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(871,	'brackets/admin-translations',	'admin',	'index.export',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(872,	'brackets/admin-translations',	'admin',	'export.notice',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(873,	'brackets/admin-translations',	'admin',	'export.language_to_export',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(874,	'brackets/admin-translations',	'admin',	'btn.export',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(875,	'brackets/admin-translations',	'admin',	'index.title',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(876,	'brackets/admin-translations',	'admin',	'btn.import',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(877,	'brackets/admin-translations',	'admin',	'btn.re_scan',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(878,	'brackets/admin-translations',	'admin',	'fields.created_at',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(879,	'brackets/admin-translations',	'admin',	'index.no_items',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(880,	'brackets/admin-translations',	'admin',	'index.try_changing_items',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(881,	'brackets/admin-ui',	'admin',	'page_title_suffix',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(882,	'brackets/admin-ui',	'admin',	'footer.powered_by',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(883,	'*',	'*',	'auth.password',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(884,	'*',	'*',	'auth.failed',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(885,	'*',	'*',	'Manage access',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(886,	'*',	'*',	'Translations',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(887,	'*',	'*',	'Configuration',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(888,	'*',	'*',	'Close',	'[]',	NULL,	'2021-05-07 17:51:47',	'2021-05-13 10:00:48',	NULL),
(889,	'*',	'admin',	'base-type.columns.nombre',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(890,	'*',	'admin',	'chambre.columns.ouverte',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(891,	'*',	'admin',	'chambre.columns.fermet',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(892,	'*',	'admin',	'hebergement-marque-blanche.columns.liens',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(893,	'*',	'admin',	'hebergement-marque-blanche.columns.type_hebergement_id',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(894,	'*',	'admin',	'hebergement-marque-blanche.columns.description',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(895,	'*',	'admin',	'hebergement-marque-blanche.columns.image',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(896,	'*',	'admin',	'hebergement-marque-blanche.actions.uploadImage',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(897,	'*',	'admin',	'hebergement-marque-blanche.actions.create',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(898,	'*',	'admin',	'hebergement-marque-blanche.actions.edit',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(899,	'*',	'admin',	'hebergement-marque-blanche.actions.index',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(900,	'*',	'admin',	'hebergement-marque-blanche.columns.id',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(901,	'*',	'admin',	'hebergement.columns.ouverte',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(902,	'*',	'admin',	'hebergement.columns.fermet',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(903,	'*',	'admin',	'hebergement-vol.columns.condition-transport',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(904,	'*',	'admin',	'hebergement-vol.columns.avec-vol',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(905,	'*',	'admin',	'hebergement-vol.columns.sans-vol',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(906,	'*',	'admin',	'hebergement-vol.columns.depart',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(907,	'*',	'admin',	'hebergement-vol.columns.arrive',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(908,	'*',	'admin',	'hebergement-vol.columns.nombre_jour',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(909,	'*',	'admin',	'hebergement-vol.columns.nombre_nuit',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(910,	'*',	'admin',	'hebergement-vol.columns.lien_depart',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(911,	'*',	'admin',	'hebergement-vol.columns.lien_arrive',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(912,	'*',	'admin',	'hebergement-vol.actions.edit',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(913,	'*',	'admin',	'hebergement-vol.title',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(914,	'*',	'admin',	'nav.hebergement.childre.marque_blanche',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(915,	'*',	'admin',	'hebergement-marque-blanche.title',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(916,	'*',	'admin',	'tarif.columns.marge_applique',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(917,	'*',	'admin',	'tarif.columns.marge_applique_pourcent',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(918,	'*',	'admin',	'tarif.columns.marge_applique_prix',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(919,	'*',	'admin',	'tarif.columns.marge_prix',	'[]',	NULL,	'2021-05-12 16:11:53',	'2021-05-13 10:00:48',	NULL),
(920,	'*',	'admin',	'tarifs.actions.create',	'[]',	NULL,	'2021-05-13 10:00:48',	'2021-05-13 10:00:48',	NULL);

DROP TABLE IF EXISTS `type_chambre`;
CREATE TABLE `type_chambre` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_chambre` int(11) NOT NULL DEFAULT 1,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `capacite` int(11) NOT NULL DEFAULT 0,
  `hebergement_id` bigint(20) unsigned NOT NULL,
  `base_type_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_chambre_hebergement_id_foreign` (`hebergement_id`),
  KEY `type_chambre_base_type_id_foreign` (`base_type_id`),
  CONSTRAINT `type_chambre_base_type_id_foreign` FOREIGN KEY (`base_type_id`) REFERENCES `base_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `type_chambre_hebergement_id_foreign` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `type_chambre` (`id`, `name`, `description`, `nombre_chambre`, `image`, `status`, `capacite`, `hebergement_id`, `base_type_id`, `created_at`, `updated_at`) VALUES
(1,	'Type chambre 1',	NULL,	10,	NULL,	'1',	2,	1,	1,	'2021-07-30 12:09:05',	'2021-07-30 12:14:31'),
(2,	'Type chambre 2',	NULL,	5,	NULL,	'1',	1,	1,	1,	'2021-07-30 12:09:57',	'2021-07-30 14:16:48'),
(3,	'Type chambre 3',	NULL,	7,	NULL,	'1',	5,	1,	3,	'2021-07-30 12:14:08',	'2021-07-30 12:14:08'),
(4,	'Type chambre 1 1',	NULL,	10,	NULL,	'1',	1,	2,	1,	'2021-07-30 17:11:28',	'2021-07-30 17:11:28');

DROP TABLE IF EXISTS `type_hebergement`;
CREATE TABLE `type_hebergement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_hebergement_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `type_hebergement` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1,	'Type heb 1',	NULL,	'2021-07-30 12:08:15',	'2021-07-30 12:08:15');

DROP TABLE IF EXISTS `type_personne`;
CREATE TABLE `type_personne` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_personne_type_unique` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `type_personne` (`id`, `type`, `age`, `description`, `created_at`, `updated_at`) VALUES
(1,	'Bébé',	'-5 Ans',	NULL,	'2021-07-30 12:15:18',	'2021-07-30 15:44:10'),
(2,	'Adulte',	'+ 18 ans',	NULL,	'2021-07-30 12:15:26',	'2021-07-30 12:15:26'),
(3,	'Enfant',	'+ de 5 ans',	NULL,	'2021-07-30 15:43:56',	'2021-07-30 15:43:56');

DROP TABLE IF EXISTS `type_transfert_voyage`;
CREATE TABLE `type_transfert_voyage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_min` int(11) NOT NULL DEFAULT 0,
  `nombre_max` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `type_transfert_voyage` (`id`, `titre`, `description`, `nombre_min`, `nombre_max`, `created_at`, `updated_at`) VALUES
(1,	'Tarifs Partagés 1 à 4 personnes',	NULL,	1,	4,	'2021-07-30 15:41:48',	'2021-07-30 15:41:48'),
(2,	'Autocar 5 à 55 personnes',	NULL,	5,	55,	'2021-07-30 15:42:38',	'2021-07-30 15:42:38'),
(3,	'Tarifs V.i.p. 1 à 4 personnes',	NULL,	1,	4,	'2021-07-30 15:42:51',	'2021-07-30 15:42:51');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'client',	'client@client.client',	NULL,	'$2y$10$P5YOWif1YzDwLqYBLD5Ad.T7niZPALUcNm2279tcirecN//V/MFaS',	NULL,	'2021-04-28 10:42:26',	'2021-04-28 10:42:26');

DROP TABLE IF EXISTS `vehicule_categorie_supplement`;
CREATE TABLE `vehicule_categorie_supplement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tarif` double(8,2) NOT NULL DEFAULT 0.00,
  `restriction_trajet_id` bigint(20) unsigned NOT NULL,
  `categorie_vehicule_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicule_categorie_supplement_restriction_trajet_id_foreign` (`restriction_trajet_id`),
  KEY `vehicule_categorie_supplement_categorie_vehicule_id_foreign` (`categorie_vehicule_id`),
  CONSTRAINT `vehicule_categorie_supplement_categorie_vehicule_id_foreign` FOREIGN KEY (`categorie_vehicule_id`) REFERENCES `categorie_vehicule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vehicule_categorie_supplement_restriction_trajet_id_foreign` FOREIGN KEY (`restriction_trajet_id`) REFERENCES `restriction_trajet_vehicule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `vehicule_info_tech`;
CREATE TABLE `vehicule_info_tech` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_place` int(11) NOT NULL,
  `nombre_porte` int(11) NOT NULL,
  `vitesse_maxi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_vitesse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `boite_vitesse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annee_sortir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kilometrage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_carburant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fiche_technique` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicule_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicule_info_tech_vehicule_id_foreign` (`vehicule_id`),
  CONSTRAINT `vehicule_info_tech_vehicule_id_foreign` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `vehicule_location`;
CREATE TABLE `vehicule_location` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `immatriculation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_min` int(11) NOT NULL DEFAULT 0,
  `franchise` double(8,2) DEFAULT 0.00,
  `franchise_non_rachatable` double(8,2) DEFAULT 0.00,
  `caution` double(8,2) DEFAULT 0.00,
  `entite_modele` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'location_vehicule',
  `marque_vehicule_id` bigint(20) unsigned NOT NULL,
  `modele_vehicule_id` bigint(20) unsigned NOT NULL,
  `prestataire_id` bigint(20) unsigned NOT NULL,
  `categorie_vehicule_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicule_location_immatriculation_unique` (`immatriculation`),
  KEY `vehicule_location_marque_vehicule_id_foreign` (`marque_vehicule_id`),
  KEY `vehicule_location_modele_vehicule_id_foreign` (`modele_vehicule_id`),
  KEY `vehicule_location_prestataire_id_foreign` (`prestataire_id`),
  KEY `vehicule_location_categorie_vehicule_id_foreign` (`categorie_vehicule_id`),
  CONSTRAINT `vehicule_location_categorie_vehicule_id_foreign` FOREIGN KEY (`categorie_vehicule_id`) REFERENCES `categorie_vehicule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vehicule_location_marque_vehicule_id_foreign` FOREIGN KEY (`marque_vehicule_id`) REFERENCES `marque_vehicule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vehicule_location_modele_vehicule_id_foreign` FOREIGN KEY (`modele_vehicule_id`) REFERENCES `modele_vehicule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vehicule_location_prestataire_id_foreign` FOREIGN KEY (`prestataire_id`) REFERENCES `prestataire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `vehicule_transfert_voyage`;
CREATE TABLE `vehicule_transfert_voyage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_transfert_voyage_id` bigint(20) unsigned NOT NULL,
  `vehicule_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicule_transfert_voyage_type_transfert_voyage_id_foreign` (`type_transfert_voyage_id`),
  KEY `vehicule_transfert_voyage_vehicule_id_foreign` (`vehicule_id`),
  CONSTRAINT `vehicule_transfert_voyage_type_transfert_voyage_id_foreign` FOREIGN KEY (`type_transfert_voyage_id`) REFERENCES `type_transfert_voyage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vehicule_transfert_voyage_vehicule_id_foreign` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `villes`;
CREATE TABLE `villes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `villes_pays_id_foreign` (`pays_id`),
  CONSTRAINT `villes_pays_id_foreign` FOREIGN KEY (`pays_id`) REFERENCES `pays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `villes` (`id`, `name`, `code_postal`, `pays_id`, `created_at`, `updated_at`) VALUES
(1,	'Antananarivo',	'101',	1,	'2021-07-30 12:07:28',	'2021-07-30 12:07:28'),
(2,	'Ville 1',	'101',	2,	'2021-07-30 15:38:10',	'2021-07-30 15:38:10');

DROP TABLE IF EXISTS `wysiwyg_media`;
CREATE TABLE `wysiwyg_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wysiwygable_id` int(10) unsigned DEFAULT NULL,
  `wysiwygable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wysiwyg_media_wysiwygable_id_index` (`wysiwygable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `wysiwyg_media` (`id`, `file_path`, `wysiwygable_id`, `wysiwygable_type`, `created_at`, `updated_at`) VALUES
(1,	'uploads/1623416148appartement-min1.jpg',	NULL,	NULL,	'2021-06-11 10:55:48',	'2021-06-11 10:55:48'),
(2,	'uploads/1623416872bat5.png',	NULL,	NULL,	'2021-06-11 11:07:52',	'2021-06-11 11:07:52'),
(3,	'uploads/1623784980HtcKIgYHGj.jpg',	NULL,	NULL,	'2021-06-15 17:23:01',	'2021-06-15 17:23:01'),
(4,	'uploads/16237855922958a7701943caf8c394303384a52135.png',	NULL,	NULL,	'2021-06-15 17:33:13',	'2021-06-15 17:33:13'),
(5,	'uploads/1623873051001-renovation-appartement-hausmannien-le-guide-conseil.jpg',	NULL,	NULL,	'2021-06-16 17:50:51',	'2021-06-16 17:50:51'),
(6,	'uploads/16238739212958a7701943caf8c394303384a52135.png',	NULL,	NULL,	'2021-06-16 18:05:22',	'2021-06-16 18:05:22'),
(7,	'uploads/1623873974appartement-min1.jpg',	NULL,	NULL,	'2021-06-16 18:06:14',	'2021-06-16 18:06:14');

-- 2021-07-30 20:11:52