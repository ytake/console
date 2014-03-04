<?php
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use Comnect\Console\Command\VersionCommand;
/**
 * Class VersionCommandTest
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class VersionCommandTest extends \Comnect\Testing\TestCase
{
	/**
	 * @test
	 */
	public function testExecute()
	{
		//
		$application = new Application();
		$application->add(new VersionCommand());
		$command = $application->find('consoler:version');
		$commandTester = new CommandTester($command);
		$commandTester->execute(array('command' => $command->getName()));
		$this->assertEquals('comnect/console 0.1.9-alpha', trim($commandTester->getDisplay()));
	}
}