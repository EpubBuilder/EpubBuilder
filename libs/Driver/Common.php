<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * EpubBuilder��Driver�N���X
 *
 * EpubBuilder�̓N���X��EpubBuilder�ƁA�l�[���X�y�[�X�AEpubBuilder���g�p���܂��B
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
 * EpubBuilder��Driver�N���X�i���ʁj
 *
 * �e�h���C�o�[�Ōp������N���X�ł�
 *
 *
 * �T���v���R�[�h��A�}�j���A���Ɋւ��Ă�
 * https://github.com/EpubBuilder/EpubBuilder/wiki
 * ���Q�Ƃ��Ă��������B
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
abstract class Common
{
    protected $config_obj;
    protected $epub_file_name;
    public function __construct(\EpubBuilder\Config $config)
    {
        $this->libCheck();
        $this->config_obj = $config;
    }

    abstract protected function libCheck();

    public function setEpubFileName($setter)
    {
        if (!is_string($setter)) {
            throw new EpubBuilderException('Please Cast to string. epub_file_name');
        }
        $this->epub_file_name = $setter;
    }

    abstract public function prepare();
    abstract public function create($epub_file_name);
    abstract public function setContents($contents, $file_name);
    abstract public function createSample();
    abstract public function free();
}
