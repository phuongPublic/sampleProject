<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Event\Event;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExportUserDataController extends AppController
{

    public $components = ['User'];


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if($this->request->is('post'))
        {
            echo  $this->exportAddressData();exit;
        }
    }

    /**
     * Export selected addresses to CSV file
     *
     * @param string  $userSeq      User sequence number
     * @param array   $uidList      List of address sequence
     * @param int  $csvFileType
     * @return string $exportAddressData  Export result string
     */
    public function exportAddressData( $csvFileType = 2)
    {
        $customerTbl = TableRegistry::get('DtbCustomer');
//        if (!$uidList) {
//            //全データIDの取得
//            $uidList = $adrTbl->getAllAddressSeq($userSeq);
//        }
//
//        if ($uidList == null) {
//            return false;
//        }
//
//        if (!is_array($uidList)) {
//            $uidList = array($uidList);
//        }
//
//        foreach($uidList as $uId) {
//            if (!preg_match("/^(?!0+$)\d+$/", $uId)) {
//                return false;
//            }
//        }
//
//        if ($csvFileType == 1) {
//            // outlook
//            $title = array(
//                "名",
//                "姓",
//                "会社名",
//                "部署",
//                "番地 (会社)",
//                "市町村 (会社)",
//                "都道府県 (会社)",
//                "郵便番号 (会社)",
//                "国 (会社)/地域",
//                "番地 (自宅)",
//                "市町村 (自宅)",
//                "都道府県 (自宅)",
//                "郵便番号 (自宅)",
//                "国 (自宅)/地域",
//                "会社 FAX",
//                "会社電話",
//                "自宅 FAX",
//                "自宅電話",
//                "携帯電話",
//                "Web ページ",
//                "メモ",
//                "誕生日",
//                "電子メール アドレス",
//            );
//        } else {
//            // window live mail
//            $title = array(
//                "姓",
//                "名",
//                "ニックネーム",
//                "電子メール アドレス",
//                "会社名",
//                "部署",
//                "勤務先の国または地域",
//                "勤務先の郵便番号",
//                "勤務先の都道府県",
//                "勤務先の市区町村",
//                "勤務先の番地",
//                "勤務先電話番号",
//                "勤務先ファックス  ",
//                "ビジネス Web ページ",
//                "国または地域",
//                "自宅の郵便番号",
//                "自宅の都道府県",
//                "自宅の市区町村",
//                "自宅の番地",
//                "携帯電話",
//                "自宅電話番号",
//                "自宅ファックス",
//                "個人 Web ページ",
//                "誕生日",
//                "メモ",
//            );
//        }
//        $exportAddressData = implode(",", $title) . "\r\n";
//        // Convert each of address data to string
//        foreach ($uidList as $uid) {
//            $adrdata = $adrTbl->getAddressData($uid);
//
//            // 不用カラムの削除
//            unset($adrdata["adrdata_seq"]);
//            unset($adrdata["user_seq"]);
//            unset($adrdata["ins_date"]);
//            unset($adrdata["upd_date"]);
//
//            $adrdata["note"] = $this->removeEOL($adrdata["note"]);
//            if ($csvFileType == 1) {
//                $adrdata2 = array(
//                    $adrdata["name_f"],
//                    $adrdata["name_l"],
//                    $adrdata["org_name"],
//                    $adrdata["org_post"],
//                    $adrdata["work_adr2"],
//                    $adrdata["work_adr1"],
//                    $adrdata["work_pref"],
//                    $adrdata["work_postcode"],
//                    $adrdata["work_countory"],
//                    $adrdata["home_adr2"],
//                    $adrdata["home_adr1"],
//                    $adrdata["home_pref"],
//                    $adrdata["home_postcode"],
//                    $adrdata["home_countory"],
//                    $adrdata["work_fax"],
//                    $adrdata["work_tel"],
//                    $adrdata["home_fax"],
//                    $adrdata["home_tel"],
//                    $adrdata["home_cell"],
//                    $adrdata["work_url"],
//                    $adrdata["note"],
//                    $adrdata["birthday"],
//                    $adrdata["email"],
//                );
//            } else {
//                $adrdata2 = array(
//                    $adrdata["name_l"],
//                    $adrdata["name_f"],
//                    $adrdata["nickname"],
//                    $adrdata["email"],
//                    $adrdata["org_name"],
//                    $adrdata["org_post"],
//                    $adrdata["work_countory"],
//                    $adrdata["work_postcode"],
//                    $adrdata["work_pref"],
//                    $adrdata["work_adr1"],
//                    $adrdata["work_adr2"],
//                    $adrdata["work_tel"],
//                    $adrdata["work_fax"],
//                    $adrdata["work_url"],
//                    $adrdata["home_countory"],
//                    $adrdata["home_postcode"],
//                    $adrdata["home_pref"],
//                    $adrdata["home_adr1"],
//                    $adrdata["home_adr2"],
//                    $adrdata["home_cell"],
//                    $adrdata["home_tel"],
//                    $adrdata["home_fax"],
//                    $adrdata["home_url"],
//                    $adrdata["birthday"],
//                    $adrdata["note"],
//                );
//            }
//
//            $exportAddressData .= $this->toStringInCsvFormat($adrdata2) . "\r\n";
//        }
        $exportData = null;
        $title = array(
                "first name",
                "last name",
                "email",
                "birth day",
                "phone",
                "cv_name",
                "create_date",
            );
        $exportData = implode(",", $title) . "\r\n";
        $exportArrayData = $customerTbl->getAllCustomerData();

        foreach ($exportArrayData as $key => $item)
        {
            $exportData .= $this->toStringInCsvFormat($item) . "\r\n";
        }
//        debug($exportData);die;
        $filename = "address.csv";
        if ($exportData) {
            // インポート/エクスポート形式変更対応
            if ($csvFileType == 2) {
                // 出力はUTF-8で。
             //   $exportData = mb_convert_encoding($exportData, "UTF-8", "auto");
                $exportData =  chr(255) . chr(254) .mb_convert_encoding($exportData, 'UTF-16LE', 'UTF-8');

            } else {
                // 出力はSJISで。
                if(preg_match("/Macintosh/isx", $this->request->header('User-Agent'))) {
                    $exportData = mb_convert_encoding($exportData, "SJIS-mac", "auto");
                } else {
                    $exportData = mb_convert_encoding($exportData, "SJIS-win", "auto");
                }
            }
            // ヘッダーの出力
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=$filename");
        }
        return $exportData;
    }

    /**
     * Convert address data to string follow by csv format
     *
     * @param array $addressData   Array of address data
     * @return string $result    CSV data
     */
    private function toStringInCsvFormat($addressData)
    {
        if (!$addressData) {
            return "";
        }
        foreach ($addressData as $key => $value) {
            $addressData[$key] = "\"" . str_replace('"', '\"', $value) . "\"";
        }
        $result = implode(",", $addressData);
        return $result;
    }

}
