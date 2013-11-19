<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * EpubBuilderのメインクラスのメインクラス
 *
 * EpubBuilderはクラス名EpubBuilderと、ネームスペース、EpubBuilderを使用します。
 *
 * PHP versions 5.3
 *
 * LICENSE: The following is a BSD 2-Clause license template.
 * To generate your own license,
 * change the values of OWNER and YEAR from their original values as given here,
 * and substitute your own.
 * Note: see also the BSD-3-Clause license.URI:
 * http://opensource.org/licenses/BSD-2-Clause
 * This prelude is not part of the license.
 *
 * @category   EpubBuilder
 * @package    EpubBuilder
 * @author     Akito<akito-artisan@five-foxes.com>
 * @copyright  2013 nyanpass.jp
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    $Id$
 * @link       https://github.com/EpubBuilder
 * @see        https://github.com/EpubBuilder/EpubBuilder/wiki
 * @since      File available since Release 1.0.0
 */


/**
 * EpubBuilderのメインクラス
 *
 * 基本的にはこのクラスをロードすれば問題なく使用できます。
 *
 *
 * サンプルコードや、マニュアルに関しては
 * https://github.com/EpubBuilder/EpubBuilder/wiki
 * を参照してください。
 *
 *
 * @category   EpubBuilder
 * @package    EpubBuilder
 * @author     Akito<akito-artisan@five-foxes.com>
 * @copyright  2013 nyanpass.jp
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/PackageName
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      Class available since Release 1.0.0
 */
class EpubBuilder
{
    /**
     * コンフィグオブジェクト
     *
     * @access      private
     * @var         \EpubBuilder\Config
     */
    private $config_obj;

    /**
     * クラスの基底ディレクトリ
     *
     * @access      private
     * @var         string
     */
    private $base_directory_path;

    /**
     * ドライバオブジェクト
     *
     * @access      private
     * @var         \EpubBuilder\Driver\Common
     */
    private $Driver;

    /**
     * factory用のDriver識別子
     *
     * \PEAR\File_Archiveを使用する
     *
     * @var         String
     */
    const DRIVER_PEAR = 'Pear';

    /**
     * factory用のDriver識別子
     *
     * zipコマンドを使用する
     *
     * @var         String
     */
    const DRIVER_EXEC = 'ExecZip';

    /**
     * factory用のDriverType識別子
     *
     * 縦書
     *
     * @var         String
     */
    const TYPE_VERTICAL = 1;

    /**
     * factory用のDriverType識別子
     *
     * 横書き
     *
     * @var         String
     */
    const TYPE_HORIZONTAL = 2;

    /**
     * factory用のDriverType識別子
     *
     * 自動でprepareしない
     *
     * @var         String
     */
    const NO_AUTO_PREPARE = 3;

    /**
     * +-- コンストラクタ
     *
     * @final
     * @access      private
     * @return      void
     */
    final private function __construct()
    {
        $this->base_directory_path = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $this->classLord();
        $this->config_obj = new \EpubBuilder\Config;
        $this->config_obj->initialize();
    }
    /* ----------------------------------------- */

    /**
     * +-- オブジェクトの作成
     *
     * @final
     * @access      public
     * @static
     * @param       string $driver OPTIONAL:self::DRIVER_EXEC
     * @param       integer $driver_type OPTIONAL:self::TYPE_HORIZONTAL
     * @return      EpubBuilder
     */
    public static function factory($driver = self::DRIVER_EXEC, $driver_type = self::TYPE_HORIZONTAL)
    {
        static $_this;
        if (!$_this) {
            $_this = new EpubBuilder;
        }
        $_this->driverSelect($driver, $driver_type);
        return $_this;
    }
    /* ----------------------------------------- */

    /**
     * +-- コンフィグオブジェクトを返す
     *
     * @access      public
     * @return      EpubBuilder\Config
     */
    public function getConfig()
    {
        return $this->config_obj;
    }
    /* ----------------------------------------- */

