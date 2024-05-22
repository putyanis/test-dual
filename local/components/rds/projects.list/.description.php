<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
    die();
}

\Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);

$arComponentDescription = [
    'NAME'        => Loc::getMessage('COMPONENT_NAME'),
    'DESCRIPTION' => Loc::getMessage('COMPONENT_DESC'),
    'SORT'        => 20,
    'CACHE_PATH'  => 'Y',
    'PATH'        => [
        'ID'    => 'RDS',
        'CHILD' => [
            'ID'    => 'actions',
            'NAME'  => Loc::getMessage('GROUP_NAME'),
            'SORT'  => 10,
        ],
    ],
];
