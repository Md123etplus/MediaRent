
CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(191) NOT NULL,
  `prenom` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `mot_pass` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `annonce` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_publication` date NOT NULL,
  `statut` varchar(50) NOT NULL,
  `premium` tinyint(1) NOT NULL DEFAULT 0,
  `objet_id` bigint(20) UNSIGNED NOT NULL,
  `proprietaire_id` bigint(20) UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `adress` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    email VARCHAR(255),
    CIN VARCHAR(50),
    created_at DATETIME,
    updated_at DATETIME
);


CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categorie` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `evaluation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `objet_id` bigint(20) UNSIGNED NOT NULL,
  `evaluateur_id` bigint(20) UNSIGNED NOT NULL,
  `evalue_id` bigint(20) UNSIGNED NOT NULL,
  `note_objet` int(11) NOT NULL,
  `note_proprietaire` int(11) NOT NULL,
  `commentaire_objet` text NOT NULL,
  `commentaire_proprietaire` text NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `image` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(191) NOT NULL,
  `objet_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `notification` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  `contenu_email` text NOT NULL,
  `sujet_email` varchar(191) NOT NULL,
  `utilisateur_id` bigint(20) UNSIGNED NOT NULL,
  `annonce_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `envoyee` tinyint(1) NOT NULL DEFAULT 0,
  `lue` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `objet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `ville` varchar(191) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `proprietaire_id` bigint(20) UNSIGNED NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `prix_journalier` double NOT NULL,
  `etat` enum('neuf','bon','usé') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reclamation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  `utilisateur_id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `statut` varchar(50) DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reservation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `annonce_id` bigint(20) UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `statut` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) NOT NULL,
  `confirmation_token` varchar(191) DEFAULT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `last_notified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(191) NOT NULL,
  `prenom` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `mot_de_passe` varchar(191) NOT NULL,
  `role` enum('partenaire','client') NOT NULL DEFAULT 'client',
  `CIN` varchar(191) NOT NULL,
  `img_profil` text NOT NULL,
  `img_cin_front` text NOT NULL,
  `img_cin_back` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id`),
  ADD KEY `annonce_objet_id_foreign` (`objet_id`),
  ADD KEY `annonce_proprietaire_id_foreign` (`proprietaire_id`);

ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluation_objet_id_foreign` (`objet_id`),
  ADD KEY `evaluation_evaluateur_id_foreign` (`evaluateur_id`),
  ADD KEY `evaluation_evalue_id_foreign` (`evalue_id`);

ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_objet_id_foreign` (`objet_id`);

ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification_utilisateur_id_foreign` (`utilisateur_id`),
  ADD KEY `notification_annonce_id_foreign` (`annonce_id`);

ALTER TABLE `objet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `objet_proprietaire_id_foreign` (`proprietaire_id`),
  ADD KEY `objet_categorie_id_foreign` (`categorie_id`),
  ADD KEY `objet_latitude_longitude_index` (`latitude`,`longitude`);

ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reclamation_utilisateur_id_foreign` (`utilisateur_id`),
  ADD KEY `reclamation_reservation_id_foreign` (`reservation_id`);

ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_client_id_foreign` (`client_id`),
  ADD KEY `reservation_annonce_id_foreign` (`annonce_id`);

ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);


ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `annonce`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `categorie`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

ALTER TABLE `evaluation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

ALTER TABLE `image`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `notification`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `objet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

ALTER TABLE `reclamation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `reservation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;


ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_objet_id_foreign` FOREIGN KEY (`objet_id`) REFERENCES `objet` (`id`),
  ADD CONSTRAINT `annonce_proprietaire_id_foreign` FOREIGN KEY (`proprietaire_id`) REFERENCES `users` (`id`);

ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_evaluateur_id_foreign` FOREIGN KEY (`evaluateur_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `evaluation_evalue_id_foreign` FOREIGN KEY (`evalue_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `evaluation_objet_id_foreign` FOREIGN KEY (`objet_id`) REFERENCES `reservation` (`id`);

ALTER TABLE `image`
  ADD CONSTRAINT `image_objet_id_foreign` FOREIGN KEY (`objet_id`) REFERENCES `objet` (`id`);

ALTER TABLE `notification`
  ADD CONSTRAINT `notification_annonce_id_foreign` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id`),
  ADD CONSTRAINT `notification_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `users` (`id`);

ALTER TABLE `objet`
  ADD CONSTRAINT `objet_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `objet_proprietaire_id_foreign` FOREIGN KEY (`proprietaire_id`) REFERENCES `users` (`id`);

ALTER TABLE `reclamation`
  ADD CONSTRAINT `reclamation_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`),
  ADD CONSTRAINT `reclamation_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `users` (`id`);

ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_annonce_id_foreign` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id`),
  ADD CONSTRAINT `reservation_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`);
COMMIT;
