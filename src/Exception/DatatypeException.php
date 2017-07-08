<?php
namespace Affinity4\Datatype\Exception;

/**
 * Class DatatypeException
 *
 * @author Luke Watts <luke@affinity4.ie>
 *
 * @since 0.0.4
 *
 * @package Affinity4\Datatype\Exception
 */
class DatatypeException extends \Exception
{
    /**
     * DatatypeException constructor
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}