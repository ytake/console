<?php
namespace Comnect\Support;
use Comnect\Application;

class Config{

	/**
	 * get configure file
	 * @return array
	 */
	public function get($filename)
	{
		$environmnetFile = dirname(dirname(dirname(dirname(dirname(dirname(dirname(realpath(__FILE__)))))))) . "/app/config/environment.php";
		if(!file_exists($environmnetFile))
		{
			throw new \ErrorException("not found $environmnetFile", 500);
		}

		$configure = require_once $environmnetFile;
		foreach($configure as $env => $values)
		{
			$host = array_search(gethostname(), $values);
			// not found
			if($host !== false)
			{
				$config = $this->path('config') ."/$env/$filename.php";
				if(file_exists($config))
				{
					return require_once $config;
					break;
				}
			}
		}
		// default or production file
		$config = $this->path('config') ."/". $filename . ".php";
		if(!file_exists($config))
		{
			throw new \ErrorException("not found $config", 500);
		}
		return require_once $config;
	}

	/**
	 * path information
	 * @param void
	 * @return array
	 */
	public function path($e)
	{
		$path = [
			'root' => dirname(dirname(dirname(dirname(dirname(dirname(dirname(realpath(__FILE__)))))))),
			'config' => dirname(dirname(dirname(dirname(dirname(dirname(dirname(realpath(__FILE__)))))))) . "/app/config",
		];
		return $path[$e];
	}
}