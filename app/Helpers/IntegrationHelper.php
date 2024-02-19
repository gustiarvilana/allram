<?php

namespace App\Helpers;

class IntegrationHelper
{
    protected $key;

    public function __construct()
    {
        $this->key = "encryp123";
    }

    public function encrypt($data)
    {
        $cipher = 'aes-256-cbc';
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);

        $encrypted = openssl_encrypt($data, $cipher, $this->key, 0, $iv);

        return base64_encode($iv . $encrypted);
    }

    public function decrypt($data)
    {
        $cipher = 'aes-256-cbc';
        $data = base64_decode($data);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($data, 0, $ivlen);
        $encrypted = substr($data, $ivlen);

        return openssl_decrypt($encrypted, $cipher, $this->key, 0, $iv);
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }
}