    /**
     * +-- 全てを開放して初期化する
     *
     * @access      public
     * @param       any $cue_name OPTIONAL:NULL
     * @return      void
     */
    public function free($cue_name = NULL)
    {
        if (!empty($this->Driver)) {
            $this->Driver->free();
        }
        $this->config_obj->setCueName($cue_name);
        $this->executer(true);
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行オブジェクトを参照する
     *
     * @access      public
     * @param       var_text $is_reset (OPTIONAL: false)
     * @return      EpubBuilder\Executer
     */
    public function executer($is_reset = false)
    {
        static $executer;
        if (!empty($executer) || $is_reset) {
            $executer->free();
        }
        if (empty($executer) || $is_reset) {
            $executer = new EpubBuilder\Executer($this->config_obj, $this->Driver);
        }
        return $executer;
    }
    /* ----------------------------------------- */

    /**
     * +-- ドライバを選択する
     *
     * @access      public
     * @param       string $driver
     * @param       integer $driver_type OPTIONAL:self::TYPE_HORIZONTAL
     * @return      \EpubBuilder\Driver\Common
     */
    public function driverSelect($driver, $driver_type = self::TYPE_HORIZONTAL)
    {
        if (!empty($this->Driver)) {
            $this->Driver->free();
        }

        $class_name = '\EpubBuilder\Driver\\'.$driver;
        if (!class_exists($class_name, false)) {
            require $this->base_directory_path.'libs'.DIRECTORY_SEPARATOR.'Driver'.DIRECTORY_SEPARATOR.$driver.'.php';
        }
        if (!class_exists($class_name, false)) {
            throw new EpubBuilderException('undefined Driver : '.$driver, EpubBuilderException::CODE_INIT);
        }
        $this->Driver = new $class_name($this->config_obj);
        if ($driver_type !== self::NO_AUTO_PREPARE) {
            $this->prepare($driver_type);
        }
        return $this->Driver;
    }
    /* ----------------------------------------- */

    /**
     * +-- Driverの初期化を行う
     *
     * @access      public
     * @param       integer $driver_type OPTIONAL:self::TYPE_HORIZONTAL
     * @return      void
     */
    public function prepare($driver_type = self::TYPE_HORIZONTAL)
    {
        $this->Driver->prepare($driver_type);
    }
    /* ----------------------------------------- */

    // +-- executer alias

    /**
     * +-- タイトルを入力する
     *
     * @final
     * @access      public
     * @param       string $novel_title
     * @param       string $novel_sub_title
     * @param       string $author
     * @param       string $composer
     * @return      void
     */
    final public function addTitleContents($novel_title, $novel_sub_title, $author, $composer)
    {
        $this->executer()->addTitleContents($novel_title, $novel_sub_title, $author, $composer);
    }
    /* ----------------------------------------- */

    /**
     * +-- テキストデータをセットする
     *
     * @final
     * @access      public
     * @param       any $title
     * @param       any $contents
     * @param       any $page_id
     * @param       any $order OPTIONAL:false
     * @return      void
     */
    final public function addTextContents($title, $contents, $page_id, $order = false)
    {
        $this->executer()->addTextContents($title, $contents, $page_id, $order);
    }
    /* ----------------------------------------- */

    /**
     * +-- 本を作成する
     *
     * @final
     * @access      public
     * @param       string $book_id
     * @param       string $epub_file_name 保存するファイル名
     * @return      string 作成された本のパス
     */
    final public function create($book_id, $epub_file_name = false)
    {
        return $this->executer()->create($book_id, $epub_file_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- サンプルの作成
     *
     * @final
     * @access      public
     * @return      string 作成された本のパス
     */
    final public function createSample()
    {
        return $this->executer()->createSample();
    }
    /* ----------------------------------------- */

    /* ----------------------------------------- */

    // +-- private methods
    /**
     * +-- クラスのロード
     *
     * @final
     * @access      private
     * @return      void
     */
    final private function classLord()
    {
        require $this->base_directory_path.'libs'.DIRECTORY_SEPARATOR.'Config.php';
        require $this->base_directory_path.'libs'.DIRECTORY_SEPARATOR.'Executer.php';
        require $this->base_directory_path.'libs'.DIRECTORY_SEPARATOR.'Renderer.php';
        require $this->base_directory_path.'libs'.DIRECTORY_SEPARATOR.'Driver'.DIRECTORY_SEPARATOR.'Common.php';
    }
    /* ----------------------------------------- */


    /**
     * +-- Singleton化
     *
     * @final
     * @access      private
     * @return      void
     */
    final private function __clone()
    {
        throw new Exception('singleton error', EpubBuilderException::CODE_SYSTEM);
    }
    /* ----------------------------------------- */
    /* ----------------------------------------- */
}

/**
 * +-- オブジェクト作成用の関数
 *
 * @param       any $driver OPTIONAL:EpubBuilder::DRIVER_EXEC
 * @param       any $driver_type OPTIONAL:EpubBuilder::TYPE_HORIZONTAL|EpubBuilder::factory $driver
 * @return      EpubBuilder
 */
function EpubBuilder($driver = EpubBuilder::DRIVER_EXEC, $driver_type = EpubBuilder::TYPE_HORIZONTAL)
{
    return EpubBuilder::factory($driver, $driver_type);
}
/* ----------------------------------------- */


/**
 * EpubBuilderの例外クラス
 *
 * PHP標準のexceptionを継承して作られています。
 *
 *
 * @category   EpubBuilder
 * @package    EpubBuilder
 * @author     Akito<akito-artisan@five-foxes.com>
 * @copyright  2013 nyanpass.jp
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/PackageName
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      Class available since Release 1.0.0
 */
class EpubBuilderException extends exception
{
    /**
     * ドライバから発行されるエラー
     *
     * @var         any
     */
    const CODE_DRIVER = 2000;


    /**
     * ドライバから発行されるエラー
     *
     * @var         any
     */
    const CODE_ECECUTER = 2001;

    /**
     * 初期化時に発行されるエラー
     *
     * @var         any
     */
    const CODE_INIT   = 5000;

    /**
     * システム規定に関するエラー
     *
     * @var         any
     */
    const CODE_SYSTEM   = 5001;
}
