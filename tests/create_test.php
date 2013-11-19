<?php


require '../EpubBuilder.php';

$EpubBuilder = EpubBuilder(EpubBuilder::DRIVER_EXEC, EpubBuilder::NO_AUTO_PREPARE);
$EpubBuilder->getConfig()->working_directory_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'work'.DIRECTORY_SEPARATOR;
$EpubBuilder->prepare(EpubBuilder::TYPE_HORIZONTAL);
// addTextContentsをコールする前にaddTitleContentsでタイトルを付ける必要があります。
$EpubBuilder->addTitleContents('テストブック', '第一版', 'Akito', 'nyanpass.jp');
// テキストコンテナにコンテンツを入れます
$EpubBuilder->addTextContents('ここはタイトルです。', 'ここは本文です', 1);
$EpubBuilder->addTextContents('ここはタイトルです。2', 'ここは本文です2', 2);

// book_idを指定して保存します。book_idは本毎のユニークIDです
$EpubBuilder->create('sample_book');

// ゴミの削除
$EpubBuilder->free();


