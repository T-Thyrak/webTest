<?php

use Envms\FluentPDO\Query;

    function generateRandomSaltString($length) {
        if ($length < 1) {
            throw new Exception('Length must be greater than 0');
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomstring = '';

        for ($i = 0; $i < $length; $i++) {
            $randomstring .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $randomstring;
    }

    function create_new_token(Query $fluent, int $user_id): string {
        $token = generateRandomSaltString(64);

        $fluent->insertInto('tokens')
            ->values([
                'token' => $token,
                'user_id' => $user_id,
            ])
            ->execute();
        
        return $token;
    }
?>