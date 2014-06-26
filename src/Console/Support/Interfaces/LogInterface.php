<?php
namespace Comnect\Console\Support\Interfaces;

/**
 * Interface LogInterface
 * @package Comnect\Support\Interfaces
 */
interface LogInterface
{

    /**
     * @param null $path
     * @param null $level
     * @return mixed
     */
    public function log($path = null, $level = null);

}