<?php

return [
    'host'    => Env::get('DB_HOST', 'localhost'),
    'port'    => Env::get('DB_PORT', 3306),
    'dbname'  => Env::get('DB_NAME', 'dtrans_rental'),
    'user'    => Env::get('DB_USER', 'root'),
    'pass'    => Env::get('DB_PASS', ''),
    'charset' => 'utf8mb4',
];
