<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Candidat;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function index()
    {
        abort(403);    
    }

    public function store(Request $request)
    {
        if ($request->user()->role == 'admin') {
            return redirect()->back()->withErrors('Les administrateurs ne peuvent pas voter.');
        }

        $user = Auth::user();
        $election = Election::first();

        if ($user->hasVoted(optional($election)->id)) {
            return redirect()->back()->with('error', 'Vous avez déjà soumis vos votes.');
        }

        $request->validate([
            'vote' => 'nullable|array',
        ]);

        foreach ($request->vote as $poste => $candidat_id) {
            Vote::create([
                'election_id' => $election->id,
                'user_id' => $user->id,
                'candidat_id' => $candidat_id,
                'poste' => $poste,
            ]);
        }

        return redirect()->route('member.vote')->with('success', 'Vos votes ont été enregistrés avec succès.');
    }
}
