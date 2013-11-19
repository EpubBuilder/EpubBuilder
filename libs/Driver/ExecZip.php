<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * EpubBuilderのDriverクラス
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

namespace EpubBuilder\Driver;

/**
 * EpubBuilderのDriverクラス
 *
 * zipコマンドを使用するDriverです
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
class ExecZip extends Common
{

    protected function libCheck()
    {
    }

    public function setContents($contents, $file_name)
    {
        $work_dir = $this->config_obj->working_directory_path.$this->config_obj->cue_name.DIRECTORY_SEPARATOR;
        file_put_contents($work_dir.'OEBPS'.DIRECTORY_SEPARATOR.$file_name, $contents);
    }
    
    public function free()
    {
        $work_dir = $this->config_obj->working_directory_path.$this->config_obj->cue_name.DIRECTORY_SEPARATOR;
        if (is_dir($work_dir.'OEBPS')) {
            $this->rmdirf($work_dir);
        }
    }
    
    protected function rmdirf($dir_name)
    {
        if (!is_dir($dir_name)) {
            return;
        }
        $dir_name = realpath($dir_name);
        if (is_dir($dir_name)) {
            if ($dh = opendir($dir_name)) {
                while (($file = readdir($dh)) !== false) {
                    if (strpos($file, '.') !== 0) {
                        if (is_file($dir_name.DIRECTORY_SEPARATOR.$file)) {
                            unlink($dir_name.DIRECTORY_SEPARATOR.$file);
                        } elseif (is_dir($dir_name.DIRECTORY_SEPARATOR.$file)) {
                            $this->rmdirf($dir_name.DIRECTORY_SEPARATOR.$file);
                        }
                    }
                }
                closedir($dh);
            }
        }
        rmdir($dir_name);
    }
    
    public function prepare($style = \EpubBuilder::TYPE_HORIZONTAL)
    {
        $work_dir = $this->config_obj->working_directory_path.$this->config_obj->cue_name.DIRECTORY_SEPARATOR;
        if (is_dir($work_dir)) {
            throw new EpubBuilderException('Cannot Create Work Dir : '.$work_dir, EpubBuilderException::CODE_DRIVER);
        }
        mkdir($work_dir);
        if (!is_dir($work_dir)) {
            throw new EpubBuilderException('Cannot Create Work Dir : '.$work_dir, EpubBuilderException::CODE_DRIVER);
        }

        // サブディレクトリの作成
        mkdir($work_dir.'OEBPS');
        mkdir($work_dir.'META-INF');

        // Cssのセット
        if (\EpubBuilder::TYPE_HORIZONTAL === $style) {
            copy($this->config_obj->meta_data_path.'style'.DIRECTORY_SEPARATOR.'horizontal_css.css', $work_dir.'OEBPS'.DIRECTORY_SEPARATOR.'stylesheet.css');
        } elseif (\EpubBuilder::TYPE_VERTICAL === $style) {
            copy($this->config_obj->meta_data_path.'style'.DIRECTORY_SEPARATOR.'vertical_css.css', $work_dir.'OEBPS'.DIRECTORY_SEPARATOR.'stylesheet.css');
        }

        // デフォルトのファイルを作成する
        copy($this->config_obj->meta_data_path.'META-INF'.DIRECTORY_SEPARATOR.'container.xml', $work_dir.'META-INF'.DIRECTORY_SEPARATOR.'container.xml');
        copy($this->config_obj->meta_data_path.'mimetype', $work_dir.'mimetype');
    }

    public function createSample()
    {
        $work_dir = $this->config_obj->sample_data_path;
        $epub_name = $this->config_obj->working_directory_path.'sample.epub';
        is_file($epub_name) && unlink($epub_name);
        $base = getcwd();
        chdir($work_dir);
        $cmd = "zip -0 -X {$epub_name} mimetype";
        `$cmd`;
        $cmd = "zip -r  {$epub_name} * -x mimetype";
        `$cmd`;
        chdir($base);
        return $epub_name;
    }

    public function create($epub_file_name)
    {
        $work_dir = $this->config_obj->working_directory_path.$this->config_obj->cue_name.DIRECTORY_SEPARATOR;
        
        if (!$epub_file_name) {
            $epub_file_name = $this->config_obj->cue_name.'.epub';
        }
        $epub_name = $this->config_obj->working_directory_path.$epub_file_name;
        is_file($epub_name) && unlink($epub_name);
        $base = getcwd();
        chdir($work_dir);
        $cmd = "zip -0 -X {$epub_name} mimetype";
        `$cmd`;
        $cmd = "zip -r  {$epub_name} * -x mimetype";
        `$cmd`;
        chdir($base);
        return $epub_name;
    }
}
