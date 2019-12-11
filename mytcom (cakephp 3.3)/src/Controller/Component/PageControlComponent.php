<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * PageControl component
 */
class PageControlComponent extends Component
{

    protected $displayNum = 5;//表示するページ数

    /**
     *
     * @param int $pages
     * @param array $result
     * @param int $items
     * @return array
     */

    public function pageCtl($pages, $result, $items)
    {

        // 戻りデータの定義
        $data = array(
            'page' => "",
            'total' => "",
            'total_page' => "",
            'start' => "",
            'end' => "",
            'next' => "",
            'back' => "",
            'show_data' => "",
            'link_num' => "",
            'items' => ""
        );

        // 1ページあたり表示する件数を設定
        $data['items'] = $items;

        // 表示するページ番号を設定（入力値がない場合は1を設定）
        if ($pages != "") {
            $data['page'] = $pages;
        } else {
            $data['page'] = 1;
        }
        // データの件数を設定
        $data['total'] = count($result);
        // 総ページ数を設定
        $pageItems = $items;
        //合計ページ数
        if ($items) {
            $data['total_page'] = intval(ceil($data['total'] / $items));
        }
        // 表示するデータの先頭データと末端データのレコード番号を設定
        $offset = ($data['page'] - 1) * $pageItems;
        //オフセット
        $from = $offset;
        //開始データ
        $data['start'] = $offset + 1;
        if ($data['start'] + $pageItems < $data['total']) {
            $data['end'] = $offset + $pageItems;
        } elseif ($data['start'] + $pageItems == $data['total']) {
            $data['end'] = $data['start'] + ($data['total'] - $data['start']) - 1;
        } else {
            $data['end'] = $data['start'] + ($data['total'] - $data['start']);
        }
        // 前ページと次ページのページ番号を設定
        if ($data['page'] < $data['total_page']) {
            $data['next'] = $data['page'] + 1;
        }
        if (($data['page'] - 1) != 0) {
            $data['back'] = $data['page'] - 1;
        }

        $data['show_data'] = $this->getSelectedData($from, $pageItems, $result);
        $data['link_num'] = $this->getCountData($data['page'], $data['total_page']);

        return $data;
    }

    /**
     *  Get selected data
     *
     *  @param  int     $start          start record
     *  @param  int     $pageItem       page item
     *  @param  int     $data           data
     *  @return array   selected data
     */
    private function getSelectedData($start, $pageItem, $data)
    {
        $selectedData = array();
        if (isset($data)) {
            for ($i = $start; $i < $start + $pageItem; $i++) {
                if (array_key_exists($i, $data)) {
                    if ($data[$i] != "" || isset($data[$i])) {
                        $selectedData[$i] = $data[$i];
                    }
                }
            }
        }
        return $selectedData;
    }

    private function getCountData($page, $totalPage)
    {

        $data = array();
        for ($i = 1; $i < $totalPage + 1; $i++) {
            $data[] = $i;
        }
        $pagelink = $data;

        if (count($pagelink) == 1) {
            $pagelink = array();
            return $pagelink;
        }


        if ($totalPage < $this->displayNum) {
            return $pagelink;
        }


        if ($totalPage > $this->displayNum) {
            $center = intval(floor($this->displayNum / 2));
            $modify = array();

            $num = $page + $center; //最後のページチェック
            if ($num > $totalPage) {
                $max = $totalPage + 1;
                $min = $max - $this->displayNum;
            } elseif ($page < $center + 1) {
                $max = $this->displayNum + 1;
                $min = 1;
            } else {
                $max = $page + $center + 1;
                $min = $page - $center;
            }

            for ($i = $min; $i < $max; $i++) {
                $modify[] = $i;
            }

            sort($modify);
            $pagelink = $modify;
        }

        return $pagelink;
    }
}
