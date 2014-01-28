<?php
namespace Comnect\Datastore;

use Comnect\Datastore\Interfaces\DatastoreInterface;
use Comnect\Support\Config;
use Illuminate\Database\Capsule\Manager as DatabaseManager;

/**
 * Class Database
 * @package Comnect\Datastore
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Database implements DatastoreInterface{

	/** @var \Comnect\Support\Config */
	protected $config;
	/** @var \Illuminate\Database\Capsule\Manager  */
	protected $manager;
	/** @var \Illuminate\Database\Connection  */
	protected $connector;

	/**
	 * @param Config $config
	 * @param DatabaseManager $database
	 */
	public function __construct(Config $config, DatabaseManager $manager)
	{
		$this->config = $config;
		$this->manager = $manager;
	}

	/**
	 *
	 * @param $database
	 */
	public function connect($database)
	{
		$db = $this->config->get('database');
		$connection = $db['connections'][$database];
		$this->manager->addConnection($connection, $database);
		$this->manager->setAsGlobal();
		$this->connector = $this->manager->connection($database);
		return $this->connector;
	}
}