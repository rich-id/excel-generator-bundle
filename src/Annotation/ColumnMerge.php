<?php

declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Annotation;

/**
 * Class ColumnMerge.
 *
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
