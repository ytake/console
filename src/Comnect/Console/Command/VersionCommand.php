<?php
namespace Comnect\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command Controller
 * @package Comnect\Console\Command
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class VersionCommand extends Command
{
	const COMMAND_NAME = "consoler:version";

	const VERSION = '0.1.4-beta';

	/**
	 *
	 */
	protected function configure()
	{
		$this->setName(self::COMMAND_NAME)
			->setDescription('Display this comnect/console version')
			->addArgument('console:version');
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|null|void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$controller = $input->getArgument(self::COMMAND_NAME);
		$text = "comnect/console <info>" .self::VERSION . "</info>";
		$text .= "\n";
		$output->writeln($text);
	}
}
