<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * MovieDownload Controller
 */
class MovieDownloadController extends AppController
{

    // 使用するComponentの定義
    public $components = ['OpenStatus', 'LogMessage', 'MovieFile', 'Common'];

    public function initialize()
    {
        parent::initialize();
        $this->request->session()->start();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $session = $this->request->session();
        $userData = $session->read("OpenStatusData");
        $userSeq = $userData['UserData'][1][0]['user_seq'];

        //log start download
        if (preg_match("/open/isx", $this->request->env('HTTP_REFERER'))) {
            $this->LogMessage->logMessage("12040", $userSeq);
        } else {
            $this->LogMessage->logMessage("10087", $userSeq);
        }
        $mContentsTbl = TableRegistry::get('MovieContents');
        $result = $mContentsTbl->getSingleMovieData($userSeq, $this->request->query('cid'));
        $movie = $this->MovieFile->getMovieFileInfo($userSeq, $this->request->query('cid'), 'original', 'encode_movie', 'dl');

        if (empty($result)) {
            if (preg_match("/open/isx", $this->request->env('HTTP_REFERER'))) {
                $this->LogMessage->logMessage("12034", $userSeq);
            } else {
                $this->LogMessage->logMessage("10089", $userSeq);
            }
            $this->request->session()->write('message', 'ダウンロード対象のファイルが存在しません。');
            return $this->redirect($this->request->env('HTTP_REFERER'));
        }
        $name = $this->Common->encodeFileName($result[0]['name']);
        $file_uri = $movie['movieFileData'];

        $content = exec('file -bi "' . $file_uri . '"');
        $fileSize = filesize($file_uri);
        $ffidArray = array();
        $ffidArray[0]['movie_id'] = $userData['OpenStatus'][1][0]['open_type'] == 5 ? $this->request->query('cid') : $userData['OpenStatus'][1][0]['target_id'];
        $this->OpenStatus->updateDownloadCount($ffidArray, $userData['OpenStatus'][1][0], $userData['OpenStatus'][1][0]['open_type']);
        // ファイルパスにoriginalを含む場合（ファイル登録した動画ファイル）、拡 張子はmovie_contents.extensionの値を使う。
        // カット編集の動画ファイルの場合、拡張子はmp4を使う。
        $ext = strpos($file_uri, 'original') == false ? 'mp4' : strtolower($result[0]['extension']);
        header('Content-Type: '.$content);
        header('Content-Length: '.$fileSize);
        header('Content-Disposition: attachment; filename="'.$name.'.'.$ext.'"');
        readfile($file_uri);

        //log end download
        if (preg_match("/open/isx", $this->request->env('HTTP_REFERER'))) {
            $this->LogMessage->logMessage("12041", $userSeq);
        } else {
            $this->LogMessage->logMessage("10088", $userSeq);
        }
        if (!@PHPUNIT_RUNNING === 1) {
            exit;
        }
    }
}
