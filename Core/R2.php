<?php
namespace Core;

use Aws\S3\S3Client;

class R2
{
	private $client;
	private $bucket;
	private static $instance;

	public function __construct($config)
	{
		$this->client = new S3Client([
			'version' => 'latest',
			'region' => $config['region'],
			'endpoint' => $config['endpoint'],
			'credentials' => [
				'key' => $config['key'],
				'secret' => $config['secret']
			]
		]);
		$this->bucket = $config['bucket'];
	}

	public function putObject($params)
	{
		$this->client->putObject([
			'Bucket' => $this->bucket,
			'Key' => $params['Key'],
			'Body' => $params['Body']
		]);
	}

	public function getClient(): S3Client
	{
		return $this->client;
	}

	public function getBucket(): string
	{
		return $this->bucket;
	}

	private static function instanceExists()
	{
		return self::$instance !== null;
	}

	public static function getInstance($config): R2
	{
		if (!self::instanceExists()) {
			if (empty($config)) {
				throw new DatabaseException('No database configuration provided');
			}

			self::$instance = new self($config);
		}
		return self::$instance;
	}
}
