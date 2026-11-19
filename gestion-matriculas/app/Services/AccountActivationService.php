<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Throwable;

class AccountActivationService
{
    public function sendLink(User $user): bool
    {
        try {
            return Password::sendResetLink([
                'email' => $user->email,
            ]) === Password::ResetLinkSent;

        } catch (Throwable $exception) {
            report($exception);

            return false;
        }
    }
}