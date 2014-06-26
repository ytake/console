<?php
namespace Comnect\Console\Datastore\Interfaces;

/**
 * Interface DataStoreInterface
 * @package Comnect\Console\Datastore\Interfaces
 */
interface DataStoreInterface
{

    /**
     * connection
     * @param string $database
     * @return mixed
     */
    public function connect($database);
}