<?php

/* 
 * 環境定義用設定ファイル
 */

/*
 *  動作サーバの環境を定義する。
 *    production : 本番サーバ環境
 *    staging    : 検証サーバ環境
 *    development: 開発サーバ環境
 *    local-dev  : 開発者端末
 *    ※指定外の設定を行うとアプリケーションが異常終了する。
 */
$_SERVER['NOPT_ENVIRONMENT'] = 'local-dev';

/*
 *  動作するISPモードを指定する。
 *    tcom : My@Tcom
 *    tcom  : PocketTNC
 *    ※指定外の設定を行うとアプリケーションが異常終了する。
 */
$_SERVER['NOPT_ISP'] = 'tcom';
