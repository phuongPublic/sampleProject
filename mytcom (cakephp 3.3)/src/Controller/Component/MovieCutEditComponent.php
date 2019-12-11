<?php

namespace App\Controller\Component;

use App\Model\Entity\MovieContent;
use Cake\Core\Configure;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Exception;

/**
 * MovieCutEdit component
 */
class MovieCutEditComponent extends Component
{
    // 使用するComponentの定義
    public $components = ['LogMessage', 'Movie', 'Common'];

    /**
     * register movie cut request data to DB
     *
     * @param string $userSeq user_seq
     * @param string $movieContentsId movieContentsId
     * @param string $movieEditMode movie edit mode
     * @param string $movieEditStart movie cut edit start point
     * @param string $movieEditEnd movie cut edit end point
     * @return movieContestn true-success, false-DB error
     */
    public function registerCutMovieInfo($userSeq, $movieContentsId, $movieEditMode, $movieEditStart, $movieEditEnd)
    {
        //1.呼び出し
        //2.サーバ名取得
        $serverName =  env('NOPT_ISP');
        
        //4.カット対象動画情報取得
        $cutMovieInfo = $this->getMovieInfo($userSeq, $movieContentsId);
        if ($cutMovieInfo == null){
            $this->LogMessage->logMessage('10016', $userSeq);
            throw new Exception();
        }

        try {
            $movieTbl = TableRegistry::get('MovieContents');
            $newId = $movieTbl->selectNextId($userSeq);

            $movie = $movieTbl->newEntity();

            $movie->user_seq = $cutMovieInfo->user_seq;
            $movie->movie_folder_id = $cutMovieInfo->movie_folder_id;
            $movie->movie_contents_id = $newId;
            $movie->movie_contents_name = $cutMovieInfo->movie_contents_name;
            $movie->name = $cutMovieInfo->name;
            $movie->extension = $cutMovieInfo->extension;
            $movie->amount = 0;
            $movie->movie_contents_url = '';
            $movie->movie_contents_comment = $cutMovieInfo->movie_contents_comment;
            $movie->movie_capture_url = '';
            $movie->reproduction_time = '0:0';
            $movie->resultcode = 1;
            $movie->file_id = null;
            $movie->encode_status = 0;
            $movie->video_size = null;

            $movie->encode_file_id_flv = null;
            $movie->encode_file_id_docomo_300k = null;
            $movie->encode_file_id_docomo_2m_qcif = null;
            $movie->encode_file_id_docomo_2m_qvga = null;
            $movie->encode_file_id_docomo_10m = null;
            $movie->encode_file_id_au = null;
            $movie->encode_file_id_sb = null;
            $movie->encode_file_id_iphone = null;

            $movieTbl->connection()->transactional(function () use ($movieTbl, $movie, $userSeq, $newId) {
                $movieTbl->save($movie, ['atomic' => false]);

                $tempDir = Configure::read('Common.Upload') . Configure::read('Common.BaseMovie') . $userSeq . '/temp/';
                $this->Common->umaskMkdir($tempDir, 0777);
                $movieDir = $tempDir . $this->Common->fixFormatId($newId) . '/encode_movie/pc';
                $this->Common->umaskMkdir($movieDir, 0777);
                $movieDir = $tempDir . $this->Common->fixFormatId($newId) . '/encode_movie/smartphone';
                $this->Common->umaskMkdir($movieDir, 0777);
            });

        } catch (Exception $e) {
            $this->LogMessage->logMessage('10019', $userSeq);
            throw $e;
        }

        $movieEditStart = '00:'.$movieEditStart;
        $movieEditEnd = '00:'.$movieEditEnd;

        //encode data
        $encodeData = [];
        $encodeData['request_source'] = $serverName;
        $encodeData['encode_order'] = 1;
        $encodeData['encode_status'] = 0;
        $encodeData['cancel'] = 0;
        $encodeData['retry_count'] = 0;
        $encodeData['movie_encode_id'] = $newId;
        $encodeData['movie_edit_mode'] = $movieEditMode;
        $encodeData['movie_edit_start'] = $movieEditStart;
        $encodeData['movie_edit_end'] = $movieEditEnd;

        $this->sendCutRequest($userSeq, $movieContentsId, $encodeData);
    }
        
    /**
     * get movie contents data to DB
     *
     * @param  string $userSeq user_seq
     * @param string $movieContentsId movieContentsId
     * @return movieContestn true-success, false-DB error
     */
    public function getMovieInfo($userSeq, $movieContentsId){
        try {
            $movieContents = TableRegistry::get('MovieContents');
            $movie = $movieContents->find()
                ->where(['user_seq' => $userSeq])
                ->andWhere(['movie_contents_id' => $movieContentsId])
                ->first();
            return $movie;
        } catch(Exception $e){
            $this->LogMessage->logMessage('10017', $userSeq);
            throw $e;
        }
    }

    /**
     * method sendCutRequest
     *
     * @param $userSeq
     * @param $movieContentsId
     * @param $encodeData
     * @return boolean
     */
    public function sendCutRequest($userSeq, $movieContentsId, $encodeData)
    {
        try {
            $requestEncodeTbl = TableRegistry::get('EncodeRequest');
            $requestEncode = $requestEncodeTbl->newEntity();

            $requestEncode->request_source = $encodeData['request_source'];
            $requestEncode->movie_contents_id = $movieContentsId;
            $requestEncode->user_seq = $userSeq;
            $requestEncode->encode_order = $encodeData['encode_order'];
            $requestEncode->encode_status = $encodeData['encode_status'];
            $requestEncode->cancel = $encodeData['cancel'];
            $requestEncode->retry_count = $encodeData['retry_count'];
            $requestEncode->movie_encode_id = $encodeData['movie_encode_id'];
            $requestEncode->movie_edit_mode = $encodeData['movie_edit_mode'];
            $requestEncode->movie_edit_start = $encodeData['movie_edit_start'];
            $requestEncode->movie_edit_end = $encodeData['movie_edit_end'];

            //transaction
            $requestEncodeTbl->connection()->transactional(function () use ($requestEncodeTbl, $requestEncode) {
                $requestEncodeTbl->save($requestEncode, ['atomic' => false]);
            });
        } catch (Exception $e) {
            $this->LogMessage->logMessage('10020', $userSeq);
            throw $e;
        }
    }
}
