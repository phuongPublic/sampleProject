<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use App\Validation\NoptBaseValidator;
use Exception;

/**
 * MovieFolder component
 *
 * @property OpenStatusComponent OpenStatus
 */
class MovieFolderComponent extends Component
{

    // 使用するComponentの定義
    public $components = ['Movie', 'LogMessage', 'UserMst', 'Common','OpenStatus'];

    /**
     * user_seqより対象ユーザのフォルダ情報を取得する
     *
     * @param string $userSeq
     * @param string $sort
     * @return int
     */
    public function getFolderInfo($userSeq, $sort)
    {
        // 他Model情報取得
        $movieFolder = TableRegistry::get('MovieFolder');
        $movieContents = TableRegistry::get('MovieContents');

        //ソート順を設定
        if ($sort == 'new') {
            $sortStr = 'DESC';
        } else {
            $sortStr = 'ASC';
        }

        // フォルダ一覧取得
        $folderList = $movieFolder->find()
                ->order(['movie_folder_id' => $sortStr])
                ->where(['user_seq' => $userSeq])
                ->hydrate(false)
                ->toArray();
        // 各フォルダに対する情報を取得
        for ($i = 0; $i < count($folderList); $i++) {
            // ファイル数取得
            $folderList[$i]['movie_count'] = $movieContents->find()
                    ->where(['user_seq' => $userSeq, 'movie_folder_id' => $folderList[$i]['movie_folder_id'], 'encode_status !=' => 9])
                    ->count();
        }
        return $folderList;
    }

    /**
     * method insertFolderData
     *
     * @param $userSeq
     * @param string $movieFolderName
     * @param string $movieFolderComment
     * @return bool
     */
    public function insertFolderData($userSeq, $newId, $movieFolderName = '初期フォルダ', $movieFolderComment = '初期フォルダです。編集で名前・コメントを変更することが出来ます。')
    {
        $result = false;
        if(is_array($movieFolderName)) {
            $movieFolderName = " ";
        }
        if(is_array($movieFolderComment)) {
            $movieFolderComment = "";
        }
        try {
            $mFolderTbl = TableRegistry::get('MovieFolder');
            $mFolder = $mFolderTbl->newEntity();
            $mFolder->movie_folder_name = $movieFolderName;
            $mFolder->movie_folder_id = $newId;
            $mFolder->movie_folder_comment = $movieFolderComment;
            $mFolder->user_seq = $userSeq;
            //transaction
            $mFolderTbl->connection()->transactional(function () use ($mFolderTbl, $mFolder) {
                $mFolderTbl->save($mFolder, ['atomic' => false]);
            });
            $result = true;
        } catch (Exception $e) {
            $this->LogMessage->logMessage('10048', $userSeq, "");
            $result = false;
        }
        return $result;
    }

    /**
     * method confirmExistFolder
     *
     * @param $userSeq
     * @param $id
     * @return bool|mixed
     */
    public function confirmExistFolder($userSeq, $id)
    {
        $movieFolderTbl = TableRegistry::get('MovieFolder');
        try {
            $folder = $movieFolderTbl->find()
                    ->where(['user_seq' => $userSeq])
                    ->andWhere(['movie_folder_id' => $id])
                    ->first();
            if (empty($folder)) {
                return false;
            } else {
                return $folder;
            }
        } catch (Exception $e) {
            $this->LogMessage->logMessage("10048", $userSeq, "");
        }
    }

    /**
     * method updateMovieFolderData
     *
     * @param int $id
     * @param string $userSeq
     * @param string $folderName
     * @param string $folderComment
     * @return int
     */
    public function updateMovieFolderData($id, $userSeq, $folderName, $folderComment)
    {
        $result = 1;
        if(is_array($folderName)) {
            $folderName = " ";
        }
        if(is_array($folderComment)) {
            $folderComment = "";
        }
        try {
            $movieFolderTbl = TableRegistry::get('MovieFolder');
            $movieFolder = $this->confirmExistFolder($userSeq, $id);
            if (!$movieFolder) {
                $result = 0;
            } else {
                $movieFolder->movie_folder_name = $folderName;
                $movieFolder->movie_folder_comment = $folderComment;
                $movieFolderTbl->connection()->transactional(function () use ($movieFolderTbl, $movieFolder) {
                    $movieFolderTbl->save($movieFolder, ['atomic' => false]);
                });
            }
        } catch (Exception $e) {
            $result = -1;
        }
        return $result;
    }

    /**
     * delete Movie Folder
     *
     * @param string $userSeq
     * @param string $mFolderId
     * @return int
     */
    public function deleteMovieFolderData($userSeq, $mFolderId)
    {
        $result = 1;
        if(is_array($mFolderId)) {
            $mFolderId = "";
        }
        try {

            //動画フォルダの公開ステータスを削除する。
            $this->OpenStatus->deleteOpenStats($userSeq, $mFolderId, $openType=4, $folderFlg=false);

            $mFolderTbl = TableRegistry::get('MovieFolder');
            $mFolderList = $mFolderTbl->getSingleMovieFolderData($userSeq, $mFolderId);
            if (empty($mFolderList)) {
                $result = 0;
                return $result;
            }
            $mContentsTbl = TableRegistry::get('MovieContents');
            $movieList = $mContentsTbl->getContentsByMovie($userSeq, $mFolderId);
            //transaction
            $mFolderTbl->connection()->transactional(function () use ($userSeq, $mFolderId, $movieList, $mFolderTbl) {
                //delete album on database
                $mFolderTbl->deleteAll([
                    'user_seq' => $userSeq,
                    'movie_folder_id' => $mFolderId
                ]);
                if (!empty($movieList)) {
                    //delete picture on database
                    foreach ($movieList as $movieUnit) {
                        $this->Movie->deleteMovieData($userSeq, $movieUnit['movie_contents_id']);
                    }
                }
            });
        } catch (Exception $e) {
            $result = -1;
        }
        return $result;
    }

