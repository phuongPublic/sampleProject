<?php

namespace App\Controller\Component;

use Aura\Intl\Exception;
use Cake\Controller\Component;
use App\Validation\NoptBaseValidator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Movie component
 */
class MovieComponent extends Component
{
    // 使用するComponentの定義
    public $components = [
        'LogMessage',
        //'MovieFolder',
        'MovieFile',
        'Common',
    ];

    /**
     * method getSearchMovieByFolder
     * @param $userSeq
     * @param $movieFolderId
     * @param $keyword
     * @param $sort
     * @return array|\Cake\ORM\Table
     */
    public function getSearchMovieByFolder($userSeq, $movieFolderId, $keyword, $sort)
    {
        //remove space in head of keyword
        $keyword = trim($keyword);
        $keyword = str_replace(array("\\", "%", "_"), array("\\\\", "\%", "\_"), $keyword);
        $keyword = '%' . $keyword . '%';

        $resultMovieList = TableRegistry::get('MovieContents');
        //ソート順を設定
        if ($sort == 'old') {
            $sortStr = 'ASC';
        } else {
            $sortStr = 'DESC';
        }
        if ($movieFolderId) {
            $resultMovieList = $resultMovieList->find()
                ->order(['movie_contents_id' => $sortStr])
                ->where(['user_seq' => $userSeq, 'encode_status !=' => 9])
                ->andWhere(['movie_folder_id' => $movieFolderId])
                ->andWhere(['OR' => [['movie_contents_name LIKE' => $keyword], ['movie_contents_comment LIKE' => $keyword]]])
                ->hydrate(false)
                ->toArray();
        } else {
            $resultMovieList = $resultMovieList->find()
                ->order(['movie_contents_id' => $sortStr])
                ->where(['user_seq' => $userSeq, 'encode_status !=' => 9])
                ->andWhere(['OR' => [['movie_contents_name LIKE' => $keyword], ['movie_contents_comment LIKE' => $keyword]]])
                ->hydrate(false)
                ->toArray();
        }

        return $resultMovieList;
    }

    /**
     * method insertMovieStatus
     *
     * @param $newId
     * @param $userSeq
     * @param $movieData
     * @return boolean
     */
    public function insertMovieStatus($newId, $userSeq, $movieData)
    {
        $result = false;
        try {
            $movieTbl = TableRegistry::get('MovieContents');
            $movie = $movieTbl->newEntity();


            //set movie properties
            $movie->user_seq = $userSeq;
            $movie->movie_folder_id = $movieData['movie_folder_id'];
            $movie->movie_contents_id = $newId;
            $movie->movie_contents_name = $movieData['movie_contents_name'];
            $movie->name = $movieData['name'];
            $movie->extension = $movieData['extension'];
            $movie->amount = $movieData['amount'];
            $movie->movie_contents_url = '';
            $movie->movie_contents_comment = $movieData['movie_contents_comment'];
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
            //IPhone compatible
            $movie->encode_file_id_iphone = null;

            //transaction
            $movieTbl->connection()->transactional(function () use ($movieTbl, $movie, $userSeq, $newId) {
                $movieTbl->save($movie, ['atomic' => false]);
                //create directory
                $tempDir = Configure::read('Common.Upload') . Configure::read('Common.BaseMovie') . $userSeq . '/temp/';
                $this->Common->umaskMkdir($tempDir, 0777);
                $movieDir = $tempDir . $this->Common->fixFormatId($newId) . '/encode_movie/original';
                $this->Common->umaskMkdir($movieDir, 0777);
            });
            $result = true;
        } catch (Exception $e) {
            $this->LogMessage->logMessage('10010', $userSeq);
            $result = false;
        }
        return $result;
    }

    /**
     * method updateMovieData
     *
     * @param $userSeq
     * @param $movieId
     * @param $movieName
     * @param $movieComment
     * @return int
     */
    public function updateMovieData($userSeq, $movieId, $movieName, $movieComment)
    {
        //to handle in controller, $result = 1 mean update complete success
        $result = 1;
        try {
            $movieTbl = TableRegistry::get('MovieContents');
            //get movie entity
            $movie = $movieTbl->find()
                ->where(['user_seq' => $userSeq])
                ->andWhere(['movie_contents_id' => $movieId])
                ->first();
            //update if movie exists on database
            if ($movie != null) {
                $movie->name = $movieName;
                $movie->movie_contents_name = $movieName . '.' . $movie->extension;
                $movie->movie_contents_comment = $movieComment;

                //transaction
                $movieTbl->connection()->transactional(function () use ($movieTbl, $movie) {
                    $movieTbl->save($movie, ['atomic' => false]);
                });
            } else {
                //to handle in controller, movie not exists
                $result = 0;
            }
        } catch (Exception $e) {
            //to handle in controller, error occur
            $result = -1;
        }
        return $result;
    }

