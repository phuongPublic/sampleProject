<?php

namespace App\Controller\Component;

use Aura\Intl\Exception;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * UserMst component
 */
class UserMstComponent extends Component
{

    public $components = ['LogMessage'];
    /**
     * method updateUsedFileSize
     *
     * @param string type string $userSeq int $size
     * @param $userSeq
     * @param $size
     * @return boolean
     * @throws Exception
     */
    public function updateUsedFileSize($type, $userSeq, $size)
    {
        $status = false;
        try {
            $userMst = TableRegistry::get('UserMst');
            $user = $userMst->find()
                ->where(['user_seq' => $userSeq])
                ->first();

            if ($type == "album") {
                $user->album_size = $size;
            } elseif ($type == "movie") {
                $user->movie_size = $size;
            } else {
                $user->file_size = $size;
            }
            //transaction
            $userMst->connection()->transactional(function () use ($userMst, $user) {
                $userMst->save($user, ['atomic' => false]);
            });
            $status = true;
        } catch (Exception $e) {
            throw $e;
        }
        return $status;
    }

    /*
    * method checkFileSize
    *
    * @param string $userSeq
    * @param string $type
    *
    * @return int
    */
    public function checkFileSize($userSeq, $type)
    {
        $userTbl = TableRegistry::get('UserMst');
        $user = $userTbl->find()
            ->where(['user_seq' => $userSeq, 'reg_flg'])
            ->first();
        if ($type == "movie") {
            $size = $user->movie_size;
        } elseif ($type == "album") {
            $size = $user->album_size;
        } else {
            $size = $user->file_size;
        }
        return $size;
    }

    /**
     * user_seqより対象ユーザのディスク使用量を取得する
     *
     * @param string $userSeq
     * @return int
     */
    public function getUserDataSize($userSeq)
    {
        $userMst = TableRegistry::get('UserMst');
        $user = $userMst->find()
            ->where(['user_seq' => $userSeq])
            ->first();
        $totalSize = $user->file_size + $user->album_size + $user->movie_size;
        return $totalSize;
    }

    /**
     * @param $userSeq
     * @param $type
     * @return mixed
     */
    public function getFileSize($userSeq, $type)
    {
        if ($type == 'album') {
            $table = TableRegistry::get('PicTbl');
        } else {
            $table = TableRegistry::get('FileTbl');
        }
        $query = $table->find();
        $amount = $query
            ->where(['user_seq' => $userSeq])
            ->select(['sum' => $query->func()->sum('amount')])
            ->hydrate(false)
            ->toArray();
        $dataSize = $amount[0]['sum'];
        return $dataSize;
    }

    /**
     * @param $userSeq
     */
    public function updateFileAlbumSize($userSeq)
    {
        $fileSize = $this->getFileSize($userSeq, 'file');
        $albumSize = $this->getFileSize($userSeq, 'album');
        $userMst = TableRegistry::get('UserMst');
        $user = $userMst->find()
            ->where(['user_seq' => $userSeq])
            ->first();
        $user->file_size = $fileSize;
        $user->album_size = $albumSize;
        //transaction
        $userMst->connection()->transactional(function () use ($userMst, $userSeq, $user) {
            $userMst->save($user, ['atomic' => false]);
        });
    }
}
