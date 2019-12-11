<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * MFolderPreview Controller
 *
 * @property \App\Model\Table\MFolderPreviewTable $MFolderPreview
 */
class MFolderPreviewController extends AppController
{

    public $components = ['LogMessage', 'Common', 'UserMst', 'Movie', 'MovieFolder', 'PageControl', 'OpenStatus'];
    // 使用するComponentの定義
    private $menuNowFlg;

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
        //message session
        $this->set('message', $this->request->session()->consume('message'));

        //handling foreach device
        if ($this->deviceTypeId == 1) {
            $this->pc();
        } else {
            $this->smartPhone();
        }
    }

    private function pc()
    {
        $mid = '';
        $mlscr = isset($this->request->query['ml']) ? 1 : 0;
        $this->set('mlscr', $mlscr);

        if ($this->request->is('get') && $this->request->query('mid')) {
            $mid = $this->request->query['mid'];
        } elseif ($this->request->is('post') && !empty($this->request->data['mid'])) {
            $mid = $this->request->data['mid'];
        }
        //check movie folder exists
        if (!empty($mid)) {
            $folderTbl = TableRegistry::get('MovieFolder');
            $folder = $folderTbl->getSingleMovieFolderData($this->userInfo['user_seq'], $mid);
            if (empty($folder)) {
                $this->LogMessage->logMessage('10083', $this->userInfo['user_seq']);
                $this->request->session()->write('message', '動画フォルダが存在しません。');
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
            }
        }
        //delete movie
        if ($this->request->is('post') && !empty($this->request->data['deletefile'])) {
            if (empty($this->request->data['del'])) {
			    $this->LogMessage->logMessage('10029', $this->userInfo['user_seq']);
                $this->request->session()->write('message', '動画が選択されていません。');
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $mid . '&' . $this->cashe);
            } else {
                $this->request->session()->write('movie_delete', $this->request->data);
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/contents/delete.html?' . $this->cashe);
            }
        }

        //Movement processing
        if ($this->request->is('post') && isset($this->request->data['remove']) && $this->request->data['remove'] == 1) {
            if (isset($this->request->data['del']) && count($this->request->data['del']) > 0) {
                for ($i = 0; $i < count($this->request->data['del']); $i++) {
				    //log moving movie is start
                    $this->LogMessage->logMessage('10030', $this->userInfo['user_seq']);
                    $result = $this->Movie->moveContentsFolderData($this->userInfo['user_seq'], $this->request->data['folder'], $this->request->data['del'][$i]);
                    if ($result == -2) {
                        //move movie error
						$this->LogMessage->logMessage('10032', $this->userInfo['user_seq']);
                        $this->request->session()->write('message', '移動に失敗しました。');
                        return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                    } elseif ($result == -1) {
                        //movie folder not exists
						$this->LogMessage->logMessage('10049', $this->userInfo['user_seq']);
                        $this->request->session()->write('message', '移動先の動画フォルダが存在しません。');
                        return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                    } elseif ($result == 0) {
                        //movie to move not exist
						$this->LogMessage->logMessage('10051', $this->userInfo['user_seq']);
                        $this->request->session()->write('message', '移動対象の動画が存在しません。');
                        return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                    }
                }
                //log moving movie is completed
                $this->LogMessage->logMessage('10031', $this->userInfo['user_seq']);
                $this->request->session()->write('message', sprintf(Configure::read('Common.move'), '動画'));
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['folder'] . $this->cashe);
            }
        }

        //open public movie
        if ($this->request->is('post') && !empty($this->request->data['open'])) {
            if (empty($this->request->data['del'])) {
			    $this->LogMessage->logMessage('12046', $this->userInfo['user_seq']);
                $this->request->session()->write('message', '動画が選択されていません。');
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/open/regist.html?mid=' . $mid . '&openflg=4&' . $this->cashe);
            } else {
                $this->request->session()->write('mfile_open', $this->request->data['del']);
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/open/regist.html?mid=' . $mid . '&openflg=5&' . $this->cashe);
            }
        }

        $movieFolderList = $this->MovieFolder->getAllMovieFolderData($this->userInfo['user_seq']);
        // movie folder total capacity confirmation
        $movieTbl = TableRegistry::get('MovieContents');
        $query = $movieTbl->find();
        $amount = $query
            ->where(['user_seq' => $this->userInfo['user_seq'], 'movie_folder_id' => $mid])
            ->select(['sum' => $query->func()->sum('amount')])
            ->hydrate(false)
            ->toArray();
        $dataSize = $amount[0]['sum'];

        $sort = isset($this->request->data['sort']) ? $this->request->data('sort') : $this->request->query('sort');

        //searching
        $keyword = "";
        if ($this->request->is('post') && isset($this->request->data['keyword'])) {
            $keyword = $this->request->data['keyword'];
            if (mb_strlen($keyword) > Configure::read('KeywordSearch.KeywordLimit')) {
                $this->request->session()->write('message', '検索キーワードには' . Configure::read('KeywordSearch.KeywordLimit') . '文字以内で入力してください。');
                return $this->redirect($this->previousUrl);
            }
        } elseif ($this->request->is('get') && isset($this->request->query['keyword'])) {
            if (mb_strlen($this->request->query['keyword']) > Configure::read('KeywordSearch.KeywordLimit')) {
                $this->request->session()->write('message', '検索キーワードには' . Configure::read('KeywordSearch.KeywordLimit') . '文字以内で入力してください。');
                return $this->redirect($this->previousUrl);
            }
            $keyword = base64_decode($this->request->query['keyword']);
        }

        if (!empty($this->request->query['mid'])) {
            $mid = $this->request->query['mid'];
            if (isset($this->request->query['src']) && $this->request->query['src'] == 'all') {
                $mid = '';
            }
            $select = $this->Movie->getSearchMovieByFolder($this->userInfo['user_seq'], $mid, $keyword, $sort);
            $mid = $this->request->query['mid'];
        } else {
            $mid = $this->request->session()->read('mid');
            if ($this->request->query('src') == 'all' || empty($this->request->query('src'))) {
                $select = $this->Movie->getSearchMovieByFolder($this->userInfo['user_seq'], $mid, $keyword, $sort);
            }
        }
        //pagination
        $page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        $pageData = $this->PageControl->pageCtl($page, $select, Configure::read('Movie.PCMovieLimit'));
        $this->set('pageData', $pageData);
        $data = $pageData['show_data'];

        $openFlg = 0;
        $openStatusTbl = TableRegistry::get('OpenStatus');
        foreach ($data as $key => $value) {
            // check open status for movie in folder
            if ($openFlg != 1) {
                $openStatus = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $data[$key]['movie_contents_id'], '5');
                if (!empty($openStatus)) {
                    $openFlg = 1;
                }
            }
        }
        $result = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $mid, 4);
        //search params
        if (!empty($this->request->data['search']) || isset($this->request->query['fromsrc']) && $this->request->query['fromsrc'] == 1) {
            $this->set('fromsrc', 1);
        } else {
            $this->set('fromsrc', 0);
        }

        $this->set('movieFolderList', $movieFolderList);
        $movieFolderTbl = TableRegistry::get('MovieFolder');
        $folderNameList = $movieFolderTbl->getMovieFolderName($this->userInfo['user_seq']);
        $this->set('folderNameList', $folderNameList);
        $this->set('data', $data);
        $this->set('mid', $mid);

        $this->set("slide", isset($select[1][0]['pic_id']) ? $select[1][0]['pic_id'] : null);
        if (empty($result)) {
            $this->set('openStatus', false);
        } else {
            $this->set('openStatus', true);
        }
        $this->set("optsort", array('new' => '新しい順', 'old' => '古い順'));
        $this->set("resultNum", count($select));
        $this->set("keyword", $keyword);
        $this->set("keyword64", base64_encode($keyword));
        $this->set("dataSize", $dataSize);

        $this->set("openFlg", $openFlg);
        $this->set('page', $page);
        if (isset($this->request->query['src'])) {
            $this->set('src', $this->request->query['src']);
        } else {
            $this->set('src', null);
        }
        if (isset($this->request->query['sort'])) {
            $this->set('sort', $this->request->query['sort']);
        } else {
            $this->set('sort', null);
        }
    }

    private function smartPhone()
    {
        //Movement processing
        if ($this->request->is('post') && isset($this->request->data['remove']) && $this->request->data['remove'] == 1) {
            if (isset($this->request->data['del']) && count($this->request->data['del']) > 0) {
                for ($i = 0; $i < count($this->request->data['del']); $i++) {
				    //log moving movie is start
                    $this->LogMessage->logMessage('10030', $this->userInfo['user_seq']);
                    $result = $this->Movie->moveContentsFolderData($this->userInfo['user_seq'], $this->request->data['folder'], $this->request->data['del'][$i]);
                    if ($result == -2) {
                        //move movie error
						$this->LogMessage->logMessage('10032', $this->userInfo['user_seq']);
                        $this->request->session()->write('message', '移動に失敗しました。');
                        return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                    } elseif ($result == -1) {
                        //movie folder not exists
						$this->LogMessage->logMessage('10049', $this->userInfo['user_seq']);
                        $this->request->session()->write('message', '移動先の動画フォルダが存在しません。');
                        return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                    } elseif ($result == 0) {
                        //movie to move not exist
						$this->LogMessage->logMessage('10051', $this->userInfo['user_seq']);
                        $this->request->session()->write('message', '移動対象の動画が存在しません。');
                        return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/list.html?' . $this->cashe);
                    }
                }
                //log moving movie is completed
                $this->LogMessage->logMessage('10031', $this->userInfo['user_seq']);
                $this->request->session()->write('message', sprintf(Configure::read('Common.move'), '動画'));
                return $this->redirect($this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->data['folder'] . $this->cashe);
            }
        }

        $movieFolderList = $this->MovieFolder->getAllMovieFolderData($this->userInfo['user_seq']);
        $sort = isset($this->request->data['sort']) ? $this->request->data('sort') : $this->request->query('sort');
        $keyword = '';
        if (isset($this->request->data['keyword'])) {
            $keyword = $this->request->data('keyword');
        } else {
            $keyword = base64_decode($this->request->query('keyword'));
        }

        if (!empty($this->request->query['mid'])) {
            $mid = $this->request->query['mid'];
            if (isset($this->request->query['src']) && $this->request->query['src'] == 'all') {
                $mid = '';
            }
            $select = $this->Movie->getSearchMovieByFolder($this->userInfo['user_seq'], $mid, $keyword, $sort);
            $mid = $this->request->query['mid'];
        } else {
            $mid = $this->request->session()->read('mid');
            if ($this->request->query('src') == 'all' || empty($this->request->query('src'))) {
                $select = $this->Movie->getSearchMovieByFolder($this->userInfo['user_seq'], $mid, $keyword, $sort);
            }
        }

        // movie folder total capacity confirmation
        $movieTbl = TableRegistry::get('MovieContents');
        $query = $movieTbl->find();
        $amount = $query
            ->where(['user_seq' => $this->userInfo['user_seq'], 'movie_folder_id' => $mid])
            ->select(['sum' => $query->func()->sum('amount')])
            ->hydrate(false)
            ->toArray();
        $dataSize = $amount[0]['sum'];
        //pagination
        $page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        $pageData = $this->PageControl->pageCtl($page, $select, Configure::read('Movie.SPMovieLimit'));
        $this->set('pageData', $pageData);
        $data = $pageData['show_data'];

        $this->set('umovkey', $this->Common->iphone5encrypt($this->userInfo['user_seq']));
        $openFlg = 0;
        $openStatusTbl = TableRegistry::get('OpenStatus');
        foreach ($data as $key => $value) {
            // check open status for movie in folder
            if ($openFlg != 1) {
                $openStatus = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $data[$key]['movie_contents_id'], '5');
                if (!empty($openStatus)) {
                    $openFlg = 1;
                }
            }
        }
        $result = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $mid, 4);
        //search params
        if (($this->request->query('search') || $this->request->data('search')) || ($this->request->query('fromsrc') == 1 || $this->request->data('fromsrc') == 1)
        ) {
            $this->set('fromsrc', 1);
            $fromsrc = 1;
            if ($this->request->query('src') == 'all') {
                $this->set('preview', $this->deviceName[$this->deviceTypeId] . '/movie/list.html');
            } else {
                $this->set('preview', $this->deviceName[$this->deviceTypeId] . '/movie/preview.html?mid=' . $this->request->query('mid'));
            }
        } else {
            $this->set('fromsrc', 0);
            $fromsrc = 0;
            $this->set('preview', $this->deviceName[$this->deviceTypeId] . '/movie/list.html');
        }

        $this->set('movieFolderList', $movieFolderList);
        $movieFolderTbl = TableRegistry::get('MovieFolder');
        $folderNameList = $movieFolderTbl->getMovieFolderName($this->userInfo['user_seq']);
        $this->set('folderNameList', $folderNameList);
        $this->set('data', $data);
        $this->set('mid', $mid);

        $this->set("slide", isset($select[1][0]['pic_id']) ? $select[1][0]['pic_id'] : null);
        if (empty($result)) {
            $this->set('openStatus', false);
        } else {
            $this->set('openStatus', true);
        }
        $this->set("optsort", array('new' => '新しい順', 'old' => '古い順'));
        $this->set("resultNum", count($select));
        $this->set("keyword", $keyword);
        $this->set("keyword64", base64_encode($keyword));
        $this->set("dataSize", $dataSize);

        $this->set("openFlg", $openFlg);
        $this->set('page', $page);
        if (isset($this->request->query['src'])) {
            $this->set('src', $this->request->query['src']);
        } else {
            $this->set('src', null);
        }
        if (isset($this->request->query['sort'])) {
            $this->set('sort', $this->request->query['sort']);
        } else {
            $this->set('sort', null);
        }

        //set title
        if ((isset($keyword) && $keyword != '') || $fromsrc) {
            $this->set('title', '動画検索結果');
        } else {
            $this->set('title', '動画フォルダ詳細');
        }
    }

    public function showMoreMovie()
    {
        $sort = isset($this->request->data['sort']) ? $this->request->data('sort') : $this->request->query('sort');
        $keyword = '';
        if (isset($this->request->data['keyword'])) {
            $keyword = $this->request->data('keyword');
        } else {
            $keyword = base64_decode($this->request->query('keyword'));
        }

        if (!empty($this->request->query['mid'])) {
            $mid = $this->request->query['mid'];
            if (isset($this->request->query['src']) && $this->request->query['src'] == 'all') {
                $mid = '';
            }
            $select = $this->Movie->getSearchMovieByFolder($this->userInfo['user_seq'], $mid, $keyword, $sort);
            $mid = $this->request->query['mid'];
        } else {
            $mid = $this->request->session()->read('mid');
            if ($this->request->query('src') == 'all' || empty($this->request->query('src'))) {
                $select = $this->Movie->getSearchMovieByFolder($this->userInfo['user_seq'], $mid, $keyword, $sort);
            }
        }

        $dataSize = 0;
        //pagination
        $page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        $pageData = $this->PageControl->pageCtl($page, $select, Configure::read('Movie.SPMovieLimit'));
        $this->set('pageData', $pageData);
        $data = $pageData['show_data'];

        $openFlg = 0;
        $openStatusTbl = TableRegistry::get('OpenStatus');
        foreach ($data as $key => $value) {
            // check open status for movie in folder
            if ($openFlg != 1) {
                $openStatus = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $data[$key]['movie_contents_id'], '5');
                if (!empty($openStatus)) {
                    $openFlg = 1;
                }
            }
            $dataSize += $value['amount'];
        }
        $result = $openStatusTbl->getAllOrderByOpenStatus($this->userInfo['user_seq'], $mid, 4);
        //search params
        if (($this->request->query('search') || $this->request->data('search')) || ($this->request->query('fromsrc') == 1 || $this->request->data('fromsrc') == 1)
        ) {
            $this->set('fromsrc', 1);
            $fromsrc = 1;
        } else {
            $this->set('fromsrc', 0);
            $fromsrc = 0;
        }

        $this->set('data', $data);
        $this->set('mid', $mid);

        $this->set("slide", isset($select[1][0]['pic_id']) ? $select[1][0]['pic_id'] : null);
        $this->set('openStatus', $result);
        $this->set("resultNum", count($select));
        $this->set("keyword", $keyword);
        $this->set("keyword64", base64_encode($keyword));
        $this->set("dataSize", $dataSize);
        $this->set('umovkey', $this->Common->iphone5encrypt($this->userInfo['user_seq']));

        $this->set("openFlg", $openFlg);
        $this->set('page', $page);
        if (isset($this->request->query['src'])) {
            $this->set('src', $this->request->query['src']);
        } else {
            $this->set('src', null);
        }
        if (isset($this->request->query['sort'])) {
            $this->set('sort', $this->request->query['sort']);
        } else {
            $this->set('sort', null);
        }
        if ($this->deviceTypeId == 2) {
            $this->render('Iphone.MFolderPreview/showMoreMovie');
        } elseif ($this->deviceTypeId == 3) {
            $this->render('Android.MFolderPreview/showMoreMovie');
        }
    }
}
