<?php
namespace App\Exception;

use Cake\Core\Exception\Exception;

class MissingGetComponentException extends Exception
{
    protected $_messageTemplate = 'error500.ctp';
    protected $code = 500;

    public function __construct($message = '')
    {
        parent::__construct($message, $this->code);
    }
}