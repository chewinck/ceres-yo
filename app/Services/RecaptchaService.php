<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RecaptchaService
{
    public static function validate(string $token): bool
    {
        // Bypass en desarrollo o testing
        // if (app()->environment('local', 'testing')) {
        //     return true;
        // }

        $secret = config('services.recaptcha.secret');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $token,
        ]);

        if (!$response->successful()) {
            return false;
        }

        $result = $response->json();

        return $result['success'] ?? false;
    }
}
