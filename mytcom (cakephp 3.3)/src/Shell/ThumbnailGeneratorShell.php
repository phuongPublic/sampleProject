<?php

namespace App\Shell;

use Cake\Console\Shell;

define("WRITE_IMAGE_LOG", true); //true = デバッグON   false = デバッグOFF

require_once(VENDOR . "cpuload-1.0.1" . DS . "class_CPULoad.php");

/**
 * ThumbnailGenerator shell command.
 */
class ThumbnailGeneratorShell extends Shell
{

    public $tasks = ['ThumbnailGenerator'];

    public function execute($uploadPathMulti)
    {
        $uploadPathMulti = preg_split("/,/", $uploadPathMulti);

        foreach ($uploadPathMulti as $uploadPathSingle) {
            $this->ThumbnailGenerator->execute($uploadPathSingle);
        }
    }
}
