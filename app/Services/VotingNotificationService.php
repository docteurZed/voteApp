<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\VotingCredentialNotification;
use Illuminate\Support\Facades\Notification;

class VotingNotificationService
{
    public function sendCredentialsToAll(): void
    {
        // $users = User::where('is_active', true)->get();
        $user = User::first();
        $voteUrl = route('member.vote');

        $user->notify(new VotingCredentialNotification(
                $user->email,
                $user->student_number,
                $voteUrl
            ));

        // foreach ($users as $user) {

        //     $user->notify(new VotingCredentialNotification(
        //         $user->email,
        //         $user->student_number,
        //         $voteUrl
        //     ));
        // }
    }
}
