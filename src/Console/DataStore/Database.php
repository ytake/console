<?php
namespace Comnect\Console\DataStore;

use Comnect\Console\Support\Interfaces\LogInterface;
use Comnect\Console\Support\Interfaces\ConfigInterface;
use Comnect\Console\DataStore\Interfaces\DataStoreInterface;
use Illuminate\Database\Capsule\Manager as DatabaseManager;

/**
 * Class Database
 * @package Comnect\Datastore
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Database implements DatastoreInterface
{

    /** @var ConfigInterface */
    protected $config;

    /** @var DatabaseManager  */
    protected $manager;

    /** @var \Illuminate\Database\Connection  */
    protected $connector;

    /** @var LogInterface  */
    protected $log;

    /** @var  string */
    protected $database;

    /**
     * @param ConfigInterface $config
     * @param DatabaseManager $manager
     * @param LogInterface $log
     */
    public function __construct(
        ConfigInterface $config,
        DatabaseManager $manager,
        LogInterface $log
    ) {
        $this->config = $config;
        $this->manager = $manager;
        $this->log = $log;
    }

    /**
     * @param string $database
     * @return \Illuminate\Database\Connection|mixed
     */
    public function connect($database)
    {
        $dbConfig = $this->config->get('database');
        $container = $this->manager->getContainer();
        $container['config']['database.fetch'] = $dbConfig['fetch'];
        $container['config']['database.default'] = $dbConfig['default'];
        $this->manager->setContainer($container);

        $connection = $dbConfig['connections'][$database];
        $this->manager->addConnection($connection, $database);

        $this->manager->setAsGlobal();
        $this->connector = $this->manager->connection($database);
        return $this->connector;
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        if($this->connector != null) {
            if(!is_null($this->log->log())) {
                $this->log->log()->addDebug('query.log', $this->connector->getQueryLog());
            }
        }
        /** @var \Illuminate\Database\DatabaseManager $database */
        $database = $this->manager->getDatabaseManager();
        $database->disconnect();
    }
}
