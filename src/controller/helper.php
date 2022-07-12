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

    function create_new_token(Query $fluent, int $user_id, string $gtoken): string {
        $vars = [
            'user_id' => $user_id,
            'token' => $gtoken,
            'last_updated' => date('Y-m-d H:i:s', (time() + 3600 * 5)),
        ];

        $fluent->insertInto('tokens', $vars)
                ->execute();

        return $gtoken;
    }
?>