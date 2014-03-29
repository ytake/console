<?php
namespace Comnect\Support\Interfaces;

/**
 * Interface ConfigInterface
 * @package Comnect\Support\Config\Interfaces
 * @author yuuki.takezawa<yuuki.takeawa@comnect.jp.net>
 *
 */
interface ConfigInterface {

	/**
	 * @param $filename
	 * @return mixed
	 */
	public function get($filename);
}