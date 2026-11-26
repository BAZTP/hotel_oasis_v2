<?php
use Core\Database;
use Core\DatabaseException;
use Core\R2;

$config = require 'config.php';

$DB_USER = $_ENV['DB_USER'] ?? getenv('DB_USER', 'root');
$DB_PASSWORD = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD', '');

try {
	$db = Database::getInstance($config['db'], $DB_USER, $DB_PASSWORD);
	$s3 = R2::getInstance($config['r2']);
} catch (DatabaseException | Exception $e) {
	echo $e->getMessage();
	die();
}
