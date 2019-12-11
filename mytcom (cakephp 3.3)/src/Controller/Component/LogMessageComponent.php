<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Logger;

/**
 * LogMessage component
 */
class LogMessageComponent extends Component
{

    static public $config;

    public function __construct()
    {
        Logger::configure(CONFIG . 'log4php_config.php');
        self::$config = parse_ini_file(CONFIG . 'log_message.ini', true);
    }

    public static function logMessage($logId, $logDetails = array())
    {
        if (!is_array($logDetails)) {
            $logDetails = array($logDetails);
        }

        $messageConfig = self::$config;
        $log = Logger::getLogger(basename(__FILE__));

        if ($logId === null) {
            $level = 'DEBUG';
            $function = 'DBG';
            $monitorLevel = '-';
            $messageId = '-';
            if ($logDetails) {
                $message = implode(", ", $logDetails);
            } else {
                $message = "No parameter found";
            }
        } else {
            if (!isset($messageConfig[$logId])) {
                $logDetails = array($logId);
                $logId = "99999";
            }

            $messageData = $messageConfig[$logId];
            $messageParts = explode('/', $messageData);

            //出力レベル
            $level = $messageParts[0];
            //機能名
            $function = $messageParts[1];
            //監視レベル
            $monitorLevel = $messageParts[2];
            //メッセージID
            $messageId = $messageParts[3];
            //メッセージ
            $message = $messageParts[4];

            $sc = "?";
            if (strpos($message, $sc) !== false) {
                if ($logDetails) {
                    foreach ($logDetails as $v) {
                        $position = strpos($message, $sc);
                        $message = substr_replace($message, $v, $position, 1);
                    }
                }
            }
        }

        $logLevel = "";
        switch ($level) {
            case "FATAL":
                $logLevel = "fatal";
                break;
            case "ERROR":
                $logLevel = "error";
                break;
            case "WARNING":
                $logLevel = "warn";
                break;
            case "INFO":
                $logLevel = "info";
                break;
            case "DEBUG":
                $logLevel = "debug";
                break;
            default:
                $logLevel = "trace";
        }

        $time = date('Y/m/d H:i:s');
        $nopt = "NOPT";
        $sessionId = session_id() ? : "-";
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        preg_match_all('#\((.*?)\)#', $agent, $shortAgent);
        $shortAgent = isset($shortAgent[1][0]) ? $shortAgent[1][0] : "-";

        $logMessage = $time . " " . $nopt . " [" . $sessionId . "]" . " [" . $shortAgent . "]";
        $logMessage .= " (" . $level . "): " . $function . " [" . $monitorLevel . "] ";
        $logMessage .= $messageId . " " . $message;

        $log->$logLevel($logMessage);
    }

}
