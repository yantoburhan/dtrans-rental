<?php

/**
 * DriverMiddleware — Ensures the authenticated user has the driver role
 */
class DriverMiddleware
{
    public function handle(): void
    {
        $user = Session::get('user');
        if (!$user || $user['role'] !== 'driver') {
            http_response_code(403);
            $base = Env::get('APP_URL');
            header("Location: $base/403");
            exit;
        }
    }
}
