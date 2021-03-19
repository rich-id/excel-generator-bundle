<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Data\Annotation;

/**
 * Class ColumnDimension
 *
 * @package   RichId\ExcelGeneratorBundle\Data\Annotation
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class ColumnDimension
{
    /** @var int */
    public $dimension;

    /** @var bool */
    public $autoResize = false;
}
