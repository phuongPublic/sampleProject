<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * MFolderList Controller
 *
 * @property \App\Model\Table\MovieRegistTable $MovieRegist
 */
class MovieRegistController extends AppController
{

    private $menuNowFlg;
    // 使用するComponentの定義
    public $components = ['Common', 'UserMst', 'Movie', 'MovieFolder', 'PageControl', 'OpenStatus', 'LogMessage', 'FileUpload'];

    /**
     * クラス初期化処理用メソッド
     *
     */
    public function initialize()
    {
        parent::initialize();

        // ファイル管理を選択状態とする。
        $this->menuNowFlg = 6;
        $this->set('menu_now_flg', $this->menuNowFlg);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        //運用ドメイン以外からのアクセスは無効とする。
        if(!$this->Common->checkReferer()){
            return false;
        }
        //message session
        $this->set('message', $this->request->session()->consume('message'));

        //handling foreach device
        if ($this->deviceTypeId == 1) {
            $this->pc();
        } else {
            $this->smartPhone();
        }
    }

    /**
     * pc method
     * process if user agent is pc
     * @return \Cake\Network\Response|null
     */
    private function pc()
    {
        $movieTbl = TableRegistry::get('MovieContents');
        if ($this->request->is('post')) {
            //log message start regist movie
            $this->LogMessage->logMessage('10011', $this->userInfo['user_seq']);
            //set session data, use for fail case
            $formData = ['title' => $this->request->data('title'), 'description' => $this->request->data('description')];
            $this->request->session()->write('formData', $formData);
            // ディレクトリトラバーサル対策
            $isTraversal = $this->checkTraversal();
            if ($isTraversal) {
                $this->request->session()->write('message', '動画のアップロードに失敗しました。');
                return $this->redirect('/movie/contents/regist.html?mid=' . $this->request->data['movie_folder_id']);
            }

            //get used size
            $movieSize = $this->UserMst->checkFileSize($this->userInfo['user_seq'], 'movie');
            $totalSize = $this->UserMst->getUserDataSize($this->userInfo['user_seq']);
            //upload path
            $this->FileUpload->setUpload('movie', Configure::read('Common'), $this->userInfo);
            $newId = $movieTbl->selectNextId($this->userInfo['user_seq']);
            $targetPath = Configure::read('Common.Upload') . Configure::read('Common.BaseMovie') . $this->userInfo['user_seq'] . '/temp/' . $this->Common->fixFormatId($newId);
            if (empty($this->request->data('movie_folder_id'))) {
                $this->request->session()->write('message', 'フォルダが指定されていません。');
                $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            }
            //check movie folder exists
            $movieFolderTbl = TableRegistry::get('MovieFolder');
            $folder = $movieFolderTbl->getSingleMovieFolderData($this->userInfo['user_seq'], $this->request->data['movie_folder_id']);
            if (empty($folder)) {
                $this->LogMessage->logMessage('10090', $this->userInfo['user_seq']);
                $this->request->session()->write('message', '登録先の動画フォルダが存在しません。');
                $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            }
            if (empty($this->request->data('fileId'))) {
                //log no file choosen
                $this->LogMessage->logMessage('10006', $this->userInfo['user_seq']);
                $this->request->session()->write('message', '動画を選択してください。');
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            }
            $uploadSize = 0;
            $tempFile = '';
            if (isset($this->request->data['fileId'])) {
                $tempFile = Configure::read('Common.Upload') . Configure::read('Common.BaseMovie') . $this->userInfo['user_seq'] . '/temp/' . $this->request->data['fileId'];
                if (file_exists($tempFile)) {
                    $uploadSize = filesize($tempFile);
                }
            }
            //check total upload size
            if ($uploadSize > Configure::read('Common.UploadMaxMovie')) {
                $size = Configure::read('Common');
                $this->request->session()->write('message', 'ファイルサイズが' . $size['UploadMaxMovieStr'] . 'を超えています。合計サイズを' . $size['UploadMaxMovieStr'] . '以下にしてください。');
                $this->LogMessage->logMessage('10001', array(Configure::read('Common.UploadMaxMovieStr'), $this->userInfo['user_seq']));
                $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            }
            if ($uploadSize + $totalSize > Configure::read('Common.DiskSize')) {
                //log for size over 50 GB
                $this->LogMessage->logMessage('10004', $this->userInfo['user_seq']);
                $this->request->session()->write('message', '使用量の合計が' . Configure::read('Common.DiskSizeStr') . 'を超えるため登録できません。');
                $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            }

            //check title if include path
            $checkTitle = preg_match('/(\.\.\/|\/|\.\.\\\\)/', $this->request->data['title']) ? true : false;
            $checkFileName = preg_match('/(\.\.\/|\/|\.\.\\\\)/', $this->request->data['fileName']) ? true : false;
            if ($checkTitle) {
                $this->request->session()->write('message', 'ファイル名が不正です。');
                $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            } elseif ($checkFileName) {
                $this->request->session()->write('message', 'ファイル名が不正です。');
                $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            } elseif (mb_strlen($this->request->data['title']) > 125) {
                //log title or file name length more than 125 character
                $this->LogMessage->logMessage('10040', $this->userInfo['user_seq']);
                $this->request->session()->write('message', '動画タイトルには125文字以内で入力してください。');
                $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            } elseif ($this->Common->getStrlenNoNewline($this->request->data['description']) > 1000) {
                //log comment length more than 1000 character
                $this->LogMessage->logMessage('10038', $this->userInfo['user_seq']);
                $this->request->session()->write('message', 'コメントには1000文字以内で入力してください。');
                $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            } elseif (mb_strlen(trim($this->request->data['title'])) == 0) {
                $this->LogMessage->logMessage('10039', $this->userInfo['user_seq']);
                $this->request->session()->write('message', '動画タイトルが入力されませんでした。');
                $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            }
            preg_match("/^(.+?)\.([0-9a-zA-Z]+)$/", $this->request->data['fileName'], $matches);
            //if a file don't have extension $matches[2] is not set
            if (isset($matches[2])) {
                $ext = $matches[2];
                $pregString = "/^(" . Configure::read('Movie.SupportExt') . ")$/i";
                if (preg_match($pregString, $ext) <= 0) {
                    $this->LogMessage->logMessage('10002', $this->userInfo['user_seq']);
                    $this->request->session()->write('message', '動画の登録に失敗しました。');
                    $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                    return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
                }
            } else {
                $this->LogMessage->logMessage('10002', $this->userInfo['user_seq']);
                $this->request->session()->write('message', '動画の登録に失敗しました。');
                $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data('fileId'));
                return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
            }

            //insert and rename movie file if correct
            if (isset($this->request->data['fileId'])) {
                if ($this->Common->checkFileExists($tempFile, '10005')) {
                    $isOk = false;
                    for ($j = 0; $j < 3; $j++) {
                        if (!$isOk) {
                            $newId = $movieTbl->selectNextId($this->userInfo['user_seq']);
                            $movie = $movieTbl->getSingleMovieData($this->userInfo['user_seq'], $newId);
                            if (!empty($movie)) {
                                $this->LogMessage->logMessage("10086", array($this->userInfo['user_seq'], $j + 1));
                            }
                            $folderId = $this->request->data['movie_folder_id'];
                            $title = $this->request->data['title'];
                            $comment = $this->request->data['description'];
                            if(is_array($folderId)) {
                                $folderId = "";
                            }
                            if(is_array($title)) {
                                $title = " ";
                            }
                            if(is_array($comment)) {
                                $comment = "";
                            }
                            //Create file information for registration
                            $data = [
                                'movie_folder_id' => $folderId,
                                'extension' => $ext,
                                'amount' => filesize($tempFile),
                                'movie_contents_name' => $title . '.' . $ext,
                                'name' => $title,
                                'movie_contents_comment' => $comment
                            ];
                            $insertResult = $this->Movie->save($newId, $this->userInfo['user_seq'], $data);
                            $isOk = $insertResult;
                            $newFile = $targetPath . '/encode_movie/original/encoding_movie';
                            if ($isOk) {
                                $result = rename($tempFile, $newFile);
                                chmod($newFile, 0777);
                                if (!$result) {
                                    $this->LogMessage->logMessage("10010", $this->userInfo['user_seq']);
                                    $this->request->session()->write('message', '動画の登録に失敗しました。');
                                    return $this->redirect('/movie/contents/regist.html?' . $this->cashe);
                                }
                                break;
                            }
                        }
                        if ($j == 2 && !$isOk) {
                            $this->request->session()->write('message', "動画の登録に失敗しました。");
                        }
                    }
                    if (!$isOk) {
                        $this->LogMessage->logMessage("10010", $this->userInfo['user_seq']);
                        $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $this->request->data['fileId']);
                        $this->request->session()->write('message', '動画の登録に失敗しました。');
                        return $this->redirect('/movie/preview.html?mid=' . $this->request->data['movie_folder_id']);
                    }
                } else {
                    $this->request->session()->write('message', '動画の登録に失敗しました。');
                    return $this->redirect('/movie/preview.html?mid=' . $this->request->data['movie_folder_id'] . '&' . $this->cashe);
                }
            }

