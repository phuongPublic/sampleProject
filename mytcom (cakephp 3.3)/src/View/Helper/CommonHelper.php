<?php
/**
 * システム共通コンポーネント
 *
 * @copyright (c) 2016, TOKAI Communications Corporation All rights reserved.
 */

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

/**
 * システム共通コンポーネントクラス
 *
 */
class CommonHelper extends Helper
{
    /**
     *
     * @return type
     */
    public function getAspSetting()
    {
        return Configure::read('Common.AspSettingFlag');
    }

    /**
     *
     * @return type
     */
    public function getIsp()
    {
        return $_SERVER['NOPT_ISP'];
    }

    public function mbwordwrap($string, $length = 80, $break = "<br />", $cut = "UTF-8")
    {
        $html = "";
        $strings = explode("\n", $string);
        foreach ($strings as $string) {
            while ($length < mb_strlen($string, $cut)) {
                $html .= mb_substr($string, 0, $length, $cut) . $break;
                $string = mb_substr($string, $length);
            }
            $html .=$string . "\n";
        }
        return $html;
    }

    /**
     * Return limited string
     * @param string
     * @param int
     * @return string
     */
    public function limitWord($string, $length = 21)
    {
        $newString = $string;
        if (strlen($newString) > $length) {
            $newString = mb_strcut($newString, 0, $length) . "...";
            return $newString;
        }
//        if ($this->isJapanese($string)) {
//            $length = 7;
//        }
//        if (mb_strlen($newString, "UTF-8") > $length) {
//            $newString = mb_substr($string, 0, $length, "UTF-8") . '...';
//        }
        return $newString;
    }

    /**
     * Return length string
     * @param string
     * @return int
     */
    public function getStrLength($string)
    {
        $length = mb_strlen($string, "UTF-8");
        if ($this->isJapanese($string)) {
            $length = round($length/3);
        }
        return $length;
    }

    /**
     * convert to Byte
     * Function base on Smarty function (Ethna)
     * @param int $int
     * @param boolean $flg
     * @return string
     */
    public function modifierByte($int, $flg=true)
    {
        if (strtolower($this->getIsp()) == 'tnc') {
            return $this->getByteTnc($int, $flg);
        } else {
            return $this->getByteDefault($int, $flg);
        }
    }

    /**
     * convert to KB
     * Function base on Smarty function (Ethna)
     * @param int $num
     * @return string
     */
    public function modifierKbyte($num)
    {
        if (strtolower($this->getIsp()) == 'tnc') {
            $BYTE_BASE = 1000;
        }else{
            $BYTE_BASE = 1024;
        }
        return round(ceil($num/$BYTE_BASE))."KB";
    }

    /**
     * convert to MB
     * Function base on Smarty function (Ethna)
     * @param int $num
     * @return string
     */
    public function modifierMbyte($num)
    {
        if (strtolower($this->getIsp()) == 'tnc') {
            $kNum = round(ceil($num/10000));
            $mNum = $kNum/100;
        }else{
            $mNum = round($num/pow(1024,2),2);
        }
        return $mNum."MB";
    }

    // Ethna |nl2br|escape:"html"|regex_replace:"/[\r\t\n]/":""
    public function htmlEscape($html)
    {
        $html = quotemeta($html);
        $html = htmlentities($html, ENT_QUOTES);
        $html = str_replace(array("\r\n","\n","\r"), ' ', $html);
        return $html;
    }

    public function htmlEscapeNotQuote($html)
    {
        $html = htmlentities($html, ENT_QUOTES);
        $html = str_replace(array("\r\n","\n","\r"), ' ', $html);
        return $html;
    }

    // Ethna |date_format
    public function date_format($string, $format = "%b %e, %Y", $default_date = null)
    {
        if (substr(PHP_OS, 0, 3) == 'WIN') {
            $_win_from = array('%e', '%T', '%D');
            $_win_to = array('%#d', '%H:%M:%S', '%m/%d/%y');
            $format = str_replace($_win_from, $_win_to, $format);
        }
        if ($string != '') {
            return strftime($format, $this->smarty_make_timestamp($string));
        } elseif (isset($default_date) && $default_date != '') {
            return strftime($format, $this->smarty_make_timestamp($default_date));
        } else {
            return;
        }
    }

