<?php
namespace Comnect\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Comnect\Console\Controller;

/**
 * Class Command Controller
 * @package Comnect\Console\Command
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class ControllerCommand extends Command
{
	const COMMAND_NAME = "consoler:perform";

	/** @var \Comnect\Console\Controller */
	protected $app;

	public function __construct(Controller $app)
	{
		parent::__construct();
		$this->app = $app;
	}

	/**
	 * configure
	 */
	protected function configure()
	{
		$this->setName(self::COMMAND_NAME)
			->setDescription('specify the namespace(controller)')
			->addArgument('controller', InputArgument::REQUIRED, 'specify the namespace(controller)')
			->addOption(
				'vars', null,
				InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
				'if set, perform set variables'
			);
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|null|void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$array = array();
		$controller = ucwords($input->getArgument('controller'));
		if ($input->getOption('vars'))
		{
			$array = $input->getOption('vars');
		}

		// perform process
		try {
			// path to perform
			$this->app->make($controller)->perform($array);
			$output->writeln("perform controller:$controller");

		// reflectionException
		}catch(\ReflectionException $e){
			$output->writeln("<error>error! controller:$controller not found</error>");
		}
	}
}