    /**
     * method getMovieFolderInfoList
     *
     * @param $userSeq
     * @return array
     * @throws Exception
     */
    public function getMovieFolderInfoList($userSeq)
    {
        $mFolderTbl = TableRegistry::get('MovieFolder');
        $mContentsTbl = TableRegistry::get('MovieContents');
        try {
            $mFolderList = $mFolderTbl->find()
                    ->where(['user_seq' => $userSeq])
                    ->hydrate(false)
                    ->toArray();
            foreach ($mFolderList as $mFolder) {
                //Get movie contents by folder id
                $movieInfo = $mContentsTbl->getContentsByMovie($userSeq, $mFolder['movie_folder_id']);
                $mFolder['movieInfo'] = $movieInfo;
            }
            //Get Endcode status
            $encStatus = $this->Movie->checkMovieEncStatus($userSeq);
            $mFolderList['encStatus'] = $encStatus;
            return $mFolderList;
        } catch (Exception $e) {
            $this->LogMessage->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

    /**
     * method getMovieFolderInfoById
     *
     * @param $userSeq
     * @param $mFolderId
     * @return array
     * @throws Exception
     */
    public function getMovieFolderInfoById($userSeq, $mFolderId)
    {
        $mFolderTbl = TableRegistry::get('MovieFolder');
        $mContentsTbl = TableRegistry::get('MovieContents');
        try {
            $mFolderInfo = $mFolderTbl->find()
                    ->where(['user_seq' => $userSeq,
                        'movie_folder_id' => $mFolderId])
                    ->hydrate(false)
                    ->toArray();
            $mFolderInfo['movieInfo'] = $mContentsTbl->getContentsByMovie($userSeq, $mFolderId);
            //Get Endcode status
            $encStatus = $this->Movie->checkMovieEncStatus($userSeq);
            $mFolderInfo['encStatus'] = $encStatus;
            return $mFolderInfo;
        } catch (Exception $e) {
            $this->LogMessage->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

    /**
     * Validate input
     * @param $validator
     * @return NoptBaseValidator
     */
    public function validationDefault(NoptBaseValidator $validator)
    {
        $validator->allowEmpty('movie_folder_name');

        $validator->add(
                'movie_folder_name', 'noValue', ['rule' => function ($name) {
                if (mb_strlen($name, 'utf-8') == 0) {
                    $this->LogMessage->logMessage("10036", $this->request->session()->read('UserData.user_seq'));
                    return false;
                }
                return true;
            },
            'message' => 'フォルダ名が入力されていません｡',
                ]
        );
        $validator->add(
                'movie_folder_name', 'noSpaces', ['rule' => function ($movie_folder_name) {
                if (mb_strlen($movie_folder_name) > 0 && mb_strlen(trim($movie_folder_name), 'utf-8') == 0) {
                    $this->LogMessage->logMessage("10081", $this->request->session()->read('UserData.user_seq'));
                    return false;
                }
                return true;
            },
            'message' => '半角スペースのみの登録はできません。',
                ]
        );

        $validator->add(
                'movie_folder_name', 'maxLength', ['rule' => function ($movie_folder_name) {
                if (mb_strlen($movie_folder_name, 'utf-8') > 25) {
                    $this->LogMessage->logMessage("10037", $this->request->session()->read('UserData.user_seq'));
                    return false;
                }
                return true;
            },
            'message' => 'フォルダ名には25文字以内で入力してください｡',
                ]
        );

        $validator->allowEmpty('movie_folder_comment');
        $validator->add(
                'movie_folder_comment', 'maxLength', ['rule' => function ($movie_folder_comment) {
//                if (mb_strlen(trim($movie_folder_comment), 'utf-8') > 1000) {
                if ($this->Common->getStrlenNoNewline($movie_folder_comment) > 1000) {
                    $this->LogMessage->logMessage("10038", $this->request->session()->read('UserData.user_seq'));
                    return false;
                }
                return true;
            },
            'message' => 'コメントには1000文字以内で入力してください｡',
                ]
        );
        return $validator;
    }

    /**
     * method getAllMovieFolderData
     * @param $userSeq
     * @return array
     */
    public function getAllMovieFolderData($userSeq)
    {
        try {
            $movieFolder = TableRegistry::get('MovieFolder');
            $MovieFolderObjArray = $movieFolder->find()->where(['user_seq' => $userSeq])->hydrate(false)->toArray();
            for ( $i = 0; $i < count($MovieFolderObjArray); $i++) {
                $movieTbl = TableRegistry::get('MovieContents');
                $MovieFolderArray = $movieTbl->getContentsByMovie($userSeq, $MovieFolderObjArray[$i]['movie_folder_id']);
                $MovieFolderObjArray[$i]['movie_count'] = count($MovieFolderArray);
            }
            return $MovieFolderObjArray;
        } catch (Exception $e) {
            $this->LogMessage->logMessage('10048', $userSeq, "");
            throw $e;
        }
    }

}
