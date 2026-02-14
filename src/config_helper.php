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
 * searches for a config-file: first in the config/ directory (recommended),
 * then falls back to current and parent directories.
 * @return path to found config file, or FALSE otherwise.
 */
function find_config($filename='config.php') {
    // Check the config/ directory first (relative to src/)
    $data_config = __DIR__ . '/../config/' . $filename;
    if (file_exists($data_config)) {
        return $data_config;
    }

    // Fallback: walk up from current directory
    $path_length = substr_count(getcwd(), DIRECTORY_SEPARATOR)
        + 1; // also search the current directory

    $dir = '.'; // updated in each loop
    for ($i=0; $i<$path_length;$i++) {
        $config_filename = $dir . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($config_filename)) {
            return $config_filename;
        } else {
            $dir = '../' . $dir;
        }
    }
    return false;
}

/**
 * Loads .env then searches and loads the config file. Prints an error if not found.
 */
function load_config() {
    global $config;

    load_dotenv();

    $file = find_config();
    if ($file !== false) {
        require_once($file);
        if (!isset($config) || !is_array($config)) {
            die('ERROR: Config file is invalid. Please see the installation instructions in the README.md');
        }
    } else {
        die('ERROR: Config file not found. Please see the installation instructions in the README.md');
    }
}
