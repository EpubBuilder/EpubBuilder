<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * EpubBuilderの処理クラス
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
 * EpubBuilderの処理クラス
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
class Executer
{
    protected $book_meta_data;
    protected $page_header    = array();
    protected $page_contents  = array();
    protected $page_id_list = array();

    protected $config_obj;
    protected $driver;
    protected $renderer;


    protected $novel_title, $novel_sub_title, $author, $composer;
    protected $is_set_title = false;
    
    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       \EpubBuilder\Config $config
     * @param       \EpubBuilder\Driver\Common $driver
     * @return      void
     */
    public function __construct(\EpubBuilder\Config $config, \EpubBuilder\Driver\Common $driver)
    {
        $this->config_obj = $config;
        $this->driver = $driver;
        $this->renderer = new Renderer($this->config_obj);
    }
    /* ----------------------------------------- */
    
    /**
     * +-- タイトルを入力する
     *
     * @access      public
     * @param       string $novel_title
     * @param       string $novel_sub_title
     * @param       string $author
     * @param       string $composer
     * @return      void
     */
    public function addTitleContents($novel_title, $novel_sub_title, $author, $composer)
    {
        $this->novel_title = $novel_title;
        $this->novel_sub_title = $novel_sub_title;
        $this->author = $author;
        $this->composer = $composer;
        $this->is_set_title = true;
        $this->renderer->setAttribute('novel_title', $novel_title);
        $this->renderer->setAttribute('novel_sub_title', $novel_sub_title);
        $this->renderer->setAttribute('author', $author);
        $this->renderer->setAttribute('composer', $composer);
        $contents = $this->renderer->displayRef('title_page.tpl');
        $this->driver->setContents($contents, 'title_page.xhtml');


        $this->page_id_list[0] = 'title_page';
        $this->page_header[0] = array(
            'page_title' => 'タイトルページ',
            'page_order' => 0,
            'page_id'    => 'title_page',
            'page_path'  => 'title_page'.'.xhtml',
        );
    }
    /* ----------------------------------------- */
    
    /**
     * +-- テキストデータをセットする
     *
     * @access      public
     * @param       any $title
     * @param       any $contents
     * @param       any $page_id
     * @param       any $order OPTIONAL:false
     * @return      void
     */
    public function addTextContents($title, $contents, $page_id, $order = false)
    {
        if (!$this->is_set_title) {
            throw new EpubBuilderException('タイトルは先に入力してください。', EpubBuilderException::CODE_ECECUTER);
        }
        $tmp = array_search($page_id, $this->page_id_list);
        if ($tmp !== false) {
            $order = $tmp;
        }
        if ($order === false) {
            $order = count($this->page_id_list);
        }
        $this->page_id_list[$order] = $page_id;
        $this->page_header[$order] = array(
            'page_title' => $title,
            'page_order' => $order,
            'page_id'    => $page_id,
            'page_path'  => $page_id.'.xhtml',
        );
        $this->renderer->setAttribute('title', $title);
        $this->renderer->setAttribute('contents', $contents);
        $this->renderer->setAttribute('page_id', $page_id);
        $this->renderer->setAttribute('order', $order);
        $contents = $this->renderer->displayRef('chapter.tpl');
        $this->driver->setContents($contents, $page_id.'.xhtml');
    }
    /* ----------------------------------------- */

    /**
     * +-- 本を作成する
     *
     * @access      public
     * @param       string $book_id
     * @param       string $epub_file_name 保存するファイル名
     * @return      string 作成された本のパス
     */
    public function create($book_id, $epub_file_name = false)
    {
        $this->renderer->setAttribute('book_id', $book_id);
        $this->renderer->setAttribute('novel_title', $this->novel_title);
        $this->renderer->setAttribute('novel_sub_title', $this->novel_sub_title);
        $this->renderer->setAttribute('author', strip_tags($this->author));
        $this->renderer->setAttribute('composer', strip_tags($this->composer));
        $this->renderer->setAttribute('page_header', $this->page_header);
        $contents = $this->renderer->displayRef('navdoc.tpl');
        $this->driver->setContents($contents, 'navdoc.html');
        $contents = $this->renderer->displayRef('content.opf.tpl');
        $this->driver->setContents($contents, 'content.opf');
        $contents = $this->renderer->displayRef('toc.ncx.tpl');
        $this->driver->setContents($contents, 'toc.ncx');
        return $this->driver->create($epub_file_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- サンプルの作成
     *
     * @access      public
     * @return      string 作成された本のパス
     */
    public function createSample()
    {
        return $this->driver->createSample();
    }
    /* ----------------------------------------- */
    
    /**
     * +-- 開放
     *
     * @access      public
     * @return      void
     */
    public function free()
    {
        unset($this->renderer);
        $this->renderer = new Renderer($this->config_obj);
    }
    /* ----------------------------------------- */
}
