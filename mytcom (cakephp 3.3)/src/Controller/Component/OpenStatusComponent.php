<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Exception;

/**
 * OpenStatus component
 */
class OpenStatusComponent extends Component
{

    // 使用するComponentの定義
    public $components = ['LogMessage'];



    /**
     * 公開機能仕様変更
     *
     * @param array $dataArray $openArray int $openFlg
     */
    public function updateDownloadCount($dataArray, $openArray, $openFlg)
    {
        $openStatusTbl = TableRegistry::get('OpenStatus');
        try {
            for ($i = 0; $i < \count($dataArray); $i++) {
                if ($openFlg == 1) {
                    $id = $dataArray[$i]['album_id'];
                } elseif ($openFlg == 3) {
                    $id = $dataArray[$i]['pic_id'];
                } elseif ($openFlg == 2) {
                    $id = $dataArray[$i]['file_id'];
                } else {
                    $id = $dataArray[$i]['movie_id'];
                }

                $openStatus = $openStatusTbl->find()
                    ->where(['user_seq' => $openArray['user_seq'],
                        'open_id' => $openArray['open_id'],
                        'target_id' => $id])
                    ->first();
                if ($openStatus != null) {
                    //get download count now
                    $num = $openStatusTbl->getDownloadCount($openArray['open_id'], $id, $openArray['user_seq']);
                    $openStatus->download_count = $num + 1;
                    $openStatusTbl->connection()->transactional(function () use ($openStatusTbl, $openStatus) {
                        $openStatusTbl->save($openStatus, ['atomic' => false]);
                    });
                }
            }
        } catch (Exception $e) {
            //NotFoundException
            throw $e;
        }
    }


    /**
     *
     * 公開ステータスを削除する
     * $openType =
     *  1:Picture by Album,
     *  2:single File and Folder,
     *  3:single Picture,
     *  4:Movies by Folder,
     *  5:single Movie,
     *
     *  $folderFlg if is send by Folder id.
     *
     * @param string $userSeq
     * @param string $targetId
     * @param string $openType
     * @param bool $folderFlg
     * @return int
     */
    public function deleteOpenStats($userSeq=null, $targetId=null, $openType=null ,$folderFlg=null)
    {
        //必須引数の存在確認
        if(empty($userSeq) || empty($targetId) || empty($openType)) {
            return false;
        }

        //target_userのテーブルレコードを削除
        $this->deleteTargetUser($userSeq, $targetId, $openType, $folderFlg);

        $query =null;
        if ($openType === 1) {
            //アルバム一式の公開設定削除
            $this->deleteOpenRecode($userSeq, $targetId, $openType);

            //そのアルバムの中のPicture単体公開の削除を行う。
            $openType = 3;
            $picTbl = TableRegistry::get('PicTbl');
            $query = $picTbl->find();
            $file_info = $query->where(['user_seq' => $userSeq, 'album_id' => $targetId])->toArray();
            //$targetIdを取得したリストの$file_infoのfile_idに入れ替える。
            foreach ($file_info as $file_id) {
                $targetId = $file_id['pic_id'];
                $this->deleteOpenRecode($userSeq, $targetId, $openType);
            }
        } else if ($openType === 2 && $folderFlg) {
                //$openType=2でフォルダー指定の場合は、FileテーブルからfileId=targetIdを取得する。
                $fileTbl = TableRegistry::get('FileTbl');
                foreach ($targetId as $targetId_folder) {
                    $query = $fileTbl->find();
                    $file_info = $query->where(['user_seq' => $userSeq, 'file_folder_id' => $targetId_folder])->toArray();

                    //$targetIdを取得したリストの$file_infoのfile_idに入れ替える。
                    foreach ($file_info as $file_id) {
                        $targetId = $file_id['file_id'];
                        $this->deleteOpenRecode($userSeq, $targetId, $openType);
                    }
                }
        } else if ($openType === 4) {
            //動画フォルダ一式の公開設定削除
            $this->deleteOpenRecode($userSeq, $targetId, $openType);

            //その動画フォルダの中の動画単体公開の削除を行う。
            $openType = 5;
            $movTbl = TableRegistry::get('MovieContents');
            $query = $movTbl->find();
            $move_info = $query->where(['user_seq' => $userSeq, 'movie_folder_id' => $targetId])->toArray();
            //$targetIdを取得したリストの$file_infoのfile_idに入れ替える。
            foreach ($move_info as $move_id) {
                $targetId = $move_id['movie_contents_id'];
                $this->deleteOpenRecode($userSeq, $targetId, $openType);
            }
        } else {
            //ファイル指定の場合は、targetIdのリストを処理する。
            foreach ($targetId as $file_id) {
                $targetId = $file_id;
                $this->deleteOpenRecode($userSeq, $targetId, $openType);
            }
        };
        return true;
    }


