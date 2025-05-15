<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Evaluation;
use Carbon\Carbon;

class CheckEvaluationVisibility
{
    public function handle($request, Closure $next)
    {
        $evaluation = $request->route('evaluation');

        if (!$evaluation->is_public) {
            $bothSubmitted = !$evaluation->reservation->evaluations()
                ->whereNull('commentaire')
                ->exists();

            $oneWeekPassed = Carbon::parse($evaluation->reservation->date_fin)
                ->addWeek()
                ->isPast();

            if (!$bothSubmitted && !$oneWeekPassed) {
                abort(403, 'Cette évaluation n\'est pas encore publique');
            }
        }

        return $next($request);
    }
}
