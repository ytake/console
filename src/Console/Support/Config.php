<?php
namespace Comnect\Console\Support;

use Comnect\Console\Support\Interfaces\ConfigInterface;

/**
 * Class Config
 * @package Comnect\Support
 * @author yuuki.takezawa<yuuki.takeawa@comnect.jp.net>
 */
class Config implements ConfigInterface
{

    /**
     * @param $filename
     * @return mixed
     * @throws \ErrorException
     */
    public function get($filename)
    {
        $configure = $this->_getEnvironmentFile();
        foreach($configure as $env => $values) {
            $host = array_search(gethostname(), $values);
            // not found
            if($host !== false) {
                $config = $this->path('config') ."/$env/$filename.php";
                if(file_exists($config)) {
                    return require $config;
                    break;
                }
            }
        }
        // default or production file
        $config = $this->path('config') ."/". $filename . ".php";
        if(!file_exists($config)) {
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
        $path = array(
            'root' => realpath(null),
            'config' => realpath(null) . "/src/config",
            'storage' => realpath(null) . "/src/storage",
        );
        return $path[$name];
    }

    /**
     * get environmnet
     * @return int|string
     */
    public function getEnvironment()
    {
        $configure = $this->_getEnvironmentFile();
        foreach($configure as $env => $values) {
            $host = array_search(gethostname(), $values);
            // not found
            if($host !== false) {
                return $env;
                break;
            }
        }
        // default environment
        return 'production';
    }

    /**
     * get environment file
     * @access private
     * @return array
     * @throws \ErrorException
     */
    private function _getEnvironmentFile()
    {
        $environmentFile = $this->path('config') . "/environment.php";
        if(!file_exists($environmentFile)) {
            throw new \ErrorException("not found $environmentFile", 500);
        }
        return require $environmentFile;
    }
}