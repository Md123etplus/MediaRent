<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function exportData(Request $request)
    {
        $type = $request->input('type', 'reservations');
        $filename = 'export_' . $type . '_' . date('Y-m-d') . '.csv';

        switch ($type) {
            case 'users':
                return $this->exportUsers($filename);
            case 'annonces':
                return $this->exportAnnonces($filename);
            case 'reservations':
                return $this->exportReservations($filename);
            case 'evaluations':
                return $this->exportEvaluations($filename);
            default:
                return back()->with('error', 'Type d\'export non valide');
        }
    }

    private function exportUsers($filename)
    {
        $users = User::all();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');

            // En-têtes
            fputcsv($file, [
                'ID',
                'Nom',
                'Prénom',
                'Email',
                'Rôle',
                'CIN',
                'Date d\'inscription',
                'Statut'
            ]);

            // Données
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->nom,
                    $user->prenom,
                    $user->email,
                    $user->role,
                    $user->CIN,
                    $user->created_at,
                    $user->is_suspended ? 'Suspendu' : 'Actif'
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function exportReservations($filename)
    {
        $reservations = Reservation::with(['client', 'annonce.objet'])->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($reservations) {
            $file = fopen('php://output', 'w');

            // En-têtes
            fputcsv($file, [
                'ID',
                'Client',
                'Matériel',
                'Date début',
                'Date fin',
                'Prix total',
                'Statut',
                'Date réservation'
            ]);

            // Données
            foreach ($reservations as $res) {
                $days = $res->date_debut->diffInDays($res->date_fin);
                $total = $days * $res->annonce->objet->prix_journalier;

                fputcsv($file, [
                    $res->id,
                    $res->client->nom . ' ' . $res->client->prenom,
                    $res->annonce->objet->nom,
                    $res->date_debut->format('d/m/Y'),
                    $res->date_fin->format('d/m/Y'),
                    $total . ' €',
                    $res->statut,
                    $res->created_at->format('d/m/Y H:i')
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function exportAnnonces($filename)
    {
        $annonces = Annonce::with(['proprietaire', 'objet'])->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($annonces) {
            $file = fopen('php://output', 'w');

            // En-têtes
            fputcsv($file, [
                'ID',
                'Matériel',
                'Catégorie',
                'Propriétaire',
                'Prix/jour',
                'Ville',
                'Statut',
                'Premium',
                'Dates disponibilité',
                'Date publication'
            ]);

            // Données
            foreach ($annonces as $annonce) {
                fputcsv($file, [
                    $annonce->id,
                    $annonce->objet->nom,
                    $annonce->objet->categorie->nom ?? 'N/A',
                    $annonce->proprietaire->nom . ' ' . $annonce->proprietaire->prenom,
                    $annonce->objet->prix_journalier . ' €',
                    $annonce->objet->ville,
                    $annonce->statut,
                    $annonce->premium ? 'Oui' : 'Non',
                    $annonce->date_debut->format('d/m/Y') . ' - ' . $annonce->date_fin->format('d/m/Y'),
                    $annonce->created_at->format('d/m/Y H:i')
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function exportEvaluations($filename)
    {
        $evaluations = Evaluation::with(['evaluateur', 'evalue', 'objet'])->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($evaluations) {
            $file = fopen('php://output', 'w');

            // En-têtes
            fputcsv($file, [
                'ID',
                'Évaluateur',
                'Évalué',
                'Matériel',
                'Note',
                'Commentaire',
                'Date évaluation',
                'Visible'
            ]);

            // Données
            foreach ($evaluations as $eval) {
                fputcsv($file, [
                    $eval->id,
                    $eval->evaluateur->nom . ' ' . $eval->evaluateur->prenom,
                    $eval->evalue->nom . ' ' . $eval->evalue->prenom,
                    $eval->objet->nom ?? 'N/A',
                    $eval->note . '/5',
                    '"' . str_replace('"', '""', $eval->commentaire) . '"', // Protection des guillemets
                    $eval->created_at->format('d/m/Y H:i'),
                    $eval->is_visible ? 'Oui' : 'Non'
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
