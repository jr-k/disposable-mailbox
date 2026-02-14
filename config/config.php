<?php

date_default_timezone_set(getenv('TIMEZONE') ?: 'Europe/Paris');

$config['locale'] = getenv('LOCALE') ?: 'en_US';

if (getenv('DEBUG') === 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

$config['imap']['url'] = getenv('IMAP_URL') ?: '{imap.example.com:993/imap/ssl}INBOX';
$config['imap']['username'] = getenv('IMAP_USERNAME') ?: '';
$config['imap']['password'] = getenv('IMAP_PASSWORD') ?: '';

$config['domains'] = array_map('trim', explode(',', getenv('DOMAINS') ?: 'example.com'));

$config['delete_messages_older_than'] = getenv('DELETE_OLDER_THAN') ?: '30 days ago';

$config['blocked_usernames'] = array_map('trim', explode(',', getenv('BLOCKED_USERNAMES') ?: 'root,admin,administrator,hostmaster,postmaster,webmaster'));

$config['prefer_plaintext'] = getenv('PREFER_PLAINTEXT') !== 'false';
