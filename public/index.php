<?php

/**
 * Dtrans Rental — Front Controller
 * All requests are routed through this file via .htaccess
 */

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH',  ROOT_PATH . '/app');
define('PUBLIC_PATH', __DIR__);

// Load environment variables
require_once ROOT_PATH . '/app/core/Env.php';
Env::load(ROOT_PATH . '/.env');

// Load Composer autoload first so third-party packages are available
require_once ROOT_PATH . '/vendor/autoload.php';

// Load core autoloader
require_once ROOT_PATH . '/app/core/Autoloader.php';
Autoloader::register();

// Start session
require_once ROOT_PATH . '/app/core/Session.php';
Session::start();

// Bootstrap application
require_once ROOT_PATH . '/app/core/App.php';
$app = new App();
$app->run();
