<?php

namespace App\Controller\Component;

use Exception;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

define("THUMBNAIL_EDIT", 2);
define("DEFAULT_ENCODE_STATUS", 0);
define("DEFAULT_CANCEL_FLG", 0);
define("DEFAULT_RETRY_COUNT", 0);

/**
 * MovieThumbnailEdit Component
 *
 * @property \App\Model\Table\MovieContentsTable $getReproductionTime
 */
class MovieThumbnailEditComponent extends Component
{
    // 使用するComponentの定義
    public $components = [
        'LogMessage'
    ];

    /**
     * get reproductionTime of movie
     * @param string $userSeq
     * @param string $movieContentsId
     * @throws Exception
     */
    public function getMovieReproductionTime($userSeq, $movieContentsId)
    {
        $movieContentsTable = TableRegistry::get('movieContents');
        try{
            $reproductionTime = $movieContentsTable->getReproductionTime($userSeq, $movieContentsId);            
        } catch (Exception $e){
            $this->LogMessage->logMessage('10022', $userSeq);
            throw $e;
        }
        
        if(empty($reproductionTime)){
            $this->LogMessage->logMessage('10023', $userSeq);
            throw new Exception();
        }
        
        return $reproductionTime;
    }
    
    /**
     * add movie thumbnail edit request
     * @param string $userSeq
     * @param string $movieContentsId
     * @param time $thumbnailPosition
     * @throws Exception
     */
    public function addMovieThumbnailEditRequest($userSeq, $movieContentsId, $thumbnailPosition, $reproductionTime)
    {
        $serverName = env('NOPT_ISP');
        try {
            $encodeRequestTbl = TableRegistry::get('EncodeRequest');
            $encodeRequest = $encodeRequestTbl->newEntity();

            $encodeRequest->request_source = $serverName;
            $encodeRequest->movie_contents_id = $movieContentsId;
            $encodeRequest->user_seq = $userSeq;
            $encodeRequest->encode_order = THUMBNAIL_EDIT;
            $encodeRequest->encode_status = DEFAULT_ENCODE_STATUS;
            $encodeRequest->cancel = DEFAULT_CANCEL_FLG;
            $encodeRequest->retry_count = DEFAULT_RETRY_COUNT;
            $encodeRequest->movie_encode_id = NULL;
            $encodeRequest->movie_edit_mode = NULL;
            $encodeRequest->movie_edit_start = NULL;
            $encodeRequest->movie_edit_end = NULL;
            $encodeRequest->thumbnail_position = '00:'.$thumbnailPosition;
            $encodeRequest->play_time = $reproductionTime;
            
            $encodeRequestTbl->connection()->transactional(function () use ($encodeRequestTbl, $encodeRequest) {
                $encodeRequestTbl->save($encodeRequest, ['atomic' => false]);
            });
            
        } catch (Exception $e) {
            $this->LogMessage->logMessage('10024', $userSeq);
            throw $e;
        }
        return true;
    } 
}
