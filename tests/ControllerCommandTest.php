<?php
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use Comnect\Console\Command\ControllerCommand;
use Comnect\Console\Controller;

/**
 * Class ControllerCommandTest
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class ControllerCommandTest extends \Comnect\Testing\TestCase
{
	/**
	 * @test
	 * @expectedException \RuntimeException
	 */
	public function testNotNamespaceExecute()
	{
		//
		$application = new Application();
		$application->add(new ControllerCommand(new Controller));
		$command = $application->find('consoler:perform');
		$commandTester = new CommandTester($command);
		$commandTester->execute(array('command' => $command->getName()));
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function testNotFoundClassExcute()
	{
		$application = new Application();
		$application->add(new ControllerCommand(new Controller));
		$command = $application->find('consoler:perform');
		$commandTester = new CommandTester($command);
		$commandTester->execute(array('command' => $command->getName(), 'controller' => "NotFoundClass"));
	}

	/**
	 * @test
	 */
	public function testExcute()
	{
		$application = new Application();
		$application->add(new ControllerCommand(new Controller));
		$command = $application->find('consoler:perform');
		$commandTester = new CommandTester($command);
		$commandTester->execute(array('command' => $command->getName(), 'controller' => '\\StubController'));
		$this->assertSame('perform controller:\StubController', trim($commandTester->getDisplay()));
	}
}

/**
 * Class StubController
 */
class StubController extends \Comnect\Console\Controller{

	public function perform(array $array){

	}
}