    /**
     * 公開ステータスのテーブルレコードを削除
     *
     * @param $userSeq
     * @param $targetId
     * @param $openType
     * @return bool
     * @throws $e
     */
    private function deleteOpenRecode($userSeq=null, $targetId=null, $openType=null)
    {
        //オープンステータステーブルのアクセスを獲得
        $query = null;
        $openStatusTbl = TableRegistry::get('OpenStatus');
        $query = $openStatusTbl->find();
        //オープンステータステーブルの検索条件の設定
        $fileOpen_info = $query->where(['user_seq' => $userSeq, 'target_id' => $targetId, 'open_type' => $openType]);
        $fileOpen_info = $fileOpen_info->toArray();

        if ($fileOpen_info != null) {
            //ファイルの公開情報をopen_statusテーブルから削除する。
            try {
                $openStatusTbl->deleteAll(['user_seq' => $userSeq, 'target_id' => $targetId, 'open_type' => $openType]);
            } catch (Exception $e) {
                //NotFoundException
                throw $e;
            }
        }
        return true;
    }


    /**
     * target_userのテーブルレコードを削除
     *
     * @param $userSeq
     * @param null $targetId
     * @param null $openType
     * @param null $folderFlg
     * @return bool
     * @internal param $openId
     * @throws $e
     */
    private function deleteTargetUser($userSeq=null, $targetId=null, $openType=null, $folderFlg=null)
    {

        if ($openType === 1) {
            //$openType === 1 アルバム削除のケース：ターゲットID（１つのみ）からオープンIDを取得する
            //オープンステータスからopen_idを取得する。
            $query = null;
            $openStatusTbl = TableRegistry::get('OpenStatus');
            $query = $openStatusTbl->find();
            //オープンステータステーブルの検索条件の設定
            $pictOpen_info = $query->where(['user_seq' => $userSeq, 'target_id' => $targetId[0], 'open_type' => $openType])->toArray();
            $targetUser = TableRegistry::get('TargetUser');
            foreach ($pictOpen_info as $pictOpen_info_data) {
                try {
                    $targetUser->deleteAll(['user_seq' => $userSeq, 'open_id' => $pictOpen_info_data['open_id']]);
                } catch (Exception $e) {
                    //NotFoundException
                    throw $e;
                }
            }

            //そのアルバムの中のPicture単体公開情報の検索jを行う。
            $query = null;
            $picTbl = TableRegistry::get('PicTbl');
            $query = $picTbl->find();
            $pict_file = $query->where(['user_seq' => $userSeq, 'album_id' => $targetId])->toArray();

            //$targetIdを取得したリストの$file_infoのfile_idに入れ替える。
            $targetId = [];
            foreach ($pict_file as $pict_file_id) {
                array_push($targetId, $pict_file_id['pic_id']);
            }
            //フォルダの中の写真のオープンIDを調べて削除する：フォルダ削除なので写真単体は残らないので一括削除。
            $query = null;
            foreach ($targetId as $targetId_pict_no) {
                $query = $openStatusTbl->find();
                $pictOpen_info = $query->where(['user_seq' => $userSeq, 'target_id' => $targetId_pict_no])->toArray();
                foreach ($pictOpen_info as $pictOpen_info_data) {
                    try {
                        $targetUser->deleteAll(['user_seq' => $userSeq, 'open_id' => $pictOpen_info_data['open_id']]);
                    } catch (Exception $e) {
                        //NotFoundException
                        throw $e;
                    }
                }
            }
            return true;

        } else if ($openType === 2) {

          if ($folderFlg) {
                //$openType=2でフォルダー指定の場合は、FileテーブルからfileId=targetIdを取得する。
                //$targetIdを取得したリストの$file_infoのfile_idに入れ替える。
                $targetId_list = [];
                $query = null;
                $fileTbl = TableRegistry::get('FileTbl');
                foreach ($targetId as $targetId_folder_no) {
                    $query = $fileTbl->find();
                    $file_info = $query->where(['user_seq' => $userSeq, 'file_folder_id' => $targetId_folder_no])->toArray();
                    foreach ($file_info as $file_id_no) {
                        array_push($targetId_list, $file_id_no['file_id']);
                    }
                    // フォルダに含まれるファイルIDをターゲットIDに入れる。
                    $targetId = $targetId_list;
                }
            }

            $query = null;
            $openStatusTbl = TableRegistry::get('OpenStatus');
            foreach ($targetId as $targetId_file_no) {
                $query = $openStatusTbl->find();
                $fileOpen_info = $query->where(['user_seq' => $userSeq, 'target_id' => $targetId_file_no])->toArray();

                foreach ($fileOpen_info as $fileOpen_info_id) {
                    $query = null;
                    $query = $openStatusTbl->find();
                    $fileOpen_info_list = $query->select(['target_id'])->where(['user_seq' => $userSeq, 'open_id' => $fileOpen_info_id['open_id']])->toArray();
                    $fileOpen_info_list_id = null;
                    $fileOpen_info_list_id_value = [];
                    foreach ($fileOpen_info_list as$fileOpen_info_list_id) {
                        array_push($fileOpen_info_list_id_value, (string)$fileOpen_info_list_id['target_id']);
                    }
                    sort($fileOpen_info_list_id_value);
                    sort($targetId);

                    $result = array_diff($fileOpen_info_list_id_value, $targetId);
                    if (count($result) === 0) {
                        $targetUser = TableRegistry::get('TargetUser');
                        try {
                            $targetUser->deleteAll(['user_seq' => $userSeq, 'open_id' => $fileOpen_info_id['open_id']]);
                        } catch (Exception $e) {
                            //NotFoundException
                            throw $e;
                        }
                    }
                }
            }
            return true;

        } else if ($openType === 3) {
            //写真を選択したケース：ターゲットID（複数）からオープンIDを取得する
            //同一のオープンIDで公開されている数と、ターゲットIDの数が同じなら、ターゲットユーザーIDの登録を削除する
            $query = null;
            $openStatusTbl = TableRegistry::get('OpenStatus');
            foreach ($targetId as $targetId_pict_no) {
                $query = $openStatusTbl->find();
                $pictOpen_info = $query->where(['user_seq' => $userSeq, 'target_id' => $targetId_pict_no])->toArray();

                foreach ($pictOpen_info as $pictOpen_info_id) {
                    $query = null;
                    $query = $openStatusTbl->find();
                    $pictOpen_info_list = $query->select(['target_id'])->where(['user_seq' => $userSeq, 'open_id' => $pictOpen_info_id['open_id']])->toArray();
                    $pictOpen_info_list_id = null;
                    $pictOpen_info_list_id_value = [];
                    foreach ($pictOpen_info_list as $pictOpen_info_list_id) {
                        array_push($pictOpen_info_list_id_value, (string)$pictOpen_info_list_id['target_id']);
                    }
                    sort($pictOpen_info_list_id_value);
                    sort($targetId);
                    $result = array_diff($pictOpen_info_list_id_value, $targetId);
                    if (count($result) === 0) {
                        $targetUser = TableRegistry::get('TargetUser');
                        try {
                            $targetUser->deleteAll(['user_seq' => $userSeq, 'open_id' => $pictOpen_info_id['open_id']]);
                        } catch (Exception $e) {
                            //NotFoundException
                            throw $e;
                        }
                    }
                }
            }
            return true;

        } else if ($openType === 4) {
            //動画フォルダ削除のケース：ターゲットID（１つのみ）からオープンIDを取得する
            //オープンステータスからopen_idを取得する。
            $query = null;
            $openStatusTbl = TableRegistry::get('OpenStatus');
            $query = $openStatusTbl->find();
            //オープンステータステーブルの検索条件の設定
            $moveOpen_info = $query->where(['user_seq' => $userSeq, 'target_id' => $targetId[0], 'open_type' => $openType])->toArray();
            $targetUser = TableRegistry::get('TargetUser');
            foreach ($moveOpen_info as $moveOpen_info_data) {
                try {
                    $targetUser->deleteAll(['user_seq' => $userSeq, 'open_id' => $moveOpen_info_data['open_id']]);
                } catch (Exception $e) {
                    //NotFoundException
                    throw $e;
                }
            }

            //その動画フォルダの中の動画単体公開情報の検索jを行う。
            $query = null;
            $movTbl = TableRegistry::get('MovieContents');
            $query = $movTbl->find();
            $move_file = $query->where(['user_seq' => $userSeq, 'movie_folder_id' => $targetId])->toArray();

            //$targetIdを取得したリストの$move_file_idのmovie_contents_idに入れ替える。
            $targetId = [];
            foreach ($move_file as $move_file_id) {
                array_push($targetId, $move_file_id['movie_contents_id']);
            }

            //動画フォルダの中の動画のオープンIDを調べて削除する：フォルダ削除なので動画単体は残らないので一括削除。
            $query = null;
            foreach ($targetId as $targetId_move_no) {
                $query = $openStatusTbl->find();
                $moveOpen_info = $query->where(['user_seq' => $userSeq, 'target_id' => $targetId_move_no])->toArray();
                foreach ($moveOpen_info as $moveOpen_info_data) {
                    try {
                        $targetUser->deleteAll(['user_seq' => $userSeq, 'open_id' => $moveOpen_info_data['open_id']]);
                    } catch (Exception $e) {
                        //NotFoundException
                        throw $e;
                    }
                }
            }
            return true;

        } else if ($openType === 5) {
            //動画を選択したケース：ターゲットID（複数）からオープンIDを取得する
            //同一のオープンIDで公開されている数と、ターゲットIDの数が同じなら、ターゲットユーザーIDの登録を削除する
            $query = null;
            $openStatusTbl = TableRegistry::get('OpenStatus');
            foreach ($targetId as $targetId_move_no) {
                $query = $openStatusTbl->find();
                $moveOpen_info = $query->where(['user_seq' => $userSeq, 'target_id' => $targetId_move_no])->toArray();

                foreach ($moveOpen_info as $moveOpen_info_id) {
                    $query = null;
                    $query = $openStatusTbl->find();
                    $moveOpen_info_list = $query->select(['target_id'])->where(['user_seq' => $userSeq, 'open_id' => $moveOpen_info_id['open_id']])->toArray();
                    $moveOpen_info_list_id = null;
                    $moveOpen_info_list_id_value = [];
                    foreach ($moveOpen_info_list as $moveOpen_info_list_id) {
                        array_push($moveOpen_info_list_id_value, (string)$moveOpen_info_list_id['target_id']);
                    }
                    sort($moveOpen_info_list_id_value);
                    sort($targetId);
                    $result = array_diff($moveOpen_info_list_id_value, $targetId);
                    if (count($result) === 0) {
                        $targetUser = TableRegistry::get('TargetUser');
                        try {
                            $targetUser->deleteAll(['user_seq' => $userSeq, 'open_id' => $moveOpen_info_id['open_id']]);
                        } catch (Exception $e) {
                            //NotFoundException
                            throw $e;
                        }
                    }
                }
            }
            return true;
        }
        return true;
    }

}