    /**
     * method deleteMovieData
     *
     * @param $userSeq
     * @param $movieContentsId
     *
     * @return int
     */
    public function deleteMovieData($userSeq, $movieContentsId)
    {
        //to handle in controller, $result = 1 mean delete complete success
        $result = 1;
        try {
            $movieTbl = TableRegistry::get('MovieContents');
            $encodeTbl = TableRegistry::get('EncodeRequest');

            //OPT側のデータベースにデータが無い場合、動画ファイル削除処理を終了する。
            $movie = $movieTbl->getSingleMovieData($userSeq, $movieContentsId);
            if (empty($movie)) {
                return 0;
            }
            //get movie entity
            $encReq = $encodeTbl->find()
                ->where(['user_seq' => $userSeq])
                ->andWhere(['movie_encode_id' => $movieContentsId])
                ->andWhere(['request_source' => env('NOPT_ISP')])
                ->order(['register_date' => 'DESC'])
                ->limit(1)
                ->first();

            //update if movie exists on database
            // OPT側の動画データの削除。動画ファイルの削除条件
            // ・動画変換サーバのencode_request.encode_statusが
            // 2（処理正常終了）または、3（処理異常終了）、または該当のデータが存在しないとき
            // データが存在しない時は、旧FW（Ethna）で登録した動画データを想定している。
            if (is_null($encReq) || $encReq->encode_status == 2 || $encReq->encode_status == 3) {
                //transaction
                $movieTbl->connection()->transactional(function () use ($movieTbl, $userSeq, $movieContentsId) {
                    $movieTbl->deleteAll([
                        'user_seq' => $userSeq,
                        'movie_contents_id' => $movieContentsId
                    ]);
                });
                $this->MovieFile->deleteMovieFile($userSeq, $movieContentsId);
            } elseif ($encReq->encode_status == 0) {
                //encode_request.encode_statusが0（要求依頼）のとき。
                $encReq->cancel = 1;
                $encodeTbl->connection()->transactional(function () use ($encodeTbl, $userSeq, $encReq) {
                    $encodeTbl->save($encReq, ['atomic' => false]);
                });

                //transaction
                $movieTbl->connection()->transactional(function () use ($movieTbl, $userSeq, $movieContentsId) {
                    $movieTbl->deleteAll([
                        'user_seq' => $userSeq,
                        'movie_contents_id' => $movieContentsId
                    ]);
                });
                $this->MovieFile->deleteMovieFile($userSeq, $movieContentsId);
            } elseif ($encReq->encode_status == 1) {
                //encode_request.encode_statusが1（処理中）のとき。
                $movieObj = $movieTbl->find()
                    ->where(['user_seq' => $userSeq])
                    ->andWhere(['movie_contents_id' => $movieContentsId])
                    ->first();
                $movieObj->encode_status = 9;
                $movieTbl->connection()->transactional(function () use ($movieTbl, $userSeq, $movieObj) {
                    $movieTbl->save($movieObj, ['atomic' => false]);
                });
            }
        } catch (Exception $e) {
            //to handle in controller, $result = -1 mean error occur
            $result = -1;
        }
        return $result;
    }

