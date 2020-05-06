<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthorizationService
 * @package App\Services
 */
class AuthorizationService
{
    /**
     * @param $secret
     * @param $iv
     * @return string
     */
    public function decrypt($secret, $iv)
    {
        $secret = base64_decode($secret);
        $iv = base64_decode($iv);

        return sodium_crypto_box_seal_open($secret, $iv);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function isSecretValid(Request $request): bool
    {
        $secret = $request->request->get('secret');
        $iv = $request->request->get('iv');

        return $_ENV['APP_SECRET'] === $this->decrypt($secret, $iv);
    }
}