<?php

namespace App\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;

/**
 * MovieDetail Controller
 *
 * @property \App\Model\Table\MovieDetailTable $MovieDetail
 */
class MoviePlayController extends AppController
{

    // 使用するComponentの定義
    public $components = ['MovieFile', 'ActionClass'];

    /**
     * クラス初期化処理用メソッド
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $openDataStt = $this->request->session()->check('OpenStatusData');
        if ($openDataStt) {
            $userData = $this->request->session()->read("OpenStatusData");
            $userSeq = $userData['UserData'][1][0]['user_seq'];
            $openIdSession = $this->request->session()->read('openId');
            $openIdGet = $this->request->query('id');
            $url = $this->ActionClass->openUserAuth($this->deviceName[$this->deviceTypeId], $openDataStt, $openIdSession, $openIdGet);
            if ($url != "" && isset($openIdGet)) {
                return $this->redirect($url);
            }
        } else {
            $userSeq = $this->userInfo['user_seq'];
        }

        // getパラメーターにumovkeyの存在したら
        // 暗号の復号化処理を行い　＆　ユーザー確認を行い
        // ムービー送信処理へ引き渡す。
        // NGの場合はエラーとする。
        if (isset($_GET['umovkey'])) {
            $umovkey = $this->iphone5decrypt($_GET['umovkey']);
            //uaerSeqの存在確認を行う。
            $userMst = TableRegistry::get('UserMst');
            $result = $userMst->getUserInformation($umovkey);
            //uaerSeqが存在しない場合はエラーとする。
            if (!$result) {
                return false;
            }
            $userSeq = $result[0]['user_seq'];
        }

        $movieFileId = $this->request->query('cid');
        $deviceType = $this->deviceTypeId == 1 ? 'pc' : 'smartphone';
        //get User-Agent
        $userAgent = $this->request->header('User-Agent');
        if (strpos($userAgent, Configure::read('Common.UserAgent.OS.Windows7')) != false && strpos($userAgent, Configure::read('Common.UserAgent.Browser.IE11')) != false) {
            $deviceType = 'low_pc';
        }
        $moviePath = $this->MovieFile->getMovieFileInfo($userSeq, $movieFileId, $deviceType, 'encode_movie');
        $file = $moviePath['movieFileData'];
        if (file_exists($file)) {
            $fp = @fopen($file, 'rb');
            $size   = filesize($file); // File size
            $length = $size;           // Content length
            $start  = 0;               // Start byte
            $end    = $size - 1;       // End byte
            header('Content-type: video/mp4');
            header("Accept-Ranges: 0-$length");
            if (isset($_SERVER['HTTP_RANGE'])) {
                $c_start = $start;
                $c_end   = $end;
                list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
                if (strpos($range, ',') !== false) {
                    header('HTTP/1.1 416 Requested Range Not Satisfiable');
                    header("Content-Range: bytes $start-$end/$size");
                    exit;
                }
                if ($range == '-') {
                    $c_start = $size - substr($range, 1);
                } else {
                    $range  = explode('-', $range);
                    $c_start = $range[0];
                    $c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
                }
                $c_end = ($c_end > $end) ? $end : $c_end;
                if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                    header('HTTP/1.1 416 Requested Range Not Satisfiable');
                    header("Content-Range: bytes $start-$end/$size");
                    exit;
                }
                $start  = $c_start;
                $end    = $c_end;
                $length = $end - $start + 1;
                fseek($fp, $start);
                header('HTTP/1.1 206 Partial Content');
            }
            header("Content-Range: bytes $start-$end/$size");
            header("Content-Length: ".$length);
            $buffer = 1024 * 8;
            while (!feof($fp) && ($p = ftell($fp)) <= $end) {
                if ($p + $buffer > $end) {
                    $buffer = $end - $p + 1;
                }
                set_time_limit(0);
                echo fread($fp, $buffer);
                flush();
            }
            fclose($fp);
            exit();
        } else {
            header('HTTP/1.1 404 Not Found');
            exit;
        }
    }

    /**
     * iPhone5対策：Cookieが空となるためURLにGETパラメータで設定
     * 暗号化で使用したキャッシュ値をGETより取得し復号化。
     *
     * @param string $ck
     * @param string $umovkey
     * @return string $userSeq_de
     * */

    private function iphone5decrypt($umovkey)
    {
        $key = Configure::read('Common.SiteSetting.KEY');
        $salt = Configure::read('Common.SiteSetting.SALT');
        $userSeq = Security::decrypt($this->base64_decode_urlsafe($umovkey),$key, $salt);
        return $userSeq;
    }

    function base64_decode_urlsafe($s){
        $s = (str_replace( array('_','-','.'), array('+','=','/'), $s));
        return(base64_decode($s));
    }

}
