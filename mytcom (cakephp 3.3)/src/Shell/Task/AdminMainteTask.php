<?php

namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Filesystem\File;
use Exception;
use Cake\ORM\TableRegistry;
use App\Controller\Component\LogMessageComponent;

/** ISP: TCOM */
define('TCOM_ISP', "tcom");
/** ISP: TNC */
define('TNC_ISP', "tnc");

/**
 * AdminMainteTask shell task.
 */
class AdminMainteTask extends Shell
{

    private $log;

    /**
     * メンテナンスファイルを書き込む。
     */
    public function beginMaintenance($mainteBody)
    {
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");

        //共通
        $this->beginMainteCommon($filePath, $mainteBody);

        // 旧OTP(ethna版)
        if (Configure::read("Common.AdminModule.Mainte.EthnaUsingFlag")) {
            $this->beginMainteEthna($filePath, $mainteBody);
        }
        // TCOMの場合
        if ($_SERVER['NOPT_ISP'] == TCOM_ISP) {
            $this->beginMainteBbsKso($filePath, $mainteBody);
        // TNCの場合
        } elseif ($_SERVER['NOPT_ISP'] == TNC_ISP) {
            $this->beginMainteBbs($filePath, $mainteBody);
        }
    }

    private function beginMainteCommon($filePath, $mainteBody)
    {
        // PCの場合PC用のメンテナンスページ生成
        $this->createFileMainte($filePath['mainte_template'], $filePath['mainte'], $mainteBody);

        // Iphoneの場合Iphone用のメンテナンスページ生成
        $this->createFileMainte($filePath['mainte_template_iphone'], $filePath['mainte_iphone'], $mainteBody);

        // Androidの場合Android用のメンテナンスページ生成
        $this->createFileMainte($filePath['mainte_template_android'], $filePath['mainte_android'], $mainteBody);

        // .htaccessファイル上書き
        $fileHtaccessMainte = new File($filePath['htaccess_mainte']);
        $result = $fileHtaccessMainte->copy($filePath['htaccess'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_mainte'], $filePath['htaccess']);

        return true;
    }

    private function beginMainteEthna($filePath, $mainteBody)
    {
        // PCの場合PC用のメンテナンスページ生成
        $this->createFileMainte($filePath['mainte_template'], $filePath['mainte_opt_pc'], $mainteBody);

        // PC用の.htaccess上書き
        $fileHtaccessNormalOpt = new File($filePath['htaccess_mainte_opt_pc']);
        $result = $fileHtaccessNormalOpt->copy($filePath['htaccess_opt_pc'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_mainte_opt_pc'], $filePath['htaccess_opt_pc']);

        //Iphoneの場合Iphone用のメンテナンスページ生成
        $this->createFileMainte($filePath['mainte_template_iphone'], $filePath['mainte_opt_ip'], $mainteBody);

        // Iphone用の.htaccess上書き
        $fileHtaccessNormalOptIp = new File($filePath['htaccess_mainte_opt_ip']);
        $$result = $fileHtaccessNormalOptIp->copy($filePath['htaccess_opt_ip'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_mainte_opt_ip'], $filePath['htaccess_opt_ip']);

        //Androidの場合Android用のメンテナンスページ生成
        $this->createFileMainte($filePath['mainte_template_android'], $filePath['mainte_opt_ad'], $mainteBody);

        // Android用の.htaccess上書き
        $fileHtaccessNormalOptAd = new File($filePath['htaccess_mainte_opt_ad']);
        $result = $fileHtaccessNormalOptAd->copy($filePath['htaccess_opt_ad'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_mainte_opt_ad'], $filePath['htaccess_opt_ad']);

        return true;
    }

    private function beginMainteBbs($filePath, $mainteBody)
    {
        // BBS.PCの場合PC用のメンテナンスページ生成
        $this->createFileMainte($filePath['mainte_template'], $filePath['mainte_bbs'], $mainteBody);

        // BBS.SPの場合SP用のメンテナンスページ生成
        $this->createFileMainte($filePath['mainte_template_iphone'], $filePath['mainte_sp_bbs'], $mainteBody);

        // BBS.htaccessファイル上書き
        $fileHtaccessMainteBbs = new File($filePath['htaccess_mainte_bbs']);
        $result = $fileHtaccessMainteBbs->copy($filePath['htaccess_bbs'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_mainte_bbs'], $filePath['htaccess_bbs']);

        return true;
    }

    private function beginMainteBbsKso($filePath, $mainteBody)
    {
        $this->beginMainteBbs($filePath, $mainteBody);

        // TCOM_KSO.PCの場合PC用のメンテナンスページ生成
        $this->createFileMainte($filePath['mainte_template'], $filePath['mainte_kso'], $mainteBody);

        // TCOM_KSO.htaccessファイル上書き
        $fileHtaccessMainteKso = new File($filePath['htaccess_mainte_kso']);
        $result = $fileHtaccessMainteKso->copy($filePath['htaccess_kso'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_mainte_kso'], $filePath['htaccess_kso']);

        $fileHtaccessMainteKso1 = new File($filePath['htaccess_mainte_kso_1']);
        $result = $fileHtaccessMainteKso1->copy($filePath['htaccess_kso_1'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_mainte_kso_1'], $filePath['htaccess_kso_1']);

        $fileHtaccessMainteKsoApp = new File($filePath['htaccess_mainte_kso_app']);
        $result = $fileHtaccessMainteKsoApp->copy($filePath['htaccess_kso_app'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_mainte_kso_app'], $filePath['htaccess_kso_app']);

        $fileHtaccessMainteKsoWebroot = new File($filePath['htaccess_mainte_kso_webroot']);
        $result = $fileHtaccessMainteKsoWebroot->copy($filePath['htaccess_kso_webroot'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_mainte_kso_webroot'], $filePath['htaccess_kso_webroot']);

        return true;
    }

    /**
     * メンテナンステンプレートファイルを読み込んで、「内容」をセットしたファイルをhtmlファイルを生成する。
     */
    private function createFileMainte($originFile, $destFile, $mainteBody)
    {
        $this->log = new LogMessageComponent();
        //read file
        try {
            $tempFile = new File($originFile);
            $outputHtmlNoParam = $tempFile->read();
            $outputHtml = str_replace('<?= $mainte_body ?>', $mainteBody, $outputHtmlNoParam);
            $tempFile->close();
        } catch (Exception $e) {
            $this->log->logMessage('83036', $originFile);
            throw $e;
        }

        //create file
        try {
            $mainteFile = new File($destFile);
            $mainteFile->write($outputHtml);
            $mainteFile->close();
        } catch (Exception $e) {
            $this->log->logMessage('83037', $originFile, $destFile);
            throw $e;
        }
    }

    /**
     * メンテナンスを終了すると.htaccessファイル上書き。
     */
    public function endMaintenance($objMainteUpdate)
    {
        $this->updateStatusToEndMainte($objMainteUpdate);
        $this->copyHtaccessFileToEndMainte();

        return true;
    }

    /**
     * メンテナンスを公開終了ステータスに編集する。
     */
    private function updateStatusToEndMainte($objMainteUpdate)
    {
        $this->log = new LogMessageComponent();
        $mainteTbl = TableRegistry::get("Mainte");
        foreach ($objMainteUpdate as $mainte) {
            try {
                $mainteId = $mainte['mainte_id'];
                $this->log->logMessage('83024', $mainteId);
                $mainteEntity = $mainteTbl->newEntity();
                $mainteEntity->mainte_id = $mainteId;
                $mainteEntity->mainte_status = array_search("公開終了", Configure::read('Common.AdminModule.Mainte.AdminMainteStatus'));
                $mainteTbl->connection()->transactional(function () use ($mainteTbl, $mainteEntity) {
                    $mainteTbl->save($mainteEntity, ['atomic' => false]);
                });
                $this->log->logMessage('83025', $mainteId);
            } catch (Exception $ex) {
                $this->log->logMessage('83026', $mainteId);
                throw $ex;
            }
        }
    }

    /**
     * ※２　メンテナンス終了処理
     */
    public function copyHtaccessFileToEndMainte()
    {
        $filePath = Configure::read("Common.AdminModule.Mainte.FilePath");
        
        //共通
        $fileHtaccessNormal = new File($filePath['htaccess_normal']);
        $result = $fileHtaccessNormal->copy($filePath['htaccess'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_normal'], $filePath['htaccess']);

        // 旧OTP(ethna版)
        if (Configure::read("Common.AdminModule.Mainte.EthnaUsingFlag")) {
            $this->ethnaCloseMainte($filePath);
        }

        // TCOMの場合
        if ($_SERVER['NOPT_ISP'] == TCOM_ISP) {
            $this->endMainteBbsKso($filePath);
        // TNCの場合
        } elseif ($_SERVER['NOPT_ISP'] == TNC_ISP) {
            $this->endMainteBbs($filePath);
        }
        return true;
    }

    private function ethnaCloseMainte($filePath)
    {
        // PC用の.htaccess上書き
        $fileHtaccessNormalOpt = new File($filePath['htaccess_normal_opt_pc']);
        $result = $fileHtaccessNormalOpt->copy($filePath['htaccess_opt_pc'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_normal_opt_pc'], $filePath['htaccess_opt_pc']);

        // Iphone用の.htaccess上書き
        $fileHtaccessNormalOptIp = new File($filePath['htaccess_normal_opt_ip']);
        $result = $fileHtaccessNormalOptIp->copy($filePath['htaccess_opt_ip'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_normal_opt_ip'], $filePath['htaccess_opt_ip']);

        // Android用の.htaccess上書き
        $fileHtaccessNormalOptAd = new File($filePath['htaccess_normal_opt_ad']);
        $result = $fileHtaccessNormalOptAd->copy($filePath['htaccess_opt_ad'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_normal_opt_ad'], $filePath['htaccess_opt_ad']);

        return true;
    }

    private function endMainteBbsKso($filePath)
    {
        // BBS
        $this->endMainteBbs($filePath);

        // TCOMの場合
        // TCOM_KSO.htaccessファイル上書き
        $fileHtaccessNormalKso = new File($filePath['htaccess_normal_kso']);
        $result = $fileHtaccessNormalKso->copy($filePath['htaccess_kso'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_normal_kso'], $filePath['htaccess_kso']);

        $fileHtaccessNormalKso1 = new File($filePath['htaccess_normal_kso_1']);
        $result = $fileHtaccessNormalKso1->copy($filePath['htaccess_kso_1'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_normal_kso_1'], $filePath['htaccess_kso_1']);

        $fileHtaccessNormalKsoApp = new File($filePath['htaccess_normal_kso_app']);
        $result = $fileHtaccessNormalKsoApp->copy($filePath['htaccess_kso_app'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_normal_kso_app'], $filePath['htaccess_kso_app']);

        $fileHtaccessNormalKsoWebroot = new File($filePath['htaccess_normal_kso_webroot']);
        $result = $fileHtaccessNormalKsoWebroot->copy($filePath['htaccess_kso_webroot'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_normal_kso_webroot'], $filePath['htaccess_kso_webroot']);

        return true;
    }

    private function endMainteBbs($filePath)
    {
        $fileHtaccessNormalBbs = new File($filePath['htaccess_normal_bbs']);
        $result = $fileHtaccessNormalBbs->copy($filePath['htaccess_bbs'], true);
        $this->writeLogWhenCopyError($result, $filePath['htaccess_normal_bbs'], $filePath['htaccess_bbs']);

        return true;
    }

    private function writeLogWhenCopyError($result, $originFile, $destFile)
    {
        $this->log = new LogMessageComponent();
        if (!$result) {
            $this->log->logMessage('83038', $originFile, $destFile);
        }
    }
}