    /**
     * @method moveContentsFolderData
     * move a movie to other movie folder
     *
     * @param $userSeq
     * @param $movieFolderId
     * @param $movieContentsId
     * @return int
     */
    public function moveContentsFolderData($userSeq, $movieFolderId, $movieContentsId)
    {
        //to handle in controller, $result = 1 mean move complete success
        $result = 1;
        try {
            //check  exists for movie
            $movieTbl = TableRegistry::get('MovieContents');
            $movie = $movieTbl->find()
                ->where(['user_seq' => $userSeq])
                ->andWhere(['movie_contents_id' => $movieContentsId])
                ->first();
            if ($movie != null) {
                $movieFolderTbl = TableRegistry::get('MovieFolder');
                $newMovieFolder = $movieFolderTbl->find()
                    ->where(['user_seq' => $userSeq])
                    ->andWhere(['movie_folder_id' => $movieFolderId])
                    ->first();
                if ($newMovieFolder != null) {
                    $movie->movie_folder_id = $movieFolderId;
                    //transaction
                    $movieTbl->connection()->transactional(function () use ($movieTbl, $movie, $movieFolderTbl, $newMovieFolder) {
                        $movieTbl->save($movie, ['atomic' => false]);
                    });
                } else {
                    //to handle in controller, $result = -1 mean destination folder not exists
                    $result = -1;
                }
            } else {
                //to handle in controller, $result = 0 mean movie not exists
                $result = 0;
            }
        } catch (Exception $e) {
            //to handle in controller, $result = -2 mean error occur
            $result = -2;
        }
        return $result;
    }

    /**
     * method sendEncodeRequest
     *
     * @param $userSeq
     * @param $movieContentsId
     * @param $encodeData
     * @return boolean
     */
    public function sendEncodeRequest($userSeq, $movieContentsId, $encodeData)
    {
        $requestEncodeTbl = TableRegistry::get('EncodeRequest');

        $requestEncode = $requestEncodeTbl->newEntity();

        $requestEncode->movie_contents_id = $movieContentsId;
        $requestEncode->user_seq = $userSeq;

        // OPTの動画のエンコードステータス確認は、動画変換サーバ側データベースのencode_request.movie_encode_idを動画IDとして扱う。
        // 理由は、動画変換サーバのカット編集機能では、encode_request.movie_contents_idにカット編集の元の動画ID、
        // encode_request.movie_encode_idにカット編集の動画IDが格納される。
        // そのため、encode_request.movie_contents_idを動画IDとして扱うと、カット編集した動画のエンコードステータスが判断できない。
        // 逆にエンコード編集は、動画編集サーバ側ではencode_request.movie_encode_idに値が格納されない。
        // よって、OPT側でencode_request.movie_contents_id とencode_request.movie_encode_idに同じ動画IDを保存する。
        $requestEncode->movie_encode_id = $movieContentsId;
        $requestEncode->request_source = env('NOPT_ISP');
        $requestEncode->encode_order = $encodeData['encode_order'];
        $requestEncode->encode_status = $encodeData['encode_status'];
        $requestEncode->cancel = $encodeData['cancel'];

        //transaction
        $requestEncodeTbl->connection()->transactional(function () use ($requestEncodeTbl, $requestEncode) {
            $requestEncodeTbl->save($requestEncode, ['atomic' => false]);
        });
    }

