<?php
namespace Comnect\Support;
use Comnect\Support\Interfaces\LogInterface;
use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;
use Illuminate\Container\Container;
/**
 * Class Logger
 * @package Comnect\Support
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Logger implements LogInterface{

	/** @var \Illuminate\Container\Container  */
	protected $container;
	/** @var \Comnect\Support\Config  */
	protected $config;
	/** @var \Monolog\Logger */
	protected $log;

	/**
	 * @param Container $container
	 * @param Config $config
	 */
	public function __construct(Container $container, Config $config)
	{
		$this->container = $container;
		$this->config = $config;

		$this->container['log'] = $this->container->share(function(){
			return new MonoLogger('comnect/console');
		});
	}

	/**
	 * @param null $path
	 * @param int $level
	 * @return mixed
	 */
	public function log($path = null, $level = MonoLogger::DEBUG)
	{
		$logConfigure = $this->config->get('log');
		$path = (is_null($path)) ? $this->config->path('storage') ."/logs/". $logConfigure['filename'] : $path;
		if(!is_null($path) && $logConfigure['debug'] !== false)
		{
			$this->log = $this->container->make('log');
			$this->log->pushHandler(new StreamHandler($path, $level));
			return $this->log;
		}
	}
}