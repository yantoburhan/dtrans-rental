<?php

/**
 * AuthController — Manual registration, login, email verification, password reset
 */
class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // ----------------------------------------------------------------
    // Login
    // ----------------------------------------------------------------

    public function loginForm(): void
    {
        if (Session::has('user')) {
            $this->redirectByRole(Session::get('user')['role']);
        }

        $this->view('auth.login', ['csrf' => $this->generateCsrf()], 'auth');
    }

    public function login(): void
    {
        $this->verifyCsrf();

        $email    = trim($this->input('email', ''));
        $password = $this->input('password', '');

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $this->flash('danger', 'Invalid email or password.');
            $this->back();
            return;
        }

        $storedPassword = $user['password'] ?? '';

        if (!password_verify($password, $storedPassword)) {
            if ($password === $storedPassword && !empty($storedPassword)) {
                // Legacy account with plaintext password stored in database.
                // Rehash and upgrade it transparently on successful login.
                $this->userModel->update($user['id'], [
                    'password' => password_hash($password, PASSWORD_BCRYPT),
                ]);
            } else {
                $this->flash('danger', 'Invalid email or password.');
                $this->back();
                return;
            }
        }

        // Temporarily disabled email verification for login
        // if (!$user['email_verified_at']) {
        //     $this->flash('warning', 'Please verify your email before logging in.');
        //     $this->back();
        //     return;
        // }

        Session::set('user', [
            'id'       => $user['id'],
            'name'     => $user['full_name'],
            'email'    => $user['email'],
            'role'     => $user['role'],
            'avatar'   => $user['avatar'] ?? null,
        ]);

        $this->redirectByRole($user['role']);
    }

    // ----------------------------------------------------------------
    // Registration
    // ----------------------------------------------------------------

    public function registerForm(): void
    {
        $this->view('auth.register', ['csrf' => $this->generateCsrf()], 'auth');
    }

    public function register(): void
    {
        $this->verifyCsrf();

        $email    = trim($this->input('email', ''));
        $username = trim($this->input('username', ''));

        // Uniqueness checks
        if ($this->userModel->findByEmail($email)) {
            $this->flash('danger', 'Email is already registered.');
            $this->back();
            return;
        }

        if ($this->userModel->findByUsername($username)) {
            $this->flash('danger', 'Username is already taken.');
            $this->back();
            return;
        }

        // Handle identity upload
        $identityFile = $this->handleIdentityUpload();
        if (!$identityFile) {
            $this->flash('danger', 'Identity document upload failed or invalid file type.');
            $this->back();
            return;
        }

        $token  = bin2hex(random_bytes(32));
        $userId = $this->userModel->createCustomer([
            'full_name'          => $this->input('full_name'),
            'username'           => $username,
            'email'              => $email,
            'password'           => $this->input('password'),
            'phone'              => $this->input('phone'),
            'address'            => $this->input('address'),
            'identity_type'      => $this->input('identity_type'),
            'identity_file'      => $identityFile,
            'verification_token' => $token,
        ]);

        // Send verification email
        Mailer::sendVerification($email, $this->input('full_name'), $token);

        $this->flash('success', 'Registration successful! Please check your email to verify your account.');
        $this->redirect('auth/login');
    }

    // ----------------------------------------------------------------
    // Email verification
    // ----------------------------------------------------------------

    public function verifyEmail(string $token): void
    {
        $user = $this->userModel->findByVerificationToken($token);

        if (!$user) {
            $this->flash('danger', 'Invalid or expired verification link.');
            $this->redirect('auth/login');
            return;
        }

        $this->userModel->verifyEmail($user['id']);
        $this->flash('success', 'Email verified! You can now log in.');
        $this->redirect('auth/login');
    }

    // ----------------------------------------------------------------
    // Password Reset
    // ----------------------------------------------------------------

    public function forgotForm(): void
    {
        $this->view('auth.forgot_password', ['csrf' => $this->generateCsrf()], 'auth');
    }

    public function sendReset(): void
    {
        $this->verifyCsrf();
        $email = trim($this->input('email', ''));
        $user  = $this->userModel->findByEmail($email);

        if ($user) {
            $token   = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + 3600);

            $this->userModel->update($user['id'], [
                'password_reset_token'   => $token,
                'password_reset_expires' => $expires,
            ]);

            Mailer::sendPasswordReset($email, $user['full_name'], $token);
        }

        // Always show success to avoid email enumeration
        $this->flash('success', 'If that email exists, a reset link has been sent.');
        $this->redirect('auth/login');
    }

    public function resetForm(string $token): void
    {
        $user = $this->userModel->findByResetToken($token);
        if (!$user) {
            $this->flash('danger', 'Invalid or expired reset link.');
            $this->redirect('auth/login');
            return;
        }

        $this->view('auth.reset_password', ['csrf' => $this->generateCsrf(), 'token' => $token], 'auth');
    }

    public function resetPassword(): void
    {
        $this->verifyCsrf();

        $token    = $this->input('token', '');
        $password = $this->input('password', '');
        $confirm  = $this->input('password_confirmation', '');

        if ($password !== $confirm || strlen($password) < 8) {
            $this->flash('danger', 'Passwords do not match or are too short (min 8 chars).');
            $this->back();
            return;
        }

        $user = $this->userModel->findByResetToken($token);
        if (!$user) {
            $this->flash('danger', 'Invalid or expired reset link.');
            $this->redirect('auth/login');
            return;
        }

        $this->userModel->update($user['id'], [
            'password'             => password_hash($password, PASSWORD_BCRYPT),
            'password_reset_token' => null,
            'password_reset_expires'=> null,
        ]);

        $this->flash('success', 'Password reset successfully. You can now log in.');
        $this->redirect('auth/login');
    }

    // ----------------------------------------------------------------
    // Logout
    // ----------------------------------------------------------------

    public function logout(): void
    {
        Session::destroy();
        $this->redirect('auth/login');
    }

    // ----------------------------------------------------------------
    // Private helpers
    // ----------------------------------------------------------------

    private function redirectByRole(string $role): void
    {
        match ($role) {
            'admin'  => $this->redirect('admin/dashboard'),
            'driver' => $this->redirect('driver/dashboard'),
            default  => $this->redirect('customer/dashboard'),
        };
    }

    private function handleIdentityUpload(): string|false
    {
        if (!isset($_FILES['identity_file']) || $_FILES['identity_file']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $file      = $_FILES['identity_file'];
        $ext       = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed   = ['jpg', 'jpeg', 'png', 'pdf'];

        if (!in_array($ext, $allowed)) {
            return false;
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            return false; // 5MB max
        }

        // Verify it's actually an image or PDF via mime type
        $mime = mime_content_type($file['tmp_name']);
        $allowedMimes = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($mime, $allowedMimes)) {
            return false;
        }

        $filename   = uniqid('id_', true) . '.' . $ext;
        $uploadPath = PUBLIC_PATH . '/uploads/identities/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return false;
        }

        return $filename;
    }
}