    /**
     * Return device type
     * @return string
     */
    public function getDeviceType()
    {
        return $this->request->session()->read("deviceTypeId");
    }

    public function getSiteSetting()
    {
        return Configure::read('Common.SiteSetting');
    }


    /**
     * Smarty function Ethna for default isp
     * @param int $int
     * @param boolean $flg
     * @return string
     */
    private function getByteDefault($int, $flg=true) {
        if (preg_match("/^[\d]*?$/isx",$int)) {
            $keta  = strlen($int);
            if ($int == "" || $int == 0) {
                $size = 0;
                $type =    "KB";
            } elseif(($int/1024) < 1) {
                $size = $int;
                $type =    "B";
            } elseif (($int/pow(1024,2)) < 1) {
                $size = $flg ? ceil($int/1024) : round($int/1024,2);
                $type =    "KB";
            } elseif (($int/pow(1024,3)) < 1) {
                $size = $flg ? ceil($int/pow(1024,2)) : round($int/pow(1024,2),2);
                $type =    "MB";
            } else {
                $size = $flg ? round($int/pow(1024,3),2) : round($int/pow(1024,3),4);
                $type =    "GB";
            }
        }
        return "$size$type";
    }

    /**
     * Smarty function Ethna for default tnc isp
     * @param int $int
     * @param boolean $flg
     * @return string
     */
    private function getByteTnc($int, $flg=true) {
        if(preg_match("/^[\d]*?$/isx",$int)){
            $keta  = strlen($int);
            if($int == "" || $int == 0){
                $size = $int;
                $type =    "KB";
            }elseif($keta < 4){
                $size = $int;
                $type =    "B";
            }elseif($keta < 7){
                $size = ($flg)?ceil($int/1000) : round($int/1000,2);
                $type =    "KB";
            }elseif($keta < 10){
                $size = ($flg)?ceil($int/1000000) : round($int/1000000,2);
                //$size = ceil($int/1000000);
                $type =    "MB";
            }elseif($keta < 13){
                //$size = ($flg)?ceil($int/1000000000) : round($int/1000000000,2);
                $size = ($flg)?ceil($int/10000000) : round($int/10000000,2);
                $size = $size / 100;
                //$size = ceil($int/1000000000);
                $type =    "GB";
            }
        }
        return "$size$type";
    }

    private function smarty_make_timestamp($string)
    {
        if (empty($string)) {
            // use "now":
            $time = time();
        } elseif (preg_match('/^\d{14}$/', $string)) {
            // it is mysql timestamp format of YYYYMMDDHHMMSS?
            $time = mktime(substr($string, 8, 2), substr($string, 10, 2), substr($string, 12, 2), substr($string, 4, 2), substr($string, 6, 2), substr($string, 0, 4));
        } elseif (is_numeric($string)) {
            // it is a numeric string, we handle it as timestamp
            $time = (int) $string;
        } else {
            // strtotime should handle it
            $time = strtotime($string);
            if ($time == -1 || $time === false) {
                // strtotime() was not able to parse $string, use "now":
                $time = time();
            }
        }
        return $time;
    }

    private function isKanji($str) {
        return preg_match('/[\x{4E00}-\x{9FBF}]/u', $str) > 0;
    }

    private function isHiragana($str) {
        return preg_match('/[\x{3040}-\x{309F}]/u', $str) > 0;
    }

    private function isKatakana($str) {
        return preg_match('/[\x{30A0}-\x{30FF}]/u', $str) > 0;
    }

    private function isJapanese($str) {
        return $this->isKanji($str) || $this->isHiragana($str) || $this->isKatakana($str);
    }

    /**
     * 動画の再生時間からカンマ秒を取り除く。
     * @param String $reproductionTime 動画の再生時間。
     * @return String 正規表現にマッチした場合は、たとえば11:22:33.44の形から11:22:33を返却する。正規表現にマッチしない場合は、@paramのまま返却する。
     */
    public function cutCommaSeconds($reproductionTime)
    {
        return preg_replace("/(\d{2}:\d{2}:\d{2})\.\d{2}$/", "$1", $reproductionTime);
    }
}
