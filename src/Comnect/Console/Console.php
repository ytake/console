<?php
namespace Comnect\Console;

use Symfony\Component\Console\Application as SymfonyConsole;
use Comnect\Console\Command;

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

	/**
	 * construct
	 * @param string $name
	 * @param string $version
	 *
	 */
	public function __construct(Controller $app, $name = 'UNKNOWN', $version = 'UNKNOWN')
	{
		parent::__construct($name, $version);
		//
		$this->application = new SymfonyConsole();
		$this->app = $app;

		// register commands
		$this->_addCommands();
	}

	/**
	 * boot consoler
	 */
	public function boot()
	{
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
		$this->application->add(new \Comnect\Console\Command\ControllerCommand($this->app));
		// display version
		$this->application->add(new \Comnect\Console\Command\VersionCommand);
	}
}