<?php

namespace RDS;

class Asset
{
    public static function insertJS(array $paths): void
    {
        foreach ($paths as $path)
        {
            $timestamp = filemtime($_SERVER['DOCUMENT_ROOT'].$path);
            echo '<script src="'.$path.'?'.$timestamp.'"></script>';
        }
    }
    
    public static function insertCss(array $paths): void
    {
        foreach ($paths as $path)
        {
            $timestamp = filemtime($_SERVER['DOCUMENT_ROOT'].$path);
            echo '<link rel="stylesheet" href="'.$path.'?'.$timestamp.'">';
        }
    }
}
