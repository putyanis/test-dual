<?php
/**
 * @var array $arCurrentValues
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
    die();
}

if (!\Bitrix\Main\Loader::includeModule('iblock'))
{
    return;
}

use \Bitrix\Main\Localization\Loc;

Loc::loadLanguageFile(__FILE__);

$iblockTypes = CIBlockParameters::GetIBlockTypes();
$iblocks = [];
$dbIblocks = CIBlock::GetList(
    [
        'SORT' => 'ASC',
    ],
    [
        'SITE_ID' => $_REQUEST['site'],
        'TYPE'    => ($arCurrentValues['IBLOCK_TYPE'] != '-' ? $arCurrentValues['IBLOCK_TYPE'] : ''),
    ]
);

while ($dbIblock = $dbIblocks->Fetch())
{
    $iblocks[$dbIblock['ID']] = '['.$dbIblock['ID'].'] '.$dbIblock['NAME'];
}

$sortOrder = [
    'ASC'  => Loc::getMessage('SORT_ASC'),
    'DESC' => Loc::getMessage('SORT_DESC'),
];

$sortField = [
    'ID'          => Loc::getMessage('SORT_ID'),
    'NAME'        => Loc::getMessage('SORT_NAME'),
    'ACTIVE_FROM' => Loc::getMessage('SORT_ACTIVE'),
    'SORT'        => Loc::getMessage('SORT_SORT'),
    'TIMESTAMP_X' => Loc::getMessage('SORT_STAMP'),
];

$arComponentParameters = array(
    'PARAMETERS' => array(
        'IBLOCK_TYPE'    => [
            'PARENT'  => 'DATA_SOURCE',
            'NAME'    => Loc::getMessage('IBLOCK_TYPE'),
            'TYPE'    => 'LIST',
            'VALUES'  => $iblockTypes,
            'DEFAULT' => '',
            'REFRESH' => 'Y',
        ],
        'IBLOCK_ID'      => [
            'PARENT'            => 'DATA_SOURCE',
            'NAME'              => Loc::getMessage('IBLOCK_ID'),
            'TYPE'              => 'LIST',
            'VALUES'            => $iblocks,
            'DEFAULT'           => '',
            'ADDITIONAL_VALUES' => 'Y',
            'REFRESH'           => 'Y',
        ],
        'COUNT_PER_TYPE' => [
            'PARENT'            => 'DATA_SOURCE',
            'NAME'              => Loc::getMessage('COUNT_PER_TYPE'),
            'TYPE'              => 'STRING',
            'DEFAULT'           => '8',
            'ADDITIONAL_VALUES' => 'N',
        ],
        'SORT_BY_1'      => [
            'PARENT'            => 'DATA_SOURCE',
            'NAME'              => Loc::getMessage('SORT_BY_1'),
            'TYPE'              => 'LIST',
            'VALUES'            => $sortField,
            'DEFAULT'           => 'SORT',
            'ADDITIONAL_VALUES' => 'Y',
        ],
        'SORT_ORDER_1'   => [
            'PARENT'  => 'DATA_SOURCE',
            'NAME'    => Loc::getMessage('SORT_ORDER_1'),
            'TYPE'    => 'LIST',
            'VALUES'  => $sortOrder,
            'DEFAULT' => 'ASC',
        ],
        'SORT_BY_2'      => [
            'PARENT'            => 'DATA_SOURCE',
            'NAME'              => Loc::getMessage('SORT_BY_2'),
            'TYPE'              => 'LIST',
            'VALUES'            => $sortField,
            'DEFAULT'           => 'NAME',
            'ADDITIONAL_VALUES' => 'Y',
        ],
        'SORT_ORDER_2'   => [
            'PARENT'  => 'DATA_SOURCE',
            'NAME'    => Loc::getMessage('SORT_ORDER_2'),
            'TYPE'    => 'LIST',
            'VALUES'  => $sortOrder,
            'DEFAULT' => 'ASC',
        ],
        'IMAGE_SIZE'   => [
            'PARENT'  => 'DATA_SOURCE',
            'NAME'    => Loc::getMessage('IMAGE_SIZE'),
            'TYPE'    => 'LIST',
            'VALUES'  => [],
            'DEFAULT' => 'ASC',
        ],
        'CACHE_TIME'     => [
            'DEFAULT' => 36000000,
        ],
    ),
);
