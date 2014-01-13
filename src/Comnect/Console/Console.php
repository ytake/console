<?php
namespace Comnect\Console;

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Application as SymfonyConsole;
use Comnect\Console\Command;
/**
 * @category console
 * @category core
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Console extends SymfonyConsole {

	/** @var \Symfony\Component\Console\Application @var */
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
		// registar commands
		$this->_addCommands();
	}

	/**
	 *
	 * @param \Comnect\Console\Application $app
	 */
	public function boot()
	{
		// boot process
		$this->_application->run();
	}

	/**
	 * add application command
	 * @param ArgvInput $argv
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