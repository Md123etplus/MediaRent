-- Supprimer d'abord les évaluations liées aux réservations
DELETE FROM evaluation 
WHERE reservation_id IN (401, 402, 403) 
   OR objet_id IN (401, 402, 403);

-- Supprimer les réservations existantes
DELETE FROM reservation 
WHERE id IN (401, 402, 403);

-- Créer les nouvelles réservations
INSERT INTO reservation (id, client_id, annonce_id, date_debut, date_fin, statut) VALUES
(401, 25, 201, '2023-05-15', '2023-05-20', 'terminée'),
(402, 25, 202, '2023-06-01', '2023-06-05', 'terminée'),
(403, 25, 203, '2023-07-10', '2023-07-15', 'terminée');

-- Créer des évaluations faites par le client 25
INSERT INTO evaluation (reservation_id, objet_id, evaluateur_id, evalue_id, note_objet, note_proprietaire, commentaire_objet, commentaire_proprietaire, date) VALUES
(401, 401, 25, 1, 5, 5, 'Excellent objet, exactement comme décrit. Je recommande vivement!', 'Propriétaire très professionnel et accueillant.', '2023-05-21'),
(402, 402, 25, 1, 4, 4, 'Très bon objet, quelques petites traces d''usure mais fonctionne parfaitement.', 'Bonne communication avec le propriétaire.', '2023-06-06'),
(403, 403, 25, 1, 5, 5, 'Parfait état, très satisfait de la location.', 'Propriétaire super sympa et arrangeant.', '2023-07-16');

-- Créer des évaluations reçues par le client 25 (de la part des propriétaires)
INSERT INTO evaluation (reservation_id, objet_id, evaluateur_id, evalue_id, note_objet, note_proprietaire, commentaire_objet, commentaire_proprietaire, date) VALUES
(401, 401, 1, 25, 5, 5, 'Objet rendu en parfait état', 'Client respectueux et ponctuel.', '2023-05-21'),
(402, 402, 1, 25, 5, 5, 'RAS sur l''état de l''objet', 'Excellent client, très soigneux.', '2023-06-06'),
(403, 403, 1, 25, 5, 5, 'Objet bien entretenu', 'Communication parfaite, client recommandé.', '2023-07-16');
