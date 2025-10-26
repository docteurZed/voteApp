<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidat;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        // On récupère la première élection
        $election = Election::first();

        if (!$election) {
            return view('admin.results')->with('message', 'Aucune élection trouvée.');
        }

        $totalVotants = Vote::where('election_id', $election->id)->count();
        $totalElecteurs = User::count(); // ou adapte selon ton modèle (ex: User::where('role', 'member')->count())
        $tauxParticipation = $totalElecteurs > 0
            ? round(($totalVotants / $totalElecteurs) * 100, 2)
            : 0;

        // Récupère les candidats validés et leurs votes
        $candidats = Candidat::where('election_id', $election->id)
            ->where('statut', 'valide')
            ->withCount(['votes' => function ($query) use ($election) {
                $query->where('election_id', $election->id);
            }])
            ->get()
            ->groupBy('poste');

        // Pour chaque poste, on calcule le total de votes pour calculer le pourcentage
        $results = [];

        foreach ($candidats as $poste => $candidatsPoste) {
            $totalVotes = $candidatsPoste->sum('votes_count') + 220;

            $results[$poste] = $candidatsPoste->map(function ($candidat) use ($totalVotants) {
                $candidat->percentage = $totalVotants > 0 ? round(($candidat->votes_count / $totalVotants) * 100, 2) : 0;
                return $candidat;
            });
        }

        $start = Carbon::parse('2025-10-26 00:00');
        $end = Carbon::parse('2025-10-27 00:00');
        $now = Carbon::now();

        if ($now->lt($start)) {
            return view('member.vote_attempt', compact('start', 'end', 'now'));
        }

        return view('admin.results', compact('election', 'results', 'tauxParticipation', 'totalVotants', 'totalElecteurs'));
    }
}
