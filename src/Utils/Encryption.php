<?php

    namespace App\Utils;

    use App\PDO\Select;

    class Encryption implements EncryptionInterface
    {
        private static $cipher = "AES-128-CBC";

        private static function getEncKey()
        {
            $keyData = new Select('enc_keys', ['select' => 'key_val', 'where' => ['key_id' => 1]]);
            return $keyData->one();
        }

        public static function encode($ecText)
        {
            $key = self::getEncKey();
            $ivlen = openssl_cipher_iv_length(self::$cipher);
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext_raw = openssl_encrypt($ecText, self::$cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
            $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
            return base64_encode( $iv.$hmac.$ciphertext_raw );
        }

        public static function decode($decText)
        {
            $key = self::getEncKey();
            $c = base64_decode($decText);
            $ivlen = openssl_cipher_iv_length(self::$cipher);
            $iv = substr($c, 0, $ivlen);
            $hmac = substr($c, $ivlen, $sha2len=32);
            $ciphertext_raw = substr($c, $ivlen+$sha2len);
            $original_plaintext = openssl_decrypt($ciphertext_raw, self::$cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
            $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
            if (hash_equals($hmac, $calcmac))
            {
                return $original_plaintext;
            }
        }
    }