    /**
     * method checkMovieEncStatus
     *
     * @param $userSeq
     * @return array
     */
    public function checkMovieEncStatus($userSeq)
    {
        try {
            // movie_contents.encode_statusが9（キャンセル(削除予約)）のデータを取得する。
            $movieTbl = TableRegistry::get('MovieContents');
            $movieEncodes = $movieTbl->getMovieByEncode($userSeq, 9);

            //get array id
            $movieEncIds = [];
            foreach ($movieEncodes as $movieEnc) {
                $movieEncIds[] = $movieEnc['movie_contents_id'];
            }
            //get status in encDB which encode complete success
            $encodeRequestTbl = TableRegistry::get('EncodeRequest');
            if (!empty($movieEncIds)) {
                // movie_contents.encode_statusが9（キャンセル(削除予約)）のmovie_contentsデータ分繰り返す
                foreach ($movieEncIds as $contentId) {
                    // encode_requestテーブルから最新のデータを1件取得する。
                    $encRequest = $encodeRequestTbl->find()
                        ->select(['encode_status'])
                        ->where(['user_seq' => $userSeq, 'movie_encode_id' => $contentId, 'request_source' => env('NOPT_ISP')])
                        ->order(['register_date' => 'DESC'])
                        ->limit(1)
                        ->first();
                    // encode_request.encode_statusが2（処理正常終了）、3（処理異常終了）なら削除処理を実施する
                    if (!is_null($encRequest)) {
                        if ($encRequest->encode_status == 2 || $encRequest->encode_status == 3) {
                            $this->MovieFile->deleteMovieFile($userSeq, $contentId);
                            $movieTbl->connection()->transactional(function () use ($movieTbl, $userSeq, $contentId) {
                                $movieTbl->deleteAll([
                                    'user_seq' => $userSeq,
                                    'movie_contents_id' => $contentId
                                ]);
                            });
                        }
                    }
                }
            }

            //get movie not encode, encode_status == 0
            $movieTbl = TableRegistry::get('MovieContents');
            $movieEncodes = $movieTbl->getMovieByEncode($userSeq, 0);

            //get array id
            $movieEncIds = [];
            foreach ($movieEncodes as $movieEnc) {
                $movieEncIds[] = $movieEnc['movie_contents_id'];
            }
            //get status in encDB which encode complete success
            $encodeRequestTbl = TableRegistry::get('EncodeRequest');
            if (!empty($movieEncIds)) {
                foreach ($movieEncIds as $id) {
                    try {
                        //because encode_request not delete when movie delete
                        $encRequest = $encodeRequestTbl->find()
                            ->where(['user_seq' => $userSeq, 'movie_encode_id ' => $id, 'request_source' => env('NOPT_ISP')])
                            ->order(['register_date' => 'DESC'])
                            ->limit(1)
                            ->first();

                        if (!is_null($encRequest)) {
                            if ($encRequest->encode_status == 2) {
                                //get amount movie folder
                                $folder = Configure::read('Common.Upload') . Configure::read('Common.BaseMovie') . '/' . $userSeq . '/movie/' . $this->Common->fixFormatId($id);
                                $amount = $this->MovieFile->folderSize($folder);

                                //Internet Explorer 11 movie folder
                                $lowPcFolder = $folder . '/encode_movie/low_pc';
                                $lowPcSize = $this->MovieFile->folderSize($lowPcFolder);

                                $contentSize = $amount - $lowPcSize;

                                //update status movie encode success
                                $movie = $movieTbl->find()
                                    ->where(['user_seq' => $userSeq])
                                    ->andWhere(['movie_contents_id' => $id])
                                    ->first();
                                $movie->encode_status = 2;
                                $movie->amount = $contentSize;
                                // encode_request.play_timeのコンマ秒が1桁のとき。最後に0を付与する。例）11:22:33.4の形から11:22:33.40を返却する。
                                // マッチしなければ、そのままの値を返却する。
                                $movie->reproduction_time = preg_replace('/(\d{2}:\d{2}:\d{2}\.\d{1})$/', '${1}0', $encRequest->play_time);

                                //transaction
                                $movieTbl->connection()->transactional(function () use ($movieTbl, $movie) {
                                    $movieTbl->save($movie, ['atomic' => false]);
                                });
                                //log video encode completion status updated.
                                $this->LogMessage->logMessage('10060', array($userSeq, $id));
                            } elseif ($encRequest->encode_status == 3) {
                                //update status movie which encode abnormal
                                $movie = $movieTbl->find()
                                    ->where(['user_seq' => $userSeq])
                                    ->andWhere(['movie_contents_id' => $id])
                                    ->first();
                                $movie->encode_status = 3;
                                //transaction
                                $movieTbl->connection()->transactional(function () use ($movieTbl, $movie) {
                                    $movieTbl->save($movie, ['atomic' => false]);
                                });
                                //log video encode completion status updated.
                                $this->LogMessage->logMessage('10060', array($userSeq, $id));
                            }
                        }
                    } catch (Exception $e) {
                        $this->LogMessage->logMessage('10048', $userSeq, "");
                    }
                }
            }

            //update total movie size
            $movieSize = $this->Common->getMovieSize($userSeq);
            $userMst = TableRegistry::get('UserMst');
            $user = $userMst->find()
                ->where(['user_seq' => $userSeq])
                ->first();
            $user->movie_size = $movieSize;
            $userMst->connection()->transactional(function () use ($userMst, $user) {
                $userMst->save($user, ['atomic' => false]);
            });
        } catch (Exception $e) {
            $this->LogMessage->logMessage('10048', $userSeq, "");
        }
    }

