<?php

/**
 * AdminMiddleware — Ensures the authenticated user has the admin role
 */
class AdminMiddleware
{
    public function handle(): void
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'admin') {
            http_response_code(403);
            $base = Env::get('APP_URL');
            header("Location: $base/403");
            exit;
        }
    }
}
