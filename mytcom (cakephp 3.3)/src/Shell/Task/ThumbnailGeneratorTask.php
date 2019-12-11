<?php

namespace App\Shell\Task;

use Cake\Console\Shell;
use \phpThumb;
use \ErrorException;
use App\Controller\Component\LogMessageComponent;

// PC版詳細用イメージの幅と高さの比率(480:360 = 4:3)
define("WIDTH_RATE", 4);
define("HEIGHT_RATE", 3);

// PC版詳細用イメージの幅と高さの最大値
define("WIDTH_MAX_DETAIL", 480);
define("HEIGHT_MAX_DETAIL", 360);

// getImageInfoから取得するイメージ情報のキー
define("WIDTH", 0);
define("HEIGHT", 1);

// ImageJpegの引数となる、作成するイメージの品質指定
define("QUALITY_MAX", 100);

// サムネイルファイル名のサフィクス
define("SUFFIX_PC_DETAIL", "_detail");
define("SUFFIX_PC_THUMB", "_thumb");
define("SUFFIX_MOBILE_THUMB", "_mobi");
define("SUFFIX_IPHONE_THUMB", "_iphone");

// サムネイル作成に失敗した場合に作成されるNGフラグファイルの名前のサフィクス
define("SUFFIX_NG_FLG", "_NGFlg");

// makeImageByPhpThumbの終了ステータス
define("PHPTHUMB_OK", 1);
define("PHPTHUMB_NG", 0);

/**
 * ThumbnailGenerator shell task.
 *
 * サムネイルを作成するクラス
 */
class ThumbnailGeneratorTask extends Shell
{

    public $tasks = ['StopWatch'];
    private $log;
    // アップロードファイル（サムネイル作成元画像）の情報
    private $orgImagePath;
    private $orgImageInfo;
    private $orgImageWidth;
    private $orgImageHeight;
    // サムネイル作成先画像のフルパスつきファイル名
    private $dstPcDetailPath;           // PC版詳細画面イメージ
    private $dstPcThumbnailPath;        // PC版サムネイル用
    private $dstMobileThumbnailPath;    // スマートフォン版サムネイル用（元携帯版サムネイル用）
    private $dstIphoneThumbnaillPath;   // スマートフォン版サムネイル用（元iPhone版サムネイル用）

    /*     * ************************************************************************
     * execute 全サムネイル作成処理
     *
     * @return void
     * ************************************************************************ */

    public function execute($uploadPath)
    {
        set_error_handler("self::thumbnailErrorHandler");
        $this->log = new LogMessageComponent();
        $this->log->logMessage("02049", $uploadPath);

        try {
            $this->initialSetting($uploadPath);
        } catch (ErrorException $ex) {
            // 画像作成元のアップロードファイルがない場合、またはイメージファイルでない場合
            $this->log->logMessage("02051", $uploadPath);
            set_error_handler(null);
            return;
        }

        // PC版詳細画面用イメージ作成
        $this->createPcDetail();
        // PC版サムネイル用イメージ作成      createPcDetailによって作成されるPC版詳細画面用イメージをINPUTとしている
        $this->createPcThumbnail();

        // スマートフォン版サムネイル用イメージ(_mobi)作成     createPcDetailによって作成されるPC版詳細画面用イメージをINPUTとしている
        $this->createMobileThumbnail();

        // スマートフォン版サムネイル用イメージ(_iphone)作成
        $this->createIphoneThumbnail();
        $this->log->logMessage("02050", $uploadPath);
        set_error_handler(null);
    }

    /*     * ************************************************************************
     * initialSetting プロパティの初期化処理
     *
     * @param string:変換元イメージのファイルパス
     *
     * @return void
     * ************************************************************************ */

