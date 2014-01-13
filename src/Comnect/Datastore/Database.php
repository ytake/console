<?php
/**
 * Created by PhpStorm.
 * User: takezawa
 * Date: 2014/01/09
 * Time: 15:48
 */
namespace Comnect\Datastore;

use Comnect\Support\Config;
use PDO;
use Illuminate\Database\Connectors\ConnectionFactory;

class Database {

	/** @var \Comnect\Support\Config */
	protected $config;
	/** @var  Illuminate\Database\Connectors\ConnectionFactory */
	protected $connection;

	public function __construct(Config $config, ConnectionFactory $connection)
	{
		$this->config = $config;
		$this->connection = $connection;
	}

	/**
	 *
	 * @param $database
	 */
	public function connect($database)
	{
		$connection = $this->config->get('database')['connections'][$database];
		return $this->connection->make($connection);
	}
}