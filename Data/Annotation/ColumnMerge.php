<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Data\Annotation;

/**
 * Class ColumnMerge
 *
 * @package   RichId\ExcelGeneratorBundle\Data\Annotation
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class ColumnMerge
{
    /** @var int */
    public $count;
}
