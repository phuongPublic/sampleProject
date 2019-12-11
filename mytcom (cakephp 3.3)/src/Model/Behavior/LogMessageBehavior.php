<?php

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use App\Controller\Component\LogMessageComponent;

/**
 * LogMessage behavior
 */
class LogMessageBehavior extends Behavior
{

    private $log;

    /**
     * Initialize method
     *
     * @return void
     */
    public function __construct()
    {
        $this->log = new LogMessageComponent();
    }

    /**
     * logMessage method
     *
     * @param str   $logId      message ID
     * @param array $logDetails placeholder of message
     * @return void
     */
    public function logMessage($logId, $logDetails = array())
    {
        $this->log->logMessage($logId, $logDetails);
    }

}
