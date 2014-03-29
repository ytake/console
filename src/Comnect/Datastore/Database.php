<?php
namespace Comnect\Datastore;

use Comnect\Datastore\Interfaces\DatastoreInterface;
use Comnect\Support\Config;
use Comnect\Support\Interfaces\LogInterface;
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
	/** @var \Comnect\Support\Interfaces\LogInterface  */
	protected $log;

	/**
	 * @param Config $config
	 * @param DatabaseManager $database
	 */
	public function __construct(Config $config, DatabaseManager $manager, LogInterface $log)
	{
		$this->config = $config;
		$this->manager = $manager;
		$this->log = $log;
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
		return $this->manager->connection($database);
	}

	/**
	 * @return void
	 */
	public function __destruct()
	{
		if($this->connector != null)
		{
			if(!is_null($this->log->log()))
			{
				$this->log->log()->addDebug('query.log', $this->connector->getQueryLog());
			}
		}
	}
}