    private function initialSetting($uploadPath)
    {

        $this->orgImagePath = $uploadPath;                                                   // アップロードファイル（サムネイル作成元用）
        $this->dstPcDetailPath = $this->orgImagePath . SUFFIX_PC_DETAIL;                     // PC版詳細画面イメージ
        $this->dstPcThumbnailPath = $this->orgImagePath . SUFFIX_PC_THUMB;                   // PC版サムネイル
        $this->dstMobileThumbnailPath = $this->orgImagePath . SUFFIX_MOBILE_THUMB;           // スマートフォン版サムネイル用（元携帯版サムネイル用）
        $this->dstIphoneThumbnaillPath = $this->orgImagePath . SUFFIX_IPHONE_THUMB;          // スマートフォン版サムネイル用（元iPhone版サムネイル用）

        $this->orgImageInfo = $this->getImageInfo($this->orgImagePath);
        $this->orgImageWidth = $this->orgImageInfo[WIDTH];
        $this->orgImageHeight = $this->orgImageInfo[HEIGHT];
    }

    /*     * ************************************************************************
     * createPcDetail PC版詳細イメージ作成処理
     *
     * @return void
     * ************************************************************************ */

    private function createPcDetail()
    {
        // 作成先イメージの幅と高さを取得
        $makeImageSize = $this->getSizeForPcDetail();

        $srcImageName = $this->orgImagePath;
        $makeImageName = $this->dstPcDetailPath;
        $makeImageWidth = $makeImageSize[WIDTH];
        $makeImageHeight = $makeImageSize[HEIGHT];
        $makeImageFormat = $this->getImageFormatForPhpthumb($this->orgImageInfo['mime']);
        $makeIgnoreAspectRatio = true;
        $makeProcNameForLog = "詳細画面用";

        $this->makeImageByPhpThumb($makeImageName, $srcImageName, $makeImageWidth, $makeImageHeight, $makeImageFormat, $makeIgnoreAspectRatio, $makeProcNameForLog);
    }

    /*     * ************************************************************************
     * getSizeForPcDetail PC版詳細イメージサイズ取得処理
     *
     * PC版詳細イメージサイズの取得にのみ使用
     *
     * @return array PC版詳細イメージの幅と高さ
     * ************************************************************************ */

    private function getSizeForPcDetail()
    {
        // $makeImageWidthまたは$makeImageHeightの一方の値を設定し、他方の値を""とすると、下記の値がphpThumbで設定される
        // $makeImageHeight=任意の値、$makeImageWidth=""のとき
        // $makeImageWidth=$this->orgImageWidth * ($makeImageHeight / $this->orgImageHeight)
        // $makeImageWidth=任意の値、$makeImageHeight=""のとき
        // $makeImageHeight=$this->orgImageHeight * ($makeImageWidth / $this->orgImageWidth)

        if ($this->orgImageWidth <= WIDTH_MAX_DETAIL && $this->orgImageHeight <= HEIGHT_MAX_DETAIL) {
            $makeImageWidth = $this->orgImageWidth;
            $makeImageHeight = $this->orgImageHeight;
        } elseif ($this->orgImageWidth <= WIDTH_MAX_DETAIL && $this->orgImageHeight > HEIGHT_MAX_DETAIL) {
            // 作成するイメージの高さをHEIGHT_MAX_DETAILとし、幅は、高さの拡大縮小比率をかけた値とする
            $makeImageWidth = "";
            $makeImageHeight = HEIGHT_MAX_DETAIL;
        } elseif ($this->orgImageWidth > WIDTH_MAX_DETAIL && $this->orgImageHeight <= HEIGHT_MAX_DETAIL) {
            // 作成するイメージの幅をWIDTH_MAX_DETAILとし、高さは、幅の拡大縮小比率をかけた値とする
            $makeImageWidth = WIDTH_MAX_DETAIL;
            $makeImageHeight = "";
        } elseif ($this->orgImageWidth > WIDTH_MAX_DETAIL && $this->orgImageHeight > HEIGHT_MAX_DETAIL) {
            // 作成元イメージを、幅：高さ＝4:3とした値を取得する
            $orgImageWidthRated = $this->orgImageWidth / WIDTH_RATE;
            $orgImageHeightRated = $this->orgImageHeight / HEIGHT_RATE;

            // 高さが大きければ、高さをHEIGHT_MAX_DETAILとし、幅は、高さの拡大縮小比率をかけた値とする
            // 幅が大きければ、　幅をWIDTH_MAX_DETAILとし、　　高さは、幅の拡大縮小比率をかけた値とする
            if ($orgImageWidthRated < $orgImageHeightRated) {
                $makeImageWidth = "";
                $makeImageHeight = HEIGHT_MAX_DETAIL;
            } else {
                $makeImageWidth = WIDTH_MAX_DETAIL;
                $makeImageHeight = "";
            }
        }

        return [$makeImageWidth, $makeImageHeight];
    }

