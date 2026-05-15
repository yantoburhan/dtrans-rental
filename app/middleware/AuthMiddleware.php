<?php

/**
 * AuthMiddleware — Ensures the user is authenticated
 * Redirects to login if not logged in
 */
class AuthMiddleware
{
    public function handle(): void
    {
        if (!Session::has('user')) {
            Session::flash('alert', ['type' => 'warning', 'message' => 'Please login to continue.']);
            $base = Env::get('APP_URL');
            header("Location: $base/auth/login");
            exit;
        }
    }
}
