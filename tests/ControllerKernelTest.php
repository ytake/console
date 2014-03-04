<?php
use Comnect\Console\Controller;
/**
 * ControllerTest.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/02/17 17:38
 */
class ControllerKernelTest extends \Comnect\Testing\TestCase
{
	protected $controller;

	/**
	 *
	 */
	protected function setUp()
	{
		$this->controller = new Controller();
	}

	/**
	 * controller basic perform testing
	 * @test
	 */
	public function testControllerPerform()
	{
		$this->assertSame(null, $this->controller->perform(array()));
	}

	/**
	 * @test
	 */
	public function testControllerPerformValues()
	{
		$this->assertSame(null, $this->controller->perform(array('hello', 'controller')));
	}

	/**
	 * @expectedException \ReflectionException
	 */
	public function testControllerMake()
	{
		$this->controller->make("Hello");
	}

	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testControllerPerformObject()
	{
		$this->controller->perform(new \stdClass);
	}

	/**
	 * @expectedException PHPUnit_Framework_Error_Warning
	 */
	public function testControllerMakeNoClass()
	{
		$this->controller->make();
	}
}