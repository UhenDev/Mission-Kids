<?php
/**
 * MISSION KIDS — Front Controller & Application Router
 */

declare(strict_types=1);

require_once __DIR__ . '/../src/Helpers/Session.php';
require_once __DIR__ . '/../src/Helpers/Security.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/Controllers/HomeController.php';
require_once __DIR__ . '/../src/Controllers/MissionController.php';
require_once __DIR__ . '/../src/Controllers/ApiController.php';

$appConfig = require __DIR__ . '/../config/config.php';
if (($appConfig['app']['env'] ?? 'development') === 'production') {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

Session::start();
Security::setSecurityHeaders();

$page = $_GET['page'] ?? (Session::isLoggedIn() ? 'home' : 'landing');
$method = $_SERVER['REQUEST_METHOD'];

switch ($page) {
    case 'landing':
        $controller = new HomeController();
        $controller->landing();
        break;

    case 'login':
        $controller = new AuthController();
        if ($method === 'POST') {
            $controller->handleLogin();
        } else {
            $controller->showLogin();
        }
        break;

    case 'register':
        $controller = new AuthController();
        if ($method === 'POST') {
            $controller->handleRegister();
        } else {
            $controller->showRegister();
        }
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'home':
        $controller = new HomeController();
        $controller->studentHome();
        break;

    case 'worlds':
        $controller = new MissionController();
        $controller->showWorlds();
        break;

    case 'mission':
        $slug = (string)($_GET['slug'] ?? 'tanaman-layu');
        $controller = new MissionController();
        $controller->play($slug);
        break;

    case 'achievements':
        $controller = new HomeController();
        $controller->achievements();
        break;

    case 'progress':
        $controller = new HomeController();
        $controller->progress();
        break;

    case 'api':
        $controller = new ApiController();
        $controller->handleRequest();
        break;

    default:
        if (Session::isLoggedIn()) {
            header('Location: ?page=home');
        } else {
            header('Location: ?page=landing');
        }
        exit;
}
