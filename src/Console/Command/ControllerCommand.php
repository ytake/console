<?php
namespace Comnect\Console\Command;

use ErrorException;
use Illuminate\Container\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command Controller
 * @package Comnect\Console\Command
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class ControllerCommand extends Command
{

    const COMMAND_NAME = "consoler:perform";

    /** @var Container */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('specify the command or namespace')
            ->addArgument(
                'action',
                InputArgument::REQUIRED,
                'specify the command or namespace'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = "";
        $query = array();
        //
        $parsed = parse_url($input->getArgument('action'));

        if(isset($parsed['path'])) {
            $command = $parsed['path'];
            // query parse
            if(isset($parsed['query'])) {
                parse_str($parsed['query'], $query);
            }
        }


        /**
         */
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if ($errno == E_RECOVERABLE_ERROR) {
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            }
        });

        try {
            /** @var  $start */
            $start = microtime(true);

            $this->container->bind('Comnect\Console\Support\Interfaces\LogInterface', 'Comnect\Console\Support\Logger');
            $this->container->bind('Comnect\Console\Support\Interfaces\ConfigInterface', 'Comnect\Console\Support\Config');
            $this->container->make($command)->perform($query);

            /** @var  $end */
            $end = microtime(true);
            $process = sprintf('%0.5f', ($end - $start));
            $output->writeln("<info>{$process}</info><comment>/second</comment>");

        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), 500);

        }
    }
}