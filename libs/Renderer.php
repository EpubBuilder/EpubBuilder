<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * EpubBuilderのレンダリングクラス
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
 * EpubBuilderのレンダリングクラス
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
class Renderer
{
    /**
     * コンパイルディレクトリ
     *
     * @access      public
     * @var         any
     */
    public $_compile_id;
    
    /**
     * Smartyオブジェクト
     *
     * @access      public
     * @var         Smarty
     */
    public $Smarty;
    
    /**
     * コンフィグオブジェクト
     *
     * @access      private
     * @var         \EpubBuilder\Config
     */
    private $config_obj;

    
    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       \EpubBuilder\Config $config
     * @return      void
     */
    public function __construct(\EpubBuilder\Config $config)
    {
        $this->config_obj = $config;
        $this->_compile_id  = 'EpubBuilder';
        $this->setting();
    }
    /* ----------------------------------------- */

    /**
     * +-- Smartyの設定
     *
     * @access      public
     * @return      void
     */
    public function setting()
    {
        if (!class_exists('\Smarty', false)) {
            ini_set('include_path', ini_get('include_path') . (DIRECTORY_SEPARATOR === '/' ? ':' : ';') . realpath($this->config_obj->base_directory_path.'.'.DIRECTORY_SEPARATOR.'Smarty'));
            require 'ArtisanSmarty.class.php';
        }
        $this->Smarty = new \Smarty;
        $this->Smarty->compile_dir  = $this->config_obj->base_directory_path.'template.c';
        $this->Smarty->etc_dir      = $this->config_obj->base_directory_path.'template.c';
        $this->Smarty->config_dir   = $this->config_obj->meta_data_path.DIRECTORY_SEPARATOR.'template';
        $this->Smarty->template_dir = $this->config_obj->meta_data_path.DIRECTORY_SEPARATOR.'template';
        $this->Smarty->default_modifiers = array('escape');
    }
    /* ----------------------------------------- */

    /**
     * +--templateに値を格納する
     *
     * @param string $key 格納する名前
     * @param mixed $value 値
     * @return void
     */
    public function setAttribute($name, $value)
    {
        $this->Smarty->assign($name, $value);
    }
    /* ----------------------------------------- */

    /**
     * +-- alias Smarty::display
     *
     * @access      public
     * @param       string $file_name
     * @param       string $cache_id OPTIONAL:NULL
     * @param       any $dummy2 OPTIONAL:NULL
     * @return      boolean
     */
    public function display($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        $this->Smarty->display($file_name, $cache_id, $this->_compile_id);
    }
    /* ----------------------------------------- */
    
    /**
     * +-- alias Smarty::is_cached
     *
     * @access      public
     * @param       string $file_name
     * @param       string $cache_id OPTIONAL:NULL
     * @param       any $dummy2 OPTIONAL:NULL
     * @return      boolean
     */
    public function is_cached($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        return $this->Smarty->is_cached($file_name, $cache_id, $this->_compile_id);
    }
    /* ----------------------------------------- */
    
    /**
     * +-- alias Smarty::clear_cache
     *
     * @access      public
     * @param       string $file_name
     * @param       string $cache_id OPTIONAL:NULL
     * @param       any $dummy2 OPTIONAL:NULL
     * @return      boolean
     */
    public function clear_cache($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        return $this->Smarty->clear_cache($file_name, $cache_id, $this->_compile_id);
    }
    /* ----------------------------------------- */
    
    /**
     * +-- alias Smarty::fetch
     *
     * @access      public
     * @param       string $file_name
     * @param       string $cache_id OPTIONAL:NULL
     * @param       any $dummy2 OPTIONAL:NULL
     * @return      string
     */
    public function displayRef($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        return $this->Smarty->fetch($file_name, $cache_id, $this->_compile_id);
    }
    /* ----------------------------------------- */
}
