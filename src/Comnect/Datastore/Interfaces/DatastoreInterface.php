<?php
namespace Comnect\Datastore\Interfaces;

/**
 * Interface DatastoreInterface
 * @package Comnect\Datastore\Interfaces
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
interface DatastoreInterface{

	/**
	 * connection
	 * @param string $database
	 * @return mixed
	 */
	public function connect($database);
}