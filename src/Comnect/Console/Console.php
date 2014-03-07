<?php
namespace Comnect\Console;
use Comnect\Console\Command\ControllerCommand;
use Comnect\Console\Command\VersionCommand;
use Symfony\Component\Console\Application as SymfonyConsole;
use Symfony\Component\Console\Command\Command;

/**
 * Class Console
 * @package Comnect\Console
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Console extends SymfonyConsole {

	/** @var \Symfony\Component\Console\Application */
	protected $application;
	/** @var \Comnect\Console\Controller */
	protected $app;
	/** @var array  */
	protected $commands = array();

	/**
	 * @param Controller $app
	 * @param string $name
	 * @param string $version
	 */
	public function __construct(Controller $app, $name = 'UNKNOWN', $version = 'UNKNOWN')
	{
		parent::__construct($name, $version);
		//
		$this->application = new SymfonyConsole();
		$this->app = $app;
	}

	/**
	 * boot consoler
	 */
	public function boot()
	{
		// register commands
		$this->_addCommands();
		// boot
		$this->application->run();
	}

	/**
	 * add application command
	 * @return void
	 */
	private function _addCommands()
	{
		// performer
		$this->application->add(new ControllerCommand($this->app));
		// display version
		$this->application->add(new VersionCommand);
		if(count($this->commands))
		{
			foreach($this->commands as $command)
			{
				$this->application->add($command);
			}
		}
	}

	/**
	 * add user commands
	 * @param Command $class
	 */
	public function addCommand(Command $class)
	{
		$this->commands[] = $class;
	}
}