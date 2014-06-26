<?php
namespace Comnect\Console;

use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Comnect\Console\Command\ControllerCommand;

/**
 * Class Console
 * @package Comnect\Console
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Console extends Application
{

    /** @var \Illuminate\Container\Container  */
    protected $container;

    /** @var array  */
    protected $commands = array();

    /** @var string  */
    protected $name = "comnect/console";

    /** @var float  */
    protected $version = 0.3;

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct($this->name, $this->version);
        $this->container = new Container;
    }

    /**
     *
     */
    public function boot()
    {
        // register commands
        $this->registerCommands();
        // boot
        $this->run();
    }

    /**
     * add application command
     * @access private
     * @return void
     */
    private function registerCommands()
    {
        // perform
        $this->add(new ControllerCommand($this->container));

        if(count($this->commands)) {
            foreach($this->commands as $command) {
                $this->add($command);
            }
        }
    }

    /**
     * @param Command $class
     */
    public function addCommand(Command $class)
    {
        $this->commands[] = $class;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}