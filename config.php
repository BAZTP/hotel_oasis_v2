<?php

return [
	'db' => [
		'host' => $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost',
		'port' => $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: '3306',
		'dbname' => $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'test',
		'charset' => $_ENV['DB_CHARSET'] ?? getenv('DB_CHARSET') ?: 'utf8mb4',
		'ssl-mode' => $_ENV['DB_SSL_MODE'] ?? getenv('DB_SSL_MODE') ?: 'REQUIRED'
	],
	'r2' => [
		'region' => $_ENV['S3_REGION'] ?? getenv('S3_REGION') ?: 'us-east-1',
		'endpoint' => $_ENV['S3_ENDPOINT'] ?? getenv('S3_ENDPOINT') ?: '',
		'key' => $_ENV['S3_ACCESS_KEY'] ?? getenv('S3_ACCESS_KEY') ?: '',
		'secret' => $_ENV['S3_SECRET_KEY'] ?? getenv('S3_SECRET_KEY') ?: '',
		'bucket' => $_ENV['S3_BUCKET'] ?? getenv('S3_BUCKET') ?: '',
		'public' => $_ENV['S3_PUBLIC_URL'] ?? getenv('S3_PUBLIC_URL') ?: ''
	]
];
