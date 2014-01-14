<?php
namespace Comnect\Datastore;

use Comnect\Datastore\Interfaces\DatastoreInterface;
use Comnect\Support\Config;
use Predis\Client;

/**
 * Class Redis
 * @package Comnect\Datastore
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Redis implements DatastoreInterface {

	/** @var \Comnect\Support\Config */
	protected $config;

	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 *
	 * @param array $database
	 */
	public function connect($database = 'default')
	{
		$connection = $this->config->get('redis')[$database];
		return new Client($connection);
	}
}