            //update movie size
            $this->UserMst->updateUsedFileSize('album', $this->userInfo['user_seq'], $uploadSize + $movieSize);

            // log message end regist movie
            $this->request->session()->delete('formData');
            $this->LogMessage->logMessage("10012", $this->userInfo['user_seq']);
            $this->request->session()->write('message', sprintf(Configure::read('Common.regist'), '動画'));
            return $this->redirect('/movie/preview.html?mid=' . $this->request->data['movie_folder_id'] . '&' . $this->cashe);
        }

        $movieFolderTbl = TableRegistry::get('MovieFolder');
        $folderNameList = $movieFolderTbl->getMovieFolderName($this->userInfo['user_seq']);

        //get movie folder list
        $movieFolderList = $this->MovieFolder->getAllMovieFolderData($this->userInfo['user_seq']);
        $this->set('movieFolderList', $movieFolderList);

        $uploadConfig = Configure::read('Common');
        $this->set('base', $uploadConfig);

        if ($this->request->query('mid')) {
            $mid = $this->request->query('mid');
        } elseif ($this->request->data('mid')) {
            $mid = $this->request->data('mid');
        } else {
            $mid = null;
        }
        $this->set('mid', $mid);
        $this->set('data', $this->request->data);
        $this->set('folderNameList', $folderNameList);
        if (!(preg_match("/regist/isx", $this->previousUrl) && preg_match("/contents/isx", $this->previousUrl))) {
            $this->request->session()->write('backUrl', $this->previousUrl);
        }
        if (preg_match("/regist/isx", $this->previousUrl) && preg_match("/contents/isx", $this->previousUrl)) {
            $this->set('previousUrl', $this->request->session()->read('backUrl'));
        } else {
            $this->set('previousUrl', $this->previousUrl);
        }
        $this->set('userDataSize', $this->UserMst->getUserDataSize($this->userInfo['user_seq']));
        $formData = $this->request->session()->consume('formData');
        $this->set('formData', $formData);
    }

    private function smartPhone()
    {
        if (isset($this->request->data['fileInput']) && !empty($this->request->data['fileInput']['tmp_name'])) {
            // log message start regist video
            $this->LogMessage->logMessage('10011', $this->userInfo['user_seq']);
            $type = 'movie';
            $uploadConfig = Configure::read('Common');
            // init upload file
            $this->FileUpload->setUpload($type, $uploadConfig, $this->userInfo);
            $fileInput = $this->request->data('fileInput');

            //$check file upload
            $checkFileUpload = $this->FileUpload->checkFileInput($fileInput);
            if ($checkFileUpload) {
                $checkFileSize = $this->FileUpload->checkFileSize($fileInput, $uploadConfig, $type);
                $checkFileType = $this->FileUpload->checkFileType($fileInput, $type);
                //check file name > 125
                if (mb_strlen($fileInput['name']) > 125) {
                    //log title or file name length more than 125 character
                    $this->LogMessage->logMessage('10040', $this->userInfo['user_seq']);
                    $this->request->session()->write('message', '動画のタイトルは125文字以内で入力してください。');
                    $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $fileInput['tmp_name']);
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['movie_folder_id']);
                }
                if (!$checkFileSize && !$checkFileType) {
                    $this->LogMessage->logMessage('10003', array(Configure::read('Common.UploadMaxMovieStr'), $this->userInfo['user_seq']));
                    $this->request->session()->write('message', '動画の登録に失敗しました。(サイズが' . $uploadConfig['UploadMaxMovieStr'] . 'を超えています。形式が3gp,3gpp2,amc,avi,mov,mpeg1,mpeg2,mpeg4,wmv,flv以外です。)');
                    $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $fileInput['tmp_name']);
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['movie_folder_id']);
                } elseif (!$checkFileSize) {
                    $this->LogMessage->logMessage('10001', array(Configure::read('Common.UploadMaxMovieStr'), $this->userInfo['user_seq']));
                    $this->request->session()->write('message', '動画の登録に失敗しました。(サイズが' . $uploadConfig['UploadMaxMovieStr'] . 'を超えています。)');
                    $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $fileInput['tmp_name']);
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['movie_folder_id']);
                } elseif (!$checkFileType) {
                    //image extension
                    $this->LogMessage->logMessage('10002', $this->userInfo['user_seq']);
                    $this->request->session()->write('message', '動画の登録に失敗しました。(形式が3gp,3gpp2,amc,avi,mov,mpeg1,mpeg2,mpeg4,wmv,flv以外です。) ');
                    $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $fileInput['tmp_name']);
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['movie_folder_id']);
                }

                //check space disk
                $sysConfig = Configure::read('Common');
                $diskTotal = $sysConfig['DiskSize'];
                $userDataSize = $this->UserMst->getUserDataSize($this->userInfo['user_seq']);
                $checkSpaceDisk = $this->FileUpload->checkSpaceDisk($fileInput, $diskTotal, $userDataSize);
                if (!$checkSpaceDisk) {
                    $this->LogMessage->logMessage('10004', $this->userInfo['user_seq']);
                    $this->request->session()->write('message', '動画の登録に失敗しました。(空き容量が不足しております。)');
                    $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $fileInput['tmp_name']);
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['movie_folder_id']);
                }
                //check movie folder target exist
                $movieFolderTbl = TableRegistry::get('MovieFolder');
                $folder = $movieFolderTbl->getSingleMovieFolderData($this->userInfo['user_seq'], $this->request->data['movie_folder_id']);
                if (empty($folder)) {
                    $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $fileInput['tmp_name']);
                    $this->LogMessage->logMessage('10090', $this->userInfo['user_seq']);
                    $this->request->session()->write('message', '登録先の動画フォルダが存在しません。');
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                }
                $isOk = false;
                $movieTbl = TableRegistry::get('MovieContents');
                for ($i = 0; $i < 3; $i++) {
                    if (!$isOk) {
                        $newId = $movieTbl->selectNextId($this->userInfo['user_seq']);
                        $movie = $movieTbl->getSingleMovieData($this->userInfo['user_seq'], $newId);
                        if (!empty($movie)) {
                            $this->LogMessage->logMessage("10086", array($this->userInfo['user_seq'], $i + 1));
                        } else {
                            //upload file
                            $targetPath = Configure::read('Common.Upload') . Configure::read('Common.BaseMovie') . $this->userInfo['user_seq'] . '/temp/' . $this->Common->fixFormatId($newId);
                            $currentFile = $fileInput['tmp_name'];
                            $savingFile = $targetPath . '/encode_movie/original/encoding_movie';
                            if ($this->Common->checkFileExists($currentFile, '10005')) {
                                $title = $fileInput['name'];
                                $nameHead = mb_substr($title, 0, strripos($title, '.'));
                                $ext = mb_substr(strrchr($title, '.'), 1);
                                $folderId = $this->request->data['movie_folder_id'];
                                if(is_array($folderId)) {
                                    $folderId = "";
                                }
                                // regist data
                                $data = [
                                    'movie_folder_id' => $folderId,
                                    'extension' => $ext,
                                    'amount' => filesize($currentFile),
                                    'movie_contents_name' => $title,
                                    'name' => $nameHead,
                                    'movie_contents_comment' => '',
                                ];
                                //redirect if not have permission write directory
                                if (is_dir(dirname($targetPath)) && !is_writable(dirname($targetPath))) {
                                    $this->LogMessage->logMessage('10005', array($this->userInfo['user_seq'], $savingFile));
                                    $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $fileInput['name']);
                                    $this->request->session()->write('message', '動画の登録に失敗しました。');
                                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['movie_folder_id']);
                                }
                                $insertResult = $this->Movie->save($newId, $this->userInfo['user_seq'], $data);
                                $isOk = $insertResult;
                                if ($isOk) {
                                    move_uploaded_file($currentFile, $savingFile);
                                    chmod($savingFile, 0777);
                                }
                            } else {
                                $this->request->session()->write('message', '動画の登録に失敗しました。');
                            }
                        }
                    }
                    if ($i == 2 && !$isOk) {
                        $this->request->session()->write('message', "動画の登録に失敗しました。");
                    }
                }
                if (!$isOk) {
                    $this->LogMessage->logMessage('10010', $this->userInfo['user_seq']);
                    $this->FileUpload->DeleteUploadFile($this->userInfo['user_seq'], $fileInput['name']);
                    $this->request->session()->write('message', '動画の登録に失敗しました。');
                    return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['movie_folder_id']);
                }
                // log message end regist movie
                $this->LogMessage->logMessage("10012", $this->userInfo['user_seq']);
                $this->request->session()->write('message', sprintf(Configure::read('Common.regist'), '動画'));
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['movie_folder_id']);
            }
        } else {
            $this->request->session()->write('message', '動画が選択されませんでした。');
            //log message for no file uploaded
            $this->LogMessage->logMessage('10006', $this->userInfo['user_seq']);
            return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['movie_folder_id']);
        }
    }

    /**
     * ディレクトリトラバーサル攻撃をチェックする
     * @return true:トラバーサル攻撃あり false:トラバーサル攻撃なし
     */
    private function checkTraversal()
    {
        $isTraversal = false;
        if (isset($this->request->data['fileId'])) {
            if (!preg_match('/^o_[a-z0-9]+$/', $this->request->data['fileId'])) {
                $isTraversal = true;
            }
        }
        return $isTraversal;
    }
}
