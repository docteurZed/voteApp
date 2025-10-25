<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VotingCredentialNotification extends Notification
{
    use Queueable;

    protected string $email;
    protected string $password;
    protected string $voteUrl;

    public function __construct(string $email, string $password, string $voteUrl)
    {
        $this->email = $email;
        $this->password = $password;
        $this->voteUrl = $voteUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Informations de connexion au vote AEMPO–Lomé 2025')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('La Commission Électorale Indépendante (CEI) de l’AEMPO–Lomé a le plaisir de vous informer que le scrutin pour le renouvellement du Bureau Exécutif Local se tiendra le **26 octobre 2025**, de **00h00 à 23h59**.')
            ->line('Afin de vous permettre de participer au vote en ligne, voici vos identifiants personnels de connexion :')
            ->line('**Adresse e-mail :** ' . $this->email)
            ->line('**Mot de passe :** ' . $this->password)
            ->action('Accéder à la plateforme de vote', $this->voteUrl)
            ->line('Nous vous invitons à vous connecter pendant la période du vote pour exprimer votre choix.')
            ->line('Nous vous remercions pour votre engagement et votre participation à la vie de notre association.')
            ->salutation('Cordialement,')
            ->line('**La Commission Électorale Indépendante (CEI)** AEMPO–Lomé');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
