<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Block;

class DefaultBlockType extends BlockType
{
    public static $category = 'default';
    public static $id       = 'default';
    public static $icon     = 'subject';
    public static $static   = true;

    public static function render(Block $block)
    {
        return '';
    }
}
