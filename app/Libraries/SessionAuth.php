<?php

namespace App\Libraries;

class SessionAuth
{

    public static function setAuth(array $userInfo): void
    {
        $session = session();
        $session->set([
            'logged_in' => true,
            'user_data' => $userInfo
        ]);
    }

    public static function id(): ?int
    {
        $session = session();
        if (self::isAuthenticated()) {
            return $session->get('user_data')['id'] ?? null;
        }

        return null;
    }


    public static function isAuthenticated(): bool
    {
        $session = session();
        return $session->has('logged_in') && $session->get('logged_in') === true;
    }


    public static function logout(): void
    {
        $session = session();
        $session->remove(['logged_in', 'user_data']);
    }

    public static function user(): ?array
    {
        $session = session();
        if (self::isAuthenticated()) {
            return $session->get('user_data');
        }

        return null;
    }
}