    /**
     * method save
     *
     * @param $newId
     * @param $userSeq
     * @param $data
     * @return boolean
     */
    public function save($newId, $userSeq, $data)
    {
        //insert to DB
        $result = $this->insertMovieStatus($newId, $userSeq, $data);
        if ($result) {
            //encode data
            $encodeData = [];
            $encodeData['encode_order'] = 0;
            $encodeData['encode_status'] = 0;
            $encodeData['cancel'] = 0;

            //send encode movie
            $this->sendEncodeRequest($userSeq, $newId, $encodeData);
        }
        return $result;
    }

    /**
     * method getDelMovieList
     * @param $userSeq
     * @param $del
     * @return array
     */
    public function getDelMovieList($userSeq, $del)
    {
        if (empty($del)) {
            return array();
        }
        $movieFolderTbl = TableRegistry::get('MovieFolder');
        $movieContentTbl = TableRegistry::get('MovieContents');
        $openStatus = TableRegistry::get('OpenStatus');

        $movieList = [];
        for ($i = 0; $i < count($del); $i++) {
            $result = $movieContentTbl->getSingleMovieData($userSeq, $del[$i]);
            if (empty($result)) {
                //movie not found
                return array();
            }
            $mFolderId = $result[0]['movie_folder_id'];
            $mFolderName = $movieFolderTbl->getFolderNameById($userSeq, $mFolderId);
            $result[0]['movie_folder_name'] = $mFolderName['movie_folder_name'];

            $statusMFolder = $openStatus->getAllOrderByOpenStatus($userSeq, $mFolderId, 4);
            if (!empty($statusMFolder)) {
                $statusInfo = 1;
            } else {
                $statusMovie = $openStatus->getAllOrderByOpenStatus($userSeq, $result[0]['movie_contents_id'], 5);
                $statusInfo = !empty($statusMovie) ? 1 : 0;
            }
            $result[0]['openstatus'] = $statusInfo;
            $movieList[] = $result[0];
        }
        return $movieList;
    }

    /**
     * Validate input
     * @param $validator
     * @return NoptBaseValidator
     */
    public function validationDefault(NoptBaseValidator $validator)
    {
        $validator->allowEmpty('name');

        $validator->add(
            'name', 'noValue', ['rule' => function ($name) {
                if (mb_strlen(trim($name), 'utf-8') == 0) {
                    $this->LogMessage->logMessage("10039", $this->request->session()->read('UserData.user_seq'));
                    return false;
                }
                return true;
            },
                'message' => '動画のタイトルが入力されていません｡',
            ]
        );
        $validator->add(
            'name', 'maxLength', ['rule' => function ($name) {
                if (mb_strlen($name, 'utf-8') > 125) {
                    $this->LogMessage->logMessage("10040", $this->request->session()->read('UserData.user_seq'));
                    return false;
                }
                return true;
            },
                'message' => '動画のタイトルには125文字以内で入力してください｡',
            ]
        );

        $validator->add(
            'name', 'noSpaces', ['rule' => function ($name) {
                if (mb_strlen($name) > 0 && mb_strlen(trim($name), 'utf-8') == 0) {
                    $this->LogMessage->logMessage("10082", $this->request->session()->read('UserData.user_seq'));
                    return false;
                }
                return true;
            },
                'message' => '半角スペースのみの登録はできません。',
            ]
        );

        $validator->allowEmpty('movie_contents_comment');
        $validator->add(
            'movie_contents_comment', 'maxLength', ['rule' => function ($movie_contents_comment) {
                if ($this->Common->getStrlenNoNewline($movie_contents_comment) > 1000) {
                    $this->LogMessage->logMessage("10038", $this->request->session()->read('UserData.user_seq'));
                    return false;
                }
                return true;
            },
                'message' => '動画のコメントには1000文字以内で入力してください。',
            ]
        );
        return $validator;
    }

    /**
     * method downloadAble
     *
     * @param $userSeq
     * @param $movieContentsId
     * @return boolean
     * @throws Exception
     */
    public function downloadAble($userSeq, $movieContentsId)
    {
        $movieTbl = TableRegistry::get('MovieContents');
        $movieDetails = $movieTbl->getSingleMovieData($userSeq, $movieContentsId);
        if ($movieDetails != null) {
            $regDate = $movieDetails[0]['reg_date']->i18nFormat('YYYY-MM-dd');
            //get new framework date
            $frameworkDate = Configure::read('Common.MovieFileDownloadableDate');
            if (strtotime($regDate) > strtotime($frameworkDate)) {
                return true;
            }
        }
        return false;
    }
}
