<?php
/**
 * MISSION KIDS — Auth Controller
 */

declare(strict_types=1);

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Helpers/Security.php';
require_once __DIR__ . '/../Helpers/Session.php';

class AuthController
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    public function showLogin(?string $error = null): void
    {
        if (Session::isLoggedIn()) {
            header('Location: ?page=home');
            exit;
        }

        $csrfToken = Security::generateCsrfToken();
        $pageTitle = "Masuk — MISSION KIDS";
        require __DIR__ . '/../../templates/pages/auth/login.php';
    }

    public function handleLogin(): void
    {
        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->showLogin('Sesi keamanan kedaluwarsa. Silakan coba lagi ya!');
            return;
        }

        $username = (string)($_POST['username'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        $result = $this->auth->login($username, $password);
        if ($result['success']) {
            header('Location: ?page=home');
            exit;
        } else {
            $this->showLogin($result['error']);
        }
    }

    public function showRegister(?string $error = null): void
    {
        if (Session::isLoggedIn()) {
            header('Location: ?page=home');
            exit;
        }

        $csrfToken = Security::generateCsrfToken();
        $pageTitle = "Mulai Petualangan — MISSION KIDS";
        require __DIR__ . '/../../templates/pages/auth/register.php';
    }

    public function handleRegister(): void
    {
        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->showRegister('Sesi keamanan kedaluwarsa. Silakan coba lagi ya!');
            return;
        }

        $username = (string)($_POST['username'] ?? '');
        $nickname = (string)($_POST['nickname'] ?? '');
        $password = (string)($_POST['password'] ?? '');
        $avatarId = (string)($_POST['avatar_id'] ?? 'astro_cat');

        $result = $this->auth->register($username, $password, $nickname, $avatarId);
        if ($result['success']) {
            header('Location: ?page=home&welcome=1');
            exit;
        } else {
            $this->showRegister($result['error']);
        }
    }

    public function logout(): void
    {
        Session::destroy();
        header('Location: ?page=landing');
        exit;
    }
}
