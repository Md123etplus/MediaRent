-- Supprimer d'abord les données existantes (dans l'ordre inverse des dépendances)
DELETE FROM evaluation WHERE id IN (301, 302, 303) OR reservation_id IN (301, 302, 303);
DELETE FROM reservation WHERE annonce_id IN (201, 202, 203);
DELETE FROM annonce WHERE id IN (201, 202, 203);
DELETE FROM users WHERE id IN (101, 102, 103);

-- Créer des utilisateurs qui feront les évaluations
INSERT INTO users (id, nom, prenom, email, username, mot_de_passe, role, CIN, img_profil, img_cin_front, img_cin_back) VALUES
(101, 'Martin', 'Sophie', 'sophie@test.com', 'sophie_m', 'password123', 'client', 'CIN123', 'profile.jpg', 'cin_f.jpg', 'cin_b.jpg'),
(102, 'Dubois', 'Pierre', 'pierre@test.com', 'pierre_d', 'password123', 'client', 'CIN124', 'profile.jpg', 'cin_f.jpg', 'cin_b.jpg'),
(103, 'Garcia', 'Maria', 'maria@test.com', 'maria_g', 'password123', 'client', 'CIN125', 'profile.jpg', 'cin_f.jpg', 'cin_b.jpg');

-- Créer des annonces pour l'objet 30
INSERT INTO annonce (id, date_publication, statut, premium, objet_id, proprietaire_id, date_debut, date_fin) VALUES
(201, '2023-01-01', 'terminée', 0, 30, 1, '2023-01-15', '2023-01-20'),
(202, '2023-02-01', 'terminée', 0, 30, 1, '2023-02-15', '2023-02-20'),
(203, '2023-03-01', 'terminée', 0, 30, 1, '2023-03-15', '2023-03-20');

-- Créer des réservations pour ces annonces
INSERT INTO reservation (id, client_id, annonce_id, date_debut, date_fin, statut) VALUES
(301, 101, 201, '2023-01-15', '2023-01-20', 'terminée'),
(302, 102, 202, '2023-02-15', '2023-02-20', 'terminée'),
(303, 103, 203, '2023-03-15', '2023-03-20', 'terminée');

-- Créer des évaluations pour l'objet 30
INSERT INTO evaluation (reservation_id, objet_id, evaluateur_id, evalue_id, note_objet, note_proprietaire, commentaire_objet, commentaire_proprietaire, date) VALUES
(301, 301, 101, 1, 5, 5, 'Excellent objet, très bien entretenu et conforme à la description. Je le recommande vivement!', 'Propriétaire très professionnel et sympathique.', '2023-01-21'),
(302, 302, 102, 1, 4, 5, 'Très satisfait de la location. L''objet fonctionne parfaitement même si quelques petites rayures sont visibles.', 'Communication parfaite avec le propriétaire.', '2023-02-21'),
(303, 303, 103, 1, 5, 5, 'Super expérience! L''objet était impeccable et le rapport qualité/prix est excellent.', 'Propriétaire très arrangeant et ponctuel.', '2023-03-21');
