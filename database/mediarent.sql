CREATE DATABASE IF NOT EXISTS `mediarent` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `mediarent`;
CREATE TABLE `Utilisateur`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `mot_de_passe` VARCHAR(255) NOT NULL,
    `role` ENUM('client,partenaire') NOT NULL,
    `CIN` VARCHAR(255) NOT NULL,
    `img_profil` TEXT NOT NULL,
    `img_cin_front` TEXT NOT NULL,
    `img_cin_back` TEXT NOT NULL
);
ALTER TABLE
    `Utilisateur` ADD UNIQUE `utilisateur_email_unique`(`email`);
CREATE TABLE `Admin`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `mot_pass` VARCHAR(255) NOT NULL
);
CREATE TABLE `Objet`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `ville` VARCHAR(255) NOT NULL,
    `proprietaire_id` BIGINT UNSIGNED NOT NULL,
    `categorie_id` BIGINT UNSIGNED NOT NULL,
    `prix_journalier` FLOAT(53) NOT NULL,
    `etat` ENUM('') NOT NULL
);
CREATE TABLE `Image`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `url` VARCHAR(255) NOT NULL,
    `objet_id` BIGINT UNSIGNED NOT NULL
);
CREATE TABLE `Annonce`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `date_publication` DATE NOT NULL,
    `statut` VARCHAR(50) NOT NULL,
    `premium` BOOLEAN NULL DEFAULT 'DEFAULT FALSE',
    `objet_id` INT UNSIGNED NOT NULL,
    `proprietaire_id` INT UNSIGNED NOT NULL,
    `date_debut` DATE NOT NULL,
    `date_fin` DATE NOT NULL,
    `adress` TEXT NOT NULL
);
CREATE TABLE `Reservation`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `client_id` BIGINT UNSIGNED NOT NULL,
    `annonce_id` BIGINT UNSIGNED NOT NULL,
    `date_debut` DATE NOT NULL,
    `date_fin` DATE NOT NULL,
    `statut` VARCHAR(50) NOT NULL
);
CREATE TABLE `Reclamation`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `contenu` TEXT NOT NULL,
    `utilisateur_id` BIGINT UNSIGNED NOT NULL,
    `reservation_id` BIGINT UNSIGNED NOT NULL,
    `date_creation` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(), `statut` VARCHAR(50) NULL DEFAULT 'en_attente');
CREATE TABLE `Evaluation`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `objet_id` BIGINT UNSIGNED NOT NULL,
    `evaluateur_id` BIGINT UNSIGNED NOT NULL,
    `evalue_id` BIGINT UNSIGNED NOT NULL,
    `note` INT NOT NULL,
    `commentaire` TEXT NOT NULL,
    `date` DATE NOT NULL
);
CREATE TABLE `Notification`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `contenu` TEXT NOT NULL,
    `contenu_email` TEXT NOT NULL,
    `sujet_email` VARCHAR(255) NOT NULL,
    `utilisateur_id` BIGINT UNSIGNED NOT NULL,
    `annonce_id` BIGINT UNSIGNED NULL,
    `date_creation` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(), `envoyee` BOOLEAN NULL DEFAULT 'DEFAULT FALSE', `lue` BOOLEAN NULL DEFAULT 'DEFAULT FALSE');
CREATE TABLE `categorie`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL
);
ALTER TABLE
    `Notification` ADD CONSTRAINT `notification_annonce_id_foreign` FOREIGN KEY(`annonce_id`) REFERENCES `Annonce`(`id`);
ALTER TABLE
    `Notification` ADD CONSTRAINT `notification_utilisateur_id_foreign` FOREIGN KEY(`utilisateur_id`) REFERENCES `Utilisateur`(`id`);
ALTER TABLE
    `Annonce` ADD CONSTRAINT `annonce_proprietaire_id_foreign` FOREIGN KEY(`proprietaire_id`) REFERENCES `Utilisateur`(`id`);
ALTER TABLE
    `Reclamation` ADD CONSTRAINT `reclamation_utilisateur_id_foreign` FOREIGN KEY(`utilisateur_id`) REFERENCES `Utilisateur`(`id`);
ALTER TABLE
    `Reservation` ADD CONSTRAINT `reservation_client_id_foreign` FOREIGN KEY(`client_id`) REFERENCES `Utilisateur`(`id`);
ALTER TABLE
    `Objet` ADD CONSTRAINT `objet_categorie_id_foreign` FOREIGN KEY(`categorie_id`) REFERENCES `categorie`(`id`);
ALTER TABLE
    `Objet` ADD CONSTRAINT `objet_proprietaire_id_foreign` FOREIGN KEY(`proprietaire_id`) REFERENCES `Utilisateur`(`id`);
ALTER TABLE
    `Annonce` ADD CONSTRAINT `annonce_objet_id_foreign` FOREIGN KEY(`objet_id`) REFERENCES `Objet`(`id`);
ALTER TABLE
    `Image` ADD CONSTRAINT `image_objet_id_foreign` FOREIGN KEY(`objet_id`) REFERENCES `Objet`(`id`);
ALTER TABLE
    `Evaluation` ADD CONSTRAINT `evaluation_evaluateur_id_foreign` FOREIGN KEY(`evaluateur_id`) REFERENCES `Utilisateur`(`id`);
ALTER TABLE
    `Reclamation` ADD CONSTRAINT `reclamation_reservation_id_foreign` FOREIGN KEY(`reservation_id`) REFERENCES `Reservation`(`id`);
ALTER TABLE
    `Evaluation` ADD CONSTRAINT `evaluation_objet_id_foreign` FOREIGN KEY(`objet_id`) REFERENCES `Reservation`(`id`);
ALTER TABLE
    `Reservation` ADD CONSTRAINT `reservation_annonce_id_foreign` FOREIGN KEY(`annonce_id`) REFERENCES `Annonce`(`id`);
ALTER TABLE
    `Evaluation` ADD CONSTRAINT `evaluation_evalue_id_foreign` FOREIGN KEY(`evalue_id`) REFERENCES `Utilisateur`(`id`);