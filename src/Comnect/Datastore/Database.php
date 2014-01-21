<?php
namespace Comnect\Datastore;

use Comnect\Datastore\Interfaces\DatastoreInterface;
use Comnect\Support\Config;
use Illuminate\Database\Connectors\ConnectionFactory;

/**
 * Class Database
 * @package Comnect\Datastore
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Database implements DatastoreInterface{

	/** @var \Comnect\Support\Config */
	protected $config;
	/** @var  \Illuminate\Database\Connectors\ConnectionFactory */
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
		$db = $this->config->get('database');
		$connection = $db['connections'][$database];
		return $this->connection->make($connection);
	}
}