<?php
namespace Comnect\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Container\Container;

/**
 * Class Command Controller
 * @package Comnect\Console\Command
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class ControllerCommand extends Command
{
	const COMMAND_NAME = "controller:perform";

	/** @var \Illuminate\Container\Container */
	protected $container;

	public function __construct()
	{
		parent::__construct();
		$this->container = new Container;
	}

	/**
	 *
	 */
	protected function configure()
	{
		$this->setName(self::COMMAND_NAME)
			->setDescription('start process')
			->addArgument('controller', InputArgument::REQUIRED, 'start process');
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|null|void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$controller = ucwords($input->getArgument('controller'));

		// perform process
		try {

			$this->container->make($controller)->perform();
			$output->writeln("perform controller:$controller");

		// refrectionException
		}catch(\ReflectionException $e){
			$output->writeln("<error>error! controller:$controller not found</error>");
		}
	}
}