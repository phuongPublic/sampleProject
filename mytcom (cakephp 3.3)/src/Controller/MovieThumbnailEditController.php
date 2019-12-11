<?php

namespace App\Controller;

use Exception;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * 
 * MovieThumbnailEdit Controller
 *
 */
class MovieThumbnailEditController extends AppController
{
    public $components = ['MovieThumbnailEdit'];
        
    /**
     * クラス初期化処理用メソッド
     *
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
        if(!$this->request->is('ajax')){
            $userSeq = $this->request->session()->read('UserData.user_seq');
            $movieContentId = $this->request->query('cid');
            $this->set('movieContentId', $movieContentId);
        
            $result = $this->MovieThumbnailEdit->getMovieReproductionTime($userSeq, $movieContentId);
            $reproductionTime = $this->textToSecond($result[reproduction_time]);
            $this->set('reproductionTime', $reproductionTime);
            
            $this->render('index');
            return;
        }
        
        if ($this->request->is('ajax')) {
            $this->autoRender = FALSE;

            $userSeq = $this->request->session()->read('UserData.user_seq');
            $movieContentsId = $this->request->query('movie_contents_id');
            $thumbnailPosition = $this->request->query('thumbnail_position');

            try {
                $reproductionTime = $this->MovieThumbnailEdit->getMovieReproductionTime($userSeq, $movieContentsId);
                
                if(! $this->checkThumbnailPosition($thumbnailPosition, $reproductionTime[reproduction_time] )){
                    echo "サムネイルの編集点は<br>動画の時間以内で設定してください。"; 
                } else {
                    $this->MovieThumbnailEdit->addMovieThumbnailEditRequest($userSeq, $movieContentsId, $thumbnailPosition,$reproductionTime[reproduction_time]);
                    echo "サムネイル画像の設定が完了しました。";
                } 
                
            } catch (Exception $ex) {
                echo "受付に失敗しました。<br>時間を開けて再度登録してください。";
            } 
        } 
    }
    
    /**
     * Check the thumnailPosition within the correct range
     * @param string $thumbnailPosition
     * @param string $reproductionTime
     */
    public function checkThumbnailPosition($thumbnailPosition, $reproductionTime ){
        if($this->textToSecond("00:00.00") <= $this->textToSecond($thumbnailPosition) 
                && $this->textToSecond($thumbnailPosition)  <= $this->textToSecond($reproductionTime)){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * The text type time ("00:00.00") translate to the second time 
     * @param string $textTime
     */
    public function textToSecond($textTime){  
        if (preg_match('/^[\d]{2,}[:][\d]{2}[.][\d]{2}$/', $textTime) ){
            $splitTime = explode(":", $textTime);
        
            $min = $splitTime[0];
            $sec = explode(".", $splitTime[1])[0];
            $milliSec = explode(".", $splitTime[1])[1];
        
            $time = $min*60 + $sec + $milliSec *0.01;
            return $time;
        }elseif (preg_match('/^[\d]{2}[:][\d]{2}[:][\d]{2}[.][\d]{2}$/', $textTime) ){
            $splitTime = explode(":", $textTime);

            $hour = $splitTime[0];
            $min = $splitTime[1];
            $sec = explode(".", $splitTime[2])[0];
            $milliSec = explode(".", $splitTime[2])[1];
            $time = $hour*60*60 + $min*60 + $sec + $milliSec *0.01;
            return $time;
        } else {
            return -1;
        }
    }
}
