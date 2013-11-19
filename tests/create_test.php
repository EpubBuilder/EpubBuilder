<?php


require '../EpubBuilder.php';

$EpubBuilder = EpubBuilder(EpubBuilder::DRIVER_EXEC, EpubBuilder::NO_AUTO_PREPARE);
$EpubBuilder->getConfig()->working_directory_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'work'.DIRECTORY_SEPARATOR;
$EpubBuilder->prepare(EpubBuilder::TYPE_HORIZONTAL);
// addTextContents���R�[������O��addTitleContents�Ń^�C�g����t����K�v������܂��B
$EpubBuilder->addTitleContents('�e�X�g�u�b�N', '����', 'Akito', 'nyanpass.jp');
// �e�L�X�g�R���e�i�ɃR���e���c�����܂�
$EpubBuilder->addTextContents('�����̓^�C�g���ł��B', '�����͖{���ł�', 1);
$EpubBuilder->addTextContents('�����̓^�C�g���ł��B2', '�����͖{���ł�2', 2);

// book_id���w�肵�ĕۑ����܂��Bbook_id�͖{���̃��j�[�NID�ł�
$EpubBuilder->create('sample_book');

// �S�~�̍폜
$EpubBuilder->free();


