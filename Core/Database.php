<?php
namespace Core;

use PDO;
use PDOException;

class Database
{
	private $connection;
	private $statement;
	private static $instance;

	
        
        
        
        

	/**
	 * @throws DatabaseException
	 */
	public function __construct($config, $user = 'root', $password = '')
	{
		$dsn = 'mysql:' . http_build_query($config, '', ';');
		$dsn .= '?ssl-mode=' . $config['ssl-mode'];

		try {
			$this->connection = new PDO($dsn, $user, $password, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			]);
		} catch (PDOException $exception) {
			throw new DatabaseException(
				"Connection failed (probably database is off or wrong details): {$exception->getMessage()}"
			);
		}
	}

	/**
	 * @throws DatabaseException
	 */
	public function query($query): static
	{
		if ($this->connection === null) {
			throw new DatabaseException('No connection to database');
		}

		$this->statement = $this->connection->prepare($query);
		$this->statement->execute();
		return $this;
	}

	public function prepare($query): Database
  {
		if ($this->connection === null) {
			throw new DatabaseException('No connection to database');
		}

		$this->statement = $this->connection->prepare($query);
		return $this;
	}

	function bind($key, $value): static
	{
		$this->statement->bindParam($key, $value);
		return $this;
	}

	public function execute(): Database
  {
    $this->statement->execute();
		return $this;
	}

	/**
	 * @throws DatabaseException
	 */
	public function fetch()
	{
		if ($this->statement === null) {
			throw new DatabaseException('No query executed');
		}

		return $this->statement->fetch();
	}

	/**
	 * @throws DatabaseException
	 */
	public function fetchAll()
	{
		if ($this->statement === null) {
			throw new DatabaseException('No query executed');
		}

		return $this->statement->fetchAll();
	}

	private static function instanceExists(): bool
	{
		return self::$instance !== null;
	}

	/**
	 * @throws DatabaseException
	 */
	public static function getInstance($config = [], $user = 'root', $password = 'root'): Database
	{
		if (!self::instanceExists()) {
			if (empty($config)) {
				throw new DatabaseException('No database configuration provided');
			}

			self::$instance = new self($config, $user, $password);
		}
		return self::$instance;
	}

	/** */
}