    /*     * ************************************************************************
     * createPcThumbnail PC版サムネイル作成処理
     *
     * createPcDetailによって作成されるPC版詳細画面用イメージをINPUTとしている
     *
     * @return void
     * ************************************************************************ */

    private function createPcThumbnail()
    {
        $srcImageName = $this->dstPcDetailPath;
        $makeImageName = $this->dstPcThumbnailPath;
        $makeImageWidth = 100;
        $makeImageHeight = 100;
        $makeImageFormat = $this->getImageFormatForPhpthumb($this->orgImageInfo['mime']);
        $makeIgnoreAspectRatio = null;
        $makeProcNameForLog = "サムネイル用";

        $this->makeImageByPhpThumb($makeImageName, $srcImageName, $makeImageWidth, $makeImageHeight, $makeImageFormat, $makeIgnoreAspectRatio, $makeProcNameForLog);
    }

    /*     * ************************************************************************
     * createMobileThumbnail スマートフォン版サムネイル（元携帯版サムネイル）作成処理
     *
     * createPcDetailによって作成されるPC版詳細画面用イメージをINPUTとしている
     *
     * @return void
     * ************************************************************************ */

    private function createMobileThumbnail()
    {
        $srcImageName = $this->dstPcDetailPath;
        $makeImageName = $this->dstMobileThumbnailPath;
        $makeImageWidth = 220;
        $makeImageHeight = 230;
        $makeImageFormat = 'jpg';
        $makeIgnoreAspectRatio = null;
        $makeProcNameForLog = "携帯用";

        $this->makeImageByPhpThumb($makeImageName, $srcImageName, $makeImageWidth, $makeImageHeight, $makeImageFormat, $makeIgnoreAspectRatio, $makeProcNameForLog);
    }

    /*     * ************************************************************************
     * createIphoneThumbnail スマートフォン版サムネイル（元iPhone版サムネイル）作成処理
     *
     * @return void
     * ************************************************************************ */

    private function createIphoneThumbnail()
    {
        $srcImageName = $this->orgImagePath;
        $makeImageName = $this->dstIphoneThumbnaillPath;
        $makeImageWidth = 160;
        $makeImageHeight = 160;
        $makeImageFormat = 'jpg';
        $makeIgnoreAspectRatio = null;
        $makeProcNameForLog = "iPhoneサムネイル用";

        // イメージサイズ変換処理用
        $convSrcImageName = $this->dstIphoneThumbnaillPath;
        $convDstImageName = $this->dstIphoneThumbnaillPath;
        $convDstImageWidth = 160;
        $convDstImageHeight = 160;

        // 既存では、makeImageByPhpThumbでImageLog.logに出力せず、convertImageSizeでのみ出力しているため、踏襲
        $ret = $this->makeImageByPhpThumb($makeImageName, $srcImageName, $makeImageWidth, $makeImageHeight, $makeImageFormat, $makeIgnoreAspectRatio);

        if ($ret == PHPTHUMB_OK) {
            $this->convertImageSize($convDstImageName, $convSrcImageName, $convDstImageWidth, $convDstImageHeight, $makeProcNameForLog);
        }
    }

    /*     * ************************************************************************
     * convertImageSize イメージサイズ変換処理
     *
     * スマートフォン版サムネイル用（元iPhone版サムネイル用）作成処理でのみ使用する
     *
     * @param string:変換先イメージのファイルパス
     * @param string:変換元イメージのファイルパス
     * @param string:変換先イメージの幅
     * @param string:変換先イメージの高さ
     *
     * @return void
     * ************************************************************************ */

