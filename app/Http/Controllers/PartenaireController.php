<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PartenaireController extends Controller
{
    public function show(User $user)
    {
        if ($user->role !== 'partenaire') {
            abort(404);
        }

        return view('partenaires.show', compact('user'));
    }
}
