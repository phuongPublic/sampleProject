<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;

/**
 * MovieFile component
 *
 * @property OpenStatusComponent OpenStatus
 */
class MovieFileComponent extends Component
{

    // 使用するComponentの定義
    public $components = ['LogMessage', 'Common', 'OpenStatus'];

    /**
     *
     * 動画ファイルの削除
     * @param string $userSeq
     * @param string $movieFileId
     * @return boolean
     */
    public function deleteMovieFile($userSeq, $movieFileId)
    {
        //動画の公開ステータスを削除する。
        $this->OpenStatus->deleteOpenStats($userSeq, array($movieFileId), 5, false);

        $result = false;
        $movieDir = $this->rmDirMovFile($userSeq, $movieFileId);
        $tempDir = $this->rmDirMovFile($userSeq, $movieFileId, 'temp');
        if ($movieDir == true || $tempDir == true) {
            $result = true;
        }

        return $result;
    }

    /**
     * @param string $userSeq
     * @param string $movieFileId
     * @param string $dir
     * @return boolean
     */
    public function rmDirMovFile($userSeq, $movieFileId, $dir = 'movie')
    {
        //log start delete movie file
        if ($dir == 'temp') {
            $this->LogMessage->logMessage('10065', array($userSeq, $movieFileId));
        } else {
            $this->LogMessage->logMessage('10062', array($userSeq, $movieFileId));
        }
        $result = true;
        $uploadPath = Configure::read('Common.Upload') . Configure::read('Common.BaseMovie');
        $mFileIdPath = sprintf('%010d', $movieFileId);
        $movieDir = $uploadPath . $userSeq . DS . $dir . DS . $mFileIdPath;
        if (file_exists($movieDir)) {
            $folder = new Folder($movieDir);
            $result = $folder->delete();
            if ($result) {
                //log end delete movie file
                if ($dir == 'temp') {
                    $this->LogMessage->logMessage('10066', array($userSeq, $movieFileId));
                } else {
                    $this->LogMessage->logMessage('10063', array($userSeq, $movieFileId));
                }
            } else {
                //log error when delete movie file
                if ($dir == 'temp') {
                    $this->LogMessage->logMessage('10067', array($userSeq, $movieFileId));
                } else {
                    $this->LogMessage->logMessage('10064', array($userSeq, $movieFileId));
                }
            }
        } else {
            //log when folder and movie file not exist
            $this->LogMessage->logMessage('10050', $userSeq);
            $this->LogMessage->logMessage('10028', $userSeq);
            $result = false;
        }
        return $result;
    }

    /**
     *
     * get movie file or thumbnail
     * @param string $userSeq
     * @param string $movieFileId
     * @param string $deviceType ("pc" or "smartphone" or "original")
     * @param string $movCategory ("thumbnail" or "encode_movie")
     * @param int $dlStt (1 or "dl")
     * @return array
     */
    public function getMovieFileInfo($userSeq, $movieFileId, $deviceType = 'pc', $movCategory = 'thumbnail', $dlStt = 1)
    {
        $result = 1;
        $movieFileInfo = $this->checkMovieContent($userSeq, $movieFileId);
        $mFileIdPath = sprintf('%010d', $movieFileId);
        if ($movieFileInfo == true) {
            $uploadPath = Configure::read('Common.Upload') . Configure::read('Common.BaseMovie');
            $movieDir = $uploadPath . $userSeq . DS . 'movie' . DS . $mFileIdPath . DS . $movCategory . DS;
            //thumbnail case: $fileName = $movCategory = thumbnail
            //movie case: $movCategory = encode_movie $fileName = movie
            $fileName = $movCategory == 'encode_movie' ? 'movie' : $movCategory;
            //full path of file need to check
            $movieInfo = $movieDir . $deviceType . DS . $fileName;

            //in case prepare video for IE directory hasnt any file. $deviceType == 'low_pc' && !file_exists($movieInfo)
            //for download phase (only active when $dlStt != 1) $dlStt != 1 && !file_exists($movieInfo)
            if (($dlStt != 1 || $deviceType == 'low_pc') && !file_exists($movieInfo)) {
                $movieInfoPC = $movieDir . 'pc' . DS . $fileName;
                $result = file_exists($movieInfoPC) ? array('movieFilePath' => $movieDir . $deviceType . DS, 'movieFileData' => $movieInfoPC) : 1;
            //normal case: get thumbnail or movie follow param $movCategory
            } elseif (file_exists($movieInfo)) {
                $result = array('movieFilePath' => $movieDir . $deviceType . DS, 'movieFileData' => $movieInfo);
            }

            //error case: active when file hasnt been detected
            if ($result == 1) {
                $result = false;
            }
        }
        return $result;
    }

    /**
     * check movie content file exits
     * @param $userSeq
     * @param $movieFileId
     * return boolean
     */
    public function checkMovieContent($userSeq, $movieFileId)
    {
        $result = true;
        $movieContents = TableRegistry::get('MovieContents');
        $movieFileInfo = $movieContents->getSingleMovieData($userSeq, $movieFileId);
        if (count($movieFileInfo) == 0) {
            $result = false;
        }
        return $result;
    }

    /**
     * method folderSize
     *
     * @param $path
     * @return int
     */
    public function folderSize($path)
    {
        $totalSize = 0;
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $t) {
                if (is_dir(rtrim($path, '/') . '/' . $t)) {
                    if ($t <> "." && $t <> "..") {
                        $size = $this->foldersize(rtrim($path, '/') . '/' . $t);
                        $totalSize += $size;
                    }
                } else {
                    $size = filesize(rtrim($path, '/') . '/' . $t);
                    $totalSize += $size;
                }
            }
        }
        return $totalSize;
    }
}
