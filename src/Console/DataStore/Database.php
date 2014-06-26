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

    /** @var Connection  */
    protected $connector;

    /** @var LogInterface  */
    protected $log;

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

        //$this->manager->setCacheManager(new \Illuminate\Cache\CacheManager($container));
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