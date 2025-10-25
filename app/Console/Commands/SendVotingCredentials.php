<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VotingNotificationService;

class SendVotingCredentials extends Command
{
    protected $signature = 'notify:voters';
    protected $description = 'Envoie les identifiants de connexion et le lien de vote à tous les utilisateurs.';

    protected VotingNotificationService $service;

    public function __construct(VotingNotificationService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): void
    {
        $this->info('Envoi des identifiants de vote en cours...');
        $this->service->sendCredentialsToAll();
        $this->info('✅ Notifications envoyées avec succès à tous les utilisateurs actifs.');
    }
}
