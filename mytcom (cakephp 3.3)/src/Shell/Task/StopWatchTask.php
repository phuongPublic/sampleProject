<?php

namespace App\Shell\Task;

use Cake\Console\Shell;
use \CPULoad;

define("SIZE", 3);

/**
 * StopWatch shell task.
 *
 * サムネイル作成の時間とCPUロードを取得し、ImageLog.logに出力するクラス
 */
class StopWatchTask extends Shell
{

    private $timeStart;

    /*     * ************************************************************************
     * startStopWatch 処理開始時刻取得処理
     *
     * @return void
     * ************************************************************************ */

    public function startStopWatch()
    {
        $this->timeStart = $this->getNowWatch();
    }

    /*     * ************************************************************************
     * stopStopWatch 処理終了時刻取得処理
     *
     * CPU時間の取得と、ログメッセージ生成及びメッセージのログへの書き込みを行う
     *
     * @param string ログに表示するための処理名
     * @param string 作成先ファイル名
     * @param string 作成元ファイル名
     * @param array 作成先ファイル情報
     * @param array 作成元ファイル情報
     *
     * @return void
     * ************************************************************************ */

    public function stopStopWatch($ProcNameForLog, $dstImageName, $srcImageName, $dstImageInfo, $srcImageInfo)
    {
        // class_CPULoad.phpは、'/proc/stat'に対してfopenしようとするので、Linux環境でのみ実行させる
        if (!preg_match("/WIN/", PHP_OS)) {
            $cpuloadInfo = $this->getCPULoadInfo();
        } else {
            $cpuloadInfo = "CPU load data available just in Linux environment";
        }
        $timeElapsed = round($this->getNowWatch() - $this->timeStart, 4);
        $msg = $this->makeLogMsg($ProcNameForLog, $dstImageName, $srcImageName, $dstImageInfo, $srcImageInfo, $cpuloadInfo, $timeElapsed);
        $this->writeMsgToLog($msg);
    }

    /*     * ************************************************************************
     * getNowWatch 現在時刻取得処理
     *
     * @return float:マイクロ秒を含むエポック秒
     * ************************************************************************ */

    private function getNowWatch()
    {
        list($msec, $sec) = explode(" ", microtime());
        return ((float) $msec + (float) $sec);
    }

    /*     * ************************************************************************
     * getCPULoadInfo CPU時間取得処理
     *
     * @return string:CPU時間
     * ************************************************************************ */

    private function getCPULoadInfo()
    {
        $cpuLoadIns = new CPULoad();
        $cpuLoadIns->get_load();
        return $cpuLoadIns->print_log();
    }

    /*     * ************************************************************************
     * makeLogMsg ログメッセージ作成処理
     *
     * @param string ログに表示するための処理名
     * @param string 作成先ファイル名
     * @param string 作成元ファイル名
     * @param array 作成先ファイル情報
     * @param array 作成元ファイル情報
     * @param string CPU時間
     * @param float マイクロ秒を含むエポック秒
     *
     * @return string ログメッセージ
     * ************************************************************************ */

    private function makeLogMsg($ProcNameForLog, $dstImageName, $srcImageName, $dstImageInfo, $srcImageInfo, $cpuloadInfo, $timeElapsed)
    {
        $msg = "";
        $msg .= date("Y-m-d h:i") . "  Target:" . $ProcNameForLog . "\n";
        $msg .= $cpuloadInfo . "\n";
        $msg .= "Process Time: " . $timeElapsed . "\n";
        $msg .= "Image Convert from: \n";
        $msg .= "　" . $srcImageName . "\n";
        $msg .= "(" . $srcImageInfo[SIZE] . " mime: " . $srcImageInfo['mime'] . ")\n";
        $msg .= "Image Convert to: \n";
        $msg .= "　" . $dstImageName . "\n";
        $msg .= "(" . $dstImageInfo[SIZE] . " mime: " . $dstImageInfo['mime'] . ")\n\n";
        $msg .= "-------------------------------------------------------------------------------------------\n";
        return $msg;
    }

    /*     * ************************************************************************
     * writeMsgToLog ログメッセージ作成処理
     *
     * @param string ログメッセージ
     *
     * @return void
     * ************************************************************************ */

    private function writeMsgToLog($msg)
    {
        $fp = fopen(LOGS . "ImageLog.log", "a");
        //ファイルのロック
        flock($fp, LOCK_EX);
        //エラーの書き込み
        fwrite($fp, $msg);
        //ファイルの開放
        flock($fp, LOCK_UN);
        fclose($fp);
    }

}
