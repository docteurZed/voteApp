@extends('partials.member.base')

@section('content')
    <section class="container mx-auto max-w-screen-xl px-6 py-12">

        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-white">
                Résultats de l'élection : {{ $election->title }}
            </h2>
            <div class="mt-3">
                <span class="w-32 h-1 bg-green-600 rounded-full inline-block"></span>
            </div>
        </div>

        <div class="bg-gray-900/60 rounded-2xl p-6 shadow-md mb-10 text-center">
            <h3 class="text-xl font-bold text-white mb-3">Taux de participation</h3>
            <p class="text-gray-300 mb-2">
                <span class="text-red-600 font-semibold">{{ $totalVotants }}</span> votant{{ $totalVotants > 1 ? 's' : '' }} sur <span class="font-semibold">{{ $totalElecteurs }}</span>
                (<span class="font-bold text-red-600">{{ $tauxParticipation }}%</span>)
            </p>

            <div class="w-full bg-gray-700 h-3 rounded-full overflow-hidden">
                <div class="bg-green-600 h-3 rounded-full transition-all duration-700 ease-out"
                    style="width: {{ $tauxParticipation }}%">
                </div>
            </div>
        </div>

        @foreach ($results as $poste => $liste)
            @php
                $nomsPostes = [
                    'president' => 'Président',
                    'vpi' => 'Vice-Président aux affaires internes',
                    'vpe' => 'Vice-Président aux affaires externes',
                    'secretaire' => 'Secrétaire',
                    'tresorier' => 'Trésorier',
                    'scome' => 'Responsable SCOME',
                    'score' => 'Responsable SCORE',
                    'scope' => 'Responsable SCOPE',
                    'scora' => 'Responsable SCORA',
                    'scoph' => 'Responsable SCOPH',
                    'scohe' => 'Responsable SCOHE',
                    'communication' => 'Chargé de Communication',
                    'sport' => 'Chargé des activités culturelles et sportives',
                ];
                $labelPoste = $nomsPostes[$poste] ?? ucfirst(str_replace('_', ' ', $poste));
            @endphp

            <div class="rounded-2xl p-4 sm:p-6 shadow-md bg-gray-900/60 backdrop-blur-md mb-8">
                <div class="mb-6 text-center">
                    <h3
                        class="text-2xl font-bold text-white bg-gradient-to-r from-red-600 via-transparent to-red-600 py-2 rounded-lg">
                        Poste de {{ $labelPoste }}
                    </h3>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($liste as $candidat)
                        @php
                            $level = match ($candidat->user->level) {
                                'l1' => 'Première année',
                                'l2' => 'Deuxième année',
                                'l3' => 'Troisième année',
                                'm1' => 'Quatrième année',
                                'm2' => 'Cinquième année',
                                'd1' => 'Sixième année',
                                'd2' => 'Interne',
                                'd3' => 'Année de thèse',
                                'alumni' => 'Alumni',
                                default => $candidat->user->level,
                            };

                            $filiere = match ($candidat->user->filiere) {
                                'medecine' => 'Médecine',
                                'pharmacie' => 'Pharmacie',
                                'odonto' => 'Odonto-Stomatologie',
                                default => $candidat->user->filiere,
                            };
                        @endphp

                        <div
                            class="candidate-card flex flex-col items-center gap-4 p-4 rounded-xl bg-gray-800 border border-gray-700 shadow-sm">
                            {{-- Photo --}}
                            <div class="relative w-28 h-28 flex-shrink-0">
                                <img src="{{ asset('candidatFile/photo-' . $candidat->user->student_number . '.jpg') }}"
                                    alt="Photo de {{ $candidat->user->name }}"
                                    class="w-full h-full object-cover rounded-lg border-2 border-gray-700">
                            </div>

                            {{-- Infos --}}
                            <div class="text-center mt-2">
                                <h4 class="text-lg font-bold text-white">{{ $candidat->user->name }}</h4>
                                <p class="text-gray-300 text-sm font-semibold">
                                    {{ $level }} @if ($filiere)
                                        - {{ $filiere }}
                                    @endif
                                </p>
                                @if ($candidat->slogan)
                                    <p class="text-gray-500 text-sm mt-1 line-clamp-2">
                                        {{ Str::limit($candidat->slogan, 90) }}</p>
                                @endif
                                <p class="text-green-400 font-bold mt-2">
                                    {{ $candidat->votes_count }} vote{{ $candidat->votes_count > 1 ? 's' : '' }} -
                                    {{ $candidat->percentage }}%
                                </p>

                                <div class="w-full bg-gray-700 h-2 rounded-full mt-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $candidat->percentage }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </section>
@endsection
