<?php


require '../EpubBuilder.php';

$EpubBuilder = EpubBuilder();
$EpubBuilder->getConfig()->working_directory_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'work'.DIRECTORY_SEPARATOR;
$EpubBuilder->createSample();