    private function convertImageSize($dstImageName, $srcImageName, $dstImageWidth, $dstImageHeight, $makeProcNameForLog)
    {
        if (WRITE_IMAGE_LOG) {
            $this->StopWatch->startStopWatch();
        }

        // 作成元イメージから情報の取得
        try {
            $srcImageInfo = $this->getImageInfo($srcImageName);
            $srcImageWidth = $srcImageInfo[WIDTH];
            $srcImageHeight = $srcImageInfo[HEIGHT];

            // 中間イメージの縦横を取得する
            // 中間イメージの縦横として、下記の比の方程式を満たす長さを与える
            // $srcImageWidth : $srcImageHeight = $midImageWidth : $midImageHeight
            // なお、縦横の一方は、それぞれ$dstImageWidthまたは$dstImageHeightが与えられている
            //
            // 例.縦横の一方を160とした場合、もう一方の長さを、160*(変換元イメージの縦横比)で与える
            if ($srcImageWidth > $srcImageHeight) {
                $midImageHeight = $dstImageHeight;
                $midImageWidth = $srcImageWidth / $srcImageHeight * $midImageHeight;
            } elseif ($srcImageWidth < $srcImageHeight) {
                $midImageWidth = $dstImageWidth;
                $midImageHeight = $srcImageHeight / $srcImageWidth * $midImageWidth;
            } else {
                $midImageWidth = $dstImageWidth;
                $midImageHeight = $dstImageHeight;
            }

            // 中間イメージを作成先イメージへコピーする基準となる座標を取得する
            // 上記の$midImageWidthと$midImageHeightを取得する条件より、各座標がマイナスとなることはない
            $srcX = ($midImageWidth - $dstImageWidth) / 2;
            $srcY = ($midImageHeight - $dstImageHeight) / 2;

            // 作成元イメージをメモリに取得する
            $srcImageId = ImageCreateFromJpeg($srcImageName);
            // 中間イメージのいれものをメモリに取得する
            $midImageId = ImageCreateTrueColor($midImageWidth, $midImageHeight);
            // 作成先イメージのいれものをメモリに取得する
            $dstImageId = ImageCreateTrueColor($dstImageWidth, $dstImageHeight);

            // 作成元イメージを中間イメージに、拡大または縮小してコピー
            // $src_imageの、座標($src_x,$src_y)を基準とした縦横($src_w,$src_h)の情報を、$dst_imageの座標($dst_x,$dst_y)の縦横($dst_w,$dst_h)に拡大縮小してコピー
            // bool imagecopyresampled ( resource $dst_image , resource $src_image
            //, int $dst_x , int $dst_y
            //, int $src_x , int $src_y
            //, int $dst_w , int $dst_h
            //, int $src_w , int $src_h )
            ImageCopyResampled($midImageId, $srcImageId, 0, 0, 0, 0, $midImageWidth, $midImageHeight, $srcImageWidth, $srcImageHeight);

            // 中間イメージを作成先イメージに、コピー。縦横($dstImageWidth * $dstImageHeightを越える部分についてはコピーしない)
            // $src_imの、座標($src_x,$src_y)を基準とした縦横($src_w,$src_h)の情報を、$dst_imの座標($dst_x,$dst_y)にコピー
            // bool imagecopy ( resource $dst_im , resource $src_im
            // , int $dst_x , int $dst_y
            // , int $src_x , int $src_y
            // , int $src_w , int $src_h )
            ImageCopy($dstImageId, $midImageId, 0, 0, $srcX, $srcY, $dstImageWidth, $dstImageHeight);

            // 作成先イメージを、JPEGとしてファイルに書き込み
            ImageJpeg($dstImageId, $dstImageName, QUALITY_MAX);

            // メモリの解放
            ImageDestroy($srcImageId);
            ImageDestroy($midImageId);
            ImageDestroy($dstImageId);

            if (WRITE_IMAGE_LOG) {
                $this->StopWatch->stopStopWatch($makeProcNameForLog, $dstImageName, $srcImageName, $this->getImageInfo($dstImageName), $this->getImageInfo($srcImageName));
            }
        } catch (ErrorException $ex) {
            $this->log->logMessage("02052", $dstImageName);

            // もし、makeImageByPhpThumbで作成したファイルがある場合、削除する
            if (is_file($srcImageName)) {
                unlink($srcImageName);
            }
            $this->makeNgFlgFile($dstImageName);
        }

        @chmod($dstImageName, 0777);
    }

