<?php

namespace App\Controller;

use Exception;
use App\Controller\AppController;


/**
 * 
 * MovieCutEditController
 *
 */
class MovieCutEditController extends AppController
{
    public $components = ['MovieCutEdit','MovieThumbnailEdit'];

    const betweenStartEnd = 0;
    const ZeroStartAndEndPlayTime = 1;

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
        if($this->request->is('ajax')){
            $this->autoRender = FALSE;

            $userSeq = $this->request->session()->read('UserData.user_seq');
            $movieContentsId = $this->request->query('movie_contents_id');
            $movieEditMode = $this->request->query('movie_edit_mode');
            $movieEditStart = $this->textToSecond($this->request->query('movie_edit_start'));
            $movieEditEnd = $this->textToSecond($this->request->query('movie_edit_end'));
            $reproductionTime = 0;

            try {
                $result = $this->MovieThumbnailEdit->getMovieReproductionTime($userSeq, $movieContentsId);
                $reproductionTime = $this->textToSecond($result[reproduction_time]);
            } catch (Exception $ex) {
                echo "受付に失敗しました。<br>時間を開けて再度登録してください。";
                return;
            }

            $playTime = 0;
            if($movieEditMode == self::betweenStartEnd){
                $playTime = $movieEditEnd - $movieEditStart;
            } else if($movieEditMode == self::ZeroStartAndEndPlayTime) {
                $playTime = $reproductionTime - ($movieEditEnd - $movieEditStart);
            }

            if(!$this->validateMovieEditMode($movieEditMode)){
                echo "編集モードは<br>「前後をカットする」または「途中をカットする」<br>を設定して下さい。";
                return;
            }
            if(!$this->validateMovieEditStartAndEnd($movieEditStart, $movieEditEnd ,$reproductionTime)){
                echo "カット編集点は<br>動画の時間以内で設定して下さい。"; 
                return;
            }
            if($playTime < 3){
                echo "合計時間は3秒以上設定して下さい。";
                return;
            }

            try{
                $this->MovieCutEdit->registerCutMovieInfo($userSeq, $movieContentsId, $movieEditMode, $this->request->query('movie_edit_start'), $this->request->query('movie_edit_end'));
                echo "受付が完了しました。";
            } catch (Exception $ex){
                echo "受付に失敗しました。<br>時間を開けて再度登録してください。";
            }
        }
    }
    
    /**
     * Check the movieEditMode
     * @param string $movieEditMode
     */
    public function validateMovieEditMode($movieEditMode)
    {
        if($movieEditMode == "0" || $movieEditMode == "1"){
            return true;
        }
        return false;
    }
    
    /**
     * Check the movieEditStart and movieEditEnd
     * @param string $movieEditStart
     * @param string $movieEditEnd
     * @param string $playTime
     */
    public function validateMovieEditStartAndEnd($movieEditStart, $movieEditEnd, $playTime)
    {
        if($movieEditStart < 0){
            return false;
        }
        if($movieEditEnd < 0){
            return false;
        }
        if($movieEditStart > $playTime){
            return false;
        }
        if($movieEditEnd > $playTime){
            return false;
        }
        if($movieEditStart > $movieEditEnd){
            return false;
        }
        return true;
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
