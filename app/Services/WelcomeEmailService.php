<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailService
{
    /**
     * Send a welcome email (inline content) to the newly registered user.
     */
    public function send(User $user): void
    {
        $fullName = full_name($user->first_name, $user->last_name);

        try {
            Mail::raw(
                "سلام {$fullName} عزیز!\n\n"
                ."از اینکه به خانواده درنیکا نیوز پیوستید خوشحالیم. "
                ."برای دسترسی سریع‌تر به آخرین اخبار کافیست به وبسایت ما سر بزنید.\n\n"
                ."با احترام\nتیم درنیکا نیوز",
                function ($message) use ($user, $fullName) {
                    $message->to($user->email, $fullName)
                        ->subject('خوش آمدید به درنیکا نیوز');
                }
            );
        } catch (\Throwable $exception) {
            Log::error('Failed to send welcome email', [
                'user_id' => $user->id,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}

