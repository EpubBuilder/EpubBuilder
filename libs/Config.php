<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * EpubBuilderの設定クラス
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

namespace EpubBuilder;

/**
 * EpubBuilderの設定クラス
 *
 * EpubBuilderの設定を記載するクラスです。基本的には自動取得となっています。
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
class Config
{


    /**
     * 作業ディレクトリ
     *
     * @access      public
     * @var         string
     */
    public $working_directory_path;


    /**
     * メタデータが入っているディレクトリ
     *
     * @access      public
     * @var         string
     */
    public $meta_data_path;

    /**
     * サンプルデータのパス
     *
     * @access      public
     * @var         string
     */
    public $sample_data_path;

    /**
     * ユニークなキューID
     *
     * @access      public
     * @var         string
     */
    public $cue_name;


    /**
     * 規定ディレクトリ(コンストラクタで自動定義されます。)
     *
     * @access      public
     * @var         any
     */
    public $base_directory_path;

    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @return      void
     */
    public function __construct()
    {
        $this->base_directory_path = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
    }
    /* ----------------------------------------- */
    
    /**
     * +-- 初期化
     *
     * @access      public
     * @return      void
     */
    public function initialize()
    {
        if (empty($this->working_directory_path) || is_dir($this->working_directory_path)) {
            $this->working_directory_path = $this->base_directory_path.'tmp'.DIRECTORY_SEPARATOR;
        }
        if (empty($this->meta_data_path) || is_dir($this->meta_data_path)) {
            $this->meta_data_path = $this->base_directory_path.'MetaDatas'.DIRECTORY_SEPARATOR;
        }
        
        if (empty($this->sample_data_path) || is_dir($this->sample_data_path)) {
            $this->sample_data_path = $this->base_directory_path.'Sample'.DIRECTORY_SEPARATOR;
        }
        
        if (empty($this->cue_name)) {
            $this->cue_name = microtime(true).'-'.mt_rand(0,100000);
        }
    }
    /* ----------------------------------------- */
    
    /**
     * +-- 新規キューの名前をセットする
     *
     * @access      public
     * @param       string $cue_name OPTIONAL:NULL
     * @return      void
     */
    public function setCueName($cue_name = NULL)
    {
        if (!($this->cue_name = $cue_name)) {
            $this->cue_name = microtime(true).'-'.mt_rand(0,100000);
        }
    }
    /* ----------------------------------------- */
}
