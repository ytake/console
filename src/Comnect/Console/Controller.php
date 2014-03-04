<?php
namespace Comnect\Console;

use Comnect\Console\Interfaces\ApplicationInterface;
use Comnect\Datastore\Datastore;
use Illuminate\Container\Container;

/**
 * Class Controller
 * @package Comnect\Console
 * @author yuuki.takezawa<yuuki.takeawa@comnect.jp.net>
 *
 */
class Controller extends Container implements ApplicationInterface{

	/**
	 * perform
	 * @return mixed|void
	 */
	public function perform(array $array){}
}