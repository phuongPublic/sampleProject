<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * MovieThumbnail Controller
 *
 * @property \App\Model\Table\MovieThumbnailTable $MovieThumbnail
 */
class MovieThumbnailController extends AppController
{

    // 使用するComponentの定義
    public $components = ['LogMessage', 'MovieFile'];

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        if ($this->request->session()->check("OpenStatusData")) {
            $userData = $this->request->session()->read("OpenStatusData");
            $userSeq = $userData['UserData'][1][0]['user_seq'];
        } else {
            $userSeq = $this->userInfo['user_seq'];
        }
        $cid = $this->request->query('cid');
        $imageDir = WWW_ROOT_CONTENTS . 'images' . DS;
        $contentType = 'jpeg';
        if ($this->deviceTypeId == 1) {
            $deviceType = 'pc';
        } else {
            $deviceType = 'smartphone';
        }

        $targetPicBusy = $imageDir . 'movie_busy100x70.jpg';
        $targetPicConvertFail = $imageDir . 'movie_convert_fail100x75.jpg';

        $movieTbl = TableRegistry::get('MovieContents');
        $movie = $movieTbl->getSingleMovieData($userSeq, $cid);

        if (!empty($movie)) {
            $encodeStatus = $movie[0]['encode_status'];
            if ($encodeStatus == 0 || $encodeStatus == 1) {
                $targetPic = $targetPicBusy;
            } elseif ($encodeStatus == 2) {
                $movieFile = $this->MovieFile->getMovieFileInfo($userSeq, $cid, $deviceType, 'thumbnail');
                if (isset($movieFile['movieFileData'])) {
                    $targetPic = $movieFile['movieFileData'];
                } else {
                    $targetPic = $imageDir . 'no_image_p480x360.jpg';
                }
            } elseif ($encodeStatus == 3) {
                $targetPic = $targetPicConvertFail;
            }
        } else {
            $targetPic = $imageDir . 'no_image_p480x360.jpg';
        }

        //response header
        header('Content-Length: ' . (string)(filesize($targetPic)));
        header('Content-Type: image/' . $contentType);
        readfile($targetPic);
        exit;
    }

}
