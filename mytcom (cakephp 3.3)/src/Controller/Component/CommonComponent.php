<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use App\Validation\NoptBaseValidator;
use Exception;
use Cake\Utility\Security;

/**
 * Common component
 */
class CommonComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var string
     */
    private $userSeq;

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    // 使用するComponentの定義
    public $components = ['LogMessage', 'OpenStatus', 'TargetUser', 'ActionClass'];

    /**
     * URLの末尾に付加する"c=XXX"の文字列を生成する
     *
     * @return string
     */
    public function urlRandString()
    {
        return "c=" . md5(uniqid(rand(), true));
    }

    /**
     * delete open info
     * @param string $userSeq
     * @param array $dataArray
     * @param int $openType
     * @throws exception
     * return void
     */
    public function deleteOpenDataInfo($userSeq, $dataArray, $openType = 2)
    {
        $openId = $dataArray['open_id'];
        $targetUserSeq = $dataArray['target_user_seq'];
        $targetId = isset($dataArray['target_id']) ? $dataArray['target_id'] : null;
        try {
            ConnectionManager::get('default')->transactional(function () use ($openType, $userSeq, $targetId, $openId) {
                $this->deleteOpenDataOpenStatus($userSeq, $openId);
                $this->deleteTargetUserData($userSeq, $openId, $openType, "openScreen");
            });
        } catch (Exception $e) {
            if ($openType == 2) {
                $this->LogMessage->logMessage("12032", $userSeq);
            } elseif ($openType == 4 || $openType == 5) {
                $this->LogMessage->logMessage("12052", $userSeq);
            } else {
                $this->LogMessage->logMessage("12017", $userSeq);
            }
            throw $e;
        }
    }

    /**
     * delete open data (pic = 3, album = 1, folder = 2, 4 = movie folder, 5 = movie)
     *
     * @param array $dataList, $option
     * @return array
     */
    public function deleteOpenStatusData($userSeq, $dataList, $option = 3)
    {
        $openStatusList = array();
        $openStatus = TableRegistry::get('OpenStatus');
        $data_id = 'pic_id';
        if ($option == 1) {
            $data_id = 'album_id';
        } elseif ($option == 2) {
            $data_id = 'file_id';
        } elseif ($option == 4) {
            $data_id = 'movie_folder_id';
        } elseif ($option == 5) {
            $data_id = 'movie_contents_id';
        }
        foreach ($dataList as $item) {
            $openStatusList[] = $item[$data_id];
        }
        $openStatus->deleteAll([
            'user_seq' => $userSeq,
            'target_id IN ' => $openStatusList
        ]);
        return $openStatusList;
    }

    /**
     * delete open data (album = 1, file = 2, pic = 3, folder movies = 4, movie = 5)
     *
     * @param array $openStatusList, $option
     * @return void
     */
    public function deleteTargetUserData($userSeq, $openStatusList, $option, $forOpenScr = "")
    {
        $targetUserList = array();
        $targetUserTbl = TableRegistry::get('TargetUser');
        if ($forOpenScr == "") {
            $openStatusTbl = TableRegistry::get('OpenStatus');
            $openList = $openStatusTbl->getListAllOpenDataOrderByCloseDate($userSeq, $openStatusList, $option);
            if (!empty($openList)) {
                foreach ($openList as $item) {
                    if ($item['open_id']) {
                        $targetUserList[] = $item['open_id'];
                    }
                }
            }
        } else {
            $targetUserList = $openStatusList;
        }
        if (!empty($targetUserList)) {
            $targetUserTbl->deleteAll([
                'user_seq' => $userSeq,
                'open_id IN' => $targetUserList
            ]);
        }
    }

    /**
     * delete open data (movie = 3, file = 1, pic = 2)
     *
     * @param array $data, $option
     * @return void
     */
    public function removeDataFile($data, $option = 1)
    {
        $filePath = 'file_uri';
        $logId = '13018';
        if ($option == 2) {
            $filePath = 'pic_url';
            $logId = '02016';
        } elseif ($option == 3) {
            $filePath = 'movie_contents_url';
            $logId = '10047';
        }
        foreach ($data as $item) {
            if ($this->checkFileExists($item[$filePath], $logId)) {
                unlink($item[$filePath]);
            }
        }
    }

    /**
     * delete open info
     *
     * @param string $userSeq
     * @return boolean true
     */
    public function deleteOpenDataOpenStatus($userSeq, $openId)
    {
        $openStatusTbl = TableRegistry::get('OpenStatus');
        $openStatusTbl->deleteAll([
            'open_id' => $openId,
            'user_seq' => $userSeq
        ]);
        return true;
    }

    /**
     * insert open data
     *
     * @param string $userSeq, $newId
     * @return int $flagResult 0:OK 1:NG
     */
    public function insertOpenData($userSeq, $openflg, $dataPost)
    {
        switch ($openflg) {
            case 1://album
                $targetArray = array($dataPost['album_id']);
                break;
            case 2://file
                $targetArray = $dataPost['selected'];
                break;
            case 3://picture
                $targetArray = $dataPost['pic_open'];
                break;
            case 4://movie folder
                $targetArray = array($dataPost['movie_folder_id']);
                break;
            case 5://movie
                $targetArray = $dataPost['mfile_open'];
                break;
        }
        $newId = $this->createOpenId();
        $this->insertOpenDataOpenStatus($userSeq, $newId, $dataPost, $targetArray, $openflg);
        $this->sendToInviteEmail($dataPost, $newId, $userSeq, $openflg);
        return true;
    }

    /**
     * insert open data open status
     *
     * @param string $userSeq, $newId, $email
     *        array $dataPost
     * @throws Exception
     * @return boolean true
     */
    public function insertOpenDataOpenStatus($userSeq, $newId, $dataPost, $targetArray, $openflg)
    {
        try {
            $openStatusTbl = TableRegistry::get('OpenStatus');
            $openStatusTbl->connection()->transactional(function () use ($openStatusTbl, $dataPost, $userSeq, $newId, $targetArray) {
                foreach ($targetArray as $targetId) {
                    $openStatusEntity = $openStatusTbl->newEntity();
                    $openStatus = $openStatusTbl->patchEntity($openStatusEntity, $dataPost);
                    $openStatus->open_id = $newId;
                    $openStatus->user_seq = $userSeq;
                    $openStatus->open_type = $dataPost['open_flg'];
                    $openStatus->close_date = $this->setEndDateOpen($dataPost['close_date']);
                    $openStatus->close_type = $dataPost['close_date'];
                    $openStatus->download_count = 0;
                    $openStatus->target_id = $targetId;
                    $openStatusTbl->save($openStatus, ['atomic' => false]);
                }

                foreach ($dataPost['mail'] as $value) {
                    preg_match_all("/\<(.*?)\>/", $value, $result);
                    $email = isset($result[1][0]) && $result[1][0] != "" ? $result[1][0] : $value;
                    $this->insertOpenDataTargetUser($userSeq, $newId, $dataPost, $email);
                }
            });
        } catch (Exception $e) {
            //insert fail
            // album/picture
            if ($openflg = 1 || $openflg = 3) {
                $this->LogMessage->logMessage("12003", $userSeq);
                // movie
            } elseif ($openflg = 4 || $openflg = 5) {
                $this->LogMessage->logMessage("12049", $userSeq);
                // file
            } else {
                $this->LogMessage->logMessage("12027", $userSeq);
            }
            throw $e;
        }
        return true;
    }

    /**
     * insert open data target user
     *
     * @param string $userSeq, $newId, $email
     *        array $dataPost
     * @return boolean true
     */
    public function insertOpenDataTargetUser($userSeq, $newId, $dataPost, $email)
    {
        $targetUserTbl = TableRegistry::get('TargetUser');
        $targetUserEntity = $targetUserTbl->newEntity();
        $targetUser = $targetUserTbl->patchEntity($targetUserEntity, $dataPost);
        $targetUser->open_type = $dataPost['open_flg'];
        $targetUser->open_id = $newId;
        $targetUser->user_seq = $userSeq;
        $targetUser->mail = $email;
        $targetUserTbl->connection()->transactional(function () use ($targetUserTbl, $targetUser) {
            $targetUserTbl->save($targetUser, ['atomic' => false]);
        });
        return true;
    }

    /**
     * 新規オープンIDの作成
     *
     * @return int
     */
    public function createOpenId()
    {
        $openStatusTbl = TableRegistry::get('OpenStatus');
        $openId = "";
        do {
            $openId = md5(uniqid(rand(), true));
            $try = $openStatusTbl->checkOpenID($openId);
            if (count($try) == 0) {
                break;
            }
        } while (true);
        return $openId;
    }

    /**
     * send email data open status
     *
     * @param array $dataPost
     * @param string $newId
     * @param string $userSeq
     * @param string $openflg
     * @throws Exception
     * @return boolean true
     */
    public function sendToInviteEmail($dataPost, $newId, $userSeq, $openflg)
    {
        $closeDate = $this->setEndDateDisplay($dataPost['close_date'], null, 'Open');
        $systemConfig = Configure::read('Common.DiskSizeStr');
        $ispName = Configure::read('Common.IspName');
        if ($dataPost['close_date'] != 4) {
            $closeDate = $closeDate . "まで";
        }

        $template = "";
        //get template mail
        switch ($openflg) {
            case 1://album
                $template = env('NOPT_ISP').DS.'album_user_mail';
                $subContent = 'さんからアルバム公開のお知らせです';
                break;
            case 2://file
                $template = env('NOPT_ISP').DS.'file_user_mail';
                $subContent = 'さんからファイル公開のお知らせです';
                break;
            case 3://picture
                $template = env('NOPT_ISP').DS.'album_user_mail';
                $subContent = 'さんからアルバム公開のお知らせです';
                break;
            case 4://movie folder
                $template = env('NOPT_ISP').DS.'movie_user_mail';
                $subContent = 'さんから動画公開のお知らせです';
                break;
            case 5://movie
                $template = env('NOPT_ISP').DS.'movie_user_mail';
                $subContent = 'さんから動画公開のお知らせです';
                break;
        }
        //process send mail
        foreach ($dataPost['mail'] as $value) {
            if ($value != "") {
                $result = '';
                preg_match_all("/\<(.*?)\>/", $value, $result);
                $email = isset($result[1][0]) && $result[1][0] != "" ? $result[1][0] : $value;
                $dataMail = array();
                $dataMail['template'] = $template;
                $dataMail['mail_data'] = array(
                    'nickname' => $dataPost['nickname'],
                    'close_date' => $closeDate,
                    'message' => $dataPost['message'],
                    'open_id' => $newId,
                    'from_mail' => $dataPost['userAddress'],
                    'mail' => $email,
                    'disc_size' => $systemConfig,
                );
                $dataMail['from']['address'] = $dataPost['userAddress'];
                $dataMail['from']['nickname'] = ($dataPost['nickname']) ? $dataPost['nickname'] : $dataPost['userAddress'];
                $dataMail['to'] = $email;
                $dataMail['subject'] = $ispName . $dataPost['nickname'] . $subContent;

                try {
                    $this->ActionClass->sendMailAction($dataMail, "OpenRegist");
                } catch (Exception $e) {
                    $this->LogMessage->logMessage("12036", $userSeq, $dataPost['userAddress']);
                    throw $e;
                }
            }
        }
        return true;
    }

    /**
     * Validate open regist input data
     * @param   open regist  data
     * @return boolean true-is valid ; object $errors -not valid
     */
    public function validate($data)
    {
        if (empty($data['mail'])) {
            // if mail data is null
            $data['mail'] = array();
        } elseif (!is_array($data['mail'])) {
            // In case of smartphone, mail data is string type
            // In order to validate it, convert data to array
            $data['mail'] = explode(',', $data['mail']);
        }
        $validator = $this->validationDefault(new NoptBaseValidator());
        //ネストされたバリデータからのエラーを含むすべてのエラーを取得する
        $arr = $data;
        $arr['bypass'] = ['nickname' => true, 'message' => true, 'mail' => true];
        $errors = $validator->errors($arr);
        if (!empty($errors)) {
            return $errors;
        }
        return true;
    }

    /**
     * Validate input
     * @param Validator $validator
     * @return Validator
     */
    private function validationDefault(NoptBaseValidator $validator)
    {
        $this->userSeq = $this->request->session()->read('UserData.user_seq');
        $validator->allowEmpty('nickname');
        $validator->add(
            'nickname', 'noValue', ['rule' => function ($nickname) {
                if (mb_strlen(trim($nickname), 'utf-8') == 0) {
                    $this->LogMessage->logMessage("12004", $this->userSeq);
                    return false;
                }
                return true;
            },
                'message' => 'ニックネームが入力されていません｡',
            ]
        );

        $validator->add(
            'nickname', 'noSpaces', ['rule' => function ($nickname) {
                if (mb_strlen($nickname) > 0 && mb_strlen(trim($nickname), 'utf-8') == 0) {
                    $this->LogMessage->logMessage("12044", $this->userSeq);
                    return false;
                }
                return true;
            },
                'message' => '半角スペースのみの登録はできません。',
            ]
        );

        $validator->add(
            'nickname', 'maxLength', ['rule' => function ($nickname) {
                if (mb_strlen($nickname, 'utf-8') > 25) {
                    $this->LogMessage->logMessage("12005", $this->userSeq);
                    return false;
                }
                return true;
            },
                'message' => 'ニックネームには25文字以内で入力してください｡',
            ]
        );

        $validator->allowEmpty('message');
        $validator->add(
            'message', 'noValue', ['rule' => function ($message) {
                if (mb_strlen(trim($message), 'utf-8') == 0) {
                    $this->LogMessage->logMessage("12006", $this->userSeq);
                    return false;
                }
                return true;
            },
                'message' => 'メッセージが入力されていません｡',
            ]
        );

        $validator->add(
            'message', 'noSpaces', ['rule' => function ($message) {
                if (mb_strlen($message) > 0 && mb_strlen(trim($message), 'utf-8') == 0) {
                    $this->LogMessage->logMessage("12045", $this->userSeq);
                    return false;
                }
                return true;
            },
                'message' => '半角スペースのみの登録はできません。',
            ]
        );

        $validator->add(
            'message',
            'maxLength',
            ['rule' => function ($message) {
                if ($this->getStrlenNoNewline($message) > 125) {
                        $this->LogMessage->logMessage("12007", $this->userSeq);
                        return false;
                }
                return true;
            },
                'message' => 'メッセージには125文字以内で入力してください。',
            ]
        );

        $validator->allowEmpty('mail');
        $validator->add(
            'mail', 'noValue', ['rule' => function ($mail) {
                if (count($mail) == 0) {
                    $this->LogMessage->logMessage("12008", $this->userSeq);
                    return false;
                }
                return true;
            },
                'message' => 'メールアドレスを入力してください｡',
            ]
        );

        $validator->add(
            'mail', 'checkFormat', ['rule' => [$this, "checkMailData"],
                'last' => true,
                'message' => '不正なメールアドレスが入力されています。'
            ]
        );

        $validator->add(
            'mail', 'maxNumber', ['rule' => function ($mail) {
                if (count($mail) > 10) {
                    $this->LogMessage->logMessage("12010", $this->userSeq);
                    return false;
                }
                return true;
            },
                'message' => '追加できるアドレスは10件までです。',
            ]
        );
        return $validator;
    }

    /**
     * Valid email data
     *
     * @return boolean : true : mail check true - false : mail check fail
     */
    public function checkMailData($mailArray)
    {
        $error = null;
        for ($i = 0; $i < count($mailArray); $i++) {
            if ($mailArray[$i] != "") {
                preg_match_all("/\<(.*?)\>/", $mailArray[$i], $result);
                if (isset($result[1][0]) && $result[1][0] != "") {
                    $email = $result[1][0];
                } else {
                    $email = $mailArray[$i];
                }
                if ($email != "") {
                    if (!preg_match('/^[a-zA-Z0-9\._-]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/', $email)) {
                        $error[] = $mailArray[$i];
                    }
                }
            }
        }
        if (!empty($error)) {
            $userSeq = $this->request->session()->read('UserData.user_seq');
            $this->LogMessage->logMessage("12009", $userSeq);
            return false;
        } else {
            return true;
        }
    }

    /**
     * Create end date string to display for user
     * @param int/string $closeDate
     * @param any $type
     * @param any $optional
     * @return value: end date string
     */
    public function setEndDateDisplay($closeDate, $type = null, $optional = null)
    {
        if ($closeDate == 4) {
            return "無期限";
        }
        if ($type == null) {
            $string = $this->setEndDateOpen($closeDate);
        } else {
            $string = $closeDate;
        }
        $dayArray = array();
        $dayArray[0] = "(日)";
        $dayArray[1] = "(月)";
        $dayArray[2] = "(火)";
        $dayArray[3] = "(水)";
        $dayArray[4] = "(木)";
        $dayArray[5] = "(金)";
        $dayArray[6] = "(土)";
        $list = str_split($string, 10);
        $stringDate = explode("-", $list[0]);
        $stringTime = explode(":", $list[1]);
        $dayName = date("w", mktime(0, 0, 0, intval($stringDate[1]), intval($stringDate[2]), intval($stringDate[0])));
        $value = '';
        if (empty($optional)) {
            $value = $stringDate[0] . "年" . $stringDate[1] . "月" . $stringDate[2] . "日" . $dayArray[$dayName] . $stringTime[0] . "時" . $stringTime[1] . "分";
        } else {
            $value = $stringDate[0] . "年" . $stringDate[1] . "月" . $stringDate[2] . "日" . $dayArray[$dayName];
        }
        return $value;
    }

    /**
     * Create end date string to insert into database
     *
     * @return value: end date string
     */
    public function setEndDateOpen($targetNum)
    {
        $closeDate = "";
        switch ($targetNum) {
            case 1:
                $closeDate = date("Y-m-d 23:59:59", strtotime("+1 month"));
                break;
            case 2:
                $closeDate = date("Y-m-d 23:59:59", strtotime("+2 week"));
                break;
            case 3:
                $closeDate = date("Y-m-d 23:59:59", strtotime("+1 week"));
                break;
            case 4:
                $closeDate = date("Y-m-d 23:59:59", mktime(23, 59, 59, 12, 31, 2037));
                break;
        }
        return $closeDate;
    }

    /**
     * method getDeviceTypeUserAgent
     *
     * @param string $agent
     * @return int 1:PC,2:iPhone,3:android
     */
    public function getDeviceTypeUserAgent($agent)
    {
        if ($this->_isIphone($agent)) {
            return 2;
        } elseif ($this->_isAndroid($agent)) {
            return 3;
        } else {
            return 1;
        }
    }

    /**
     * method getDeviceTypeExHeader
     *
     * @param int $header
     * @return int 1:PC,2:iPhone,3:android
     */
    public function getDeviceTypeExHeader($header)
    {
        if ($header == 2) {
            return 2;
        } elseif ($header == 3) {
            return 3;
        } else {
            return 1;
        }
    }

    /**
     * アクセス端末がiPhoneであるかチェックする
     *
     * @return boolean
     */
    private function _isIphone($agent)
    {
        // アクセス端末がiPhone系であればtrueを返す
        foreach (Configure::read('Common.UserAgentList.Iphone') as $value) {
            if (stripos($agent, $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * アクセス端末がAndroidであるかチェックする
     *
     * @return boolean
     */
    private function _isAndroid($agent)
    {
        // アクセス端末がAndroid系であればtrueを返す
        foreach (Configure::read('Common.UserAgentList.Android') as $value) {
            if (stripos($agent, $value)) {
                return true;
            }
        }
        return false;
    }

    /**
     * read file content
     * @param string $fileName
     * @return contents
     */
    public function readTargetFileContents($fileName)
    {
        $handle = fopen($fileName, "rb");
        $contents = fread($handle, filesize($fileName));
        fclose($handle);
        return $contents;
    }

    /**
     * content-descriptionに設定するファイル名をブラウザに応じたエンコーディングで返す
     * @param string $fileName
     * @return string エンコードしたファイル名
     */
    public function encodeFileName($fileName)
    {
        $ua = env('HTTP_USER_AGENT');
        // IEの場合はsjis-win, それ以外はUTF-8
        if ($this->isIE($ua)) {
            return mb_convert_encoding($fileName, "SJIS-win", "UTF-8");
        } else {
            return $fileName;
        }
    }

    public function isIE($userAgent)
    {
        return strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false || strpos($userAgent, 'Edge') !== false;
    }

    /**
     * read file size
     * @param string $userSeq
     * @return file size
     */
    public function getFileSize($userSeq)
    {
        $totalFileSize = 0;
        $fileTbl = TableRegistry::get('FileTbl');
        $sizeList = $fileTbl->getTotalFileSize($userSeq);
        if (!empty($sizeList)) {
            foreach ($sizeList as $item) {
                $totalFileSize += $item;
            }
        }
        return $totalFileSize;
    }

    /**
     * read pic size
     * @param string $userSeq
     * @return pic size
     */
    public function getPicSize($userSeq)
    {
        $totalPicSize = 0;
        $picTbl = TableRegistry::get('PicTbl');
        $sizeList = $picTbl->getTotalPicSize($userSeq);
        if (!empty($sizeList)) {
            foreach ($sizeList as $item) {
                $totalPicSize += $item;
            }
        }
        return $totalPicSize;
    }

    /**
     * read movie size
     * @param string $userSeq
     * @return movie size
     */
    public function getMovieSize($userSeq)
    {
        $totalMovieSize = 0;
        $movieTbl = TableRegistry::get('MovieContents');
        $sizeList = $movieTbl->getTotalMoviesSize($userSeq);
        if (!empty($sizeList)) {
            foreach ($sizeList as $item) {
                $totalMovieSize += $item;
            }
        }
        return $totalMovieSize;
    }

    /**
     * read total used size
     * @param string $userSeq
     * @return total used size
     */
    public function getUsedSize($userSeq)
    {
        $fileSize = $this->getFileSize($userSeq);
        $picSize = $this->getPicSize($userSeq);
        $movieSize = $this->getMovieSize($userSeq);
        $total = $fileSize + $picSize + $movieSize;
        return $total;
    }

    /**
     * user_seqより対象ユーザのフォルダ情報を取得する
     *
     * @param string $userSeq
     * @param string $sort
     * @return int
     */
    public function getFolderStorageInfo($userSeq, $dels, $sort = null)
    {
        // 他Model情報取得
        $fileFolderTbl = TableRegistry::get('FileFolderTbl');
        $fileTbl = TableRegistry::get('FileTbl');
        $openStatus = TableRegistry::get('OpenStatus');

        //ソート順を設定
        if ($sort == 'new') {
            $sortStr = 'DESC';
        } else {
            $sortStr = 'ASC';
        }

        if (count($dels)) {
            $folderList[] = $fileFolderTbl->getFolderListByTarget($userSeq, $dels, $sortStr);
        } else {
            // フォルダ一覧取得
            $folderList[] = $fileFolderTbl->getFolderListOrder($userSeq, $sortStr);
        }
        //debug($folderList);
        // 各フォルダに対する情報を取得
        $folderList = $folderList[0];
        for ($i = 0; $i < count($folderList); $i++) {
            $folderList[$i]['openstatus'] = 0;
            // ファイル数取得
            $folderList[$i]['count'] = $fileTbl->getFolderCountFile($userSeq, $folderList[$i]['file_folder_id']);
            // フォルダ総容量確認
            $amount = $fileTbl->getFolderAmount($userSeq, $folderList[$i]['file_folder_id']);
            // 合計値を取得できた場合はその値を設定し取得できない場合は0を設定する
            if ($amount[0]['sum']) {
                $folderList[$i]['amount'] = $amount[0]['sum'];
            } else {
                $folderList[$i]['amount'] = 0;
            }

            // 公開状態取得
            $fileList = $fileTbl->getFolderData($userSeq, $folderList[$i]['file_folder_id']);
            foreach ($fileList as $item) {
                if (isset($item['file_id'])) {
                    $fileIds[] = $item['file_id'];
                }
            }
            if (isset($fileIds)) {
                $result = $openStatus->getListAllOpenDataOrderByCloseDate($userSeq, $fileIds, 2);
            }
            if (count($fileList > 0)) {
                for ($j = 0; $j < count($fileList); $j++) {
                    foreach ($result as $item) {
                        if ($item['target_id'] == $fileList[$j]['file_id']) {
                            $folderList[$i]['openstatus'] = 1;
                        }
                    }
                }
            }
        }
        return $folderList;
    }

    /**
     * method fixFormatId
     *
     * @param string $id
     * @return string
     */
    public function fixFormatId($id)
    {
        return str_pad($id, 10, '0', STR_PAD_LEFT);
    }

    /**
     * check file exists and log message
     *
     * @param $fileName
     * @param $idLog (picture, file,movie)
     * @return bool
     */
    public function checkFileExists($fileName, $idLog = null)
    {
        if (!file_exists($fileName)) {
            if ($idLog == "13003" || $idLog  == "02005" || $idLog  == "10005") {
                $this->LogMessage->logMessage($idLog, array($this->request->session()->read('UserData.user_seq'), $fileName));
            } else {
                $this->LogMessage->logMessage($idLog, array($this->request->session()->read('UserData.user_seq')));
            }
            return false;
        }
        return true;
    }

    /**
     * Get page number
     *
     * @param string $getRequest
     * @return int $pageNum
     */
    public function getPageNum($getRequest)
    {
        if (isset($getRequest) && preg_match("/^(?!0+$)\d+$/", $getRequest)) {
            $pageNum = intval($getRequest);
        } else {
            $pageNum = null;
        }
        return $pageNum;
    }

    /**
     * Go to previous url
     *
     * @return string
     */
    public function getPreviousUrl()
    {
        if ($this->request->env('HTTP_REFERER')) {
            $httpRefer = $this->request->env('HTTP_REFERER');
            $requestUri = strtok($this->request->here(), '?');
            
            if ($httpRefer != $this->request->session()->read('previousUrl') && $requestUri != $this->request->session()->read('requestUri')) {
                $this->request->session()->write('requestUri', $requestUri);
                $this->request->session()->write('previousUrl', $httpRefer);
            }
        }
        return $this->request->session()->read('previousUrl');
    }

    /**
     * 文字列から改行を除いた文字数を返却する。
     * @param $string 改行を除いた文字数を取得したい文字列
     * @return int 改行を除いた引数の文字列の文字数
     */
    public function getStrlenNoNewline($string)
    {
        return mb_strlen(preg_replace(array('/\r|\n/'), '', $string), 'utf-8');
    }

    /**
     * method umaskMkdir
     * @param $pathname
     * @param $mode
     */
    public function umaskMkdir($pathname, $mode)
    {
        //umaskを0002から0000に変更する。
        $oldUmask = umask(0);
        if (!is_dir($pathname)) {
            mkdir($pathname, $mode, true);
        }
        //ねんのため、元のumaskに戻す。
        umask($oldUmask);
    }

    /**
     * ファイルの権限を付与する
     * @param string $filename
     * @param int $mode
     */
    public function umaskChmod($filepath, $mode)
    {
        //umaskを0002から0000に変更する。
        $oldUmask = umask(0);
        if (file_exists($filepath)) {
            chmod($filepath, $mode);
        }
        //ねんのため、元のumaskに戻す。
        umask($oldUmask);
    }

    /**
     * チェックリファラー
     *
     * */
    public function checkReferer()
    {
        //運用ドメイン以外からのアクセスは無効とする。リファラーの参照を行う。

        //リファラーがセットされているか確認する。セットされていない場合がエラーとする。
        if (!isset($_SERVER['HTTP_REFERER'])) {
            return false;
        } else {
            $referer_server = parse_url($_SERVER['HTTP_REFERER']);
            $work_domain = Configure::read('Common.Domain');
            $work_domain2 = Configure::read('Common.CheckDomain');
            if ($referer_server['host'] != $work_domain && $referer_server['host'] != $work_domain2) {
                return false;
            }
            return true;
        }
    }

    /**
     * iPhone5対策：Cookieが空となるためURLにGETパラメータで設定
     * セキュリティ施策として毎回ユニークとなるキャッシュ値を使い暗号化。
     *
     * @param string $key
     * @return string $umovkey
     * */

    public function iphone5encrypt($userSeq){
        $key = Configure::read('Common.SiteSetting.KEY');
        $salt = Configure::read('Common.SiteSetting.SALT');
        $umovkey = $this->base64_encode_urlsafe(Security::encrypt($userSeq, $key, $salt));
        return $umovkey;
    }

    function base64_encode_urlsafe($s)
    {
        $s = base64_encode($s);
        return (str_replace(array('+', '=', '/'), array('_', '-', '.'), $s));
    }
}
