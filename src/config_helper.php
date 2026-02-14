<?php

/**
 * Loads .env file if present (does not override existing env vars).
 */
function load_dotenv() {
    $dotenv_path = __DIR__ . '/..';
    if (file_exists($dotenv_path . '/.env')) {
        $dotenv = Dotenv\Dotenv::createImmutable($dotenv_path);
        $dotenv->safeLoad();
    }
}

/**
 * Loads .env then loads the config file.
 */
function load_config() {
    global $config;

    load_dotenv();

    require_once __DIR__ . '/config.php';

    if (!isset($config) || !is_array($config)) {
        die('ERROR: Config file is invalid. Please see the installation instructions in the README.md');
    }
}
