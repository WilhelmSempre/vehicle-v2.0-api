<?php
declare(strict_types=1);

namespace App\Services;

use SodiumException;
use Symfony\Component\HttpFoundation\Request;

class AuthorizationService
{
    /**
     * @throws SodiumException
     */
    public function decrypt($secret, $iv): bool|string
    {
        $secret = base64_decode($secret);
        $iv = base64_decode($iv);

        return sodium_crypto_box_seal_open($secret, $iv);
    }

    /**
     * @throws SodiumException
     */
    public function isSecretValid(Request $request): bool
    {
        $secret = $request->request->get('secret');
        $iv = $request->request->get('iv');

        return $_ENV['APP_SECRET'] === $this->decrypt($secret, $iv);
    }
}
