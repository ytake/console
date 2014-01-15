<?php
namespace Comnect\Support;

use Comnect\Support\Config\Interfaces\ConfigInterface;
/**
 * Class Config
 * @package Comnect\Support
 * @author yuuki.takezawa<yuuki.takeawa@comnect.jp.net>
 *
 */
class Config implements ConfigInterface {

	/**
	 * get configure file
	 * @return array
	 */
	public function get($filename)
	{
		$environmentFile = dirname(dirname(dirname(dirname(dirname(dirname(dirname(realpath(__FILE__)))))))) . "/app/config/environment.php";
		if(!file_exists($environmentFile))
		{
			throw new \ErrorException("not found $environmentFile", 500);
		}

		$configure = require $environmentFile;
		foreach($configure as $env => $values)
		{
			$host = array_search(gethostname(), $values);
			// not found
			if($host !== false)
			{
				$config = $this->path('config') ."/$env/$filename.php";
				if(file_exists($config))
				{
					return require $config;
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
		return require $config;
	}

	/**
	 * path information
	 * @param string $name
	 * @return array
	 */
	public function path($name)
	{
		$path = [
			'root' => dirname(dirname(dirname(dirname(dirname(dirname(dirname(realpath(__FILE__)))))))),
			'config' => dirname(dirname(dirname(dirname(dirname(dirname(dirname(realpath(__FILE__)))))))) . "/app/config",
		];
		return $path[$name];
	}
}