    /*     * ************************************************************************
     * makeImageByPhpThumb Phpthumbによるイメージ作成処理
     *
     * @param string:作成先イメージのファイルパス
     * @param string:作成元イメージのファイルパス
     * @param string:作成先イメージの幅
     * @param string:作成先イメージの高さ
     * @param string:作成先イメージのフォーマット
     * @param bool  :作成先イメージのアスペクト修正についてのフラグ
     * @param string:呼び出し処理名
     *
     * @return void
     * ************************************************************************ */

    private function makeImageByPhpThumb($makeImageName, $srcImageName, $makeImageWidth, $makeImageHeight, $makeImageFormat, $makeIgnoreAspectRatio, $makeProcNameForLog = null)
    {
        if (WRITE_IMAGE_LOG && isset($makeProcNameForLog)) {
            $this->StopWatch->startStopWatch();
        }

        // NGフラグファイルがすでに存在していた場合は、それを削除する
        $this->deleteNgFlgFile($makeImageName);
        $phpThumb = new phpThumb();

        try {
            $phpThumb->setSourceFilename($srcImageName);
            $phpThumb->setParameter('w', $makeImageWidth);
            $phpThumb->setParameter('h', $makeImageHeight);
            $phpThumb->setParameter('config_output_format', $makeImageFormat);
            if (isset($makeIgnoreAspectRatio)) {
                $phpThumb->setParameter('iar', $makeIgnoreAspectRatio);
            }

            $phpThumb->GenerateThumbnail();
            $phpThumb->RenderToFile($makeImageName);

            if (WRITE_IMAGE_LOG && isset($makeProcNameForLog)) {
                $this->StopWatch->stopStopWatch($makeProcNameForLog, $makeImageName, $srcImageName, $this->getImageInfo($makeImageName), $this->getImageInfo($srcImageName));
            }
        } catch (ErrorException $ex) {
            $this->log->logMessage("02052", $makeImageName);
            $this->makeNgFlgFile($makeImageName);
            return PHPTHUMB_NG;
        }

        @chmod($makeImageName, 0777);
        return PHPTHUMB_OK;
    }

    /*     * ************************************************************************
     * deleteNgFlgFile NGフラグファイル削除処理
     *
     * @param String:作成先イメージのファイルパス
     *
     * @return void
     * ************************************************************************ */

    private function deleteNgFlgFile($makeImageName)
    {
        if (is_file($makeImageName . SUFFIX_NG_FLG)) {
            unlink($makeImageName . SUFFIX_NG_FLG);
        }
    }

    /*     * ************************************************************************
     * makeNgFlgFile NGフラグファイル作成処理
     *
     * @param String:作成先イメージのファイルパス
     *
     * @return void
     * ************************************************************************ */

    private function makeNgFlgFile($makeImageName)
    {
        touch($makeImageName . SUFFIX_NG_FLG);
    }

    /*     * ************************************************************************
     * getImageInfo イメージ情報取得処理
     *
     * サイズのみならず、イメージ情報を取得することを強調するため、メソッドとした
     *
     * @param String:イメージファイルのパス
     *
     * @return array:イメージファイルの情報
     * ************************************************************************ */

    private function getImageInfo($path)
    {
        return getimagesize($path);
    }

    /*     * ************************************************************************
     * getImageFormatForPhpthumb Phpthumb用ファイルフォーマット取得処理
     *
     * @param string:getImageInfoから得られるファイルフォーマット
     *
     * @return string:Phpthumb用ファイルフォーマット
     * ************************************************************************ */

    private function getImageFormatForPhpthumb($mime)
    {
        if ($mime == "image/jpg" || $mime == "image/jpeg" || $mime == "image/jpe") {
            $makeImageFormat = "jpg";
        } elseif ($mime == "image/png" || $mime == "image/x-png") {
            $makeImageFormat = "png";
        } elseif ($mime == "image/gif") {
            $makeImageFormat = "gif";
        }
        return $makeImageFormat;
    }

    /*     * ************************************************************************
     * thumbnailErrorHandler 本クラスでのみ用いられるエラーハンドラー
     *
     * @param int:エラーレベル
     * @param string:エラーメッセージ
     *
     * @return void
     * ************************************************************************ */

    private static function thumbnailErrorHandler($severity, $message)
    {
        if (!(error_reporting() & $severity)) {
            // このエラーコードが error_reporting に含まれていない場合
            return;
        }
        throw new ErrorException($message, 0, $severity);
    }

}
