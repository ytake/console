<?php
namespace Comnect\Console;

use Illuminate\Container\Container;
use Comnect\Console\Interfaces\ApplicationInterface;


/**
 * Class Controller
 * @package Comnect\Console
 * @author yuuki.takezawa<yuuki.takeawa@comnect.jp.net>
 */
abstract class Controller extends Container
{
    
    /**
     * @param array $array
     * @return mixed|void
     */
    abstract function perform(array $array);
}
