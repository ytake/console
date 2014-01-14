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
	private $_application;

	/**
	 * construct
	 * @param string $name
	 * @param string $version
	 *
	 */
	public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
	{
		parent::__construct($name, $version);
		//
		$this->_application = new SymfonyConsole();
		// register commands
		$this->_addCommands();
	}

	/**
	 * console boot
	 */
	public function boot()
	{
		// boot process
		$this->_application->run();
	}

	/**
	 * add application command
	 * @return void
	 */
	private function _addCommands()
	{
		// performer
		$this->_application->add(new \Comnect\Console\Command\ControllerCommand);
		// display version
		$this->_application->add(new \Comnect\Console\Command\VersionCommand);
	}

}