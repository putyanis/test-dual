<?php
/**
 * @global CMain $APPLICATION
 */

?>
<!doctype html>
<html lang="ru">
<head>
    <title><?php $APPLICATION->ShowTitle() ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <?php
    $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        array(
            "AREA_FILE_SHOW"   => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "EDIT_TEMPLATE"    => "",
            "PATH"             => "/assets/bx-head.php",
        )
    );
    
    $APPLICATION->ShowHead();
    ?>
</head>
<body>
<main class="main">
