<?php
/**
 * @global CMain $APPLICATION
 */

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
    "rds:projects.list",
    "",
    Array(
        "CACHE_FILTER" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "COUNT_PER_TYPE" => "8",
        "IBLOCK_ID" => "1",
        "IBLOCK_TYPE" => "content",
        "SORT_BY_1" => "SORT",
        "SORT_BY_2" => "NAME",
        "SORT_ORDER_1" => "ASC",
        "SORT_ORDER_2" => "ASC",
        "IMAGE_SIZE" => [
            'width' => 307,
            'height' => 500,
        ],
    )
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
