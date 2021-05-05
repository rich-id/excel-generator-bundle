<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Annotation;

/**
 * Class HeaderTitle
 *
 * @package   RichId\ExcelGeneratorBundle\Annotation
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class HeaderTitle extends Style
{
    /** @var string */
    public $title;

    /** @var string */
    public $translationKey;

    /** @var int */
    public $columnMerge;
}
