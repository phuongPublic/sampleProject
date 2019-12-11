<?php

namespace App\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * MovieDetail Controller
 *
 * @property \App\Model\Table\MovieDetailTable $MovieDetail
 */
class MovieDetailController extends AppController
{

    // 使用するComponentの定義
    public $components = ['LogMessage', 'MovieFolder', 'Movie', 'MovieFile', 'Common'];

    /**
     * クラス初期化処理用メソッド
     */
    public function initialize()
    {
        parent::initialize();

        // アルバムを選択状態とする。
        $this->set('menu_now_flg', 6);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $agent = $this->request->header('User-Agent');
        $userSeq = $this->userInfo['user_seq'];
        // message session
        $this->set('message', $this->request->session()->consume('message'));
        $movieContentId = $this->request->query('cid');
        // initial total movie variable
        $totalMovie = 0;
        $loopStart = 0;
        $movContents = TableRegistry::get('MovieContents');
        $openStatusTbl = TableRegistry::get('OpenStatus');
        $movieFolderTbl = TableRegistry::get('MovieFolder');
        $movieContent = $movContents->getSingleMovieData($userSeq, $movieContentId);
        $downloadButton = $this->Movie->downloadAble($userSeq, $movieContentId);
        $this->set('downloadAble', $downloadButton);
        // download movie
        if (!empty($this->request->data['movieId'])) {
            if ($this->Movie->downloadAble($userSeq, $this->request->data['movieId'])) {
                $movieContent = $movContents->getSingleMovieData($userSeq, $this->request->data['movieId']);
                $movie = $this->MovieFile->getMovieFileInfo($userSeq, $this->request->data['movieId'], 'original', 'encode_movie', 'dl');
                if (!empty($movieContent)) {
                    $file = $movie['movieFileData'];
                    //log start download
                    $this->LogMessage->logMessage("10087", $this->userInfo['user_seq']);
                    //Send file as response
                    if (file_exists($file)) {
                        $content = exec('file -bi "' . $file . '"');
                        $name = $this->Common->encodeFileName($movieContent[0]['name']);
                        $fileSize = filesize($file);
                        // ファイルパスにoriginalを含む場合（ファイル登録した動画ファイル）、拡 張子はmovie_contents.extensionの値を使う。
                        // カット編集の動画ファイルの場合、拡張子はmp4を使う。
                        $ext = strpos($file, 'original') == false ? 'mp4' : strtolower($movieContent[0]['extension']);
                        header('Content-Type: '.$content);
                        header('Content-Length: '.$fileSize);
                        header('Content-Disposition: attachment; filename="'.$name.'.'.$ext.'"');
                        readfile($file);

                        //log end download
                        $this->LogMessage->logMessage("10088", $userSeq);
                        exit;
                    }
                }
            }
        }
        if (!empty($movieContent)) {
            $this->set('data', $movieContent[0]);
            $movieFolderId = $movieContent[0]['movie_folder_id'];
            // get movie FolderName
            $movieFolder = $movieFolderTbl->getFolderNameById($userSeq, $movieFolderId);
            if ($movieFolder) {
                $movieFolderName = $movieFolder['movie_folder_name'];
            } else {
                $movieFolderName = '';
            }
            $targetId = $movieContentId;
            $openStatus = 0;
            $result = $openStatusTbl->getAllOrderByOpenStatus($userSeq, $movieFolderId, 4);
            if (count($result) <= 0) {
                $result = $openStatusTbl->getAllOrderByOpenStatus($userSeq, $targetId, 5);
                $openStatus = count($result) > 0 ? 1 : 0;
            } else {
                $openStatus = 1;
            }
            $slide = $movContents->getContentsByMovie($userSeq, $movieFolderId, 'DESC');
            $movieFolderStatus = $openStatusTbl->getAllOrderByOpenStatus($userSeq, $movieFolderId, 4);
            for ($i = 0; $i < count($slide); $i ++) {
                $targetId = $slide[$i]['movie_contents_id'];
                $thisStatus = $openStatusTbl->getAllOrderByOpenStatus($userSeq, $targetId, 5);
                if (count($movieFolderStatus) > 0) {
                    $slide[$i]['open_status'] = 1;
                } elseif (count($thisStatus) > 0) {
                    $slide[$i]['open_status'] = 1;
                } else {
                    $slide[$i]['open_status'] = 0;
                }
                $slide[$i]['downloadAble'] = 0;
                $downloadButton = $this->Movie->downloadAble($userSeq, $targetId);
                if ($downloadButton) {
                    $slide[$i]['downloadAble'] = 1;
                }
                if ($movieContentId == $targetId) {
                    $loopStart = $i;
                }
            }
            $totalMovie = count($slide);
        } else {
            $this->request->session()->write('message', '動画またはサムネイルが存在しません。');
            $this->LogMessage->logMessage('10084', $this->userInfo['user_seq']);
            return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
        }
        $app = array("video_width" => 600, "video_height" => 400,"movie_folder_name" => $movieFolderName, "prev_page" => "");
        $this->set('app', $app);
        $this->set('mid', $movieFolderId);
        $this->set('cid', $movieContentId);
        $total = $this->MovieFolder->getAllMovieFolderData($userSeq);
        $this->set('movieFolderList', $total);
        $this->set('open_status', $openStatus);
        $folderNameList = $movieFolderTbl->getMovieFolderName($this->userInfo['user_seq']);
        $this->set('folderNameList', $folderNameList);
        $this->set('LoopStart', $loopStart);
        $this->set("autoStart", $this->request->query('autoStart'));
        $this->set('total', $totalMovie);
        $this->set('slide', $slide);
        $this->set('umovkey', $this->Common->iphone5encrypt($userSeq));
        $folder2 = array();
        foreach ($total as $key => $value) {
            $folder2[] = $value['movie_folder_name'];
        }
        $this->set("folder2", $folder2);

        if ($this->deviceTypeId != 1) {
            //back button smart phone
            if (preg_match("/preview/isx", $this->request->env('HTTP_REFERER'))) {
                $this->request->session()->write("PREV_URL", $this->request->env('HTTP_REFERER'));
            }
            $this->set("preUrl", $this->request->session()->read("PREV_URL"));
            $this->set("keyword64", $this->request->session()->read("keyword64"));
        }
        $messageUnsupport = Configure::read('Movie.UnsupporMes');
        $this->set('messageUnsupport', $messageUnsupport);
    }


}
