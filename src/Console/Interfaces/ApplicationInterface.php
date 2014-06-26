<?php
namespace Comnect\Console\Interfaces;

/**
 * Interface ApplicationInterface
 * @package Comnect\Console\Interfaces
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
interface ApplicationInterface
{

    /**
     * @param array $array
     * @return mixed
     */
    public function perform(array $array);
}