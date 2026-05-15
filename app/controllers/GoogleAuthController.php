<?php

/**
 * GoogleAuthController — Google OAuth 2.0 authentication flow
 * Requires: composer require league/oauth2-google
 */
class GoogleAuthController extends Controller
{
    private function getProvider(): \League\OAuth2\Client\Provider\Google
    {
        return new \League\OAuth2\Client\Provider\Google([
            'clientId'     => Env::get('GOOGLE_CLIENT_ID'),
            'clientSecret' => Env::get('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => Env::get('GOOGLE_REDIRECT_URI'),
        ]);
    }

    public function redirect(): void
    {
        $provider = $this->getProvider();
        $authUrl  = $provider->getAuthorizationUrl([
            'scope' => ['email', 'profile'],
        ]);
        Session::set('oauth2_state', $provider->getState());
        header("Location: $authUrl");
        exit;
    }

    public function callback(): void
    {
        $state = $this->input('state');
        if (!$state || $state !== Session::get('oauth2_state')) {
            $this->flash('danger', 'Invalid OAuth state. Please try again.');
            $this->redirect('auth/login');
            return;
        }
        Session::remove('oauth2_state');

        $code = $this->input('code');
        if (!$code) {
            $this->flash('danger', 'Google authentication failed.');
            $this->redirect('auth/login');
            return;
        }

        try {
            $provider    = $this->getProvider();
            $token       = $provider->getAccessToken('authorization_code', ['code' => $code]);
            $googleUser  = $provider->getResourceOwner($token);
            $googleData  = $googleUser->toArray();

            $userModel = new User();
            $existing  = $userModel->findByGoogleId($googleData['id'])
                      ?? $userModel->findByEmail($googleData['email']);

            if ($existing) {
                // Update google_id if registered manually before
                if (!$existing['google_id']) {
                    $userModel->update($existing['id'], ['google_id' => $googleData['id']]);
                }
                $user = $existing;
            } else {
                // Create new account
                $userId = $userModel->createFromGoogle([
                    'name'      => $googleData['name'],
                    'email'     => $googleData['email'],
                    'google_id' => $googleData['id'],
                    'avatar'    => $googleData['picture'] ?? null,
                ]);
                $user = $userModel->find($userId);
            }

            Session::set('user', [
                'id'     => $user['id'],
                'name'   => $user['full_name'],
                'email'  => $user['email'],
                'role'   => $user['role'],
                'avatar' => $user['avatar'] ?? $googleData['picture'] ?? null,
            ]);

            $this->redirect('customer/dashboard');
        } catch (\Exception $e) {
            error_log('GoogleAuth error: ' . $e->getMessage());
            $this->flash('danger', 'Google authentication failed. Please try again.');
            $this->redirect('auth/login');
        }
    }
}
