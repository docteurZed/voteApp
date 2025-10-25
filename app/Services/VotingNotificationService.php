<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\VotingCredentialNotification;
use Illuminate\Support\Facades\Notification;

class VotingNotificationService
{
    public function sendCredentialsToAll(): void
    {
        $users = User::where('is_active', true)
                        ->latest()
                        ->take(58)
                        ->get();
        $voteUrl = route('member.vote');

        foreach ($users as $user) {

            $user->notify(new VotingCredentialNotification(
                $user->email,
                $user->student_number,
                $voteUrl
            ));
        }
    }
}
