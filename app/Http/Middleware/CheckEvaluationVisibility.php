<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Evaluation;
use Carbon\Carbon;

class CheckEvaluationVisibility
{
    /**
     * Vérifie si une évaluation peut être visible publiquement
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $evaluation = $request->route('evaluation');

        // Si l'évaluation est déjà marquée comme publique, on laisse passer
        if ($evaluation->is_public && $evaluation->is_visible) {
            return $next($request);
        }

        // Vérifier si les deux évaluations (client et partenaire) ont été soumises
        $bothEvaluationsSubmitted = !$evaluation->reservation->evaluations()
            ->whereNull('commentaire')
            ->exists();

        // Vérifier si une semaine s'est écoulée depuis la fin de la location
        $oneWeekPassed = Carbon::parse($evaluation->reservation->date_fin)
            ->addWeek()
            ->isPast();

        // Autoriser l'accès seulement si une des conditions est remplie
        if ($bothEvaluationsSubmitted || $oneWeekPassed) {
            // Marquer l'évaluation comme publique pour les prochaines visites
            if (!$evaluation->is_public) {
                $evaluation->update(['is_public' => true]);
            }

            return $next($request);
        }

        // Refuser l'accès dans tous les autres cas
        abort(403, 'Cette évaluation n\'est pas encore disponible. Elle deviendra publique lorsque les deux parties auront soumis leur évaluation ou après une semaine.');
    }
}