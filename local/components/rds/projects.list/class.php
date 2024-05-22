<?php

namespace RDS\Component;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use CBitrixComponent;
use CIBlockElement;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
    die();
}

Loc::loadMessages(__FILE__);

class ProjectsList extends CBitrixComponent
{
    protected array $cacheId = [];
    
    protected string $cacheDir = '/projects/list/';
    
    protected array $filter;
    
    protected array $sort;
    
    protected array $nav;
    
    protected array $select;
    
    public function onPrepareComponentParams($arParams): array
    {
        $arParams['CACHE_TIME'] = $arParams['CACHE_TIME'] ?? 36000000;
        $arParams['COUNT_PER_TYPE'] = intval($arParams['COUNT_PER_TYPE']) > 0 ? $arParams['COUNT_PER_TYPE'] : 8;
        
        if (empty($arParams['IMAGE_SIZE']))
        {
            $arParams['IMAGE_SIZE'] = [
                'width'  => 307,
                'height' => 500,
            ];
        }
        
        return $arParams;
    }
    
    public function executeComponent(): void
    {
        $this->includeModules();
        
        $this->prepareFilter();
        $this->prepareSort();
        $this->prepareNav();
        $this->prepareSelect();
        
        if ($this->startCache())
        {
            $this->loadData();
            $this->endCache();
        }
        
        $this->includeComponentTemplate();
    }
    
    protected function abortCache($messID = ''): void
    {
        $this->abortResultCache();
        
        if (strlen($messID) > 0)
        {
            ShowError(Loc::getMessage($messID));
        }
    }
    
    protected function startCache(): bool
    {
        if ($this->startResultCache($this->arParams['CACHE_TIME'], $this->cacheId, $this->cacheDir))
        {
            return true;
        }
        
        return false;
    }
    
    protected function endCache(): void
    {
        $this->endResultCache();
    }
    
    protected function includeModules(): void
    {
        if (!Loader::includeModule('iblock'))
        {
            $this->abortCache('IBLOCK_MODULE_NOT_INSTALLED');
        }
    }
    
    protected function loadData(): void
    {
        if ($this->arParams['IBLOCK_ID'] == 0)
        {
            $this->abortCache('WRONG_IBLOCK_ID');
        }
        
        $this->arResult['PROJECT_TYPES'] = [];
        
        $projectTypes = \CIBlockPropertyEnum::GetList(
            [
                'SORT'  => 'ASC',
                'VALUE' => 'ASC',
            ],
            [
                'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                'CODE'      => 'PROJECT_TYPE',
            ]
        );
        
        while ($projectType = $projectTypes->GetNext())
        {
            $this->arResult['PROJECT_TYPES'][$projectType['ID']] = [
                'ID'    => $projectType['ID'],
                'VALUE' => $projectType['VALUE'],
                'ITEMS' => [],
            ];
        }
        
        $this->arResult['ITEMS'] = [];
        
        $projects = CIBlockElement::GetList(
            $this->sort,
            $this->filter,
            false,
            $this->nav,
            $this->select
        );
        
        while ($project = $projects->GetNext())
        {
            $projectTypeID = $project['PROPERTY_PROJECT_TYPE_ENUM_ID'];
            
            if (empty($project['PREVIEW_PICTURE']))
            {
                continue;
            }
            
            $project['PREVIEW_PICTURE'] = \CFile::ResizeImageGet(
                $project['PREVIEW_PICTURE'],
                $this->arParams['IMAGE_SIZE'],
                BX_RESIZE_IMAGE_EXACT,
                true
            );
            
            $this->arResult['PROJECT_TYPES'][$projectTypeID]['ITEMS'][] = $project;
        }
        
        $this->arResult['SHOW_TEMPLATE'] = array_reduce(
            $this->arResult['PROJECT_TYPES'],
            function($result, $item) {
                return $result + count($item['ITEMS']);
            },
            0
        );
        
        $allProjects = array_merge(
            ...array_column($this->arResult['PROJECT_TYPES'], 'ITEMS')
        );
        
        usort(
            $allProjects,
            function ($a, $b) {
                return $a['SORT'] = $b['SORT'];
            }
        );
        
        array_unshift(
            $this->arResult['PROJECT_TYPES'],
            [
                'ID'    => 'all',
                'VALUE' => 'All',
                'ITEMS' => array_slice(
                    $allProjects,
                    0,
                    $this->arParams['COUNT_PER_TYPE'],
                ),
            ]
        );
    }
    
    protected function prepareFilter(): void
    {
        $this->filter = [
            'IBLOCK_TYPE' => $this->arParams['IBLOCK_TYPE'],
            'IBLOCK_ID'   => $this->arParams['IBLOCK_ID'],
            'ACTIVE'      => 'Y',
        ];
    }
    
    protected function prepareSort(): void
    {
        $sortKeys = [];
        $sortValues = [];
        
        $sortKeys[] = empty($this->arParams['SORT_BY_1']) ? 'ACTIVE_FROM' : $this->arParams['SORT_BY_1'];
        $sortKeys[] = empty($this->arParams['SORT_BY_2']) ? 'SORT' : $this->arParams['SORT_BY_2'];
        
        $sortValues[] = strtoupper($this->arParams['SORT_ORDER_1']) == 'ASC' ? 'ASC' : 'DESC';
        $sortValues[] = strtoupper($this->arParams['SORT_ORDER_2']) == 'ASC' ? 'ASC' : 'DESC';
        
        $this->sort = array_combine($sortKeys, $sortValues);
    }
    
    protected function prepareNav(): void
    {
        $this->nav = [
            'nPageSize'          => $this->arParams['COUNT_PER_TYPE'],
            'bDescPageNumbering' => false,
        ];
    }
    
    protected function prepareSelect(): void
    {
        $this->select = [
            'ID',
            'IBLOCK_ID',
            'NAME',
            'SORT',
            'PREVIEW_PICTURE',
            'PROPERTY_PROJECT_TYPE',
        ];
    }
}
