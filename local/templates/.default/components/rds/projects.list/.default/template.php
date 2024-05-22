<?php
/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arResult
 * @var array $arParams
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
    die();
}

if (!$arResult['SHOW_TEMPLATE'])
{
    return;
}

?>
<section class="section inner">
    <div class="title-wrapper title-wrapper_projects">
        <div class="title">
            <div class="subtitle subtitle_projects">Our project</div>
            Our latest projects
        </div>
        <nav class="project-types js-project-types">
        <?php
        $firstActive = true;
        foreach ($arResult['PROJECT_TYPES'] as $projectType)
        {
            $activeClass = $firstActive ? 'active' : '';
            $firstActive = false;
            ?>
            <button class="project-type <?=$activeClass?>" data-type="<?=$projectType['ID']?>"><?=$projectType['VALUE']?></button>
            <?php
        }
        ?>
        </nav>
    </div>
    
    <?php
    $firstActive = true;
    foreach ($arResult['PROJECT_TYPES'] as $projectType)
    {
        $hidden = !$firstActive ? 'hidden' : '';
        $firstActive = false;
        ?>
        <div class="projects js-projects" data-type="<?=$projectType['ID']?>" <?=$hidden?>>
            <?php
            foreach ($projectType['ITEMS'] as $key => $project)
            {
                $classes = [];
                
                if (($key + 1) % 2 === 0)
                {
                    $classes[] = 'project_translated';
                }
                
                if (($key + 1) % 3 === 0 || ($key + 1) % 4 === 0)
                {
                    $classes[] = 'project_mobile-translated';
                }
                ?>
                <picture class="project <?=implode(' ', $classes)?>">
                    <img src="<?=$project['PREVIEW_PICTURE']['src']?>" class="project__img" alt="<?=$project['NAME']?>" width="<?=$project['PREVIEW_PICTURE']['width']?>" height="<?=$project['PREVIEW_PICTURE']['height']?>" />
                </picture>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        new ProjectsController({
            projectTypesSelector: ".js-project-types",
            projectsSelector: ".js-projects",
        });
    });
</script>
