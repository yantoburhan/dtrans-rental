<?php

/**
 * Controller — Base controller with shared utilities
 * All controllers extend this class
 */
abstract class Controller
{
    // ----------------------------------------------------------------
    // View rendering
    // ----------------------------------------------------------------

    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        // Make data variables available in view
        extract($data);

        $viewFile   = APP_PATH . '/views/' . str_replace('.', '/', $view) . '.php';
        $layoutFile = APP_PATH . '/views/layouts/' . $layout . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View [$view] not found at $viewFile");
        }

        // Capture view content
        $content = '';
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Render inside layout (or standalone if layout = none)
        if ($layout === 'none') {
            echo $content;
        } else {
            if (!file_exists($layoutFile)) {
                throw new \RuntimeException("Layout [$layout] not found.");
            }
            require $layoutFile;
        }
    }

    // ----------------------------------------------------------------
    // Redirect helpers
    // ----------------------------------------------------------------

    protected function redirect(string $path): void
    {
        $base = rtrim(Env::get('APP_URL'), '/');
        header("Location: $base/$path");
        exit;
    }

    protected function back(): void
    {
        $ref = $_SERVER['HTTP_REFERER'] ?? Env::get('APP_URL');
        header("Location: $ref");
        exit;
    }

    // ----------------------------------------------------------------
    // JSON response
    // ----------------------------------------------------------------

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // ----------------------------------------------------------------
    // Request helpers
    // ----------------------------------------------------------------

    protected function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    // ----------------------------------------------------------------
    // CSRF
    // ----------------------------------------------------------------

    protected function generateCsrf(): string
    {
        if (!Session::has('_csrf_token')) {
            Session::set('_csrf_token', bin2hex(random_bytes(32)));
        }
        return Session::get('_csrf_token');
    }

    protected function validateCsrf(string $token = ''): bool
    {
        $token = $token ?: ($_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
        return hash_equals(Session::get('_csrf_token', ''), $token);
    }

    protected function verifyCsrf(): void
    {
        if (!$this->validateCsrf()) {
            http_response_code(419);
            die('CSRF token mismatch.');
        }
    }

    // ----------------------------------------------------------------
    // Flash messages
    // ----------------------------------------------------------------

    protected function flash(string $type, string $message): void
    {
        Session::flash('alert', ['type' => $type, 'message' => $message]);
    }
}
